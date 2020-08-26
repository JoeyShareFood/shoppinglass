 <?php
	$sql = "select * from category where idpai = 0 and display = 'Y' order by sort_order desc, id";
	$rs = mysql_query($sql); 	
	$result = array();

	while($array = mysql_fetch_array($rs)) {
	  $result[] = $array ; 
	}
	 
?> 
<div style="display:none;" class="tips"><?=__FILE__?></div>
<div class="site-menu-container">
 <nav id="site-menu" class="site-menu" style="display:none;">	
		<ul>	
			<li style="z-index:1000;"  class="menu-item titulo"  id="">
				<p>Categorias</p>
			</li>
			 <?php
				$sql = "select * from category where idpai=0 and display = 'Y' order by sort_order desc, id limit 11";
				$rs = mysql_query($sql); 										
				 
				$cont = 1;
				$ContList = 0;
				while($l = mysql_fetch_assoc($rs)){  
				?>
				
					<li style="z-index:1000;"  class="menu-item eletronicos"  id="<?=$l['id']?>"> 				
					<a class="menu-item-link" title="<?=utf8_decode($l['name'])?>" href="<?=$ROOTPATH?>/departamento/<?=utf8_decode($l['name'])?>/<?=$l['id']?>">										
						<div style="border-top:1px solid #eee;"> 
							<div style="float: left;width: 32px;"><img style="padding-top:4px;" src="<?=$ROOTPATH."/media/".$l['imagemcateg']?>"></div><div style="margin-top: 6px;"><?=utf8_decode($l['name'])?></div>
						</div>  			
					</a> 
					<? 
					lista_filhos($l['id'],$cont, $ContList);
					$cont++;					
				} 
			?> 	
		</ul>
	</nav>
</div>
 <?php
 function lista_filhos($id_categoria,$cont, $ContList){
	 
	$sql = "select idpai,id,name,tipo, link ,linkexterno,target from category where idpai=$id_categoria and display = 'Y' order by sort_order desc, id";
	$rs  = mysql_query($sql);
	$zindex=1000;
 

	while($l = mysql_fetch_assoc($rs)){ 
	 
		$idpai = $l['idpai'];
		$zindex++;
		$linkid =""; 
		$ContList = $ContList + 1;
		 
		if($idpai and $pai!=$idpai){
				
			if($cont > 3){
				//$alinhamentodireita =" submenu-align-right";
			} 			
			$pai = $idpai;	 ?>			
			<div class="submenu-wrapper submenu-default <?=$alinhamentodireita?>">
				<div class="submenu-border">                                
					<ul class="categories"> 		
				
		<? } else {?> 
				</li>
			 <? } ?>
			<?php if($ContList == 12) { ?>
			</ul>		                              
					<ul class="categories"> 			
			<?php }?>
			<li class="item" > 
				<a title="<?=utf8_decode($l['name']) ?>" href="<?=$ROOTPATH?>/departamento/<?=utf8_decode($l['name']) ?>/<?=$l['id']?>">
					<span><span><?=utf8_decode($l['name'])?></span></span>
				</a> 
			 <? //lista_filhos($l["id"]); // NÃO LISTA AS FILHAS DAS FILHAS.?>
	<? }  ?>
		<?if($idpai){?>	
				</ul>
			</div> 
		</div> 
	</li>
	<? } ?>

<? } ?>
