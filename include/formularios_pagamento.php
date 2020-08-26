 <? 
	$idpedido		= $order['id']; 
	$valorfrete =  $order[valorfrete];	
	$valor_original = number_format($order['origin'], 2, ',', '.'); // dependendo do gateway, o valor total é calcula diretamente nele, com o valor da oferta + quantidade
   
	$nomes 		= explode(" ",utf8_decode($login_user['realname']));
	$nome 		= $nomes[0];
	$sobrenome 	= $nomes[1]. " ".$nomes[2]. " ".$nomes[3]. " ".$nomes[4];
	 
	/**********************************************************************************************/
		$items = mysql_query("SELECT * FROM order_team WHERE order_id = ".$idpedido);
	/**********************************************************************************************/
	 
 ?>
<div style="display:none;" class="tips"><?=__FILE__?></div>
<?
if($INI['pagseguro']['novaapi']=="1"){
	
	if($idpedido){
		require_once(WWW_ROOT.'/util/apipagseguro/createPaymentRequest.php');
	}
}
else {  

	if($INI['pagseguro']['acc'] != ""){?>
		<!-- :::::::::::::::::::: formulario de pagamento PAGSEGURO ::::::::::::: -->
		<? if($INI['pagseguro']['transparente']=="" or $INI['pagseguro']['transparente']=="0"){?> <!-- nao usa o pagamento transparente. Usa o pagamento html tradicional-->
			<form id="pagseguro" name="pagseguro"  method="post" sid="<?php echo $team_id; ?>" action="https://pagseguro.uol.com.br/checkout/checkout.jhtml">
			<input type="hidden" readonly="readonly" name="email_cobranca" value="<?php echo $INI["pagseguro"]["acc"]; ?>">
			<input type="hidden" readonly="readonly" name="tipo" value="CP">
			<input type="hidden" readonly="readonly" name="moeda" value="BRL">
			<input type="hidden" readonly="readonly" id="ref_transacao" name="ref_transacao" value="<?php echo  $idpedido; ?>">
			<input type="hidden" readonly="readonly" id="reference" name="reference" value="<?php echo  $idpedido; ?>">
			<?  $con=0;   
			while ($item = mysql_fetch_array($items, MYSQL_ASSOC)) {
				$con++;  
				$team = Table::Fetch('team', $item['team_id']); ?> 
		 
				<input type="hidden" readonly="readonly" id="item_id_<?=$con?>" name="item_id_<?=$con?>" value="<?php echo  $team[id] ; ?>">
				<input type="hidden" readonly="readonly" id="item_descr_<?=$con?>" name="item_descr_<?=$con?>" value="<?=utf8_decode(displaySubStringWithStrip($team['title'], 90)) ?>">
				<input type="hidden" readonly="readonly" id="item_quant_<?=$con?>" name="item_quant_<?=$con?>" value="<?php echo $item['team_qty'] ?>">
				<input type="hidden" readonly="readonly" id="item_valor_<?=$con?>" name="item_valor_<?=$con?>" value="<?php echo  number_format($item['team_price'], 2, ',', '.');	 ?>">
				<input type="hidden" readonly="readonly" name="item_peso_<?=$con?>" value="<?=$team['peso']?>"> 
				 
			<? } ?> 
			<? if($cupomdesconto){?>
				  <input type="hidden" readonly="readonly" name="extraAmount" value="-<?=$valorcupomdesconto?>"> <!-- valor de desconto a ser concedido deve ser NEGATIVO -->
			<? } ?>
				
			<!-- <input type="hidden" readonly="readonly" name="extraAmount" value="-10.00"> --> 
		 
				<input type="hidden" readonly="readonly" name="item_frete_1" value="<?=$valorfrete?>"> 
				<input type="hidden" readonly="readonly" name="tipo_frete" value="<?=$tipofrete?>">
			 
			  <!-- Dados do comprador (opcionais) -->  
			<input type="hidden" name="senderName" value="<?=$login_user['realname']?>">  
			<input type="hidden" name="senderEmail" value="<?=$login_user['email']?>">   
			   
			<input type="hidden" name="shippingType" value="1">  
			<input type="hidden" name="shippingAddressPostalCode" value="<?=$login_user['zipcode']?>">  
			<input type="hidden" name="shippingAddressStreet" value="<?=$login_user['address']?>">      
			<input type="hidden" name="shippingAddressDistrict" value="<?=$login_user['bairro']?>">  
			<input type="hidden" name="shippingAddressCity" value="<?=$login_user['cidadeusuario']?>">  
			<input type="hidden" name="shippingAddressState" value="<?=$login_user['estado']?>">  
			<input type="hidden" name="shippingAddressCountry" value="BRA">  
			<!-- Dados do comprador (opcionais) -->    
			<input type="hidden" name="senderPhone" value="<?=$login_user['mobile']?>">   
			</form>
	<? }
		else{ // usando o pagamento pagseguro transparente (obs: a conta do cliente deve ser autorizada no pagseguro)
			//$valorpagsegurotrans = str_replace(".","",$valor_original);		
			//$valorpagsegurotrans = str_replace(",",".",$valorpagsegurotrans);?>
			
			<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script> 
			<form target="pagseguro" method="post"    id="formulario" action="https://pagseguro.uol.com.br/v2/checkout/payment.html" onsubmit="PagSeguroLightbox(this); return false;">
			
			<input type="hidden" readonly="readonly" name="receiverEmail" value="<?php echo $INI["pagseguro"]["acc"]; ?>">
			<input type="hidden" readonly="readonly" name="tipo" value="CP">
			<input type="hidden" readonly="readonly" name="currency" value="BRL">
			<input type="hidden" readonly="readonly" id="ref_transacao" name="ref_transacao" value="<?php echo  $idpedido; ?>">
			<input type="hidden" readonly="readonly" id="reference" name="reference" value="<?php echo  $idpedido; ?>">
			
			<?  $con=0;   
			while ($item = mysql_fetch_array($items, MYSQL_ASSOC)) {
				$con++;  
				$team = Table::Fetch('team', $item['team_id']); 
				$valorpagsegurotrans = number_format($item['team_price'], 2, ',', '.');		
				$valorpagsegurotrans = str_replace(".","",$valorpagsegurotrans);		
				$valorpagsegurotrans = str_replace(",",".",$valorpagsegurotrans);	
				?> 
		  
				<input type="hidden" readonly="readonly" id="itemId<?=$con?>" name="itemId<?=$con?>" value="<?=$team[id]?>">
				<input type="hidden" readonly="readonly" id="itemDescription<?=$con?>" name="itemDescription<?=$con?>" value="<?=utf8_decode(displaySubStringWithStrip($team['title'], 90)) ?>">
				<input type="hidden" readonly="readonly" id="itemQuantity<?=$con?>" name="itemQuantity<?=$con?>" value="<?php echo $item['team_qty'] ?>">
				<input type="hidden" readonly="readonly" id="itemAmount<?=$con?>" name="itemAmount<?=$con?>" value="<?php echo $valorpagsegurotrans;	 ?>"> 
				<input type="hidden" readonly="readonly" name="itemWeight<?=$con?>" value="0"> 
				
			<? } ?>
			  
				<input type="hidden" readonly="readonly" name="item_frete_1" value="<?=$valorfrete?>"> 
				<input type="hidden" readonly="readonly" name="tipo_frete" value="<?=$tipofrete?>">
		 
			
			  <!-- Dados do comprador (opcionais) -->  
			<input type="hidden" name="senderName" value="<?=$login_user['realname']?>">  
			<input type="hidden" name="senderEmail" value="<?=$login_user['email']?>">  
			
				<!-- Informações de frete (opcionais) -->  
			<input type="hidden" name="shippingType" value="1">  
			<input type="hidden" name="shippingAddressPostalCode" value="<?=$login_user['zipcode']?>">  
			<input type="hidden" name="shippingAddressStreet" value="<?=$login_user['address']?>">      
			<input type="hidden" name="shippingAddressDistrict" value="<?=$login_user['bairro']?>">  
			<input type="hidden" name="shippingAddressCity" value="<?=$login_user['cidadeusuario']?>">  
			<input type="hidden" name="shippingAddressState" value="<?=$login_user['estado']?>">  
			<input type="hidden" name="shippingAddressCountry" value="BRA">  
			  
			<!-- Dados do comprador (opcionais) -->    
			<input type="hidden" name="senderPhone" value="<?=$login_user['mobile']?>">   
		</form> <? 
		}  
	}	
}
?>   
  
