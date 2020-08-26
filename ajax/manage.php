<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
require_once(dirname(dirname(__FILE__)) .'/util/Util.php');
global $INI;

//need_manager();

$action = strval($_REQUEST['action']);
$id = abs(intval($_GET['id']));

if ( 'orderrefund' == $action) {
	need_auth('admin');
	$order = Table::Fetch('order', $id);
	$rid = strtolower(strval($_GET['rid']));
	if ( $rid == 'credit' ) {
		ZFlow::CreateFromRefund($order);		
	} else { 
		Table::UpdateCache('order', $id, array(
					'service' => 'cash',
					'state' => 'unpay'
			));
	}
	/* team -- */
	$team = Table::Fetch('team', $order['team_id']);
	team_state($team);
	if ( $team['state'] != 'failure' ) {
		$minus = $team['conduser'] == 'Y' ? 1 : $order['quantity'];
		Table::UpdateCache('team', $team['id'], array(
					'now_number' => array( "now_number - {$minus}", ),
		));
	}
	/* card refund */
	if ( $order['card_id'] ) {
		Table::UpdateCache('card', $order['card_id'], array(
			'consume' => 'N',
			'team_id' => 0,
			'order_id' => 0,
		));
	}
	/* coupons */
	if ( in_array($team['delivery'], array('coupon', 'pickup') )) {
		$coupons = Table::Fetch('coupon', array($order['id']), 'order_id');
		foreach($coupons AS $one) Table::Delete('coupon', $one['id']);
	}

	/* order update */
	Table::UpdateCache('order', $id, array(
				'card' => 0,
				'card_id' => '',
				'express_id' => 0,
				'express_no' => '',
				));
	Session::Set('notice', 'Reembolsado');
	json(null, 'refresh');
}
elseif ( 'orderremove' == $action) {
	need_auth('order');
	$order = Table::Fetch('order', $id);
	if ( $order['state'] != 'unpay' ) {
		json('As ordens de pagamento não podem ser excluidas', 'alert');
	}
	/* card refund */
	if ( $order['card_id'] ) {
		Table::UpdateCache('card', $order['card_id'], array(
			'consume' => 'N',
			'team_id' => 0,
			'order_id' => 0,
		));
	}
	Table::Delete('order', $order['id']);
	Session::Set('notice', "Ordem de compra {$order['id']} apagada com sucesso");
	json(null, 'refresh');
}
else if ( 'depoimentoremove' == $action ) {
	 
	$boates = Table::Fetch('avaliacao_produto', $id); 
	if ($boates) {
		Table::Delete('avaliacao_produto', $id);
		Session::Set('notice', "Depoimento: {$id} Apagado com sucesso");
		json(null, 'refresh');
	}
	 
	 Session::Set('notice', 'Falha ao apagar este depoimento');
	 json(null, 'refresh'); 
}
else if ( 'zonasremove' == $action ) {
	 
	$temreg = Table::Fetch('zonas_entrega', $id); 
	if ($temreg) {
		Table::Delete('zonas_entrega', $id);
		Session::Set('notice', "Registro deletado com sucesso");
		json(null, 'refresh');
	}
	 
	 Session::Set('notice', 'Falha ao apagar este depoimento');
	 json(null, 'refresh'); 
}

