<?php
/**
 * System_groupForm Registration
 * @author  <your name here>
 */
class MedidaForm extends TStandardForm
{
    protected $form; // form
    private $frame;
    
    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct()
    {
        parent::__construct();
        
        parent::setDatabase('webrural');              // defines the database
        parent::setActiveRecord('Medida');     // defines the active record
        
        // creates the form
        $this->form = new TQuickForm('form_Medida');
        $this->form->class = 'tform';
        $this->form->setFormTitle('Medidas');

        $crit = new TCriteria();
        $crit->add(new TFilter('exp_id','in','(SELECT exp_id from experimentos where exp_usr_id = ' . TSession::getValue('userid') . ')'));
        
        // create the form fields
        $med_id = new TEntry('med_id');
        $med_exp_id = new TDBCombo('med_exp_id','webrural','Experimento','exp_id','exp_nome','exp_nome', $crit);
        $med_par_id = new TDBCombo('med_par_id','webrural','Parcela','par_id','par_nome');
        $med_plt_id = new TDBCombo('med_plt_id','webrural','Planta','plt_id','plt_nome');
        $med_alt_planta = new TEntry('med_alt_planta');
        $med_larg_folha = new TEntry('med_larg_folha');
        $med_tam_folha = new TEntry('med_tam_folha');
        $med_fen_id = new TDBCombo('med_fen_id','webrural','Fenologia','fen_id','fen_fenologia');
        $med_data = new TDate('med_data');
        $med_imagem = new TFile('med_imagem');

        // complete upload action
        $med_imagem->setCompleteAction(new TAction(array($this, 'onComplete')));
        //$med_imagem->setAllowedExtensions( ['gif', 'png', 'jpg', 'jpeg'] );
        $med_alt_planta->setNumericMask(2, '.', true);
        $med_larg_folha->setNumericMask(2, '.', true);
        $med_tam_folha->setNumericMask(2, '.', true);
        $med_data->setMask('dd/mm/yyyy');
        $med_data->setDatabaseMask('yyyy-mm-dd');
        $med_data->setValue( date('Y-m-d') );

        // add the fields
        $this->form->addQuickField('ID', $med_id, '20%');
        $this->form->addQuickField('Experimento', $med_exp_id, '50%');
        $this->form->addQuickField('Parcela', $med_par_id, '50%');
        $this->form->addQuickField('Planta', $med_plt_id, '50%');
        $this->form->addQuickField('Altura da Planta (cm)', $med_alt_planta, '50%');
        $this->form->addQuickField('Largura da Folha (cm)', $med_larg_folha, '50%');
        $this->form->addQuickField('Tamanho da Folha (cm)', $med_tam_folha, '50%');
        $this->form->addQuickField('Fenologia', $med_fen_id, '50%');
        $this->form->addQuickField('Data', $med_data, '50%');
        $this->form->addQuickField('Imagem', $med_imagem, '50%');

        $med_id->setEditable(FALSE);

        $this->frame = new TElement('div');
        $this->frame->id = 'photo';
        $this->frame->style = 'width:400px;height:auto;min-height:200px;border:1px solid gray;padding:4px;';
        $row = $this->form->addRow();
        $row->addCell('');
        $row->addCell($this->frame);

        // create the form actions
        $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:floppy-o');
        $this->form->addQuickAction('Nova Medida',  new TAction(array($this, 'onEdit')), 'fa:eraser red');
        $this->form->addQuickAction('Nova Parcela',  new TAction(array('ParcelaForm', 'onEdit')), 'fa:plus-circle red');
        $this->form->addQuickAction('Nova Planta',  new TAction(array('PlantaForm', 'onEdit')), 'fa:plus-circle red');
        $this->form->addQuickAction('Nova Fenologia',  new TAction(array('FenologiaForm', 'onEdit')), 'fa:plus-circle red');
        $this->form->addQuickAction('Ir para a Listagem de Medidas',new TAction(array('MedidaList','onReload')),'fa:table blue');
        $this->form->addQuickAction('Voltar para a Listagem de Experimentos',new TAction(array('ExperimentoList','onReload')),'fa:table blue');

        //$this->form->addQuickContent(array($this->frame));
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        $container->add(new TXMLBreadCrumb('menu.xml', 'MedidaList'));
        $container->add($this->form);
        
        parent::add($container);
    }

    public function onNew()
    {
    }

    /**
     * On complete upload
     */
    public static function onComplete($param)
    {
        //new TMessage('info', 'Upload completed: '.$param['med_imagem']);
        
        // refresh photo_frame
        TScript::create("$('#photo').html('')");
        TScript::create("$('#photo').append(\"<img style='width:100%' src='tmp/{$param['med_imagem']}'>\");");
    }
    
    /**
     * Edit product
     */
    public function onEdit($param)
    {
        $object = parent::onEdit($param);
        if ($object)
        {
            $image = new TImage($object->med_imagem);
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
        if ($object instanceof Medida)
        {
            $source_file   = 'tmp/'.$object->med_imagem;
            $target_file   = 'images/'.$object->med_imagem;
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
                    $object->med_imagem = 'images/'.$object->med_imagem;
                    $object->store();
                    
                    TTransaction::close();
                }
                catch (Exception $e) // in case of exception
                {
                    new TMessage('error', $e->getMessage());
                    TTransaction::rollback();
                }
            }
            $image = new TImage($object->med_imagem);
            $image->style = 'width: 100%';
            $this->frame->add( $image );
        }
    }
}
