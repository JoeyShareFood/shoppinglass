<?php
require_once(dirname(__FILE__) . '/app.php');

if($_REQUEST["idpagina"]){
	$idpagina 	= explode("/",RemoveXSS($_REQUEST["idpagina"])); // urlrewrite
	$idpagina = $idpagina[0]; 
} 
if($_REQUEST["idcategoria"]){ 
	$parametros 	= explode("/",$_REQUEST["idcategoria"]); // urlrewrite  
	$idcategoria = $parametros[1]; 
	$idsatributos = $parametros[2]; // se existir	 
}
envia_email_pedido_abandonado();

if($_REQUEST["idoferta"]){
 
	$idoferta 	= explode("/",RemoveXSS($_REQUEST["idoferta"])); // urlrewrite
	$linkaux 	= explode("/",RemoveXSS($_REQUEST["idoferta"])); // urlrewrite
	$idoferta	=  $idoferta[0]; 
}
if($_REQUEST['login_fb']=="true"){
	mail_cadastro_fb(RemoveXSS($_REQUEST['user_id']));		
} 
 
if($_REQUEST['page']){
	require_once(DIR_DESIGN."/".$_REQUEST["page"].".php");
	exit;
} 
if($idoferta){
	require_once(DIR_DESIGN."/detalhe_produto.php");
}
else if($INI['option']['paginainicial'] != "" ){
	$idpagina  = $INI['option']['paginainicial'];
	require_once(DIR_DESIGN."/pagina.php");
}
else{
	$HOME =  'sim';
	require_once(DIR_DESIGN."/home.php");
}

//EnvioFatura();

?>  