<!-- :::::::::::::::::::: formulario de pagamento BCASH ::::::::::::: -->
<?php  
 if($INI['pagamentodg']['acc'] != ""){  
	if($INI['pagamentodg']['transparente']=="" or $INI['pagamentodg']['transparente']=="0"){ // USA O PAGAMENTO TRADICIONAL. NAO USA O TRANSPARENTE?>
 
	<form name="pagamentodigital" id="pagamentodigital"  method="post" sid="<?php echo $team_id; ?>" action="https://www.pagamentodigital.com.br/checkout/pay/"  >
	<input name="email_loja" type="hidden" readonly="readonly" value="<?php echo $INI['pagamentodg']['acc']; ?>">
	
	<?  
	$con=0;   
	mysql_data_seek($items,0);
	while ($item = mysql_fetch_array($items, MYSQL_ASSOC)) {
		$con++;  
		$team = Table::Fetch('team', $item['team_id']); 
		$valorpagdigital = number_format($item['team_price'], 2, ',', '.');		
		//$valorpagdigital = str_replace(",",".",$valor); 	
	?>   
	<input id="produto_codigo_1" name="produto_codigo_1" type="hidden" readonly="readonly" value="<?=$team[id]?>">
	<input id="produto_descricao_1"  name="produto_descricao_1" type="hidden" readonly="readonly" value="<?=utf8_decode(displaySubStringWithStrip($team['title'], 90)) ?>">
	<input id="produto_qtde_1" name="produto_qtde_1" type="hidden" readonly="readonly" value="<?php echo $item['team_qty'] ?>">
	<input id="produto_valor_1" name="produto_valor_1" id="produto_valor_1" type="hidden" readonly="readonly" value="<?=$valorpagdigital?>" >
	 		
	<? } ?>
	
	<input name="tipo_integracao" type="hidden" readonly="readonly" value="PAD">
	<!-- opcionais -->
	<input id="id_pedido" name="id_pedido" type="hidden" readonly="readonly" value="<?php echo  $idpedido; ?>">
	<input   name="email" type="hidden" readonly="readonly" value="<?=$login_user['email']?>">
	<input   name="nome" type="hidden" readonly="readonly" value="<?=$login_user['realname']?>">
	<input   name="cpf" type="hidden" readonly="readonly" value="<?=$login_user['cpf']?>">
	<input   name="telefone" type="hidden" readonly="readonly" value="<?=$login_user['mobile']?>">
	<input   name="endereco" type="hidden" readonly="readonly" value="<?=$login_user['address']?>">
	<input   name="bairro" type="hidden" readonly="readonly" value="<?=$login_user['bairro']?>">
	<input   name="cidade" type="hidden" readonly="readonly" value="<?=$login_user['cidadeusuario']?>">
	<input   name="estado" type="hidden" readonly="readonly" value="<?=$login_user['estado']?>">
	<input  name="cep" type="hidden" readonly="readonly" value="<?=$login_user['zipcode']?>">  

	<input name="frete" type="hidden" readonly="readonly" value="<?=$valorfrete?>"> 
	<input name="url_retorno" type="hidden" readonly="readonly" value="<?php echo $INI['system']['wwwprefix']?>/pedido/pagamentodg/retorno.php"> 
	<input name="url_aviso" type="hidden" value="<?php echo $INI['system']['wwwprefix']?>/pedido/pagamentodg/retorno.php">
	<input name="redirect" type="hidden" value="true">
																	   
	</form> 
<? }
	else{ ?>
		<!-- :::::::::::::::::::: formulario de pagamento BCASH TRANSPARENTE ::::::::::::: -->
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
		<html>
		<header>
		<title>Realização do Pagamento</title>  
		<script type="text/javascript" src="<?=$ROOTPATH?>/js/fancybox/source/jquery.fancybox.js?v=2.1.5" ></script>
		<link rel="stylesheet" href="<?=$ROOTPATH?>/js/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="all">  
		</header>
		<body>          
		<a id="link_payment" class="iframe_bcash" data-fancybox-type="iframe" href="<?=$ROOTPATH?>/include/form_bcash.php?idpedido=<?=$idpedido?>"></a>
		<script> 
			J(".iframe_bcash").fancybox({
			fitToView : false,
			width : 970,
			height : 700,
			autoSize : false,
			closeClick : false,
			openEffect : 'none',
			closeEffect : 'none'
			});  
		</script> 
	<? }  
	}
