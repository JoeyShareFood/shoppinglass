 <?php
 
error_reporting(E_ALL & ~(E_NOTICE|E_WARNING));

/***********************************************************
Script de Processamento do retorno do pagamento digital:
Implementação dos logs de gravação das etapas do processo.
Implementação do envio de email com dados da transação para o admin.
Implementação do envio de email de sucesso com dados da transação para o cliente.
Implementação do envio de email com o cupom para o cliente.
Implementação do envio de email com o cupom para todos os clientes ao ativar a oferta
Tratamento de envio de email e suporte a smtp e sendmail

16-01-2011 
www.tkstore.com.br
vipcom
www.sistemacomprascoletivas.com.br

release 1.8
 
*************************************************************/
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

require_once("../../util/Util.php");

Util::log("======================================== Retorno  -  Post Pag Digital v 1.7\n");
$param = gravar_request();
function gravar_request(){
	
	$parametros="";
	
	foreach ($_REQUEST as $nome_campo => $valor_campo) {
	
		$parametros .= $nome_campo . "=" . $valor_campo . "&";
  } 
   return $parametros;
}

//Util::log("Parametros:: $param");

header('Content-Type: text/html; charset=ISO-8859-1');
 
$token = $INI['pagamentodg']['mid'];

define('TOKEN', $token);

Util::log("TOKEN :: ". $token);
  
$id_transacao = $_POST['id_transacao'];
$data_transacao = $_POST['data_transacao'];
$data_credito = $_POST['data_credito'];
$valor_original = $_POST['valor_original'];
$valor_loja = $_POST['valor_loja'];
$valor_total = $_POST['valor_total'];
$desconto = $_POST['desconto'];
$acrescimo = $_POST['acrescimo'];
$tipo_pagamento = $_POST['tipo_pagamento'];
$parcelas = $_POST['parcelas'];
$cliente_nome = $_POST['cliente_nome'];
$cliente_email = $_POST['cliente_email'];
$cliente_rg = $_POST['cliente_rg'];
$cliente_data_emissao_rg = $_POST['cliente_data_emissao_rg'];
$cliente_orgao_emissor_rg = $_POST['cliente_orgao_emissor_rg'];
$cliente_estado_emissor_rg = $_POST['cliente_estado_emissor_rg'];
$cliente_cpf = $_POST['cliente_cpf'];
$cliente_sexo = $_POST['cliente_sexo'];
$cliente_data_nascimento = $_POST['cliente_data_nascimento'];
$cliente_endereco = $_POST['cliente_endereco'];
$cliente_complemento = $_POST['cliente_complemento'];
$status = $_POST['status'];
$cod_status = $_POST['cod_status'];
$cliente_bairro = $_POST['cliente_bairro'];
$cliente_cidade = $_POST['cliente_cidade'];
$cliente_estado = $_POST['cliente_estado'];
$cliente_cep = $_POST['cliente_cep'];
$frete = $_POST['frete'];
$tipo_frete = $_POST['tipo_frete'];
$informacoes_loja = $_POST['informacoes_loja'];
$id_pedido = $_POST['id_pedido'];
$free = $_POST['free'];

$qtde_produtos = $_POST['qtde_produtos'];
$x = "1";
$produto_codigo = $_POST['produto_codigo_'.$x];
$produto_descricao = $_POST['produto_descricao_'.$x];
$produto_qtde = $_POST['produto_qtde_'.$x];
$produto_valor = $_POST['produto_valor_'.$x];
$produto_extra = $_POST['produto_extra_'.$x];

  
$post = "transacao=$id_transacao" .
"&status=$status" .
"&cod_status=$cod_status" .
"&valor_original=$valor_original" .
"&valor_loja=$valor_loja" .
"&token=$token";
$enderecoPost = "https://www.pagamentodigital.com.br/checkout/verify/";

