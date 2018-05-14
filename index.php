<?php
	ini_set('display_errors',1);
	ini_set('display_startup_erros',1);
	error_reporting(E_ALL);

	require_once "Jogador.php";
	require_once "Tabuleiro.php";

	$jogador[0] = new Jogador("David Silveira");
	$jogador[1] = new Jogador("Saulo Araujo");

	$jogo = new Tabuleiro;
	$jogo->iniciarJogo($jogador[0], $jogador[1]);
	$j = 0;
	while ( ($jogo->getSituacaoJogo() == true) and $j < 1000 ) {
		$n = rand(1,9);
		$jogo->jogar($jogador[ $j%2 ], $n);
		$j++;
	}
	/*
	$jogo->jogar($jogador1, 1);
	$jogo->jogar($jogador2, 2);
	$jogo->jogar($jogador1, 9);
	$jogo->jogar($jogador2, 8);
	$jogo->jogar($jogador1, 3);
	$jogo->jogar($jogador2, 4);
	$jogo->jogar($jogador1, 7);
	$jogo->jogar($jogador2, 5);
	*/
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

</body>
</html>