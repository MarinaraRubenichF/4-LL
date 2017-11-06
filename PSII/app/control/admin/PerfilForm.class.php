<?php
class PerfilForm extends TPage
{
    private $form;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->form = new TQuickForm;
        $this->form->class = 'tform';
        $this->form->setFormTitle('Perfil');
        
        $name  = new TEntry('lgn_usr_nome');
        $login = new TEntry('lgn_usuario');
        $password = new TPassword('lgn_senha');
        $login->setEditable(FALSE);
        
        $this->form->addQuickField( _t('Name'), $name, '80%', new TRequiredValidator );
        $this->form->addQuickField( _t('Login'), $login, '80%', new TRequiredValidator );
        
        $table = $this->form->getContainer();
        $row = $table->addRow();
        $row->style = 'background: #FFFBCB;';
        $cell = $row->addCell( new TLabel(_t('Change password') . ' ('. _t('Leave empty to keep old password') . ')') );
        $cell->colspan = 2;
        
        $this->form->addQuickField( _t('Password'), $password, '80%' );
        
        $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:save');
        
        $bc = new TBreadCrumb();
        $bc->addHome();
        $bc->addItem('Perfil');
        
        $container = TVBox::pack($bc, $this->form);
        $container->style = 'width:90%';
        parent::add($container);
    }
    
    public function onEdit($param)
    {
        try
        {
            TTransaction::open('webrural');
            $login = Usuario::newFromLogin( TSession::getValue('login') );
            $this->form->setData($login);
            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
    
    public function onSave($param)
    {
        try
        {
            $this->form->validate();
            
            $object = $this->form->getData();
            
            TTransaction::open('webrural');
            $user = Usuario::newFromLogin( TSession::getValue('login') );
            $user->lgn_usr_nome = $object->lgn_usr_nome;
            
            if( $object->lgn_senha )
            {  
                $user->lgn_senha = md5($object->lgn_senha);
            }
            else
            {
                unset($user->lgn_senha);
            }
            
            $user->store();
            
            $this->form->setData($object);
            
            new TMessage('info', TAdiantiCoreTranslator::translate('Record saved'));
            
            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
}