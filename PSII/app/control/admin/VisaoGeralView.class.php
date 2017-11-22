<?php
/**
 * SystemGroupList Listing
 * @author  <your name here>
 */
class VisaoGeralView extends TStandardList
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
        parent::setActiveRecord('Medida');   // defines the active record
        parent::setDefaultOrder('med_id', 'asc');         // defines the default order

        $this->form = new TQuickForm('form_Experimentos');
        $this->form->class = 'tform';

        if(TSession::getValue('userid') != 1){
            $criteria = new TCriteria();
            $criteria->add(new TFilter('med_exp_id','in','(SELECT exp_id from experimentos where exp_usr_id = ' . TSession::getValue('userid') . ')'));
            parent::setCriteria($criteria);
        }
        
        // creates a DataGrid
        $this->datagrid = new BootstrapDatagridWrapper(new TQuickGrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        $this->datagrid->setHeight(320);
        

        // creates the datagrid columns
        $id = $this->datagrid->addQuickColumn('Id','experimento->exp_id', 'left');
        $nome = $this->datagrid->addQuickColumn('Nome', 'experimento->exp_nome', 'left');
        $usuario = $this->datagrid->addQuickColumn('Usuário', 'experimento->nome_usuario->lgn_usr_nome', 'left');
        $data_hora = $this->datagrid->addQuickColumn('Data Criação', 'experimento->exp_dt_hr', 'left');
        $data = $this->datagrid->addQuickColumn('Data Medida', 'med_data', 'left');
        $cultura = $this->datagrid->addQuickColumn('Cultura', 'experimento->cultura->clt_nome', 'left'); 
        $parcelas = $this->datagrid->addQuickColumn('Nº Parcelas','= {experimento->exp_num_lin} * {experimento->exp_num_col}', 'left');
        $parcela = $this->datagrid->addQuickColumn('Parcela','parcela->par_nome', 'left');
        $bloco = $this->datagrid->addQuickColumn('Bloco','bloco->blc_nome', 'left');
        $planta = $this->datagrid->addQuickColumn('Planta','planta->plt_nome', 'left');
        $alt_planta = $this->datagrid->addQuickColumn('Altura da Planta','med_alt_planta', 'left');
        $larg_folha = $this->datagrid->addQuickColumn('Largura da Folha','med_larg_folha', 'left');
        $tam_folha = $this->datagrid->addQuickColumn('Tamanho da Folha','med_tam_folha', 'left');
        $fenologia = $this->datagrid->addQuickColumn('Fenologia','fenologia->fen_fenologia', 'left');
        $imagem = $this->datagrid->addQuickColumn('Imagem', '', 'left');

        $data_hora->setTransformer(array($this, 'formatDate'));

        $this->form->addQuickAction('CSV',  new TAction(array($this, 'onExportCSV')), 'fa:file-excel-o' );

        // aplica transformações
        $imagem->setTransformer(function($image, $object) {
            //return new TImage($object->med_imagem);
            $link = "<a target='_blank' style='width:100%' href='app/images/{$object->med_imagem}'>Toque para ver</a>";
            return $link;
            //$a= new TImage($object->med_imagem); 
            //$a->style='width:50px'; // AQUI 
            //return $a; 
        });
   
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

    /**
     * Export to CSV
     */

    function onExportCSV()
    {
        $this->onSearch();
    }

    public function formatDate($data_hora, $object)
    {
        $dt = new DateTime($data_hora);
        return $dt->format('d/m/Y h:i');
    }
}