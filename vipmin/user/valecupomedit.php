<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('market');
 
$codigo =  $_REQUEST['codigo']; 
$id 	=  $_REQUEST['id']; 
$valecompras = Table::Fetch('valecompras', $id);
 
$up_array = array(
		'codigo', 'limite','usado','valor','status','limiteporusuario'
 ); 
$table = new Table('valecompras', $_POST); 
 
if(!$valecompras){// cadastro 
		if( !is_post()){
			include template('manage_user_valecupomedit');
		}
		else{  
		 
		$codigo = Table::Fetch('valecompras', $codigo, 'codigo');
		if ($codigo ) {
			Session::Set('notice', 'código existente. Por favor, use outro código');
			redirect( WEB_ROOT . "/vipmin/user/valecupomedit.php");
		}    
		$table->valor = str_replace("R$","",str_replace(",",".",str_replace(".","",$table->valor))); 
			
		$flag = $table->insert($up_array);  
		
		if ( $flag) { 
			 Session::Set('notice', 'Dados cadastrados com sucesso');
			 redirect( WEB_ROOT . "/vipmin/user/valecupom.php"); 
		}
		else{ 
			 Session::Set('notice', 'Dados cadastrados com sucesso');
			 redirect( WEB_ROOT . "/vipmin/user/valecupom.php"); 
		} 
	} 
} 
else if ( is_post() ) { 
 
	$table->valor = str_replace("R$","",str_replace(",",".",str_replace(".","",$table->valor))); 
	$flag = $table->update($up_array); 
	
	if ( $flag) {
		Session::Set('notice', 'Dados alterados com sucesso');
		redirect( WEB_ROOT . "/vipmin/user/valecupom.php");
	}
	else{
		Session::Set('notice', 'Erro na alteração dos dados');
		redirect( WEB_ROOT . "/vipmin/user/valecupom.php");
	}
} 
else{
	include template('manage_user_valecupomedit');
}


