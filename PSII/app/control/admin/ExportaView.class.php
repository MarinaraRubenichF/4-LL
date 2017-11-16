<?php
/**
 * SystemAccessLogList Listing
 * @author  <your name here>
 */
class ExportaView extends TStandardList
{
    protected $form;      // search form
    protected $datagrid;  // listing
    protected $pageNavigation;
    protected $loaded;
    
    /**
     * Class constructor
     * Creates the page, the search form and the listing
     */
    public function __construct()
    {
        parent::__construct();

        parent::setDatabase('webrural');            // defines the database
        parent::setActiveRecord('Medida');   // defines the active record
        parent::setDefaultOrder('med_exp_id', 'asc');         // defines the default order
        parent::addFilterField('med_exp_id', '=', 'med_exp_id'); // filterField, operator, formField
        
        // creates the form
        $this->form = new TQuickForm('form_search_experimentos');
        $this->form->setFormTitle('Exportar Experimentos');
        $this->form->class = 'tform';
        
        // create the form fields
        $id_experimento   = new TEntry('med_exp_id');
        //$nome_experimento = new TEntry('experimento->exp_nome');

        if(TSession::getValue('userid') != 1){
            $criteria = new TCriteria();
            $criteria->add(new TFilter('med_exp_id','in','(SELECT exp_id from experimentos where exp_usr_id = ' . TSession::getValue('userid') . ')'));
            parent::setCriteria($criteria);
        }
        
        $this->form->addQuickField( 'Id', $id_experimento, '50%' );
        //$this->form->addQuickField( 'Nome', $nome_experimento, '50%' );
        
        $id_experimento->setValue(TSession::getValue('experimento_id'));
        
        $this->form->addQuickAction( 'Buscar', new TAction(array($this, 'onSearch')), 'fa:search blue' );
        $this->form->addQuickAction( 'Exportar CSV',  new TAction(array($this, 'onExportCSV')), 'fa:file-excel-o blue' );
        //$this->form->addQuickAction( 'New',  new TAction(array('CustomerFormView', 'onEdit')), 'fa:plus green' );
        
        // creates a DataGrid
        $this->datagrid = new TQuickGrid;
        //$this->datagrid->enablePopover('Popover', 'Hi <b>{name}</b>, <br> that lives at <b>{city->name} - {city->state->name}</b>');
        
        // creates the datagrid columns
        $this->datagrid->addQuickColumn('Id', 'med_exp_id', 'center', '10%', new TAction(array($this, 'onReload')), array('order', 'med_exp_id'));
        $this->datagrid->addQuickColumn('Nome', 'experimento->exp_nome', 'left', '30%');
        
        // creates two datagrid actions
        //$this->datagrid->addQuickAction('Edit', new TDataGridAction(array('CustomerFormView', 'onEdit')), 'id', 'fa:edit blue');
        //$this->datagrid->addQuickAction('Delete', new TDataGridAction(array($this, 'onDelete')), 'id', 'fa:trash red');
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());
        
        // creates the page structure using a vertical box
        $vbox = new TVBox;
        $vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $vbox->add($this->form);
        $vbox->add($this->datagrid);
        $vbox->add($this->pageNavigation);
        
