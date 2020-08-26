<?php

need_login();

if(isset($_GET["action"]) and $_GET["action"] == "liberarpagamento") {

	/* Caso entre nesta condiçao, o pagamento do pedido em questao e liberado 
	ao vendedor */
	
	if(isset($_GET["idpedido"])) {
	
		$id = (int) strip_tags($_GET["idpedido"]);
		$sql = "UPDATE `order` SET `statusliberacao` = 'Pagamento liberado pelo cliente' WHERE `order`.`id` = " . $id;
		$rs = mysql_query($sql);
		$row = mysql_affected_rows();
		
		if($row >= 1) {

			echo "<img scr='" . $PATHSKIN . "/images/info_message.png'> Dinheiro liberado com sucesso!";	
			
			/* É buscado informações do vendedor do produto em questão. */			
			$SqlPartner = "select * from user where id = " . $result['partner_id'];
			$RsPartner = mysql_query($SqlPartner);
			$RowPartner = mysql_fetch_assoc($RsPartner);
			
			/* Após a atualização, é enviado o email ao vendedor e dono do site informando da liberação do
			dinheiro por parte do cliente. */			
			$parametros = array( 'realname' => $login_user['realname'], 'id' => $id,
			$request_params = array(
					'http' => array(
					'method'  => 'POST',
					'header'  => implode("\r\n", array(
					'Content-Type: application/x-www-form-urlencoded',
					'Content-Length: ' . strlen(http_build_query($parametros)),
				)),
				'content' => http_build_query($parametros),
				))
			);

		$request  = stream_context_create($request_params);
		$emailadmin = $INI['mail']['from'];
		$arquivotemplate = "confirmacao_liberacao_pagamento.php"; 
		$assunto = utf8_decode("Vendeu! Uhuu");
		$emailadmin = $INI['mail']['from'];
 
		//envia email para cliente 
 		$mensagem = file_get_contents($INI["system"]["wwwprefix"]."/templates/". $arquivotemplate, false, $request);
 		enviar($login_user['email'], $assunto, $mensagem);
 		grava_status_entrega("Email de pedido realizado enviado para ". $RowPartner['email'],$id); 

		// envia o mesmo email para o administrador
		$bodyadmin="----------  CÓPIA DE EMAIL ENVIADA PARA O ADMINISTRADOR ----------<BR>";
		$mensagem =  $bodyadmin.$mensagem;
		enviar($emailadmin, $assunto, $mensagem);
		grava_status_entrega("Cópia do email enviado para administrador ". $emailadm, $id); 
									
		} else {
			
			/* Caso tenha ocorrido algum erro na atualização. */			
			echo "<img scr='" . $PATHSKIN . "/images/info_message.png'>Falha ao liberar o dinheiro!";
		}
	}	
} 
	
?>