?>

<!-- :::::::::::::::::::: formulario de pagamento MOIP ::::::::::::: -->
<?php if($INI['moip']['mid'] != ""){  ?>
	<form id="moip" name="moip" method="post" action="https://www.moip.com.br/PagamentoMoIP.do" sid="<?php echo $team_id; ?>">
	<input type='hidden' readonly="readonly" id='id_carteira' name='id_carteira' value='<?php echo $INI['moip']['mid']; ?>'>
	<input type='hidden' readonly="readonly" id='id_transacao' name='id_transacao' value='<?php echo $idpedido; ?>'>

	<?  
	$con=0;   
	mysql_data_seek($items,0);
	while ($item = mysql_fetch_array($items, MYSQL_ASSOC)) {
		$con++;  
		$team = Table::Fetch('team', $item['team_id']); 
	 
		$valor = number_format($item['team_price'], 2, ',', '.');	
		$valor = str2num($valor) +  str2num($valorfrete);
		$valor = number_format($valor,2);
		$valor = str_replace(",","",$valor); 
		$valor = str_replace(".","",$valor);
		?>    	
		<input type='hidden' readonly="readonly" id='valor' name='valor' value='<?php echo  $valor  ?>'>
		<input type='hidden' readonly="readonly" id='nome' name='nome' value='<?=utf8_decode(displaySubStringWithStrip($team['title'], 90)) ?>'>
		<input type='hidden' readonly="readonly" id='descricao' name='descricao' value=''>

	<? } ?> 
	</form>
<? } ?>

