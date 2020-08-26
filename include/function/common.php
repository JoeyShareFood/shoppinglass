<?php
    
import('configure');
import('current');
import('utility');
import('mailer');
import('sms'); 
import('upgrade');
import('uc');
import('cron');

function getOfertasPacote($id){ 
  
	$sql	=	"select id,title,team_price,market_price from team where idpacote='".$id."' and begin_time < '".time()."' and end_time > '".time()."' and now_number < max_number ";
	$rs		=	mysql_query($sql);
  
	if(mysql_num_rows($rs) >0){
		$conteudo	 =	"<div class=\'boxmaior\'><div class=csescolha>Escolha a sua oferta</div><br/><br/>";
		while($row	= mysql_fetch_array($rs)){
		 
			$idoferta		=	$row['id'];
			$title			=	utf8_decode($row['title']);
			$team_price	 	=	number_format($row['team_price'],2, ',', '.');
			$market_price 	=	number_format($row['market_price'],2, ',', '.');
			$economia 		=	number_format($row['market_price'] - $row['team_price'],2, ',', '.');
			$porcentagem	= 	round(100 - $row['team_price']/$row['market_price']*100,0);
	  
			 if(!$style){
				$style=" style=background:#F0F4F4"; 
			 }
			 else{
				$style=false;
			 }
			$conteudo	.=  "<table><tr $style ><td style=width:650px;>";
			$conteudo	.= 	"<div class=descricaooferta style=\'width: 628px;\'>".$title."</div>";
			$conteudo	.= 	"<div class=descricaooferta style=\'width: 628px;\'><b>De R$ ".$market_price ." por R$ ".$team_price.". ".$porcentagem."% de desconto. Economise R$ ".$economia ."</b></div> <br>";
			$conteudo	.=  "</td><td style=width:50px;><label for=$i><div  style=\'padding:10px;width:96px;\' class=view-deal-button><a  class=button small href=javascript:enviacart($idoferta);>Quero esta</a></div><label></td></tr></table>";

		}
		 $conteudo	.=  "</div>";
	}
	else{
		 $conteudo	.= 	"<font color=#303030 size=10> Não existem mais ofertas disponíveis para este pacote. <br>Já estão canceladas ou esgotadas.<br><br> Por favor, tente verificar a disponibilidade mais tarde. </font><br/><br/>";
	}
	
	return $conteudo;
}
function ePacote($id){ 
  
	$sql	=	"select id from team where idpacote='".$id."'  limit 1";
	$rs		=	mysql_query($sql);
  
	if(mysql_num_rows($rs) >0){
		return true;
	}
	else{
		return false;
	} 
}
function mostratopo(){ 
	global $INI, $idpagina;
	if( $INI['option']['redirecionador'] == "Y" or $idpagina or $_REQUEST['page'] or $_REQUEST['idoferta'] ){
		return true;
	}
	else{
		return false;
	} 
}

function mostrabanner(){ 
	global $INI, $idpagina;
	if( (!$_REQUEST['idoferta'] and !$_REQUEST['page']) or  $idpagina){
		return true;
	}
	else{
		return false;
	} 
}

function envia_email_confirmacao_pagamento($idpedido, $tipo=false){ 
	  
	$order 	= Table::Fetch('order', $idpedido);
	$user 	= Table::Fetch('user', $order['user_id']);
	   
	$items = mysql_query("SELECT * FROM order_team WHERE order_id = ".$idpedido);
	
	while ($item = mysql_fetch_array($items, MYSQL_ASSOC)) {
		$quantity = $item['team_qty'];
		Table::UpdateCache('team', $item['team_id'], array( 
			'now_number' => array( "`now_number` + {$quantity}", ),
		)); 
	}
	 
	$parametros = array(  'realname' => $user['realname'], 'id' => $idpedido);
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
	$mensagem = file_get_contents($INI["system"]["wwwprefix"]."/templates/confirmacao_pagamento.php", false, $request);
	
	$ret = enviar($user['email'], "Sua compra foi confirmada", $mensagem);
	
	$mensagem="";
	unset($mensagem);

	if($ret){
			return true;
	}
	else{
		return false;
	}
}

function getFrete(){  
	
		if( $team['fretegratuito'] == "1"){
			$valorfrete = "0,00";
		}
		else if( $team['valorfrete'] != "" and $team['valorfrete'] != "0,00"){
			$valorfrete = $team['valorfrete'];
		}
		else{
			$valorfrete = calculaFrete(41106,$team['ceporigem'], getCepDestino($login_user), $team['peso'], $team['altura'], $team['largura'],  $team['comprimento'], $team['team_price']);
		}

		if(empty($_SESSION['IDCARRINHO'])){
			$_SESSION['IDCARRINHO'] = rand(1000,9999);
			
			$sql = "select idcarrinho from order_enderecos where idcarrinho=".$_SESSION['IDCARRINHO'];
			$rs =  mysql_query($sql);
				
			if(mysql_num_rows($rs) == 0){ //atualiza o endereço de cobranca ou entrega
				$sql = " 
				INSERT INTO `order_enderecos` ( `idcarrinho`, `entrega_cep`, `entrega_endereco`, `entrega_numero`, `entrega_complemento`, `entrega_bairro`, `entrega_cidade`, `entrega_estado`, `entrega_telefone`, `cobranca_cep`, `cobranca_endereco`, `cobranca_numero`, `cobranca_complemento`, `cobranca_bairro`, `cobranca_cidade`, `cobranca_estado`, `cobranca_telefone`) VALUES
				(  ".$_SESSION['IDCARRINHO'].",  '".$login_user['entrega_cep']."', '".$login_user['entrega_endereco']."', '".$login_user['entrega_numero']."', '".$login_user['entrega_complemento']."', '".$login_user['entrega_bairro']."', '".$login_user['entrega_cidade']."', '".$login_user['entrega_estado']."', '".$login_user['entrega_telefone']."', '".$login_user['cobranca_cep']."', '".$login_user['cobranca_endereco']."', '".$login_user['cobranca_numero']."', '".$login_user['cobranca_complemento']."', '".$login_user['cobranca_bairro']."', '".$login_user['cobranca_cidade']."', '".$login_user['cobranca_estado']."', '".$login_user['cobranca_telefone']."');
				";
				$rs =  mysql_query($sql);
			}	
		}
}

function RemoveXSS($val) { 
   // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed 
   // this prevents some character re-spacing such as <java\0script> 
   // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs 
  // $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val); 
    
   // straight replacements, the user should never need these since they're normal characters 
   // this prevents like <IMG SRC=&#X40&#X61&#X76&#X61&#X73&#X63&#X72&#X69&#X70&#X74&#X3A &#X61&#X6C&#X65&#X72&#X74&#X28&#X27&#X58&#X53&#X53&#X27&#X29> 
   $search = 'abcdefghijklmnopqrstuvwxyz'; 
   $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
   $search .= '1234567890!@#$%^&*()'; 
   $search .= '~`";,:?+/={}[]-_|\'\\'; 
   for ($i = 0; $i < strlen($search); $i++) { 
   
      // ;? matches the ;, which is optional 
      // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars 
    
      // &#x0040 @ search for the hex values 
      $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ; 
      // &#00064 @ 0{0,7} matches '0' zero to seven times 
      $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ; 
   } 
    
   // now the only remaining whitespace attacks are \t, \n, and \r 
   $ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset','ilayer', 'layer', 'bgsound', 'title', 'base'); 
   $ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus','onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect','oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover','ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup','onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel','onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit','onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload'); 
   $ra = array_merge($ra1, $ra2); 
    
   $found = true; // keep replacing as long as the previous round replaced something 
   while ($found == true) { 
      $val_before = $val; 
      for ($i = 0; $i < sizeof($ra); $i++) { 
         $pattern = '/'; 
         for ($j = 0; $j < strlen($ra[$i]); $j++) { 
            if ($j > 0) { 
               $pattern .= '('; 
               $pattern .= '(&#[xX]0{0,8}([9ab]);)'; 
               $pattern .= '|'; 
               $pattern .= '|(&#0{0,8}([9|10|13]);)'; 
               $pattern .= ')*'; 
            } 
            $pattern .= $ra[$i][$j]; 
         } 
         $pattern .= '/i'; 
         $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag 
         $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags 
         if ($val_before == $val) { 
            // no replacements were made, so exit the loop 
            $found = false; 
         } 
      } 
   }  
   return $val; 
}

function current_teamcategory($gid='0') {
	global $city;
 
	foreach(option_hotcategory('group') AS $id=>$name) {
		$a["$id"] = $name;
	}
	$l = "/team/index.php?gid={$gid}";
	if (!$gid) $l = "/team/index.php";
	return current_link($l, $a, true);
}

function current_teamcategory_principal($gid='0') {
	global $city;
 
	foreach(option_hotcategory('group') AS $id=>$name) {
		$a["$id"] = $name;
	}
	$l = "/team/index.php?gid={$gid}";
	if (!$gid) $l = "/team/index.php";
	return current_link_principal($l, $a, true);
}

function current_teamcategory_recentes($gid='0') {
	global $city;
 
	foreach(option_hotcategory('group') AS $id=>$name) {
		$a["$id"] = $name;
	}
	$l = "/team/index.php?gid={$gid}";
	if (!$gid) $l = "/team/index.php";
	return current_link_recentes($l, $a, true);
}

function current_teamcategoryhome($gid='0') {
	global $city;
  
	foreach(option_hotcategory('group') AS $id=>$name) {
		$a["/". $city['ename']."/departamento/$id"] = $name;
	}
	 
	return current_link_home($l, $a, true);
} 

function tratacidade($nome) {

	    $var =    $nome  ;
		
		/*$var = ereg_replace("[áàâãª]","a",$var);
		$var = ereg_replace("[ÉÈÊ]","E",$var);
		$var = ereg_replace("[éèê]","e",$var);
		$var = ereg_replace("[Í]","I",$var);
		$var = ereg_replace("[ÓÒÔÕ]","O",$var);
		$var = ereg_replace("[óòôõº]","o",$var);
		$var = ereg_replace("[ÚÙÛ]","U",$var);
		$var = ereg_replace("[í]","i",$var);
		$var = ereg_replace("[úùû]","u",$var);
		$var = str_replace("Ç","C",$var);
		$var = str_replace("ç","c",$var);
		//$var = str_replace(" ","-",$var);
		$var = str_replace("_","-",$var);*/
		 
 
		return $var;

	}

function getNavegador(){
	$useragent = $_SERVER['HTTP_USER_AGENT'];
 
  if (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$useragent,$matched)) {
    $browser_version=$matched[1];
    $browser = 'IE';
  } elseif (preg_match( '|Opera/([0-9].[0-9]{1,2})|',$useragent,$matched)) {
    $browser_version=$matched[1];
    $browser = 'Opera';
  } elseif(preg_match('|Firefox/([0-9\.]+)|',$useragent,$matched)) {
    $browser_version=$matched[1];
    $browser = 'Firefox';
  } elseif(preg_match('|Chrome/([0-9\.]+)|',$useragent,$matched)) {
    $browser_version=$matched[1];
    $browser = 'Chrome';
  } elseif(preg_match('|Safari/([0-9\.]+)|',$useragent,$matched)) {
    $browser_version=$matched[1];
    $browser = 'Safari';
  } else {
    // browser not recognized!
    $browser_version = 0;
    $browser= 'other';
  }
  
  return $browser;
}	
function upload_image($input, $image=null, $type="team", $scale=false,$marcadagua=false) {
	  global $INI;
	 $img = new canvas();
	 
	$year = date("Y"); $day = date("md"); $n = time().rand(1000,9999).".jpg";
	$z = $_FILES[$input];
	if ($z && strpos($z["type"], "image")===0 && $z["error"]==0) {
		if (!$image) {
			RecursiveMkdir( IMG_ROOT . "/" . "{$type}/{$year}/{$day}" );
			$image = "{$type}/{$year}/{$day}/{$n}";
			$path = IMG_ROOT . "/" . $image;
		} else {
			RecursiveMkdir( dirname(IMG_ROOT ."/" .$image) );
			$path = IMG_ROOT . "/" .$image;
		}
		if ($type=="user") {
			Image::Convert($z["tmp_name"], $path, 48, 48, Image::MODE_CUT);
		}
	 
		else if($type=="team") {

			move_uploaded_file($z["tmp_name"], $path);   
			  
			$npath = preg_replace('#(\d+)\.(\w+)$#', "\\1_destaque.\\2", $path); 
			$img->carrega(WWW_ROOT."/media/".$image)->redimensiona( null, 279) ->grava($npath); 
				//Image::Convert($path, $npath, null, 279, Image::MODE_CUT);
			  
			$npath = preg_replace('#(\d+)\.(\w+)$#', "\\1.\\2", $path); 
			$img->carrega(WWW_ROOT."/media/".$image)->redimensiona( 600, null) ->grava($npath); 
				//Image::Convert($path, $npath, 600, null, Image::MODE_CUT);
			
			
			$npath = preg_replace('#(\d+)\.(\w+)$#', "\\1_popular.\\2", $path); 
			$img->carrega(WWW_ROOT."/media/".$image)->redimensiona( 150,150 )->grava($npath);
				//Image::Convert($path, $npath, 150, 150, Image::MODE_CUT);
			
			$npath = preg_replace('#(\d+)\.(\w+)$#', "\\1_fit.\\2", $path); 
			$img->carrega(WWW_ROOT."/media/".$image)->redimensiona( 334,null )->grava($npath);
				//Image::Convert($path, $npath, 334, null, Image::MODE_CUT);
			    
			$npath = preg_replace('#(\d+)\.(\w+)$#', "\\1_popular_mini.\\2", $path); //usado nos thumbs do slide detalhe da oferta
			$img->carrega(WWW_ROOT."/media/".$image)->redimensiona(  62,62)->grava($npath);
			
			//Image::Convert($path, $npath, 323,null, Image::MODE_CUT);
			
		
			
		}	
		else if($type=="estatica") {

			move_uploaded_file($z["tmp_name"], $path);  
			$npath = preg_replace('#(\d+)\.(\w+)$#', "\\1_".$input.".\\2", $path); 
			$img->carrega(WWW_ROOT."/media/".$image)->grava($npath);  
			
		}
		else if($type=="categoria") {

			move_uploaded_file($z["tmp_name"], $path);  
			$npath = preg_replace('#(\d+)\.(\w+)$#', "\\1_".$input.".\\2", $path); 
			$img->carrega(WWW_ROOT."/media/".$image)->grava($npath);  
			
		}
		
	 	 else if($type=="parceiro") {

			move_uploaded_file($z["tmp_name"], $path);
			$npath = preg_replace('#(\d+)\.(\w+)$#', "\\1_parceiromini.\\2", $path);
			//$img->carrega(WWW_ROOT."/media/".$image)->redimensiona( 128,null )->grava($npath);
			Image::Convert($path, $npath, 128, null, Image::MODE_CUT);
			 
			
		} 
		
		else if($type == "imagemcateghome") {
		
			move_uploaded_file($z["tmp_name"], $path);
			$npath = preg_replace('#(\d+)\.(\w+)$#', "\\1_categhome.\\2", $path); 
			$img->carrega(WWW_ROOT."/media/".$image)->redimensiona( 285,400 )->grava($npath);			
			
		}				
		else if($type == "logovendedor") {
		
			move_uploaded_file($z["tmp_name"], $path);
			$npath = preg_replace('#(\d+)\.(\w+)$#', "\\logovendedor.\\2", $path); 
			$img->carrega(WWW_ROOT."/media/".$image)->redimensiona(285,400)->grava($npath);			
			
		}  				
		else if($type == "bannervendedor") {
		
			move_uploaded_file($z["tmp_name"], $path);
			$npath = preg_replace('#(\d+)\.(\w+)$#', "\\bannervendedor.\\2", $path); 
			$img->carrega(WWW_ROOT."/media/".$image)->redimensiona(285,400)->grava($npath);			
			
		}  
	}
	return $image;
}
 function magic_gpc($string) {
	if(SYS_MAGICGPC) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = magic_gpc($val);
			}
		} else {
			$string = stripslashes($string);
		}
	}
	return $string;
}
 
