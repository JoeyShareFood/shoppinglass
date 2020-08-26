<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('market');
 
$tipo = $_REQUEST['tipo'];
$adminnew =  $_REQUEST['adminnew'];
$id = abs(intval($_GET['id']));
$email =  $_REQUEST['email'];
$username =  $_REQUEST['username'];

$pg="index.php";
 
if($tipo=="admin"){
 $pg="manager.php";
}

if($adminnew=="true"){
	$urlaux =  "?adminnew=true";
}

$user = Table::Fetch('user', $id);
 
if(!empty($user)){
	$edicao = true; 
}

if ( !$edicao ) { // cadastro
	
	if( !is_post()){
		include template('manage_user_edit');
	}
	else{ 
		 
		$table = new Table('user', $_POST);
		$up_array = array(
				'login', 'realname','email', 'password','manager','mobile', 'zipcode', 'address','local','bairro','money','cpf','estado','cidadeusuario', 'comissao','status', 'create_time', 'login_time'
				);
  
		$eu = Table::Fetch('user', $email, 'email');
		if ($eu ) {
			Session::Set('notice', 'Email existente. Por favor, use outro email');
			redirect( WEB_ROOT . "/vipmin/user/edit.php".$urlaux);
		}
		  	 
		$eu = Table::Fetch('user', $username, 'username');
		if ($eu ) {
			Session::Set('notice', 'Login existente. Por favor, use outro login');
			redirect( WEB_ROOT . "/vipmin/user/edit.php".$urlaux);
		}
		  
		if ( $login_user_id == 1 && $id > 1 ) { $up_array[] = 'manager'; }
		if ( $id == 1 && $login_user_id > 1 ) {
			Session::Set('notice', 'Você não tem privilegio de super administrador para fazer as alterações');
			
			redirect( WEB_ROOT . "/vipmin/user/$pg");
		}
		$table->manager = (strtoupper($table->manager)=='Y') ? 'Y' : 'N';
		$table->senha = $table->password;
		$table->create_time = time();
		$table->password = ZUser::GenPassword($table->password);
	   
		$flag = $table->insert($up_array); 
		
		if ( $flag) {
			if($adminnew=="true"){
			
			 Session::Set('notice', 'Dados do administrador cadastrados com sucesso');
			 redirect( WEB_ROOT . "/vipmin/user/manager.php");
			}
			else{
			 Session::Set('notice', 'Dados do usu&aacute;rio cadastrados com sucesso');
			 redirect( WEB_ROOT . "/vipmin/user/index.php");
			 
			}
		}
		else{
			if($adminnew=="true"){
			
			 Session::Set('notice', 'Dados do administrador cadastrados com sucesso');
			 redirect( WEB_ROOT . "/vipmin/user/manager.php");
			}
			else{
			 Session::Set('notice', 'Dados do usu&aacute;rio cadastrados com sucesso');
			 redirect( WEB_ROOT . "/vipmin/user/index.php");
			 
			}
		}
		 
	} 
}

else  { // edicao
  
	if(!is_post()){
		include template('manage_user_edit');
	}
	else{ 
		$table = new Table('user', $_POST);
		 
			$up_array = array(
				'username', 'realname','email','manager','mobile', 'zipcode', 'address','local','bairro','money','cpf','estado','cidadeusuario', 'comissao',
				);
		$eu = Table::Fetch('user', $email, 'email');
		
		if ($eu && $eu['id'] != $id ) {
			Session::Set('notice', 'Email existente. Por favor, use outro email');
			redirect( WEB_ROOT . "/vipmin/user/edit.php?id=$id");
		}
		  	 
		$eu = Table::Fetch('user', $username, 'username');
		if ($eu && $eu['id'] != $id ) {
			Session::Set('notice', 'Login existente. Por favor, use outro login');
			redirect( WEB_ROOT . "/vipmin/user/edit.php?id=$id");
		}
		
		if ( $login_user_id == 1 && $id > 1 ) { $up_array[] = 'manager'; }
		if ( $id == 1 && $login_user_id > 1 ) {
			Session::Set('notice', 'Você não tem privilegio de super administrador para fazer as alterações');
			redirect( WEB_ROOT . "/vipmin/user/edit.php?id=$id");
		}
	 
		$table->manager = (strtoupper($table->manager)=='Y') ? 'Y' : 'N';
		if ($table->password ) {
			$senha = $table->password;
			$table->password = ZUser::GenPassword($table->password);
			$up_array[] = 'password';
			$sql = "update user set senha='".$senha."' where username='".$table->username."'";
			mysql_query($sql);
			 
		} 
		$flag = $table->update($up_array); 
		
		if ( $flag) {
			Session::Set('notice', 'Dados do usu&aacuterio alterados com sucesso');
			 redirect( WEB_ROOT . "/vipmin/user/$pg");
		}
		else{
			Session::Set('notice', 'Erro na alteração dos dados');
			redirect( WEB_ROOT . "/vipmin/user/edit.php?id=$id");
		}
	} 
}