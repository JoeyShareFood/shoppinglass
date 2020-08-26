<?php

include "../app.php";  

if($_REQUEST['acao']=='verifica_regras_pre_compra'){
	$error =  verifica_regras_pre_compra();
	echo trim($error);
}

if($_REQUEST['acao']=='calculafrete'){
	echo fretecarrinho(RemoveXSS($_REQUEST['cep_destino']),RemoveXSS($_REQUEST["modo"]));	
}
if($_REQUEST['acao']=='logStatusEntrega'){
	echo logStatusEntrega(RemoveXSS($_REQUEST['id']));	
}
if($_REQUEST['acao']=='consultavalecompras'){
	echo consultavalecompras(RemoveXSS($_REQUEST['codigo']));	
}
if($_REQUEST['acao']=='gravatrack'){
	$error =  gravatrack(RemoveXSS($_REQUEST['code']),RemoveXSS($_REQUEST['id']));
	echo trim($error);
	
}
if($_REQUEST['acao']=='avalia_produto'){
	$error =  avalia_produto(RemoveXSS($_REQUEST['team_id']),RemoveXSS($_REQUEST['notaavaliacao']),RemoveXSS($_REQUEST['title']),RemoveXSS(utf8_encode($_REQUEST['text'])),RemoveXSS($_REQUEST['user_id']));
	echo trim($error);
	
}
if($_REQUEST['acao']=='question_product'){
	$error =  question_product(RemoveXSS($_REQUEST['team_id']), RemoveXSS($_REQUEST['title']), RemoveXSS($_REQUEST['text']), RemoveXSS($_REQUEST['user_id']), RemoveXSS($_REQUEST['partner_id']));
	echo trim($error);	
}
if($_REQUEST['acao']=='qualification_order'){
	$error = qualification_order(RemoveXSS($_REQUEST['concretion']), RemoveXSS($_REQUEST['productId']), RemoveXSS($_REQUEST['seller']), RemoveXSS($_REQUEST['text']), RemoveXSS($_REQUEST['title']), RemoveXSS($_REQUEST['user']), RemoveXSS($_REQUEST['orderId']), RemoveXSS($_REQUEST['nota']));
	echo trim($error);	
}
if($_REQUEST['acao']=='get_id_rand'){ 
	$rand = rand(10000, 99999999);
	echo $rand ;
}
if($_REQUEST['acao']=='emailcontato'){ 
	$res = emailcontato();
	echo $res;

}
if($_REQUEST['acao']=='retorno_pagamento_moiptrans'){ 
	
	$data= date("d/m/Y");
	if(strtolower($_REQUEST['status_pagamento']=="autorizado")){ 
		envia_cupons(RemoveXSS($_REQUEST['idpedido']),RemoveXSS($_REQUEST['valor']),RemoveXSS($_REQUEST['idtransacao']),RemoveXSS($_REQUEST['gateway']),RemoveXSS($_REQUEST['status_pagamento']),$data);
	}
	else{  
		$moneytratado = str_replace(",",".",RemoveXSS($_REQUEST['valor']));
		
		$sql2 	= "update `order`  set pay_id = '". RemoveXSS($_REQUEST['idtransacao'])."',money = ". $moneytratado.",retorno_automatico = 'sim',service = '". RemoveXSS($_REQUEST['service'])."',msg_retorno_pagamento = '". RemoveXSS($_REQUEST['status_pagamento'])."', pay_time = ". time(). " where id=".RemoveXSS($_REQUEST['idpedido']);
		$flag 	= mysql_query($sql2);
				
		if(!$flag){
				echo "Erro ao atualizar os dados. ".mysql_error() ;
		}
	}
} 

if($_REQUEST['acao']=='pegadata'){ 
	echo date("d/m/Y H:i:s");
} 
?>