elseif ( 'duplicar' == $action) {
 
	$id = $_REQUEST['id'];
 
	$sql = "INSERT INTO team (  `minimo_pessoa`, `user_id`, `layout`, `title`, `summary`, `city_id`, `group_id`, `partner_id`, `system`, `team_price`, `preco_comissao`, `market_price`, `product`, `condbuy`, `per_number`, `min_number`, `max_number`, `now_number`, `pre_number`,  `flv`, `mobile`, `credit`, `card`, `fare`, `farefree`, `bonus`, `address`, `detail`, `systemreview`, `userreview`, `notice`, `express`, `delivery`, `state`, `conduser`, `buyonce`, `team_type`, `sort_order`, `expire_time`, `begin_time`, `end_time`, `reach_time`, `close_time`, `seo_title`, `seo_keyword`, `seo_description`, `posicionamento`, `semhtmldescricao`, `semhtmlregulamento`, `manterdimensao`, `maisinformacoes`, `metodo_pagamento`, `bonuslimite`, `retornoparticipe`, `url_comprar`, `posicionamentotitulo`, `marcadagua`, `processo_compra`, `categoria_agrupi`, `categoria_valejunto`, `cidade_valejunto`, `categoria_apontaofertas`, `cidade_apontaofertas`, `categoria_dsconto`, `frete`, `ceporigem`, `peso`, `altura`, `comprimento`, `valorfrete`, `largura`, `fretegratuito`, `republicacao`, `pontos`, `pontosgerados`, `idpacote`, `estatica_home`, `estatica_direita`, `estatica_detalhe`, `estatica_recentes`, `id_oferta_parceiro`, `codreferencia`, `mostrarpreco`, `condicaoenvio`, `uploadarquivo`, `condbuy2`, `contadorpedidos`, `avaliacaoclientes`, `nomeaba1`, `nomeaba2`, `observacao_preco`, `titulo_opcao2`, `titulo_opcao1`, `titulo_upload`) 
	SELECT    `minimo_pessoa`, `user_id`, `layout`, `title`, `summary`, `city_id`, `group_id`, `partner_id`, `system`, `team_price`, `preco_comissao`, `market_price`, `product`, `condbuy`, `per_number`, `min_number`, `max_number`, `now_number`, `pre_number`,`flv`, `mobile`, `credit`, `card`, `fare`, `farefree`, `bonus`, `address`, `detail`, `systemreview`, `userreview`, `notice`, `express`, `delivery`, `state`, `conduser`, `buyonce`, `team_type`, `sort_order`, `expire_time`, `begin_time`, `end_time`, `reach_time`, `close_time`, `seo_title`, `seo_keyword`, `seo_description`, `posicionamento`, `semhtmldescricao`, `semhtmlregulamento`, `manterdimensao`, `maisinformacoes`, `metodo_pagamento`, `bonuslimite`, `retornoparticipe`, `url_comprar`, `posicionamentotitulo`, `marcadagua`, `processo_compra`, `categoria_agrupi`, `categoria_valejunto`, `cidade_valejunto`, `categoria_apontaofertas`, `cidade_apontaofertas`, `categoria_dsconto`, `frete`, `ceporigem`, `peso`, `altura`, `comprimento`, `valorfrete`, `largura`, `fretegratuito`, `republicacao`, `pontos`, `pontosgerados`, `idpacote`, `estatica_home`, `estatica_direita`, `estatica_detalhe`, `estatica_recentes`, `id_oferta_parceiro`, `codreferencia`, `mostrarpreco`, `condicaoenvio`, `uploadarquivo`, `condbuy2`, `contadorpedidos`, `avaliacaoclientes`, `nomeaba1`, `nomeaba2`, `observacao_preco`, `titulo_opcao2`, `titulo_opcao1`, `titulo_upload` FROM team
	WHERE id = ".$id ;
	$rs = mysql_query($sql);
	
	 //Session::Set('notice', $sql);
	json(null, 'refresh');
}
else if ( 'ordercash' == $action ) {
	//need_auth('order');
	
	$order = Table::Fetch('order', $id); 
	$user = Table::Fetch('user', $order['user_id']);
	$hoje =  date("Y-m-d H:i:s");
 	Table::UpdateCache('order', $id, array(
		'state' => 'pay', 
		'datapagamento' => $hoje, 
		'data_ultima_atualizacao' => $hoje, 
	));
	
	grava_status_entrega("Pedido alterado para pago manualmente via administração ".$emailadmin,$id);
	email_pagamento_aprovado($id);
	grava_status_entrega("Email enviado para o cliente com sucesso",$id);
	
	/* É buscado informações do vendedor do produto em questão. */			
	$SqlPartner = "select * from user where id = " . $order['partner_id'];
	$RsPartner = mysql_query($SqlPartner);
	$RowPartner = mysql_fetch_assoc($RsPartner);

	$parametros = array('realname' => $RowPartner['realname'], 'id' => $order['id'],
		$request_params = array(
			'http' => array(
			'method'  => 'POST',
			'header'  => implode("\r\n", array(
			'Content-Type: application/x-www-form-urlencoded',
			'Content-Length: ' . strlen(http_build_query($parametros)),
			)),
			'content' => http_build_query($parametros),
		))
	);

	$request  = stream_context_create($request_params);
	$emailadmin = $INI['mail']['from'];
	$arquivotemplate = "confirmacao_liberacao_pagamento.php"; 
	$assunto = utf8_decode("Vendeu! Uhuu");

	//envia email para cliente 
	$template_email = $INI["system"]["wwwprefix"]."/templates/". $arquivotemplate . "?id=" . $order['id'] . "&realname=" . urlencode($RowPartner['realname']);
	$mensagem = file_get_contents($template_email);
	enviar($RowPartner['email'], $assunto, $mensagem);
	//exit;
	grava_status_entrega("Email de pedido realizado enviado para ". $RowPartner['email'], $id); 

	$items = mysql_query("SELECT * FROM order_team WHERE order_id = ".$id);
	while ($item = mysql_fetch_array($items, MYSQL_ASSOC)) {
				 $team_qty = $item[team_qty];
				 $sql = "UPDATE team SET now_number = now_number + ".$team_qty. " WHERE id =". $item[team_id]  ;
				 mysql_query($sql) or die(mysql_error() . "==>".$sql);
	}
	
	Session::Set('notice', "Pedido alterado para pago com sucesso. O cliente foi notificado.");
	json(null, 'refresh');
}
else if ( 'ordercashseller' == $action ) {
	//need_auth('order');
	$emailadmin = $INI["mail"]["from"];
	$statusliberacao = "Valor pago direto pelo cliente";
	$order = Table::Fetch('order', $id); 
	$user = Table::Fetch('user', $order['user_id']);
	$hoje =  date("Y-m-d H:i:s");
 	Table::UpdateCache('order', $id, array(
		'state' => 'pay', 
		'datapagamento' => $hoje, 
		'data_ultima_atualizacao' => $hoje, 
	));
	
	grava_status_entrega("Pedido alterado para pago manualmente via adminanunciante ".$emailadmin,$id);
	email_pagamento_aprovado($id);
	grava_status_entrega("Email enviado para o cliente com sucesso",$id);	
	
	$items = mysql_query("SELECT * FROM order_team WHERE order_id = ".$id);
	while ($item = mysql_fetch_array($items, MYSQL_ASSOC)) {
				 $team_qty = $item[team_qty];
				 $sql = "UPDATE team SET now_number = now_number + " . $team_qty. " WHERE id =" . $item[team_id]  ;
				 mysql_query($sql) or die(mysql_error() . "==>".$sql);				 
				 
				 $sql = "UPDATE `order` SET statusliberacao = '" . $statusliberacao . "' WHERE id =". $id;
				 mysql_query($sql) or die(mysql_error() . "==>".$sql);
	}

	$parametros = array('idpedido' => $id);
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
	$body = file_get_contents($INI["system"]["wwwprefix"]."/templates/pedido_pago_usuario.php", false, $request);

	if(Util::postemailCliente($body, $INI['system']['sitename'] . " - Pedido pago", $emailadmin)){
		Util::log($id. " - Email para o administrador, notificando sobre pagamento pago manualmente na admin.". $emailadmin); 
		echo "Status do pedido alterado com sucesso"; 
	 }
	else{
		Util::log($id. " - Erro no envio do email para ".$user['email']); 
		echo "Não conseguimos enviar o email para " . $emailadmin . ". Mas o status foi alterado com sucesso."; 
	}
	 
	
	Session::Set('notice', "Pedido alterado para pago com sucesso. O cliente foi notificado.");
	json(null, 'refresh');
}
else if ( 'teamremoveall' == $action ) {

	need_auth('order');
	$id = $_REQUEST['id']; 
	Util::log("DELETANDO TODOS OS ANUNCIOS E SUAS REFERENCIAS" );
   
	$sql  = "DELETE FROM team";
	$rs  = mysql_query($sql );	
	
	$sql  = "DELETE FROM  questions";
	$rs  = mysql_query($sql );	
	
	$sql  = "DELETE FROM  qualification";
	$rs  = mysql_query($sql );	
	
	$sql  = "DELETE FROM  `order`";
	$rs  = mysql_query($sql );	
	
	$sql  = "DELETE FROM  `order_enderecos`";
	$rs  = mysql_query($sql );
	
	$sql  = "DELETE FROM  faturas";
	$rs  = mysql_query($sql );	
	 
	if($rs){
		Session::Set('notice', 'Todos os anuncios foram excluidos com sucesso bem como todas as referencias.');
	}
	else{
		Session::Set('notice', 'Não foi possivel excluir os anúncios '.$sql. ' '. mysql_error());
	}
	json(null, 'refresh');
}
else if ( 'statusentrega' == $action ) {
 
	//need_auth('order');
	
	$order = Table::Fetch('order', $id); 
	$user = Table::Fetch('user', $order['user_id']);
	$hoje =  date("Y-m-d H:i:s");
 	Table::UpdateCache('order', $id, array(
		'statusentrega' => $_REQUEST[statusentrega], 
		'data_ultima_atualizacao' => $hoje, 
	));
	 
	grava_status_entrega($_REQUEST[statusentrega],$id); 
	 
	$parametros = array('idpedido' => $id);
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
	$body = file_get_contents($INI["system"]["wwwprefix"]."/templates/statusentrega.php", false, $request);

	if(Util::postemailCliente($body,ASSUNTO_STATUS_ENTREGA,$user['email'])){
		Util::log($id. " - statusentrega - Email para o cliente enviado com sucesso ".$user['email']); 
		echo "Status do pedido alterado com sucesso e email enviado para ".$user['email']; 
	 }
	else{
		Util::log($id. " - statusentrega - Erro no envio do email para ".$user['email']); 
		echo "Não conseguimos enviar o email para ".$user['email'].". Mas o status foi alterado com sucesso."; 
	}
	 
	 //Session::Set('notice', "Alteração de status realizada com sucesso. Enviamos um email para : {$user['email']}");
	 //json(null, 'refresh');
}

else if ( 'ordercancel' == $action ) {
 
	//need_auth('order');
	
	$order = Table::Fetch('order', $id); 
	$user = Table::Fetch('user', $order['user_id']);
	$hoje =  date("Y-m-d H:i:s");
 	Table::UpdateCache('order', $id, array(
		'statuspedido' => 'cancelado', 
		'datacancelamento' => $hoje, 
		'data_ultima_atualizacao' => $hoje, 
	));
	  
	  grava_status_entrega("Pedido cancelado",$id);	
	  
	  Session::Set('notice', "Pedido cancelado");
	 json(null, 'refresh');
}
else if ( 'verifica_categoria' == $action ) {
	
	$idcategoria = $_REQUEST['idcategoria'];
 
	$sql = "select titulo from page where status = 1 and category_id = ".$idcategoria ;
	$rs = mysql_query($sql);
	$row = @mysql_fetch_object($rs);  
	$titulo 	= $row->titulo;
	echo $titulo;
	
}
else if ( 'reenviacupomforce' == $action ) {

	need_auth('order');
	$id = $_REQUEST['id'];
	$origem = $_REQUEST['origem'];
	Util::log($id ." - Reenvio de cupom: ".$id. " origem: ".$origem);
	
	$order = Table::Fetch('order', $id);
	$team = Table::Fetch('team', $order['team_id']);
  
	$sql = "select a.id,a.secret,a.order_id,a.nome,b.username,b.email,c.title,c.homepage,c.location,c.address,c.chavesms  from coupon a,user b, partner c where a.partner_id = c.id and a.user_id = b.id and a.id = ".$id ;
	$rs = mysql_query($sql);
	$row = mysql_fetch_object($rs);  
   
		$numcupom 	= $row->id;
		$senha 		= $row->secret; 
		$pedido  	= $row->order_id; 
		$email 		= $row->email; 
		$nome 		= $row->nome; 
		$username  	= $row->username; 
		$parceiro  	= $row->title ; 
		$homepage   = $row->homepage  ; 
		$location   = $row->address  ; 
		$complemento = $row->chavesms; 
		$location =  $location. " ".$complemento;

		
		Util::log("Pedido: ".$pedido. " - Numero do cupom: $numcupom - senha: $senha - Utilizador: $nome");
		$msg.="<br>Pedido: ".$pedido. " - Numero do cupom: $numcupom - senha: $senha - Utilizador: $nome";
		$url = $INI['system']['wwwprefix']; 
		$url.= $url."/pedidos";
	  
		$parametros = array('oferta' => $team['title'], 'username' => $username, 'numcupom' => $numcupom, 'senha' => $senha,  'utilizador' => $nome ,'parceiro' => $parceiro, 'location' => $location, 'homepage' => $homepage  );
 
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

		if(Util::postemailCliente($body,$INI['system']['sitename']. " - ".ASSUNTO_ENVIO_CUPOM. ": ".displaySubStringWithStrip(utf8_decode($team['title']),80),$email)){
			Util::log($pedido. " - Email para o cliente com dados do cupom enviado com sucesso(".$email.")...");
			$msg.="<br>Email para o cliente com dados do cupom enviado com sucesso(".$email.").";
			
			$sql2 = "update coupon set envioucupom =1 where id = '".$numcupom."'";
			$rs2 = mysql_query($sql2);
			if($rs2){
				Util::log($pedido. " - campo envioucupom atualizado.");
			 }
			 else{
				Util::log($pedido. " - campo envioucupom nao atualizado. $sql2");
			 }
	
		}
		else{
			Util::log($pedido. " - Erro no envio do email... Este cupom não foi enviado (".$email.") .");
			$msg.= "<br>Erro no envio do email... Este cupom não foi enviado (".$email.")";
		}
			 

	 if( !$achou){
		Util::log($id. " - ".$msg);
		Session::Set('notice', $msg);
	 }
	else{
		Session::Set('notice',$msg);
	 }
 
	json(null, 'refresh');
}


