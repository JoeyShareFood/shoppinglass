<?php  

session_start();

set_time_limit(0);

require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
 
if(!$login_user_id){
	$login_user_id = "";
}
 
$senha 			= $_REQUEST["pw"];
$username 		= $_REQUEST["username"];
 
$emails 		= $_REQUEST["emails"];
$usersfacebook 	= $_REQUEST["usersfacebook"];
$usersorkut 	= $_REQUEST["usersorkut"];
$userstwitter 	= $_REQUEST["userstwitter"];
 
$assuntoredes 	= utf8_encode("Voc&ecirc; recebeu um convite para entrar no ".$INI['system']['sitename']);
  
$parametros = array( 'origem'=>'redes','realname' => $login_user['realname'],'login_user_email' =>$login_user['email'],'login_user_id' =>$login_user_id);
$request_params = array(
	'http' => array(
		'method'  => 'POST',
		'header'  => implode("\r\n", array(
			'Content-Type: application/x-www-form-urlencoded',
			'Content-Length: ' . strlen(http_build_query($parametros)),
		)),
		'content' => http_build_query($parametros),
	)
);

$request  = stream_context_create($request_params);
$mensagememail = file_get_contents($INI["system"]["wwwprefix"]."/templates/indicacao_amigo.php", false, $request);
 
$mensagememail = utf8_encode($mensagememail ); 
	
require('openinviter.php'); //importa a classe
$inviter = new OpenInviter(); //instancia a classe
 
 if( $usersfacebook != ""){

	 $request_params = array(
		'http' => array(
			'method'  => 'POST',
			'header'  => implode("\r\n", array(
				'Content-Type: application/x-www-form-urlencoded',
				'Content-Length: ' . strlen(http_build_query($parametros)),
			)),
			'content' => http_build_query($parametros),
		)
	);

	$request  = stream_context_create($request_params);
	$mensagemredes = file_get_contents($INI["system"]["wwwprefix"]."/templates/convite_amigos_redessocias.php", false, $request);
  
	$inviter->startPlugin('facebook'); //informa o serviço a qual irá se conectar
	$inviter->login($username,$senha); //Informa usuário e senha
	
	$usersfacebook = substr($usersfacebook, 0, -1);
	$usersfacebook = explode(",",$usersfacebook);
	 
	$message['subject'] =  $assuntoredes;
	$message['body'] 	=   $mensagemredes;
	
	$inviter->sendMessage($inviter->userId,$message,$usersfacebook);
	//$mensagem =  "<h2>Mensagens </h2><br>";
	//$mensagem .=  "<h3>Usuários do facebook irão receber as mensagens em sua caixa postal. Obrigado !</h3>";
    $inviter->logout();
 }
  
  if( $usersorkut != ""){

    
 
	$inviter->startPlugin('orkut'); //informa o serviço a qual irá se conectar
	$inviter->login($username,$senha); //Informa usuário e senha
	
	$usersorkut = substr($usersorkut, 0, -1);
	$usersorkut = explode(",",$usersorkut);
	 
	$message['subject'] =  $assuntoredes;
	$message['body'] =  $mensagemredes;
	 
	$inviter->sendMessage($inviter->userId,$message,$usersorkut);
	//$mensagem =  "<h2>Scraps enviados</h2><br>";
	//$mensagem .=  "<h3>Usuários do Orkut irão receber as mensagens como scraps. Obrigado !</h3>";
    $inviter->logout();
 } 

 if( $userstwitter != ""){

 
	$inviter->startPlugin('twitter'); //informa o serviço a qual irá se conectar
	$inviter->login($username,$senha); //Informa usuário e senha
	
	$userstwitter = substr($userstwitter, 0, -1);
	$userstwitter = explode(",",$userstwitter);
	 
	$message['subject'] =  $assuntoredes;
	$message['body'] =  $mensagemredes;
 
	$inviter->sendMessage($inviter->userId,$message,$userstwitter);
	//$mensagem =  "<h2>Scraps enviados</h2><br>";
	//$mensagem .=  "<h3>Usuários do Orkut irão receber as mensagens como scraps. Obrigado !</h3>";
    $inviter->logout();
 }
 
 
if($emails != ""){
	  
		$emails = substr($emails, 0, -1);
		   
		$arr =  explode(",",$emails);
		$cont=0;
		for($i=0;$i<=count($arr);$i++){
		
			$cont++;
			
			if(!isset($arr[$i])){
				continue;
			}
			 
			 if(enviar($arr[$i],"Você foi convidado para participar do site ".$INI['system']['sitename'],$mensagememail)){
				$enviado =  true;
				sleep($INTERVALO_ENVIO_EMAILS_IMPORTACAO);
			 } 
	  
		}
        
}

if(!$mensagemuser){
	$mensagem .=  "<br><h2 style='font-size:1.307em;margin-left:47px;'>Seus contatos receberam o convite com sucesso ! </h2>";
}
echo "<br>". utf8_encode( $mensagem )  ;
 	
?>

<br>

<a  style="margin-left:190px;" href="javascript:voltaimportarcontatos();" class="link-1"><em><b>Quero convidar mais</b></em></a>

<br><br> <br><br>
<img style="margin-left:169px;" src="<?=$ROOTPATH?>/skin/padrao/images/importacaocontatos.png">
 
 