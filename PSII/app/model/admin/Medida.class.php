<?php
/**
 * System_group Active Record
 * @author  <your-name-here>
 */
class Medida extends TRecord
{
    const TABLENAME = 'medidas';
    const PRIMARYKEY= 'med_id';
    const IDPOLICY =  'max'; // {max, serial}

    private $experimento;
    private $fenologia;
    private $parcela;
    private $planta;
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('med_exp_id');
        parent::addAttribute('med_par_id');
        parent::addAttribute('med_blc_id');
        parent::addAttribute('med_plt_id');
        parent::addAttribute('med_alt_planta');
        parent::addAttribute('med_larg_folha');
        parent::addAttribute('med_tam_folha');
        parent::addAttribute('med_fen_id');
        parent::addAttribute('med_data');
        parent::addAttribute('med_imagem');
    }

    //Pegar nomes dos atributos de cultura e usuário a partir dos id's da tabela dos Experimentos
    public function set_experimento(Experimento $object)
    {
        $this->experimento = $object;
        $this->med_exp_id = $object->id;
    }

    public function get_experimento()
    {
        // loads the associated object
        if (empty($this->experimento))
            $this->experimento = new Experimento($this->med_exp_id);
    
        // returns the associated object
        return $this->experimento;
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

    public function set_parcela(Parcela $object)
    {
        $this->parcela = $object;
        $this->med_par_id = $object->id;
    }

    public function get_parcela()
    {
        // loads the associated object
        if (empty($this->parcela))
            $this->parcela = new Parcela($this->med_par_id);
    
        // returns the associated object
        return $this->parcela;
    }

    public function set_planta(Planta $object)
    {
        $this->planta = $object;
        $this->med_plt_id = $object->id;
    }

    public function get_planta()
    {
        // loads the associated object
        if (empty($this->planta))
            $this->planta = new Planta($this->med_plt_id);
    
        // returns the associated object
        return $this->planta;
    }

    public function set_bloco(Bloco $object)
    {
        $this->bloco = $object;
        $this->med_blc_id = $object->id;
    }

    public function get_bloco()
    {
        // loads the associated object
        if (empty($this->bloco))
            $this->bloco = new Bloco($this->med_blc_id);
    
        // returns the associated object
        return $this->bloco;
    }
}