else if ( 'cupomconsume' == $action ) {

	need_auth('order');
	$id = $_REQUEST['id']; 
	Util::log($id ." - cupom consume: ".$id );
	
	$sql  = "update coupon set consume ='Y', consume_time='".time()."' where id = ".$id;
	$rs  = mysql_query($sql );

	Session::Set('notice', 'Cupom '.$id.' consumido com sucesso.');
 
	json(null, 'refresh');
}
else if ( 'cupomnaoconsume' == $action ) {

	need_auth('order');
	$id = $_REQUEST['id']; 
	Util::log($id ." - cupom consume: ".$id );
   
	$sql  = "update coupon set consume ='N' where id = ".$id;
	$rs  = mysql_query($sql );

	Session::Set('notice', 'Cupom '.$id.' liberado para o consumo com sucesso.');
 
	json(null, 'refresh');
}
else if ( 'pageremove' == $action ) {

	need_auth('market');
	$id = $_REQUEST['id']; 
	Util::log($id ." - deletando paginas: ".$id );
   
	$sql  = "delete from page where id = ".$id;
	$rs  = mysql_query($sql );

	Session::Set('notice', 'Página excluída com sucesso.');
 
	json(null, 'refresh');
}
else if ( 'cupomremove' == $action ) {

	need_auth('order');
	$id = $_REQUEST['id']; 
	Util::log($id ." - deletando cupom: ".$id );
   
	$sql  = "delete from coupon where id = ".$id;
	$rs  = mysql_query($sql );

	Session::Set('notice', 'Cupom '.$id.' excluído com sucesso.');
 
	json(null, 'refresh');
}
else if ( 'orderremoveforce' == $action ) {

	//need_auth('order');
	$id = $_REQUEST['id']; 
	Util::log($id ." - deletando pedido: ".$id );
   
	$sql  = "DELETE FROM `order` WHERE `id` = ".$id;
	$rs  = mysql_query($sql );

	if($rs){
		Session::Set('notice', 'Pedido '.$id.' excluído com sucesso.');

		$strSQL = "SELECT * FROM order_team WHERE order_id = '{$order["id"]}' ";
		
		$objRs = mysql_query($strSQL);
		while($row = mysql_fetch_array($objRs)){		
			$update = "update team set max_number = (max_number + ".$row['team_qty'].") where id = ".$row['team_id'];
			$rs = mysql_query($update);
			Util::log($update);
		}
	}
	else{
		Session::Set('notice', 'Pedido '.$id.' não excluído. '.$sql. ' '. mysql_error());
	}
	json(null, 'refresh');
}
else if ( 'enviaemailuser' == $action ) {
 
	set_time_limit(0) ;
	need_auth('market');
	
	$assunto = $_REQUEST['assunto'];  
	$mensagem = $_REQUEST['mensagem']; 
	$mensagem = str_replace("|","&",$mensagem);	
	$mensagem = str_replace("#","/../",$mensagem);	
	$mensagem =  utf8_decode($mensagem); 
	$mensagem = str_replace("../../../uploads/","$ROOTPATH/uploads/",$mensagem);  // ambientes de producao
	//$mensagem = str_replace("../../uploads/","$ROOTPATH/uploads/",$mensagem);  // descomente para clientes
	
	$emails = base64_decode($_REQUEST['chave']);  
	$qtde = base64_decode($_REQUEST['recp']);  

 
	//$mensagem = str_replace("../../uploads/","$ROOTPATH/uploads/",$mensagem);  
	
	$emails = explode(",",$emails);
	
		foreach($emails AS $one) { 
		 

		 
		if(Utility::ValidEmail($one) and $one!=""){
			//$one = "contato@vipcomsistemas.com.br";
			if(enviar($one, $assunto, $mensagem)){
				//$sql  = "insert into log_emailuser (email,data,assunto) values('$one','".date("Y-m-d H:i:s")."','$assunto')";
				//$rs  = mysql_query($sql );
				Util::log('enviando email vipmin: '.$one.' - '.date("Y-m-d H:i:s"). 'sucesso' );
				echo "true";
				
			}
			else{
				//$sql  = "insert into log_emailuser (email,data,assunto,erro) values('$one','".date("Y-m-d H:i:s")."','$assunto',1)";
				//$rs  = mysql_query($sql );
				Util::log('enviando email vipmin: '.$one.' - '.date("Y-m-d H:i:s"). 'erro 1' );
			}
			//sleep($INTERVALO_ENVIO_EMAILS_INDIQUE);
			sleep(1);
		}
		else{
				//$sql  = "insert into log_emailuser (email,data,assunto,erro) values('$one','".date("Y-m-d H:i:s")."','$assunto',2)";
				//$rs  = mysql_query($sql );
				Util::log('enviando email vipmin: '.$one.' - '.date("Y-m-d H:i:s"). 'email invalido' );
		}
	}   

}
else if ( 'salvar_modelo' == $action ) {
 
	need_auth('market');
	 
	$assunto = $_REQUEST['assunto'];  
	$mensagem = $_REQUEST['mensagem']; 
	$mensagem = str_replace("|","&",$mensagem);	
	$mensagem =  utf8_decode($mensagem);
	$idmodelo = trim($_REQUEST['idmodelo']);  
  
	if($idmodelo!="" and $idmodelo!="0" and $idmodelo!="00"){
	    $sql  = "update modelos_email  set texto = '$mensagem', assunto = '$assunto' where id = $idmodelo";
		$rs  = mysql_query($sql );
		echo "true";
	}
	else{
		$sql  = "insert into modelos_email (texto,data,assunto) values('$mensagem','".date("Y-m-d H:i:s")."','$assunto')";
		$rs  = mysql_query($sql );
		echo mysql_insert_id();
	}
	if(!$rs){
		//echo  'Erro em salvar este modelo '.$sql. ' '. mysql_error();
	 } 	 
	 sleep(1);
}

