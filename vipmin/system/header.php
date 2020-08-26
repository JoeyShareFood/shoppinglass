 
<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
 
need_manager();
need_auth('design');

$system = Table::Fetch('system', 1);

if ($_POST) {
	need_manager(true);
	unset($_POST['commit']);
 
	$INI = Config::MergeINI($INI, $_POST);
	$INI = ZSystem::GetUnsetINI($INI);
	save_config();

	$value = Utility::ExtraEncode($INI);
	$table = new Table('system', array('value'=>$value));
	if ( $system ) $table->SetPK('id', 1);
	$flag = $table->update(array( 'value'));
	
	if($_POST[header][statusimagemheader]=='N' and $_REQUEST['acao'] !="up"){
		// Session::Set('notice', 'Apesar de ter uma imagem selecionada, você configurou para NÃO usar imagem no cabeçalho.');
		 Session::Set('notice', 'Imagem do cabeçalho desativada com sucesso');
	}
	else{
		 Session::Set('notice', 'O seu site está usando imagem agora. Vá para a área pública e aperte CTRL+F5');
	}
    redirect( WEB_ROOT . '/vipmin/system/cores.php');
}

include template('manage_system_header');



