<?php
need_login();

global $INI;
$nomesite = $INI['system']['sitename'];

if(empty($_POST['item'])){
	 redirect( WEB_ROOT . "/carrinho");
}
$sql = "ALTER TABLE `order` ADD `partner_id` INT NULL AFTER `user_id` ";
$rs = mysql_query($sql);

/* Pontuação adicionada a cada vez que um vendedor recebe um pedido. */
$pts = 2;
   
//if($_POST['existefrete'] =="sim"){
if($_POST['modo_envio']){
	$nome_metodo = get_nomemetodo($_POST['modo_envio']);
	if(eh_metodosistema($_POST['modo_envio'])){
 
		$respostafrete = fretecarrinho(getCepDestino($login_user),$_POST['modo_envio']);
		$fretearr =  explode("-",$respostafrete);
		$valorfrete = $fretearr[1];
		$prazofrete = $fretearr[2];
	}
	else{
		 $valorfrete = get_valorfrete_manual($_POST['modo_envio']);
		 $prazofrete = get_prazo_manual($_POST['modo_envio']);
	}
} 
if($valorfrete==""){
	$valorfrete = 0;
} 
if($prazofrete==""){
	$prazofrete = 0;
}
if($INI['system']['diasadicionais'] !=""){
	$prazofrete = $prazofrete + $INI['system']['diasadicionais'];
} 
//setando o tipo do frete para os gateways ex: pagseguro
if(ehsedex($_POST['modo_envio'])){
	$tipofrete="SD";
}
else{
	$tipofrete="EN";
}

 
$items = RemoveXSS($_POST['item']);

/* É preciso verificar se é um parceiro ou usuário comum cadastrado no banco de dados. */
if(isset($login_user_id) and !(empty($login_user_id))) {
	$usuario = $login_user_id;
} else {
	$usuario = $login_partner_id;
}

$datapedido = date("Y-m-d H:i:s");
$state = 'unpay';
$time = time();
 
foreach ($items as $item) {
	$quantidade = $_POST["qty_{$item}"];
	$quantidadepedido += $quantidade;	
	/* Como é apenas um produto por vez, o loop efetua o laço apenas uma vez. Assim pego a ID do vendedor e grava na tabela de pedidos. */
	$team = Table::Fetch('team', $item);
	$vendedor = Table::Fetch('user', $team['partner_id']);
	$cliente = Table::Fetch('user', $login_user['id']);
}

 $totalpedido =  str_replace(",","",$totalpedido);

 $codigocupom = RemoveXSS($_POST['codigocupom']);  
 $valecompras = Table::Fetch('valecompras', $codigocupom,'codigo');
 
 if($valecompras[status]=="ativo"){
	$cupomdesconto = $codigocupom;
	$valorcupomdesconto = $valecompras[valor];
	grava_status_entrega("Vale cupom ( $codigocupom ) de R$ $valorcupomdesconto foi adicionado com sucesso",$id);	
	
	$sql = "update `valecompras` set usado = usado + 1 where codigo='$cupomdesconto'";
	$rs = mysql_query($sql);
	if(!$rs){
		echo mysql_error();
	}
 }
 
$status = "Aguardando Pagamento";
 
$SQL = "INSERT INTO `order` (`datapedido`, `user_id`, `partner_id`, `quantity`, `origin`, `create_time`, `valorfrete`,`prazofrete`,`modo_envio`,`valecompras`,`codigovalecompras`,`statusliberacao`) VALUES
('{$datapedido}', {$usuario}, {$vendedor['id']}, $quantidadepedido, '', '{$time}', '{$valorfrete}','{$prazofrete}','{$nome_metodo}', '$valorcupomdesconto','$cupomdesconto', '$status')";
 
$pagina = "pedido";

$resultado = mysql_query($SQL);
$id = mysql_insert_id();