else if ( 'salvar_pagina' == $action ) {
 
	need_auth('market');
	 
	$titulo = 	 	$_REQUEST['titulo'] ;  
	$status = 	 	$_REQUEST['status'] ;  
	$mensagem =  	$_REQUEST['mensagem'];
	$mensagem = 	str_replace("|","&",$mensagem);  
	$mensagem = 	utf8_decode($mensagem);  
	$idmodelo 		=   trim($_REQUEST['idmodelo']);  
	$category_id 	=	trim($_REQUEST['category_id']);  
  
	if($idmodelo!="" and $idmodelo!="0" and $idmodelo!="00"){
	    echo $sql  = "update page  set value = '".$mensagem."', titulo = '$titulo', datamodificacao = '".date("Y-m-d H:i:s")."', category_id = $category_id ,status = '$status' where id = '$idmodelo'";
		$rs  = mysql_query($sql );
		if($rs){ 
			echo "true";
		}  
	}
	else{
	
		$id = mt_rand(5, 1000000000);
		
		$sql  = "insert into modelos_email (texto,data,assunto) values('$mensagem','".date("Y-m-d H:i:s")."','$titulo')";
		$rs  = mysql_query($sql );
		
		$sql  = "insert into page (id,value,data_criacao,titulo,category_id,status) values('$id','$mensagem','".date("Y-m-d H:i:s")."','$titulo',$category_id,'$status')";
		$rs  = mysql_query($sql );
		echo $id ;
	}
	if(!$rs){
		 echo  'Erro em salvar esta página. Por favor, tente novamente. '.$sql. ' '. mysql_error();
	 } 
	  sleep(1);
}
else if ( 'userremove' == $action ) {

	need_auth('order');
	$id = $_REQUEST['id']; 
	Util::log($id ." - deletando usuário e todas as referencias: ".$id );
   
	$sql  = "DELETE FROM `coupon` WHERE `user_id` = ".$id;
	$rs  = mysql_query($sql );	
	$sql  = "DELETE FROM `flow` WHERE `user_id` = ".$id;
	$rs  = mysql_query($sql );
	$sql  = "DELETE FROM `invite` WHERE `user_id` = ".$id;
	$rs  = mysql_query($sql );
	$sql  = "DELETE FROM `order` WHERE `user_id` = ".$id;
	$rs  = mysql_query($sql );
	$sql  = "DELETE FROM `user` WHERE `id` = ".$id;
	$rs  = mysql_query($sql );

	if($rs){
		Session::Set('notice', 'O usuário id ('.$id.') e todas as suas referências foram excluídos com sucesso.');
	}
	else{
		Session::Set('notice', 'O usuário id ('.$id.') não foi excluído. '.$sql. ' '. mysql_error());
	}
	json(null, 'refresh');
}
else if ('userdeactivate' == $action) {

	need_auth('order');
	$id = $_REQUEST['id']; 
	Util::log($id ." - desativando usuário: ".$id );
	$user = Table::Fetch('user', $id);
   
	$sql  = "UPDATE user SET STATUS = 'desativado' WHERE id = '" . $id . "'";
	$rs = mysql_query($sql);
	
	/*
	$parametros = array('id_user' => $_REQUEST['id']);
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
	$body = file_get_contents($INI["system"]["wwwprefix"]."/templates/conta_status.php", false, $request);

	if(Util::postemailCliente($body, $INI['system']['sitename']." - Conta de login", $user['email'])){
		Util::log($id. " - status conta - Email para o cliente enviado com sucesso " . $user['email']); 
	 }
	else{
		Util::log($id. " - status conta - Erro no envio do email para ".$user['email']); 
	}
	
	*/
	
	json(null, 'refresh');
}
else if ('useractivate' == $action) {

	need_auth('order');
	$id = $_REQUEST['id']; 
	Util::log($id ." - ativando usuário: ".$id );
	$user = Table::Fetch('user', $id);
   
	$sql  = "UPDATE user SET STATUS = 'ativado' WHERE id = '" . $id . "'";
	$rs = mysql_query($sql);
	
	/*
	$parametros = array('id_user' => $_REQUEST['id']);
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
	$body = file_get_contents($INI["system"]["wwwprefix"]."/templates/conta_status.php", false, $request);

	if(Util::postemailCliente($body, $INI['system']['sitename']." - Conta de login", $user['email'])){
		Util::log($id. " - status conta - Email para o cliente enviado com sucesso " . $user['email']); 
	 }
	else{
		Util::log($id. " - status conta - Erro no envio do email para ".$user['email']); 
	}
	*/
	json(null, 'refresh');
}
else if ( 'reenviacupom' == $action ) {

	need_auth('order');

	Util::log($id ." - Reenvio de cupom para o pedido: ".$id);

	$order = Table::Fetch('order', $id);
	$user = Table::Fetch('user', $order['user_id']);


// buscando dados da oferta - verificando se ela está ativa para enviar cupons para todos os clientes que compraram
	$team = Table::Fetch('team', $order['team_id']);
	 
	 if($team['now_number'] >= $team['min_number']){  //<!--  A oferta esta ativa  --> 
	  
		//criando os cupons
		ZCoupon::CheckOrder($order);

		Util::log($id. " - Oferta ativa -  buscando os cupons dos usuarios para envio...");
	 
		$sql = "select a.id,a.secret,a.order_id,a.nome,b.username,b.email,c.title,c.homepage,c.location,c.address,c.chavesms  from coupon a,user b, partner c where a.partner_id = c.id and a.user_id = b.id and a.order_id = ".$order['id']." and a.team_id = ".$order['team_id'];
		$rs = mysql_query($sql);
		
		Util::log("Encontrado (".mysql_num_rows($rs).") oferta(s) para envio.");
		 
		//Util::log($_REQUEST['ProdID_1']. " $sql  ");
		
		$achou = false;
		$cont=0;
		while($row = mysql_fetch_object($rs)){
			$cont++;
			$achou = true;
			$numcupom 	= $row->id;
			$senha 		= $row->secret; 
			$pedido  	= $row->order_id; 
			$email 		= $row->email; 
			$nome 		= $row->nome; 
			$username  	= $row->username; 
			$parceiro  	= $row->title ; 
			$homepage   = $row->homepage  ; 
			$location   = $row->address  ; 
			$complemento = $row->chavesms; 
			$location =  $location. " ".$complemento;

			
			Util::log("Pedido: ".$pedido. " - Numero do cupom: $numcupom - senha: $senha - Utilizador: $nome");
			$msg.="<br>Pedido: ".$pedido. " - Numero do cupom: $numcupom - senha: $senha - Utilizador: $nome";
			$url = $INI['system']['wwwprefix']; 
			$url.= $url."/pedidos";
		  
		    $parametros = array('oferta' => $team['title'], 'username' => $username, 'numcupom' => $numcupom, 'senha' => $senha,  'utilizador' => $nome ,'parceiro' => $parceiro, 'location' => $location, 'homepage' => $homepage  );
	 
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
	
			if(Util::postemailCliente($body,$INI['system']['sitename']. " - ".ASSUNTO_ENVIO_CUPOM. ": ".displaySubStringWithStrip(utf8_decode($team['title']),80),$email)){
				Util::log($pedido. " - Email para o cliente com dados do cupom enviado com sucesso(".$email.")...");
				$msg.="<br>Email para o cliente com dados do cupom enviado com sucesso(".$email.").";
				
				$sql2 = "update coupon set envioucupom =1 where id = '".$numcupom."'";
				$rs2 = mysql_query($sql2);
				if($rs2){
					Util::log($pedido. " - campo envioucupom atualizado.");
				 }
				 else{
					Util::log($pedido. " - campo envioucupom nao atualizado. $sql2");
				 }
		
			}
			else{
				Util::log($pedido. " - Erro no envio do email... (".$email.") .");
			    $msg.= "<br>Erro no envio do email... (".$email.") <br> Email inválido ou ambiente não configurado para enviar emails.";
			}
			
		}
			
	 }
	 else{
		Util::log($id. " - A oferta desta compra nao esta ativa, numero minimo nao alcancado ainda (".$team['min_number'].") total comprados (".$team['now_number'].").");
	    $msg.= "<br>A oferta desta compra nao esta ativa, numero minimo nao alcancado ainda (".$team['min_number'].") total comprados (".$team['now_number'].").";
	 }


	 if( !$achou){
		Util::log($id. " - Ainda nenhum cupom disponivel para envio:  Minimo: (".$team['min_number'].") - Total comprados (".$team['now_number'].").");
		Session::Set('notice', "Ainda nenhum cupom disponivel para envio:  Minimo: (".$team['min_number'].") - Total comprados (".$team['now_number'].").<br>".$msg);
	 }
	else{
		if($cont==1){
			echo $cont." cupom para o usuário: ".$email. "<br>".$msg ;
		}
		else{
			echo $cont." cupons para o usuário: ".$email. "<br>".$msg;
		}
	 } 
}
else if ( 'teamdetail' == $action) {
	$team = Table::Fetch('team', $id);
	$partner = Table::Fetch('partner', $team['partner_id']);

	$paycount = Table::Count('order', array(
		'state' => 'pay',
		'team_id' => $id,
	));
	$buycount = Table::Count('order', array(
		'state' => 'pay',
		'team_id' => $id,
	), 'quantity');
	$onlinepay = Table::Count('order', array(
		'state' => 'pay',
		'team_id' => $id,
	), 'money');
	$creditpay = Table::Count('order', array(
		'state' => 'pay',
		'team_id' => $id,
	), 'credit');
	$cardpay = Table::Count('order', array(
		'state' => 'pay',
		'team_id' => $id,
	), 'card');
	$couponcount = Table::Count('coupon', array(
		'team_id' => $id,
	));
	$team['state'] = team_state($team);
	
	$city_id = abs(intval($team['city_id']));
	
	$subcond = array(); 
	//if($city_id) $subcond['city_id'] = $city_id;
	
	$subcond['city_id'] = $city_id;
	
	if( $city_id == 0){
		$subcount = Table::Count('subscribe');
	}
	else{	
		$subcount = Table::Count('subscribe', $subcond);
	} 
	/*
	$subcond2 = array();
	$subcond2['city_id'] = 0;
	$arrsubscidzero = Table::Count('subscribe', $subcond2);
*/
	if($INI['option']['enviaamigos'] != "Y"){ // a importacao de contatos não sera usado para somar usuarios
		$arrsubscidzero =0;
	}
	$arrsubscidzero =0;
 
	$subcond['enable'] = 'Y';
	$smssubcount = Table::Count('smssubscribe', $subcond);

	/* send team subscribe mail */
	$team['noticesubscribe'] = ($team['close_time']==0&&is_manager());
	$team['noticesmssubscribe'] = ($team['close_time']==0&&is_manager());
	/* send success coupon */
	$team['noticesms'] = ($team['delivery']!='express')&&(in_array($team['state'], array('success', 'soldout')))&&is_manager();
	/* teamcoupon */
	$team['teamcoupon'] = ($team['noticesms']&&$buycount>$couponcount);
	
	$team['needline'] = ($team['noticesms']||$team['noticesubscribe']||$team['teamcoupon']);

	$html = render('manage_ajax_dialog_teamdetail');
	json($html, 'dialog');
}
else if ( 'filiadodetail' == $action) {
	$team = Table::Fetch('produtos_afiliados', $id);
	$partner = Table::Fetch('partner', $team['partner_id']);
  
	$subcond = array(); 
	$subcount = Table::Count('subscribe');
	 
	  
	/*
	$subcond2 = array();
	$subcond2['city_id'] = 0;
	$arrsubscidzero = Table::Count('subscribe', $subcond2);
*/
	if($INI['option']['enviaamigos'] != "Y"){ // a importacao de contatos não sera usado para somar usuarios
		$arrsubscidzero =0;
	}
	$arrsubscidzero =0;
 
	$subcond['enable'] = 'Y';
	$smssubcount = Table::Count('smssubscribe', $subcond);

	/* send team subscribe mail */
	$team['noticesubscribe'] = ($team['close_time']==0&&is_manager());
	$team['noticesmssubscribe'] = ($team['close_time']==0&&is_manager());
	/* send success coupon */
	$team['noticesms'] = ($team['delivery']!='express')&&(in_array($team['state'], array('success', 'soldout')))&&is_manager();
	/* teamcoupon */
	$team['teamcoupon'] = ($team['noticesms']&&$buycount>$couponcount);
	
	$team['needline'] = ($team['noticesms']||$team['noticesubscribe']||$team['teamcoupon']);

	$html = render('manage_ajax_dialog_afiliadosdetail');
	json($html, 'dialog');
}
else if ( 'teamremove' == $action) {
	//need_auth('team');
	$team = Table::Fetch('team', $id);
	$order_count = Table::Count('order', array(
		'team_id' => $id,
		'state' => 'pay',
	));
	if ( $order_count > 0 ) {
			Session::Set('notice', 'Esta oferta está contida em '.$order_count .' pedido(s) pago(s). Por motivo de segurança você deve apagar o(s) pedido(s) primeiro.');
			json(null, 'refresh'); 
	}
	ZTeam::DeleteTeam($id);

	/* remove coupon */
	$coupons = Table::Fetch('coupon', array($id), 'team_id');
	foreach($coupons AS $one) Table::Delete('coupon', $one['id']);
	/* remove order */
	$orders = Table::Fetch('order', array($id), 'team_id');
	foreach($orders AS $one) Table::Delete('order', $one['id']);
	/* end */

	Session::Set('notice', "Oferta {$id} Apagada com sucesso!");
	json(null, 'refresh');
}

