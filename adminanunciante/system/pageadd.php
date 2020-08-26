<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
need_auth('market');
 
$id =  $_REQUEST['id'] ;
$page = Table::Fetch('page', $id);

if(!empty($page)){
	$edicao = true; 
}

$table 	= new Table('page', $_POST); 
$uarray = array('value',  'data_criacao', 'titulo', 'status', 'maintop');

if ( !$edicao ) { // cadastro
	
	if( !is_post()){
		include template('manage_system_pageadd');
	}
	else{  
		$table->data_criacao = date("Y-m-d H:i:s"); 
		$flag = $table->insert($uarray);
		
		if($flag){
			Session::Set('notice', 'Dados cadastrados com sucesso.');
			redirect( WEB_ROOT . "/vipmin/system/page.php");
		}
		else{
			Session::Set('notice', 'Erro no cadastro dos dados');
			redirect( WEB_ROOT . "/vipmin/system/pageadd.php");
		}
	} 
}

else  { // edicao
 
	if(!is_post()){
		include template('manage_system_pageadd');
	}
	else{ 
		$table->datamodificacao = date("Y-m-d H:i:s");
		$flag = $table->update($uarray); 
		
		if($flag){
			Session::Set('notice', 'Dados alterados com sucesso.');
			redirect( WEB_ROOT . "/vipmin/system/page.php");
		}
		else{
			Session::Set('notice', 'Erro na alteração dos dados');
			redirect( WEB_ROOT . "/vipmin/system/pageadd.php");
		}
	} 
} 
 