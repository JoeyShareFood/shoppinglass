<?php

require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('admin');

$pedido = strval($_GET['pedido']);
$id =  $_GET['id'];

if ($pedido) { 
	$condition[] = "id_order = " . $pedido;
}
if ($id) { 
	$condition[] = "id = " . $id;
}
/* end */ 
$count = Table::Count('qualification', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 20);
$users = DB::LimitQuery('qualification', array(
	'condition' => $condition,
	'order' => 'ORDER BY id ASC',
	'size' => $pagesize,
	'offset' => $offset,
));

include template('manage_user_qualification');