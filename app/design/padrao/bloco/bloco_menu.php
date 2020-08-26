<?php 
$sql = "select * from category where (idpai=0 or idpai is null) and ( display = 'Y' and mostrartopo='Y') order by sort_order desc";
$rs = mysql_query($sql);  										
?>
 
<div style="display:none;" class="tips"><?=__FILE__?></div>
 
 <div id="menu">
	<div id="tmcategories" style="position: relative">
		<ul class="menu" id="cat">
		 
			<!--<li style="z-index:1000;" class="parent" id="1000"><a title="Lojas" href="<?=$ROOTPATH?>/index.php"><span><span id="sp_1000">Home</span></span></a></li>-->
			
			<?php 
			while($l = mysql_fetch_assoc($rs)){ 
				$linkid =""; 
				if(!strpos($_SERVER["REQUEST_URI"],"lojista")){
					$nomecategoria = utf8_decode($l['name']);
				}
				else{
					$nomecategoria = $l['name'];
				}
				
				if($l['linkexterno']!=""){?>
					<li style="z-index:1000;" class="parent" id="<?=$l['id']?>"> <a target="<?=$l['target']?>" title="<?=$nomecategoria?>" href="<?=$l['linkexterno']?>"><span><span id="sp_<?=$l['id']?>"><?=$nomecategoria?></span></span></a><? 
				 } 
				   
				$sqlc = "select id,value,titulo,data_criacao from page where status = 1 and category_id =".$l['id'] ;
				$rsc = mysql_query($sqlc);
				$linha = mysql_fetch_object($rsc);
				
				$titulo  = tratanome($linha->titulo);
				$id  = $linha->id;  
				$tituloseo =  str_replace("&", "-", str_replace(" ","+",strtolower($l['name'])));
				if($id==""){
					$id=$l['id'];
				}
				 ?>
					<li style="z-index:1000;" class="parent" id="<?=$l['id']?>"> <a title="<?=$nomecategoria?>" href="<?=$ROOTPATH?>/departamento/<?=retira_acentos_v1($tituloseo) ?>/<?=$id?>"><span><span id="sp_<?=$l['id']?>"><?=$nomecategoria?></span></span></a>
				<? 
					 
				lista_filhos_page($l['id']);  
			} 
			?>
		</ul>

	</div>
 </div>
 <?php
 function lista_filhos_page($id_categoria){
	 
	$sql = "select idpai,id,name,tipo, link ,linkexterno,target from category where idpai=$id_categoria and display = 'Y' order by sort_order desc";
	$rs  = mysql_query($sql);
	$zindex=1000;
  
	while($l = mysql_fetch_assoc($rs)){ 
	 
		$idpai = $l['idpai'];
		$zindex++;
		 $linkid ="";
		 
		if($idpai and $pai!=$idpai){
				$pai = $idpai;
				
		?>
			<div class="subcat">
				<ul class="redonde"> 
		<?}
		else{?>
			</li>
		<?}
		 
		 $nomecategoria =   $l['name'];
		 $nomecategoria = utf8_decode($nomecategoria);
		 $nomecategorialink =  str_replace("&", "-", str_replace(" ","+",strtolower($l['name'])));
		 $nomecategorialink = retira_acentos_v1($nomecategorialink);
		 
		$id=$l['id'];
		 
			
		if($l['linkexterno']!=""){?>
				<li style="z-index:1000;"  class="parent" id="<?=$l['id']?>"> <a target="<?=$l['target']?>" title="<?=utf8_decode($l['name'])?>" href="<?=$l['linkexterno']?>"><span><span><?=utf8_decode($l['name'])?></span></span></a><? 
			 }
		else if($l['tipo']=="pagina"){
		 
			$sqlc = "select id,value,titulo,data_criacao from page where status = 1 and category_id =".$l['id'] ;
			$rsc = mysql_query($sqlc);
			$linha = mysql_fetch_object($rsc);
			
			$titulo  = tratanome($linha->titulo);
			$id  = $linha->id; 
			
			?>
			<li style="z-index:1000;" class="parent" id="<?=$l['id']?>"> <a title="<?=$nomecategoria?>" href="<?=$ROOTPATH?>/departamento/<?=$nomecategorialink ?>/<?=$id?>"><span><span id="sp_<?=$l['id']?>"><?=$nomecategoria?></span></span></a>
		    <?  
		} 
		else{
		?>
			<li style="z-index:1000;" class="parent" id="<?=$l['id']?>"> <a title="<?=$nomecategoria?>" href="<?=$ROOTPATH?>/departamento/<?=$nomecategorialink ?>/<?=$id?>"><span><span id="sp_<?=$l['id']?>"><?=$nomecategoria?></span></span></a>
		<? 
		}
		?>
		<script> 
			J("#<?=$id_categoria?>").attr("class","submenu") 
		</script>
		<?
		lista_filhos_page($l["id"]);
	}?>
	<?if($idpai){?>			 
			</ul>
		</div> 
	</li>
	<? } ?>

<? } 


function retira_acentos_v1( $texto )
{
  $array1 = array(   "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
                     , "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç" );
  $array2 = array(   "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
                     , "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C" );
  return str_replace( $array1, $array2, $texto );
}


?>
 