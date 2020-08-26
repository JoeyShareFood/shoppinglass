<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('market');

if (is_post()){
	$card = $_POST;

	$card['quantity'] = abs(intval($card['quantity']));
	$card['money'] = abs(intval($card['money']));
	$card['partner_id'] = abs(intval($card['partner_id']));
	$card['begin_time'] = strtotime($card['begin_time']);
	$card['end_time'] = strtotime($card['end_time']);

	$error = array();
	if ( $card['money'] < 1 ) {
		$error[] = "the coupon value is no less than 1";
	}
	if ( $card['quantity'] < 1 || $card['quantity'] > 1000 ) {
		$error[] = "A quantidade de cupons produzidos deve ficar entre 1-1000";
	}
	$today = strtotime(date('d-m-Y'));
	if ( $card['begin_time'] < $today ) {
		$error[] = "data inicial não pode ser antes do que hoje";
	}
	elseif ( $card['end_time'] < $card['begin_time'] ) {
		$error[] = "data do fim não pode ser antes da data inicial";
	}
	if ( !$error && ZCard::CardCreate($card) ) {
		Session::Set('notice', "{$card['quantity']} cupons criado com sucesso");
		redirect(WEB_ROOT . '/vipmin/coupon/cardcreate.php');
	}
	$error = join("<br />", $error);
	Session::Set('error', $error);
}
else {
	$card = array(
		'begin_time' => time(),
		'end_time' => strtotime('+3 months'),
		'quantity' => 10,
		'money' => 10,
		'code' => date('dmY').'_WR',
	);
}

include template('manage_coupon_cardcreate');