<!-- :::::::::::::::::::: formulario de pagamento cartao de credito::::::::::::: 
<?php if($INI['credito']['pay'] == "1"){  ?>
<form id="cartaocredito" name="cartaocredito" method="post" action="<?=$ROOTPATH?>/index.php?page=pagamentocc">
	<input type='hidden' readonly="readonly" id='valor' name='valor' value='<?php echo  str_replace(",","",$valor_original) ;  ?>'>
	<input type="hidden" readonly="readonly" name="pedido" value="<?php echo $idpedido; ?>">
	<input type="hidden" readonly="readonly" name="team_id" value="<?php echo $team_id; ?>">
</form>
<? } ?>
 -->

 <!-- :::::::::::::::::::: formulario de pagamento PAYPAL ::::::::::::: -->
<?php if($INI['paypal']['mid'] != ""){  ?>
 
 <form action="https://www.paypal.com/cgi-bin/webscr"  id="paypal" name="paypal" method="post">
 
	<input type="hidden" readonly="readonly" name="cmd" value="_xclick">
	<input type="hidden" readonly="readonly" name="lc" value="<?php echo $INI['paypal']['loc']; ?>"> 
	<input type="hidden" readonly="readonly" name="business" value="<?php echo $INI['paypal']['mid']; ?>">
	<?  
	$valorfretep = str_replace(",",".",$valorfrete);
	$con=0;   
	mysql_data_seek($items,0);
	while ($item = mysql_fetch_array($items, MYSQL_ASSOC)) {
		$con++;  
		$team = Table::Fetch('team', $item['team_id']); 
		
		$valor  = number_format($item['team_price'], 2, ',', '.');	
		$valor = str_replace(",",".",$valor);
		$valor_paypal = $valor * $item['team_qty'] ;
	
	?>  
	<input type="hidden" readonly="readonly" id="item_name_<?=$con?>" name="item_name" value="<?=utf8_decode(displaySubStringWithStrip($team['title'], 90)) ?>">
	<input type="hidden" readonly="readonly" id="item_number_<?=$con?>" name="item_number" value="<?=$team[id]?>">
	<input type="hidden" readonly="readonly" id="amount_<?=$con?>" name="amount" value="<?php echo $valor_paypal ?>">
	
	<? } ?>
	<input type="hidden" readonly="readonly"  name="shipping" value="<?=$valorfretep?>">
	<input type="hidden" readonly="readonly" name="first_name" value="<?=$nome?>">
	<input type="hidden" readonly="readonly" name="last_name" value="<?=$sobrenome?>">
	<input type="hidden" readonly="readonly" name="address1" value="<?=$login_user['address']?>">
	<input type="hidden" readonly="readonly" name="address2" value="<?=$login_user['bairro']?>">
	<input type="hidden" readonly="readonly" name="city" value="<?=$login_user['cidadeusuario']?>">
	<input type="hidden" readonly="readonly" name="tax_id" value="<?=$login_user['cpf']?>">
	<input type="hidden" readonly="readonly" name="state" value="<?=$login_user['estado']?>">
	<input type="hidden" readonly="readonly" name="zip" value="<?=$login_user['zipcode']?>">
	<input type="hidden" readonly="readonly" name="H_PhoneNumber" value="<?=$login_user['mobile']?>">
	<input type="hidden" readonly="readonly" name="email" value="<?=$login_user['email']?>">
	<INPUT TYPE="hidden" readonly="readonly" NAME="return" value="<?php echo $INI['system']['wwwprefix']?>/pedido/paypal/retorno.php">  
	<input type="hidden" readonly="readonly" name="currency_code" value="<?php echo $INI['paypal']['loc']; ?>"> 
	 
	<input type="hidden" readonly="readonly" name="rm" value="2" /> 
	<input type="hidden" readonly="readonly" name="notify_url" value="<?php echo $INI['system']['wwwprefix']?>/pedido/paypal/retorno.php" /> 
	<input type="hidden" readonly="readonly" name="transaction_subject" value="<?=utf8_decode(displaySubStringWithStrip($team['title'], 90)) ?>" />
 
</form>
<? } ?>

