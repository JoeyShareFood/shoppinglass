<?php
 
 global $ROOTPATH;
 global $INI;

 if($RetornoPagamento->status_transacao == STATUS_APROVADO){
    
   
	$strSQL = "SELECT * FROM order_team WHERE order_id = " . $RetornoPagamento->idPedido;
	$objRs = mysql_query($strSQL);
	
	 while($row = mysql_fetch_array($objRs)){  
	  $update = "update team set max_number = (max_number - ".$row['team_qty'].") where id = ".$row['team_id'];
	  $rs = mysql_query($update);
	  Util::log($update);
	 }
	 
	$sql2 	= "update `order` set msg_retorno_pagamento = 'Aprovado' where id=".$RetornoPagamento->idPedido;
	$flag 	= mysql_query($sql2);
	if(!$flag){
			Util::log($RetornoPagamento->idPedido. " - erro na atualizacao do msg_retorno_pagamento. $sql2 ".mysql_error());
	}
		 
		
	Util::log($RetornoPagamento->idPedido." - Status aprovado. Preparando para atualizar tabela de pedidos.");
	Util::log($RetornoPagamento->idPedido. " - Verificando a existencia do pedido...");
	
	/***************************** TRATAMENTO DE SERVICO E CREDITO ****************************************/
	if($RetornoPagamento->pedido_inexistente){
		Util::log($RetornoPagamento->idPedido. " - Pedido nao foi localizado nos registros de pedidos.");
		Util::log($RetornoPagamento->idPedido. " - Verificando o pagamento de credito.");
		$codusuario = explode("-",$RetornoPagamento->idPedido);
		$flag  		= $codusuario[0];
		$codusuario = explode("-",$codusuario[1]);
		$userid 	= explode("-",$codusuario[0]);
		$userid 	= $userid[0];
		Util::log($RetornoPagamento->idPedido. " - flag: $flag");
		 
		if( trim($flag) == "charge"){
			Util::log($RetornoPagamento->idPedido. " - compra de credito. Atualizando os creditos do usuario: (".$RetornoPagamento->getTotalPago().") para usuario id $userid");
			$moneytratado = str_replace(",",".",$RetornoPagamento->getTotalPago());
			$sql2 = "update user set money = money + ".$moneytratado." where id = '".$userid."'";
			$rs2 = mysql_query($sql2);
			if($rs2){
				Util::log($RetornoPagamento->idPedido. " - credito atualizado com sucesso.");
			}
			else{
				Util::log($RetornoPagamento->idPedido. " - erro na atualizacao do credito. $sql2 ".mysql_error());
			}
			$time = time();
			$sql2 	= "insert into flow (user_id,admin_id,detail_id,direction,money,action,create_time) values ('".$userid."','0','11','income','".$RetornoPagamento->getTotalPago()."','buy',$time)";
			$rs2 	= mysql_query($sql2);
			
			if($rs2){
				Util::log($RetornoPagamento->idPedido. " - fluxo atualizado com sucesso.");
			}
			else{
				Util::log($RetornoPagamento->idPedido. " - erro na atualizacao do fluxo. $sql2 : ".mysql_error());
			}
			header("Location: ".$ROOTPATH."/index.php");	
			?> 
			<meta http-equiv="refresh" content="0; url=<?=$ROOTPATH?>?pg=true"><?
			 exit;
		}  
		
		$body.=	$RetornoPagamento->getDadosTransacaoBasico(); 
		if(Util::postemail($body, $RetornoPagamento->nomesite. " - Pedido ".$RetornoPagamento->idPedido." ".$RetornoPagamento->status_transacao)){
			Util::log($RetornoPagamento->idPedido. " - Email enviado para (".Util::getFrom().")... Retornando para a loja ");
		}
		else{
			 Util::log($RetornoPagamento->idPedido. " - Erro no envio do email (".Util::getFrom().")... Retornando para a loja ");
		} 
	}
	else{
		Util::log($RetornoPagamento->idPedido. " - Pedido encontrado. Verificando status do pagamento.");
	}
	/***************************** INICIO DA ATUALIZACAO DO PEDIDO NO SITE ****************************************/
	if($RetornoPagamento->status_pedido_site == 'unpay'){
		Util::log($RetornoPagamento->idPedido. " - Pedido encontrado com status nao pago. Preparando para atualizar...");
		
		$table = new Table('order');
		$table->SetPk('id', $RetornoPagamento->idPedido);
		$table->pay_id 	= $RetornoPagamento->idtransacao;
		$table->money = $RetornoPagamento->getTotalPago();
		$table->retorno_automatico = "sim";
		$table->state = 'pay';
		$table->service	= $RetornoPagamento->gateway;
		$table->pay_time = time();
		$flag = $table->update(array('state', 'pay_id', 'money','service','pay_time','retorno_automatico'));
		
		
		if ($flag >= 1) {
			Util::log($RetornoPagamento->idPedido. " - Pedido atualizado para pago com sucesso. Preparando para inserir o registro na tabela de pagamento.");
			grava_status_entrega("Pedido alterado para pago com sucesso via retorno automatico ". $RetornoPagamento->gateway, $RetornoPagamento->idPedido);
			
			$table = new Table('pay');
			$table->id = $RetornoPagamento->idtransacao;
			$table->order_id = $RetornoPagamento->idPedido;
			$table->money = $RetornoPagamento->getTotalPago();
			$table->currency = 'BRL';
			$table->bank = $RetornoPagamento->tipo_pagamento; 
			$table->service =  $RetornoPagamento->gateway;
			$table->create_time = time();
			$table->insert( array('id', 'order_id', 'money', 'currency', 'service', 'create_time', 'bank') );
			
			Util::log($RetornoPagamento->idPedido. " - Registro inserido na tabela de pagamento com sucesso. Verificando se este site gera pontos para o usuario ...");
			$order 	 = Table::Fetch('order',$RetornoPagamento->idPedido);
			
			/* Email é enviado para o vendedor informando que o pagamento de sua venda foi efetuado, e o valor se encontra com o administrador do site. */
			$user = Table::Fetch('user', $order['user_id']);

			$parametros = array('id' => $order['id']);
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
			$body = file_get_contents($ROOTPATH."/templates/pagamento_aprovado_vendedor.php", false, $request);

			if(Util::postemailCliente($body, $RetornoPagamento->nomesite . " - Pagamento aprovado", $user['email'])){
				Util::log($id. " - email_pagamento_aprovado - Email para o vendedor enviado com sucesso ".$user['email']);  
			}
			else{
				Util::log($id. " - email_pagamento_aprovado - Erro no envio do email para ".$user['email']);  
			}		
			
			$pts = 3;
			UpdatePoints($pts, $order['partner_id']);
  
			$order = Table::FetchForce('order', $order['id']);
			$team = Table::FetchForce('team', $order['team_id']); 
		 
			if($INI['option']['pontuacao']=="Y"){
			
				$pontosganhos = (int)$team['pontosgerados']; 
				$sql = "update user set score = score  + ".$pontosganhos." where id =".$order['user_id'];
				$rs =  mysql_query($sql);  
				
				Util::log($RetornoPagamento->idPedido. " - Este pagamento gerou $pontosganhos para este usuario. Preparando para buscar os dados para envio do cupom ...");
		 	}
		  
			Util::log($RetornoPagamento->idPedido. " - Preparando para enviar o email de compra concluida para o cliente (".$RetornoPagamento->email_site.")...");
			
			$ret = envia_email_confirmacao_pagamento($RetornoPagamento->idPedido);
			
			if($ret){
				Util::log($RetornoPagamento->idPedido. " - Email enviado com sucesso para (".$RetornoPagamento->email_site.")...Preparando para enviar o email para o administrador");
			}
			else{
				Util::log($RetornoPagamento->idPedido. " - Email nao enviado para (".$RetornoPagamento->email_site.")...Preparando para enviar o email para o administrador");
			 }
			 
			$body =  "O pedido numero ".$RetornoPagamento->idPedido." acaba de ser aprovado e o status desta compra ja foi atualizado para pago na loja virtual. <br>";
			$body.=	$RetornoPagamento->getDadosTransacao();
				 
			if(Util::postemail($body, $RetornoPagamento->nomesite. " - Pedido ".$RetornoPagamento->idPedido." ".$RetornoPagamento->status_transacao)){
				Util::log($RetornoPagamento->idPedido. " - Email para o administrador enviado com sucesso. Retornando para a loja");
			}
			else{
				Util::log($RetornoPagamento->idPedido. " - Erro no envio do email (".Util::getFrom().")... Retornando para a loja ");
			}
		}
		else{
			Util::log($RetornoPagamento->idPedido. " - Nao foi possivel atualizar a tabela order com os dados do pedido ".$RetornoPagamento->idPedido.". Retornando para a loja.",true);
		}
	}
	else if ( $RetornoPagamento->status_pedido_site == 'pay' ) {
		Util::log($RetornoPagamento->idPedido. " - Pedido ja estava com status de pago no banco de dados. Retornando para a loja.");
	}
	Utility::Redirect( WEB_ROOT );	
}
else { 
	
	if(strtolower($RetornoPagamento->status_transacao) == STATUS_DEVOLVIDO){
		
		Util::log($RetornoPagamento->idPedido. " - preparando para atualizar o status de pagamento para unpay na tabela order ");
		$table = new Table('order');
		$table->SetPk('id', $RetornoPagamento->idPedido);  
		$table->state = 'devolvido';
		$flag = $table->update(array('state', 'pay_id'));
		if($flag){
				Util::log($RetornoPagamento->idPedido. " - status atualizado com sucesso.");
		}
		Util::log($RetornoPagamento->idPedido. " - preparando para excluir o registro de pagamento na tabela pay");
		$sql = "delete from pay where order_id = ".$RetornoPagamento->idPedido;
		$flag2 = mysql_query($sql);
		if($flag2){
				Util::log($RetornoPagamento->idPedido. " - dados pay excluidos com sucesso.");
		}
		$sql = "delete from coupon where order_id = ".$RetornoPagamento->idPedido;
		$flag2 = mysql_query($sql);
		if($flag2){
				Util::log($RetornoPagamento->idPedido. " - dados cupons excluidos com sucesso.");
		} 
	}		
	if(strtolower($RetornoPagamento->status_transacao) != STATUS_COMPLETO){
		$body = $RetornoPagamento->getDadosTransacaoBasico(); 
		if(Util::postemail($body, $RetornoPagamento->nomesite. " - Pedido ".$RetornoPagamento->idPedido." ".$RetornoPagamento->status_transacao)){
			Util::log($RetornoPagamento->idPedido. " - Email enviado para (".Util::getFrom().")... Retornando para a loja ");
		}
		else{
			 Util::log($RetornoPagamento->idPedido. " - Erro no envio do email (".Util::getFrom().")... Retornando para a loja ");
		}
		/*
		if(Util::postemailCliente($body,$RetornoPagamento->nomesite. " - ".$RetornoPagamento->status_transacao,$RetornoPagamento->email_gateway)){
				Util::log($RetornoPagamento->idPedido. " - Email enviado para o cliente com sucesso...".$RetornoPagamento->email_gateway);
		}
		else{
			Util::log($RetornoPagamento->idPedido. " - Erro no envio do email para o cliente(".$RetornoPagamento->email_gateway.")");
		}
		*/
	} 
}
	
?>