if($id){
	
	grava_status_entrega("Pedido recebido com sucesso",$id); 
  
	$cidade = RemoveXSS($_POST['entrega_cidade']);
	$cep = RemoveXSS($_POST['entrega_cep']);
	$bairro = RemoveXSS($_POST['entrega_bairro']); 
	$estado = RemoveXSS($_POST['entrega_estado']);
	$endereco = RemoveXSS($_POST['entrega_endereco']);
	$numero = RemoveXSS($_POST['entrega_numero']);
	$complemento = RemoveXSS($_POST['entrega_complemento']);   
		
	$sql = "insert into order_enderecos set entrega_cidade = '$cidade',entrega_cep = '$cep',entrega_bairro = '$bairro',entrega_estado = '$estado',entrega_endereco = '$endereco',entrega_numero = '$numero',entrega_complemento = '$complemento',idpedido='$id'";
	$rs =  mysql_query($sql);   
	if(!$rs){
		echo " Não foi possivel inserir este endereço. Entre em contato conosco.";
		exit;
	}	
}
				
$totalpedido = 0;
$quantidadepedido = 0;
 
foreach ($items as $item) {
	$qty = "qty_" . $item;
	$quantidade = $_POST[$qty];
	$quantidadepedido += $quantidade;
	$team = Table::Fetch('team', $item);
	$preco = $team['team_price'];
	$total = $preco*$quantidade;
	$totalpedido += $total;
	$total =  str_replace(",","",$total);
	$preco =  str_replace(",","",$preco);
	$condbuy = $_SESSION['condbuy_'.$item];
	$condbuy2 = $_SESSION['condbuy2_'.$item];
	$uploadarquivo = $_SESSION['uploadarquivo_'.$item];
	
	/* Ínicio das regras para calcular comissão do site e valor do pagamento do vendedor. */
	if(!(empty($INI['system']['comissao']))) {		
		$comissao = $INI['system']['comissao'];
	}
	
	if(!(empty($cliente['comissao'])) and $cliente['comissao'] != 0) {
		$comissao = $cliente['comissao'];
	}	

	/* Se for determinado algum valor especial de comissão para determinado usuário, este
	   valor irá sobreescrever o valor padrão do site.
	*/
	$comissaosite = (($total * $comissao) / 100);
	//$valorvendedor = $total - $comissaosite + $valorfrete;
	if(!(empty($team['seguro_val']))) {
		$valorvendedor = $total - ($comissaosite + $team['seguro_val']);
	}
	else {
		$valorvendedor = $total - $comissaosite;
	}
	
	$GerarFatura = 1;
	
	/* Neste ponto é verificado se o vendedor tem algum bônus. */
	$order = Table::Fetch('order', $id);
	$bonus = getSaldo($order['partner_id']);
	
	/* Como os créditos são retornados com valor negativo, é multiplicado por negativo para
	   ficar positivo.		
	*/
	if($bonus < 0) {
		$bonus = $bonus * (-1);
	}
	else {
		/* Neste caso é quando o vendedor não possui créditos. */
		$bonus = 0;
	}
	
	/* Caso o valor do bônus seja superior ou igual ao valor da comissão, não é gerado uma nova fatura.
	*/
	if($bonus >= $comissaosite) {
		$GerarFatura = 0;
	}
	else if($bonus < $comissaosite) {
		$comissaosite = $comissaosite - $bonus;
		$status = "unpay";
		$descricao = "Fatura comissão - Valor parcial pago com créditos";
	}
	/* Alguns padrões para a geração da fatura. */
	$pagamento = "PagSeguro";
	$descricao = "Fatura comissão";

	/* Fim das regras para calcular comissão do site e valor do pagamento do vendedor. */
	
	if($item){
		$SQL2 = "INSERT INTO order_team VALUES ({$id}, {$item}, {$quantidade}, {$preco}, {$total},'$condbuy','$condbuy2','$uploadarquivo');";
		mysql_query($SQL2) or die(mysql_error() . "==>".$SQL2);
		
		
		/* A fatura não é gerada apenas quando o valor total do pedido é pago pelos créditos.  */
		if($GerarFatura == 1) {
			/* Informações de fatura são inseridos no banco de dados. Apenas informações padrões e básicas são gravadas. */
			$sqlB = "insert into faturas(id_user, forma_pagamento, valor, descricao, data_geracao, status) values('" . $vendedor['id'] . "', '" . $pagamento . "', '" .$comissaosite . "', '" . $descricao . "', '" . $datapedido . "', '" . $status . "')";
			mysql_query($sqlB) or die(mysql_error() . "==>".$sqlB);
			
			/* É feito o envio automático da fatura para o email do vendedor.
			$id_billi = mysql_insert_id();
			
			$parametros = array('id_billi' => $id_billi);
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
			$mensagem = file_get_contents($INI["system"]["wwwprefix"]."/templates/envio_fatura.php", false, $request);
			
			/* É feito o envio de email ao vendedor com informações sobre a fatura gerada.. 
			enviar($vendedor['email'], $nomesite . "- Fatura", $mensagem);
			*/
		}
	}
} 
$sql = "update `order` set origin =  '$totalpedido', comissaosite = '$comissaosite', valorvendedor = '$valorvendedor', porcentagem = '$comissao' where id=$id";
$rs = mysql_query($sql);
if(!$rs){
	echo "<h3>".mysql_error()."</h3>";
	exit;
}

			
/* O estoque é atualizado.
$estoque = (int) $team['max_number'] - (int) $quantidade;
$sqlE = "update team set max_number = " . $estoque . " where id = " . $team['id'];
$rsE = mysql_query($sqlE);
*/
			
