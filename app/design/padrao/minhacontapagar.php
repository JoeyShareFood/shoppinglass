<?php  
require_once("include/head.php"); 
need_login();

$idpedido = (int) strip_tags($_REQUEST['idpedido']);
$order = Table::Fetch('order', $idpedido ); 

//setando o tipo do frete para os gateways ex: pagseguro
$tipofrete="EN"; 
 
if($idpedido){ 
 $condition = array( 
	'order_id' => $idpedido,   
	);
}
else{
	echo "<h2>Você não pode acessar esta página desta forma</h2>";
	exit;
}
  
$count = Table::Count('order_team', $condition); 
$orders = DB::LimitQuery('order_team', array(
	 'condition' => $condition,
	 'order' => 'ORDER BY team_id DESC',
)); 
?> 
<div style="display:none;" class="tips"><?=__FILE__?></div> 

<link rel="stylesheet" href="<?=$PATHSKIN?>/css/myaccount.css" type="text/css" media="all">

<style>
.my-cart-product-wrapper .my-cart-product-item {
    float: left;
}
</style>

<body id="page1" class="webstore home"> 

<?php if(detectResolution()) { ?>
<!-- Responsivo -->
<div class="containerM">
	<? require_once(DIR_BLOCO."/headerM.php"); ?>
	<div class="row">
		<div class="titlePage">
			<p>Pagar pedido</p>
		</div>
		<div class="productsPage">
			<?php require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/include/botoespagamento.php'); ?>
			<?php  require_once(DIR_BLOCO."/rodapeM.php"); ?>			
		</div>				
	</div>
</div>
<?php } else { ?>
<div class="container">  
	<div class="page">
		<?php  require_once(DIR_BLOCO."/header.php"); ?>
			<div class="main-content clearfix"> 
				<div class="my-account-page" id="my-account-container">
					<div id="my-account-header">
						<?php  require_once(DIR_BLOCO."/my-account.php"); ?>
					</div>
				</div>
				<div class="main-content clearfix"> 
					<div class="formay" style="margin-top: 85px;">
						<?php require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/include/botoespagamento.php'); ?>	
					</div>			
				</div>
		<div style='display:none'>
			<div id='inline_combinarcomvendedor' style='background:#fff; height:110px; padding:10px; width:345px !important'>
				<div id="divContato" class="formulario span-8 last">
						<div class="span-8 last caixa-linha-ficha" id="container-nome">
							<div class="span-8 borda-bottom-1 fundosecao">
								<div class="AvisoContato">
									<img align="left" src="<?php echo $PATHSKIN; ?>/images/customer-support.png"> 
									<h4 class="branco-padrao size-20-bold jump-1" style="margin-left:65px;">Após entrar em contato com vendedor, fique tranquilo e aguarde o retorno.</h4>
								</div>
								<div class="alturasecao"><h4 class="branco-padrao size-20-bold jump-1">Combinar com vendedor</h4></div>
							</div>
						 
								<div class="span-7 jump-1 last"  style="text-align:left;">
									<label class="last size-13-bold rotulo">Seu nome</label>
								</div> 
							  <input type="text" readonly maxlength="100" id="txtNome" value="<?php echo $login_user['realname']; ?>" name="nome" class="span-6-b raio-5">
						</div>
						<div class="span-8 last caixa-linha-ficha" id="container-email" style="clear:both;">
							<div class="span-8 last margin-top-10">
								<div class="span-7 jump-1 last"  style="text-align:left;">
									<label class="last size-13-bold rotulo">Seu e-mail</label>
								</div>
							</div>
							<input type="text" readonly maxlength="60" value="<?php echo $login_user['email']; ?>" id="txtEmail"  name="email" class="span-6-b raio-5">
						</div>
						<div class="span-8 last caixa-linha-ficha" id="container-tel" style="clear: both;">
							<div class="span-8 last margin-top-10">
								<div class="span-7 jump-1 last"  style="text-align:left;">
									<label class="last size-13-bold rotulo"  >Telefone</label>
								</div>
							</div>
							<input type="text" readonly value="<?php echo $login_user['mobile']; ?>" id="txtTel"  maxlength="13"  onKeyPress="return SomenteNumero(event);" name="telefone" class="span-4 raio-5 celular" style="">
						</div>
						<div class="span-8 last caixa-linha-ficha"  style="text-align:left;" id="container-msg">
							<div class="span-8 last margin-top-10">
								<div class="span-7 jump-1 last">
									<label class="last size-13-bold rotulo"  >Mensagem</label>
								</div>
							</div> 
							<textarea rows="6" onkeyup="limite_textarea(this.value)" maxlength="500" name="proposta" id="txtMsg" class="span-6-b last raio-5" rows=""></textarea>
						</div>
						<div class="jump-1 last caixa-linha-ficha size-12"  style="text-align:left;clear: both;">
							Caracteres restantes: <label id="conttxt" for="txtMsg">500</label>
						</div>
						<div class="span-8 last checkboxes" style="text-align:left;clear:both;margin-top:19px;">
							<div class="span-5 jump-1 last captcha-cont-vendedor" style="margin-top:22px;width:243px;" >
								<div style="width: 163px;">	
								<button id="btnEnviar" class="btn btn-primary write-review" style="width:94px;" onclick="javascript:MsgVendedor();"  title="Enviar" data-tipo-anuncio="Usados" data-tipo-veiculo="Carro" data-id="11239890"   class="span-4 last raio-5 size-14-bold bt-verm margin-top-10">Enviar</button>
								</div>
								<DIV><BR><BR></DIV>				
							</div>
						</div>
					</div>
		   </div> 
</div>

<script language="javascript"> 
	J(".secaotitulo").corner("round 2px");
	
	function limite_textarea(valor) {
		quant = 500;
		total = valor.length;
		if(total <= quant) {
			resto = quant - total;
			document.getElementById('conttxt').innerHTML = resto;
		} else {
			document.getElementById('txtMsg').value = valor.substr(0,quant);
		}
	}
	
function MsgVendedor(){
	  
	var idpedido = '<?php echo $idpedido; ?>';
	var nome = J("#txtNome").val();
	var email  = J("#txtEmail").val();
	var telefone = J("#txtTel").val();
	var proposta = J("#txtMsg").val(); 
	
	if(idpedido == ""){

		alert("Ocorreu um erro inesperado. Por favor, volte mais tarde.")
		return;
	} 

	if(proposta == ""){

		alert("Informe alguma mensagem !")
		document.getElementById("proposta").focus();
		return;
	}  
	//jQuery.colorbox({html:"<img src="+URLWEB+"/skin/padrao/images/ajax-loader2.gif> <font color='black' size='10'>Enviando sua proposta, por favor, aguarde...</font>"});
	
	J.ajax({
		   type: "POST",
		   cache: false,
		   async: true,
		   url: URLWEB+"/combinarvendedor.php",
		   data: "idpedido="+idpedido+"&nome="+nome+"&email="+email+"&telefone="+telefone+"&proposta="+proposta ,
		   success: function(msg){
		   
		   if( jQuery.trim(msg)==""){
		    	jQuery.colorbox({html:"<p>Mensagem enviada com sucesso! </p>"});
				location.href = "<?php echo $ROOTPATH; ?>";
			}  
		   else {
					jQuery.colorbox({html:"<p>"+msg+"</p>"});
					location.href = "<?php echo $ROOTPATH; ?>";
				}
			 }
		 });
}
</script>

<?php
	require_once(DIR_BLOCO."/rodape.php");
	require_once(DIR_BLOCO."/alterar_dados_minha_conta.php");
?>
	
</div>
</div>
<?php } ?>
</body>
</html>
