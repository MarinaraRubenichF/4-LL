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

        $id_experimento->setValue(TSession::getValue('med_exp_id'));
        
        $this->form->addQuickAction( 'Buscar', new TAction(array($this, 'onSearch')), 'fa:search blue' );
        $this->form->addQuickAction( 'Exportar CSV',  new TAction(array($this, 'onExportCSV')), 'fa:file-excel-o blue' );
        //$this->form->addQuickAction( 'New',  new TAction(array('CustomerFormView', 'onEdit')), 'fa:plus green' );
        
        // creates a DataGrid
        $this->datagrid = new TQuickGrid;
        //$this->datagrid->enablePopover('Popover', 'Hi <b>{name}</b>, <br> that lives at <b>{city->name} - {city->state->name}</b>');
        
        // creates the datagrid columns
        $this->datagrid->addQuickColumn('Id', 'med_exp_id', 'center', '10%', new TAction(array($this, 'onReload')), array('order', 'med_exp_id'));
        $this->datagrid->addQuickColumn('Nome', 'experimento->exp_nome', 'left', '30%', new TAction(array($this, 'onReload')), array('order', 'experimento->exp_nome'));
        
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
            
            if (TSession::getValue('med_exp_id'))
            {
                // add the filter stored in the session to the criteria
                $criteria->add(TSession::getValue('med_exp_id'));
            }

            if(TSession::getValue('userid') != 1){
                $criteria->add(new TFilter('med_exp_id','in','(SELECT exp_id from experimentos where exp_usr_id = ' . TSession::getValue('userid') . ')'));
            }
            
             $crit = new TCriteria;
             $crit->add(new TFilter('med_exp_id', 'in', '(select date(exp_dt_hr) from experimentos)'));
             var_dump($crit);


            $csv = '';
            // load the objects according to criteria
            $meusExperimentos = $repository->load($criteria);
            if ($meusExperimentos)
            {
                foreach ($meusExperimentos as $meuExperimento)
                {
                    $csv .= $meuExperimento->parcela->par_nome.';'.
                            $meuExperimento->planta->plt_nome.';'.
                            $meuExperimento->$crit.';'.
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
