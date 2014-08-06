<?php




class PCliente{
	
	private $nome;
	private $mail;
	private $cep;
	private $cidade;
	private $uf;
	private $logradouro;
	private $bairro;
	private $numero;
	private $complemento;
	private $dd;
	private $telefone;
	
	
	/**
	 * Returns the nome value.
	 *
	 * @return Strin
	 */
	public function getNome() {
	    return $this->nome;
	}
	 
	/**
	 * Set the nome value.
	 *
	 * @param String $nome
	 */
	public function setNome($name) {

        $name = preg_replace('/\d/', '', $name);
        $name = preg_replace('/[\n\t\r]/', ' ', $name);
        $name = preg_replace('/\s(?=\s)/', '', $name);
        $name = trim($name);
        $name = explode(' ', $name);

        if(count($name) == 1 ) {
            $name[] = ' dos Santos';
        }
        $name = implode(' ', $name);

	    $this->nome = $name;
	}
	
	
	/**
	 * Returns the mail value.
	 *
	 * @return String
	 */
	public function getMail() {
	    return $this->mail;
	}
	 
	/**
	 * Set the mail value.
	 *
	 * @param String $mail
	 */
	public function setMail($mail) {
	    $this->mail = $mail;
	}
	
	/**
	 * Returns the cep value.
	 *
	 * @return String
	 */
	public function getCep() {
	    return $this->cep;
	}
	 
	/**
	 * Set the cep value.
	 *
	 * @param variableType $cep
	 */
	public function setCep($cep) {
	    $this->cep = $cep;
	}
	
	/**
	 * Returns the cidade value.
	 *
	 * @return variableType
	 */
	public function getCidade() {
	    return $this->cidade;
	}
	 
	/**
	 * Set the cidade value.
	 *
	 * @param variableType $cidade
	 */
	public function setCidade($cidade) {
	    $this->cidade = $cidade;
	}
	
	
	/**
	 * Returns the uf value.
	 *
	 * @return variableType
	 */
	public function getUf() {
	    return $this->uf;
	}
	 
	/**
	 * Set the uf value.
	 *
	 * @param variableType $uf
	 */
	public function setUf($uf) {
	    $this->uf = $uf;
	}
	
	/**
	 * Returns the logradouro value.
	 *
	 * @return variableType
	 */
	public function getLogradouro() {
	    return $this->logradouro;
	}
	 
	/**
	 * Set the logradouro value.
	 *
	 * @param variableType $logradouro
	 */
	public function setLogradouro($logradouro) {
	    $this->logradouro = $logradouro;
	}
	
	
	/**
	 * Returns the bairro value.
	 *
	 * @return variableType
	 */
	public function getBairro() {
	    return $this->bairro;
	}
	 
	/**
	 * Set the bairro value.
	 *
	 * @param variableType $bairro
	 */
	public function setBairro($bairro) {
	    $this->bairro = $bairro;
	}
	
	
	/**
	 * Returns the numero value.
	 *
	 * @return variableType
	 */
	public function getNumero() {
	    return $this->numero;
	}
	 
	/**
	 * Set the numero value.
	 *
	 * @param variableType $numero
	 */
	public function setNumero($numero) {
	    $this->numero = $numero;
	}
	
	
	/**
	 * Returns the complemento value.
	 *
	 * @return variableType
	 */
	public function getComplemento() {
	    return $this->complemento;
	}
	 
	/**
	 * Set the complemento value.
	 *
	 * @param variableType $complemento
	 */
	public function setComplemento($complemento) {
	    $this->complemento = $complemento;
	}
	
	/**
	 * Returns the dd value.
	 *
	 * @return variableType
	 */
	public function getDD() {
	    return $this->dd;
	}
	 
	/**
	 * Set the dd value.
	 *
	 * @param variableType $dd
	 */
	public function setDD($dd) {
	    $this->dd = $dd;
	}
	
	
	/**
	 * Returns the telefone value.
	 *
	 * @return variableType
	 */
	public function getTelefone() {
	    return $this->telefone;
	}
	 
	/**
	 * Set the telefone value.
	 *
	 * @param variableType $telefone
	 */
	public function setTelefone($telefone) {
	    $this->telefone = $telefone;
	}
	
}