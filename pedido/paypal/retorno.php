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
define('TOKEN', $INI['paypal']['mid']);
define('STATUS_APROVADO', "Aprovado"); 
define('STATUS_COMPLETO', "completo"); 
define('STATUS_DEVOLVIDO',"devolvido"); 
define('STATUS_VERIFICADO',"VERIFIED"); 
define('STATUS_FALSO',"FALSO"); 
/*++++++++++++++++++++++++++++++++++++++++++++++++*/ 
 

 $param = gravar_request();
function gravar_request(){	
	$parametros="";
	foreach ($_REQUEST as $nome_campo => $valor_campo) {
		$parametros .= $nome_campo . "=" . $valor_campo . "&";
  } 
   return $parametros;
}
Util::log("Parametros:: $param");

/*++++++++++++++++++++++++++++++++++++++++++++++++ CRIAÇÃO DO ARRAY DOS DADOS DO PAGAMENTO DO GATEWAY*/
 
 $dados_pagamento = array(
    "gateway" => 'paypal', 
    "idtransacao" => $_POST['txn_id'], 
    "idPedido" => $_POST['item_number'] ,  
    "email_gateway" => $_POST['payer_email'], 
    "status_transacao" => $_POST['payment_status'], 
    "tipo_pagamento" => $_POST['TipoPagamento'],  
    "data_pagamento" => date("d-m-Y H:i:s"),  
    "valor_unitario" => $_POST['mc_gross'],  
    "quantidade_comprada" => "1",  
);
/*++++++++++++++++++++++++++++++++++++++++++++++++*/

$RetornoPagamento = new RetornoPagamento();
$RetornoPagamento->setDados($dados_pagamento);
 
 Util::log("Gateway:: ".$RetornoPagamento->gateway);
 
/* DEBUG*/
//mail("atendimento@sistemacomprascoletivas.com.br","retorno de dados ".$RetornoPagamento->gateway,$RetornoPagamento->gravar_request()); 	 


/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/ 
function fsockPost($url,$data) {
	//Parse url
	$web=parse_url($url);
	//build post string
	foreach($data as $i=>$v) {
		$postdata.= $i . "=" . urlencode($v) . "&";
	}
	$postdata.="cmd=_notify-validate";
	//Set the port number
	if($web['scheme'] == "https") {
		$web['port']="443";
		$ssl="ssl://";
	} else {
		$web['port']="80";
	}
	//Create paypal connection
	$fp = @fsockopen($ssl.$web['host'],$web['port'],$errnum,$errstr,30);
	//Error checking
	if(!$fp) { echo "$errnum: $errstr"; }
	//Post Data
	else {
		fputs($fp, "POST {$web['path']} HTTP/1.1\r\n");
		fputs($fp, "Host: {$web['host']}\r\n");
		fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
		fputs($fp, "Content-length: ".strlen($postdata)."\r\n");
		fputs($fp, "Connection: close\r\n\r\n");
		fputs($fp, $postdata . "\r\n\r\n");
		//loop through the response from the server
		while(!feof($fp)) {
			$info[] = @fgets($fp, 1024);
		}
		//close fp - we are done with it
		fclose($fp);
		//break up results into a string
		$info = implode(",",$info);
	}
	return $info;
}



/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/ 
 
if ($dados_pagamento->status_transacao) {

	Util::log($RetornoPagamento->idPedido." - ".$dados_pagamento->status_transacao);

	Util::log($RetornoPagamento->idPedido." - Iniciando verificacao do token: ".TOKEN); 
	
	/*++++++++++++++++++++++++++++++++++++++++++++++++*/
	 $post_url = "https://www.paypal.com/row/cgi-bin/webscr";
	$result = fsockPost($post_url, $_POST);
	/*++++++++++++++++++++++++++++++++++++++++++++++++*/
	
	require_once(dirname(dirname(dirname(__FILE__))) . '/util/processa_retorno_pagamento.php');
} 
else{
	Util::log("Nenhum post recebido");
}
header("Location: ".$ROOTPATH."/index.php?pg=true");	
?>
<meta http-equiv="refresh" content="0; url=<?=$ROOTPATH?>?pg=true">