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

        if(TSession::getValue('userid') != 1){
            $crit = new TCriteria();
            $crit->add(new TFilter('lgn_id','in','(SELECT lgn_id from login where lgn_id = ' . TSession::getValue('userid') . ')'));
        }

        // create the form fields
        $exp_id = new THidden('exp_id');
        $exp_usr_id = new TDBCombo('exp_usr_id','webrural','Usuario','lgn_id','lgn_usr_nome','', $crit);
        $exp_nome = new TEntry('exp_nome');
        $exp_desc = new TText('exp_desc');
        $exp_dt_hr = new TDateTime('exp_dt_hr');
        $exp_lcl_id = new TDBCombo('exp_lcl_id','webrural','Local','lcl_id','lcl_nome');
        $exp_clt_id = new TDBCombo('exp_clt_id','webrural','Cultura','clt_id','clt_nome');
        $exp_tip_id = new TDBCombo('exp_tip_id','webrural','Tipo','tip_id','tip_nome');
        $exp_num_lin = new TSpinner('exp_num_lin');
        $exp_num_col = new TSpinner('exp_num_col');
        $exp_num_plts = new TSpinner('exp_num_plts');
        $exp_espac = new TEntry('exp_espac');
        $exp_imagem = new TFile('exp_imagem');

        $exp_espac->setNumericMask(2, '.', true);
        $exp_dt_hr->setMask('dd/mm/yyyy hh:ii');
        $exp_dt_hr->setDatabaseMask('yyyy-mm-dd hh:ii');
        $exp_dt_hr->setValue( date('Y-m-d H:i') );
        $exp_num_lin->setRange(1,100,1); 
        $exp_num_col->setRange(1,100,1);
        $exp_num_plts->setRange(1,100,1);

        // add the fields
        $this->form->addQuickField('Id', $exp_id, '20%');
        $this->form->addQuickField('Nome', $exp_nome, '90%');
        $this->form->addQuickField('Descrição', $exp_desc, '90%');
        $this->form->addQuickField('Usuário', $exp_usr_id, '90%');
        $this->form->addQuickField('Data/hora', $exp_dt_hr, '90%');
        $this->form->addQuickField('Cultura', $exp_clt_id, '90%');
        $this->form->addQuickField('Local', $exp_lcl_id, '90%');
        $this->form->addQuickField('Tipo', $exp_tip_id, '90%');
        $this->form->addQuickField('Linhas / Tratamentos', $exp_num_lin, '30%');
        $this->form->addQuickField('Colunas / Repetições', $exp_num_col, '30%');
        $this->form->addQuickField('Nº Plantas Amostra', $exp_num_plts, '30%');
        $this->form->addQuickField('Espaçamento (em metros)', $exp_espac, '30%');
        $this->form->addQuickField('Imagem', $exp_imagem, '90%');

        $exp_id->setEditable(FALSE);

        // create the form actions
        $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:floppy-o');
        $this->form->addQuickAction('Novo Experimento',  new TAction(array($this, 'onEdit')), 'fa:eraser red');
        $this->form->addQuickAction('Nova Cultura',  new TAction(array('CulturaForm', 'onEdit')), 'fa:plus-circle red');
        $this->form->addQuickAction('Novo Bloco',  new TAction(array('BlocoForm', 'onEdit')), 'fa:plus-circle red');
        $this->form->addQuickAction('Novo Local',  new TAction(array('LocalForm', 'onEdit')), 'fa:plus-circle red');
        //$this->form->addQuickAction('Novo Usuário',  new TDataGridAction(array('UsuarioForm', 'onEdit')), 'fa:user-plus red');
        $this->form->addQuickAction('Ir para a Listagem',new TDataGridAction(array('ExperimentoList','onReload')),'fa:table blue');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(new TXMLBreadCrumb('menu.xml', 'ExperimentoForm'));
        $container->add($this->form);
        
        parent::add($container);
    }

    
    /**
     * Edit
     */
    public function onEdit($param)
    {
        $object = parent::onEdit($param);
        if ($object)
        {
            $image = new TImage($object->exp_imagem);
            $image->style = 'width: 100%';
        }

         try 
         {
            if (isset($param['key'])) {
                $key = $param['key'];  // obtém o parâmetro $key
                
                TTransaction::open('webrural'); // abre a transação
                $data = new Experimento($key); // instancia o Active Record
                
                $this->form->setData($data); // preenche o form
                TTransaction::close(); // fecha a transação
            }
            else {
                $this->form->clear();
            }
           
        } 
        catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }
    }
    
    /**
     * Overloaded method onSave()
     * Executed whenever the user clicks at the save button
     */
    public function onSave()
    {
        $data = $this->form->getData();
        $this->form->setData($data);

        try
        {
            // open a transaction with database 'permission'
            TTransaction::open('webrural');

            // first, use the default onSave()
            $object = parent::onSave();
            
            // if the object has been saved
            if ($object instanceof Experimento)
            {
                $source_file   = 'tmp/'.$object->exp_imagem;
                $target_file   = 'app/images/'.$object->exp_imagem;
                $finfo         = new finfo(FILEINFO_MIME_TYPE);
                
                // if the user uploaded a source file
                if (file_exists($source_file) AND ($finfo->file($source_file) == 'image/png' OR $finfo->file($source_file) == 'image/jpeg'))
                {
                    // move to the target directory
                    //rename($source_file, $target_file)
                        
                        // update the photo_path
                        $object->exp_imagem = 'tmp/'.$object->exp_imagem;
                        $object->store();
                }
                $image = new TImage($object->exp_imagem);
                $image->style = 'width: 100%';
            }

            $dat = new Experimento();
            $dat->exp_id = $data->exp_id;
            $dat->exp_nome = $data->exp_nome;
            $dat->exp_desc = $data->exp_desc;
            $dat->exp_dt_hr = $data->exp_dt_hr;
            $dat->exp_lcl_id = $data->exp_lcl_id;
            $dat->exp_clt_id = $data->exp_tip_id;
            $dat->exp_tip_id = $data->exp_tip_id;
            $dat->exp_num_lin = $data->exp_num_lin;
            $dat->exp_num_col = $data->exp_num_col;
            $dat->exp_num_plts = $data->exp_num_plts;
            $dat->exp_espac = $data->exp_espac;
            $dat->exp_imagem = $data->exp_imagem;
            $dat->store();
            
            $action = new TAction(array('ExperimentoList', 'onReload'));
            new TMessage('info', 'Registro Salvo', $action);

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
