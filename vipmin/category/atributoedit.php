<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('market');
 
$idcategoria =  $_REQUEST['idcategoria'] ;
$category = Table::Fetch('category', $idcategoria);
 
if($category['idpai'] != 0) {
	$categoriapai = Table::Fetch('category', $category['idpai']);
} 

if($_REQUEST['idatributo']){
	$category_atributos = Table::Fetch('category_atributos', $_REQUEST['idatributo']);
	$edicao = true; 
}
$zone = $_REQUEST['zone'];
$uarray = array( 'category_id',  'id_atributopai', 'nome_atributo', 'status', 'ordem' );


if ( !$edicao ) { // cadastro
	
	if( !is_post()){
		include template('manage_category_atributoedit');
	}
	else{ 
		 
		$table = new Table('category_atributos', $_POST);    
		$flag = $table->insert($uarray);
		
		if($flag){
			Session::Set('notice', 'Dados cadastrados com sucesso.');
			redirect( WEB_ROOT . "/vipmin/category/atributoedit.php?zone=$zone&idcategoria=". $_REQUEST['category_id']);
		}
		else{
			Session::Set('notice', 'Erro na alteração dos dados');
			redirect( WEB_ROOT . "/vipmin/category/atributoedit.php?zone=$zone&idcategoria=". $_REQUEST['category_id']);
		}
	
	} 
}

else  { // edicao
 
	if(!is_post()){
		include template('manage_category_atributoedit');
	}
	else{
	
		$table = new Table('category_atributos', $_POST);   
		$flag = $table->update($uarray); 
		
		if ( $flag) {
			Session::Set('notice', 'Dados alterados com sucesso');
			redirect( WEB_ROOT . "/vipmin/category/atributoedit.php?zone=$zone&idcategoria=". $_REQUEST['category_id']);
		}
		else{
			Session::Set('notice', 'Erro na alteração dos dados');
			redirect( WEB_ROOT . "/vipmin/category/atributoedit.php?zone=$zone&idcategoria=". $_REQUEST['category_id']);
		}
	} 
}