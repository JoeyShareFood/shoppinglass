<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('design');

$system = Table::Fetch('system', 1);

if ($_POST) {
	need_manager(true);
	unset($_POST['commit']);
 
	$INI = Config::MergeINI($INI, $_POST);
	$INI = ZSystem::GetUnsetINI($INI);
	save_config();

	$value = Utility::ExtraEncode($INI);
	$table = new Table('system', array('value'=>$value));
	if ( $system ) $table->SetPK('id', 1);
	$flag = $table->update(array( 'value'));

	Session::Set('notice', 'Informações atualizadas com sucesso!');
	redirect( WEB_ROOT . '/vipmin/system/cores.php');
}
if ($_GET['template']){
	
	$template = $_GET['template'];
	
	$destino_c	= WWW_ROOT."/include/configure/cores.php";	
	$destino_h	= WWW_ROOT."/include/configure/header.php";	
	$destino_b	= WWW_ROOT."/include/configure/background.php";	 
	
	$origem_c 	= WWW_ROOT."/include/configure/templates/$template/cores.php";	
	$origem_h 	= WWW_ROOT."/include/configure/templates/$template/header.php";	
	$origem_b	= WWW_ROOT."/include/configure/templates/$template/background.php";	
	 
	if (!copy( $origem_c, $destino_c )){
		$erro_c = true;
		Session::Set('notice', 'Houve um erro ao copiar as cores.');
	}
	else if (!copy( $origem_h, $destino_h )){
		$erro_h = true;
		Session::Set('notice', 'Houve um erro ao copiar o cabeçalho.');
	}
	else if (!copy( $origem_b, $destino_b )){
		$erro_b = true;
		Session::Set('notice', 'Houve um erro ao copiar o background.');
	}	
 
	/******* INICIO  somente para ambiente de testes, remover para o cliente **************/
	
	$origem_op	= WWW_ROOT."/include/configure/templates/$template/option.php";	
	$origem_bu	= WWW_ROOT."/include/configure/templates/$template/bulletin.php";	
	$origem_lo	= WWW_ROOT."/include/configure/templates/$template/logo.png";

	$destino_op	= WWW_ROOT."/include/configure/option.php";	
	$destino_bu	= WWW_ROOT."/include/configure/bulletin.php";	
	$destino_lo	= WWW_ROOT."/include/logo/logo.png"; 
	
	$origem_slide 	= WWW_ROOT."/include/configure/templates/$template/banner.jpg";
	$destino_slide	= WWW_ROOT."/media/slideshowbanners/banner.jpg";	
	
	$origem_slide_thumb 	= WWW_ROOT."/include/configure/templates/$template/banner_thumb.jpg";
	$destino_slide_thumb	= WWW_ROOT."/media/slideshowbanners/thumbs/banner.jpg";	

	if (!copy( $origem_bu, $destino_bu )){
		$erro_bu = true;
		Session::Set('notice', 'Houve um erro ao copiar o bulletin.');
	}	
	else if (!copy( $origem_lo, $destino_lo )){
		$erro_lo = true;
		Session::Set('notice', 'Houve um erro ao copiar a logo.');
	}	
	else if (!copy( $origem_op, $destino_op )){
		$erro_op = true;
		Session::Set('notice', 'Houve um erro ao copiar o arquivo de opções.');
	}
	else if (!copy( $origem_slide, $destino_slide )){
		$erro_slide = true;
		Session::Set('notice', 'Houve um erro ao copiar o banner do slide.');
	}	
	else if (!copy( $origem_slide_thumb, $destino_slide_thumb )){
		$erro_slide_thumb = true;
		Session::Set('notice', 'Houve um erro ao copiar o thumb banner do slide.');
	}
	/************  FIM AMBIENTE DE TESTES *************/
	
	if(!$erro_h and !$erro_c and !$erro_b and !$erro_bu and !$erro_slide and !$erro_lo and !$erro_op){
		if($template=="01"){
			Session::Set('notice', 'Cores restauradas com sucesso ! Aperte CTRL + F5 para remover o cache do seu navegador');
		}
		else{
			Session::Set('notice', 'Template atualizada com sucesso ! Aperte CTRL + F5 para remover o cache do seu navegador');
		}
	}
	
}
include template('manage_system_cores');


