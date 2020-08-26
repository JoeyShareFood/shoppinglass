<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('market');
 
$id =  $_REQUEST['id'] ;
$category = Table::Fetch('category', $id);
$zone = $_REQUEST['zone'];
 
 
if($zone=="city"){
	$tipo="Cidade";
}
else{
	$tipo="Categoria";
}

if(!empty($category)){
	$edicao = true; 
}

if ( !$edicao ) { // cadastro
	
	if( !is_post()){
		include template('manage_category_edit');
	}
	else{ 
		 
		$table = new Table('category', $_POST); 
		$uarray = array( 'zone',  'name', 'display', 'displaycateg', 'categoria_destaque', 'sort_order','bannercategoria','idpai','tipo','linkexterno','target','imagemcateg','imagemnavegacao', 'imagemcateghome', 'bannernavegacao','mostrartopo','seo_cat_key','seo_cat_descricao','seo_cat_title');
		$table->display = strtoupper($table->display)=='Y' ? 'Y' : 'N';
		$table->displaycateg = strtoupper($table->displaycateg)=='Y' ? 'Y' : 'N';
		$table->imagemcateg = upload_image('imagemcateg',$category2['imagemcateg'],'categoria');
		$table->imagemcateghome = upload_image('imagemcateghome',$category2['imagemcateghome'],'imagemcateghome');
			
		$flag = $table->insert($uarray);
		
		if($flag){
			Session::Set('notice', 'Dados cadastrados com sucesso.');
			redirect( WEB_ROOT . "/vipmin/category/index.php?zone=$zone");
		}
		else{
			Session::Set('notice', 'Erro na alteração dos dados');
			redirect( WEB_ROOT . "/vipmin/category/index.php?zone=$zone");
		}
	
	} 
}

else  { // edicao
 
	if(!is_post()){
		include template('manage_category_edit');
	}
	else{
	
		$table = new Table('category', $_POST); 
		$uarray = array( 'zone',  'name', 'display', 'displaycateg', 'categoria_destaque', 'sort_order','bannercategoria','idpai','tipo','linkexterno','target','imagemcateg', 'imagemcateghome', 'imagemnavegacao','bannernavegacao','mostrartopo','seo_cat_key','seo_cat_descricao','seo_cat_title');
		$table->display = strtoupper($table->display)=='Y' ? 'Y' : 'N';
		$table->displaycateg = strtoupper($table->displaycateg)=='Y' ? 'Y' : 'N';
		
		if($_FILES['imagemcateg']['name'] != ""){
			$table->imagemcateg = upload_image('imagemcateg',$category2['imagemcateg'],'categoria');
		 }
		 
		if($_FILES['imagemcateghome']['name'] != "") {
			$table->imagemcateghome = upload_image('imagemcateghome',$category2['imagemcateghome'],'imagemcateghome');
		}		
		$flag = $table->update($uarray); 
		
		if ( $flag) {
			Session::Set('notice', 'Dados alterados com sucesso');
			redirect( WEB_ROOT . "/vipmin/category/index.php?zone=$zone");
		}
		else{
			Session::Set('notice', 'Erro na alteração dos dados');
			redirect( WEB_ROOT . "/vipmin/category/index.php?zone=$zone");
		}
	} 
}