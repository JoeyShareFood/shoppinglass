  <?php

error_reporting(E_ALL & ~(E_NOTICE|E_WARNING));
 
/***********************************************************
www.sistemacomprascoletivas.com.br 
www.tkstore.com.br 
www.vipcomhost.com.br 
Vipcom 2012
*************************************************************/

//header('Content-Type: text/html; charset=ISO-8859-1');

require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/util/Util.php'  );
require_once(dirname(dirname(dirname(__FILE__))) . '/util/RetornoPagamento.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/templates/assuntos_emails.php'  );
  
/*+++++++++++++++++++++++++++++++++++++++++++++++*/
define('TOKEN', $INI['moip']['mid']);
define('STATUS_APROVADO', "1"); 
define('STATUS_COMPLETO', "4"); 
define('STATUS_DEVOLVIDO',"5"); 
define('STATUS_VERIFICADO',"VERIFICADO"); 
define('STATUS_FALSO',"FALSO"); 
/*++++++++++++++++++++++++++++++++++++++++++++++++*/ 
 
/*++++++++++++++++++++++++++++++++++++++++++++++++ CRIAÇÃO DO ARRAY DOS DADOS DO PAGAMENTO DO GATEWAY*/
 
 $dados_pagamento = array(
    "gateway" => 'moip', 
    "idtransacao" => $_POST['cod_moip'], 
    "idPedido" => $_POST['id_transacao'] ,  
    "email_gateway" => $_POST['email_consumidor'], 
    "status_transacao" => $_POST['status_pagamento'], 
    "tipo_pagamento" => $_POST['tipo_pagamento'],  
    "data_pagamento" => date("d/m/Y H:i:s"),  
    "valor_unitario" => $_POST['valor'],        
);
/*++++++++++++++++++++++++++++++++++++++++++++++++*/
/**************************************************/
$param = gravar_request();
function gravar_request(){	
	$parametros="";
	foreach ($_REQUEST as $nome_campo => $valor_campo) {
		$parametros .= $nome_campo . "=" . $valor_campo . "&";
  } 
   return $parametros;
}
//Util::log("Parametros:: $param");
/***************************************************/


$RetornoPagamento = new RetornoPagamento();
$RetornoPagamento->setDados($dados_pagamento);
 
 
/*+++++++++++++++++++++++++++++++++++++++++++++++++++++*/
if( $RetornoPagamento->status_transacao=="1"){
	$RetornoPagamento->descricao_status = utf8_encode("Pagamento já foi realizado porém ainda não foi creditado na Carteira MoIP recebedora (devido ao floating da forma de pagamento)");
}
else if( $RetornoPagamento->status_transacao=="2"){
	$RetornoPagamento->descricao_status = utf8_encode("Pagamento está sendo realizado ou janela do navegador foi fechada (pagamento abandonado)");
}
else if( $RetornoPagamento->status_transacao=="3"){
	$RetornoPagamento->descricao_status = utf8_encode("Boleto foi impresso e ainda não foi pago");
}
else if( $RetornoPagamento->status_transacao=="4"){
	$RetornoPagamento->descricao_status = utf8_encode("Pagamento já foi realizado e dinheiro já foi creditado na Carteira MoIP recebedora"); 
}
else if( $RetornoPagamento->status_transacao=="5"){
	$RetornoPagamento->descricao_status = utf8_encode("Pagamento foi cancelado pelo pagador, instituição de pagamento, MoIP ou recebedor antes de ser concluído"); 
}
else if( $RetornoPagamento->status_transacao=="6"){
	$RetornoPagamento->descricao_status = utf8_encode("Pagamento foi realizado com cartão de crédito e autorizado, porém está em análise pela Equipe MoIP. Não existe garantia de que será concluído"); 
}
else if( $RetornoPagamento->status_transacao=="7"){
	$RetornoPagamento->descricao_status = utf8_encode("Pagamento foi estornado pelo pagador, recebedor, instituição de pagamento ou MoIP"); 
}

Util::log($RetornoPagamento->idPedido." - ".$RetornoPagamento->descricao_status);
/*+++++++++++++++++++++++++++++++++++++++++++++++++++++-*/
 
Util::log("Gateway:: ".$RetornoPagamento->gateway);

/* DEBUG*/
//mail("atendimento@sistemacomprascoletivas.com.br","retorno de dados ".$RetornoPagamento->gateway,$RetornoPagamento->gravar_request()); 	 

 
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/ 
 
if ($dados_pagamento->status_transacao) {

	Util::log($RetornoPagamento->idPedido." - Iniciando verificacao do token: ".TOKEN); 
	
	/*++++++++++++++++++++++++++++++++++++++++++++++++*/
	 $result = "VERIFICADO"; 
	/*++++++++++++++++++++++++++++++++++++++++++++++++*/
	
	require_once(dirname(dirname(dirname(__FILE__))) . '/util/processa_retorno_pagamento.php');
} 
else{
	Util::log("Nenhum post recebido");
}
header("Location: ".$ROOTPATH."/index.php?pg=true");	
?>
<meta http-equiv="refresh" content="0; url=<?=$ROOTPATH?>?pg=true">