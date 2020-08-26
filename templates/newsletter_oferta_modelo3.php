 <?php
 	 
	$limiteofertasemail = 8;  
   
	require_once(dirname(dirname(__FILE__)). '/app.php');
	require_once(dirname(dirname(__FILE__)). '/include/get_ofertas.php');
	$page = Table::Fetch('page', 'about_us');
	    
	$sobre = $page['value'];
	 
	/*Buscando os dados da oferta para envio*/
		$origem = "produto";
		$team = Table::Fetch('team', $_REQUEST['idoferta']); 
	/****************************************/
	    
	$economia = str_replace(".",",",number_format($team['market_price'] - $team['team_price'],2)) ;
  
  $nomesite = htmlentities($INI['system']['sitename'],ENT_COMPAT,'UTF-8');
  if($INI['other']['color_fundo_news'] ==""){
	   $INI['other']['color_fundo_news'] ="#004040";
	}
 ?>
<html><head>
<style type="text/css">
 
.titulo {
	color: #fff;
	font-family:sans-serif;
	font-size:21px;
}
 
</style>
</head><body><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="pt-br" />
 
 

<table align="center" border="0" cellpadding="0" cellspacing="0" width="700">  <tbody><tr>    <td align="center" bgcolor="#195D9E" height="10"></td>  </tr>
</tbody></table>

<table align="center" bgcolor="#195D9E" border="0" cellpadding="0" cellspacing="6" width="700">
  <tbody><tr>
    <td align="center" valign="middle" width="36%"><a href="<?=$INI['system']['wwwprefix']?>" target="_blank">
    <!-- ********** LOGO DO SITE ********** -->
    <img  style="max-width:251px;" src="<?=$INI['system']['wwwprefix']?>/include/logo/logo.png">
    <!-- ********** FIM LOGO DO SITE**********  -->
    </a></td>
    <td style="color: rgb(255, 255, 255); font-family: Tahmoma; font-size: 23px; font-weight: bold;" align="right" width="64%"><p align="center"><span class="titulo">Nossas melhores ofertas<BR>Corra que é só hoje!<br>
    </span> </p>

</td>
  </tr>
  <tr>
    <td height="2"></td>
    <td align="right"></td>
  </tr>
</tbody></table>
<table align="center" bgcolor="#ffffff" border="0" cellpadding="10" width="700">
  <tbody><tr>
    <td width="363" height="293" style="border-bottom:1px solid #eee;">
    <a href="<?php echo $INI['system']['wwwprefix']; ?>/<?=$origem?>/<?php echo $team['id']; ?>&c=maillist"   title="<?php echo utf8_decode($team['title']); ?>"><img src="<?php echo team_image($team['image']); ?>" alt="<?php echo utf8_decode($team['title']); ?>" width="364" style="border:none;" title="<?php echo utf8_decode($team['title']); ?>" /></a>
    </td>
    <td valign="top" width="295" style="border-left:1px solid #eee;border-bottom:1px solid #eee;">
	<table style="color: rgb(51, 51, 51); font-family: sans-serif; font-size: 14px;text-align:center;" border="0" cellpadding="0" cellspacing="0" width="100%">
      <tbody><tr>
	<td style="color: rgb(51, 51, 51); font-family: sans-serif,Times,serif; font-size: 18px;" height="51" valign="top"><?php echo  htmlentities($team['title'],ENT_COMPAT,'UTF-8');   ?><br></td>
      </tr>  
		  <tr>
			<td><strong>De: </strong><span style="color: rgb(255, 0, 0); font-size: 17px; text-decoration: line-through;">R$ <?php echo moneyit3($team['market_price']); ?></span></td>
		  </tr>
		  <tr>
			<td><strong>Por: </strong><span style="color: rgb(0, 51, 51); font-family: sans-serif; font-size: 31px; font-weight: bold;">R$ <?php echo moneyit3($team['team_price']); ?></span></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center"><a title="<?php echo utf8_decode($team['title']); ?>" href="<?=$INI['system']['wwwprefix']?>/<?=$origem?>/<?=$team['id']; ?>" target="_blank"><img src="<?=$INI['system']['wwwprefix']?>/skin/padrao/images/comprar_orange.png" border="0"></a></td>
		  </tr>
		  <tr>
			<td align="center"><p style="font-family: Tahoma;"><strong> Uma economia de<br>R$ <?php echo $economia ?></strong></p>
			  <p style="font-family: Tahoma;"><strong><span style="font-family: Tahoma; font-size: xx-large;"><?php echo moneyit2((100*($team['market_price'] - $team['team_price'])/$team['market_price'])); ?>%</span></strong><br>
				de desconto
			  </p></td>
		  </tr>  
    </tbody></table>
    </td>
  </tr>
</tbody></table>

<!-- OUTRAS OFERTAS -->

<table align="center" bgcolor="#ffffff" border="0" cellpadding="10" width="700">
  <tbody>
    <tr>
	<? 
	$hoje = time();
	$consulta = "SELECT * FROM team where id <> ".$_REQUEST['idoferta']."  	 LIMIT 4";
	$resultado = mysql_query($consulta);
	$cont=0;
	while ($team = mysql_fetch_assoc($resultado)){
		$cont++;
		if($cont==3){ echo "<tr>";}
	?> 
		<td width="363" height="195" style="border-bottom:1px solid #eee;">
			<a href="<?php echo $INI['system']['wwwprefix']; ?>/<?=$origem?>/<?php echo $team['id']; ?>&c=maillist"   title="<?php echo utf8_decode($team['title']); ?>"><img src="<?php echo team_image($team['image']); ?>" alt="<?php echo utf8_decode($team['title']); ?>" width="280" style="border:none;" title="<?php echo utf8_decode($team['title']); ?>" /></a>
			<div  style="width: 282px; font-family: sans-serif; margin-top: 4px;"><?php echo utf8_decode($team['title']); ?></div>
			<div style="font-family: sans-serif; float: left; margin-right: 41px;">
			<strong>
				<span style="font-family:Tahoma; font-size: 25px;color: #195D9E;">
				 R$ <?php echo moneyit3($team['team_price']); ?>
				</span>
			</strong> 
			</div>
			<div><strong><span style="font-family: Tahoma; font-size: 23px;"><?php echo moneyit2((100*($team['market_price'] - $team['team_price'])/$team['market_price'])); ?>%</span></strong><br>
				 de desconto
			</div>
		</td> 
		
	<? 
		if($cont==4){ echo "</tr>";}
	} 
	?>
  </tr> 
</tbody>
</table>


<table align="center" border="0" cellpadding="0" cellspacing="0" width="700">  <tbody>
  <tr>    <td align="center" bgcolor="#195D9E" height="2"></td>  
    </tr>
</tbody></table>
 
<table align="center" border="0" cellpadding="0" cellspacing="0" width="700">  
  <tbody><tr>    <td align="center" bgcolor="#195D9E" height="70"><p><span style="color: rgb(255, 255, 255); font-family: sans-serif; font-size: 17px;">
    <?=$nomesite?> 
    - Todos os direitos reservados </span></p>
        <p style="color:#FFF;font-family: sans-serif;font-size: 13px;">Caso n&atilde;o queira mais receber ofertas do <?php echo $INI['system']['abbreviation']; ?>, voc&ecirc; pode <a href="<?php echo $INI['system']['wwwprefix']; ?>/cancelarinscricao.php?code=<?php echo $_REQUEST['secret']; ?>" style="" title="Cancelar newsletter"><font color="#FFCC00">descadastrar</font></a> a qualquer momento.</p></td>  
</tr>
</tbody></table>
</body></html>