function template($tFile) {

	global $INI; 
	if ( 0===strpos($tFile, 'manage') ) {
		return __template($tFile);
	}
	if ($INI['skin']['template']) {
 
		$templatedir = DIR_TEMPLATE. '/' . $INI['skin']['template'];
		$checkfile = $templatedir . '/html_header.html';
		if ( file_exists($checkfile) ) {
		 
			return __template($INI['skin']['template'].'/'.$tFile);
		}
		
	} 
	return __template($tFile);
}

function render($tFile, $vs=array()) {
    ob_start();
    foreach($GLOBALS AS $_k=>$_v) {
        ${$_k} = $_v;
    }
	foreach($vs AS $_k=>$_v) {
		${$_k} = $_v;
	}
	include template($tFile);
    return render_hook(ob_get_clean());
}

function render_hook($c) {
	global $INI;
	$c = preg_replace('#href="/#i', 'href="'.WEB_ROOT.'/', $c);
	$c = preg_replace('#src="/#i', 'src="'.WEB_ROOT.'/', $c);
	$c = preg_replace('#action="/#i', 'action="'.WEB_ROOT.'/', $c);

	 
	$page = strval($_SERVER['REQUEST_URI']);
	if($INI['skin']['theme'] && !preg_match('#/vipmin/#i',$page)) {
		$themedir = WWW_ROOT. '/media/theme/' . $INI['skin']['theme'];
		$checkfile = $themedir. '/css/index.css';
		if ( file_exists($checkfile) ) {
			$c = preg_replace('#/media/css/#', "/media/theme/{$INI['skin']['theme']}/css/", $c);
			$c = preg_replace('#/media/img/#', "/media/theme/{$INI['skin']['theme']}/img/", $c);
		}
	}
	if (strtolower(cookieget('locale','zh_cn'))=='zh_tw') {
		require_once(DIR_FUNCTION  . '/tradition.php');
		$c = str_replace(explode('|',$_charset_simple), explode('|',$_charset_tradition),$c);
	}
 
	$c = obscure_rep($c);
	return $c;
}

function output_hook($c) {
	global $INI;
	if ( 0==abs(intval($INI['system']['gzip'])))  die($c);
	$HTTP_ACCEPT_ENCODING = $_SERVER["HTTP_ACCEPT_ENCODING"];
	if( strpos($HTTP_ACCEPT_ENCODING, 'x-gzip') !== false )
		$encoding = 'x-gzip';
	else if( strpos($HTTP_ACCEPT_ENCODING,'gzip') !== false )
		$encoding = 'gzip';
	else $encoding == false;
	if (function_exists('gzencode')&&$encoding) {
		$c = gzencode($c);
		header("Content-Encoding: {$encoding}");
	}
	$length = strlen($c);
	header("Content-Length: {$length}");
	die($c);
}

$lang_properties = array();
function I($key) {
    global $lang_properties, $LC;
    if (!$lang_properties) {
        $ini = DIR_ROOT . '/i18n/' . $LC. '/properties.ini';
        $lang_properties = Config::Instance($ini);
    }
    return isset($lang_properties[$key]) ?
        $lang_properties[$key] : $key;
}

function json($data, $type='eval') {
    $type = strtolower($type);
    $allow = array('eval','alert','updater','dialog','mix', 'refresh');
    if (false==in_array($type, $allow))
        return false;
    Output::Json(array( 'data' => $data, 'type' => $type,));
}

function retira_acento ($txt){

$txt= ereg_replace("[????]","A", $txt );
$txt= ereg_replace("[?????]","a",$txt);
$txt= ereg_replace("[???]","E",$txt);
$txt= ereg_replace("[???]","e",$txt);
$txt= ereg_replace("[?]","I",$txt);
$txt= ereg_replace("[????]","O",$txt);
$txt= ereg_replace("[?????]","o",$txt);
$txt= ereg_replace("[???]","U",$txt);
$txt= ereg_replace("[?]","i",$txt);
$txt= ereg_replace("[???]","u",$txt);
$txt= str_replace("?","C",$txt);
$txt= str_replace("?","c",$txt);

return $txt;

}

function retira_acentos( $texto )
{
  $array1 = array(   "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
                     , "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç" );
  $array2 = array(   "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
                     , "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C" );
  return str_replace( $array1, $array2, $texto );
}

function redirect($url=null, $notice=null, $error=null) {
	$url = $url ? obscure_rep($url) : $_SERVER['HTTP_REFERER'];
	$url = $url ? $url : '/';
	if ($notice) Session::Set('notice', $notice);
	if ($error) Session::Set('error', $error);
    header("Location: {$url}");
    exit;
}
function write_php_file($array, $filename=null){
	$v = "<?php\r\n\$INI = ";
	$v .= var_export($array, true);
	$v .=";\r\n?>";
	return file_put_contents($filename, $v);
}

function write_ini_file($array, $filename=null){
	$ok = null;
	if ($filename) {
		$s =  ";;;;;;;;;;;;;;;;;;\r\n";
		$s .= ";; SYS_INIFILE\r\n";
		$s .= ";;;;;;;;;;;;;;;;;;\r\n";
	}
	foreach($array as $k=>$v) {
		if(is_array($v))   {
			if($k != $ok) {
				$s  .=  "\r\n[{$k}]\r\n";
				$ok = $k;
			}
			$s .= write_ini_file($v);
		}else   {
			if(trim($v) != $v || strstr($v,"["))
				$v = "\"{$v}\"";
			$s .=  "$k = \"{$v}\"\r\n";
		}
	}

	if(!$filename) return $s;
	return file_put_contents($filename, $s);
}

function save_config($type='ini') {
	return configure_save();
	global $INI; $q = ZSystem::GetSaveINI($INI);
	if ( strtoupper($type) == 'INI' ) {
		if (!is_writeable(SYS_INIFILE)) return false;
		return write_ini_file($q, SYS_INIFILE);
	}
	if ( strtoupper($type) == 'PHP' ) {
		if (!is_writeable(SYS_PHPFILE)) return false;
		return write_php_file($q, SYS_PHPFILE);
	}
	return false;
}

function save_system($ini) {
	$system = Table::Fetch('system', 1);
	$ini = ZSystem::GetUnsetINI($ini);
	$value = Utility::ExtraEncode($ini);
	$table = new Table('system', array('value'=>$value));
	if ( $system ) $table->SetPK('id', 1);
	return $table->update(array( 'value'));
}

function atualiza_qtde_visualizacao($idoferta) {
 
	$sql = "select visualizados from team where id = $idoferta";
    $rs = mysql_query($sql);	
	$linha = mysql_fetch_object($rs);
	
	if($linha->visualizados){
	  
	   $sql = "update team set visualizados = visualizados + 1 where id = $idoferta";
		mysql_query($sql); 
	}
	else{ 
		$sql = "update team set visualizados =  1 where id = $idoferta";
		mysql_query($sql);
	} 
}
function gravatrack($code,$idpedido) {
 
	global $INI,$ROOTPATH;
	$order 	= Table::Fetch('order', $idpedido);	
	$user 	= Table::Fetch('user', $order['user_id']);	
		
	$sql = "update `order` set codigorastreio = '$code' where id = $idpedido";
	$rs = mysql_query($sql); 
	
	 if(!$rs){
		echo $sql." ".mysql_error();
	}
	else{
	
		$parametros = array('id' => $idpedido,'code' => $code);
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
		grava_status_entrega("Codigo de rastreio informado ". $code, $idpedido);
		$request  = stream_context_create($request_params);
		$body = file_get_contents($ROOTPATH."/templates/codigo_rastreio_correios.php", false, $request);

		if(Util::postemailCliente($body,"Uhuu, seu produto tá chegando!",$user['email'])){
			Util::log($id. " - gravatrack - Email para o cliente enviado com sucesso ".$user['email']);  
		 }
		else{
			Util::log($id. " - gravatrack - Erro no envio do email para ".$user['email']);  
		}
		 
	} 

}
function get_num_pedido($tipo) {
	$data = date("Y-m-d H:i:s");
	
	$valorped = str_replace("","",$_REQUEST['valorpedido']);
	$valorped = str_replace(",",".",$valorped);
	
    $sql	=	"INSERT INTO `order`(datapedido,service,user_id,team_id,quantity,price,origin,tipo,city_id) values ('".$data."','".$_REQUEST['gateway']."','".$_REQUEST['idusuario']."','".$_REQUEST['idoferta']."','".$_REQUEST['quantidade']."','".$_REQUEST['valor_unitario']."','".$valorped."','".$tipo."','".$_REQUEST['city_id']."' )";
	$rs = mysql_query($sql);
	if(!$rs){
		echo $sql." ".mysql_error();
	}
	else{
		if($tipo=="promocional"){ // atualiza o contator promocional
			$sql = "update team set now_number = now_number+1 where id =".$_REQUEST['idoferta'];
			mysql_query($sql);
		}
	
		$idnovopedido = mysql_insert_id();
		if($tipo!="promocional"){
			$usuario 	= Table::Fetch('user', $_REQUEST['idusuario']);
			$nome 		= $usuario['realname'] ;
			$qtde 		= $_REQUEST['quantidade']; 
			$sql 		=  "insert into order_amigos (nome,order_id,qtde) values ('$nome',$idnovopedido,$qtde)";
			mysql_query($sql);
		}
		 
		return $idnovopedido;
	}
}

function avalia_produto($team_id,$pontuacao,$titulo,$mensagem,$user_id) { 
	$data = date("Y-m-d H:i:s");
	global $INI;
	  
    $sql	=	"INSERT INTO `avaliacao_produto`(team_id,pontuacao,titulo,mensagem,user_id,data) values (  '$team_id','$pontuacao','$titulo','$mensagem','$user_id','$data' )";
	$rs = mysql_query($sql);
	if(!$rs){
		echo $sql." ".mysql_error();
		 Util::log($id. "avalia_produto - o comentario nao foi inserido. (".$mysql_error().")"); 
	} 
	else{
		 
		 $team 	= Table::Fetch('team', $team_id);
		 $user 	= Table::Fetch('user',$user_id);
		 
		 $body = 
		"<div> O produto '".utf8_decode($team[title])."' recebeu um novo comentário.</div><br>
		Você pode apagar este comentário pela administração em <B>SISTEMA->AVALIAÇÃO DE CLIENTES</B> <br><br>
		<b> Dados do Comentário</b>

		<p>Produto: ".utf8_decode($team[title])."</p>
		<p>Título: ".utf8_decode($titulo)."</p> 
		<p>Mensagem: ".utf8_decode($mensagem)."</p> 
		<p>Nome: ".utf8_decode($user[realname])."</p> 
		<p>Email: ".$user[email]."</p> 
		<p>Pontuação: ".$pontuacao."</p> " ;
		
		$emailadmin = $INI['mail']['from'];
		
		 if(!enviar( $emailadmin,utf8_decode($INI["system"]["sitename"]). " - ".utf8_encode("Novo Comentário"),utf8_encode($body))){
			 echo "O email nao foi enviado para o administrador.";
			 Util::log($id. "avalia_produto - O email nao foi enviado para o administrador (".$emailadmin.")");  
		 }
		else{
			Util::log($id. "avalia_produto - O email enviado com sucesso para (".$emailadmin.")");  
		}		 
	}
}

function question_product($team_id, $titulo, $duvida, $user_id, $id_vendedor) { 
	$data = date("Y-m-d H:i:s");
	global $INI;
	
	/* A pergunta é passada por um filtro para evitar palavras de baixo calão. */
	$titulo = FiltroString($titulo);
	$duvida = FiltroString($duvida);
	  
    $sql	=	"INSERT INTO `questions`(id_produto, id_vendedor, id_cliente, titulo, duvida, data) values ('$team_id', '$id_vendedor', '$user_id', '$titulo', '$duvida','$data' )";
	$rs = mysql_query($sql);
	$IdQuestion = mysql_insert_id();
	
	if(!$rs){
		echo $sql." ".mysql_error();
		 Util::log($id. "questions - a dúvida sobre o produto não foi inserido. (".$mysql_error().")"); 
	} 
	else{
		
		/* Envia mensagem direto para usuário. */
		if($INI['option']['moderacao_msg'] == "N"){
		
			$sql_q = "update questions set status = 1 where id = " . $IdQuestion;
			$rs_q = mysql_query($sql_q);
			
			$team 	= Table::Fetch('team', $team_id);
			$user 	= Table::Fetch('user',$user_id);
			$vendedor 	= Table::Fetch('user',$id_vendedor);
		
			$parametros = array('idquestion' => $IdQuestion);
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
			$body = file_get_contents($INI["system"]["wwwprefix"]."/templates/question.php", false, $request);
			
			$EmailVendedor = $vendedor['email'];
			
			if(!enviar($EmailVendedor, "Você tem uma mensagem", $body)){
				echo "O email nao foi enviado para o administrador.";
				Util::log($id. "avalia_produto - O email nao foi enviado para o administrador (".$EmailVendedor.")");  
			}
			else{
				Util::log($id. "avalia_produto - O email enviado com sucesso para (".$EmailVendedor.")");  
			}
		}
		else {
			
			/* Envia email ao admin informando de nova mensagem. */
			$parametros = array('idquestion' => $IdQuestion);
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
			$body = file_get_contents($INI["system"]["wwwprefix"]."/templates/question_admin.php", false, $request);
			
			$EmailAdmin = $INI["mail"]["from"];
			
			if(!enviar($EmailAdmin,utf8_decode($INI["system"]["sitename"]). " - ".utf8_encode("Nova pergunta"), $body)){
				 echo "O email nao foi enviado para o administrador.";
				 Util::log($id. "avalia_produto - O email nao foi enviado para o administrador (".$EmailAdmin.")");  
			}
			else{
				Util::log($id. "avalia_produto - O email enviado com sucesso para (".$EmailAdmin.")");  
			}			
		}
	}
}

