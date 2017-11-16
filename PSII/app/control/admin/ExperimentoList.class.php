<?php
/**
 * SystemGroupList Listing
 * @author  <your name here>
 */
class ExperimentoList extends TStandardList
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
        parent::setActiveRecord('Experimento');   // defines the active record
        parent::setDefaultOrder('exp_id', 'asc');         // defines the default order
        parent::addFilterField('exp_id', '=', 'exp_id'); // filterField, operator, formField
        parent::addFilterField('exp_nome', 'like', 'exp_nome'); // filterField, operator, formField
        parent::addFilterField('exp_lcl_id', 'like', 'exp_lcl_id'); // filterField, operator, formField
        parent::addFilterField('exp_clt_id', 'like', 'exp_clt_id'); // filterField, operator, formField
        
        // creates the form
        $this->form = new TQuickForm('form_search_Experimento');
        $this->form->class = 'tform';
        $this->form->setFormTitle('Experimentos');

        if(TSession::getValue('userid') != 1){
            $criteria = new TCriteria();
            $criteria->add(new TFilter('exp_usr_id','=',TSession::getValue('userid')));
            parent::setCriteria($criteria);
        }
        //if(TSession::getValue('userid') != 1){
            $crit = new TCriteria();
            $crit->add(new TFilter('lgn_id','in','(SELECT exp_usr_id from experimentos where exp_usr_id = ' . TSession::getValue('userid') . ')'));
        //}
        
        // create the form fields
        $exp_id = new TEntry('exp_id');
        $exp_nome = new TEntry('exp_nome');
        $exp_lcl_id = new TDBCombo('exp_lcl_id','webrural','Local','lcl_id','lcl_nome');
        $exp_clt_id = new TDBCombo('exp_clt_id','webrural','Cultura','clt_id','clt_nome');
        
        // add the fields
        $this->form->addQuickField('Id', $exp_id, '20%');
        $this->form->addQuickField('Nome', $exp_nome, '50%');
        $this->form->addQuickField('Cultura', $exp_clt_id, '50%');
        $this->form->addQuickField('Local', $exp_lcl_id, '50%');
        
        // add the search form actions
        $this->form->addQuickAction(_t('Find'), new TAction(array($this, 'onSearch')), 'fa:search');
        //$this->form->addAction(('Acrescentar Medidas'),  new TAction(array('MedidaForm', 'onEdit')), 'bs:plus-sign green');
        //$this->form->addAction('Exportar CSV',  new TAction(array($this, 'onExportCSV')), 'fa:file-excel-o' );

        // creates a DataGrid
        $this->datagrid = new BootstrapDatagridWrapper(new TQuickGrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        $this->datagrid->setHeight(320);

        // creates the datagrid columns
        // Dados da tabela para os campos da listagem
        //$column_id = new TDataGridColumn('exp_id', 'Id', 'center', 50);
        $column_nome = $this->datagrid->addQuickColumn('Nome', 'exp_nome', 'center', 100);
        $column_usr_id = $this->datagrid->addQuickColumn('Usuário', 'nome_usuario->lgn_usr_nome', 'center', 50);
        $column_dt_hr = $this->datagrid->addQuickColumn('Data/Hora', 'exp_dt_hr', 'center', 150);
        $column_cultura = $this->datagrid->addQuickColumn('Cultura', 'cultura->clt_nome', 'center', 50);
        $column_linha = $this->datagrid->addQuickColumn('Linhas / Repetições', 'exp_num_lin', 'center', 60);
        $column_coluna = $this->datagrid->addQuickColumn('Colunas / Tratamentos', 'exp_num_col', 'center', 60);
        $column_parcela = $this->datagrid->addQuickColumn('Nº Parcelas', '= {exp_num_lin} * {exp_num_col}', 'center', 60);
        $column_num_plts = $this->datagrid->addQuickColumn('Nº Plantas Amostra', 'exp_num_plts', 'center', 60);
        $column_tipo = $this->datagrid->addQuickColumn('Tipo', 'tipo->tip_nome', 'center', 60);
        $column_espac = $this->datagrid->addQuickColumn('Espaçamento', 'exp_espac', 'center', 50);
        $column_desc = $this->datagrid->addQuickColumn('Descrição', 'exp_desc', 'center', 250);
        $column_local = $this->datagrid->addQuickColumn('Local', 'local->lcl_nome', 'center', 100);

        $column_dt_hr->setTransformer(array($this, 'formatDate'));

        /*$column_imagem = $this->datagrid->addQuickColumn('Imagem', '', 'left');

        // aplica transformações
        $column_imagem->setTransformer(function($image, $object) {
            //return new TImage($object->med_imagem);
            $link = "<a target='_blank' style='width:100%' href='app/images/{$object->med_imagem}'>Toque para ver</a>";
            return $link;
            //$a= new TImage($object->med_imagem); 
            //$a->style='width:50px'; // AQUI 
            //return $a; 
        });*/

        $this->datagrid->addQuickAction('Editar', new TDataGridAction(array('ExperimentoForm', 'onEdit')), 'exp_id', 'fa:pencil-square-o blue fa-lg');
        $this->datagrid->addQuickAction('Acresc, Informações', new TDataGridAction(array('MedidaForm', 'onNew')), 'exp_id','fa:plus-square green');
        $this->datagrid->addQuickAction('Excluir', new TDataGridAction(array($this, 'onDelete')), 'exp_id', 'fa:trash-o red fa-lg');


        /*/ creates the datagrid column actions
        $order_id = new TAction(array($this, 'onReload'));
        $order_id->setParameter('order', 'exp_id');
        $column_id->setAction($order_id);*/
        
        $order_nome = new TAction(array($this, 'onReload'));
        $order_nome->setParameter('order', 'exp_nome');
        $column_nome->setAction($order_nome);

        /*$order_cultura = new TAction(array($this, 'onReload'));
        $order_cultura->setParameter('order', 'exp_clt_id');
        $column_cultura->setAction($order_cultura);*/
        
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

    public function onEdit($param)
    {
    }

    public function formatDate($column_dt_hr, $object)
    {
        $dt = new DateTime($column_dt_hr);
        return $dt->format('d/m/Y h:i');
    }
}
