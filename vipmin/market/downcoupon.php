<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('market');

if ( $_POST ) {
	$team_id = abs(intval($_POST['team_id']));
	$consume = $_POST['consume'];
	if (!$team_id || !$consume) die('Por favor, existem campos a serem marcados. Verifique o filtro.');

	$condition = array(
		'team_id' => $team_id,
		'consume' => $consume,
	);

	$coupons = DB::LimitQuery('coupon', array(
		'condition' => $condition,
	));
	if (!$coupons) die('Nenhum cupom encontrado para este filtro.');

	$users = Table::Fetch('user',Utility::GetColumn($coupons,'user_id'));
	$orders = Table::Fetch('order',Utility::GetColumn($coupons,'order_id'));

	$team = Table::Fetch('team', $team_id);
	$name = 'coupon_'.date('Ymd');
	$kn = array(
		'id' => 'No do cupom',
		'username' => 'username',
		'secret' => 'Senha do cupom',
		'condbuy' => 'Opcao',
		'date' => 'Data',
		'remark' => 'Notas',
		'consume' => 'Consumido',
		);

	$consume = array(
		'Y' => 'used',
		'N' => 'usable',
	);
	$ecoupons = array();
	foreach( $coupons AS $one ) {
		$one['id'] = "#{$one['id']}";
		$one['username'] = $users[$one['user_id']]['username'];
		$one['consume'] = $consume[$one['consume']];
		$one['condbuy'] = $orders[$one['order_id']]['condbuy'];
		$one['remark'] = $orders[$one['order_id']]['remark'];
		$one['date'] = date('d-m-Y', $one['expire_time']);
		$ecoupons[] = $one;
	}
	down_xls($ecoupons, $kn, $name);
}

include template('manage_market_downcoupon');
