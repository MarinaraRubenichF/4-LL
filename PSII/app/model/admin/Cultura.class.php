<?php
/**
 * System_group Active Record
 * @author  <your-name-here>
 */
class Cultura extends TRecord
{
    const TABLENAME = 'cultura';
    const PRIMARYKEY= 'clt_id';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('clt_nome');
    }
}