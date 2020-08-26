<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('market');

if ( $_POST ) {

	/*
	$_POST['content'] = stripslashes($_POST['content']);

	$content = $_POST['content'];
	$emails = $_POST['emails'];
	$subject = $_POST['title'];

	$emails = preg_split('/[\s,]+/', $emails, -1, PREG_SPLIT_NO_EMPTY);
	$emails_array = array();
	$cont=0;
	foreach($emails AS $one) 
		if(Utility::ValidEmail($one)) 
			$emails_array[]=$one;
	$email_count = count($emails_array);
    $cont++;
	sleep(2);
	if($cont == 11){
		$cont=0;
		sleep(10);
	}
	*/
	
	/*personalização de envio de email*/
	$emails = $_POST['emails'];
	$emails 		= preg_split('/[\s,;]+/', $emails, -1, PREG_SPLIT_NO_EMPTY);
	$emails_array 	= array();
	$subject 		= $_POST['title'];
	$content 		= $_POST['content'];
	 
 
	 $cont=0;
	foreach($emails AS $one) { 
		 
		if(Utility::ValidEmail($one)){
			$emails_array[]=$one;
			$email_count = count($emails_array);
			enviar($one, $subject, $content );
			$cont++;
			sleep(2);
			if($cont == 11){
				$cont=0;
				sleep(11);
			}
		}
	}
  
	/* fim envio */
			
	$hostprefix = "http://{$_SERVER['HTTP_HOST']}/";
	$content = str_ireplace('href="/', "href=\"{$hostprefix}", $content);

	if ( !$email_count ) {
		Session::Set('error', 'Email falhou: sem endereço de e-mail validado');
	} else {
		  Session::Set('notice', "E-mail enviado com sucesso. Quantidade enviado: {$email_count}");
		  redirect( WEB_ROOT . '/vipmin/market/index.php' );
	}
}

include template('manage_market_email');
