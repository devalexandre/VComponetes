<?php



class PProduto{
	
	private $id;
	private $nome;
	private $descricao;
	private $preco;
	private $qtd;
	private $peso;
	
	
	/**
	 * Returns the nome value.
	 *
	 * @return variableType
	 */
	public function getNome() {
	    return $this->nome;
	}
	 
	/**
	 * Set the nome value.
	 *
	 * @param variableType $nome
	 */
	public function setNome($nome) {
	    $this->nome = $nome;
	}
	
	
		/**
	 * Returns the peso value.
	 *
	 * @return variableType
	 */
	public function getPeso() {
	    return (empty($this->peso)?0:$this->peso);
	}
	 
	/**
	 * Set the peso value.
	 *
	 * @param variableType $peso
	 */
	public function setPeso($peso) {
	    $this->peso = $peso;
	}
	
	
	/**
	 * Returns the descricao value.
	 *
	 * @return variableType
	 */
	public function getDescricao() {
	    return $this->descricao;
	}
	 
	/**
	 * Set the descricao value.
	 *
	 * @param variableType $descricao
	 */
	public function setDescricao($descricao) {
	    $this->descricao = $descricao;
	}
	
	
/**
 * Returns the preco value.
 *
 * @return variableType
 */
public function getPreco() {
    return $this->preco;
}
 
/**
 * Set the preco value.
 *
 * @param variableType $preco
 */
public function setPreco($preco) {
    $this->preco = $preco;
}

	
	/**
	 * Returns the qtd value.
	 *
	 * @return variableType
	 */
	public function getQtd() {
	    return $this->qtd;
	}
	 
	/**
	 * Set the qtd value.
	 *
	 * @param variableType $qtd
	 */
	public function setQtd($qtd) {
	    $this->qtd = $qtd;
	}
	
	/**
	 * Returns the id value.
	 *
	 * @return variableType
	 */
	public function getId() {
	    return $this->id;
	}
	 
	/**
	 * Set the id value.
	 *
	 * @param variableType $id
	 */
	public function setId($id) {
	    $this->id = $id;
	}
	
}