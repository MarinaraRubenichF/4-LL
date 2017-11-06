<?php
/**
 * System_group Active Record
 * @author  <your-name-here>
 */
class Local extends TRecord
{
    const TABLENAME = 'local';
    const PRIMARYKEY= 'lcl_id';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('lcl_nome');
    }
}