        // add the box inside the page
        parent::add($vbox);
    }

    /**
     * method onSearch()
     * Register the filter in the session when the user performs a search
     */
    function onSearch()
    {
        // get the search form data
        $data = $this->form->getData();
        
        // check if the user has filled the form
        if (isset($data->med_exp_id) AND ($data->med_exp_id))
        {
            // creates a filter using what the user has typed
            $filter = new TFilter('med_exp_id', '=', "{$data->med_exp_id}%");
            
            // stores the filter in the session
            TSession::setValue('filtro1', $filter);
            TSession::setValue('experimento_id',   $data->med_exp_id);
            
        }
        else
        {
            TSession::setValue('filtro1', NULL);
            TSession::setValue('experimento_id',   '');
        }
        
        // fill the form with data again
        $this->form->setData($data);
        
        $param=array();
        $param['offset']    =0;
        $param['first_page']=1;
        $this->onReload($param);
    }
    
    /**
     * method onReload()
     * Load the datagrid with the database objects
     */
    function onReload($parametro = NULL)
    {
        try
        {
            // open a transaction with database 'samples'
            TTransaction::open('webrural');
            
            // creates a repository for Customer
            $repository = new TRepository('Medida');
            $limit = 10;
            
            // creates a criteria
            $criteria = new TCriteria;
            
            $newparametro = $parametro; // define new parameters
            if (isset($newparametro['order']) AND $newparametro['order'] == 'med_exp_id')
            {
                $newparametro['order'] = 'med_exp_id';
            }
            
            // default order
            if (empty($newparametro['order']))
            {
                $newparametro['order'] = 'med_exp_id';
                $newparametro['direction'] = 'asc';
            }
            
            $criteria->setProperties($newparametro); // order, offset
            $criteria->setProperty('limit', $limit);
            
            if (TSession::getValue('filtro1'))
            {
                // add the filter stored in the session to the criteria
                $criteria->add(TSession::getValue('filtro1'));
            }
            
            // load the objects according to criteria
            $experimentos = $repository->load($criteria, FALSE);
            $this->datagrid->clear();
            if ($experimentos)
            {
                foreach ($experimentos as $experimento)
                {
                    // add the object inside the datagrid
                    $this->datagrid->addItem($experimento);
                }
            }
            
            // reset the criteria for record count
            $criteria->resetProperties();
            $count= $repository->count($criteria);
            
            $this->pageNavigation->setCount($count); // count of records
            $this->pageNavigation->setProperties($parametro); // order, page
            $this->pageNavigation->setLimit($limit); // limit
            
            // total row
            $row  = $this->datagrid->addRow();
            $row->style = 'height: 30px; background: whitesmoke';
            $cell = $row->addCell( $count . ' registros' );
            $cell->colspan = 6;
            $cell->style = 'text-align:center';
            
            // close the transaction
            TTransaction::close();
            $this->loaded = true;
        }
        catch (Exception $e) // in case of exception
        {
            // shows the exception error message
            new TMessage('error', $e->getMessage());
            
            // undo all pending operations
            TTransaction::rollback();
        }
    }

    /**
     * Export to CSV
     */
    function onExportCSV()
    {
        $this->onSearch();

        try
        {
            // open a transaction with database 'samples'
            TTransaction::open('webrural');
            
            // creates a repository for Customer
            $repository = new TRepository('Medida');

            // creates a criteria
            $criteria = new TCriteria;   

            if (TSession::getValue('filtro1'))
            {
                // add the filter stored in the session to the criteria
                $criteria->add(TSession::getValue('filtro1'));
                $criteria->setProperty('order', 'med_blc_id, med_par_id, med_plt_id, med_data');
                $criteria->setProperties('direction','ASC');
            }

            if(TSession::getValue('userid') != 1){
                $criteria->add(new TFilter('med_exp_id','in','(SELECT exp_id from experimentos where exp_usr_id = ' . TSession::getValue('userid') . ')'));
            }

            $csv = '';
            // load the objects according to criteria
            $meusExperimentos = $repository->load($criteria);
            if ($meusExperimentos)
            {
                $csv .= 'Experimento'.';'.'Bloco'.';'.'Parcela'.';'.'Planta'.';'.'Data'.';'.'Fenologia'."\n"; 
                foreach ($meusExperimentos as $meuExperimento)
                {
                    //$meuExperimento->med_data->setMask('dd/mm/yyyy');

                    $csv .= $meuExperimento->experimento->exp_nome.';'.
                            $meuExperimento->bloco->blc_nome.';'.
                            $meuExperimento->parcela->par_nome.';'.
                            $meuExperimento->planta->plt_nome.';'.
                            $meuExperimento->med_data.';'.
                            $meuExperimento->fenologia->fen_fenologia."\n";
                }
                file_put_contents('app/output/meusExperimentos.csv', $csv);
                TPage::openFile('app/output/meusExperimentos.csv');
            }
            // close the transaction
            TTransaction::close();
        }
        catch (Exception $e) // in case of exception
        {
            // shows the exception error message
            new TMessage('error', $e->getMessage());
            
            // undo all pending operations
            TTransaction::rollback();
        }

    }
}
