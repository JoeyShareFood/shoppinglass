<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('admin');
 
$system = Table::Fetch('system', 1);
 
 
if ($_POST) {
 
 
	if(!empty($_POST['totalbanners'])){
	
		$sql = "delete from linkbanners";
		mysql_query($sql);
			 
		for($i=0;$i<=$_POST['totalbanners'];$i++){
			$nomefile 	= $_POST['nomefile_'.$i];
			$nomefile = str_replace("." , "_" , $nomefile);
			$urlfile	=	$_POST[$nomefile];
			$nomefile = str_replace("_" , "." , $nomefile);
			 
			 if($nomefile==""){
				continue;
			 }
			$sql = "insert into linkbanners (file,link) values ('$nomefile','$urlfile')";
			$rs = mysql_query($sql);
			if(!$rs){
				echo "=====".mysql_error();
				exit;
			}
		
		}
	}
	// print_r($_POST); 
	
	 /* adaptacao do vipcart - funcionando
	if(!empty($_POST['totalbanners'])){ 
		$sql = "delete from linkbanners";
		mysql_query($sql);
			
		for($i=1;$i<=$_POST['totalbanners'];$i++){
			$nomefile 	= $_POST['nomefile_'.$i];  
			$nomefile = str_replace(" " , "_" , $nomefile);
			$nomefile = str_replace(".jpg" , "_jpg" , $nomefile);
			$nomefile = str_replace(".png" , "_png" , $nomefile);
			$urlfile	=	$_POST[$nomefile];
			$nomefile = str_replace("_png" , ".png" , $nomefile);
			$nomefile = str_replace("_jpg" , ".jpg" , $nomefile);
			$nomefile = str_replace("_" , " " , $nomefile); 
			$sql = "insert into linkbanners (file,link) values ('$nomefile','$urlfile')";
			mysql_query($sql);
		}
	}
	*/
	 
	unset($_POST['commit']);
	$INI = Config::MergeINI($INI, $_POST);
	$INI = ZSystem::GetUnsetINI($INI);
	save_config();

	$value = Utility::ExtraEncode($INI);
	$table = new Table('system', array('value'=>$value));
	if ( $system ) $table->SetPK('id', 1);
	$flag = $table->update(array( 'value'));
 
	Session::Set('notice', 'Informações atualizadas com sucesso!');
	redirect( WEB_ROOT . '/vipmin/system/banners.php');
}
 

include template('manage_system_banners');