else if ( 'valecupomremove' == $action) {
	//need_auth('team');   
	Table::Delete('valecompras', $id);
	Util::log($id ." - valecupomremove: ".$id. " excluido ");
	  
	Session::Set('notice', "Registro excluído com sucesso!");
	json(null, 'refresh');
}
else if ( 'teamremovewebsite' == $action) {
	need_auth('team');
	$team = Table::Fetch('produtos_afiliados', $id);
  
	ZTeam::DeleteTeamWebsite($id);
 
	Session::Set('notice', "Produto {$id} Apagado com sucesso!");
	json(null, 'refresh');
}
else if ( 'cardremove' == $action) {
	need_auth('market');
	$id = strval($_GET['id']);
	$card = Table::Fetch('card', $id);
	if (!$card) json('Cupom de desconto irrelevante', 'alert');
	if ($card['consume']=='Y') { json('Os cupons de descontos foram usados. Você não pode apagar', 'alert'); }
	Table::Delete('card', $id);
	Session::Set('notice', "Cupom de desconto {$id} Apagado com sucesso!");
	json(null, 'refresh');
}
else if ( 'userview' == $action) {
	$user = Table::Fetch('user', $id);
	$user['costcount'] = Table::Count('order', array(
		'state' => 'pay',
		'user_id' => $id,
	));
	$user['cost'] = Table::Count('flow', array(
		'direction' => 'expense',
		'user_id' => $id,
	), 'money');
	$html = render('manage_ajax_dialog_user');
	json($html, 'dialog');
}
else if ( 'usermoney' == $action) {
	need_auth('admin');
	$user = Table::Fetch('user', $id);
	$money = moneyit($_GET['money']);
	if ( $money < 0 && $user['money'] + $money < 0) {
		json('Falha - Saldo insuficiente', 'alert');
	}
	if ( ZFlow::CreateFromStore($id, $money) ) {
		$action = ($money>0) ? 'Recarga online' : 'Usuario recarregado';
		$money = abs($money);
		json(array(
					array('data' => " "),
					array('data' => null, 'type'=>'refresh'),
				  ), 'mix');
	}
	json('Falha na recarga', 'alert');
}
else if ( 'orderexpress' == $action ) {
	need_auth('order');
	$express_id = abs(intval($_GET['eid']));
	$express_no = strval($_GET['nid']);
	if (!$express_id) $express_no = null;
	Table::UpdateCache('order', $id, array(
		'express_id' => $express_id,
		'express_no' => $express_no,
	));
	json(array(
				array('data' => "entrega bem sucedida", 'type'=>'alert'),
				array('data' => null, 'type'=>'refresh'),
			  ), 'mix');
}
else if ( 'orderview' == $action) {
	$order = Table::Fetch('order', $id);
	$user = Table::Fetch('user', $order['user_id']);
	$team = Table::Fetch('team', $order['team_id']);
	if ($team['delivery'] == 'express') {
		$option_express = option_category('express');
	}
	$payservice = array(
	    'pagseguro' => 'Pagseguro',
		'alipay' => 'Alipay',
		'pagamentodg' => 'Pagamento Digital',
		'moip' => 'Moip',
		'mercadopago' => 'Mercado Pago',
		'credit' => 'credito',
		'cash' => 'dinheiro',
	);
	$paystate = array(
		'unpay' => '<font color="green">Não pago</font>',
		'pay' => '<font color="red">Pago</font>',
	);
	$option_refund = array(
		'credit' => 'Reembolso ao saldo da conta',
		'online' => 'Outros meios de reembolso',
	);
	
	$html = render('manage_ajax_dialog_orderview');
	json($html, 'dialog');
	 
 
	
	
}
else if ( 'inviteok' == $action ) {
	need_auth('admin');
	$express_id = abs(intval($_GET['eid']));
	$invite = Table::Fetch('invite', $id);
	if (!$invite || $invite['pay']!='N') {
		json('Não existe convite ou convidado ainda nao pagou a oferta', 'alert');
	}
	if(!$invite['team_id']) {
		json('Nenhuma compra. Desconto não pode ser realizado', 'alert');
	}
	$team = Table::Fetch('team', $invite['team_id']);
	$team_state = team_state($team);
	if (!in_array($team_state, array('success', 'soldout'))) {
		json('Os clientes so ganham credito quando o convidado realizar a compra de uma oferta', 'alert');
	}
	Table::UpdateCache('invite', $id, array(
				'pay' => 'Y',
				'admin_id'=>$login_user_id,
				));
	$invite = Table::FetchForce('invite', $id);

    /************************* 
	envia email para o usuário
   ****************************/

	$userconvidou 	= $invite["user_id"];
	$userconvidado 	= $invite["other_user_id"];
	$credito 		= $invite["credit"];

    $dadosuser1 		= Table::Fetch('user', $userconvidou);
    $dadosuser2 		= Table::Fetch('user', $userconvidado); 
  
	$nomeuser1  	= $dadosuser1["realname"];
	$emailuser1  	= $dadosuser1["email"];

	$nomeuser2  	= $dadosuser2["realname"];
	$emailuser2  	= $dadosuser2["email"];
  
    $systeminvitecredit = $INI['system']['invitecredit'] ;
 
	$assunto = utf8_decode("Parabéns, você acaba de ganhar créditos para gastar com nossas ofertas no site ".$INI['system']['sitename']);

	$parametros = array( 'nomeuser2' => $nomeuser2, 'nomeuser' => $nomeuser1, 'emailuser2' => $emailuser2);
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

	$mensagem = file_get_contents($INI["system"]["wwwprefix"]."/templates/informacao_credito_recebido.php", false, $request);

	enviar($emailuser1 ,$assunto, $mensagem);
 
	ZFlow::CreateFromInvite($invite);
	Session::Set('notice', 'Comissão paga com sucesso');
	json(null, 'refresh');
}
else if ( 'inviteremove' == $action ) {
	need_auth('admin');
	Table::UpdateCache('invite', $id, array(
		'pay' => 'C',
		'admin_id' => $login_user_id,
	));
	Session::Set('notice', 'Cancelar o convite devido ao uso ilegal');
	json(null, 'refresh');
}
else if ( 'subscriberemove' == $action ) {
	need_auth('admin');
	$subscribe = Table::Fetch('subscribe', $id);
	if ($subscribe) {
		ZSubscribe::Unsubscribe($subscribe);
		Session::Set('notice', "Endereço de email: {$subscribe['email']} descadastrado com sucesso");
	}
	json(null, 'refresh');
}
else if ( 'smssubscriberemove' == $action ) {
	need_auth('admin');
	$subscribe = Table::Fetch('smssubscribe', $id);
	if ($subscribe) {
		ZSMSSubscribe::Unsubscribe($subscribe['mobile']);
		Session::Set('notice', "Celular: {$subscribe['mobile']} Descadastrado com sucesso");
	}
	json(null, 'refresh');
}
else if ( 'partnerremove' == $action ) {
	need_auth('market');
	$partner = Table::Fetch('partner', $id);
	$count = Table::Count('team', array('partner_id' => $id) );
	if ($partner && $count==0) {
		Table::Delete('partner', $id);
		Session::Set('notice', "Parceiro: {$id} Apagado com sucesso");
		json(null, 'refresh');
	}
	if ( $count > 0 ) {
	    	Session::Set('notice', 'Este parceiro contém '.$count .'. ofertas. Por motivo de segurança você deve retirar a associação deste parceiros em todas as ofertas.');
			json(null, 'refresh');
			
	 }
	 Session::Set('notice', 'Falha ao apagar este parceiro');
	 json(null, 'refresh'); 
}
else if ( 'noticesms' == $action ) {
	need_auth('team');
	$nid = abs(intval($_GET['nid']));
	
	$now = time();
	$team = Table::Fetch('team', $id);
	$condition = array( 'team_id' => $id, );
	$coups = DB::LimitQuery('coupon', array(
				'condition' => $condition,
				'order' => 'ORDER BY id ASC',
				'offset' => $nid,
				'size' => 1,
				));
	if ( $coups ) {
		foreach($coups AS $one) {
			$nid++;
			sms_coupon($one);
		}
		json("X.misc.noticesms({$id},{$nid});", 'eval');
	} else {
		json($INI['system']['couponname'].'Envio completo', 'alert');
	}
}
else if ( 'noticesmssubscribe' == $action ) {
	need_auth('team');
	$nid = abs(intval($_GET['nid']));
	$team = Table::Fetch('team', $id);
	$condition = array( 'enable' => 'Y' );
	if(abs(intval($team['city_id']))) {
		$condition['city_id'] = abs(intval($team['city_id']));
	}
	$subs = DB::LimitQuery('smssubscribe', array(
				'condition' => $condition,
				'order' => 'ORDER BY id ASC',
				'offset' => $nid,
				'size' => 10,
				));
	$content = render('manage_tpl_smssubscribe');
	if ( $subs ) {
		$mobiles = Utility::GetColumn($subs, 'mobile');
		$nid += count($mobiles);
		$mobiles = implode(',', $mobiles);
		$smsr = sms_send($mobiles, $content);
		if ( true === $smsr ) {
			usleep(500000);
			json("X.misc.noticenextsms({$id},{$nid});", 'eval');
		} else {
			json("Falha no envio, codigo de erro:{$smsr}", 'alert');
		}
	} else {
		json('Inscrição no SMS completo', 'alert');
	}
}
else if ( 'noticesubscribe' == $action ) { 
 
    $tipo 	= $_GET['tipo'];
    $qtdeenviohora 	= $_GET['qtdeenviohora'];
    $intervalosegundos = 3600/(int)$qtdeenviohora;

	$nid = abs(intval($_GET['nid']));
	$now = time(); 
	$interval = abs(intval($INI['mail']['interval']));
	if($tipo=="afiliado"){
		$team = Table::Fetch('produtos_afiliados', $id);
	}else{
		$team = Table::Fetch('team', $id);
	}
	$partner = Table::Fetch('partner', $team['partner_id']);
	$city = Table::Fetch('city', $team['city_id']);

	//$condition = array();
	//if(abs(intval($team['city_id']))) {
		//$condition['city_id'] = abs(intval($team['city_id']));
	//}
	   
	$subs = DB::LimitQuerySubs('subscribe', array(
			    'order' => 'ORDER BY id ASC',
				'offset' => $nid,
				 'size' => 1,
				),$team['city_id']);
	// print_r($subs );
	if ( $subs ) {
		// $cont=0;
		foreach($subs AS $one) {
			$nid++;
			//$cont++;
			
			//if($cont == 11){
				//$cont=0;
				//sleep(10);
			//}
			try{
				ob_start();
				mail_subscribe($city, $team, $partner, $one,$tipo);
				ob_get_clean();
				//sleep($intervalosegundos);
				sleep($INTERVALO_ENVIO_EMAILS_NEWSLETER);
			}catch(Exception $e){}
			$cost = time() - $now;
			if ( $cost >= 20 ) {
				json("X.misc.noticenext({$id},{$nid},{$qtdeenviohora},'".$tipo."'  );", 'eval');
			}
		}
		$cost = time() - $now;
		if ($interval && $cost < $interval) { sleep($interval - $cost); }
		json("X.misc.noticenext({$id},{$nid},{$qtdeenviohora});", 'eval');
	} else {
		json('Envio de e-mail completo', 'alert');
	}
}
elseif ( 'categoryedit' == $action ) {
	need_auth('admin');
	if ($id) {
		$category = Table::Fetch('category', $id);
		if (!$category) json('Nenhum dado', 'alert');
		$zone = $category['zone'];
	} else {
		$zone = strval($_GET['zone']);
	}
	if ( !$zone ) json('Make sure the classification', 'alert');
	$zone = get_zones($zone);

	$html = render('manage_ajax_dialog_categoryedit');
	json($html, 'dialog');
}
elseif ( 'atributoremove' == $action ) { 
	need_auth('admin');
	$atributo = Table::Fetch('category_atributos', $id);
	if (!$atributo) json('Atributo não localizado', 'alert');
	 
	$tcount = Table::Count('team', array('id_atributo' => $id));
	if ($tcount ) {
		Session::Set('notice', 'Este atributo está associado a '.$tcount .' produtos(s). Por motivo de segurança você deve retirar a associação desta atributo em todos os produtos.');
		json(null, 'refresh');
	 }
	 
	Table::Delete('category_atributos', $id);
	Session::Set('notice', 'Atributo removido com sucesso!');
	json(null, 'refresh');
}
elseif ( 'categoryremove' == $action ) { 
	need_auth('admin');
	$category = Table::Fetch('category', $id);
	if (!$category) json('Categoria não localizada', 'alert');
	if ($category['zone'] == 'city') {
		$tcount = Table::Count('team', array('city_id' => $id));
		if ($tcount ) {
			Session::Set('notice', 'Esta cidade está associada a '.$tcount .' oferta(s). Por motivo de segurança você deve retirar a associação desta cidade em todas as ofertas.');
			json(null, 'refresh');
		 }
	}
	elseif ($category['zone'] == 'group') {
		$tcount = Table::Count('team', array('group_id' => $id));
		if ($tcount ) json('Esta categoria está associada a '.$tcount .' oferta(s). Por motivo de segurança você deve retirar a associação desta categoria em todas as ofertas.', 'alert');
	}
	elseif ($category['zone'] == 'express') {
		$tcount = Table::Count('order', array('express_id' => $id));
		if ($tcount ) json('Item de compra já existe nessa categoria', 'alert');
	}
	elseif ($category['zone'] == 'public') {
		$tcount = Table::Count('topic', array('public_id' => $id));
		if ($tcount ) json('Topico Já existe', 'alert');
	}
	Table::Delete('category', $id);
	option_category($category['zone']);
	Session::Set('notice', 'Removida com sucesso!');
	json(null, 'refresh');
}
else if ( 'teamcoupon' == $action ) {
	need_auth('team');
	$team = Table::Fetch('team', $id);
	team_state($team);
	if ($team['now_number']<$team['min_number']) {
		json('Comprar ou não, não é o fim do número mínimo de pessoas para o grupo', 'alert');
	}

	/* all orders */
	$all_orders = DB::LimitQuery('order', array(
		'condition' => array(
			'team_id' => $id,
			'state' => 'pay',
		),
	));
	$all_orders = Utility::AssColumn($all_orders, 'id');
	$all_order_ids = Utility::GetColumn($all_orders, 'id');
	$all_order_ids = array_unique($all_order_ids);

	/* all coupon id */
	$coupon_sql = "SELECT order_id, count(1) AS count FROM coupon WHERE team_id = '{$id}' GROUP BY order_id";
	$coupon_res = DB::GetQueryResult($coupon_sql, false);
	$coupon_order_ids = Utility::GetColumn($coupon_res, 'order_id');
	$coupon_order_ids = array_unique($coupon_order_ids);

	/* miss id */
	$miss_ids = array_diff($all_order_ids, $coupon_order_ids);
	foreach($coupon_res AS $one) {
		if ($one['count'] < $all_orders[$one['order_id']]['quantity']) {
			$miss_ids[] = $one['order_id'];
		}
	}
	$orders = Table::Fetch('order', $miss_ids);

	foreach($orders AS $order) {
		ZCoupon::Create($order);
	}
	json('Cupons enviados com sucesso',  'alert');
}
elseif ( $action == 'partnerhead' ) {
	$partner = Table::Fetch('partner', $id);
	$head = ($partner['head']==0) ? time() : 0;
	Table::UpdateCache('partner', $id, array( 'head' => $head,));
	$tip = $head ? 'Confirma sucesso da negociação' : 'Cancelar sucesso da negociação';
	Session::Set('notice', $tip);
	json(null, 'refresh');
}
elseif ( 'cacheclear' == $action ) {
	need_auth('admin');
	$root = DIR_COMPILED;
	$handle = opendir($root);
	$templatelist = array( 'default'=> 'default',);
	$clear = $unclear = 0;
	while($one = readdir($handle)) {
		if ( strpos($one,'.') === 0 ) continue;
		$onefile = $root . '/' . $one;
		if ( is_dir($onefile) ) continue;
		if(@unlink($onefile)) { $clear ++; }
		else { $unclear ++; }
	}
	json("Operação realizada com sucesso, apagar os arquivos de cache? {$clear} Não apagar {$unclear}", 'alert');
}
else if ( 'teamporcentagem' == $action) {

	$blocosofertas = new BlocosOfertas();
	//Inclui os dados REQUEST em uma variável para ganhar performance.
	$arrDados = $_REQUEST;
	
	
	$operacao = $arrDados["operacao"];
	$porcentagem = implode(".", explode(",", $arrDados["porcentagem"]));
	$categoria = $arrDados["categoria"];
	$blocosofertas->getcategoriafilhas($categoria);
	$categorias = $blocosofertas->categoriasfilhas . 0; //concatena o zero pois a função traz uma virgula no final e da erro na sintax do sql
	
	if($porcentagem != "" or $operacao != "" or $categoria != ""){
		//calculo da porcentagem de dos campos team_price e market_price
		$sql = "UPDATE team SET team_price = team_price {$operacao} team_price * {$porcentagem} / 100, market_price = market_price {$operacao} market_price * {$porcentagem} / 100 WHERE group_id IN ({$categorias}) ";
		$objRow = mysql_query($sql);
		Session::Set('notice', "Porcentagem Alterada com Sucesso!");
		redirect( WEB_ROOT . "/vipmin/team/index.php");
	}else{
		Session::Set('notice', "Desculpe, houve um erro de processamento!");
		redirect( WEB_ROOT . "/vipmin/team/index.php");
	}
}
elseif('propostaremove' == $action) {
	
	$sql  = "DELETE FROM `propostas` WHERE `id` = " . $id;
	$rs  = mysql_query($sql);
	$num = mysql_num_rows($rs);
	
	if($rs) {
		Session::Set('notice', 'Contato removido com sucesso!');
		json(null, 'refresh');
	} else {
		Session::Set('notice', 'Falha ao remover contato!');
		json(null, 'refresh');	
	}
}
elseif('qualificationProductremove' == $action) {
	
	$sql  = "DELETE FROM `qualification` WHERE `id` = " . $id;
	$rs  = mysql_query($sql);
	$num = mysql_num_rows($rs);
	
	if($rs) {
		Session::Set('notice', 'Qualificação removida com sucesso!');
		redirect( WEB_ROOT . "/vipmin/user/qualification.php");
	} else {
		Session::Set('notice', 'Falha ao remover qualificação!');
		redirect( WEB_ROOT . "/vipmin/user/qualification.php");	
	}
}
elseif('questionProductremove' == $action) {
	
	$sql  = "DELETE FROM `questions` WHERE `id` = " . $id;
	$rs  = mysql_query($sql);
	$num = mysql_num_rows($rs);
	
	if($rs) {
		Session::Set('notice', 'Pergunta removida com sucesso!');
		redirect( WEB_ROOT . "/vipmin/user/question.php");
	} else {
		Session::Set('notice', 'Falha ao remover pergunta!');
		redirect( WEB_ROOT . "/vipmin/user/question.php");	
	}
}
elseif('answerProductremove' == $action) {
	
	$sql  = "DELETE FROM `answer` WHERE `id` = " . $id;
	$rs  = mysql_query($sql);
	$num = mysql_num_rows($rs);
	
	if($rs) {
		Session::Set('notice', 'Resposta removida com sucesso!');
		redirect( WEB_ROOT . "/vipmin/user/question.php");
	} else {
		Session::Set('notice', 'Falha ao remover resposta!');
		redirect( WEB_ROOT . "/vipmin/user/question.php");	
	}
}
elseif('PagoVendedor' == $action) {
	
	$sql  = "UPDATE `order` SET statusliberacao = 'Pago ao vendedor' WHERE `id` = " . $id;
	$rs  = mysql_query($sql);
	$num = mysql_num_rows($rs);
	
	if($rs) {
		Session::Set('notice', 'Status atualizado com sucesso!');
		grava_status_entrega("Dinheiro liberado ao vendedor.", $id);
		
		$order = Table::Fetch('order', $id);
		$user = Table::Fetch('user', $order['partner_id']);
		/*
		$parametros = array('id' => $id);
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
		$body = file_get_contents($INI["system"]["wwwprefix"]."/templates/pagamento_vendedor.php", false, $request);
		
		if(Util::postemailCliente($body, "Você recebeu um pagamento", $user['email'])){
			Util::log($id. " - pagamento pela venda - Email para o cliente enviado com sucesso " . $user['email']); 
		 }
		else{
			Util::log($id. " - pagamento pela venda - Erro no envio do email para ".$user['email']); 
		}
		*/
		json(null, 'refresh');
	} else {
		Session::Set('notice', 'Falha ao atualizar status!');
		json(null, 'refresh');	
	}
}
elseif('teammoderar' == $action) {
	
	$sql  = "UPDATE `team` SET moderacao = 'Y' WHERE `id` = " . $id;
	$rs  = mysql_query($sql);
	$num = mysql_num_rows($rs);
	
	if($rs) {
		Session::Set('notice', 'Anúncio moderado com sucesso!');
		/* É enviado um email ao usuário que cadastrou o mesmo. */
		$team = Table::Fetch('team', $id);
		$user = Table::Fetch('user', $team['partner_id']);
		$realname = empty($user['realname']) ? $user['username'] : $user['realname'];
		
		$parametros = array('idoffer' => $id, 'name' => $realname);
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
		$body = file_get_contents($INI["system"]["wwwprefix"]."/templates/moderacao_produto.php", false, $request);

		if(Util::postemailCliente($body, utf8_decode("Ueba, seu produto tá no ar"), $user['email'])){
			Util::log($id. " - moderacao - Email para o cliente enviado com sucesso " . $user['email']); 
		 }
		else{
			Util::log($id. " - moderacao - Erro no envio do email para ".$user['email']); 
		}
		json(null, 'refresh');
		
	} else {
		Session::Set('notice', 'Falha ao moderar anúncio!');
		json(null, 'refresh');	
	}
}
elseif('billing_pay' == $action) {

	$data = date("Y-m-d H:i:s");
	
	$sql  = "UPDATE `faturas` SET status = 'pay', data_pagamento = '" . $data . "' WHERE `id` = " . $id;
	$rs  = mysql_query($sql);
	$num = mysql_num_rows($rs);
	
	if($rs) {
		Session::Set('notice', 'Status de pagamento da fatura atualizada com sucesso!');
		
		/* É enviado um email ao usuário que efetuou a venda. */
		$faturas = Table::Fetch('faturas', $id);
		$user = Table::Fetch('user', $faturas['id_user']);
		
		/*
		$parametros = array('id_billi' => $id);
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
		$body = file_get_contents($INI["system"]["wwwprefix"]."/templates/envio_fatura.php", false, $request);

		if(Util::postemailCliente($body, $INI['system']['sitename'] . " - Fatura", $user['email'])){
			Util::log($id. " - fatura - Email para o cliente enviado com sucesso " . $user['email']); 
		 }
		else{
			Util::log($id. " - fatura - Erro no envio do email para ".$user['email']); 
		}
		*/
		
		json(null, 'refresh');
	}
	else {
		Session::Set('notice', 'Falha ao atualizar status de pagamento da fatura!');
		json(null, 'refresh');
	}		
}
elseif('billing_cancel' == $action) {

	$data = date("Y-m-d H:i:s");
	
	$sql  = "UPDATE `faturas` SET status = 'cancelled' WHERE `id` = " . $id;
	$rs  = mysql_query($sql);
	$num = mysql_num_rows($rs);
	
	if($rs) {
		Session::Set('notice', 'Status de pagamento da fatura atualizada com sucesso!');
		/* É enviado um email ao usuário que cadastrou o mesmo. */
		$team = Table::Fetch('team', $id);
		$user = Table::Fetch('user', $team['partner_id']);
		json(null, 'refresh');
	}
	else {
		Session::Set('notice', 'Falha ao atualizar status de pagamento da fatura!');
		json(null, 'refresh');
	}		
}
elseif('InfoBilli' == $action) {

	$idfatura = (int) strip_tags($_REQUEST["idfatura"]);
	$iduser = (int) strip_tags($_REQUEST["iduser"]);
	
	$sql  = "select * from faturas where id = '" . $idfatura . "' and id_user = '" . $iduser . "'";
	$rs  = mysql_query($sql);
	$row = mysql_fetch_assoc($rs);
	
	/* Valor é retornado no formato brasileiro. */
	$row['valor'] = "R$ " . number_format($row['valor'], 2, ",", ".");
	
	if(!(empty($row))) {
		echo json_encode($row);
	}
	else {
		Session::Set('notice', 'Falha ao buscar informações sobre a fatura!');
		json(null, 'refresh');
	}		
}
elseif('feeddel' == $action) {
	
	Table::Delete('feedback', $id);
	Session::Set('notice', 'Registro deletado com sucesso!');

	echo "<script>window.location.href = 'http://www.vendecamaqua.com.br/vipmin/misc/feedback.php'</script>";
}
elseif('teampausar' == $action) {
	
	global $INI;
	
	$sql  = "UPDATE `team` SET moderacao = 'N' WHERE `id` = " . $id;
	$rs  = mysql_query($sql);
	$num = mysql_num_rows($rs);
	
	if($rs) {
		
		Session::Set('notice', 'Anúncio pausado!');
		/* É enviado um email ao usuário que cadastrou o mesmo. */
		$team = Table::Fetch('team', $id);
		$user = Table::Fetch('user', $team['partner_id']);
		
		$parametros = array('idoffer' => $id);
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
		$body = file_get_contents($INI["system"]["wwwprefix"]."/templates/anuncio_pausado.php", false, $request);

		if(Util::postemailCliente($body, "Anúncio pausado", $user['email'])){
			Util::log($id. " - moderacao - Email para o cliente enviado com sucesso " . $user['email']); 
		 }
		else{
			Util::log($id. " - moderacao - Erro no envio do email para ".$user['email']); 
		}
		json(null, 'refresh');
		
	} else {
		Session::Set('notice', 'Falha ao pausar anúncio!');
		json(null, 'refresh');	
	}
}
elseif('questionApprove' == $action) {
	
	global $INI;
	
	$sql  = "UPDATE `questions` SET status = 1 WHERE `id` = " . $id;
	$rs  = mysql_query($sql);
	$num = mysql_num_rows($rs);
	
	$question = Table::Fetch('questions', $id);
	
	if($rs) {

		$team 	= Table::Fetch('team', $question['id_produto']);
		$user 	= Table::Fetch('user', $question['id_cliente']);
		$vendedor 	= Table::Fetch('user', $question['id_vendedor']);
	
		$parametros = array('idquestion' => $id);
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
		$body = file_get_contents($INI["system"]["wwwprefix"]."/templates/question.php", false, $request);
		
		$EmailVendedor = $vendedor['email'];
		
		 if(!enviar($EmailVendedor, "Você tem uma mensagem", $body)){
			 Util::log("O email nao foi enviado para o administrador.");
		 }
		else{
			Util::log($id. "avalia_produto - O email enviado com sucesso para (".$EmailVendedor.")");  
		}
		
		Session::Set('notice', 'Status alterado com sucesso!. A pergunta foi aceita.');
		
	} else {
		Session::Set('notice', 'Falha ao moderar anúncio!');
	}
	
	redirect( WEB_ROOT . "/vipmin/user/question.php");
}
elseif('answerApprove' == $action) {
	
	global $INI;
	
	$sql  = "UPDATE `answer` SET status = 1 WHERE `id` = " . $id;
	$rs  = mysql_query($sql);
	$num = mysql_num_rows($rs);
	
	$answer = Table::Fetch('answer', $id);
	
	if($rs) {

		$user 	= Table::Fetch('user', $answer['id_cliente']);
	
		$parametros = array('id' => $id_question, 'name' => $user['realname']);
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

		$request = stream_context_create($request_params);
		$body = file_get_contents($INI["system"]["wwwprefix"] . "/templates/answer.php", false, $request);
		Util::postemailCliente($body, "Responderam sua mensagem", $user['email']);
		
		Session::Set('notice', 'Status alterado com sucesso!. A pergunta foi aceita.');
		
	} else {
		Session::Set('notice', 'Falha ao moderar anúncio!');
	}
	
	redirect( WEB_ROOT . "/vipmin/user/answer.php");
}
elseif('questionDisapprove' == $action) {
	
	global $INI;
	
	$sql  = "UPDATE `questions` SET status = 2 WHERE `id` = " . $id;
	$rs  = mysql_query($sql);
	$num = mysql_num_rows($rs);
	
	if($rs) {	
		
		Session::Set('notice', 'Status alterado com sucesso!. A pergunta não foi aceita.');
	} 
	else {
	
		Session::Set('notice', 'Falha ao alterar status!');
	}
	
	redirect( WEB_ROOT . "/vipmin/user/question.php");
}
elseif('answerDisapprove' == $action) {
	
	global $INI;
	
	$sql  = "UPDATE `answer` SET status = 2 WHERE `id` = " . $id;
	$rs  = mysql_query($sql);
	$num = mysql_num_rows($rs);
	
	if($rs) {	
		
		Session::Set('notice', 'Status alterado com sucesso!. A resposta não foi aceita.');
	} 
	else {
	
		Session::Set('notice', 'Falha ao alterar status!');
	}
	
	redirect( WEB_ROOT . "/vipmin/user/answer.php");
}
elseif('faqremove' == $action) {
	
	$sql  = "DELETE FROM `faq` WHERE `id` = " . $id;
	$rs  = mysql_query($sql);
	$num = mysql_num_rows($rs);
	
	if($rs) {
		Session::Set('notice', 'Removida com sucesso!');
		json(null, 'refresh');
	} else {
		Session::Set('notice', 'Falha ao remover!');
		json(null, 'refresh');	
	}
}
else if('delete_option' == $action) {

	$sql  = "DELETE FROM `options` WHERE `id` = " . $id;
	$rs  = mysql_query($sql);
}