function qualification_order($concretion, $productId, $id_qualificado, $text, $title, $id_qualificante, $orderId, $nota) { 
	
	$data = date("Y-m-d H:i:s");
	global $INI;
	  
    /* É feito a inserção da qualificação na tabela qualification. */
	$sqlQualification = "INSERT INTO `qualification`(id_order, id_qualificado, id_qualificante, id_produto, titulo, text, concretion, nota, data) values ('$orderId', '$id_qualificado', '$id_qualificante', '$productId', '$title', '$text', '$concretion', '$nota', '$data' )";
	$rsQualification = mysql_query($sqlQualification);
	
	$order = Table::Fetch('order', $orderId);
	
	/* É verificado se a qualificação foi positiva ou negativa. */
	if($concretion == 1) {
		$concretion = "Positivo";
		
		if($order['service'] != "Combinar com vendedor") {
			$statusliberacao = utf8_encode("Qualificação positiva. <br /> Pagamento liberado pelo comprador!");
		}
		else {
			$statusliberacao = utf8_encode("Qualificação positiva.");
		}
		
		/* Caso a qualificação tenha sido positiva, o usuário que recebe a qualificação soma pontos. */
		$pts = 5;
		UpdatePoints($pts, $id_qualificado);
	} else {
		$concretion = "Negativo";
		
		if($order['service'] != "Combinar com vendedor") {
			$statusliberacao = utf8_encode("Qualificação negativa. <br /> Pagamento retido pelo site!");
		}
		else {
			$statusliberacao = utf8_encode("Qualificação negativa.");
		}
	}

	/* Neste ponto é atualizado o status da liberação do dinheiro para o vendedor. */
	$sqlOrder = "UPDATE `order` SET `statusliberacao` = '" . $statusliberacao . "' WHERE `order`.`id` = " . $orderId;
	$rsOrder = mysql_query($sqlOrder);
	
	if(!$rsQualification){
		echo $sqlQualification." ".mysql_error();
		 Util::log($id. "qualification - a qualificação sobre a negociação não foi inserida. (".$mysql_error().")"); 
	} 
	else if(!rsOrder) {
		echo $sqlOrder." ".mysql_error();
		 Util::log($id. "pay - a liberação do dinheiro pelo comprador não foi atualizada. (".$mysql_error().")"); 
	}	
	else{
		 
		 /* São buscados algumas informações, e após é enviado um email notificando o vendedor e 
			o dono do site. Cópia de email do vendedor, é enviada ao dono do site.
		*/
		 $team 	 = Table::Fetch('team', $productId);
		 $user 	 = Table::Fetch('user', $id_qualificante);
		 $seller = Table::Fetch('user', $id_qualificado);
		 
		$parametros = array('id_order' => $orderId, 'id_qualificado' => $id_qualificado, 'name' => $seller['realname']);
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
		$body = file_get_contents($INI["system"]["wwwprefix"]."/templates/qualification.php", false, $request);
		
		$emailadmin = $INI['mail']['from'];
		
		/* Os emails são enviados ao admin e vendedor. */
		enviar($emailadmin, "Opa! Você recebeu uma qualificação. - Cópia de email", $body);
		enviar($seller['email'], "Opa! Você recebeu uma qualificação.", $body);		
		
		 if($EmailFlag == 1){
			 echo "O email nao foi enviado para o administrador.";
			 Util::log($id. "avalia_produto - O email nao foi enviado para o administrador (".$emailadmin.")");  
		 }
		else{
			Util::log($id. "avalia_produto - O email enviado com sucesso para (".$emailadmin.")");  
		}		 
	}
}

function get_id_pagamento() {
 
	$sql = "select max(id) as id from pagamentos";
    $rs = mysql_query($sql);	
	$linha = mysql_fetch_object($rs);
	$idpagamento = $linha->id;
	if($idpagamento==""){
		$idpagamento=1;	
	}
	$idpagamento = (int)$idpagamento + 1;
	return $idpagamento;
 
}

//$sql	=	"update team set anunciogratis = 'sim' where id=".$idnovo;
//$rs = @mysql_query($sql);
				
function insere_dados_pagamento() {
  
	global $INI;
  
	$data = date("Y-m-d H:i:s");
	
	$valorped = str_replace("","",$_REQUEST['valor']);
	$valorped = str_replace(",",".",$valorped);
	
    $sql	=	"INSERT INTO `pagamentos`(id, team_id,partner_id,datapagamento,idplano,valor,status_pagamento,mensagem) values (".$_REQUEST['idpedido'].",".$_REQUEST['team_id'].",".$_REQUEST['partner_id'].",'".$data."','".$_REQUEST['idplano']."',".$valorped.",'".$_REQUEST['status_pagamento']."','".$_REQUEST['mensagem']."')";
	$rs = @mysql_query($sql);
	
	
	if($_REQUEST['status_pagamento']=="Sucesso"){
		 $sql	=	"update team set pago= 'sim' where id=".$_REQUEST['team_id'];
		 $rs = @mysql_query($sql);
		  
		alteradatafim_anuncio($_REQUEST['team_id'],$_REQUEST['idplano']);
		  
		$team = Table::Fetch('team', $_REQUEST['team_id']);
		 
		 $body = 
		"<div> O anúncio '".$_REQUEST['team_id']."' foi pago e agora você precisa moderá-lo antes de sua publicação.</div><br>
		Para moderar este anúncio entre na administração no menu anúncios, clique em editar o anúncio '".$_REQUEST['team_id']."' e altere o status Moderação<br>
		<b> Dados do Anúncio</b>

		<p>Anúncio: ".$team['title']."</p>
		<p>Início: ".$team['begin_time']."</p>
		<p>Fim: ".$team['end_time']."</p>
		<p>Preço: ".$team['team_price']."</p> 
		<p>Descrição: ".$team['summary']."</p>" ;
		
		$emailadmin = $INI['mail']['from'];
		
		 if(enviar( $emailadmin,utf8_decode($INI["system"]["sitename"])." - ('".$_REQUEST['team_id']."') ".utf8_encode("Anúncio pago e aguardando moderação"),utf8_encode($body))){
			 $enviou =  true;
		 }
		 else{
			$enviou =  false;
		 }
	}
	  

}

function finalizaanuncio() {
  
	global $INI;
  
	$data = date("Y-m-d H:i:s");
	
	$valorped = str_replace("","",$_REQUEST['valor']);
	$valorped = str_replace(",",".",$valorped);
	
    $sql	=	"INSERT INTO `pagamentos`(id, team_id,partner_id,datapagamento,idplano,valor,status_pagamento,mensagem,gratis) values (".$_REQUEST['idpedido'].",".$_REQUEST['team_id'].",".$_REQUEST['partner_id'].",'".$data."','".$_REQUEST['idplano']."',".$valorped.",'','','s')";
	$rs = @mysql_query($sql);
	
 
	 $sql	=	"update team set anunciogratis= 's' where id=".$_REQUEST['team_id'];
	 $rs = @mysql_query($sql);
	  
	alteradatafim_anuncio($_REQUEST['team_id'],$_REQUEST['idplano']);
	  
	$team = Table::Fetch('team', $_REQUEST['team_id']);
	 
	 $body = 
	"<h2> O anúncio '".$_REQUEST['team_id']."' é precisa ser moderado antes de sua publicação.</h2><br>
	Para moderar este anúncio entre na administração no menu anúncios, clique em editar o anúncio '".$_REQUEST['team_id']."' e altere o status Moderação<br>
	<h3> Dados do Anúncio</h3>

	<p>Anúncio: ".$team['title']."</p>
	<p>Início: ".$team['begin_time']."</p>
	<p>Fim: ".$team['end_time']."</p>
	<p>Preço: ".$team['team_price']."</p><br>
	<p>Descrição: ".$team['summary']."</p>" ;
	
	$emailadmin = $INI['mail']['from'];
	
	 if(enviar( $emailadmin,utf8_decode($INI["system"]["sitename"])." - ('".$_REQUEST['team_id']."') Anúncio Aguardando Moderação",utf8_encode($body))){
		 $enviou =  true;
	 }
	 else{
		$enviou =  false;
	 }
	 
	  

}

function alteradatafim_anuncio($team_id,$plano_id){
	
	$sql = "select dias from planos_publicacao where id = $plano_id";
    $rs = mysql_query($sql);	
	$linha = mysql_fetch_object($rs);
	$dias = $linha->dias;
	
	$end_time =   strtotime('+'.$dias.' days');
	
	$sql	=	"update team set end_time= '$end_time' where id=".$team_id;
	$rs = @mysql_query($sql);
		 
	
	
}

function estapago($team_id) {
  
 	$sql = "select id from pagamentos where team_id =".$team_id." and status_pagamento= 'Sucesso'";
    $rs = mysql_query($sql);	
	if(mysql_num_rows($rs) >0){
		return true;
	}
	  
}

function buscaParcelas() {

	$valor = $_REQUEST['valor'];
	
	$opcoes='	<option value="1">1</option>';
	if( ($valor/2) >= 5 ){ $opcoes.='	<option value="2">2</option>';}
	if( ($valor/3) >= 5 ){$opcoes.='	<option value="3">3</option>';}
	if( ($valor/4) >= 5 ){$opcoes.='	<option value="4">4</option>';}
	if( ($valor/5) >= 5 ){$opcoes.='	<option value="5">5</option>';}
	if( ($valor/6) >= 5 ){$opcoes.='	<option value="6">6</option>';}
	if( ($valor/7) >= 5 ){$opcoes.='	<option value="7">7</option>';}
	if( ($valor/8) >= 5 ){$opcoes.='	<option value="8">8</option>';}
	if( ($valor/9) >= 5 ){$opcoes.='	<option value="9">9</option>';}
	if( ($valor/10) >= 5 ){$opcoes.='	<option value="10">10</option>';}
	if( ($valor/11) >= 5 ){$opcoes.='	<option value="11">11</option>';}
	if( ($valor/12) >= 5 ){$opcoes.='	<option value="12">12</option>';}
	
	return $opcoes;
 	   
}
 
function verifica_regras_pre_compra() {
 
	$id = $_REQUEST['id']; 
	if($_SESSION['qty_'.$id]==""){
			$_SESSION['qty_'.$id] = 1;
	}
	
	$team = Table::Fetch('team', $id );
	
	$ERROR 				=	"";
	$oferta_esgotada 	=  false;
	$end_time 			= date('YmdHis', $team['end_time']); 
	$date 				= date('YmdHis');
	
	$ex_con = array(
			'user_id' => $_REQUEST['idusuario'],
			'team_id' => $_REQUEST['idoferta'],
			'state' => 'unpay',
			);
	$order = DB::LimitQuery('order', array(
		'condition' => $ex_con,
		'one' => true,
	));

	if ( !$team ) { 
			$ERROR = 'Desculpe, esta oferta não existe mais em nossos registros' ;
			return utf8_encode($ERROR);
	}
	if (strtoupper($team['buyonce'])=='Y') {
		$ex_con['state'] = 'pay';
		if ( Table::Count('order', $ex_con) ) {
			$ERROR = 'Você já comprou esta oferta. Informamos que para esta oferta, você só pode comprar uma vez. Obrigado !';
			return utf8_encode($ERROR);
		}
	}
	if ($team['per_number']>0) {
		$now_count = Table::Count('order', array(
			'user_id' => $_REQUEST['idusuario'],
			'team_id' => $_REQUEST['idoferta'],
			'state' => 'pay',
		), 'quantity');
		
		$team['per_number'] -= $now_count;
		
		if ($team['per_number']<=0) {
			$ERROR = 'Você chegou ao limite de compra para esta oferta, por favor, dê uma olhada em outras ofertas!' ;
			return utf8_encode($ERROR);
		}
	}
	/*
	if( $team['begin_time']>time()){
		$ERROR = 'Desculpe, acabamos de adiar o início desta oferta. Por favor, dê uma olhada em outras ofertas.' ;
		return utf8_encode($ERROR);
	}
	if ( $team['end_time']<=time() ) { 
		$ERROR = 'Desculpe, esta oferta acabou de finalizar. Por favor, dê uma olhada em outras ofertas.' ;
		return utf8_encode($ERROR);
	}	
	*/
	
	if($_REQUEST['acao']!='participar'){
		
		/*
		if( $team['now_number'] >= $team['max_number'] ){ 
			$ERROR = 'Desculpe, esta oferta esgotou-se neste momento. Por favor, dê uma olhada em outras ofertas.' ;
			return utf8_encode($ERROR);
		} 
		*/
		
		if(stock($team['id']) == 0) {
			$ERROR = 'Desculpe, esta oferta esgotou-se neste momento. Por favor, dê uma olhada em outras ofertas.' ;
			return utf8_encode($ERROR);		
		}
	 }
	 if ( (int)$_SESSION['qty_'.$id]  > $team['per_number']) { 
		$ERROR = 'Quantidade máxima ultrapassada. Para esta oferta, você pode comprar até '.$team['per_number'].' unidade(s)' ;
		return utf8_encode($ERROR);
	}	
 
	
	 if ( (int)$_SESSION['qty_'.$id]  > (int)$team['per_number']) {  
	 
		$ERROR = 'Quantidade máxima ultrapassada por pessoa. Para esta oferta, você pode comprar apenas '.$team['per_number'] .' unidade(s)';
		return utf8_encode($ERROR);
	} 
	 if ( (int)$_SESSION['qty_'.$id]  < $team['minimo_pessoa']) { 
		$ERROR = 'Para esta oferta, você deve comprar o mínimo de '.$team['minimo_pessoa'].' unidades' ;
		return utf8_encode($ERROR);
	}
  
	return utf8_encode($ERROR);
}

