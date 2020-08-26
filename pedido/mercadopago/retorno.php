<?php

error_reporting(E_ALL & ~(E_NOTICE|E_WARNING));

/***********************************************************
Script de Processamento do retorno do MercadoPago:
Implementação dos logs de gravação das etapas do processo.
Implementação do envio de email com dados da transação para o admin.
Implementação do envio de email de sucesso com dados da transação para o cliente.
Implementação do envio de email com o cupom para o cliente.
Implementação do envio de email com o cupom para todos os clientes ao ativar a oferta
Tratamento de envio de email e suporte a smtp e sendmail

16-12-2011

release 1.30

Parametros: 
seller_op_id=15
mp_op_id=69737726
acc_id=508588374
status=C
status_description=rejected
item_id=27
name=Ingresso+Festa+da+Virada+SPRITS+%2F+RBS+-+a+festa+mais+esperada+do+Ano+-+1%BALOTE...
price=55
shipping_amount=0
additional_amount=0
total_amount=55
extra_part=
payment_method=CC

*************************************************************/
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php'  );
require_once("../../util/Util.php");
Util::log("\n======================================== Retorno  -  Post MercadoPago 1.30");

$param = gravar_request();
Util::postemailCliente($param,utf8_decode($INI['system']['sitename']). " - parametros sprits","suportevipcom@gmail.com");
													
function gravar_request(){

	$parametros="";

	foreach ($_POST as $nome_campo => $valor_campo) {

		$parametros .= $nome_campo . "=" . $valor_campo . "&";
  }
   return $parametros;
}

//Util::log("Parametros:: $param");

//header('Content-Type: text/html; charset=ISO-8859-1');

define('TOKEN', $INI['mercadopago']['token2']);
Util::log("TOKEN :: ". $INI['mercadopago']['token2']);

class MercadoPagoNpi {
	
	private $timeout = 20; // Timeout em segundos
	
