<?php

require_once(dirname(dirname(__FILE__)) . '/app.php');

 
$arq 		= trim($_REQUEST['arq']); 
 

$file = WWW_ROOT."/media/slideshowbanners/thumbs/".$arq;
$file_or = WWW_ROOT."/media/slideshowbanners/".$arq;
 
if(file_exists($file_or)){
	if(!unlink($file_or)){
		echo "Não foi possível apagar fisicamente a foto maior";	
	}
}
else{
	echo "Arquivo $file inexistente";
}	

if(file_exists($file)){
	if(!unlink($file)){
		echo "Não foi possível apagar fisicamente a foto thumb";	
	}
}
else{
	echo "Arquivo $file inexistente";
}
 
?>