function get_funcao_js() {
	global $login_user_id,$team,$INI;  
	
	if($login_user_id){
	 
		if(ePacote($team['id'])){
			$conteudo = getOfertasPacote($team['id']);
			$funcao_JS = "abreboxOfertasPacote('$conteudo');";
		}
		else if($team['processo_compra']=="" or $team['processo_compra']=="0"){
			$funcao_JS = "validacao();"; 
		}
		else{
			$funcao_JS = "calc(1);";
		}
	}
	else{
		if($team['processo_compra']=="" or $team['processo_compra']=="0"){
			$funcao_JS = "set_utm(0);"; 
		}
		else{
			$funcao_JS = "calc(),set_utm();";
		}
	}
	if($team['url_comprar']!=""){
		$funcao_JS = "envia_url_comprar('".$team['url_comprar']."');";
	}
	
	if($team['team_type'] =="participe"){
		if($login_user_id){
			$funcao_JS = "participar(1);";
		}
		else{
			$funcao_JS = "participar(),set_utm();";
		}
	
	}
	
	return $funcao_JS;
}
function atualiza_click($idoferta,$url) {

	$sql = "select clicados from team where id = $idoferta";
    $rs = mysql_query($sql);	
	$linha = mysql_fetch_object($rs);
	
	if($linha->clicados){
	   $sql = "update team set clicados = clicados + 1 where id = $idoferta";
		mysql_query($sql);	
	}
	else{
		$sql = "update team set clicados = 1 where id = $idoferta";
		mysql_query($sql);
	}
	
	$ip =  $_SERVER['REMOTE_ADDR'];
	$data = date('Y-m-d H:i:s');
	 
}
function consultavalecompras($codigo) {
	
	global $login_user_id;
	
	$sql = "select * from valecompras where codigo = '$codigo'";
    $rs = mysql_query($sql);	
	$linha = mysql_fetch_object($rs);
	
	$codigo = $linha->codigo;
	$limite = $linha->limite;
	$limiteporusuario = $linha->limiteporusuario;
	$usado = $linha->usado;
	$valor =  number_format($linha->valor, 2, ',', '.');  
	$status = $linha->status;
	
	if($codigo ==""){
		$erro =  "erro##Me desculpe, este cupom não existe em nossos registros.";
		return utf8_encode($erro);
	}
	if($status =="desativado"){
		$erro =  "erro##Me desculpe, este cupom está desativado em nossa base de dados.";
		return utf8_encode($erro);
	}
	if(!empty($limite)){
		if($usado >= $limite){
			$erro =  "erro##Me desculpe, este cupom chegou no seu limite de uso.";
			return utf8_encode($erro);
		}
	}	
	
	if($limiteporusuario == 1){
		$sql = "select count(id) as totaluso from `order` where user_id= $login_user_id and codigovalecompras = '$codigo'";
		$rs = mysql_query($sql);	
		$linha = mysql_fetch_object($rs);
		$totaluso = $linha->totaluso;
		
		if($totaluso >= $limiteporusuario){
			$erro =  "erro##Me desculpe, você chegou no limite de uso para este cupom.";
			return utf8_encode($erro);
		}
	}
	return "sucesso##".$valor;
	
	//$ip =  $_SERVER['REMOTE_ADDR'];
	//$data = date('Y-m-d H:i:s'); 
}

function need_post() {
	return is_post() ? true : redirect(WEB_ROOT . '/index.php');
}
function need_manager($super=false) {
 
 	/*$sql =  "select manager from user where id = ".abs(intval($_SESSION['user_id']));
	$rs  = mysql_query($sql);
	$row = mysql_fetch_object($rs);
	
	if($row->manager=="Y"){
	 
		return true;
	}
	*/
	
	if ( ! is_manager() ) {
		redirect( WEB_ROOT . '/vipmin/login.php' );
	}
	 
	if ( ! $super ) return true;
	

	  
	if ( abs(intval($_SESSION['user_id'])) == 1 ) return true;
	return redirect( WEB_ROOT . '/vipmin/misc/index.php');
}

function need_anunciante($super=false) { 
  
	if($_SESSION['user_id']=="1"){
		return redirect( WEB_ROOT . '/adminanunciante/loginnegado.php');
	}
	
	//if ( abs(intval($_SESSION['partner_id']))) { 
	//	return true;
	//}  A sessao do adminanunciante a partir da versao premium é sempre do usuario
	
	if ( abs(intval($_SESSION['user_id']))) {
		
		//$dados  = Table::Fetch('user',$_SESSION['user_id']);
		//$idpartner = busca_parceiro_usuario($dados['email']);
		//$_SESSION['partner_id'] = $idpartner;
		//if($idpartner){

			return true;
		//}

	}
	
	
	return redirect( WEB_ROOT . '/adminanunciante/login.php');
}

function need_partner() {
	return is_partner() ? true : redirect( WEB_ROOT . '/lojista/login.php');
}

function need_open($b=true) {
	if (true===$b) {
		return true;
	}
	if ($AJAX) json('Este recurso não está aberto', 'alert');
	Session::Set('error', 'Características página que você visita não está aberto');
	redirect( WEB_ROOT . '/index.php');
}

function getUltimoIdOferta() {

/*
	$sql 			=  "select id from team order by id desc limit 1";
	$rs  			= mysql_query($sql);
	$row 			= mysql_fetch_object($rs);
	$idofertateam 	= $row->id;
	
	$sql 			=  "select id from team order by id desc limit 1";
	$rs  			= mysql_query($sql);
	$row 			= mysql_fetch_object($rs);
	$idofertateam 	= $row->id;
	*/
	
	$sql 		=  "select valor from configuracao where campo='ultimo_id_oferta'";
	$rs  		= mysql_query($sql);
	$row 		= mysql_fetch_object($rs);
	$idoferta 	= $row->valor;
	
	if($idoferta==""){
		$idoferta=0;
	}
	
	$idnovaoferta = $idoferta + 1;
	
	mysql_query("update configuracao set valor = '$idnovaoferta'  where campo='ultimo_id_oferta'");

	return $idnovaoferta;
	
}
function need_auth($b=true) {

	global $AJAX, $INI, $login_user;
   /*
    $sql =  "select manager from user where id = ".abs(intval($_SESSION['user_id']));
	$rs  = mysql_query($sql);
	$row = mysql_fetch_object($rs);
	
	if($row->manager=="Y"){
	 
		return true;
	}*/
 
	if (is_string($b)) {
		$auths = $INI['authorization'][$login_user['id']];
		 
		if(in_array($b, $auths)){
			 
		}
		$b = is_manager(true) || in_array($b, $auths);
	}
	if (true===$b) {
		return true;
	}
 
	 if ($AJAX) json('????', 'alert');
	die(include template('manage_misc_noright'));
}

function is_manager($super=false, $weak=false) {
	global $login_user;
	
	/*$sql =  "select manager from user where id = ".abs(intval($_SESSION['user_id']));
	$rs  = mysql_query($sql);
	$row = mysql_fetch_object($rs);
	
	if($row->manager=="Y"){
	 
		return true;
	}*/

	
	if ( $weak===false &&( !$_SESSION['admin_id'] || $_SESSION['admin_id'] != $login_user['id']) ) {
		return false;
	}
	if ( ! $super ) return ($login_user['manager'] == 'Y');
	return $login_user['id'] == 1;
}
function is_partner() {
	return ($_SESSION['partner_id']>0);
}

function is_newbie(){ return (cookieget('newbie')!='N'); }
function is_get() { return ! is_post(); }
function is_post() {
	return strtoupper($_SERVER['REQUEST_METHOD']) == 'POST';
}

function is_login() {
	return isset($_SESSION['user_id']);
}

function get_loginpage($default=null) {
	$loginpage = Session::Get('loginpage', true);
	if ($loginpage)  return $loginpage;
	if ($default) return $default;
	return WEB_ROOT . '/index.php';
}

function cookie_city($city) {
 
}

function ename_city($ename=null) {
	return DB::LimitQuery('category', array(
		'condition' => array(
			'zone' => 'city',
			'ename' => $ename,
		),
		'one' => true,
	));
}

function cookieset($k, $v, $expire=0) {
	$pre = substr(md5($_SERVER['HTTP_HOST']),0,4);
	$k = "{$pre}_{$k}";
	if ($expire==0) {
		$expire = time() + 365 * 86400;
	} else {
		$expire += time();
	}
	setCookie($k, $v, $expire, '/');
}

function cookieget($k, $default='') {
	$pre = substr(md5($_SERVER['HTTP_HOST']),0,4);
	$k = "{$pre}_{$k}";
	return isset($_COOKIE[$k]) ? strval($_COOKIE[$k]) : $default;
}

function moneyit($k) {
    return rtrim(rtrim(sprintf("%1.2f",$k), ' '), '.');

    }

function moneyit2($k) {
$moeda2 = number_format($k, '0');  
return rtrim($moeda2);
}

function moneyit3($k) {
$moeda3 = number_format($k, 2, ',', '.'); 
return rtrim($moeda3);
}


 
function debug($v, $e=false) {
	global $login_user_id;
	if ($login_user_id==100000) {
		echo "<pre>";
		var_dump( $v);
		if($e) exit;
	}
}

function getparam($index=0, $default=0) {
	if (is_numeric($default)) {
		$v = abs(intval($_GET['param'][$index]));
	} else $v = strval($_GET['param'][$index]);
	return $v ? $v : $default;
}
function getpage() {
	$c = abs(intval($_GET['page']));
	return $c ? $c : 1;
}
function pagestring($count, $pagesize, $wap=false) {
	$p = new Pager($count, $pagesize, 'page');
	if ($wap) {
		return array($pagesize, $p->offset, $p->genWap());
	}
	return array($pagesize, $p->offset, $p->genBasic());
}

function uencode($u) {
	return base64_encode(urlEncode($u));
}
function udecode($u) {
	return urlDecode(base64_decode($u));
}
function share_facebook($team) {
	global $login_user_id;
	global $INI;
	if ($team)  {
		$query = array(
				'u' => $INI['system']['wwwprefix'] . "/team.php?id={$team['id']}&r={$login_user_id}",
				't' => $team['title'],
				);
	}
	else {
		$query = array(
				'u' => $INI['system']['wwwprefix'] . "/r.php?r={$login_user_id}",
				't' => $INI['system']['sitename'] . '(' .$INI['system']['wwwprefix']. ')',
				);
	}

	$query = http_build_query($query);
	return 'http://www.facebook.com/sharer.php?'.$query;
}

 
function share_twitter($team) {
	global $login_user_id;
	global $INI;
	if ($team)  {
		$query = array(
				'status' => $INI['system']['wwwprefix'] . "/team.php?id={$team['id']}&r={$login_user_id}" . ' ' . $team['title'],
				);
	}
	else {
		$query = array(
				'status' => $INI['system']['wwwprefix'] . "/r.php?r={$login_user_id}" . ' ' . $INI['system']['sitename'] . '(' .$INI['system']['wwwprefix']. ')',
				);
	}

	$query = http_build_query($query);
	return 'http://twitter.com/?'.$query;
}

 
function share_renren($team) {
	global $login_user_id;
	global $INI;
	if ($team)  {
		$query = array(
				'link' => $INI['system']['wwwprefix'] . "/team.php?id={$team['id']}&r={$login_user_id}",
				'title' => $team['title'],
				);
	}
	else {
		$query = array(
				'link' => $INI['system']['wwwprefix'] . "/r.php?r={$login_user_id}",
				'title' => $INI['system']['sitename'] . '(' .$INI['system']['wwwprefix']. ')',
				);
	}

	$query = http_build_query($query);
	return 'http://share.renren.com/share/buttonshare.do?'.$query;
}

function share_kaixin($team) {
	global $login_user_id;
	global $INI;
	if ($team)  {
		$query = array(
				'rurl' => $INI['system']['wwwprefix'] . "/team.php?id={$team['id']}&r={$login_user_id}",
				'rtitle' => $team['title'],
				'rcontent' => strip_tags($team['summary']),
				);
	}
	else {
		$query = array(
				'rurl' => $INI['system']['wwwprefix'] . "/r.php?r={$login_user_id}",
				'rtitle' => $INI['system']['sitename'] . '(' .$INI['system']['wwwprefix']. ')',
				'rcontent' => $INI['system']['sitename'] . '(' .$INI['system']['wwwprefix']. ')',
				);
	}
	$query = http_build_query($query);
	return 'http://www.kaixin001.com/repaste/share.php?'.$query;
}

function share_douban($team) {
	global $login_user_id;
	global $INI;
	if ($team)  {
		$query = array(
				'url' => $INI['system']['wwwprefix'] . "/team.php?id={$team['id']}&r={$login_user_id}",
				'title' => $team['title'],
				);
	}
	else {
		$query = array(
				'url' => $INI['system']['wwwprefix'] . "/r.php?r={$login_user_id}",
				'title' => $INI['system']['sitename'] . '(' .$INI['system']['wwwprefix']. ')',
				);
	}
	$query = http_build_query($query);
	return 'http://www.douban.com/recommend/?'.$query;
}

function tratanome($title){

	$var = ereg_replace("[ÁÀÂÃ]","A", utf8_decode($title) );
	$var = ereg_replace("[áàâãª]","a",$var);
	$var = ereg_replace("[ÉÈÊ]","E",$var);
	$var = ereg_replace("[éèê]","e",$var);
	$var = ereg_replace("[Í]","I",$var);
	$var = ereg_replace("[ÓÒÔÕ]","O",$var);
	$var = ereg_replace("[óòôõº]","o",$var);
	$var = ereg_replace("[ÚÙÛ]","U",$var);
	$var = ereg_replace("[í]","i",$var);
	$var = ereg_replace("[úùû]","u",$var);
	$var = str_replace("Ç","C",$var);
	$var = str_replace("ç","c",$var);
	return $var;

}
 
 

function urlamigavel($nome){
	return  str_replace("++","+",utf8_decode(str_replace("r$","",strtolower(str_replace("-","",str_replace("'","",str_replace(",","",str_replace("!","",str_replace("/","",str_replace("%","",str_replace(".","",str_replace(" ","+",$nome)))))))))))) .".html";
}

