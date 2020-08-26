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

Util::log("");
Util::log("Gateway:: MOIPTRANSPARENTE NOTIFIC");


$param = gravar_request();
function gravar_request(){	
	$parametros="";
	foreach ($_REQUEST as $nome_campo => $valor_campo) {
		$parametros .= $nome_campo . "=" . $valor_campo . "&";
  } 
   return $parametros;
}

Util::log("Parametros:: $param"); 


  /*+++++++++++++++++++++++++++++++++++++++++++++++*/
define('TOKEN', $INI['pagseguro']['mid']);
define('STATUS_APROVADO', "1"); 
define('STATUS_COMPLETO', "4"); 
define('STATUS_DEVOLVIDO',"9"); 
define('STATUS_VERIFICADO',"VERIFICADO"); 
define('STATUS_FALSO',"FALSO"); 
/*++++++++++++++++++++++++++++++++++++++++++++++++*/ 
 

/*++++++++++++++++++++++++++++++++++++++++++++++++*/

if ($_POST['status_pagamento']) {

 $idpedidoaux = explode("-",$_POST['id_transacao']);
 $idpedido = $idpedidoaux[0];
 
 
 Util::log("Id transação: ". $_POST['id_transacao']);
 Util::log("Id pedido: ". $idpedido);
 
 $valor = number_format($_POST['valor'],2);
 
 
/*++++++++++++++++++++++++++++++++++++++++++++++++ CRIAÇÃO DO ARRAY DOS DADOS DO PAGAMENTO DO GATEWAY*/

 $dados_pagamento = array(
    "gateway" => 'moiptransparente', 
    "idtransacao" => $_POST['codMoip'], 
    "idPedido" => $idpedido , 
    "cliente_gateway" => $_POST['CliNome'], 
    "email_gateway" => $_POST['email_consumidor'], 
    "status_transacao" => $_POST['status_pagamento'], 
    "tipo_pagamento" => $_POST['tipo_pagamento'],  
    "data_pagamento" => date("d/m/Y H:i:s"),  
    "valor_unitario" => $_POST['valor'],  
    "quantidade_comprada" => $_POST['ProdQuantidade_1'],  
	"descricao_status" => $_POST['status_pagamento'], 
);

	 
$RetornoPagamento = new RetornoPagamento();
$RetornoPagamento->setDados($dados_pagamento);


Util::log($RetornoPagamento->idPedido." - ".$RetornoPagamento->status_transacao);
require_once(dirname(dirname(dirname(__FILE__))) . '/util/processa_retorno_pagamento.php');
header("HTTP/1.0 200 OK");
	  
} 
else{
	//Util::log("Nenhum post recebido");
} 
?>
<?
/*
$TABELA_PEDIDO          = 'teste';

$CAMPOS_PEDIDO = Array (
    'id_transacao'      => 'idPedido',
    'valor'             => 'valorPedido',
    'status_pagamento'  => 'statusPagamento',
    'cod_moip'          => 'codMoip',
    'forma_pagamento'   => 'formaPagamento',
    'tipo_pagamento'    => 'tipoPagamento',
    'parcelas'          => 'numeroParcelas',
    'email_consumidor'  => 'emailConsumidor',
    'cartao_bin'        => 'inicioCartao',
    'cartao_final'      => 'finalCartao',
    'cartao_bandeira'   => 'bandeiraCartao',
    'cofre'             => 'cofre'
);
//CONFIGURE ABAIXO OS NÚMERO QUE DEFINIRÃO OS STATUS DAS OPERAÇÕES
//MAIS INFO EM: http://labs.moip.com.br/transparente/#referencia_nasp
/*
$AUTORIZADO      = 1;
$INICIADO        = 2;
$BOLETO_IMPRESSO = 3;
$CONCLUIDO       = 4;
$CANCELADO       = 5;
$ANALISE         = 6;
$ESTORNADO       = 7;
$REVISAO         = 8;
$REEMBOLSO       = 9;
*/
//$QUERY = "UPDATE {$TABELA_PEDIDO} SET {$TEMP} WHERE {$CAMPO_ID_PEDIDO} = {$_POST['id_transacao']}";
//$QUERY_STATUS = "UPDATE {$TABELA_PEDIDO} SET {$CAMPOS_PEDIDO['status_pagamento']} = {$_POST['status_pagamento']}";
/*
if ($_POST['status_pagamento'] == 4)
  require_once('pagamentoCompleto.php');
else if ($_POST['status_pagamento'] == 5 || $_POST['status_pagamento'] == 7 || $_POST['status_pagamento'] == 9)
  require_once('pagamentoNegado.php');
else
  require_once('pagamentoProblema.php');
  */
?>