<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('design');
 

if ($_POST) {
	$modelo  = $_REQUEST['modelo_produto'];
	$sql= "update home_config set modelo_produto = '$modelo'";
	 $rs = mysql_query($sql);
	 
	Utility::Redirect(WEB_ROOT.'/vipmin/system/produtos.php');		
} 

 $sql= "select modelo_produto from home_config";
$rs = mysql_query($sql);
$row =  mysql_fetch_object($rs);
$modelo_produto = $row->modelo_produto;
	 
include template('manage_system_produtos');
