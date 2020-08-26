<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('order');

 
$condition = array();
/* filter */
$like = strval($_GET['like']);
 
if ($like) {
	$condition[] = "email like '%".mysql_escape_string($like)."%'";
}
$uname = strval($_GET['uname']);
if ($uname) {
	$condition[] = "username like '%".mysql_escape_string($uname)."%'";
}
$action = strval($_GET['action']);
if ($action) {

	$condition['action'] = $action;
	
	$count = Table::Count('credit', $condition);
	list($pagesize, $offset, $pagestring) = pagestring($count, 20);

	$credits = DB::LimitQuery('credit', array(
		'condition' => $condition,
		'order' => 'ORDER BY id DESC',
		'size' => $pagesize,
		'offset' => $offset,
	));

}
else{

	$count = Table::Countcredito('credit', $condition);
	list($pagesize, $offset, $pagestring) = pagestring($count, 20);

	$credits = DB::LimitQuery('credit', array(
		'condition' => $condition,
		'order' => 'ORDER BY id DESC',
		'size' => $pagesize,
		'offset' => $offset,
	));
	
}
 
 




$user_ids = Utility::GetColumn($credits, 'user_id');
$users = Table::Fetch('user', $user_ids);

$option_action = array(
 
	//'login' => 'Login no site',
	'pay' => 'compra de credito',
	//'register' => 'registro no site',
	'invite' => 'convidou amigo',
);

include template('manage_credit_index');
