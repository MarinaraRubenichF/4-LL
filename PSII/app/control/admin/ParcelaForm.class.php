<?php
/**
 * System_groupForm Registration
 * @author  <your name here>
 */
class ParcelaForm extends TStandardForm
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
        $this->setActiveRecord('Parcela');     // defines the active record
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_Parcela');
        $this->form->setFormTitle('Parcelas');
        
        // create the form fields
        $par_id = new TEntry('par_id');
        $par_nome = new TEntry('par_nome');
        $par_desc = new TText('par_desc');
        
        // add the fields
        $this->form->addFields( [new TLabel('Id')], [$par_id] );
        $this->form->addFields( [new TLabel('Nome')], [$par_nome] );
        $this->form->addFields( [new TLabel('Descrição')], [$par_desc] );
        
        $par_id->setEditable(FALSE);
        $par_id->setSize('20%');
        $par_nome->setSize('50%');
        $par_desc->setSize('50%');
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
