<?php
/**
 * System_group Active Record
 * @author  <your-name-here>
 */
class Bloco extends TRecord
{
    const TABLENAME = 'bloco';
    const PRIMARYKEY= 'blc_id';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('blc_nome');
    }
}