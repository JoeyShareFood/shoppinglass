<?php

require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('admin');

$produto = strval($_GET['produto']);
$id =  $_GET['id'];

if ($produto) { 
	$condition[] = "id_produto = " . $produto;
}
if ($id) { 
	$condition[] = "id = " . $id;
}
/* end */ 
$count = Table::Count('questions', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 20);
$users = DB::LimitQuery('questions', array(
	'condition' => $condition,
	'order' => 'ORDER BY id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));

include template('manage_user_question');