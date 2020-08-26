<?php  

require_once("include/head.php");
need_login();
 
$pgcredito = "sim";
$origem = "minhaconta";
 
?>

<body id="page1">
<div class="cabecalhosub"></div>
<div class="tail-top">

    <div class="main">
       <?php  require_once(DIR_BLOCO."/header.php"); ?>
		<section id="content">
            <div class="inside">
				<div class="container">
					<div class="col-1c">
						<div>
							<div class="container">
                             <div style="display:none;" class="tips"><?=__FILE__?></div>
							  <div class="col-6" style="width:96%;" >
							  	<div class="titulosecao2"><span class="txt7">	<a style="color:#303030;" href="index.php?page=minhaconta">Meus Pedidos</a> | <a style="color:#303030;" href="index.php?page=meuscupons">Meus Cupons</a> |<a style="color:#303030;" href="index.php?page=meusconvites"> Meus Convites</a> |<a style="color:#303030;" href="index.php?page=meuscreditos"> Meus Créditos</a> | <a style="color:#303030;" href="index.php?page=meusdados">Meus Dados</a></span></div>
								 <div class="pgavulsafundominhaconta"> 
									 <br class="clear" />  
										<span class="txt12">Recarga de Créditos </span>
										 <div class="tail" style="margin-top:-12px;"></div> 
											<br class="clear" />    
										     <div class="rowElem1"> 
												  <input name="valorcredito" style="-moz-box-shadow:0 0;" onkeypress="return formatar_moeda(this,',','.',event);"  type="text" class="input" id="valorcredito" onfocus="if(this.value =='Informe o valor' ) this.value=''" onblur="if(this.value=='') this.value='Informe o valor'" value="Informe o valor"  /> <span style='font-size:13px'></span>  
												<br class="clear" /> 
											  </div>     
										   <?php   
											require_once(DIR_ROOT.'/formepay.php');
											?>
										<br class="clear" />  
										<a href="javascript:history.go(-1)">voltar</a>

									</div> 
							 </div>
						</div>
					</div>
				</div>
			</div>
        </section>
       </div>
</div> 
 
 <?php require_once(DIR_BLOCO."/rodape.php"); ?>
 
<script language="javascript">
	  
	function setprice(valor){

		document.pagamentodigital.produto_valor_1.value = valor
		document.mercadopago.price.value = valor
		document.pagseguro.item_valor_1.value = valor
		document.moip.valor.value = valor
	
	}
	 
</script>

</body>
</html>