function share_sina($team) {
	global $login_user_id;
	global $INI;
	if ($team)  {
		$query = array(
				'url' => $INI['system']['wwwprefix'] . "/team.php?id={$team['id']}&r={$login_user_id}",
				'title' => $team['title'],
				);
	}
	else {
		$query = array(
				'url' => $INI['system']['wwwprefix'] . "/r.php?r={$login_user_id}",
				'title' => $INI['system']['sitename'] . '(' .$INI['system']['wwwprefix']. ')',
				);
	}
	$query = http_build_query($query);
	return 'http://v.t.sina.com.cn/share/share.php?'.$query;
}

function share_mail($team) {
	global $login_user_id;
	global $INI;
	if (!$team) {
		$team = array(
				'title' => $INI['system']['sitename'] . '(' . $INI['system']['wwwprefix'] . ')',
				);
	}
	$pre[] = "Found a good site--{$INI['system']['sitename']}?Every day is a New deal!";
	if ( $team['id'] ) {
		$pre[] = "Customers today are:{$team['title']}";
		$pre[] = "I think you will be interested in:";
		$pre[] = $INI['system']['wwwprefix'] . "/team.php?id={$team['id']}&r={$login_user_id}";
		 
		$sub = "You are interested in?{$team['title']}";
	} else {
		$sub = $pre[] = $team['title'];
	}
	$sub = mb_convert_encoding($sub, 'GBK', 'UTF-8');
	$query = array( 'subject' => $sub, 'body' => $pre, );
	$query = http_build_query($query);
	return 'mailto:?'.$query;
}

function domainit($url) {
	if(strpos($url,'//')) { preg_match('#[//]([^/]+)#', $url, $m);
} else { preg_match('#[//]?([^/]+)#', $url, $m); }
return $m[1];
}

function getDomino($email){
	$email = explode("@",$email);
	return $email[1];	
} 
 
if(! function_exists ( 'checkdnsrr' )){ 
	function checkdnsrr ( $host , $type = '' ){ 
		if(!empty( $host )){ 
			$type = (empty( $type )) ? 'MX' : $type ; 
			exec ( 'nslookup -type=' . $type . ' ' . escapeshellcmd ( $host ), $result ); 
			$it = new ArrayIterator ( $result ); 
			foreach(new RegexIterator ( $it , '~^' . $host . '~' , RegexIterator :: GET_MATCH ) as $result ){ 
				if( $result ){ 
					return true ; 
				} 
			} 
		} 
		return false ; 
	} 
}

function RecursiveMkdir($path) {
	if (!file_exists($path)) {
		RecursiveMkdir(dirname($path));
		@mkdir($path, 0777,true);
	}
	 
}

function need_login($wap=false) {
	if ( isset($_SESSION["user_id"]) ) {
		if (is_post()) {
			unset($_SESSION["loginpage"]);
			unset($_SESSION["loginpagepost"]);
		}
		return $_SESSION["user_id"];
	}
 
	$_SESSION["loginpagepost"] = $_SERVER["REQUEST_URI"];
	 
	if (true===$wap) {
		return redirect(WEB_ROOT . "/wap/login.php");
	}
 
	return redirect(WEB_ROOT . "/index.php");
}

function user_image($image=null) {
global $INI;
	if (!$image) {
		return $INI['system']['imgprefix'] . '/media/img/user-no-avatar.gif';
	}
	return $INI['system']['imgprefix'] . '/media/' .$image;
}

function team_image($image=null, $index=false) {
	global $INI;
	if (!$image) return null;
	if ($index) {
		$path = WWW_ROOT . '/media/' . $image;
		$image = preg_replace('#(\d+)\.(\w+)$#', "\\1_index.\\2", $image);
		$dest = WWW_ROOT . '/media/' . $image;
		if (!file_exists($dest) && file_exists($path) ) {
			Image::Convert($path, $dest, 200, 120, Image::MODE_SCALE);
		}
	}
	return $INI['system']['imgprefix'] . '/media/' .$image;
}

function userreview($content) {
	$line = preg_split("/[\n\r]+/", $content, -1, PREG_SPLIT_NO_EMPTY);
	$r = '<ul>';
	foreach($line AS $one) {
		$c = explode('|', htmlspecialchars($one));
		$c[2] = $c[2] ? $c[2] : '/';
		$r .= "<li>{$c[0]}<span><a href=\"{$c[2]}\" target=\"_blank\">{$c[1]}</a>";
		$r .= ($c[3] ? "?{$c[3]}?":'') . "</span></li>\n";
	}
	return $r.'</ul>';
}

function invite_state($invite) {
	if ('Y' == $invite['pay']) return 'Já comprou';
	if ('C' == $invite['pay']) return 'Não Aprovado';
	if ('N' == $invite['pay'] && $invite['buy_time']) return 'Ainda não comprou';
	if (time()-$invite['create_time']>7*86400) return 'Expirado';
	return 'Não Comprei';
}

function team_state(&$team) {
	if ( $team['now_number'] >= $team['min_number'] ) {
		if ($team['max_number']>0) {
			if ( $team['now_number']>=$team['max_number'] ){
				if ($team['close_time']==0) {
					$team['close_time'] = $team['end_time'];
				}
				return $team['state'] = 'soldout';
			}
		}
		if ( $team['end_time'] <= time() ) {
			$team['close_time'] = $team['end_time'];
		}
		return $team['state'] = 'success';
	} else {
		if ( $team['end_time'] <= time() ) {
			$team['close_time'] = $team['end_time'];
			return $team['state'] = 'failure';
		}
	}
	return $team['state'] = 'none';
}

 

function state_explain($team, $error='false') {
	$state = team_state($team);
	$state = strtolower($state);
	switch($state) {
		case 'none': return 'Oferta em curso';
		case 'soldout': return 'Oferta esgotada';
		case 'failure': if($error) return 'Oferta não atingiu min. de compradores';
		case 'success': return 'Sucesso na oferta';
		default: return 'Oferta Finalizada';
	}
}

function get_zones($zone=null) {
	$zones = array(
			'city' => 'Cidade',
			'group' => 'Categoria',
			//'public' => 'Categoria do Forum',
			//'grade' => 'User Grade',
			//'express' => 'Express',
			'partner' => 'Categoria de parceria',
			);
	if ( !$zone ) return $zones;
	if (!in_array($zone, array_keys($zones))) {
		$zone = 'city';
	}
	return array($zone, $zones[$zone]);
}

 
function down_xls($data, $keynames, $name='dataxls') {
	$xls[] = "<html><meta http-equiv=content-type content=\"text/html; charset=UTF-8\"><body><table border='1'>";
	$xls[] = "<tr><td>ID</td><td>" . implode("</td><td>", array_values($keynames)) . '</td></tr>';
	foreach($data As $o) {
		$line = array(++$index);
		foreach($keynames AS $k=>$v) {
			$line[] = $o[$k];
		}
		$xls[] = '<tr><td>'. implode("</td><td>", $line) . '</td></tr>';
	}
	$xls[] = '</table></body></html>';
	$xls = join("\r\n", $xls);
	header('Content-Disposition: attachment; filename="'.$name.'.xls"');
	die(mb_convert_encoding($xls,'UTF-8','UTF-8'));
}

function option_hotcategory($zone='city', $force=false, $all=false) {
	$cates = option_category($zone, $force, true);
	$r = array();
	foreach($cates AS $id=>$one) {
		if ('Y'==strtoupper($one['display'])) $r[$id] = $one;
	}
	return $all ? $r: Utility::OptionArray($r, 'id', 'name');
}

function option_category($zone='city', $force=false, $all=false) {
	$cache = $force ? 0 : 86400*30;
	$cates = DB::LimitQuery('category', array(
		'condition' => array( 'zone' => $zone, ),
		'order' => 'ORDER BY sort_order DESC, id DESC',
		'cache' => $cache,
	));
	$cates = Utility::AssColumn($cates, 'id');
	return $all ? $cates : Utility::OptionArray($cates, 'id', 'name');
}

function option_yes($n, $default=false) {
	global $INI;
	if (false==isset($INI['option'][$n])) return $default;
	$flag = trim(strval($INI['option'][$n]));
	return abs(intval($flag)) || strtoupper($flag) == 'Y';
}

function option_yesv($n, $default='N') {
	return option_yes($n, $default=='Y') ? 'Y' : 'N';
}



function team_discount($team, $save=false) {
	if ($team['market_price']<0 || $team['team_price']<0 ) {
		return '?';
	}
	return moneyit((10*$team['team_price']/$team['market_price']));
}

function desconto($team_price, $market_price) {
	 
	return moneyit((10*$team_price/$market_price));
}

function team_origin($team, $quantity=0) {
	$origin = $quantity * $team['team_price'];
	if ($team['delivery'] == 'express'
			&& ($team['farefree']==0 || $quantity < $team['farefree'])
		) {
			$origin += $team['fare'];
		}
	return $origin;
}

function error_handler($errno, $errstr, $errfile, $errline) {
	switch ($errno) {
		case E_PARSE:
		case E_ERROR:
			echo "<b>Fatal ERROR</b> [$errno] $errstr<br />\n";
			echo "Fatal error on line $errline in file $errfile";
			echo "PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
			exit(1);
			break;
		default: break;
	}
	return true;
}

function obscure_rep($u) {
	if(!option_yes('encodeid')) return $u;
	if(preg_match('#/vipmin/#', $_SERVER['REQUEST_URI'])) return $u;
	return preg_replace_callback('#(\?|&)id=(\d+)(\b)#i', obscure_cb, $u);
}
function obscure_did() {
	$gid = strval($_GET['id']);
	if ($gid && strpos($gid, 'WR')===0) {
		$_GET['id'] = base64_decode(substr($gid,2))>>2;
	}
}
function obscure_cb($m) {
	$eid = obscure_eid($m[2]);
	return "{$m[1]}id={$eid}{$m[3]}";
}
function obscure_eid($id) {
	return 'WR'.base64_encode($id<<2);
}
obscure_did();



function trimarray($o) {
	if (!is_array($o)) return trim($o);
	foreach($o AS $k=>$v) { $o[$k] = trimarray($v); }
	return $o;
}
$_POST = trimarray($_POST);


set_error_handler('error_handler');

function img_parceiro() {
	return ($_SESSION['partner_id']>0);
}
 
 function exibe_filhos($id_categoria, $indent='',$idpai=false,$id=false){
 
 	if($id){
			$aux =  " and id <> ".$id;
	}
													
	$sql = "select * from category where idpai=$id_categoria  $aux order by sort_order desc";
	$rs = mysql_query($sql);
	

	while($l = mysql_fetch_assoc($rs)){
	    $selected ="";
		if($idpai == $l['id']){
				$selected =  " selected ";
		}
		$tipocategoria = $l[tipo];
		$nomecategoria = $l[name];
		
		if($tipocategoria=="")
		
		echo "<option value='$l[id]' $selected  >$indent $l[name]</option>";
		exibe_filhos($l["id"], $indent . $indent,$idpai,$id);
	}
}  

function exibe_filhos_mobile($id_categoria, $indent='',$idpai=false,$id=false){
 
 	if($id){
			$aux =  " and id <> ".$id;
	}
													
	$sql = "select * from category where idpai=$id_categoria  $aux order by sort_order desc";
	$rs = mysql_query($sql);
	

	while($l = mysql_fetch_assoc($rs)){
	    $selected ="";
		if($idpai == $l['id']){
				$selected =  " selected ";
		}
		$tipocategoria = $l[tipo];
		$nomecategoria = $l[name];
		
		if($tipocategoria=="")
		
		echo "<option value='" . $l[id] . "'" . $selected . ">" . $indent .  utf8_decode($l[name]) . "</option>";
		exibe_filhos_mobile($l["id"], $indent . $indent,$idpai,$id);
	}
} 

/*
 function exibe_atributos_filhos($id, $indent='',$idpai=false,$id=false){
 
 	if($id){
			$aux =  " and id <> ".$id;
	}
													
	$sql = "select * from category_atributos where id_atributopai=$id  $aux order by ordem desc";
	$rs = mysql_query($sql);
	 
	while($l = mysql_fetch_assoc($rs)){
	    $selected ="";
		if($idpai == $l['id']){
				$selected =  " selected ";
		}  
		  
		echo "<option value='$l[id]' $selected  >$indent $l[nome_atributo]</option>";
		exibe_atributos_filhos($l["id"], $indent . $indent,$idpai,$id);
	}
}
*/
function exibe_filhos_page($id_categoria, $indent='',$idpai=false){
 
   
	$sql = "select * from category where idpai=$id_categoria";
	$rs = mysql_query($sql);
	
	while($l = mysql_fetch_assoc($rs)){
	    $selected ="";
		if($idpai == $l['id']){
				$selected =  " selected ";
		}
		echo "<option value='$l[id]' $selected  >$indent $l[name]</option>";
		exibe_filhos($l["id"], $indent . $indent,$idpai,$id);
	}
}

function exibe_filhos_atributo($id_atributo, $indent='',$team_id){
	//$team_id =46;
    $array_atributos = busca_atributos_produto($team_id);
	
	$sql = "select * from category_atributos where status=1 and id_atributopai = $id_atributo order by ordem desc, nome_atributo asc";
	$rs = mysql_query($sql);
	
	while($row = mysql_fetch_assoc($rs)){
	    $checked = "";
		$id		=	$row['id']; 
		if (in_array($id, $array_atributos)) { 
			$checked  = "checked='checked'";
		} 
		echo " $indent <input $checked type='checkbox' value='$id' name='atributos[]' class='cinput' > {$row['nome_atributo']}";
		exibe_filhos_atributo($row["id"], $indent . $indent,$team_id);
	}
}

function busca_atributos_produto($id){

	$sql = "select id_atributo from produto_atributos where team_id = $id";
	$rs = mysql_query($sql);  

	while($array = mysql_fetch_array($rs)) {
	  $result[] = $array[id_atributo] ; 
	}
	return $result;
}

function getImagem($team,$aux=false){
	global $INI; 
	
	if($aux== "popular"){ 
		$imgbase = substr($team['estatica_home'],0,-4)."_estatica_home.jpg";
		if(file_exists(WWW_ROOT."/media/".$imgbase)){
			return $INI['system']['wwwprefix']."/media/".$imgbase;
		} 
	}
	else if($aux== "lateral"){ 
		$imgbase = substr($team['estatica_direita'],0,-4)."_estatica_direita.jpg";
		if(file_exists(WWW_ROOT."/media/".$imgbase)){
			return $INI['system']['wwwprefix']."/media/".$imgbase;
		} 
	}
	else if($aux=="detalhe"){ 
		$imgbase = substr($team['estatica_detalhe'],0,-4)."_estatica_detalhe.jpg";
		if(file_exists(WWW_ROOT."/media/".$imgbase)){
			return $INI['system']['wwwprefix']."/media/".$imgbase;
		} 
	}
	 
	 if($aux != ""){
		 $aux = "_".$aux;
	  }
	  
	  if(!$team['image']){
		return $INI['system']['wwwprefix']."/skin/padrao/images/semfoto.jpg";
	  }
	  else{
		return $INI['system']['wwwprefix']."/media/".substr($team['image'],0,-4).$aux.".jpg";
	 }
	
}


