<div style="display:none;" class="tips"><?=__FILE__?></div>
<div style="height:11px;"></div>
<script>
	J(function() {
		J( "#tabs" ).tabs({
			ajaxOptions: {
				error: function( xhr, status, index, anchor ) {
					 J( anchor.hash ).html(
					// "Não foi possível ler o conteúdo desta tab, por favor, tente novamente"
					);
				}
			}
		});
	});
</script> 
<div class="conteudotabs">
<div style="display:none;" class="tips"><?=__FILE__?></div>
	<div id="tabs">
		<ul>
			<? if($team['summary'] != ""){?><li><a href="#tabs-1"><?php echo utf8_decode("Informações do produto"); ?></a></li><? } ?>
			<? if($team['answer'] != ""){?><li><a  href="#tabs-2"><?php echo utf8_decode("Pergunte ao vendedor"); ?></a></li><? } ?> 
			<? if($team['garantia'] != ""){?><li><a  href="#tabs-3"><?php echo utf8_decode("Garantia"); ?></a></li><? } ?> 
			<? if($team['condicaoenvio'] != ""){?><li><a href="#tabs-4"><?php echo utf8_decode("Condições de envio"); ?></a></li><? } ?> 
			<? if($team['avaliacaoclientes'] != ""){?><li><a  href="#tabs-5"><?php echo utf8_decode("Qualificações"); ?></a></li><? } ?> 
		</ul>
		 
		<? if($team['summary'] != ""){?>
			<div id="tabs-1">
				<? require_once(DIR_BLOCO."/bloco_descricao_oferta.php");  ?>
			</div>
		<? } ?> 
		<? if($team['answer'] != ""){?>
			<div id="tabs-2" >
				<? require_once(DIR_BLOCO."/bloco_perguntas.php");  ?>
			</div>
		<? } ?> 
		<? if ($team['garantia'] != ""){?>
			<div id="tabs-3" >
				<? require_once(DIR_BLOCO."/bloco_garantia.php");  ?>
			</div>
		<? } ?> 
		<? if($team['condicaoenvio'] != ""){?>
			<div id="tabs-4" >
				<? require_once(DIR_BLOCO."/bloco_condicoesenvio.php");  ?>
			</div>
		<? } ?> 
		<? if($team['avaliacaoclientes'] != ""){?>
			<div id="tabs-5" >
				<? require_once(DIR_BLOCO."/bloco_avaliacao.php");  ?>
			</div>	
		<? } ?> 		 
	</div> 					
</div>  
 
 <script>
 function goanimate(id){
		 J('html, body').animate({
			scrollTop: J('#'+id).offset().top - 100
		}, 2000);
	}
 </script>
 