<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('market');

if ( $_POST ) {
	$gender = $_POST['gender'];
	$newbie = $_POST['newbie'];
	$city_id = $_POST['city_id'];
	if (!$city_id || !$newbie || !$gender) die('-ERR ERR_CHECK');

	$condition = array(
		'gender' => $gender,
		'newbie' => $newbie,
		'city_id' => $city_id,
	);

	$users = DB::LimitQuery('user', array(
		'condition' => $condition,
		'user' => 'ORDER BY id DESC',
	));

	if (!$users) die('-ERR ERR_NO_DATA');

	$name = 'user_'.date('Ymd');
	$kn = array(
		'id' => 'ID',
		'email' => 'Email',
		'username' => 'Usuario',
		'realname' => 'Nome',
		'gender' => 'Sexo',
		'mobile' => 'Celular',
		'zipcode' => 'Cep',
		'address' => 'Endereco',
		);

	$gender = array(
		'M' => 'Masculino',
		'F' => 'Feminino',
	);
	$newbie = array(
		'Y' => 'yes',
		'N' => 'no',
	);

	$eusers = array();
	foreach( $users AS $one ) {
		$one['gender'] = $gender[$one['gender']];
		$one['newbie'] = $newbie[$one['newbie']];
		$eusers[] = $one;
	}
	down_xls($eusers, $kn, $name);
}

include template('manage_market_downuser');
