<?php
/**
 * System_group Active Record
 * @author  <your-name-here>
 */
class Fenologia extends TRecord
{
    const TABLENAME = 'fenologia';
    const PRIMARYKEY= 'fen_id';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
       // parent::addAttribute('fen_clt_id');
        parent::addAttribute('fen_fenologia');
    }

    //Pegar nomes dos atributos de cultura e usuário a partir dos id's da tabela dos Experimentos
    /*public function set_cultura(Cultura $object)
    {
        $this->cultura = $object;
        $this->fen_clt_id = $object->id; 
    }
    
    public function get_cultura()
    {
        // loads the associated object
        if (empty($this->cultura))
            $this->cultura = new Cultura($this->fen_clt_id);
    
        // returns the associated object
        return $this->cultura;
    }*/
}