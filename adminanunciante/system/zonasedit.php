<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('market'); 
$id =  $_REQUEST['id'] ;
  
$zonas_entrega = Table::Fetch('zonas_entrega', $id);
 
if(!empty($zonas_entrega)){
	$edicao = true; 
}   

$up_array  = array(  'identific', 'nome', 'prazo_entrega', 'valor_frete', 'ativo','texto','ordenacao');

if ( !$edicao ) { // cadastro
	
	if( !is_post()){
		include template('manage_system_zonasedit');
	}
	else{ 
		$table = new Table('zonas_entrega', $_POST); 
	 
		$table->valor_frete =  str_replace("R$ ","",str_replace(",",".",str_replace(".","",$table->valor_frete)));
			  
		$flag = $table->insert($up_array);
		
		if($flag){
			Session::Set('notice', 'Registro cadastrado com sucesso.');
			redirect( WEB_ROOT . "/vipmin/system/zonas.php");
		}
		else{
			Session::Set('notice', 'Erro na alteração dos dados');
			redirect( WEB_ROOT . "/vipmin/system/zonas.php");
		}
	
	} 
}

else  { // edicao
 
	if(!is_post()){
		include template('manage_system_zonasedit');
	}
	else{
		$table = new Table('zonas_entrega', $_POST);  
		$table->valor_frete =  str_replace("R$ ","",str_replace(",",".",str_replace(".","",$table->valor_frete)));
		
		if($_POST['metododosistema']=="s"){
			$table->valor_frete		=	"";
			$table->prazo_entrega	=	"";
		} 
		$flag = $table->update( $up_array );
		
		if ( $flag) {
			Session::Set('notice', 'Dados alterados com sucesso');
			redirect( WEB_ROOT . "/vipmin/system/zonas.php");
		}
		else{
			Session::Set('notice', 'Erro na alteração dos dados');
			redirect( WEB_ROOT . "/vipmin/system/zonas.php");
		}
	} 
}

