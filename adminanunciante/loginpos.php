<?php
require_once(dirname(dirname(__FILE__)) . '/app.php'); 
  
$sql = "ALTER TABLE `partner` DROP INDEX `UNQ_ct`";
$rs = @mysql_query($sql);

if ( $_POST ) { 
		
		$login_admin = ZUser::GetLogin($_POST['username'], $_POST['password']);
		
		if ( !$login_admin ) {
			Session::Set('error', 'Nome de usuário e senha não conferem!');
			redirect( WEB_ROOT . '/adminanunciante/login.php');
		}
	 
	
	if($login_admin){
	
		Session::Set('user_id', $login_admin['id']); 
		 
		redirect( WEB_ROOT . '/adminanunciante/index.php');
	}
}

include template('manage_login');