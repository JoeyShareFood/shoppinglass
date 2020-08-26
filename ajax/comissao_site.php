<?php

include ('../app.php');
global $INI;

/* É verificado se todas as informações foram recebidos corretamente. */
if(isset($_POST["filtro"]) and isset($_POST["valor"])) {

	unset($comissao);
	$filtro = strip_tags($_POST["filtro"]);
	
	/* Caso o filtro seja para calcular o valor da comissão. */
	if($filtro == "comissao") {
		
		$valor = strip_tags($_POST["valor"]);
		$valor = str_replace($currency, "", str_replace(",", ".", str_replace(".", "", $valor)));
		$id_user = (int) strip_tags($_POST["usuario"]);
		
		/* É efetuado uma busca na tabela user para verificar se o usuário possui
		   alguma comissão além da comissão geral do site.
		*/
		$user = Table::Fetch('user', $id_user);
		
		if(!(empty($user["comissao"])) || $user["comissao"] != 0) {
			$comissao = (int) $user["comissao"];
		}
		else {
			$comissao = $INI["system"]["comissao"];
		}
		
		/* Valor da comissão é calculado e retornado um alerta ao usuário. */
		$comissaosite = ($valor * $comissao) / 100;
		echo "R$" . number_format($comissaosite, 2, ",", ".");
	}
	if($filtro == "seguro") {
		$valor = str_replace($currency, "", str_replace(",", ".", str_replace(".", "", strip_tags($_POST["valor"]))));	
		$valor_n = $valor - 50;			
		echo "R$ " . number_format(($valor_n * 1) / 100, 2, ",", ".");
	}
}

?>