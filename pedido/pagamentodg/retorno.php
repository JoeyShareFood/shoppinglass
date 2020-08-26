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
require_once(dirname(dirname(dirname(__FILE__))) . '/templates/assuntos_emails.php' );
  
/*+++++++++++++++++++++++++++++++++++++++++++++++*/
define('TOKEN', $INI['pagamentodg']['mid']);
define('STATUS_APROVADO', "1"); 
define('STATUS_COMPLETO', "completo"); 
define('STATUS_DEVOLVIDO',"devolvido"); 
define('STATUS_VERIFICADO',"VERIFICADO"); 
define('STATUS_FALSO',"FALSO"); 
/*++++++++++++++++++++++++++++++++++++++++++++++++*/ 
 
/*++++++++++++++++++++++++++++++++++++++++++++++++ CRIAÇÃO DO ARRAY DOS DADOS DO PAGAMENTO DO GATEWAY*/
 
 $dados_pagamento = array(
    "gateway" => 'Pagamento Digital', 
    "idtransacao" => $_POST['id_transacao'], 
    "idPedido" => $_POST['produto_codigo_1'] , 
    "cliente_gateway" => $_POST['cliente_nome'], 
    "email_gateway" => $_POST['cliente_email'], 
    "status_transacao" => $_POST['cod_status'], 
    "tipo_pagamento" => $_POST['tipo_pagamento'],  
    "data_pagamento" => $_POST['data_transacao'],  
    "valor_unitario" => $_POST['produto_valor_1'],  
    "quantidade_comprada" => $_POST['produto_qtde_1'],  
);
/*++++++++++++++++++++++++++++++++++++++++++++++++*/

$RetornoPagamento = new RetornoPagamento();
$RetornoPagamento->setDados($dados_pagamento);
 
/* DEBUG*/
//mail("atendimento@sistemacomprascoletivas.com.br","retorno de dados ".$RetornoPagamento->gateway,$RetornoPagamento->gravar_request()); 	 


/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/ 
$post = "transacao=".$RetornoPagamento->idtransacao."&status=".$_POST['status']."&cod_status=".$_POST['cod_status']."&valor_original=".$_POST['valor_original']."&valor_loja=".$_POST['valor_loja']."&token=".TOKEN;
$enderecoPost = "https://www.pagamentodigital.com.br/checkout/verify/";
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/ 
 
 Util::log($_POST['produto_codigo_1']." - Descricao status: ".utf8_decode($_POST['status'])."-".$_POST['cod_status']); 
 
if ($RetornoPagamento->idPedido and $_POST) {

	Util::log($RetornoPagamento->idPedido." - Iniciando verificacao do token: ".TOKEN); 
	
	/*++++++++++++++++++++++++++++++++++++++++++++++++*/
	ob_start();
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, $enderecoPost);
	curl_setopt ($ch, CURLOPT_POST, 1);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
	curl_exec ($ch);
	$result = ob_get_contents();
	ob_end_clean();
	/*++++++++++++++++++++++++++++++++++++++++++++++++*/
	 
	require_once(dirname(dirname(dirname(__FILE__))) . '/util/processa_retorno_pagamento.php');
	
} 
header("Location: ".$ROOTPATH."/index.php?pg=true");	
?>
<meta http-equiv="refresh" content="0; url=<?=$ROOTPATH?>?pg=true">