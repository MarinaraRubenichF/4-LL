<?php
/**
 * System_groupForm Registration
 * @author  <your name here>
 */
class FenologiaForm extends TStandardForm
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
        $this->setActiveRecord('Fenologia');     // defines the active record
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_Fenologia');
        $this->form->setFormTitle('Fenologia');
        
        // create the form fields
        $fen_id = new TEntry('fen_id');
        $fen_nome = new TEntry('fen_fenologia');
        //$fen_clt_id = new TDBCombo('fen_clt_id','webrural','Cultura','clt_id','clt_nome');
        
        // add the fields
        $this->form->addFields( [new TLabel('Id')], [$fen_id] );
        $this->form->addFields( [new TLabel('Name')], [$fen_nome] );
        //$this->form->addFields( [new TLabel('Cultura')], [$fen_clt_id] );

        $fen_id->setEditable(FALSE);
        $fen_id->setSize('20%');
        $fen_nome->setSize('50%');
        //$fen_clt_id->setSize('50%');
        //$name->addValidation( _t('Name'), new TRequiredValidator );
        
        // create the form actions
        $this->form->addAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:floppy-o');
        $this->form->addAction(_t('New'),  new TAction(array($this, 'onEdit')), 'fa:eraser red');
        $this->form->addAction(_t('Back to the listing'),new TAction(array('ExperimentoList','onReload')),'fa:table blue');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        $container->add(new TXMLBreadCrumb('menu.xml', 'ExperimentoList'));
        $container->add($this->form);
        
        parent::add($container);
    }

}
