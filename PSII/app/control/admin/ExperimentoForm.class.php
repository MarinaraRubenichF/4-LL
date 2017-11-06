<?php
/**
 * System_groupForm Registration
 * @author  <your name here>
 */
class ExperimentoForm extends TStandardForm
{
    protected $form; // form
    
    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct()
    {
        parent::__construct();
        
        $this->setDatabase('webrural');              // defines the database
        $this->setActiveRecord('Experimento');     // defines the active record
        
        // creates the form
         $this->form = new TQuickForm('form_Experimento');
        $this->form->class = 'tform';
        $this->form->setFormTitle('Experimentos');
        
        //if(TSession::getValue('userid') != 1){
            $crit = new TCriteria();
            $crit->add(new TFilter('lgn_id','in','(SELECT exp_usr_id from experimentos where exp_usr_id = ' . TSession::getValue('userid') . ')'));

        // create the form fields
        $exp_id = new TEntry('exp_id');
        $exp_usr_id = new TDBCombo('exp_usr_id','webrural','Usuario','lgn_id','lgn_usr_nome','', $crit);
        //$exp_usr_id = new TEntry('exp_usr_id');
        $exp_nome = new TEntry('exp_nome');
        $exp_desc = new TText('exp_desc');
        $exp_dt_hr = new TDateTime('exp_dt_hr');
        $exp_local = new TDBCombo('exp_lcl_id','webrural','Local','lcl_id','lcl_nome');
        $exp_clt_id = new TDBCombo('exp_clt_id','webrural','Cultura','clt_id','clt_nome');
        $exp_tip_id = new TDBCombo('exp_tip_id','webrural','Tipo','tip_id','tip_nome');
        $exp_num_lin = new TSpinner('exp_num_lin');
        $exp_num_col = new TSpinner('exp_num_col');
        $exp_espac = new TEntry('exp_espac');
        $exp_imagem = new TFile('exp_imagem');

        $exp_espac->setNumericMask(2, '.', true);
        $exp_dt_hr->setMask('dd/mm/yyyy hh:ii');
        $exp_dt_hr->setDatabaseMask('yyyy-mm-dd hh:ii');
        $exp_dt_hr->setValue( date('Y-m-d H:i') );
        $exp_num_lin->setRange(1,100,1); 
        $exp_num_col->setRange(1,100,1);
        $exp_imagem->setCompleteAction(new TAction(array($this, 'onComplete')));

        // add the fields
        $this->form->addQuickField('Id', $exp_id, '20%');
        $this->form->addQuickField('Nome', $exp_nome, '50%');
        $this->form->addQuickField('Descrição', $exp_desc, '50%');
        $this->form->addQuickField('Usuário', $exp_usr_id, '50%');
        $this->form->addQuickField('Data/hora', $exp_dt_hr, '50%');
        $this->form->addQuickField('Cultura', $exp_clt_id, '50%');
        $this->form->addQuickField('Local', $exp_local, '50%');
        $this->form->addQuickField('Tipo', $exp_tip_id, '50%');
        $this->form->addQuickField('Linhas / Tratamentos', $exp_num_lin, '20%');
        $this->form->addQuickField('Colunas / Repetições', $exp_num_col, '20%');
        $this->form->addQuickField('Espaçamento', $exp_espac, '20%');
        $this->form->addQuickField('Imagem', $exp_imagem, '50%');

        /*$this->form->addFields( [new TLabel('Id')], [$exp_id, ('Nome'), $exp_nome] );
        $this->form->addFields( [new TLabel('Descrição')], [$exp_desc] );
        $this->form->addFields( [new TLabel('Usuário')], [$exp_usr_id, ('Data/hora'), $exp_dt_hr] );
        $this->form->addFields( [new TLabel('Cultura')], [$exp_clt_id, ('Local'), $exp_local] );
        $this->form->addFields([new TLabel('Linhas')], [$exp_num_lin, ('Colunas'), $exp_num_col, ('Espaçamento'), $exp_espac]);*/

        $exp_id->setEditable(FALSE);
        
        $this->frame = new TElement('div');
        $this->frame->id = 'photo';
        $this->frame->style = 'width:400px;height:auto;min-height:200px;border:1px solid gray;padding:4px;';
        $row = $this->form->addRow();
        $row->addCell('');
        $row->addCell($this->frame);

        // create the form actions
        $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:floppy-o');
        $this->form->addQuickAction('Novo Experimento',  new TAction(array($this, 'onEdit')), 'fa:eraser red');
        $this->form->addQuickAction('Nova Cultura',  new TAction(array('CulturaForm', 'onEdit')), 'fa:plus-circle red');
        $this->form->addQuickAction('Novo Bloco',  new TAction(array('BlocoForm', 'onEdit')), 'fa:plus-circle red');
        $this->form->addQuickAction('Novo Local',  new TAction(array('LocalForm', 'onEdit')), 'fa:plus-circle red');
        $this->form->addQuickAction('Novo Usuário',  new TAction(array('UsuarioForm', 'onEdit')), 'fa:user-plus red');
        $this->form->addQuickAction('Ir para a Listagem',new TAction(array('ExperimentoList','onReload')),'fa:table blue');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        $container->add(new TXMLBreadCrumb('menu.xml', 'ExperimentoForm'));
        $container->add($this->form);
        
        parent::add($container);
    }

     /**
     * On complete upload
     */
    public static function onComplete($param)
    {
        //new TMessage('info', 'Upload completed: '.$param['exp_imagem']);
        
        // refresh photo_frame
        TScript::create("$('#photo').html('')");
        TScript::create("$('#photo').append(\"<img style='width:100%' src='tmp/{$param['exp_imagem']}'>\");");
    }
    
    /**
     * Edit product
     */
    public function onEdit($param)
    {
        $object = parent::onEdit($param);
        if ($object)
        {
            $image = new TImage($object->exp_imagem);
            $image->style = 'width: 100%';
            $this->frame->add( $image );
        }
    }
    
    /**
     * Overloaded method onSave()
     * Executed whenever the user clicks at the save button
     */
    public function onSave()
    {
        // first, use the default onSave()
        $object = parent::onSave();
        
        // if the object has been saved
        if ($object instanceof Experimento)
        {
            $source_file   = 'tmp/'.$object->exp_imagem;
            $target_file   = 'images/'.$object->exp_imagem;
            $finfo         = new finfo(FILEINFO_MIME_TYPE);
            
            // if the user uploaded a source file
            if (file_exists($source_file) AND ($finfo->file($source_file) == 'image/png' OR $finfo->file($source_file) == 'image/jpeg'))
            {
                // move to the target directory
                rename($source_file, $target_file);
                try
                {
                    TTransaction::open('webrural');
                    // update the photo_path
                    $object->exp_imagem = 'images/'.$object->exp_imagem;
                    $object->store();
                    
                    TTransaction::close();
                }
                catch (Exception $e) // in case of exception
                {
                    new TMessage('error', $e->getMessage());
                    TTransaction::rollback();
                }
            }
            $image = new TImage($object->exp_imagem);
            $image->style = 'width: 100%';
            $this->frame->add( $image );
        }
    }
}
