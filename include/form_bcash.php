<?
require_once(dirname(dirname(__FILE__)) . '/app.php');

$order = Table::Fetch('order', $_REQUEST['idpedido']);
$idpedido		= $order['id']; 
$valorfrete =  $order[valorfrete];	
	
?>

<form name="bcashtransparente" id="bcashtransparente"  method="post"  action="https://www.bcash.com.br/checkout/pay/">
<input name="email_loja" type="hidden" readonly="readonly" value="<?php echo $INI['pagamentodg']['acc']; ?>">  
	
<? 
/**********************************************************************************************/
	$items = mysql_query("SELECT * FROM order_team WHERE order_id = ".$idpedido);
/**********************************************************************************************/

 $con=0;   
while ($item = mysql_fetch_array($items, MYSQL_ASSOC)) {
	$con++;  
	$team = Table::Fetch('team', $item['team_id']);
?> 
	 
<input id="produto_codigo_<?=$con?>" name="produto_codigo_<?=$con?>" type="hidden" readonly="readonly" value="<?php echo  $team[id] ; ?>">
<input id="produto_descricao_<?=$con?>"  name="produto_descricao_<?=$con?>" type="hidden" readonly="readonly" value="<?=utf8_decode(displaySubStringWithStrip($team['title'], 90)) ?>">
<input id="produto_qtde_<?=$con?>" name="produto_qtde_<?=$con?>" type="hidden" readonly="readonly" value="<?php echo $item['team_qty'] ?>">
<input id="produto_valor_<?=$con?>" name="produto_valor_<?=$con?>" id="produto_valor_1" type="hidden" readonly="readonly" value="<?php echo  number_format($team['team_price'], 2, ',', '.');	 ?>" >
<? } ?>

<input name="tipo_integracao" type="hidden" readonly="readonly" value="PAD">
<!-- opcionais -->
<input id="id_pedido" name="id_pedido" type="hidden" readonly="readonly" value="<?=$idpedido?>">
<input   name="email" type="hidden" readonly="readonly" value="<?=$login_user['email']?>">
<input   name="nome" type="hidden" readonly="readonly" value="<?=$login_user['realname']?>">
<input   name="cpf" type="hidden" readonly="readonly" value="<?=$login_user['cpf']?>">
<input   name="telefone" type="hidden" readonly="readonly" value="<?=$login_user['mobile']?>">
<input   name="endereco" type="hidden" readonly="readonly" value="<?=$login_user['address']?>">
<input   name="bairro" type="hidden" readonly="readonly" value="<?=$login_user['bairro']?>">
<input   name="cidade" type="hidden" readonly="readonly" value="<?=$login_user['cidadeusuario']?>">
<input   name="estado" type="hidden" readonly="readonly" value="<?=$login_user['estado']?>">
<input  name="cep" type="hidden" readonly="readonly" value="<?=$login_user['zipcode']?>">  


<input name="frete" type="hidden" readonly="readonly"   value="<?=$_REQUEST['valorfrete']?>" > 
<input name="url_retorno" type="hidden" readonly="readonly" value="<?php echo $INI['system']['wwwprefix']?>/pedido/pagamentodg/retorno.php"> 
<input name="url_aviso" type="hidden" value="<?php echo $INI['system']['wwwprefix']?>/pedido/pagamentodg/retorno.php">
<input name="redirect" type="hidden" value="true">
                                                                   
</form>
<script>
	document.bcashtransparente.submit();
</script>