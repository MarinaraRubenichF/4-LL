<?php
/**
 * System_group Active Record
 * @author  <your-name-here>
 */
class Experimento extends TRecord
{
    const TABLENAME = 'experimentos';
    const PRIMARYKEY= 'exp_id';
    const IDPOLICY =  'max'; // {max, serial}
    
    private $cultura;
    private $nome_usuario;
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('exp_nome');   
        parent::addAttribute('exp_usr_id');
        parent::addAttribute('exp_desc');
        parent::addAttribute('exp_dt_hr');
        parent::addAttribute('exp_lcl_id');
        parent::addAttribute('exp_clt_id');
        parent::addAttribute('exp_num_lin');
        parent::addAttribute('exp_num_col');
        parent::addAttribute('exp_num_plts');
        parent::addAttribute('exp_tip_id');
        parent::addAttribute('exp_espac');
        parent::addAttribute('exp_imagem');
    }

    //Pegar nomes dos atributos de cultura e usuário a partir dos id's da tabela dos Experimentos
    public function set_cultura(Cultura $object)
    {
        $this->cultura = $object;
        $this->exp_clt_id = $object->id; 
    }
    
    public function get_cultura()
    {
        // loads the associated object
        if (empty($this->cultura))
            $this->cultura = new Cultura($this->exp_clt_id);
    
        // returns the associated object
        return $this->cultura;
    }

    public function set_nome_usuario(Usuario $object)
    {
        $this->nome_usuario = $object;
        $this->exp_usr_id = $object->id;
    }

    public function get_nome_usuario()
    {
        // loads the associated object
        if (empty($this->nome_usuario))
            $this->nome_usuario = new Usuario($this->exp_usr_id);
    
        // returns the associated object
        return $this->nome_usuario;
    }

    public function set_tipo(Tipo $object)
    {
        $this->tipo = $object;
        $this->exp_tip_id = $object->id;
    }

    public function get_tipo()
    {
        // loads the associated object
        if (empty($this->tipo))
            $this->tipo = new Tipo($this->exp_tip_id);
    
        // returns the associated object
        return $this->tipo;
    }
    
    public function set_local(Local $object)
    {
        $this->local = $object;
        $this->exp_lcl_id = $object->id; 
    }
    
    public function get_local()
    {
        // loads the associated object
        if (empty($this->local))
            $this->local = new Local($this->exp_lcl_id);
    
        // returns the associated object
        return $this->local;
    }

    public function set_fenologia(Fenologia $object)
    {
        $this->fenologia = $object;
        $this->med_fen_id = $object->id; 
    }
    
    public function get_fenologia()
    {
        // loads the associated object
        if (empty($this->fenologia))
            $this->fenologia = new Fenologia($this->med_fen_id);
    
        // returns the associated object
        return $this->fenologia;
    }

}