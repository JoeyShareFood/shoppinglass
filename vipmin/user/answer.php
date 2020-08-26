<?php

require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('admin');

$id =  $_GET['id'];

if ($id) { 
	$condition[] = "id = " . $id;
}
/* end */ 
$count = Table::Count('answer', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 20);
$users = DB::LimitQuery('answer', array(
	'condition' => $condition,
	'order' => 'ORDER BY id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));

include template('manage_user_answer');