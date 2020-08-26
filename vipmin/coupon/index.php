<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('order');

$daytime = strtotime(date('d-m-Y'));
 
if($_REQUEST['expire']=="true" ){
	$condition = array(
		'consume' => 'N',
		'expire_time < ' . $daytime,
	);
}


/* fiter */
$partner_id =  $_GET['partner_id']  ; if ($partner_id) $condition['partner_id'] = $partner_id;
$order_id =  $_GET['order_id']  ; if ($order_id) $condition['order_id'] = $order_id;
$consume =  $_GET['consume']  ; if ($consume) $condition['consume'] = $consume;

$envioucupom =  $_GET['envioucupom']  ; if ($envioucupom=="0") {$condition[] = "envioucupom  is null";}
$envioucupom =  $_GET['envioucupom']  ; if ($envioucupom=="1") {$condition['envioucupom'] = $envioucupom;}

$nome =  $_GET['nome']  ; if ($nome) $condition['nome'] = $nome;
$tid = strval($_GET['tid']);
$coupon = strval($_GET['coupon']);
$uname = strval($_GET['uname']);
if ($tid) { $condition['team_id'] = $tid; } else { $tid = null; }

if ($coupon) {
	$condition[] = "id like '%".mysql_escape_string($coupon)."%'";
}
 
if ($uname) {
	$ucon = array( "email like '%".mysql_escape_string($uname)."%' OR username like '%".$uname."%'");
	$uhave = DB::LimitQuery('user', array( 'condition' => $ucon,));
	if ($uhave) $condition['user_id'] = Utility::GetColumn($uhave, 'id');
}
 
/* end */

$count = Table::Count('coupon', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$coupons = DB::LimitQuery('coupon', array(
	'condition' => $condition,
	'order' => 'ORDER BY team_id DESC, id ASC',
	'size' => $pagesize,
	'offset' => $offset,
));

$users = Table::Fetch('user', Utility::GetColumn($coupons, 'user_id'));
$teams = Table::Fetch('team', Utility::GetColumn($coupons, 'team_id'));
$partner = Table::Fetch('partner', Utility::GetColumn($coupons, 'partner_id'));

$selector = 'index';
$condition_p[] = " tipo = 'parceiro' or tipo is null";
$partners = DB::LimitQuery('partner', array(
			'condition' => array( $condition_p ),
			'order' => 'ORDER BY id DESC',
			));
$partners = Utility::OptionArray($partners, 'id', 'title');

include template('manage_coupon_index');
