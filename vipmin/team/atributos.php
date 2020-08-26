<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php'); 

need_manager();
need_auth('team');
  
$id = abs(intval($_REQUEST['id'])); 
$idcategoria = abs(intval($_REQUEST['group_id'])); 
$team =  Table::Fetch('team', $id);
$categoria =  Table::Fetch('category', $team['group_id']);
 
//print_r($array_atributos);

if(!empty($team)){
	$edicao = true; 
} 

if ( is_get() && empty($team) ) {
	    
}
else if ( is_post() ) {

	$sql =  "delete from produto_atributos where team_id = $id";
	$rs = mysql_query($sql);
	if($rs)	{
		foreach ($_REQUEST['atributos'] as $key => $idatributo) {
				$sql =  "insert into produto_atributos (team_id,id_atributo,idcategoria) values ($id,$idatributo,$idcategoria)";
				$rs = mysql_query($sql);
		}  
		if($rs){	 
			Session::Set('notice', 'Atributos atualizados com sucesso.');
			redirect( WEB_ROOT . "/vipmin/team/index.php");
			include template('manage_team_index');
		}
		else{
			Session::Set('error', 'Erro ao atualizar os atributos. '.mysql_error());
			redirect(null); 
		}
	}	
	else{
		Session::Set('error', 'Erro ao renovar os atributos. '.mysql_error());
		redirect(null); 
	}
}
else{
	include template('manage_team_atributos');
} 
//print_r($_REQUEST);