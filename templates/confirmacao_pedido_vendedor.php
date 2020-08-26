 <?php 
 
	require_once(dirname(dirname(__FILE__)). '/app.php');  
    $idpedido 	 	= $_REQUEST['id'];  
	$nomesite = htmlentities($INI['system']['sitename'],ENT_COMPAT,'UTF-8'); 
	
	 $order 	= Table::Fetch('order', $idpedido);
	 $user 		= Table::Fetch('user', $order[user_id]);
	 $vendedor  = Table::Fetch('user', $order['partner_id']); 
	 $items = mysql_query("SELECT * FROM order_team WHERE order_id = ".$idpedido); 
	
	$codigovalecompras 	= $order[codigovalecompras];
	$valorcupomdesconto  = $order[valecompras];
	if(!$valorcupomdesconto){
		$valorcupomdesconto=0;
	}
	
 
 ?>
<html><head></head><body><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Content-Language" content="pt-br" />
<style>
.maisOfertas {
     
    display: block;
    font-family: "Arial";
    font-size: 14px;
    overflow: hidden;
    width: 213;
    color: #303030;
	font-family:verdana;
	font-size:16px;
	margin-left:17px; 
}

.boxfundo {
	-moz-border-radius: 10px 10px 10px 10px;
	background: none repeat scroll 0 0 #FFF;
	border: 1px solid #E8E8E8;
	padding: 10px;
	}
	
</style>
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td style="padding: 20px;" name="tid" description="mediumBgcolor" >
<div style="padding: 0px; margin: 0px;">
<table style="font-family: 'Verdana';" width="80%" align="center" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td colspan="5" >&nbsp;</td>
</tr>
<tr>
<td>
<table width="80%" border="0" cellpadding="0" cellspacing="0">
<tbody>
 
<tr bgcolor="#ffffff">
<td valign="top" align="left" bgcolor="#ffffff"></td>
 
<td></td>
</tr>
 
</tbody>
</table>
</td>
</tr>
<tr>
<td style="padding: 10px 30px;" bgcolor="#ffffff">
<table width="100%" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">
<tbody>
<tr style="font-size: 16px;   color: #303030; padding: 2px 0px; margin: 0px; font-family: 'Verdana';">
<td style="padding: 0px 20px 0px 0px;" valign="top" width="57%">
<h1 style="font-family: Helvetica, Arial, sans-serif; font-weight: normal; letter-spacing: -1px; color: #0099ff; font-size: 28px; line-height: 26px; padding: 2px 0px; margin: 0px;" name="tid" description="darkColor"><img style="max-width:223px;"  src="<?=$ROOTPATH?>/include/logo/logo.png" alt="<?=$nomesite?>"></h1>

<h1 style="font-family: 'Arial'; border-bottom: solid 1px #cccccc; padding: 5px 0px 5px 0px; margin: 0px; color: #0099ff; font-size: 16px; font-weight: bold; letter-spacing: -1px;" name="tid" description="darkColor">Estamos aguardando o pagamento do pedido</h1> 
 <div class="titulo" style="background:#0173C9; box-shadow: 2px 2px 4px 0 #888888;font-family: georgia;font-size: 24px; height: 28px; padding: 0px 12px 0;color:#FFF;margin-bottom:16px;">Segue os dados do pedido</div> 
 
<p><b>Dados do Pedido </b></p> 
<div class="maisOfertas boxfundo" style="width:94%;">
<p> <b>Pedido: <?= $idpedido ?></b></p> 
<p> <b>Nome:</b> <?=$user['realname']?></p> 
<p> <b>Email:</b> <?=$user['email']?></p> 
<p> <b><?=$user['recode']?>: </b> <?=$user['cpf']?></p> 
<br>
  
<table width="100%" class="coupons-table">
	<tr style="text-align: center;"><td colspan="5"><b style="font-size:12px;">Produtos do Pedido</b></td> </tr>		
	
	<tr></tr>
	<tr style="font-size:16px;">
		<td width="10%">Qtde</td>
		<td width="60%">Item</td>
		<td>Pre&ccedil;o</td>
		<td>Total</td>
		<td>Op&ccedil;&atilde;o</td>
	</tr>		
	<?php while ($item = mysql_fetch_array($items, MYSQL_ASSOC)) {			
			echo "<tr style='font-size:16px;'>";			
			echo "<td>{$item['team_qty']}</td>";			
			$team = mysql_fetch_object(mysql_query("SELECT * FROM team WHERE id = {$item['team_id']}"));			
			echo "<td>[".$team->codreferencia."] - ".$team->title."</td>";			
			echo "<td>$currency ".number_format($item['team_price'],2,",",".")."</td>";			
			echo "<td>$currency ".number_format($item['team_total'],2,",",".")."</td>";			
			echo "<td>{$item['condbuy']}</td>";			
			echo "</tr>";		
		}
		$valortotal = str2num($order['origin']) +str2num($order['valorfrete']);
		?>
 </table>
	 
<p> <b>Sub Total: </b> <?=$currency?> <?=number_format($order['origin'],2,",",".");?></p> 
<? if($codigovalecompras){?><p> <b>Cupom de desconto:</b> R$ <?=number_format($valorcupomdesconto, 2, ',', '.') ?></p> - ( <?=$codigovalecompras?> ) <? } ?>
	 						  
<? if($order['modo_envio']){?><p> <b>Frete: </b> <?=$currency?> <?=number_format($order['valorfrete'],2,",",".");?> - Prazo m&aacute;ximo de entrega: <?=$order['prazofrete']?> dia(s) &uacute;til ( <?=$order['modo_envio']?> ). A contar do pr&oacute;ximo dia &uacute;til ap&oacute;s a aprova&ccedil;&atilde;o do pagamento  </p> <? } ?>
<p> <b>Total: </b> <?=$currency?> <?=number_format($valortotal - $valorcupomdesconto,2,",",".") ;?></p> 
<BR>
<p> <b>Endere&ccedil;o de Entrega: </b></p> 
<p><? getEnderecoEntregaPedido_template($order['id'],$order['user_id']);?></p> 
<br>
<b>Valor total do pedido: R$  <?= number_format($valortotal - $valorcupomdesconto,2,",","."); ?></b></p>
<p>Status:  <B style="color:red">N&Atilde;O PAGO</B></p> 

</div>
<div style="border-botton:1px solid #eee;"></div> 
<p>Assim que recebermos o pagamento, voc&ecirc; receber&aacute; um email de confirma&ccedil;&atilde;o. Após receber este email, envie o produto do seu cliente. </p>
<p>Boas vendas !</p>
<p><b>Equipe <?=$nomesite?></b></p>
 
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td>
<table style="padding: 0px;" width="100%" border="0" cellpadding="0" cellspacing="0">
<tbody>
<tr bgcolor="#ffffff">
<td></td>
<td style="padding: 5px 15px;">
</td>
<td></td>
</tr>
 
<tr>
<td colspan="3" style="padding: 0px;" >
<p style="font-family: Verdana; font-size: 10px; color: #ffffff; text-align: center;" align="center">
  <?=$nomesite?> - Todos os direitos reservados
  <br /> 
  </p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</div>
</td>
</tr>
</tbody>
</table></body></html>