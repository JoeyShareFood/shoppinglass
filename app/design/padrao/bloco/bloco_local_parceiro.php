<div style="display:none;" class="tips"><?=__FILE__?></div>
	<?php 
	include "../../../../app.php";
	$partner = Table::Fetch('partner', RemoveXSS($_REQUEST['partner_id']));
	  ?>
	<div class="col-1">
		<div class="indent" style="padding:2px;">
			<div class="container1"> 
				<div class="titulo">Parceiro</div>  
					<div class="descricaooferta">  
						<?
						$endereco="";
						if($partner['address']!=""){
						$endereco.=$partner['address']. " ";
						$endegoogle .= $partner['address']. " ";}
						if($partner['numero']!=""){
						$endereco.=$partner['numero']. " ";
						$endegoogle .= $partner['numero']. " ";}
						if($partner['chavesms']!="")
						$endereco.=$partner['chavesms']. " ";
						if($partner['bairro']!=""){
						$endereco.=$partner['bairro']. " ";	
						$endegoogle .= $partner['bairro']. " ";}
						if($partner['cidade']!=""){
						$endereco.=$partner['cidade']. " ";
						$endegoogle .= $partner['cidade']. " ";}
						if($partner['estado']!="") 
						$endereco.= "- ".$partner['estado']. " "; 
						if($partner['cep']!="")
						$endereco.=$partner['cep']. " ";
						if($partner['phone']!="")
						$endereco.=$partner['phone']. " ";
						?>
						<b><?php echo  utf8_decode($partner['title']) ; ?></b><BR><?=  utf8_decode($endereco)  ; ?>  
						<?php if($partner['homepage'] != ""){?>
						- <a  style="text-decoration:none;color:black;" href="<?php  echo $partner['homepage']; ?>" target="_blank"><?php echo domainit($partner['homepage']); ?></a>
						<?php } ?>

						<br><br>
					
						<?php  if($partner['address'] != "" and $INI['option']['bloco_googlemaps'] == "Y" ){?>
						<div style="float:left; width: 700px;"> <iframe frameborder="0" height="200" width="690" scrolling="no" src="<?=$ROOTPATH?>/maps.php?coord=<?=$partner['longlat']?>&endereco=<?=utf8_decode($endegoogle);?>" id="imaps"></iframe></div>
						<? } ?> 
						<? if($partner['image'] !=""){?> 
						<div style="clear:both; width: 297px; float: left;margin-top:11px;">  
							<a href="<?=$partner['homepage']?>" target="_blank"><img style="max-width: 300px;"src='<?php echo $ROOTPATH."/media/".substr($partner['image'],0,-4).".jpg";?>' title='<?php echo utf8_decode($partner['title']); ?>' alt='<?php echo utf8_decode($partner['title']); ?>'></a> 
						</div>
						<? } ?>
						<div class="descricaooferta_parceiro">
							<?php echo utf8_decode($partner['descricao']);?>
						</div>
				</div>	
			</div>	
		</div>	
	</div>	 
<script>
	J("#carregando_tabs").hide();
</script>