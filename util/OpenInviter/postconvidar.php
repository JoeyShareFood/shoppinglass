 <?php  
   
set_time_limit(0);

require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
?>

<img style="margin-left:64px;" src="<?=$ROOTPATH?>/skin/padrao/images/redeshor.jpg">
<br> <br>
 <?=utf8_encode("<span style='font-size:12px;color:#303030'> Marque o contatos que você gostaria de convidar para se cadastrar em nosso site.<br>
Para cada cadastro bem sucedido, você irá ganhar créditos para comprar nossas excelentes ofertas !</span>")?>  
<br> <br>

<a   href="javascript:voltaimportarcontatos();" class="link-1"><em><b>voltar</b></em></a> 

<input type="button" style="margin-left:10px;width:97px;font-size:10px;color:#303030;padding:16px 8px 18px 5px;" value="marcar todos"  onclick="jQuery('input[name=emailmarcado]').attr('checked', true);"  > 
<input type="button" style="margin-left:10px;width:97px;font-size:10px;color:#303030;padding:16px 8px 18px 5px;" value="desmarcar todos" onclick="jQuery('input[name=emailmarcado]').attr('checked', false);"   > 
<a style="margin-left:10px;"  onclick="javascript:convidar();"  class="link-1"><em><b><?=utf8_encode("Já escolhí, agora quero convidar")?></b></em></a>
  
<br> <br><br>
 

 <div id="loadingcontato">
 <div id="txt" style="font-size:11px;color:#303030;">	
<?php

$username = $_POST['username'];
$senha 	= $_POST['senha'];
require('openinviter.php'); //importa a classe
$inviter = new OpenInviter(); //instancia a classe

$inviter->startPlugin('gmail'); //informa o serviço a qual irá se conectar
$inviter->login($username,$senha); //Informa usuário e senha
 
$contatos = $inviter->getMyContacts(); //pega os contatos 
if($contatos){ $achou = true; ?>
	 <img  src="<?=$ROOTPATH?>/skin/padrao/images/iconegmail.jpg"> <br><br>
<? }
foreach ($contatos as $email => $nome)
{
	
	echo   "<input class='cinput' style='width:20px;' id='mail' value='".$email."' type='checkbox' name='emailmarcado'>".  $nome     ." ( ". $email ." )<br>";
	
     if( $INI['option']['convidados_newsletter'] == "Y"){ 

		 //ZSubscribe::Create($email, abs(intval(0)),$username);
		
		$dominio = explode("@",$email);
		$dominio = $dominio[1];
		
		// $sql = "INSERT INTO `email_list_subscribers` ( `listid`, `emailaddress`, `domainname`, `format`, `confirmed`, `confirmcode`, `requestdate`, `requestip`, `confirmdate`, `confirmip`, `subscribedate`, `bounced`, `unsubscribed`, `unsubscribeconfirmed`, `formid`) VALUES ( 2, '".$email."', '".$dominio."', 'h', '1', '82cca631f30c3a42f7366e5ceeb38eee', '', '', '', '', '', 0, 0, '0', 0);";
		//$rs = @mysql_query($sql); 
	}
}


/*
$inviter->startPlugin('linkedin'); //informa o serviço a qual irá se conectar
$inviter->login($username,$senha); //Informa usuário e senha
 
$contatos = $inviter->getMyContacts(); //pega os contatos 
if($contatos){ $achou = true; ?>
	 <img  src="<?=$ROOTPATH?>/skin/padrao/images/iconelinkedin.jpg" > <br><br>
<? }
foreach ($contatos as $email => $nome)
{
	
	echo   "<input class='cinput' style='width:20px;' id='mail' value='".$email."' type='checkbox' name='emailmarcado'>". utf8_decode( $nome )   ." ( ". $email ." )<br>";
	
	   if( $INI['option']['convidados_newsletter'] == "Y"){ 
		   
			 //ZSubscribe::Create($email, abs(intval(0)),$username);
			
			$dominio = explode("@",$email);
			$dominio = $dominio[1];
			
			// $sql = "INSERT INTO `email_list_subscribers` ( `listid`, `emailaddress`, `domainname`, `format`, `confirmed`, `confirmcode`, `requestdate`, `requestip`, `confirmdate`, `confirmip`, `subscribedate`, `bounced`, `unsubscribed`, `unsubscribeconfirmed`, `formid`) VALUES ( 2, '".$email."', '".$dominio."', 'h', '1', '82cca631f30c3a42f7366e5ceeb38eee', '', '', '', '', '', 0, 0, '0', 0);";
			//$rs = @mysql_query($sql); 
	   }
	
}

*/

$inviter->startPlugin('hotmail'); //informa o serviço a qual irá se conectar
$inviter->login($username,$senha); //Informa usuário e senha
 
$contatos = $inviter->getMyContacts(); //pega os contatos 
 
if($contatos){$achou = true;?>
	 <img src="<?=$ROOTPATH?>/skin/padrao/images/iconehotmail.jpg"><br><br>
<? }
foreach ($contatos as $email => $nome)
{
	echo   "<input class='cinput' style='width:20px;' id='mail' value='".$email."' type='checkbox' name='emailmarcado'>". utf8_decode( $nome )   ." ( ". $email ." )<br>";
	
	  if( $INI['option']['convidados_newsletter'] == "Y"){ 
		 
      //ZSubscribe::Create($email, abs(intval(0)),$username);
		
		$dominio = explode("@",$email);
		$dominio = $dominio[1];
		
		// $sql = "INSERT INTO `email_list_subscribers` ( `listid`, `emailaddress`, `domainname`, `format`, `confirmed`, `confirmcode`, `requestdate`, `requestip`, `confirmdate`, `confirmip`, `subscribedate`, `bounced`, `unsubscribed`, `unsubscribeconfirmed`, `formid`) VALUES ( 2, '".$email."', '".$dominio."', 'h', '1', '82cca631f30c3a42f7366e5ceeb38eee', '', '', '', '', '', 0, 0, '0', 0);";
		//$rs = @mysql_query($sql); 
	  }
	
}


$inviter->startPlugin('msn'); //informa o serviço a qual irá se conectar
$inviter->login($username,$senha); //Informa usuário e senha
 
$contatos = $inviter->getMyContacts(); //pega os contatos 
if($contatos){$achou = true;?>
	 <img src="<?=$ROOTPATH?>/skin/padrao/images/iconehotmail.jpg"><br><br>
<? }
foreach ($contatos as $email => $nome)
{
	echo   "<input class='cinput' style='width:20px;' id='mail' value='".$email."' type='checkbox' name='emailmarcado'>". utf8_decode( $nome )   ." ( ". $email ." )<br>";
	
	  if( $INI['option']['convidados_newsletter'] == "Y"){ 
		 
      //ZSubscribe::Create($email, abs(intval(0)),$username);
		
		$dominio = explode("@",$email);
		$dominio = $dominio[1];
		
		//$sql = "INSERT INTO `email_list_subscribers` ( `listid`, `emailaddress`, `domainname`, `format`, `confirmed`, `confirmcode`, `requestdate`, `requestip`, `confirmdate`, `confirmip`, `subscribedate`, `bounced`, `unsubscribed`, `unsubscribeconfirmed`, `formid`) VALUES ( 2, '".$email."', '".$dominio."', 'h', '1', '82cca631f30c3a42f7366e5ceeb38eee', '', '', '', '', '', 0, 0, '0', 0);";
		//$rs = @mysql_query($sql); 
	  }
	
}


/*
$inviter->startPlugin('terra'); //informa o serviço a qual irá se conectar
$inviter->login($username,$senha); //Informa usuário e senha
 
$contatos = $inviter->getMyContacts(); //pega os contatos 
if($contatos){$achou = true;?>
	 <img src="<?=$ROOTPATH?>/skin/padrao/images/iconeterra.jpg"><br><br>
<? }
foreach ($contatos as $email => $nome)
{
	echo   "<input class='cinput' style='width:20px;' id='mail' value='".$email."' type='checkbox' name='emailmarcado'>". utf8_decode( $nome )   ." ( ". $email ." )<br>";
	
	  if( $INI['option']['convidados_newsletter'] == "Y"){ 
		 
      //ZSubscribe::Create($email, abs(intval(0)),$username);
		
		$dominio = explode("@",$email);
		$dominio = $dominio[1];
		
		$sql = "INSERT INTO `email_list_subscribers` ( `listid`, `emailaddress`, `domainname`, `format`, `confirmed`, `confirmcode`, `requestdate`, `requestip`, `confirmdate`, `confirmip`, `subscribedate`, `bounced`, `unsubscribed`, `unsubscribeconfirmed`, `formid`) VALUES ( 2, '".$email."', '".$dominio."', 'h', '1', '82cca631f30c3a42f7366e5ceeb38eee', '', '', '', '', '', 0, 0, '0', 0);";
		$rs = @mysql_query($sql); 
	  }
	
}


$inviter->startPlugin('facebook'); //informa o serviço a qual irá se conectar
$inviter->login($username,$senha); //Informa usuário e senha
 
$contatosface = $inviter->getMyContacts(); //pega os contatos 
if($contatosface){ $achou = true;?>
	<br> <img src="<?=$ROOTPATH?>/skin/padrao/images/iconefacebook.jpg"> <br><br>
<? }
 
foreach ($contatosface as $email => $nome)
{
	echo   "<input class='cinput' style='width:20px;' value='".$email."' type='checkbox' id='face' name='emailmarcado'>". utf8_decode( $nome )   ."<br>";
	 
	
}
 
 
 
$inviter->startPlugin('twitter'); //informa o serviço a qual irá se conectar
$inviter->login($username,$senha); //Informa usuário e senha
 
$contatos = $inviter->getMyContacts(); //pega os contatos 

if($contatos){ $achou = true;?>
	 <img  src="<?=$ROOTPATH?>/skin/padrao/images/iconetwitter.jpg"> <br><br>
<? }
foreach ($contatos as $email => $nome)
{
	echo   "<input class='cinput' style='width:20px;' value='".utf8_decode($nome)."' id='twitter' type='checkbox' name='emailmarcado'>". utf8_decode( $nome )   ." <br>";
	
	  if( $INI['option']['convidados_newsletter'] == "Y"){ 
		 
       //ZSubscribe::Create($email, abs(intval(0)),$username);
		
		$dominio = explode("@",$email);
		$dominio = $dominio[1];
		
		// $sql = "INSERT INTO `email_list_subscribers` ( `listid`, `emailaddress`, `domainname`, `format`, `confirmed`, `confirmcode`, `requestdate`, `requestip`, `confirmdate`, `confirmip`, `subscribedate`, `bounced`, `unsubscribed`, `unsubscribeconfirmed`, `formid`) VALUES ( 2, '".$email."', '".$dominio."', 'h', '1', '82cca631f30c3a42f7366e5ceeb38eee', '', '', '', '', '', 0, 0, '0', 0);";
		//$rs = @mysql_query($sql); 
	  }
	
	
} 
 
$inviter->startPlugin('orkut'); //informa o serviço a qual irá se conectar
$inviter->login($username,$senha); //Informa usuário e senha
$contatos = $inviter->getMyContacts(); //pega os contatos 
 

if($contatos){ $achou = true;?>
	<br> <img  src="<?=$ROOTPATH?>/skin/padrao/images/iconeorkut.jpg"> <br><br>
<? }
 
foreach ($contatos as $email => $nome)
{
	echo   "<input class='cinput' id='orkut' style='width:20px;' value='".$email."' type='checkbox' name='emailmarcado'>". utf8_decode( $nome )   ."<br>";
	 
}
 */
/*
$inviter->startPlugin('youtube'); //informa o serviço a qual irá se conectar
$inviter->login($username,$senha); //Informa usuário e senha
 
$contatos = $inviter->getMyContacts(); //pega os contatos 
if($contatos){$achou = true;?>
	 <img style="margin-left:120px;" src="<?=$ROOTPATH?>/skin/padrao/images/iconegmail.jpg"> <br><br>
<? }
foreach ($contatos as $email => $nome)
{
	echo   "<input class='cinput' style='width:0px;' value='".$email."' type='checkbox' name='emailmarcado'>". utf8_decode( $nome )   ." ( ". $email ." )<br>";
	//ZSubscribe::Create($email, abs(intval(0)));
}

*/
/*
$inviter->startPlugin('yahoo'); //informa o serviço a qual irá se conectar
$inviter->login($username,$senha); //Informa usuário e senha
 
$contatos = $inviter->getMyContacts(); //pega os contatos 
if($contatos){ $achou = true;?>
	<br> <img  src="<?=$ROOTPATH?>/skin/padrao/images/iconeyahoo.jpg"> <br><br>
<? }
foreach ($contatos as $email => $nome)
{
	echo   "<input class='cinput' style='width:20px;' id='mail' value='".$email."' type='checkbox' name='emailmarcado'>". utf8_decode( $nome )   ." ( ". $email ." )<br>";
	
	  if( $INI['option']['convidados_newsletter'] == "Y"){ 
		 
         //ZSubscribe::Create($email, abs(intval(0)),$username);
		
		$dominio = explode("@",$email);
		$dominio = $dominio[1];
		
		//$sql = "INSERT INTO `email_list_subscribers` ( `listid`, `emailaddress`, `domainname`, `format`, `confirmed`, `confirmcode`, `requestdate`, `requestip`, `confirmdate`, `confirmip`, `subscribedate`, `bounced`, `unsubscribed`, `unsubscribeconfirmed`, `formid`) VALUES ( 2, '".$email."', '".$dominio."', 'h', '1', '82cca631f30c3a42f7366e5ceeb38eee', '', '', '', '', '', 0, 0, '0', 0);";
		//$rs = @mysql_query($sql); 
	  }
	
}
*/
 
$inviter->logout();

if(!$achou){
	echo utf8_encode( "<p style=font-size: 15px;font-weight: normal;color:#272727;padding-top:10px><b>Usuário ou senha inválidos, por favor, clique no botão voltar para corrigir os campos.</b></p>");
}
?> 
</div>
<script>

function voltaimportarcontatos(){
	   
		 jQuery.ajax({
			   type: "POST",
			   cache: false,
			   async: false,
			   url: URLWEB+"/util/OpenInviter/convidar.php",
			   data: "",
			   success: function(msg){
					
				   jQuery("#conteudo").html(msg);
				  
		   }
		});
}


function convidar(){
	     
		 var files = ''; 
		 var usersfacebook  = ''; 
		 var usersorkut  = ''; 
		 var userstwitter  = ''; 
		 var contadoremails  = 0; 
		 
		jQuery(".cinput:checked").each(function(){ 
			if(this.checked) { 
				if(this.id=="mail"){
					files = files  + this.value+ ',';
					contadoremails = contadoremails + 1;
				}
				if(this.id=="face"){
					usersfacebook = usersfacebook  + this.value + ',';
				}
				if(this.id=="orkut"){
					usersorkut = usersorkut  + this.value + ',';
				}
				if(this.id=="twitter"){
					userstwitter = userstwitter  + this.value + ',';
				}
				 
			}
		}); 
		if(contadoremails > <?=$LIMITE_EMAILS_IMPORTACAO?>){
			passando = contadoremails -  <?=$LIMITE_EMAILS_IMPORTACAO?>;
			
			alert('Notamos que <?= utf8_encode("você")?> tem muitos contatos de emails, desmarque '+passando+' contato(s). <?= utf8_encode("Por vêz, você só pode enviar para  ".$LIMITE_EMAILS_IMPORTACAO."  contato(s).")?>');
			return;
		}
		 if(files=="" & usersfacebook == "" & usersorkut=="" & userstwitter =="" ){
			alert('<?= utf8_encode("Hum !!! Acho que você esqueceu de marcar os contatos. Marque pelo menos 1 ")?>')
			return;
		 }
		  
	     document.getElementById("conteudo").innerHTML="  <br><br><img style='margin-left:100px;' src='<?=$ROOTPATH?>/skin/padrao/images/redes-sociais.jpg'> <br><br><span style='margin-left:50px;'><br><img style='margin-left:180px;margin-top:20px;' src="+URLWEB+"/skin/padrao/images/ajax-loader.gif><br>Este processo pode demorar alguns minutos.  Por favor, aguarde...</span><br><br>";
		 jQuery.ajax({
			   type: "POST",
			   cache: false,
			   async: false,
			   url: URLWEB+"/util/OpenInviter/convidando.php",
			   data: "username=<?=$username?>&usersfacebook="+usersfacebook+"&userstwitter="+userstwitter+"&usersorkut="+usersorkut+"&emails="+files+"&pw=<?=$senha?>",
			   success: function(msg){
					
				   jQuery("#conteudo").html(msg);
				  
		   }
		});
}
 
</script>