<!-- :::::::::::::::::::: formulario de pagamento DINHEIRO MAIL ::::::::::::: -->
<?php if($INI['dinheiro']['mid'] != ""){  ?>
 

	<form action="https://checkout.dineromail.com/CheckOut" id="dinheiro" name="dinheiro"  method="post" >
	<!--Sale settings-->
	<input type="hidden" name="tool" value="cart" />
	<input type="hidden" name="merchant" value="<?php echo $INI['dinheiro']['mid']; ?>" /> 
	<input type="hidden" name="language" value="pt" />
	<input type="hidden" name="transaction_id" value="<?php echo  $idpedido; ?>" />
	<input type="hidden" name="currency" value="brl" />
	<input type="hidden" name="ok_url" value="<?php echo $INI['system']['wwwprefix']?>/pedido/dinheiromail/retorno.php" />
	<input type="hidden" name="error_url" value="<?php echo $INI['system']['wwwprefix']?>/pedido/dinheiromail/retorno.php" />
	<input type="hidden" name="pending_url" value="<?php echo $INI['system']['wwwprefix']?>/pedido/dinheiromail/retorno.php" /> 
	<input type="hidden" name="buyer_message" value="1" />
	<input type="hidden" name="header_image" value="<?php echo $INI['system']['wwwprefix']?>/include/logo/logo.png" />
	<input type="hidden" name="country_id" value="2" /> 
	<!--PaymetMethod-->
	<input type="hidden" name="payment_method_available" value="all" /> 
	<!--Items-->
	<!--Item1 -->
	<?  
	$con=0;   
	mysql_data_seek($items,0);
	while ($item = mysql_fetch_array($items, MYSQL_ASSOC)) {
		$con++;  
		$team = Table::Fetch('team', $item['team_id']);  
		$valor  = number_format($item['team_price'], 2, ',', '.');	
		//$valor = $valor * $item['team_qty'];
		//$valor = str_replace(",",".",$valor);
				
	?> 
	
	<input type="hidden" id="item_name_<?=$con?>"  name="item_name_<?=$con?>" value="<?=displaySubStringWithStrip($team['title'], 90) ?>" /> 
	<input type="hidden" id="item_quantity_<?=$con?>" name="item_quantity_<?=$con?>" value="<?php echo $item['team_qty'] ?>" />
	<input type="hidden" id="item_ammount_<?=$con?>" name="item_ammount_<?=$con?>" value="<?php echo $valor ;  ?>" />
	<input type="hidden" id="item_currency_<?=$con?>" name="item_currency_<?=$con?>" value="brl" />
	<input type="hidden" id="shipping_type_<?=$con?>" name="shipping_type_<?=$con?>" value="0" /> 
		
	<? } ?>
	<!-- <input type="hidden" name="weight_1" value="kg" />-->
	<!--<input type="hidden" name="item_weight_1" value="0" />-->
	<!-- <input type="hidden" name="shipping_currency_1" value="brl" />-->
  
	<!--Buyer info -->
	<input type="hidden" name="buyer_name" value="<?=$nome?>" />
	<input type="hidden" name="buyer_lastname" value="<?=$sobrenome?>" />
	<input type="hidden" name="buyer_sex" value="m" />
	<input type="hidden" name="buyer_nacionality" value="bra" />
	<input type="hidden" name="buyer_document_type" value="cpf" />
	<input type="hidden" name="buyer_document_number" value="<?=$login_user['cpf']?>" />
	<input type="hidden" name="buyer_email" value="<?=$login_user['email']?>" />
	<input type="hidden" name="buyer_phone" value="<?=$login_user['mobile']?>" /> 
	<input type="hidden" name="buyer_zip_code" value="<?=$login_user['zipcode']?>" />
	<input type="hidden" name="buyer_street" value="<?=$login_user['address']?> <?=$login_user['bairro']?>" /> 
	<input type="hidden" name="buyer_city" value="<?=$login_user['cidadeusuario']?>" />
	<input type="hidden" name="buyer_state" value="<?=$login_user['estado']?>" />
	<input type="hidden" name="change_quantity" value="0" />
	<input type="hidden" name="display_shipping" value="1" />
	<input type="hidden" name=" display_additional_charge" value="<?=$valorfrete?>" />
	 
	</form>
<? } 
?>

