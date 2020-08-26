<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_anunciante();

$sql = "ALTER TABLE `info` ADD `logo` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `observacoes` ;";
$rs = mysql_query($sql);

/* Se flag igual a 0, a action é de insert, se flag igual 1, a action é de update. */
$flag = 0;

if($_SESSION['user_id']) {

	/* Verifica a ID do usuário e recupera as informações caso exista. */
	$id_vendedor = $_SESSION['user_id'];
	$sql = "select * from info where id_vendedor = " . $id_vendedor;
	$rs = mysql_query($sql);
	$num = mysql_num_rows($rs);
	
	/* Caso as informações sejam encontradas, então a flag recebe o valor 1 para edição. */
	if($num >= 1) {
		$info = mysql_fetch_assoc($rs);
		$flag = 1;
	}
}

if ($_POST) {
	
	$pagseguro = strip_tags($_POST["pagseguro"]);
	$dados_bancario = strip_tags($_POST["dados_bancarios"]);
	$observacoes = strip_tags($_POST["observacoes"]);
	
	if(!(empty($_POST['login']))){	
		$sql = "update user set login = '" . strip_tags($_POST['login']) . "' where id = " . $login_user_id;
		mysql_query($sql);		
	}
		
	/* Caso um novo banner tenha sido enviado, a mesma é atualizado. Caso contrário, o valor permanece o mesmo. */
	if(isset($_FILES["banner"]) and !(empty($_FILES["banner"]["tmp_name"]))) {
		$banner = upload_image('banner', $info["banner"], 'bannervendedor');
	} else if(isset($_FILES["banner"]) and empty($_FILES["banner"]["tmp_name"])) {
		$banner = $info['banner'];
	}
	
	/* Caso uma nova logo tenha sido enviada, a mesma é atualizada. Caso contrário, o valor permanece o mesmo. */
	if(isset($_FILES["logo"]) and !(empty($_FILES["logo"]["tmp_name"]))) {
		$logo = upload_image('logo', $info['logo'], 'logovendedor');
	} else if(isset($_FILES["logo"]) and empty($_FILES["logo"]["tmp_name"])) {
		$logo = $info['logo'];
	}
	
	//exit;

	/* Verifica se a ação é de inclusão ou de edição. */
	if($_POST["action"] == "editar") {
		
		$sql = "update info set id_vendedor = $id_vendedor, pagseguro = '$pagseguro', dados_bancario = '$dados_bancario', observacoes = '$observacoes', logo = '$logo', banner = '$banner' where id_vendedor = $id_vendedor";
		$rs = mysql_query($sql);				
	} else {
		
		$sql = "insert into info(id_vendedor, pagseguro, dados_bancario, observacoes, logo, banner) values('$id_vendedor', '$pagseguro', '$dados_bancario', '$observacoes', '$logo', '$banner')";
		$rs = mysql_query($sql);
	}
	
	/* Retorna o resultado de acordo com o sucesso ou falha da query. */
	if(mysql_affected_rows() >= 1 || empty(mysql_error())) {
		Session::Set('notice', 'Informações atualizadas com sucesso!');
		redirect( WEB_ROOT . '/adminanunciante/system/index.php');
	} else {
		Session::Set('notice', 'Erro ao atualizar informações!');
		redirect( WEB_ROOT . '/adminanunciante/system/index.php');		
	}
}

include template('manage_system_anunciante_index');