//bannerslideshow - home page 
function getbannerslideshow(){ 
       
  global $ROOTPATH ; 
  $dir =  WWW_ROOT."/media/slideshowbanners";
  $dh =  opendir($dir);
  
  if($dh){
    
   while ($file = readdir($dh)){
   
    if($file =="." or $file == ".." or $file =="thumbs" or $file  =="Thumbs.db"){
     continue;
    } 
    $itens[] = $file ; 
   } 
   
   sort($itens);
   
   foreach ($itens as $file) {
    
    $linkfile = str_replace(" " , "_" , $file);
    $linkfile = str_replace("." , "_" , $linkfile);
    //$linkfile = implode("_", explode(".", $file));
    
    $sql = "select link from linkbanners where file='" . $linkfile . "'";
    $rs = mysql_query($sql);
    $row = mysql_fetch_assoc($rs);
    $link = $row['link'];
    
    if($link){
    	if($link == "tk_cadastrar"){ 
    		$imagens.="<a href='#' class='tk_cadastrar'><img src='" . $ROOTPATH . "/media/slideshowbanners/" . trim($file) . "' /></a>";
    	}else{
    		$imagens.="<a href='".$link."' target='_blank'><img src='" . $ROOTPATH . "/media/slideshowbanners/" . trim($file) . "' /></a>";
    	}
    }else{
    	$imagens.="<img src='" . $ROOTPATH . "/media/slideshowbanners/" . trim($file) . "' />";
    }
   } 
   
  }   
 return  $imagens;
}



//superbanner
function getsuperslide(){ 
			    
		global $ROOTPATH ;
		
		$dir =  WWW_ROOT."/media/superbackground";
		$dh =  opendir($dir);
		
		if($dh){
		  
			while ($file = readdir($dh)){
			
				if($file =="." or $file == ".." or $file =="thumbs"){
					continue;
				} 
				$itens[] = $file ; 
			} 
			
			sort($itens);
			
			foreach ($itens as $file) {
			
				$imagens.="{image :  '$ROOTPATH/media/superbackground/".trim($file)."', title : 'teste', thumb : 'teste', url : '$ROOTPATH/media/superbackground/".trim($file)."'},";
			 } 
			
		}
		$imagens = substr($imagens, 0, -1); 
	return 	$imagens;
}

function str2num($str){ 
  if(strpos($str, '.') < strpos($str,',')){ 
            $str = str_replace('.','',$str); 
            $str = strtr($str,',','.');            
        } 
        else{ 
            $str = str_replace(',','',$str);            
        } 
        return (float)$str; 
} 


// parametro modo é o metodo dos correios
function fretecarrinho($cep_destino,$modo){

	$itens = json_decode($_SESSION['carrinhoitens'], true);
	$valorfrete = 0;
	$totalfrete = 0; 
	
	foreach(json_decode($_SESSION['carrinhoitens']) as $item) {
		if($existeerro) break; 
		
		$qty = (isset($_SESSION['qty_'.$item->id])) ? $_SESSION['qty_'.$item->id] : 1;
		$multiplicafreteqtde = "";
		if($item->frete==1){
			if($item->valorfrete!="" and str2num($item->valorfrete) > str2num(0)){
				$valorfrete  = $item->valorfrete;
				 
				if($multiplicafreteqtde=="Y"){
						//$valorfrete = $qty * str2num($valorfrete);
				}  
				$totalfrete = str2num($totalfrete) +  str2num($valorfrete);
			}
			else{
			
				if($multiplicafreteqtde=="Y"){
						//$team_price = $qty * $item->team_price;
				}
				else{
					$team_price = $item->team_price;
				}  
				$result =  calculaFrete($modo, $item->ceporigem, $cep_destino, $item->peso,$item->altura, $item->largura,$item->comprimento,$team_price);
				 
				list($status,$valorfrete,$prazoentrega,$modo) =  split ("#", $result);
				$totalfrete = $totalfrete + $valorfrete; 
				$prazos[] = $prazoentrega;
				if($status=="erro"){
						$existeerro=true;
						$mensagemerro = $prazoentrega;
				} 
			} 
		}
	}
	if($existeerro){
		return "erro-$mensagemerro";
	}
	else{
		return "sucesso-".number_format($totalfrete,2, ',', '.')."-".max( $prazos );
	} 
}

function removercentavos($valor){
	//echo "---".$valor;
	//$valor = str_replace(".", "");
	$valor = explode(",",$valor);
	$novovalor = $valor[0];
	return $novovalor; 
}
function ehsedex($tipo){
	
	if($tipo == 40010  or  $tipo == 40215){
		return true;
	}
	else{
		return false;
	}
}
  
function calculaFrete($cod_servico, $cep_origem, $cep_destino, $peso, $altura, $largura, $comprimento, $valor_declarado)
{
    #OFICINADANET###############################
    # Código dos Serviços dos Correios
    # 41106 PAC sem contrato
    # 40010 SEDEX sem contrato
    # 40045 SEDEX a Cobrar, sem contrato
    # 40215 SEDEX 10, sem contrato
    ############################################
	  
	//$cod_servico = 41106;

	 $valor_declarado = number_format($valor_declarado, 2, ',', '.');
	 $valor_declarado = removercentavos($valor_declarado);
	 $valor_declarado = str_replace(".","",$valor_declarado); // problema com valores acima de 1000. (1.000 erro), alterando para 1000
	 //echo "****".$valor_declarado;
	  
   $correios = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem=".$cep_origem."&sCepDestino=".$cep_destino."&nVlPeso=".$peso."&nCdFormato=1&nVlComprimento=".$comprimento."&nVlAltura=".$altura."&nVlLargura=".$largura."&sCdMaoPropria=n&nVlValorDeclarado=". $valor_declarado ."&sCdAvisoRecebimento=n&nCdServico=".$cod_servico."&nVlDiametro=0&StrRetorno=xml";
    $xml = simplexml_load_file($correios);
   if($xml->cServico->Erro == '0' or $xml->cServico->Erro =='99' or $xml->cServico->Erro =='010' ){
   //echo "=======entrou=======";
		
		$Valor = $xml->cServico->Valor;
		$PrazoEntrega = $xml->cServico->PrazoEntrega; 
		 
		if( $xml->cServico->Erro =='99'){
			$PrazoEntrega="";
		}
		
		$retorno = "sucesso#".$Valor."#".$PrazoEntrega."#".$cod_servico;
	}
    else{
        $Erro = $xml->cServico->Erro;
		$MsgErro = $xml->cServico->MsgErro;
		$retorno = "erro#".$Erro."#".$MsgErro."#".$cod_servico;
		 
	}
	return $retorno ;
}

function getCepDestino($dados){ 

	if(empty($dados['entrega_cep'])){
			return $dados['zipcode'];
	 }
	else{
		return $dados['entrega_cep'];
	}
	
}

function getEnderecoClienteEntrega($dados){ 
	  
	if(empty($dados['entrega_endereco'])){
			getEnderecoCliente($dados);
			return;
	}
	$endereco = ucfirst(utf8_decode($dados['entrega_endereco'])). ", ".ucfirst($dados['entrega_numero']);
	if($dados['entrega_complemento']!=""){
		$endereco.= " ".ucfirst(utf8_decode($dados['entrega_complemento']));
	}
	$endereco .=  ", ".ucfirst(utf8_decode($dados['entrega_bairro'])). ", ".ucfirst(utf8_decode($dados['entrega_cidade'])). " - ".strtoupper(utf8_decode($dados['entrega_estado'])). " - ".$dados['entrega_cep'];
	echo $endereco ;
 
 	echo '<input type=hidden name=entrega_endereco value="'.$dados['entrega_endereco'].'">';
	echo '<input type=hidden name=entrega_numero value="'.$dados['entrega_numero'].'">';
	echo '<input type=hidden name=entrega_complemento value="'.$dados['entrega_complemento'].'">';
	echo '<input type=hidden name=entrega_bairro value="'.$dados['entrega_bairro'].'">';
	echo '<input type=hidden name=entrega_cidade value="'.$dados['entrega_cidade'].'">';
	echo '<input type=hidden name=entrega_estado value="'.$dados['entrega_estado'].'">';
	echo '<input type=hidden name=entrega_cep value="'.$dados['entrega_cep'].'">';

	
}
function getEnderecoClienteCobranca($dados){ 
	
	if(empty($dados['cobranca_endereco'])){
			getEnderecoCliente($dados);
			return;
	}
	
	$endereco = ucfirst(utf8_decode($dados['cobranca_endereco'])). ", ".ucfirst($dados['cobranca_numero']);
	if($dados['cobranca_complemento']!=""){
		$endereco.= " ".ucfirst(utf8_decode($dados['cobranca_complemento']));
	}
	$endereco .=  ", ".ucfirst(utf8_decode($dados['cobranca_bairro'])). ", ".ucfirst(utf8_decode($dados['cobranca_cidade'])). " - ".strtoupper(utf8_decode($dados['cobranca_estado'])). " - ".$dados['cobranca_cep'];
	
	echo $endereco ;
	 
 	echo '<input type=hidden name=entrega_endereco value="'.$dados['entrega_endereco'].'">';
	echo '<input type=hidden name=entrega_numero value="'.$dados['entrega_numero'].'">';
	echo '<input type=hidden name=entrega_complemento value="'.$dados['entrega_complemento'].'">';
	echo '<input type=hidden name=entrega_bairro value="'.$dados['entrega_bairro'].'">';
	echo '<input type=hidden name=entrega_cidade value="'.$dados['entrega_cidade'].'">';
	echo '<input type=hidden name=entrega_estado value="'.$dados['entrega_estado'].'">';
	echo '<input type=hidden name=entrega_cep value="'.$dados['entrega_cep'].'">';
 
}
function getEnderecoCliente($dados){ 
	
	$endereco = ucfirst(utf8_decode($dados['address'])). " ".$dados['numero']." ".utf8_decode($dados['complemento']). ", ".ucfirst(utf8_decode($dados['bairro'])). ", ".ucfirst(utf8_decode($dados['cidadeusuario'])). " - ".strtoupper($dados['estado']). " - ".$dados['zipcode'];
	echo $endereco ;
	
	 
 	echo '<input type=hidden name=entrega_endereco value="'.$dados['address'].'">';
	echo '<input type=hidden name=entrega_numero value="'.$dados['numero'].'">';
	echo '<input type=hidden name=entrega_complemento value="'.$dados['complemento'].'">';
	echo '<input type=hidden name=entrega_bairro value="'.$dados['bairro'].'">';
	echo '<input type=hidden name=entrega_cidade value="'.$dados['cidadeusuario'].'">';
	echo '<input type=hidden name=entrega_estado value="'.$dados['estado'].'">';
	echo '<input type=hidden name=entrega_cep value="'.$dados['zipcode'].'">';
	
 
}

function displaySubStringWithStrip($string, $length=NULL)
{
    if ($length == NULL)
            $length = 50;
   
    $stringDisplay = substr(strip_tags($string), 0, $length);
    if (strlen(strip_tags($string)) > $length)
        $stringDisplay .= '';
    return $stringDisplay;
}

function verificarepublicacao($republicacao,$left_hour,$left_day){

	if($republicacao=="1"){
			if($left_day >1 ){
				$left_day = 0;
				$hora_corrente =  date("H"); 
				$left_hour = 23  - $hora_corrente ;  
				return $left_hour;
		}
	}
	return $left_hour;
}


function getEnderecoEntregaPedido($dados){ 
	   
	$endereco = ucfirst($dados['entrega_endereco']). ", ".ucfirst($dados['entrega_numero']);
	if($dados['entrega_complemento']!=""){
		$endereco.= " ".ucfirst($dados['entrega_complemento']);
	}
	$endereco .=  ", ".ucfirst( $dados['entrega_bairro'] ). ", ".ucfirst($dados['entrega_cidade']). " - ".strtoupper($dados['entrega_estado']). " - ".$dados['entrega_cep'];
	echo $endereco ;
 
}

function getEnderecoEntregaPedidoUser($dados){ 
	  
	$endereco = ucfirst(utf8_decode($dados['entrega_endereco'])). ", ".ucfirst($dados['entrega_numero']);
	if($dados['entrega_complemento']!=""){
		$endereco.= " ".ucfirst(utf8_decode($dados['entrega_complemento']));
	}
	$endereco .=  ", ".ucfirst(utf8_decode($dados['entrega_bairro'])). ", ".ucfirst(utf8_decode($dados['entrega_cidade'])). " - ".strtoupper(utf8_decode($dados['entrega_estado'])). " - ".$dados['entrega_cep'];
	echo $endereco ;
 
}
 

function getEnderecoCobrancaPedido($dados){ 
  
	$endereco = ucfirst($dados['cobranca_endereco']). ", ".ucfirst($dados['cobranca_numero']);
	if($dados['cobranca_complemento']!=""){
		$endereco.= " ".ucfirst($dados['cobranca_complemento']);
	}
	$endereco .=  ", ".ucfirst($dados['cobranca_bairro']). ", ".ucfirst($dados['cobranca_cidade']). " - ".strtoupper($dados['cobranca_estado']). " - ".$dados['cobranca_cep'];
	echo $endereco ;
 
}

function data($var){
	return date('d/m/Y', strtotime($var));
}

function datahora($var){
	return date('d/m/Y H:i:s', strtotime($var));
}

