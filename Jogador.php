<?php

class Jogador{
	private $nome;//string
	private $minhaVez;//boolean
	private $minhasPosicoes = array();//array
	private $simbolo;//string

	public function __construct($nome){
		$this->setNome($nome);
	}

	public function getNome()
	{
	    return $this->nome;
	}
	
	public function setNome($nome)
	{
	    $this->nome = $nome;
	}

	public function getSimbolo()
	{
	    return $this->simbolo;
	}
	
	public function setSimbolo($simbolo)
	{
	    $this->simbolo = $simbolo;
	}

	public function getMinhaVez()
	{
	    return $this->minhaVez;
	}
	
	public function setMinhaVez($minhaVez)
	{
	    $this->minhaVez = $minhaVez;
	}

	public function getMinhasPosicoes()
	{
	    return $this->minhasPosicoes;
	}
	
	public function setMinhasPosicoes($minhasposicoes)
	{
	    $this->minhasPosicoes[] = $minhasposicoes;
	}

	//public function jogar(){

	//}
}