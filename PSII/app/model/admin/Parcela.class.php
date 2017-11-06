<?php
/**
 * System_group Active Record
 * @author  <your-name-here>
 */
class Parcela extends TRecord
{
    const TABLENAME = 'parcelas';
    const PRIMARYKEY= 'par_id';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('par_nome');
        parent::addAttribute('par_desc');
    }
}