$order_id = $id;
$order = Table::Fetch('order', $order_id);

$options = Table::Fetch('options', (int) strip_tags($_POST['id_option']));

if(!(empty($options))) {
	
	$stock = (int) $options['stock'] - (int) $quantidade;
	$stock = $stock < 0 ? 0 : $stock;
	$sqlE = "update options set stock = " . $stock . " where id = " . (int) strip_tags($_POST['id_option']);
	$rsE = mysql_query($sqlE);

	$sqlU = "update `order` set id_option = " . (int) strip_tags($_POST['id_option']) . " where id = " . $order_id;
	$rsU = mysql_query($sqlU);
}

$parametros = array( 'realname' => $login_user['realname'], 'id' => $order['id'],'remark' =>  RemoveXSS($_REQUEST['remark']));
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
$emailadmin = $INI['mail']['from'];
$arquivotemplate = "confirmacao_pedido.php"; 
 
//envia email para cliente 
 $mensagem = file_get_contents($INI["system"]["wwwprefix"]."/templates/".$arquivotemplate, false, $request);
 enviar( $login_user['email'],"Pedido recebido, falta pouco",$mensagem);
 grava_status_entrega("Email de pedido realizado enviado para ".$login_user['email'],$id); 

// envia o mesmo email para o administrador
$bodyadmin="----------  CÓPIA DE EMAIL ENVIADA PARA O ADMINISTRADOR ----------<BR>";
$mensagem =  $bodyadmin.$mensagem;
enviar( $emailadmin ,ASSUNTO_NOVO_PEDIDO_CLIENTE,$mensagem);
grava_status_entrega("Cópia do email enviado para administrador ".$emailadmin,$id); 

// envia o mesmo email para o vendedor
/*
$arquivotemplate = "confirmacao_pedido_vendedor.php"; 
$mensagem = file_get_contents($INI["system"]["wwwprefix"]."/templates/".$arquivotemplate, false, $request);
enviar($vendedor['email'] , ASSUNTO_NOVO_PEDIDO_CLIENTE, $mensagem);
grava_status_entrega("Email de pedido recebido " . $vendedor['email'], $id); 
*/

$mensagem="";
unset($mensagem);

UpdatePoints($pts, $vendedor['id']);