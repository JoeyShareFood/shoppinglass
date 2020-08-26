<?php
  
 if($RetornoPagamento->status_transacao == STATUS_APROVADO){ 
	Util::log($RetornoPagamento->idPedido . " - Verificando a existencia da fatura...");
	
	/***************************** TRATAMENTO DE SERVICO E CREDITO ****************************************/
	unset($billing);
	$billing = Table::Fetch('faturas', $RetornoPagamento->idPedido);
		
	if(empty($billing['id'])){
		Util::log($RetornoPagamento->idPedido . " - Fatura não foi localizado nos registros. Parando retorno.");  
		exit;
	}
	else{
		Util::log($RetornoPagamento->idPedido. " - Fatura " . $RetornoPagamento->idPedido . " encontrada. Verificando status..");
	} 
	
	/***************************** INICIO DA ATUALIZACAO DO ANUNCIO NO SITE ****************************************/
	 
	if(empty($billing['status']) or $billing['status'] == "unpay"){  
		Util::log($RetornoPagamento->idPedido. " - Fatura encontrada com status nao pago. Preparando para atualizar...");
		$RetornoPagamento->idPedido = $billing['id'];
		
		$data_pagamento = date("Y-m-d H:i:s");
		  
		Util::log($RetornoPagamento->idPedido . " - Atualizando a tabela fatura com status aprovado para id $RetornoPagamento->idPedido ");
		$valor_unitario = str_replace(",", ".", $RetornoPagamento->valor_unitario);
		$sql =	"update faturas set status = 'pay', data_pagamento = '" . $data_pagamento . "' where id = '" . $RetornoPagamento->idPedido . "'";
		$rs = @mysql_query($sql);
		if($rs){
			Util::log($RetornoPagamento->idPedido . " - atualizacao faturas feita com sucesso");
			
			/* Envia o email ao administrador notificando o mesmo sobre o pagamento da fatura. */
			$parametros = array('id' => $RetornoPagamento->idPedido);
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
			$mensagem = file_get_contents($INI["system"]["wwwprefix"]."/templates/confirmacao_pagamento_fatura.php", false, $request);
		}
		else{
			Util::log($RetornoPagamento->idPedido . " - Nao foi possivel atualizar faturas $sql ".mysql_error());
		}
	}
	else   { // aprovado == sim
		Util::log($RetornoPagamento->idPedido. " - Fatura ja estava com status de pago no banco de dados. ". $billing['status'] . " saindo...");
	}
	 
	Utility::Redirect( WEB_ROOT );	
} 
	
?>