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
require_once(dirname(dirname(dirname(__FILE__))) . '/util/apipagseguro/NotificationListener.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/util/apipagseguro/searchTransactionByCode.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/templates/assuntos_emails.php'  );

Util::log("Gateway:: PAGSEGURO");

$param = gravar_request();
function gravar_request(){	
	$parametros="";
	foreach ($_REQUEST as $nome_campo => $valor_campo) {
		$parametros .= $nome_campo . "=" . $valor_campo . "&";
  } 
   return $parametros;
}
Util::log("Parametros:: $param"); 
  

 
 // Testa se o administrador setou para nova api do pagseguro
 if(1==2){
	 	require_once("novoretorno.php");
		exit;
  }
  
  /*+++++++++++++++++++++++++++++++++++++++++++++++*/
define('TOKEN', $INI['pagseguro']['mid']);
define('STATUS_APROVADO', "Aprovado"); 
define('STATUS_COMPLETO', "completo"); 
define('STATUS_DEVOLVIDO',"devolvido"); 
define('STATUS_VERIFICADO',"VERIFICADO"); 
define('STATUS_FALSO',"FALSO"); 
/*++++++++++++++++++++++++++++++++++++++++++++++++*/ 
 
/*++++++++++++++++++++++++++++++++++++++++++++++++ CRIAÇÃO DO ARRAY DOS DADOS DO PAGAMENTO DO GATEWAY*/
 $find = strpos($_POST['Referencia'], "Billing");
 
 if($find === false) {
	$ref_transacao = $_POST['Referencia'];
	$billing = 0;
 }
 else {
	$ref_transacao = substr($_POST['Referencia'], 7);
	$billing = 1;
} 
 
 if($ref_transacao ==""){
	Util::log("Numero do pedido vazio. saindo do retorno.");
	exit;
 }
 
$valortotal  =0;
for($i=0;$i<$_POST['NumItens'];$i++){
		$valortotal = str2num($valortotal) + str2num($_POST['ProdValor_'.$i]);
}
 
 $dados_pagamento = array(
    "gateway" => 'pagseguro', 
    "idtransacao" => $_POST['TransacaoID'], 
    "idPedido" => $ref_transacao , 
    "cliente_gateway" => $_POST['CliNome'], 
    "email_gateway" => $_POST['CliEmail'], 
    "status_transacao" => $_POST['StatusTransacao'], 
    "tipo_pagamento" => $_POST['TipoPagamento'],  
    "data_pagamento" => $_POST['DataTransacao'],  
    "valor_unitario" => $valortotal,  
    "ValorFrete" => $_POST['ValorFrete'],  
    "quantidade_comprada" => $_POST['ProdQuantidade_1'],  
	"descricao_status" => $_POST['StatusTransacao'], 
);
/*++++++++++++++++++++++++++++++++++++++++++++++++*/

$RetornoPagamento = new RetornoPagamento();
$RetornoPagamento->setDados($dados_pagamento);
 
/* DEBUG*/
//mail("atendimento@sistemacomprascoletivas.com.br","retorno de dados ".$RetornoPagamento->gateway,$RetornoPagamento->gravar_request()); 	 


/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/ 
class PagSeguroNpi {
	private $timeout = 20; // Timeout em segundos
	public function notificationPost() {
		$postdata = 'Comando=validar&Token='.TOKEN;
		foreach ($_REQUEST as $key => $value) {
			$valued    = $this->clearStr($value);
			$postdata .= "&$key=$valued";
		}
		return $this->verify($postdata); 
	}
	private function clearStr($str) {
		if (!get_magic_quotes_gpc()) {
			$str = addslashes($str);
		}
		return $str;
	}
	private function verify($data) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, "https://pagseguro.uol.com.br/pagseguro-ws/checkout/NPI.jhtml");
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$result = trim(curl_exec($curl));
		curl_close($curl);
		return $result;
	}
}
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/ 
 
if ($_POST['StatusTransacao']) {

	Util::log($RetornoPagamento->idPedido." - ".$RetornoPagamento->status_transacao);

	Util::log($RetornoPagamento->idPedido." - Iniciando verificacao do token: ".TOKEN); 
	
	/*++++++++++++++++++++++++++++++++++++++++++++++++*/
	 $npi = new PagSeguroNpi();
	 $result = $npi->notificationPost(); 
	/*++++++++++++++++++++++++++++++++++++++++++++++++*/
	
	$RetornoPagamento->resultado($result);
	
	if ($result == "VERIFICADO") {
		if($billing == 1) {
			require_once(dirname(dirname(dirname(__FILE__))) . '/util/processa_retorno_pagamento_fatura.php');
		}
		else {
			require_once(dirname(dirname(dirname(__FILE__))) . '/util/processa_retorno_pagamento.php');
		}
	}
	else{
		Util::log($RetornoPagamento->idPedido." - Token nao verificado. Por favor, renove o seu token no pagseguro: ".TOKEN); 
	}
} 
else{
	Util::log("Nenhum post recebido");
}
header("Location: ".$ROOTPATH."/index.php?pg=true");	
?>
<meta http-equiv="refresh" content="0; url=<?=$ROOTPATH?>?pg=true">