ob_start();
$ch = curl_init();
curl_setopt ($ch, CURLOPT_URL, $enderecoPost);
curl_setopt ($ch, CURLOPT_POST, 1);
curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
curl_exec ($ch);
$result = ob_get_contents();
ob_end_clean();

 
if (count($_POST) > 0 and $produto_codigo) {
	
	$ref_transacao 	= $id_transacao; 
	$ProdID_1  		= $produto_codigo ;
	$valor 				=	str_replace(",",".",$produto_valor);
	$quantidadecomprada =	str_replace(",",".",$qtde_produtos);
	$valortotalpago 	= $valor * $quantidadecomprada;
	 
	Util::log("Pedido: ".$ProdID_1. " - Transacao: ".$ref_transacao.": Iniciando verificacao do token..."); 
   
	Util::log("Pedido: ".$ProdID_1. " - Resposta ...:".$result);
	
	 if ($result == "VERIFICADO") {
	  
			Util::log("Pedido: ".$ProdID_1. " - Token confirmado. Processando compra.");  
			
			if( $cod_status  == '1') {
		
				Util::log("Pedido: ".$ProdID_1. " - Status aprovado. Preparando para atualizar tabela de pedidos. Buscando pedido codigo: ".$ProdID_1);
		 
				$order = Table::Fetch('order', $ProdID_1);
				
				if ( $order['state'] == 'unpay' ) {
				
					Util::log("Pedido: ".$ProdID_1. " - Pedido encontrado com status nao pago. Preparando para atualizar...");
		 
					$ProdValor_1 =str_replace(",",".",$valor_original);
						 
					$table = new Table('order');
					$table->SetPk('id', $ProdID_1);
					$table->pay_id = $ref_transacao;
					$table->money =  $ProdValor_1;
					$table->state = 'pay';
					$flag = $table->update(array('state', 'pay_id', 'money'));
		 
					if ( $flag ) {
					
						Util::log("Pedido: ".$ProdID_1. " - Pedido atualizado para pago com sucesso. Preparando para inserir o registro na tabela de pagamento.");
					
						$ProdValor_1 =str_replace(",",".",$valor_original);
						
						$table = new Table('pay');
						$table->id = $ref_transacao;
						$table->order_id = $ProdID_1;
						$table->money = $ProdValor_1;
						$table->currency = 'BRL';
						$table->bank = $tipo_pagamento;
						$table->service = 'pagamentodigital';
						$table->create_time = time();
						$table->insert( array('id', 'order_id', 'money', 'currency', 'service', 'create_time', 'bank') );
						
						Util::log("Pedido: ".$ProdID_1. " - Registro inserido na tabela de pagamento com sucesso. Preparando para buscar os dados e envio do cupom ...");
						  
						//update team,user,order,flow state//
						ZTeam::BuyOne($order);
						
						 
						// buscando dados da oferta - verificando se ela está ativa para enviar cupons para todos os clientes que compraram
					    $team = Table::Fetch('team', $order['team_id']);
						 
						 if($team['now_number'] >= $team['min_number']){  //<!--  A oferta esta ativa  --> 
						  
							Util::log("Pedido: ".$ProdID_1. " - Oferta ativa -  buscando os cupons dos usuarios para envio...");
						 
							$sql = "select a.id,a.secret,a.order_id,b.username,b.email,c.title,c.homepage,c.location,d.nome from coupon a,user b, partner c,order_amigos d where a.partner_id = c.id and a.user_id = b.id and a.envioucupom is null and a.consume='N' and a.order_id = d.order_id and a.team_id = ".$order['team_id'];
							$rs = mysql_query($sql);
							
							Util::log("Encontrado (".mysql_num_rows($rs).") oferta(s) para envio.");
							 
							$achou = false;
							while($row = mysql_fetch_object($rs)){
							    $achou = true;
								$numcupom 	= $row->id;
								$senha 		= $row->secret; 
								$pedido  	= $row->order_id; 
								$email 		= $row->email; 
								$username  	= $row->username; 
								$parceiro  	= $row->title ; 
								$homepage   = $row->homepage  ; 
								$location   = $row->location  ; 
								
								Util::log("Pedido: ".$ProdID_1. " - Numero do cupom: $numcupom - senha: $senha .");
						 
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
								
								$body = utf8_decode($body); 
						
								if(Util::postemailCliente($body,utf8_decode($site. " - Estamos enviando o seu cupom"),$email)){
									Util::log("Pedido: ".$ProdID_1. " - Email para o cliente com dados do cupom enviado com sucesso(".$email.")...");
									$sql2 = "update coupon set envioucupom =1 where id = '".$numcupom."'";
									$rs2 = mysql_query($sql2);
									if($rs2){
										Util::log("Pedido: ".$ProdID_1. " - campo envioucupom atualizado.");
									 }
									 else{
									 	Util::log("Pedido: ".$ProdID_1. " - campo envioucupom nao atualizado. $sql2");
									 }
								}
								else{
									Util::log("Pedido: ".$ProdID_1. " - Erro no envio do email... (".$email.") .");
								}
							}
						 }
						 else{
						 	Util::log("Pedido: ".$ProdID_1. " - A oferta desta compra nao esta ativa, numero minimo nao alcancado ainda (".$team['min_number'].") total comprados (".$team['now_number'].").");
						 }
						 if( !$achou){
						  	Util::log("Pedido: ".$ProdID_1. " - Ainda nenhum cupom disponivel para envio:  Minimo: (".$team['min_number'].") - Total comprados (".$team['now_number'].").");
						 }
						 
					    Util::log("Pedido: ".$ProdID_1. " - Preparando para enviar o email de compra concluida para o cliente (".$cliente_email.")...");
						
						$site = $INI['system']['sitename']; 
						 
						 $body =  "<h3>O pedido numero ".$ProdID_1." acaba de ser aprovado. </h3>";
						 $body  = $body ." <h3>Você receberá o número e a senha do cupom em instantes, você pode também imprimir o cupom através de nosso site!</h3>"; 
						 $body  = $body ." <p>Dados do pedido </p> 
						 <br>Numero do pedido no sistema de ofertas: <b>".$ProdID_1."</b>
						 <br>Email da conta do pagamento digital: <b>".$to."</b>
						 <br> Numero do pedido no sistema de ofertas: <b>".$ProdID_1."</b>
						 <br> Nome do cliente: <b>".$cliente_nome."</b> 
						 <br> Email do cliente: <b>".$cliente_email."</b> 
						 <br> Status da transacao: <b>".$status ."</b>   
						 <br> Codigo do Status: <b>".$cod_status  ."</b>   
						 <br> Tipo do pagamento: <b>".$tipo_pagamento."</b>   
						 <br> Produto comprado: <b>".$produto_descricao."</b>   
						 <br> Codigo produto: <b>".$produto_codigo."</b>   
						 <br> Data do pagamento: <b>".$data_transacao."</b> " ;
					 
						$body = utf8_decode($body);   
						if(Util::postemailCliente($body,utf8_decode($site. " - Pagamento Concluído"),$cliente_email)){
							Util::log("Pedido: ".$ProdID_1. " - Email para o cliente enviado com sucesso... Preparando para enviar o email para o administrador  (".Util::getFrom().")...");
						}
						else{
							Util::log("Pedido: ".$ProdID_1. " - Erro no envio do email... Preparando para enviar o email para o administrador...");
						}
						 
						 $body =  "O pedido numero ".$ProdID_1." acaba de ser aprovado e o status desta compra ja foi atualizado para pago no seu sistema de ofertas. <br>";
						 $body  = $body ." <h3>Dados do pedido </h3> Numero do pedido no sistema de ofertas: <b>".$ProdID_1."</b>
						 <br>Email da conta do pagamento digital: <b>".$to."</b>
						 <br> Numero do pedido no sistema de ofertas: <b>".$ProdID_1."</b>
						 <br> Nome do cliente: <b>".$cliente_nome."</b> 
						 <br> Email do cliente: <b>".$cliente_email."</b> 
						 <br> Status da transacao: <b>".$status ."</b> 
						  <br> Codigo do Status: <b>".$cod_status  ."</b>   
						 <br> Tipo do pagamento: <b>".$tipo_pagamento."</b>   
						 <br> Produto comprado: <b>".$produto_descricao."</b>   
						 <br> Codigo produto: <b>".$produto_codigo."</b>   
						 <br> Data do pagamento: <b>".$data_transacao."</b> " ;
						 
					    $body = utf8_encode($body);   
						if(Util::postemail($body,utf8_decode($site. " - Pedido ".$ProdID_1." ".$status))){
							Util::log("Pedido: ".$ProdID_1. " - Email para o administrador enviado com sucesso. Retornando para a loja");
						}
						else{
							Util::log("Pedido: ".$ProdID_1. " - Erro no envio do email (".Util::getFrom().")... Retornando para a loja ");
						}
					}
					else{
						Util::log("Pedido: ".$ProdID_1. " - Nao foi possivel atualizar a tabela order com os dados do pedido ".$ProdID_1.". Retornando para a loja.",true);
					}
				}
				else if ( $order['state'] == 'pay' ) {
					Util::log($ProdID_1. " - Pedido ja estava com status de pago no banco de dados. Retornando para a loja.");
				}
				else{
					Util::log($ProdID_1. " - Este pedido nao existe em seu sistema de oferta, provavelmente seja um outro servico do pagseguro.");
					
					Util::log($ProdID_1. " - Verificando o pagamento de credito.");
					 
					$codusuario = explode("-",$ProdID_1);
					$flag 			= $codusuario[0];
					$codusuario = explode("-",$codusuario[1]);
					$userid 	= explode("-",$codusuario[0]);
					$userid 	= $userid[0];
					Util::log($ProdID_1. " - flag: $flag");
					 
					if( trim($flag) == "charge"){
					
						Util::log($ProdID_1. " - compra de credito. Atualizando os creditos do usuario: (".$valortotalpago.") para usuario id $userid");
						
						$sql2 = "update user set money = money + ".$valortotalpago." where id = '".$userid."'";
						$rs2 = mysql_query($sql2);
						if($rs2){
							Util::log($pedido. " - credito atualizado com sucesso.");
						}
						else{
							Util::log($pedido. " - erro na atualizacao do credito. $sql2 ".mysql_error());
						}
						$time = time();
						$sql2 	= "insert into flow (user_id,admin_id,detail_id,direction,money,action,create_time) values ('".$userid."','0','11','income','".$valortotalpago."','buy',$time)";
						$rs2 	= mysql_query($sql2);
						
						if($rs2){
							Util::log($pedido. " - fluxo atualizado com sucesso.");
						}
						else{
							Util::log($pedido. " - erro na atualizacao do fluxo. $sql2 : ".mysql_error());
						}
						
						header("Location: ".$ROOTPATH."/index.php");	
						?> 
						<meta http-equiv="refresh" content="0; url=<?=$ROOTPATH?>?pg=true"><?
						exit;
					} 
					Utility::Redirect( WEB_ROOT );	
				}
			}
			else {
			
				Util::log("Pedido: ".$ProdID_1. " - Pedido com status nao aprovado: ".$status);
				$body =  "O pedido numero ".$ProdID_1." ainda nao foi aprovado pelo pagamento digital. O status esta ".$status .". Por isso ainda nao houve alteracao no status deste pedido no sistema de ofertas.";
				
				 $to = $INI['pagamentodg']['acc']; 
				 $site = $INI['system']['sitename']; 
				 $body = " <h3>Dados da Compra</h3>
				 <br>Email da conta do pagamento digital: <b>".$to."</b>
				 <br> Numero do pedido no sistema de ofertas: <b>".$ProdID_1."</b>
				 <br> Nome do cliente: <b>".$cliente_nome."</b> 
				 <br> Email do cliente: <b>".$cliente_email."</b> 
				 <br> Status da transacao: <b>".$status ."</b>   
				  <br> Codigo do Status: <b>".$cod_status  ."</b>   
				 <br> Tipo do pagamento: <b>".$tipo_pagamento."</b>   
				 <br> Produto comprado: <b>".$produto_descricao."</b>   
				 <br> Codigo produto: <b>".$produto_codigo."</b>   
				 <br> Data do pagamento: <b>".$data_transacao."</b> " ;
						 
				 $body = utf8_encode($body); 
				 
				if(Util::postemail($body,utf8_decode($site. " - Pedido ".$ProdID_1." ".$status))){
					Util::log("Pedido: ".$ProdID_1. " - Email enviado para (".Util::getFrom().")... Retornando para a loja ");
				}
				else{
					 Util::log("Pedido: ".$ProdID_1. " - Erro no envio do email (".Util::getFrom().")... Retornando para a loja ");
				}
			} 
		} 
		else if ($result == "FALSO") {
	
	     Util::log("Pedido: ".$ProdID_1. " - Token nao validado.");
	 
		 $to = $INI['pagamentodg']['acc']; 
		 $body = "Retorno Pagamento Digital - token nao foi validado -  result retornou um false. <br> 
		 Confirme seu token no painel do pagamento digital: token: <b>".$token ."</b>  
		 <br>Email da conta do pagamento digital: <b>".$to."</b>
		 <br> Numero do pedido no sistema de ofertas: <b>".$ProdID_1."</b>
		 <br> Nome do cliente: <b>".$cliente_nome."</b> 
		 <br> Email do cliente: <b>".$cliente_email."</b> 
		 <br> Status da transacao: <b>".$status ."</b>   
	     <br> Codigo do Status: <b>".$cod_status  ."</b>   
		 <br> Tipo do pagamento: <b>".$tipo_pagamento."</b>   
		 <br> Produto comprado: <b>".$produto_descricao."</b>   
		 <br> Codigo produto: <b>".$produto_codigo."</b>   
		 <br> Data do pagamento: <b>".$data_transacao."</b> " ;
		 
		 $body = utf8_decode($body);
		 Util::postemail($body,utf8_decode($site. "Token nao validado."));

	} else {
	
		Util::log("Pedido: ".$ProdID_1. " - Erro na integracao com o pagamento digital.");
	 
		 $to = $INI['pagamentodg']['acc']; 
		 $body = "Retorno Pagamento Digital - erro na integracao <br>  Os dados nao foram atualizados no sistema de ofertas.<br>
		 <br> Numero do pedido no sistema de ofertas: <b>".$ProdID_1."</b>
		 <br> Nome do cliente: <b>".$cliente_nome."</b> 
		 <br> Email do cliente: <b>".$cliente_email."</b> 
		 <br> Status da transacao: <b>".$status ."</b> 
		 <br> Codigo do Status: <b>".$cod_status  ."</b>   
		 <br> Tipo do pagamento: <b>".$tipo_pagamento."</b>   
		 <br> Produto comprado: <b>".$produto_descricao."</b>   
		 <br> Codigo produto: <b>".$produto_codigo."</b>   
		 <br> Data do pagamento: <b>".$data_transacao."</b> " ;
		 
		 $body = utf8_decode($body);
		 $body =  $body."<br><br>Parametros: <br>".$param;
		 Util::postemail($body,utf8_decode($site. "Erro na integracao com o pagamento digital."));
	}

} else {
	Util::log("POST nao recebido, aguarde alguns instantes");
}
 header("Location: ".$ROOTPATH."/index.php?pg=true");		


 
?>
 <meta http-equiv="refresh" content="0; url=<?=$ROOTPATH?>?pg=true">