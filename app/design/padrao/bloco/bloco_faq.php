<div style="display:none;" class="tips"><?=__FILE__?></div>
<?
	$condicoes = array(
			//'city_id' => array($others_city_id, 0),
			//'team_type in ("normal","cupom","off","pacote")',
			//"group_id = ".$_REQUEST["idcategoria"],
	);
	$dados = DB::LimitQuery('faq', array(
		'condition' => $condicoes,
		'order' => 'ORDER BY `ordem` DESC, `id` DESC',
	 ));
	 
	foreach($dados AS $index=>$one) {
		
		if($one['type'] == "vende") {
			$vende[] = $one;
		}
		else {
			$compra[] = $one;
		}
	}
?>
<div style="float:left;width:1230px;">
	<p>&nbsp;</p> 
	<p style="text-align: center;">
		<span style="font-size: x-large;">
			<span style="color: #33cccc;">
				<strong>
					<span style="font-size: xx-large;">
						<span style="color: #f77274;">Bateu aquela&nbsp;</span>
					</span>
				</strong>
			</span>
		</span>
		<span style="font-size: x-large;">
			<span style="color: #33cccc;">
				<strong>
					<span style="font-size: xx-large;">
						<span style="color: #fa8072;">
							<span style="color: #f77274;">d&uacute;vida?</span> 
						</span>
					</span>
				</strong>
			</span>
		</span>
	</p>
	<p style="text-align: center;"><strong><span style="font-size: x-large;"><span style="color: #33cccc;"><strong></strong></span></span><span style="font-size: xx-large; color: #888888;">Veja as perguntas mais comuns por aqui :D</span></strong></p>
	<p>&nbsp;</p> 
	<p>&nbsp;</p> 
</div>
<div class="faqcontat">							
	<div id="faqs">
		<h4 class="size-19-bold vermelho-padrao margin-bottom-15;" style="text-align:left;">
			QUEM COMPRA
		</h4>	
		<?php  
			if(is_array($dados)){
				foreach($compra AS $index=>$one) { 
		?>
		<dt>
			<?=utf8_decode($one['pergunta'])?>
		</dt>
		<dd class="size-12">
			<?=utf8_decode($one['resposta'])?>
		</dd> 	 
		<?php }} ?>  
	</div> 
	<div id="faqs">
		<h4 class="size-19-bold vermelho-padrao margin-bottom-15;" style="text-align:left;">
			QUEM VENDE
		</h4>
		<?php  
			if(is_array($dados)){
				foreach($vende AS $index=>$one) { 
		?>
		<dt>
			<?=utf8_decode($one['pergunta'])?>
		</dt>
		<dd class="size-12">
			<?=utf8_decode($one['resposta'])?>
		</dd> 	 
		<?php }} ?>  
	</div>
</div>
<div style="float:left;width:1230px;">
	<p>&nbsp;</p> 
	<p>&nbsp;</p> 
	<p style="text-align: center;"><span style="color: #888888;"><span style="font-size: small;"><span style="font-size: medium;"><strong><span style="font-size: xx-large;"><span class="tx_24_arvo" style="color: #888888;">Ainda ficou com d&uacute;vida? <a style="text-decoration:underline;color:#f77274;" href="../../contato"><span style="color: #f77274;">Fale com a gente</span></a></span><span style="color: #f77274;"><span style="color: #f77274;"><span style="color: #888888;">, vamos te ajudar!</span></span></span></span></strong></span></span></span></p>
	<p style="text-align: center;"><strong><span style="font-size: medium;"><br /></span></strong></p>
	<p>&nbsp;</p> 	
</div>