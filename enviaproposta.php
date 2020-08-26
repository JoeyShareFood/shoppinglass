<?php

require_once "./app.php";
 
$idpedido = strip_tags(strval($_REQUEST['idpedido']));
$nome = strip_tags(strval($_REQUEST['nome'])); 
$email = strip_tags(strval($_REQUEST['email']));
$telefone = strip_tags(strval($_REQUEST['telefone']));
$proposta = strip_tags(strval($_REQUEST['proposta']));
$order  = Table::Fetch('order', $idpedido);


$user_id = $order['partner_id'];
$user  = Table::Fetch('user',$user_id);
	  
if ($_POST) { 
	session_start(); 

	if ($_POST['captcha'] == $_SESSION['cap_code']) {
		  // Captcha CORRETO
	} else { 
			echo  utf8_encode("O código da imagem está errado.");
			exit;
	} 
	$dominio = getDomino($email);
	
	if(!checkdnsrr ($dominio)){
			echo  utf8_encode("Por favor, informe um email válido");
			exit;
	}
	
	$city_id=0;
 
	$parametros = array('idpedido' => $idpedido, 'nome' => $nome, 'email' => $email, 'telefone' => $telefone,'proposta' => $proposta);
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
	$mensagem = file_get_contents($INI["system"]["wwwprefix"]."/templates/envioproposta.php", false, $request);
 
	if(enviar($user['email'], "Contato",utf8_decode($mensagem))){
			$enviado=true;
	}

	$mensagem="";
	unset($mensagem);
	
	$data = date("Y-m-d H:i:s");
  
	$insert = array(
		'idpedido', 'nome', 'email', 'ddd_proposta',
		'telefone', 'proposta', 'data', 'user_id', 
	);
	
	$propostas = $_POST;
	
	$propostas['data'] = $data;
	$propostas['user_id'] = $order['partner_id'];
	
	/* Mesmo que o envio de proposta por email falhe, a mensagem é gravada no banco de dados. */
	$table = new Table('propostas', $propostas);
	$table->insert($insert);
	
	if (!$enviado ) {
		echo utf8_encode("Sua proposta não foi enviada por email, você pode tentar entrar em contato com o anunciante pelo email ".$user['contact']) ;	
	}
	else {
		echo utf8_encode("<img src='" . $PATHSKIN . "/images/correct.png' style='max-width:20px; margin-top:'> Sua proposta foi enviada por email! ".mysql_error()) ;
	}
}