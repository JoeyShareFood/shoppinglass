<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('market');

if ( $_POST ) {
	$phones = preg_split('/[\s,]+/', $_POST['phones'], -1, PREG_SPLIT_NO_EMPTY);
	$content = trim(strval($_POST['content']));
	$phone_count = count($phones);
	$phones = implode(',', $phones);
	if($phone_count > 1){
		$ret = sms_send_marketing($phones, $content);
	}
	else{
		$ret = sms_send($phones, $content);
	}
	
	if ( $ret===true ) {
		Session::Set('notice', "Torpedos enviados com sucesso. Número de sms enviados: {$phone_count}");
		redirect( WEB_ROOT + '/vipmin/market/sms.php' );
	}
	Session::Set('notice', "Falha no envio de SMS: {$ret}");
}

include template('manage_market_sms');
