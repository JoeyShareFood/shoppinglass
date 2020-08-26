<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">

<?php require_once("head_html.php"); ?>
  
  
<?php
 $from = $INI['mail']['from'];	
 $site = $INI['system']['sitename'];	
?>

<?php if ($_REQUEST['pg']){ ?>
	<script>
	J(document).ready(function(){
		J.colorbox({html:"<div style='text-align:center; heigth:300px;margin-top:3px;'><img width='300' src='"+URLWEB+"/include/logo/logo.png'></div><br><span style='margin-left:26px;font-size:13px;color:#303030'>O seu pagamento está sendo processado. Obrigado !</span>"});
    });
    </script>
    
<? }  
 
if(($_REQUEST['acao']=="needlogin" or $_REQUEST['acao']=="cadastro") and !$login_user_id){?>
	
	<script>
	J(document).ready(function(){
		J.colorbox({
			href:"<?=$ROOTPATH?>/app/design/padrao/autentica.php"
		});
	});
	</script>

<? }
else{
/*
	if( $INI['option']['popup_ativo'] == "Y"){
	
		$urlpop =  $ROOTPATH."/app/design/padrao/autentica.php";
		if( $INI['option']['tipopopup'] == "news"){ 
			$urlpop =  $ROOTPATH."/app/design/padrao/cadastra_email_home.php";
		}
		if(!$login_user_id){ 
			if(!isset($_COOKIE["pgcadastraemail"])){ 
				 if( $INI['option']['email_home_cookie_time'] ==""){    
					setcookie("pgcadastraemail","1", time()+60*12,"/");
				}else{
					$email_home_cookie_time =  $INI['option']['email_home_cookie_time'];
					setcookie("pgcadastraemail","1", time()+ $email_home_cookie_time,"/");
				} ?>
				
			<script>
			J(document).ready(function(){
				J.colorbox({
				<? if($INI['option']['tipopopup'] !="news"){?>
					<?if($navegador=="ie"){?>
						href:"<?=$urlpop?>",width:"950px",height:"600px"
						<?} else {?>
							href:"<?=$urlpop?>"
						<? } ?> 
					<?} else {?>
						href:"<?=$urlpop?>" 
					<? } ?>
				});
			});
			</script>
			
			<? }
		 }
	}
	*/
}
?>