<?php if($INI['moip']['tokentrans'] != "" && $INI['moip']['chavetrans'] != "" && $INI['moip']['midtrans'] != ""){  
		$item_valor2 = $valor_original;
        $item_valor2 = str_replace(",",".",$item_valor2);
		
	?>
 <form action="index.php?page=pagamentocc" id="moiptransparente" name="moip" method="post">
    <input type="hidden" name="idPedido" value="<?php echo $idpedido; ?>" />
    <input type="hidden" name="tituloPedido" value="<?php echo $title;?>" />
    <input type="hidden" name="valorPedido" value="<? echo $item_valor2; ?>" />
    <input type="hidden" name="idUsuario" value="<? echo $login_user['id']; ?>" />
    <input type="hidden" name="emailUsuario" value="<? echo $login_user['email']; ?>" />
    <input type="hidden" name="loginUsuario" value="<? echo $login_user['username']; ?>" />
    <input type="hidden" name="nomeUsuario" value="<? echo $login_user['realname']; ?>" />
    <input type="hidden" name="enderecoUsuario" value="<? echo $login_user['address']; ?>" />
    <input type="hidden" name="bairroUsuario" value="<? echo $login_user['bairro']; ?>" />
    <!--<input type="hidden" name="telefoneUsuario" value="<? echo (isset($login_user['mobile'])) ? $login_user['mobile'] : '(00)0000-0000'; ?>" />-->
    <input type="hidden" name="telefoneUsuario" value="(00)0000-0000" />
    <input type="hidden" name="cpfUsuario" value="<? echo $login_user['cpf']; ?>" />
    <input type="hidden" name="cidadeUsuario" value="<? echo $login_user['cidadeusuario']; ?>" />
    <input type="hidden" name="estadoUsuario" value="<? echo $login_user['estado']; ?>" />
</form>

<form action="index.php?page=pagamentodb" id="moipdb" name="moip" method="post">
    <input type="hidden" name="idPedido" value="<?php echo $idpedido; ?>" />
    <input type="hidden" name="tituloPedido" value="<?php echo $title;?>" />
    <input type="hidden" name="valorPedido" value="<? echo $item_valor2; ?>" />
    <input type="hidden" name="idUsuario" value="<? echo $login_user['id']; ?>" />
    <input type="hidden" name="emailUsuario" value="<? echo $login_user['email']; ?>" />
    <input type="hidden" name="loginUsuario" value="<? echo $login_user['username']; ?>" />
    <input type="hidden" name="nomeUsuario" value="<? echo $login_user['realname']; ?>" />
    <input type="hidden" name="enderecoUsuario" value="<? echo $login_user['address']; ?>" />
    <input type="hidden" name="bairroUsuario" value="<? echo $login_user['bairro']; ?>" />
    <!--<input type="hidden" name="telefoneUsuario" value="<? echo (isset($login_user['mobile'])) ? $login_user['mobile'] : '(00)0000-0000'; ?>" />-->
    <input type="hidden" name="telefoneUsuario" value="(00)0000-0000" />
    <input type="hidden" name="cpfUsuario" value="<? echo $login_user['cpf']; ?>" />
    <input type="hidden" name="cidadeUsuario" value="<? echo $login_user['cidadeusuario']; ?>" />
    <input type="hidden" name="estadoUsuario" value="<? echo $login_user['estado']; ?>" />
</form>
<? } ?>


