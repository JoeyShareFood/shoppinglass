<?php  
require_once("include/head.php"); 
$order  = Table::Fetch('order',$_REQUEST['order_id']);
?>
<body id="page1">
 <style>
 .link-3 {
    width: 161px;
}
 </style>
<div style="display:none;" class="tips"><?=__FILE__?></div>
<div class="cabecalhosub"></div>
<div class="tail-top"> 

    <div class="main">
       <?php  require_once(DIR_BLOCO."/header.php"); ?>
		<section id="content">
			
			<?php  require_once(DIR_BLOCO."/bannertopo.php"); ?>
             <div class="inside" style="padding:0 19px 0px 10px">
				<div class="container">
					<div class="col-1c"> 
						<div class="container">
						  <div class="col-6" style="width:100%;" >
							<?php  require_once(DIR_BLOCO."/blocomenuminhaconta.php"); ?><div class="pgavulsafundominhaconta">
							  <span style="color:#94c807;font-size:1.21em; font-family:Trebuchet MS;font-weight:bold;padding:12px;">Meus Pedidos</span>	<a href="index.php?page=minhaconta" class="link-3"><em><b>todos os pedidos</b></em></a> <a style="margin-right:2px;" href="index.php?page=minhaconta&status=unpay" class="link-3"><em><b>pedidos pendentes</b></em></a> <a style="margin-right:2px;" href="index.php?page=minhaconta&status=pay" class="link-3"><em><b>pedidos pagos</b></em></a>  
								<div class="tail" style="margin-top:-12px;"></div>
								 <div id="mapsparceiro"><iframe frameborder="0" height="364" width="874" scrolling="auto" src="<?=$ROOTPATH?>/util/rastreiocorreio/app/webservice.php?code=<?=$order['codigorastreio']?>&id=<?=$_REQUEST['order_id']?>" id="imaps"></iframe>
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
 
</body>
</html>
