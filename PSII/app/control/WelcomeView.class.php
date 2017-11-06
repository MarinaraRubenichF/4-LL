<?php
/**
 * SystemGroupList Listing
 * @author  <your name here>
 */
class WelcomeView extends TStandardList
{
    protected $form;     // registration form
    protected $datagrid; // listing
    protected $pageNavigation;
    
    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct()
    {
        parent::__construct();
        
        parent::setDatabase('webrural');            // defines the database
        parent::setActiveRecord('Experimento');   // defines the active record
        parent::setDefaultOrder('exp_id', 'asc');         // defines the default order

        $this->form = new TQuickForm('form_Experimentos');
        $this->form->class = 'tform';

        if(TSession::getValue('userid') != 1){
            $criteria = new TCriteria();
            $criteria->add(new TFilter('exp_usr_id','=',TSession::getValue('userid')));
            parent::setCriteria($criteria);
        }

        // creates a DataGrid
        $this->datagrid = new BootstrapDatagridWrapper(new TQuickGrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        $this->datagrid->setHeight(320);

        // creates the datagrid columns
        $id = $this->datagrid->addQuickColumn('Id', 'exp_id', 'left');
        $nome = $this->datagrid->addQuickColumn('Nome', 'exp_nome', 'left');
        $data_hora = $this->datagrid->addQuickColumn('Criado em', 'exp_dt_hr', 'left');
        $cultura = $this->datagrid->addQuickColumn('Cultura', 'cultura->clt_nome', 'left');
        $num_plantas = $this->datagrid->addQuickColumn('Nº Plantas Amostra','exp_num_plts', 'left');
        $parcelas = $this->datagrid->addQuickColumn('Nº Parcelas','= {exp_num_lin} * {exp_num_col}', 'left');
        $imagem = $this->datagrid->addQuickColumn('Imagem', '', 'left');

        // aplica transformações
        $imagem->setTransformer(function($image, $object) {
            //return new TImage($object->exp_imagem);
            $link = "<a target='_blank' style='width:100%' href='app/images/{$object->exp_imagem}'>Toque para ver</a>";
            return $link;
            //$a = new TImage($object->exp_imagem); 
            //$a->style='width:50px'; // AQUI 
            //return $a; 
        });

        //$this->form->addQuickAction( 'CSV',  new TAction(array($this, 'onExportCSV')), 'fa:file-excel-o' );
        // creates two datagrid actions
        $this->datagrid->addQuickAction('Acrescentar Medidas', new TDataGridAction(array('MedidaForm', 'onNew')), 'exp_id', 'fa:edit blue');
        $this->datagrid->addQuickAction('Visão Geral', new TDataGridAction(array('VisaoGeralView', 'onSearch')), 'exp_id', 'fa:search');
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // create the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel = new TPanelGroup('Pure Bootstrap Datagrid');
        
        $container = new TVBox;
        $container->style = 'width: 97%';
        $container->add(TPanelGroup::pack('<body style="background-color=black;"><b>Meus Experimentos</b>', $this->datagrid));
        $container->add($this->pageNavigation);
        
        parent::add($container);
    }
}