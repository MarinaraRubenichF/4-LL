<?php
/**
 * SystemGroupList Listing
 * @author  <your name here>
 */
class PlantaList extends TStandardList
{
    protected $form;     // registration form
    protected $datagrid; // listing
    protected $pageNavigation;
    protected $formgrid;
    protected $deleteButton;
    protected $transformCallback;
    
    /**
     * Page constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        parent::setDatabase('webrural');            // defines the database
        parent::setActiveRecord('Planta');   // defines the active record
        parent::setDefaultOrder('plt_id', 'asc');         // defines the default order
        parent::addFilterField('plt_id', '=', 'id'); // filterField, operator, formField
        parent::addFilterField('plt_nome', 'like', 'plt_nome'); // filterField, operator, formField
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_search_Planta');
        $this->form->setFormTitle('Planta');
        
        // create the form fields
        $id = new TEntry('id');
        $name = new TEntry('name');
        
        // add the fields
        $this->form->addFields( [new TLabel('Id')], [$id] );
        $this->form->addFields( [new TLabel(_t('Name'))], [$name] );

        $id->setSize('30%');
        $name->setSize('70%');
        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('Planta_filter_data') );
        
        // add the search form actions
        $this->form->addAction(_t('Find'), new TAction(array($this, 'onSearch')), 'fa:search');
        $this->form->addAction(_t('New'),  new TAction(array('PlantaForm', 'onEdit')), 'bs:plus-sign green');
        
        // creates a DataGrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);
        
        // creates the datagrid columns
        $column_id = new TDataGridColumn('plt_id', 'Id', 'center', 50);
        $column_name = new TDataGridColumn('plt_nome', _t('Name'), 'left');


        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_name);

        // creates the datagrid column actions
        $order_id = new TAction(array($this, 'onReload'));
        $order_id->setParameter('order', 'plt_id');
        $column_id->setAction($order_id);
        
        $order_name = new TAction(array($this, 'onReload'));
        $order_name->setParameter('order', 'plt_nome');
        $column_name->setAction($order_name);
        
       
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // create the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        $container->add(TPanelGroup::pack('', $this->datagrid));
        $container->add($this->pageNavigation);
        
        parent::add($container);
    }
}
