<?php 
$id = abs(intval(RemoveXSS($_REQUEST['id'])));
$id_option = abs(intval(RemoveXSS($_REQUEST['id_option'])));
 
if ($id != 0 and !empty($id)) { 
	
	$team = Table::Fetch('team', $id);  
	$options = Table::Fetch('options', $id_option);

	/* Caso tenha apenas uma op��o */
	if(empty($options)) {
		$sqlOpt = "select * from options where team_id = " . $id;
		$rsOpt  = mysql_query($sqlOpt);
		$options = mysql_fetch_assoc($rsOpt);  
	}	
	
	/*====== GRAVA��O DE CAMPOS */
	if($_REQUEST['condbuy']){
		$_SESSION['condbuy_'.$team['id']] =  $_REQUEST['condbuy'] ;
	}
	if($_REQUEST['condbuy2']){
		$_SESSION['condbuy2_'.$team['id']] =  $_REQUEST['condbuy2'] ;
	} 
	/*================FIM GRAVACAO DE CAMPOS*/ 

	/*================ RECUPERA��O DA SESS�O*/
	if (isset($_SESSION['carrinhoitens'])) {
		$itens = json_decode($_SESSION['carrinhoitens'], true);
		$itens[0] = $team;
		$_SESSION['carrinhoitens'] = json_encode($itens);
	} 
	else {  
		$itens = Array(0 => $team);
		$_SESSION['carrinhoitens'] = json_encode($itens);
	}   
}
else{
	//header("Location: ".$ROOTPATH);
}

?>