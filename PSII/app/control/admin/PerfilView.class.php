<?php
class PerfilView extends TPage
{
    public function __construct()
    {
        parent::__construct();
        
        $html = new THtmlRenderer('app/resources/profile.html');
        $replaces = array();
        
        try
        {
            TTransaction::open('webrural');
            
            $user= Usuario::newFromLogin(TSession::getValue('login'));
            $replaces = $user->toArray();
            $replaces['frontpage'] = $user->frontpage_name;
            $replaces['groupnames'] = $user->getSystemUserGroupNames();
            
            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
        
        $html->enableSection('main', $replaces);
        $html->enableTranslation();
        
        $bc = new TBreadCrumb();
        $bc->addHome();
        $bc->addItem('Perfil');
        
        $container = TVBox::pack($bc, $html);
        $container->style = 'width:80%';
        parent::add($container);
    }
}
