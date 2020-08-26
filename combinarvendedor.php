<?php

include ('app.php');
global $INI;
define("ASSUNTO_COMBINAR_VENDEDOR", "Combinar com vendedor");

/* É verificado se as informações enviadas pelo cliente foram recebidas corretamente. */
if(isset($_POST["idpedido"]) and isset($_POST["nome"]) and isset($_POST["email"]) and isset($_POST["telefone"]) and isset($_POST["proposta"]))
{
	$idpedido = strip_tags($_POST["idpedido"]);
	$nome = strip_tags($_POST["nome"]);
	$email = strip_tags($_POST["email"]);
	$telefone = strip_tags($_POST["telefone"]);
	$proposta = strip_tags($_POST["proposta"]);
	$data = date("Y-m-d H:i:s");
	
	$order = Table::Fetch('order', $idpedido);
	$user = Table::Fetch('user', $order['partner_id']);
	$sql = "select team_id from order_team where order_id = '" . $idpedido . "'";
	$rs = mysql_query($sql);
	$order_team = mysql_fetch_assoc($rs);
	
	/* Primeiramente os dados são gravados no banco de dados, e depois enviados via email para o vendedor. */
	$sql = "insert into feedback(user_id, contact, content, create_time, team_id, order_id) values('" . $order['partner_id'] . "', '" . $telefone . "', '" . $proposta . "', '" . $data . "', '" . $order_team['team_id'] . "', '" . $idpedido . "')";
	$rs = mysql_query($sql);
	
	/* A tabela order é atualizada com a forma de pagamento escolhida pelo cliente. */
	$sql = "UPDATE `order` SET `service` = 'Combinar com vendedor', statusliberacao = 'A combinar cliente e vendedor' WHERE id = " . $idpedido;
	$rs = mysql_query($sql);

	$parametros = array('idpedido' => $idpedido, 'nome' => $nome, 'email' => $email, 'telefone' => $telefone, 'proposta' => $proposta);
	$request_params = array(
		'http' => array(
			'method'  => 'POST',
			'header'  => implode("\r\n", array(
				'Content-Type: application/x-www-form-urlencoded',
				'Content-Length: ' . strlen(http_build_query($parametros)),
			)),
			'content' => http_build_query($parametros),
		)
	);
	
	$request  = stream_context_create($request_params);
	$arquivotemplate = "combinar_vendedor.php"; 
	 
	//envia email para o vendedor com informações enviadas pelo cliente. 
	 $mensagem = file_get_contents($INI["system"]["wwwprefix"]."/templates/".$arquivotemplate, false, $request);
	 enviar($user['email'], ASSUNTO_COMBINAR_VENDEDOR, $mensagem);
}
else 
{
	return false;
}

?>