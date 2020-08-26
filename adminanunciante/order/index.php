<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_anunciante();

if(isset($login_user_id) and !(empty($login_user_id))) {
	$partner_id = $login_user_id;
} else {
	$partner_id = $login_partner_id;
}

$condition[] = "partner_id = " . $partner_id;

if($_REQUEST['saldo']=='true'){
	$condition = array(
		'state' => 'pay',
		'team_id > 0',
		'credit > 0',
	);
}

if(isset($_GET['datapedido'])){
	$datapedido = explode('/', $_GET['datapedido']);
	$datapedido = implode('-', array_reverse($datapedido));
	$condition[] = "datapedido like '".$datapedido."%'";
}

/*
$t_con = array(
	'begin_time < '.time(),
	'end_time > '.time(),
);*/
$teams = DB::LimitQuery('team');
$t_id = Utility::GetColumn($teams, 'id');
 
/* filter */
$uname = strval($_REQUEST['uemail']);

if ($uname) {
	$ucon = array( "email like '%".mysql_escape_string($uname)."%' OR username like '%".$uname."%'");
	$uhave = DB::LimitQuery('user', array( 'condition' => $ucon,));
	if ($uhave) $condition['user_id'] = Utility::GetColumn($uhave, 'id');
}
/*
if ($uemail) {
	$field = strpos($uemail, '@') ? 'email' : 'username';
	$field = is_numeric($uemail) ? 'id' : $field;
	$uuser = Table::Fetch('user', $uemail, $field);
	$condition['user_id'] = $uuser['id'];
	 
}*/

$id = abs(intval($_GET['id'])); if ($id) $condition['id'] = $id;
$quantity =  $_GET['quantity']  ; if ($quantity) $condition['quantity'] = $quantity;
$origin =  $_GET['origin']  ; if ($origin) $condition['origin'] = $origin;
$state =  $_GET['state']  ; if ($state) $condition['state'] = $state;
$credit =  $_GET['credit']  ; if ($credit) $condition['credit'] = $credit;

$team_id = abs(intval($_GET['team_id']));
if ($team_id && in_array($team_id, $t_id)) {
	$condition['team_id'] = $team_id;
} else { $team_id = null; }
 
/* end fiter */

$count = Table::Count('order', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$orders = DB::LimitQuery('order', array(
	'condition' => $condition,
	'order' => 'ORDER BY id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));

$pay_ids = Utility::GetColumn($orders, 'pay_id');
$pays = Table::Fetch('pay', $pay_ids);

$user_ids = Utility::GetColumn($orders, 'user_id');
$users = Table::Fetch('user', $user_ids);

$team_ids = Utility::GetColumn($orders, 'team_id');
$teams = Table::Fetch('team', $team_ids);

include template('manage_order_anunciante_index');

