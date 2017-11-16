 <?php
/**
 * SystemGroupList Listing
 * @author  <your name here>
 */
class MedidaList extends TStandardList
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
        parent::setActiveRecord('Medida');   // defines the active record
        parent::setDefaultOrder('med_id', 'asc');         // defines the default order
        parent::addFilterField('med_id', '=', 'med_id'); // filterField, operator, formField
        parent::addFilterField('med_exp_id', 'like', 'med_exp_id'); // filterField, operator, formField
        parent::addFilterField('med_par_id', 'like', 'med_par_id'); // filterField, operator, formField
        parent::addFilterField('med_plt_id', '=', 'med_plt_id'); // filterField, operator, formField
        parent::addFilterField('med_fen_id', 'like', 'med_fen_id'); // filterField, operator, formField
        
        // creates the form
        $this->form = new TQuickForm('form_search_Medida');
        $this->form->class = 'tform';
        $this->form->setFormTitle('Medidas');

        if(TSession::getValue('userid') != 1){
            $criteria = new TCriteria();
            $criteria->add(new TFilter('med_exp_id','in','(SELECT exp_id from experimentos where exp_usr_id = ' . TSession::getValue('userid') . ')'));
            parent::setCriteria($criteria);
        }
        $crit = new TCriteria();
        $crit->add(new TFilter('exp_id','in','(SELECT exp_id from experimentos where exp_usr_id = ' . TSession::getValue('userid') . ')'));
        
        // create the form fields
        $med_id = new TEntry('med_id');
        $med_exp_id = new TDBCombo('med_exp_id','webrural','Experimento','exp_id','exp_nome','', $crit);
        $med_par_id = new TDBCombo('med_par_id','webrural','Parcela','par_id','par_nome');
        $med_plt_id = new TDBCombo('med_plt_id','webrural','Planta','plt_id','plt_nome');
        $med_fen_id = new TDBCombo('med_fen_id','webrural','Fenologia','fen_id','fen_fenologia');

        // add the fields
        $this->form->addQuickField('Id', $med_id, '20%');
        $this->form->addQuickField('Experimento', $med_exp_id, '50%');
        $this->form->addQuickField('Parcela', $med_par_id, '50%');
        $this->form->addQuickField('Planta', $med_plt_id, '50%');
        $this->form->addQuickField('Fenologia', $med_fen_id, '50%');
        
        // add the search form actions
        $this->form->addQuickAction('Procurar', new TAction(array($this, 'onSearch')), 'fa:search');
        //$this->form->addAction(('Nova Medida'),  new TAction(array('MedidaForm', 'onEdit')), 'bs:plus-sign green');
        //$this->form->addAction('Exportar CSV',  new TAction(array($this, 'onExportCSV')), 'fa:file-excel-o' );   

        // creates a DataGrid
        $this->datagrid = new BootstrapDatagridWrapper(new TQuickGrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        $this->datagrid->setHeight(320);

        $column_experimento = $this->datagrid->addQuickColumn('Experimento', 'experimento->exp_nome', 'center', 100);
        $column_parcela =  $this->datagrid->addQuickColumn( 'Parcela', 'parcela->par_nome', 'center', 100);
        $column_planta =  $this->datagrid->addQuickColumn('Planta', 'planta->plt_nome', 'center', 100);
        $column_altura =  $this->datagrid->addQuickColumn('Altura da Planta', 'med_alt_planta', 'center', 100);
        $column_largura = $this->datagrid->addQuickColumn('Largura da Folha', 'med_larg_folha', 'center', 100);
        $column_tamanho =  $this->datagrid->addQuickColumn('Tamanho da Folha', 'med_tam_folha', 'center', 100);
        $column_data = $this->datagrid->addQuickColumn('Data', 'med_data', 'center', 100);
        $column_fenologia = $this->datagrid->addQuickColumn('Fenologia', 'fenologia->fen_fenologia', 'center', 100);
        //$column_data->setMask("dd/mm/yyyy"); 
        $column_data->setTransformer(array($this, 'formatDate'));

        /*$column_imagem = $this->datagrid->addQuickColumn('Imagem', '', 'left');

        // aplica transformações
        $column_imagem->setTransformer(function($image, $object) {
            if($object->med_imagem != NULL){
                $link = "<a target='_blank' style='width:100%' href='app/images/{$object->med_imagem}'>Toque para ver</a>";
                return $link;
                //$a= new TImage($object->med_imagem); 
                //$a->style='width:50px'; // AQUI 
                //return $a;
            }
        });*/

        $this->datagrid->addQuickAction('Editar', new TDataGridAction(array('MedidaForm', 'onEdit')), 'med_exp_id', 'fa:pencil-square-o blue fa-lg');
        $this->datagrid->addQuickAction('Acresc, Informações', new TDataGridAction(array('MedidaForm', 'onNew')), 'med_exp_id','fa:plus-square green');
        $this->datagrid->addQuickAction('Excluir', new TDataGridAction(array($this, 'onDelete')), 'med_exp_id', 'fa:trash-o red fa-lg');

        /*/ creates the datagrid column actions
        $order_id = new TAction(array($this, 'onReload'));
        $order_id->setParameter('order', 'medexp__id');
        $column_id->setAction($order_id);
        
        /*$order_nome = new TAction(array($this, 'onReload'));
        $order_nome->setParameter('order', 'med_nome');
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

    public function formatDate($column_data, $object)
    {
        $dt = new DateTime($column_data);
        return $dt->format('d/m/Y');
    }
}