function getEnderecoCobrancaPedidoAdmin($idpedido,$idusuario){ 
  
	$dados  = Table::Fetch('order_enderecos',$idpedido,'idpedido');
	if(!$dados['cobranca_endereco']){
		$dados  = Table::Fetch('user',$idusuario);	
	}	
	if($dados['cobranca_endereco']==""){
		$endereco = ucfirst($dados['address']). ", ".ucfirst($dados['numero']);
		if($dados['entrega_complemento']!=""){
			$endereco.= " ".ucfirst($dados['complemento']);
		}
		$endereco .=  ", ".ucfirst( $dados['bairro'] ). ", ".ucfirst($dados['cidadeusuario']). " - ".strtoupper($dados['estado']). " - ".$dados['zipcode'];
	}
	else{
		$endereco = ucfirst($dados['cobranca_endereco']). ", ".ucfirst($dados['cobranca_numero']);
		if($dados['cobranca_complemento']!=""){
			$endereco.= " ".ucfirst($dados['cobranca_complemento']);
		}
		$endereco .=  ", ".ucfirst($dados['cobranca_bairro']). ", ".ucfirst($dados['cobranca_cidade']). " - ".strtoupper($dados['cobranca_estado']). " - ".$dados['cobranca_cep'];
	}
	echo $endereco ;
 
}

function getEnderecoEntregaPedido_template($idpedido,$idusuario){ 
	   
	 $dados  = Table::Fetch('order_enderecos',$idpedido,'idpedido');
	if(!$dados['entrega_endereco']){
		$dados  = Table::Fetch('user',$idusuario);	
	}
	if($dados['entrega_endereco']==""){
		$endereco = ucfirst($dados['address']). " ".ucfirst($dados['numero']);
		if($dados['complemento']!=""){
			$endereco.= " - ".ucfirst($dados['complemento']);
		}
		$endereco .=  " ".ucfirst( $dados['bairro'] ). ", ".ucfirst($dados['cidadeusuario']). " - ".strtoupper($dados['estado']). " - Cep: ".$dados['zipcode'];
	}else{
		$endereco = ucfirst($dados['entrega_endereco']). ", ".ucfirst($dados['entrega_numero']);
		if($dados['entrega_complemento']!=""){
			$endereco.= " - ".ucfirst($dados['entrega_complemento']);
		}
		$endereco .=  " ".ucfirst( $dados['entrega_bairro'] ). ", ".ucfirst($dados['entrega_cidade']). " - ".strtoupper($dados['entrega_estado']). " - Cep: ".$dados['entrega_cep'];
	}
	echo $endereco;
 
}

function getEnderecoEntregaPedidoAdmin($idpedido,$idusuario){ 
	   
	 $dados  = Table::Fetch('order_enderecos',$idpedido,'idpedido');
	if(!$dados['entrega_endereco']){
		$dados  = Table::Fetch('user',$idusuario);	
	}
	if($dados['entrega_endereco']==""){
		$endereco = ucfirst($dados['address']). " ".ucfirst($dados['numero']);
		if($dados['complemento']!=""){
			$endereco.= " ".ucfirst($dados['complemento']);
		}
		$endereco .=  " ".ucfirst( $dados['bairro'] ). ", ".ucfirst($dados['cidadeusuario']). " - ".strtoupper($dados['estado']). " - Cep: ".$dados['zipcode'];
	}else{
		$endereco = ucfirst($dados['entrega_endereco']). ", ".ucfirst($dados['entrega_numero']);
		if($dados['entrega_complemento']!=""){
			$endereco.= " ".ucfirst($dados['entrega_complemento']);
		}
		$endereco .=  " ".ucfirst( $dados['entrega_bairro'] ). ", ".ucfirst($dados['entrega_cidade']). " - ".strtoupper($dados['entrega_estado']). " - Cep: ".$dados['entrega_cep'];
	}
	echo utf8_decode($endereco) ;
 
}
  
function removeAcentos($string, $slug = false) {
    $string = strtolower($string);
    $ascii['a'] = range(224, 230);
    $ascii['e'] = range(232, 235);
    $ascii['i'] = range(236, 239);
    $ascii['o'] = array_merge(range(242, 246), array(240, 248));
    $ascii['u'] = range(249, 252);
    $ascii['b'] = array(223);
    $ascii['c'] = array(231);
    $ascii['d'] = array(208);
    $ascii['n'] = array(241);
    $ascii['y'] = array(253, 255);
    foreach ($ascii as $key=>$item) {
        $acentos = '';
        foreach ($item AS $codigo) $acentos .= chr($codigo);
        $troca[$key] = '/['.$acentos.']/i';
    }
    $string = preg_replace(array_values($troca), array_keys($troca), $string);
    if ($slug) {
        $string = preg_replace('/[^a-z0-9]/i', $slug, $string);
        $string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
        $string = trim($string, $slug);

    }
    return $string;
}

	
function geraBreadcrumb($idcategoria){ 
	  
	global $city,$INI,$ROOTPATH;
	$opcoesmenu="";
	 
	 $Breadcrumb =  ' 
		<li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="" class="breadcrumb-item home">
			<a itemprop="url" title="Home" href="'.$ROOTPATH.'" class="breadcrumb-link" onclick=""> <span itemprop="title">Home</span></a>
		</li> 
		';  
		$categoria  = Table::Fetch('category',$idcategoria);
		 
		If($categoria[idpai]<>0){ // é uma categoria filha, neste caso, mostra a categoria pai e avo 
			$categoriapai  = Table::Fetch('category',$categoria[idpai]); 
				
			If($categoriapai[idpai]<>0){
				$categoriaavo  = Table::Fetch('category',$categoriapai[idpai]); 
				$tituloseo =  removeAcentos(str_replace(" ","+",mb_strtolower($categoriaavo[name])));
				$opcoesmenu =  '
				<li itemtype="http://data-vocabulary.org/Breadcrumb"  class="breadcrumb-item">
						<a title="'.utf8_decode($categoriaavo['name']).'"   href='.$ROOTPATH.'/departamento/'.$tituloseo.'/'.$categoriaavo[id].' class="breadcrumb-link"><span itemprop="title">'.utf8_decode($categoriaavo['name']).'</span></a>
				</li> ';
			}
			
			$tituloseo =  removeAcentos(str_replace(" ","+",mb_strtolower($categoriapai[name])));
			 $opcoesmenu .=  '
			<li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="" class="breadcrumb-item">
					<a title="'.utf8_decode($categoriapai['name']).'"  itemprop="url" href='.$ROOTPATH.'/departamento/'.$tituloseo.'/'.$categoriapai[id].' class="breadcrumb-link"><span itemprop="title">'.utf8_decode($categoriapai['name']).'</span></a>
			</li> '; 
		}
		else{ // é apenas uma categoria pai 
			//$classauxini = '<h1 class="breadcrumb-main">';
			//$classauxfim = '</h1>';
			//$classcor= 'department-link';
		}
		$tituloseo =  str_replace(" ","+",mb_strtolower($categoria[name]));
		$opcoesmenu .=  '
		<li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="" class="breadcrumb-item">
				'.$classauxini.' <a title="'.utf8_decode($categoriaavo['name']).'"  itemprop="url" href='.$ROOTPATH.'/departamento/'.$tituloseo.'/'.$idcategoria.' class="breadcrumb-link '.$classcor.'" ><span itemprop="title">'.utf8_decode($categoria['name']).'</span></a>'.$classauxfim.'
		</li> ';
		 
		$Breadcrumb .= $opcoesmenu ; 
		echo $Breadcrumb; 
}

function buscaTituloAnuncio($team){ 
												
	$fabricante = mysql_query("SELECT id, nome FROM fabricante where id = '".$team['car_fabricante']."'");
	$row = mysql_fetch_array($fabricante);
	$fabricantecarro=$row['nome'];	
	
	$sql="SELECT nome FROM modelo WHERE id = '".$team['car_modelo']."'";
	$modelo = mysql_query($sql);
	$row = mysql_fetch_array($modelo);
    $modelocarro=$row['nome']; 
	$titulo = $fabricantecarro. " ".$modelocarro. " - Ano ".$team['car_ano']; 
	return $titulo;

}


function getCategoriasNavegacao(){
  	global $INI, $PATHSKIN, $_LANG; 
	
	$sql = "select * from category where tipo <> '' and imagemnavegacao = 'Y' and imagemcateg is not null and imagemcateg <> '' order by sort_order desc,id desc"; // tipo vazio é para categorias
	$rs = mysql_query($sql);
	 
	while($l = mysql_fetch_assoc($rs)){ 
	
		if($l['linkexterno']!=""){?>
			 <a target="<?=$l['target']?>" title="<?=$l['name']?>" href="<?=$l['linkexterno']?>"> </a>
		<?}
		 else{?>
			<a title="<?=$l['name']?>" href="<?=$ROOTPATH?>/index.php?page=categorias&idcategoria=<?=$l['id']?>&pagina=1&nome=<?=$l['name']?>"> <img src="<?=$INI['system']['wwwprefix']."/media/".$l['imagemcateg']?>"></a>
		<?}
	 } 	
	 
	$sql = "select * from partner where  imagemnavegacao = 'Y' and imagemparceiro is not null and imagemparceiro <> '' order by id desc";
	$rs = mysql_query($sql);
	 
	while($l = mysql_fetch_assoc($rs)){ 
	
		if($l['linkexterno']!=""){?>
			  <a target="<?=$l['target']?>" title="<?=$l['name']?>" href="<?=$l['linkexterno']?>"> </a> 
		<?}
		 else{?>
			 <a title="<?=$l['name']?>" href="<?=$ROOTPATH?>/index.php?page=parceiros&idparceiro=<?=$l['id']?>&pagina=1&nome=<?=$l['title']?>"> <img src="<?=$INI['system']['wwwprefix']."/media/".$l['imagemparceiro']?>"></a> 
		<?}
	 } 
}

function getLinkOferta($team){ 
	global $INI;   
	return $INI['system']['wwwprefix']."/produto/". $team['id']."/".urlamigavel( tratanome($team['title']));
}

function getimagemoferta($team){ 
	global $INI;   
	return   $INI['system']['wwwprefix']."/media/".substr($team['image'],0,-4)."_destaque.jpg";
}

$categoriasfilhasprod="";
function getcategoriafilhas($id_cat){ 

	 global $categoriasfilhasprod;   
	 $categoriasfilhasprod .= "'";
	$categoriasfilhasprod.= $id_cat."',"; 

	
	$sql = "select id from category where idpai=$id_cat and display = 'Y' order by sort_order desc";
	$rs  = mysql_query($sql); 
	
	while($l = mysql_fetch_assoc($rs)){ 
	
			 getcategoriafilhas($l["id"]);
	}   	  
}

function getnome($id){
	$user 	= Table::Fetch('user', $id);
 
	$nomes = explode(" ",$user['realname']); 
	return utf8_decode($nomes[0]);
}

function getpreco($preco){
	$precos = explode(",",number_format($preco,2, ',', '.'));
	return $precos[0];
}
function getdecimal($preco){
	$precos = explode(",",number_format($preco,2, ',', '.'));
	return $precos[1];
}

function avaliacaomedia($id){
	global $INI;

	$sql = "select avg(nota) avaliacaomedia from qualification where id_produto =".$id;
	$rs = mysql_query($sql);	
	$row = mysql_fetch_object($rs);

	return $row->avaliacaomedia ; 

}

function get_total_avaliacao_oferta($id){
	global $INI;

	$sql = "select count(id) total from qualification where id_produto =".$id;
	$rs = mysql_query($sql);	
	$row = mysql_fetch_object($rs);

	if($row->total==0){
		$txt = "Nenhuma avaliação, seja o primeiro a comentar";
	}	
	else if($row->total==1){
		$txt = "1 avaliação";
	}	
	else{
		$txt = $row->total." avaliações";
	}
	return $txt; 

}

function emailcontato(){
	global $INI;
	//print_r($_POST); 

	$table = new Table('feedback', $_POST); 
	$table->create_time = time();
	$table->category = RemoveXSS($_POST['request-type']);
	$table->title =  RemoveXSS($_POST['request-type']);
	$table->content =  RemoveXSS($_POST['user-comment']);
	$table->contact =  RemoveXSS($_POST['email']) ;
  
    $sql = "INSERT INTO `feedback` ( `user_id`, `category`, `title`, `contact`, `content`, `create_time`) VALUES
	(  '".$login_user_id."', '".$table->category."', '".htmlspecialchars($table->title)."', '".htmlspecialchars($table->contact)."', '".htmlentities($table->content)."', ".time().")";
	 mysql_query($sql); 
 
	if($INI['mail']['mail'] == "smtp"){
		$para = $INI['mail']['user'];  
	}
	else{
		$para = $INI['mail']['from'];
	}
	
		 //$parametros = array('id' => $reg[id]);
	   $parametros = $_POST;
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
		$body = file_get_contents($INI["system"]["wwwprefix"]."/templates/contato.php", false, $request);
		   
		
		 if(Util::postemailCliente($body,utf8_decode(ASSUNTO_CONTATO). " - ". $_POST['request-type'] ,$para )){
			Util::log($reg[id]." - emailcontato - Email para o cliente enviado ".$para); 
			return "OK";  
		 }
		else{
			Util::log($id. " - emailcontato - Erro no envio do email para ".$para);  
		}  
}

function email_pagamento_aprovado($id){
	global $INI,$ROOTPATH;
 	$order = Table::Fetch('order', $id); 
	$user = Table::Fetch('user', $order['user_id']);
	
    $parametros = array('id' => $id);
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
	$body = file_get_contents($ROOTPATH."/templates/confirmacao_pagamento.php", false, $request);

	if(Util::postemailCliente($body,"Sua compra foi confirmada",$user['email'])){
		Util::log($id. " - email_pagamento_aprovado - Email para o cliente enviado com sucesso ".$user['email']);  
	 }
	else{
		Util::log($id. " - email_pagamento_aprovado - Erro no envio do email para ".$user['email']);  
	}
	
 }
 
 
function envia_email_pedido_abandonado(){
	global $INI,$ROOTPATH;
	
	$sql = "SELECT * FROM `order` where DATEDIFF(NOW(),datapedido) > 4 and  state ='unpay'  and avisou is null ORDER by id desc limit 1";
	$rs = mysql_query($sql); 
	if(mysql_num_rows($rs) == 0 ){
		 Util::log($id. "envia_email_pedido_abandonado -  nao existem pedidos abandonados a mais de 4 dias para enviar emails - $sql");  
	}
	else{ 
		 Util::log($id. "envia_email_pedido_abandonado -  enviando email de carrinho abandonado para ".mysql_num_rows($rs)." - $sql");  
	 }
 
	while($reg = mysql_fetch_assoc($rs)){  
		$ssq = "update `order` set avisou = 'Y'  where id = ".$reg[id];
		mysql_query($ssq); 
		
		$parametros = array('id' => $reg[id]);
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
		$body = file_get_contents($INI["system"]["wwwprefix"]."/templates/confirmacao_pedido.php", false, $request);

		$user = Table::Fetch('user', $reg['user_id']); 
		
		 if(Util::postemailCliente($body,ASSUNTO_PEDIDO_AGUARDANDO_PAGAMENTO,$user['email'])){
			Util::log($reg[id]." - envia_email_pedido_abandonado - Email para o cliente enviado com sucesso ".$user['email']); 
				Table::UpdateCache('order', $reg[id], array( 
					'avisou' => array( "Y" ),
				)); 
				
		 }
		else{
			Util::log($id. " - envia_email_pedido_abandonado - Erro no envio do email para ".$user['email']);  
		}   
	}
}

