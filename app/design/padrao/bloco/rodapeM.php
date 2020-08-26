<div style="display:none;height:36px;" class="tips"><?=__FILE__?></div>
<div id="rodape">
	<div class="footer-links clearfix"> 
		<div class="titleFooter">
			<p>
				Links úteis
			</p>
		</div>
		<ul style="width:100%;float:left;">
			<?php 
			
			$sql = "select  *  from page where status = 1 order by id desc";
			$rs = mysql_query($sql); 	
			
			$i = 0;
			
			while($l = mysql_fetch_assoc($rs)) {	
				$tituloseo =  removeAcentos(str_replace(" ","+",mb_strtolower($l[name])));				
				if ($i%6==0) { ?>
					<nav class="links-column-department">
				<? } ?>
					<li class="links-item"  id="<?=$l['id']?>">
						<a class="more-about-item" title="<?=utf8_decode($l['name'])?>" href="<?=$ROOTPATH?>/page/<?=$l['id']?>">
							<span><span class="icon" id="sp_<?=$l['id']?>"></span></span><?=utf8_decode($l['titulo'])?>
						</a>
					</li>	 
				<? 
				$i++;
				if ($i%6==0) { ?>
					</nav> 
			<? } 
			}
			?> 			
			<li class="links-item"  id="<?=$l['id']?>">
				<a class="more-about-item" title="Fale com a gente" href="<?=$ROOTPATH?>/contato">
					<span><span class="icon" id="sp_<?=$l['id']?>"></span></span>
					Fale com a gente
				</a>
			</li>	
		</ul>
		<div class="width:100%;">
			<div class="titleFooter">
				<p>
					Sobre nós
				</p>
			</div>
			<p>
				<?php
					$pagina = Table::Fetch('page', 24);
					echo strip_tags($pagina['value']);
				?>
			</p>
		</div>
	</div>
</div>	