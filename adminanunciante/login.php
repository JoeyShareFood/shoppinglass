<?php
 
require_once(dirname(dirname(__FILE__)) . '/app.php'); 

unset($_SESSION['user_id']);  

if ( $_POST ) {
	
		$login_admin = ZUser::GetLogin($_POST['username'], $_POST['password']);
		if ( !$login_admin ) {
			echo "Nome de usuário e senha não conferem!"; 
		}
	
	
	
	if ( $login_admin ) {
	
	
		Session::Set('user_id', $login_admin['id']);
		ZLogin::Remember($login_admin); 
		ZUser::SynLogin($login_admin['username'], $_POST['password']); 
	}
} 
else{

	include template('manage_login_anunciante');
}