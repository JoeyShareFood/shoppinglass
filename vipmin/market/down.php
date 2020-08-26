<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('market');

if ( $_POST ) {
	$city_id = $_POST['city_id'];
	$users = DB::LimitQuery('user', array(
				'condition' => array(
					'city_id' => $city_id,
					'mobile > 0',
					),
				'select' => 'email, realname, mobile',
				));
	if ( $users ) {
		$kn = array(
				'email' => 'Email',
				'realname' => 'Nome',
				'mobile' => 'Celular',
				);
		$name = "mobile_".date('Ymd');
		down_xls($users, $kn, $name);
	}
	die('Nenhum registro encontrado');
}

include template('manage_market_downsms');
