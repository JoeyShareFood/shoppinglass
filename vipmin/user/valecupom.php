<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('admin');

$email = strval($_GET['email']); 
$bairro = strval($_GET['bairro']); 
  
$condition = array();

/* filter */
//$id =  $_GET['id']  ; if ($id) $condition['id'] = $id;
  /*
if($bairro) { 
	$condition[] = "bairro like '%".mysql_escape_string($bairro)."%'";
} 
if ($email) { 
	$condition[] = "email like '%".mysql_escape_string($email)."%'";
}
 */
/* end */ 
$count = Table::Count('valecompras', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$valecompras = DB::LimitQuery('valecompras', array(
	'condition' => $condition,
	'order' => 'ORDER BY id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));
  
include template('manage_user_valecupom');