	public function notificationPost() {
		$postdata = 'Comando=validar&Token='.TOKEN;
		foreach ($_POST as $key => $value) {
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
		curl_setopt($curl, CURLOPT_URL, "https://www.mercadopago.com/mlb/sonda");
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

if (count($_POST) > 0) {

  	$hash 	=   $_POST['Referencia']  ;
	$valor 				=	str_replace(",",".",$_POST['price']);
	$quantidadecomprada =	1;
	$valortotalpago 	= $valor * $quantidadecomprada;
	Util::log($_POST['item_id']. " - Iniciando verificacao do token...");
	$npi = new MercadoPagoNpi();
	$result = $npi->notificationPost();
	$ProdID_1 	= isset($_POST['ref_transacao']) ? $_POST['ref_transacao'] : '';
	if($ProdID_1 == ""){
		$ProdID_1 	= isset($_POST['item_id']) ? $_POST['item_id'] : '';
	}
	$transacaoID = isset($_POST['mp_op_id']) ? $_POST['mp_op_id'] : '';
	Util::log($_POST['item_id']. " - Resposta ...:".$result);

	if ($result) {

		Util::log($_POST['item_id']. " - Token confirmado. Processando compra.");

		if( $_POST['status'] == 'A') { // APROVADO

			if ( $order['state'] == 'unpay' ) {
			
				Util::log($_POST['item_id']. " - Pedido encontrado com status nao pago. Preparando para atualizar...");
				$price =str_replace(",",".",$_POST['price']);
				$table = new Table('order');
				$table->SetPk('id', $_POST['item_id']);
				$table->pay_id = $_POST['mp_op_id'];
				$table->money =  $price;
				$table->state = 'pay';
				$table->service = 'mercadopago
				$table->pay_time = time();';
				$flag = $table->update(array('state', 'pay_id', 'money'));

				if ( $flag ) {
				
					Util::log($_POST['item_id']. " - Pedido atualizado para pago com sucesso. Preparando para inserir o registro na tabela de pagamento.");
					$price =str_replace(",",".",$_POST['price']);
					
					$table = new Table('pay');
					$table->id = $_POST['mp_op_id'];
					$table->order_id = $_POST['item_id'];
					$table->money = $price;
					$table->currency = 'REA';
					$table->bank = $_POST['payment_method'];
					$table->service = 'mercadopago';
					$table->create_time = time();
					$table->insert( array('id', 'order_id', 'money', 'currency', 'service', 'create_time', 'bank') );
					
					Util::log($_POST['item_id']. " - Registro inserido na tabela de pagamento com sucesso. Preparando para buscar os dados e envio do cupom ...");
					ZTeam::BuyOne($order);
					$team = Table::Fetch('team', $order['team_id']);

					 if($team['now_number'] >= $team['min_number']){  //<!--  A oferta esta ativa  -->

						Util::log($_POST['item_id']. " - Oferta ativa -  buscando os cupons dos usuarios para envio...");
						$sql = "select a.id,a.secret,a.order_id,b.username,b.email,c.title,c.homepage,c.location from coupon a,user b, partner c where a.partner_id = c.id and a.user_id = b.id and a.envioucupom is null and a.consume='N' and a.team_id = ".$order['team_id'];
						$rs = mysql_query($sql);
						Util::log("Encontrado (".mysql_num_rows($rs).") oferta(s) para envio.");
						$achou = false;
						while($row = mysql_fetch_object($rs)){
							$achou = true;
							$numcupom 	= $row->id;
							$senha 		= $row->secret;
							$pedido  	= $row->order_id;
							$email 		= $row->email;
							$nome 		= $row->nome;
							$username  	= $row->username;
							$complemento = $row->chavesms;
							$parceiro  	= $row->title ;
							$homepage   = $row->homepage  ;
							$location   = $row->address  ;

							$location =  $location. " ".$complemento;

							Util::log("Pedido: ".$pedido. " - Numero do cupom: $numcupom - senha: $senha - Utilizador: $nome .");
							$url = $INI['system']['wwwprefix'];
							$url.= $url."/pedidos";

							Util::log("Pedido: ".$pedido. " - Numero do cupom: $numcupom - senha: $senha .");
					 
							$body = 
							"
							<h3>Parabéns $username, sua transação foi concluída com sucesso e você acaba de receber os dados do seu cupom</h3>
							<br>Número do Cupom: $numcupom 
							<br>Senha do Cupom: $senha	
							
							<h3>Local de consumação de seu cupom</h3>
							<p>".$parceiro."</p>
							<p>".$location ."</p>
							<p>".$homepage."</p>
							<p>  Aproveite !</p> 
							";

							$parametros = array( 'username' => $username, 'numcupom' => $numcupom, 'senha' => $senha,  'utilizador' => $nome ,'parceiro' => $parceiro, 'location' => $location, 'homepage' => $homepage  );
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
							$body = file_get_contents($INI["system"]["wwwprefix"]."/templates/envio_cupom.php", false, $request);

							if(Util::postemailCliente($body,utf8_decode($INI['system']['sitename']). " - Estamos enviando o seu cupom",$email)){
								Util::log($pedido. " - Email para o cliente com dados do cupom enviado com sucesso(".$email.")...");

								$sql2 = "update coupon set envioucupom = 1 where id = '".$numcupom."'";
								$rs2 = mysql_query($sql2);
								if($rs2){
									Util::log($pedido. " - campo envioucupom atualizado.");
								 }
								 else{
									Util::log($pedido. " - campo envioucupom nao atualizado. $sql2");
								 }
							}

							 else{
								Util::log($_POST['item_id']. " - A oferta desta compra nao esta ativa, numero minimo nao alcancado ainda (".$team['min_number'].") total comprados (".$team['now_number'].").");
							 }
							 if( !$achou){
								Util::log($_POST['item_id']. " - Ainda nenhum cupom disponivel para envio:  Minimo: (".$team['min_number'].") - Total comprados (".$team['now_number'].").");
							 }
							Util::log($_POST['item_id']. " - Preparando para enviar o email de compra concluida para o cliente (".$_POST['cart_email'].")...");

							$site = $INI['system']['sitename'];

							$request_params = array(
								'http' => array(
									'method'  => 'POST',
									'header'  => implode("\r\n", array(
										'Content-Type: application/x-www-form-urlencoded',
										'Content-Length: ' . strlen(http_build_query($_REQUEST)),
									)),
									'content' => http_build_query($_REQUEST),
								)
							);

							$request  = stream_context_create($request_params);
							$body = file_get_contents($INI["system"]["wwwprefix"]."/templates/confirmacao_pagamento.php", false, $request);

							if(Util::postemailCliente($body,utf8_decode($site. " - Pagamento Concluído"),$_POST['cart_email'])){
								Util::log($_POST['item_id']. " - Email para o cliente enviado com sucesso... Preparando para enviar o email para o administrador  (".Util::EMAIL_WEBMASTER.")...");
							}
							else{
								Util::log($_POST['item_id']. " - Erro no envio do email... Preparando para enviar o email para o administrador...");
							}
							 $body =  "O pedido numero ".$_POST['item_id']." acaba de ser aprovado e o status desta compra ja foi atualizado para pago no seu sistema de ofertas. <br>";
							 $body  = $body ." <h3>Dados do pedido </h3> Numero do pedido no sistema de ofertas: <b>".$ProdID_1."</b>
							 <br> Nome do cliente: <b>".$_POST['cart_name']."</b>
							 <br> Email do cliente: <b>".$_POST['cart_email']."</b>
							 <br> Status da transacao: <b>".$_POST['status']." - ".$_POST['status_description']."</b>
							 <br> Tipo do pagamento: <b>".$_POST['payment_method']."</b>
							 <br> Produto comprado: <b>".$_POST['name']."</b>
							 <br> Codigo produto: <b>".$_POST['item_id']."</b>" ;

							$body = utf8_encode($body);
							if(Util::postemail($body,utf8_decode($site. " - Pedido ".$_POST['item_id']." ".$_POST['status']))){
								Util::log($_POST['item_id']. " - Email para o administrador enviado com sucesso. Retornando para a loja");
							}
							else{
								Util::log($_POST['item_id']. " - Erro no envio do email (".Util::getFrom().")... Retornando para a loja ");
							}
						}
					}
					else{
						Util::log($_POST['item_id']. " - Nao foi possivel atualizar a tabela order com os dados do pedido ".$_POST['item_id'].". Retornando para a loja.",true);
					}
				}
				else{
					Util::log($_POST['item_id']. " - Pedido ja estava com status de pago no banco de dados. Retornando para a loja.");
				}
				$idref = $_POST['item_id'];
				Utility::Redirect( WEB_ROOT );

			}else {
			
				Util::log($_POST['item_id']. " - Pedido com status nao aprovado: ".$_POST['status']);
				
				$body =  "O pedido numero ".$_POST['item_id']." ainda nao foi aprovado pelo mercadopago. O status esta ".$_POST['status'] .". Por isso ainda nao houve alteracao no status deste pedido no sistema de ofertas.";
				
				 $to = $INI['mail']['from'];
				 $site = $INI['system']['sitename']; 
				 $body = " <h3>Dados da Compra</h3>
				 <br>Email da conta do mercadopago: <b>".$to."</b>
				 <br> Numero do pedido no sistema de ofertas: <b>".$item_id."</b>
				 <br> Nome do cliente: <b>".$_POST['cart_name']."</b>
				 <br> Email do cliente: <b>".$_POST['cart_email']."</b>
				 <br> Status da transacao: <b>".$_POST['status']." - ".$_POST['status_description']."</b>
				 <br> Tipo do pagamento: <b>".$_POST['payment_method']."</b>
				 <br> Produto comprado: <b>".$_POST['name']."</b>
				 <br> Codigo produto: <b>".$_POST['item_id']."</b>" ;
				 
				 $body = utf8_encode($body); 
				 
				if(Util::postemail($body,utf8_decode($site. " - Pedido ".$_POST['item_id']." ".$_POST['status']))){
					Util::log($_POST['item_id']. " - Email enviado para (".Util::EMAIL_WEBMASTER.")... Retornando para a loja ");
				}
				else{
					 Util::log($_POST['item_id']. " - Erro no envio do email (".Util::EMAIL_WEBMASTER.")... Retornando para a loja ");
				}
				 
			}
		}
	} else if ($result == "FALSO") {
	
		 Util::log("Token nao validado.");
		 $to = $INI['mail']['from'];
		 $body = "Retorno mercadopago - token nao foi validado -  result retornou um false. <br>
		 Confirme seu token no painel do mercadopago: token: <b>".TOKEN."</b>
		 <br>Email da conta do mercadopago: <b>".$to."</b>
		 <br> Numero do pedido no sistema de ofertas: <b>".$item_id."</b>
		 <br> Nome do cliente: <b>".$_POST['cart_name']."</b>
		 <br> Email do cliente: <b>".$_POST['cart_email']."</b>
		 <br> Status da transacao: <b>".$_POST['status']." - ".$_POST['status_description']."</b>
		 <br> Tipo do pagamento: <b>".$_POST['payment_method']."</b>
		 <br> Produto comprado: <b>".$_POST['name']."</b>
		 <br> Codigo produto: <b>".$_POST['item_id']."</b>" ;
		 
		 $body = utf8_decode($body);
		 Util::postemail($body,utf8_decode($site. "Token nao validado."));
				
		
	} else {
	
		 Util::log("Erro na integracao com o mercadopago: $result");
		 $to = $INI['mail']['from'];
		 $body = "Retorno mercadopago - erro na integracao do mercadopago <br>  Os dados nao foram atualizados no sistema de ofertas.<br>
		 <br> Numero do pedido no sistema de ofertas: <b>".$item_id."</b>
		 <br> Nome do cliente: <b>".$_POST['cart_name']."</b>
		 <br> Email do cliente: <b>".$_POST['cart_email']."</b>
		 <br> Status da transacao: <b>".$_POST['status']." - ".$_POST['status_description']."</b>
		 <br> Tipo do pagamento: <b>".$_POST['payment_method']."</b>
		 <br> Produto comprado: <b>".$_POST['name']."</b>
		 <br> Codigo produto: <b>".$_POST['item_id']."</b>" ;

		 $body = utf8_decode($body);
		 $body =  $body."<br><br>Parametros: <br>".$param;
		 Util::postemail($body,utf8_decode($site. "Erro na integracao com o mercadopago."));
	}	
}
else {
	Util::log("POST nao recebido, indica que a requisicao e o retorno do Checkout mercadopago");
	Utility::Redirect( WEB_ROOT );
}

?>