function temsimilares($team_id){
	//$team_id =  $_SESSION['team_id'];

	$team 	= Table::Fetch('team', $team_id);
	$seo_keywords = explode(",",trim($team['seo_keyword']));
	  
	foreach($seo_keywords as $value){
		$subquery.=" ( seo_keyword like '%".trim($value)."%' or title like '%".trim($value)."%' ) or";
	}  
	$subquery = substr($subquery, 0, -2);
	$where = array(" ( id <> $team_id ) and ( $subquery )   ",);	 
	 
	$order = " order by `sort_order` DESC, `id` DESC ";
	$teams = DB::LimitQuery('team', array('condition' => $where,'order' => "$order",));
		
	if($teams ){
		return $teams;
	}
	else{
		return false;
	}
}
function formatabanner($banner){
	global $ROOTPATH;
	$banner = str_replace("../../..",$ROOTPATH,$banner);
	return $banner;
	
}

function get_nomemetodo($idmetodo){
	$zonas_entrega 	= Table::Fetch('zonas_entrega', $idmetodo,'identific');
	return utf8_decode($zonas_entrega[nome]);
}
function get_valorfrete_manual($idmetodo){
	$zonas_entrega 	= Table::Fetch('zonas_entrega', $idmetodo,'identific');
	return number_format($zonas_entrega[valor_frete], 2, ',', '.');
}
function get_prazo_manual($idmetodo){
	$zonas_entrega 	= Table::Fetch('zonas_entrega', $idmetodo,'identific');
	return $zonas_entrega[prazo_entrega] ;
}
function eh_metodosistema($idmetodo){
	$zonas_entrega 	= Table::Fetch('zonas_entrega', $idmetodo,'identific');
	if($zonas_entrega[metododosistema]=="s"){
		return true;
	}
}
  
function busca_metodos_entrega($existe_frete){ 
  
	if($existe_frete){?>
	
		<div  class="metodos"> 
			<div style="margin-bottom: 7px;"><b style="font-size:15px"></b></div>
			<div style="float: left;"> 
			<? 
			$sql = "select *  from zonas_entrega where ativo='s' order by ordenacao desc";
			$rs  = mysql_query($sql); 
			if(mysql_num_rows($rs) == 0 ){
				 Util::log($id. "busca_metodos_entrega -  nao existem metodos de entrega ativos na tabela zonas_entrega - $sql");  
			}
			
			$primeiro = true;
			while($reg = mysql_fetch_assoc($rs)){ 
			
			$display="block";
			if($reg[metododosistema] =="s"){
				$display="none";
			}
			?> 
				<div style="display:<?=$display?>;" id="<?=$reg[identific]?>" data-prazo="<?=$reg[prazo_entrega]?>" data-valorfrete="<?=$reg[valor_frete]?>" data-titulo="<?=$reg[nome]?>" data-sistema="<?=$reg[metododosistema]?>"  class="metodos_entrega">
					<input <? if($primeiro){?> checked="checked" <? } ?> id="<?=$reg[identific]?>" value="<?=$reg[identific]?>"  type="radio"   name="modo_envio" onclick="altera_metodo_entrega(this.value);" style="width:20px;"> <?=$reg[nome]?>
					<span class='valorFrete_<?=$reg[identific]?>' style="left:0px;top:-10px;">  </span>  
					<span class='prazoentrega_<?=$reg[identific]?>' style="margin-bottom:-20px;"> </span>
				</div>
			<? 
			$primeiro = false;
			}  ?> 
			</div>
		</div>
		<?
		}	
	}
	
 function grava_status_entrega($txt,$idpedido){
		 
		global $INI;
 
		$DIR_LOGS = str_replace('\\','/',dirname(dirname(dirname(__FILE__))))."/pedido/logstatus";
	  
		$fp = fopen($DIR_LOGS."/".$idpedido.".txt", "a");
		$txt = tratanome($txt);
		if ($fp){
		
			fwrite($fp,date("d/m/Y H:i:s")." - ".$txt."\n");
			fclose($fp);
			chmod($DIR_LOGS."/".$idpedido.".txt", 0755);
		}
		else{
		
			$msg = "Nao foi possivel abrir o arquivo ".$DIR_LOGS."/".$idpedido.".txt para escrita";
			$msg .="<br>Texto: ".$txt;
			  
			//self::postemail($msg );
		} 	 
}
 
 function logStatusEntrega($idpedido){
		 
		global $INI,$ROOTPATH;
 
		$file  = $ROOTPATH."/pedido/logstatus/".$idpedido.".txt";
		$conteudo = file_get_contents($file);
		$cabecalho = "<h2>Histórico do Pedido ".$idpedido."</h2>--------------------------------------<br>";
		if(empty($conteudo)){
			$retorno = $cabecalho."O arquivo de histórico deste pedido está vazio." ;
		}
		else{
			$retorno = $cabecalho.nl2br($conteudo);
		}
		return utf8_encode($retorno);
}

function UpdatePoints($pts, $idusuario) {
	
	$sql = "update user set pontuacao = pontuacao + " . $pts . " where id = '" . $idusuario . "'";
	$rs = mysql_query($sql);
	$retorno = mysql_affected_rows();
	
	if($retorno >= 1) {
		Util::log("Pontos adicionados com sucesso . ".$idusuario); 
	} else {
		Util::log("Erro ao adicionar pontos do usuário: . ".$idusuario);
	}
}

function FiltroString($msg)
{
    $palavroes = array('caralho','filho da puta','viado','gay','bosta','merda','filho de uma puta',' puta','louco','arrombado',             
    'fdp','idiota','retardado','otario','otário','pqp','vsf');
    $num = count($palavroes);

    for ($i=0; $i<$num; $i++)
    {   
		$palavra=$palavroes[$i];
 
        $msg = str_ireplace($palavroes[$i],'*******',$msg);
 
    }
         
    return $msg;
}

function getSaldoComissao($id) 
{
	$sql = "SELECT sum(comissaosite) as 'saldo' FROM `order` WHERE partner_id = " . $id;
	$rs = mysql_query($sql);
	$saldo_devedor = mysql_fetch_assoc($rs);						
						
	$sql = "SELECT sum(valor) as 'valor' FROM `faturas` WHERE id_user = " . $id . " and status = 'pay'";
	$rs = mysql_query($sql);
	$credito = mysql_fetch_assoc($rs);	
	
	
	$SaldoComissao = $saldo_devedor['saldo'] . "#" . $credito['valor'] . "#";
	return $SaldoComissao;
	
}

function getSaldo($id) 
{
	$sql = "SELECT sum(comissaosite) as 'saldo' FROM `order` WHERE partner_id = " . $id;
	$rs = mysql_query($sql);
	$saldo_devedor = mysql_fetch_assoc($rs);						
						
	$sql = "SELECT sum(valor) as 'valor' FROM `faturas` WHERE id_user = " . $id . " and status = 'pay'";
	$rs = mysql_query($sql);
	$credito = mysql_fetch_assoc($rs);	
	
	$saldo = $saldo_devedor['saldo'] - $credito['valor'];
	
	return $saldo;
}

function EnvioFatura() {
	
	global $INI, $ROOTPATH;
	
	$data = date("Y-m-d");
	$data_hoje = strtotime(date("Y-m-d"));
	
	/* Busca a data da última verificação de faturas. */
	$sql = "select lembrete_fatura from home_config";
	$rs = mysql_query($sql);
	$data_fatura = mysql_fetch_assoc($rs);
	$lembrete_data = strtotime(date("Y-m-d", strtotime($data_fatura['lembrete_fatura'])));
	
	if($data_hoje > $lembrete_data) {

		$sqlF = "select id, id_user, data_geracao, data_lembrete from faturas where status = 'unpay'";
		$rsF = mysql_query($sqlF);
		
		while($faturas = mysql_fetch_assoc($rsF)) {
		
			if(empty($faturas['data_lembrete'])) {
				/* Caso nunca tenha sido enviado um email lembrando o usuário sobre as faturas. */
				$sqlV = "SELECT DATEDIFF('" . $data . "','" . $faturas['data_geracao'] . "') AS diferenca";
			}
			else {
				/* Caso o lembrete já tenha sido enviado uma outra vez, é verificado a data do último envio. */
				$sqlV = "SELECT DATEDIFF('" . $data . "','" . $faturas['data_lembrete'] . "') AS diferenca";
			}
			
			$rsV = mysql_query($sqlV);
			$row = mysql_fetch_assoc($rsV);
			
			if($row['diferenca'] >= $INI['system']['bill_check']) {
			
				$user = Table::Fetch('user', $faturas['id_user']);
				
				/* Para evitar enviar o mesmo email mais de uma vez para o usuário. */
				if(!(in_array($user['email'], $EmailsEnviados))) {
				
					$EmailsEnviados[] = $user['email'];
					
					/* Caso a diferença de intervalo de datas seja maior ou igual, o email com o lembrete é enviado. */
					$parametros = array('realname' => $user['realname']);
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
					$mensagem = file_get_contents($ROOTPATH."/templates/lembrete_fatura.php", false, $request);
					
					if(filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {					
						/* Após o envio do email, a data de envio é atualizada no banco. */
						if(enviar($user['email'] , $INI['system']['sitename']." - Faturas em aberto", $mensagem)) {
							
							$data_lembrete = date("Y-m-d H:i:s");
							$sql = "update faturas set data_lembrete = '" . $data_lembrete . "' where id = '" . $faturas['id'] . "'";
							$rs = mysql_query($sql);
							
							$sql = "update home_config set lembrete_fatura = '" . $data_lembrete . "'";
							$rs = mysql_query($sql);
						}
					}
				}
			}
		}
	}
}

function detectResolution() {
	
	$useragent=$_SERVER['HTTP_USER_AGENT'];

	if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
		return true;
	}
	else {
		return false;
	}
}

function mb_ucfirst($str, $encoding = "UTF-8", $lower_str_end = false) {
  $first_letter = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding);
  $str_end = "";
  if ($lower_str_end) {
	$str_end = mb_strtolower(mb_substr($str, 1, mb_strlen($str, $encoding), $encoding), $encoding);
  }
  else {
	$str_end = mb_substr($str, 1, mb_strlen($str, $encoding), $encoding);
  }
  $str = $first_letter . mb_strtolower($str_end);
  return $str;
}

function dateTime($date = null) {

	setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
	date_default_timezone_set('America/Sao_Paulo');

	$diaH = date('d');
	$mesH = date('m');
	$anoH = date('Y');

	$horaH = date('H');
	$minH = date('i');
	$segH = date('s');

	$ano = date("Y", strtotime($date));
	$mes = date("m", strtotime($date));
	$dia = date("d", strtotime($date));

	$hora = date("H", strtotime($date));
	$min = date("i", strtotime($date));
	$seg = date("s", strtotime($date));

	if ($anoH > $ano) {
		$anos = $anoH - $ano . ' anos atrás';
	} elseif ($mesH > $mes) {
		$meses = $mesH - $mes . ' meses atrás';
	} elseif ($diaH > $dia) {
		$dias = $diaH - $dia . ' dias atrás';
	} elseif ($horaH > $hora) {
		$horas = $horaH - $hora . ' horas atrás';
	} elseif ($minH > $min) {
		$mins = $minH - $min . ' minutos atrás';
	} elseif ($segH > $seg) {
		$segs = $segH - $seg . ' segundos atrás';
	} else {
		echo 'postado agora';
	}

	echo @$anos;
	echo @$meses;
	echo @$dias;
	echo @$horas;
	echo @$mins;
	echo @$segs;
}

function UrlAtual(){
	$dominio= $_SERVER['HTTP_HOST'];
	$url = "http://" . $dominio . $_SERVER['REQUEST_URI'];
	return $url;
}


function setUrl(){
	$dominio= $_SERVER['HTTP_HOST'];
	$url = "http://" . $dominio . $_SERVER['REQUEST_URI'];
	$_SESSION['referer'] = $url;
}

function getUrl(){
	if(isset($_SESSION['referer'])){
		return $_SESSION['referer'];
	}else{
		return $ROOTPATH;
	}
}

function optionsItem($team_id, $id_option, $options = null) {
	
	if(is_array($options) && !(empty($options))) {
		
	   $insert = array('stock', 'size', 'color', 'team_id');
			
		foreach($options as $option) {

			$table = new Table('options');		
			$count = count($option);
			
			if($count == 3) {
			
				$table->team_id = $team_id;
				$table->stock = $option[0];
				$table->size = $option[1];
				$table->color = $option[2];
				
				/* Grava novo registro */
				$table->insert($insert);
			}
			else {
				
				$table->team_id = $team_id;
				$table->stock = $option[1];
				$table->size = $option[2];
				$table->color = $option[3];
				
				/* Atualiza registro */
				$table->SetPk('id', $option[0]);				
				$table->update($insert);
			}
		}
	}
}

function checkStock($id_team, $id_option = null) {
	
	if(!(empty($id_option))) {
		$sql_o = "select count(id) as stock from options where id = " . $id_option . " and stock >= 1";
	}
	else {
		$sql_o = "select count(id) as stock from options where team_id = " . $id_team . " and stock >= 1";
	}
	
	$rs_o = mysql_query($sql_o);
	$row_o = mysql_fetch_assoc($rs_o);
	
	return $row_o['stock'];
}


function stock($id_team) {
	
	$sql_o = "select sum(stock) as stock from options where team_id = " . $id_team . " and stock >= 1";
	$rs_o = mysql_query($sql_o);
	$row_o = mysql_fetch_assoc($rs_o);
	
	return $row_o['stock'];
}

function lista_filhos_categoria($id_categoria) {
	
	$sql = "select id, name from category where idpai = " . $id_categoria . " and display = 'Y' order by sort_order desc";
	$rs = mysql_query($sql); 

	while($categorie = mysql_fetch_assoc($rs)) {
?>
	<option value="<?php echo $categorie['id']; ?>">
		... <?php echo utf8_decode($categorie['name']); ?>
	</option>
<?php
	}
}
?>