<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('market');
 
$id = abs(intval($_GET['id']));
$partner = Table::Fetch('partner', $id);

if(!empty($partner)){
	$edicao = true; 
}

if ( !$edicao ) { // cadastro
	
	if( !is_post()){
		include template('manage_partner_edit');
	}
	else{

		$_POST['location']="1t";

		$table = new Table('partner', $_POST);
		$table->SetStrip('location', 'other');
		$table->create_time = time();
		$table->user_id 	= $login_user_id;
		$table->senha 		= $table->password;
		$table->password 	= ZPartner::GenPassword($table->password);
		$table->tipo 		=  "parceiro";
		$table->group_id 	= abs(intval($table->group_id));
		$table->city_id 	= abs(intval($table->city_id));
		$table->open 		= (strtoupper($table->open)=='Y') ? 'Y' : 'N';
		$table->display 	= (strtoupper($table->display)=='Y') ? 'Y' : 'N';
		$table->image = upload_image('upload_image', null, 'parceiro', true);
		$table->image1 = upload_image('upload_image1', null, 'parceiro2', true);
		
		$table->imagemparceiro = upload_image('imagemparceiro',$partner['imagemparceiro'],'categoria');
	 
		$flag = $table->insert(array(
			'username', 'user_id', 'city_id', 'title', 'group_id',
			'bank_name', 'bank_user', 'bank_no', 'create_time',
			'location', 'other', 'homepage', 'contact', 'mobile', 'phone',
			'password', 'address', 'open', 'display',
			'image', 'image1', 'image2', 'longlat','chavesms',  'bairro', 'cep', 'estado', 'cidade','numero','descricao','tipo','bannerparceiro','imagemparceiro','imagemnavegacao'
		));
		
		$body = "Prezado ".utf8_decode($table->title)." <br />
				 O seu cadastro como parceiro foi realizado com sucesso! <br />
				 <b>usuário:</b> {$table->contact} <br />
				 <b>senha: </b>{$table->senha} <br /><br />
				 Para estar acessando a área do parceiro, clique no link abaixo:
				 <a href='$ROOTPATH/lojista/login.php'>Área do Parceiro</a><br /><br /><br />
				 Atenciosamente<br />
				 Equipe ".$INI["system"]["sitename"];
		
		if(enviar( $table->contact,$INI["system"]["sitename"]." - Cadastro de parceiro realizado ", utf8_encode($body )))
		{
			$enviou =  "E-mail enviado com sucesso para o parceiro!";
			
		}
		else
		{
			$enviou =  "Erro ao enviar e-mail para o parceiro!";
			
		}
		
		if($flag){
			Session::Set('notice', 'Parceiro cadastrado com sucesso.');
			redirect( WEB_ROOT . "/vipmin/parceiro/index.php");
		}
		else{
			Session::Set('notice', utf8_encode('Erro na alteração dos dados'));
			redirect( WEB_ROOT . "/vipmin/parceiro/index.php");
		}
	
	} 
}

else  { // edicao
 
	if(!is_post()){
		include template('manage_partner_edit');
	}
	else{
		$table = new Table('partner', $_POST);
		$table->SetStrip('location', 'other');
		$table->group_id = abs(intval($table->group_id));
		$table->city_id = abs(intval($table->city_id));
		$table->open = (strtoupper($table->open)=='Y') ? 'Y' : 'N';
		$table->display = (strtoupper($table->display)=='Y') ? 'Y' : 'N';
		$table->image = upload_image('upload_image', $partner['image'], 'parceiro', true);  
		$table->image1 = upload_image('upload_image1', $partner['image1'], 'parceiro2', true);  
	 
		if($table->password ){
			$table->password 	= ZPartner::GenPassword($table->password);
		 
			$up_array = array(
					'username', 'title', 'bank_name', 'bank_user', 'bank_no',
					'location', 'other', 'homepage', 'contact', 'mobile', 'phone',
					'address', 'group_id', 'open', 'city_id', 'display',
					'image', 'image1', 'image2', 'longlat','chavesms',  'bairro', 'cep', 'estado', 'cidade','numero','descricao','password'
					);
		}
		else{
				$up_array = array(
					'username', 'title', 'bank_name', 'bank_user', 'bank_no',
					'location', 'other', 'homepage', 'contact', 'mobile', 'phone',
					'address', 'group_id', 'open', 'city_id', 'display',
					'image', 'image1', 'image2', 'longlat','chavesms',  'bairro', 'cep', 'estado', 'cidade','numero','descricao','tipo','bannerparceiro','imagemparceiro','imagemnavegacao'
					);
		}

		if($_FILES['imagemparceiro']['name'] != ""){
			$table->imagemparceiro = upload_image('imagemparceiro',$partner['imagemparceiro'],'categoria');
		}
		$flag = $table->update( $up_array );
		
		if ( $flag) {
			Session::Set('notice', 'Dados do parceiro alterados com sucesso');
			redirect( WEB_ROOT . "/vipmin/parceiro/index.php");
		}
		else{
			Session::Set('notice', 'Erro na alteração dos dados');
			redirect( WEB_ROOT . "/vipmin/parceiro/index.php");
		}
	} 
}