<?php if($INI['akatus']['acc'] != ""){  ?> 
	<!-- :::::::::::::::::::: formulario de pagamento AKATUS ::::::::::::: -->
	<?
	//$valorakatus = str_replace(".","",$valor_original);		
	//$valorakatus = str_replace(",",".",$valorakatus);		
	//$nomeakatus = retira_acentos($title);
	?>
	<form id="akatus" name="akatus"  target="akatus" method="post" action="https://www.akatus.com/carrinho/">
    <input type="hidden" readonly="readonly"  name="email_cobranca" value="contato@ofertasgold.com.br">
    <input type="hidden" readonly="readonly"  name="tipo" value="CP">
    <input type="hidden" readonly="readonly"  name="moeda" value="BRL">
  
 <?  
	$con=0;   
	mysql_data_seek($items,0);
	while ($item = mysql_fetch_array($items, MYSQL_ASSOC)) {
		$con++;  
		$team = Table::Fetch('team', $item['team_id']); 
		$valorpagdigital = number_format($item['team_price'], 2, ',', '.');		 
	?>   
		<input type="hidden" readonly="readonly"  name="item_id_<?=$con?>" value="<?=$team[id]?>">
		<input type="hidden" readonly="readonly"  name="item_descr_<?=$con?>" value="<?=utf8_decode(displaySubStringWithStrip($team['title'], 90)) ?>">
		<input type="hidden" readonly="readonly"  name="item_quant_<?=$con?>" value="<?php echo $item['team_qty'] ?>">
		<input type="hidden" readonly="readonly"  name="item_valor_<?=$con?>" value="<?php echo  number_format($item['team_price'], 2, ',', '.');	 ?>">
	  	
	<? } ?>
	  
	 <input type="hidden" readonly="readonly" name="ref_transacao" value="<?php echo  $idpedido; ?>"> 
	 <input type="hidden" readonly="readonly" name="item_frete_1" value="<?=$valorfrete?>"> 
	 <input type="hidden" readonly="readonly" name="tipo_frete" value="<?=$tipofrete?>">

	 
	</form>

<? } ?>
 
  
 <script language="javascript">
 
	function enviapag_normal(valorform){ 
	 
		if(valorform!="formulario" & valorform!="bcashtransparente"){  // para metodos transparente, nao precisa desta mensagem
			jQuery(document).ready(function(){   
		 
					jQuery.colorbox({html:"<img src='<?=$PATHSKIN?>/images/ajax-loader2.gif'> <font color='black'>Você está sendo redirecionado para efetuar este pagamento em um ambiente seguro...</font>"});
			});
		} 
	   if(valorform=="pagseguro"){
	   
		  if(J("#urlapipg").val() != "" & typeof(J("#urlapipg").val())  != "undefined"){
			 
				location.href=J("#urlapipg").val();  
		  }
	  } 
	 J("#"+valorform).submit();
}
	 
</script>
