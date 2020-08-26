<?php

require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
require_once(dirname(__FILE__) . '/current.php');

need_manager();
need_auth('team');

$sql = "ALTER TABLE `team` ADD `termosdeuso` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL";
$rs = mysql_query($sql);
 
$id = abs(intval($_GET['id']));
$tipo =  $_REQUEST['team_type'];

$url = "index.php";
if($tipo == "pacote" or $tipo == "simples"){
	$url = "configuraveis.php";
}
if($_REQUEST['cadastraratributos'] =="sim"){
	$url = "atributos.php?id=$id";
}

$team = $eteam = Table::Fetch('team', $id);

if(!(empty($id))) {

	$sql_options = "select id, stock, size, color from options where team_id = " . (int) $id;
	$rs_options = mysql_query($sql_options);
	$row_options = mysql_num_rows($rs_options);

	$option_data = $row_options >= 1 ? true : false;
}
else {
	
	$option_data = false;
}

if(!empty($team)){
	$edicao = true; 
}
 

if ( is_get() && empty($team) ) {
	$team = array();
	$team['id'] = "";
	$team['user_id'] = $login_user_id;
	$team['partner_id'] = $login_user_id;
	$team['posicionamento'] = 12;
	$team['begin_time'] = strtotime('+0 days');
	$team['begin_time2'] = date('H:i');
	$team['end_time2'] = date('H:i');
	$team['end_time'] = strtotime('+1 days');
	$team['expire_time'] = strtotime('+1 months +1 days');
	$team['min_number'] = 10; 
	$team['per_number'] = 1;
	$team['minimo_pessoa'] = 1;
	$team['pre_number'] = 10;
	$team['max_number'] = 1000; 
	$team['team_price'] = 1; 
	$team['market_price'] = 1; 
	$team['bonus'] = abs(intval($INI['system']['invitecredit']));
	$team['conduser'] = $INI['system']['conduser'] ? 'Y' : 'N';
  
}
else if ( is_post() ) {
	$team = $_POST;
 
	$insert = array(
		'condicoes_produto', 'marca_produto', 'tamanho_produto', 'genero_produto',
		'title', 'market_price', 'team_price', 'end_time', 'retirada_local', 'seguro_val', 'condicoes_produto',
		'begin_time', 'expire_time', 'min_number', 'max_number',
		'summary', 'notice', 'per_number', 'product',
		'image', 'image1', 'image2', 'flv', 'now_number',
		'gal_image1', 'gal_image2', 'gal_image3', 'gal_image4', 'gal_image5', 'gal_image6', 'gal_image7',
		'detail', 'userreview', 'card', 'systemreview',
		'conduser', 'buyonce', 'bonus', 'sort_order',
		'delivery', 'mobile', 'address', 'fare','maisinformacoes',
		'express', 'credit', 'farefree', 'pre_number',
		'user_id', 'city_id', 'group_id', 'partner_id',
		'team_type', 'sort_order', 'farefree', 'state','posicionamento','layout','preco_comissao','minimo_pessoa','semhtmldescricao','semhtmlregulamento','manterdimensao','avaliacaoclientes','nomeaba1','nomeaba2', 'nomeaba5',
		'condbuy','categoria_valejunto','cidade_valejunto','categoria_apontaofertas','cidade_apontaofertas','categoria_dsconto','categoria_agrupi',
		'bonuslimite', 'metodo_pagamento','retornoparticipe','processo_compra','url_comprar','marcadagua','estatica_home','estatica_direita','estatica_detalhe','estatica_recentes',
		'frete','ceporigem','peso','altura','comprimento','largura','valorfrete','fretegratuito','republicacao','pontosgerados','pontos','idpacote','seo_keyword','codreferencia','mostrarpreco','condicaoenvio','condbuy2','uploadarquivo',
		'observacao_preco','titulo_opcao2','titulo_opcao1','titulo_upload','titleresumido', 'garantia', 'answer', 'termosdeuso', 'moderacao', 'comissao'
		);
  
	$idnovaoferta =	getUltimoIdOferta();
		
	$team['id'] = $idnovaoferta;
 
	$team['state'] = 'none';
	$team['team_price'] =  str_replace($currency,"",str_replace(",",".",str_replace(".","",$team['team_price'])));
	 
	$team['valorfrete'] =   str_replace($currency,"",$team['valorfrete']);
	$team['preco_comissao'] =  str_replace($currency,"",str_replace(",",".",str_replace(".","",$team['preco_comissao'])));
	$team['bonuslimite'] =  str_replace($currency,"",str_replace(",",".",str_replace(".","",$team['bonuslimite'])));
	$team['market_price'] = str_replace($currency,"",str_replace(",",".",str_replace(".","",$team['market_price']))); 
	$team['seguro_val'] = str_replace($currency,"",str_replace(",",".",str_replace(".","",$team['seguro_val']))); 
	$team['begin_time'] = strtotime(str_replace("/","-",$team['begin_time']). " ".$team['begin_time2']);
	$team['end_time'] = strtotime(str_replace("/","-",$team['end_time']). " ".$team['end_time2']);
	$team['expire_time'] = strtotime(str_replace("/","-",$team['expire_time']). " ".$team['end_time2']); 
	$team['partner_id'] = abs(intval($team['partner_id']));
	$team['user_id'] = abs(intval($team['user_id']));
	$team['sort_order'] = abs(intval($team['sort_order'])); 
	$team['pre_number'] = abs(intval($team['pre_number']));  
	$team['image'] = upload_image('upload_image',$eteam['image'],'team',true, $_POST['marcadagua']);
	$team['image1'] = upload_image('upload_image1',$eteam['image1'],'team',false,$_POST['marcadagua']);
	$team['image2'] = upload_image('upload_image2',$eteam['image2'],'team',false,$_POST['marcadagua']);

	// galeria de imagens
	$team['gal_image1'] = upload_image('gal_upload_image1',$eteam['gal_image1'],'team');
	$team['gal_image2'] = upload_image('gal_upload_image2',$eteam['gal_image2'],'team');
	$team['gal_image3'] = upload_image('gal_upload_image3',$eteam['gal_image3'],'team');
	$team['gal_image4'] = upload_image('gal_upload_image4',$eteam['gal_image4'],'team');
	$team['gal_image5'] = upload_image('gal_upload_image5',$eteam['gal_image5'],'team');
	$team['gal_image6'] = upload_image('gal_upload_image6',$eteam['gal_image6'],'team');
	$team['gal_image7'] = upload_image('gal_upload_image7',$eteam['gal_image7'],'team');  
	
	// estaticas 
	$team['estatica_home'] = upload_image('estatica_home',$eteam['estatica_home'],'estatica');
	$team['estatica_direita'] = upload_image('estatica_direita',$eteam['estatica_direita'],'estatica');
	$team['estatica_detalhe'] = upload_image('estatica_detalhe',$eteam['estatica_detalhe'],'estatica');
	$team['estatica_recentes'] = upload_image('estatica_recentes',$eteam['estatica_recentes'],'estatica');

	//team_type == goods
	if($team['team_type'] == 'goods'){
		$team['min_number'] = 1;
		$team['conduser'] = 'N';
	}

	if (!$id) {
		$team['now_number'] = $team['pre_number'];
	} else {
		$field = strtoupper($table->conduser)=='Y' ? null : 'quantity';
		$now_number = Table::Count('order', array(
					'team_id' => $id,
					'state' => 'pay',
					), $field);
		$team['now_number'] = ($now_number + $team['pre_number']);

		/* Increased the total number of state is not sold out */
		if ( $team['max_number'] > $team['now_number'] ) {
			$team['close_time'] = 0;
			$insert[] = 'close_time';
		}
	}

	$insert = array_unique($insert);
	$table = new Table('team', $team);
	$table->SetStrip('summary', 'detail', 'systemreview', 'notice');
	
	/* Comentários e perguntas e respostas, estarão ativos para todos os produtos. */
	$table->answer = "Y";
	$table->avaliacaoclientes = 1;
	/*
	if($_POST['retirada_local'] == 1) {
		$table->retirada_local = 1;
	}
	else {
		$table->retirada_local = 0;
	}
	*/
	if ($edicao) {
	
		/* Caso seja uma edição de informações e o produto seja moderado, é enviado um
		   email ao vendedor.		
		*/
		$product = Table::Fetch('team', $id);
		
		if($_POST["moderacao"] == "Y" and $product["moderacao"] == "N") {
			
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
			$mensagem = file_get_contents($INI["system"]["wwwprefix"]."/templates/moderacao_produto.php", false, $request);
				
			/* Emails são enviados ao administrador e o responsavél pelo cadastro da oferta. */
			$user = Table::Fetch('user', $team['partner_id']);
			enviar($user['email'], "Produto moderado", $mensagem);
		}
		
		/* Insere as opções */
		if(isset($_POST['id_option']) && !(empty($_POST['id_option']))) {		
			$options = array_map(null, $_POST['id_option'], $_POST['stock'], $_POST['size'], $_POST['color']);
		}
		else {
			$options = array_map(null, $_POST['stock'], $_POST['size'], $_POST['color']);		
		}

		optionsItem($id, $id_option, $options);
		
		$table->SetPk('id', $id);
		$table->update($insert);
		Session::Set('notice', 'Informações modificadas com sucesso!');
		redirect( WEB_ROOT . "/vipmin/team/".$url);
	}
	else if ($table->insert($insert)) {
		 
		$idnovo = mysql_insert_id();
		
		if($idnovo){
			
			/* Insere as opções */
			if(isset($_POST['id_option']) && !(empty($_POST['id_option']))) {		
				$options = array_map(null, $_POST['id_option'], $_POST['stock'], $_POST['size'], $_POST['color']);
			}
			else {
				$options = array_map(null, $_POST['stock'], $_POST['size'], $_POST['color']);		
			}
			
			optionsItem($idnovo, $id_option, $options);

			Session::Set('notice', 'Nova oferta adicionada ('.$idnovo.')' );	
			redirect( WEB_ROOT . "/vipmin/team/".$url);
		}
		else{
			Session::Set('error', 'Não foi possível cadastrar a nova oferta');
			redirect(null);
		}
	}
	else {
		Session::Set('error', 'Falha ao atualizar oferta '.$idnovaoferta);
		redirect(null);
	}
}
$selector = $team['id'] ? 'edit' : 'create';
include template('manage_team_edit');