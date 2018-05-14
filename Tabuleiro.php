<?php

class Tabuleiro{

	private $situacaoJogo;//boolean
	private $jogadores;//array
	private $posicoesDisponiveis = array(1,2,3,4,5,6,7,8,9);//array
	private $posicoesVencedoras = array(
										array('1','2', '3'),
										array('4','5', '6'),
										array('7','8', '9'),
										array('1','4', '7'),
										array('2','5', '8'),
										array('3','6', '9'),
										array('1','5', '9'),
										array('3','5', '7')
								  );//array


	private function setJogadores($jogador1, $jogador2){
		$this->jogadores[0] = $jogador1;
		$this->jogadores[1] = $jogador2;

		$this->jogadores[0]->setSimbolo('x');
		$this->jogadores[1]->setSimbolo('0');
	}

	private function getJogadores(){
		return $this->jogadores;
	}

	public function escolheJogadorIniciar(){
		$e = (boolean)rand(0,1);
		$this->getJogadores()[0]->setMinhaVez($e);
		$this->getJogadores()[1]->setMinhaVez(!$e);
	}

	public function getSituacaoJogo()
	{
	    return $this->situacaoJogo;
	}
	
	public function setSituacaoJogo($situacaoJogo)
	{
	    $this->situacaoJogo = $situacaoJogo;
	}

	public function getPosicoesVencedoras(){
		return $this->posicoesVencedoras;
	}

	public function getPosicoesDisponiveis()
	{
	    return $this->posicoesDisponiveis;
	}

	public function setPosicoesDisponiveis($posicoes)
	{
	    return $this->posicoesDisponiveis = $posicoes;
	}

	public function removerItemPosicoesDisponiveis($item){
		$posicoes = array_diff( $this->getPosicoesDisponiveis() , array($item));
		$this->setPosicoesDisponiveis($posicoes);
	}

	public function iniciarJogo(&$jogador1, &$jogador2){
		//Setar Jogadores
		$this->setJogadores($jogador1, $jogador2);
		//Escolhe quem começará o jogo
		$this->escolheJogadorIniciar();
		//Iniciar jogo
		$this->setSituacaoJogo(true);

		$this->quemDeveJogar();
	}

	public function mudaVezJogador(){
		if( $this->jogadores[0]->getMinhaVez() )
		{
			$this->jogadores[0]->setMinhaVez(false);
			$this->jogadores[1]->setMinhaVez(true);
		}
		else
		{
			$this->jogadores[0]->setMinhaVez(true);
			$this->jogadores[1]->setMinhaVez(false);
		}
	}

	//Verifica os dois quem ganhou (true) ou apenas o último que jogou (false)
	public function verificaVencedor($ultimoJogador = false){
		if( !$ultimoJogador )
		{
			$jogador = $this->jogadorVez();
			$jogadasVencedoras = $this->getPosicoesVencedoras();
			if(count( $jogador->getMinhasPosicoes() ) < 3) return false;

			$jogadas = $jogador->getMinhasPosicoes();
			for($i = 0 ; $i < 8 ; $i++){
				//echo "I={$i}<br>";
				for($j = 0 ; $j < 3 ; $j++){
					//echo "J={$j}<br>";
					if( !in_array( $jogadasVencedoras[$i][$j], $jogadas ) ){
						//echo "Continue - I={$i} - J={$j}";
						$j = 3;
					}
					elseif( $j == 2 )
						return $jogador;

				}
			}
			return false;
		}

	}

	public function jogadorVez(){
		if( $this->jogadores[0]->getMinhaVez() == true )
			return $this->jogadores[0];
		return $this->jogadores[1];
	}

	public function quemDeveJogar(){
		$nome = $this->jogadorVez()->getNome();

		$this->mensagem("Jogador " .$nome. " é a sua vez!<br>Qual a posição? (".implode(" | ", $this->getPosicoesDisponiveis()).")" );
	}

	public function jogar(&$jogador, $posicao){
		//Verifica se o jogo já foi encerrado ou está ativo!
		if( $this->getSituacaoJogo() != true )
		{
			$this->mensagem("O jogo já foi encerrado!");
			return false;
		}

		if( $jogador->getMinhaVez() == false )
		{
			$this->mensagem("Não é a sua vez!");
			$this->quemDeveJogar();
		}
		else
		{
			if( $this->verificaPosicaoDisponivel($posicao) )
			{
				$this->mensagem("{$jogador->getNome()} você jogou na posição {$posicao}");
				$this->removerItemPosicoesDisponiveis($posicao);
				$jogador->setMinhasPosicoes($posicao);
				$this->mensagem("Posições disponíveis: "
					.implode(" | ", $this->getPosicoesDisponiveis()));

				if( $this->verificaVencedor() === false){
					if( count($this->getPosicoesDisponiveis()) )
						$this->mudaVezJogador();
					else
						$this->setSituacaoJogo(false);
				}
				else{
					$this->mensagem("TEMOS UM VENCEDOR!");
					$this->mensagem("{$this->verificaVencedor()->getNome()}, parabéns, você é o vencedor!<br>"
						.implode(" | ", $this->verificaVencedor()->getMinhasPosicoes()));
					$this->encerrarJogo(false);
					//Como já temos um jogador vencedor então encerramos o jogo
				}
				
			}
			else
			{
				$this->mensagem("{$jogador->getNome()} você jogou na posição {$posicao} e ela não está disponível.");
				$this->quemDeveJogar();
			}
		}
		$this->grafico();
	}

	public function verificaPosicaoDisponivel($posicao){
		if( in_array($posicao, $this->getPosicoesDisponiveis()) )
			return true;
		return false;
	}

	public function encerrarJogo(){
		$this->setSituacaoJogo(false);
	}

	public function mensagem($msg){
		echo "<p>{$msg}<p>";
	}

	public function grafico(){
		echo "<div style='padding:10px;border: 1px solid #AAA;background:#333;color:#FFF;width:120px;text-align:center;'>
				Jogo da Velha
			</div>";
		echo "<div style='padding:10px;border: 1px solid #AAA;background:#EEE;width:120px;text-align:center;'>";
		for( $i = 1;$i <= 9;$i++ ){

			if( !in_array( $i, $this->getPosicoesDisponiveis() ) )
			{
				if( in_array( $i, $this->getJogadores()[0]->getMinhasPosicoes() ) )
				{
					echo $this->getJogadores()[0]->getSimbolo();
					if(($i % 3) != 0)
						echo "&nbsp;|&nbsp;";
					elseif($i != 9) echo "<br>----------<br>";
				}
				else
				{
					echo $this->getJogadores()[1]->getSimbolo();
					if(($i % 3) != 0)
						echo "&nbsp;|&nbsp;";
					elseif($i != 9) echo "<br>----------<br>";
				}
			}
			else
			{
				if(($i % 3) != 0)
						echo "&nbsp;&nbsp;&nbsp;|&nbsp;";
					elseif($i != 9) echo "<br>----------<br>";
			}

		}
		echo "</div>";
	}
}