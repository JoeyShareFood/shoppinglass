<div style="display:none;" class="tips"><?=__FILE__?></div>
<?php
	/* Primeiramente, todas as categorias que serão apresentadas na home são recuperadas. */
	$sql = "select id, name, imagemcateghome from category where categoria_destaque = 'Y' and imagemcateghome IS NOT NULL order by sort_order";
	$rs = mysql_query($sql);
	
	/* É verificado se houve algum retorno. */
	$row = mysql_num_rows($rs);
?>

<?php if($row >= 1) { ?>
<div data-spm="27" class="channel-container">
	<div class="channel-box clearfix">
		<?php while($CategoriaHome = mysql_fetch_assoc($rs)) { 
				$tituloseo =  str_replace(" ","+",$CategoriaHome['name']);	
				$tituloseo =  str_replace("+&","",$tituloseo);	
		?>
		<div class="channel-item channel-col-1 col-md-15 col-sm-15 col-lg-15"><div class="channel-item-inner"><a href="<?=$ROOTPATH?>/departamento/<?=retira_acentos_cat($tituloseo)?>/<?=$CategoriaHome['id']?>"><img src="<?php echo $ROOTHPATH . "/media/" . $CategoriaHome['imagemcateghome']; ?>"></a></div></div>
		<?php } ?>
	</div>
</div>
<?php } ?>

<?
  
function retira_acentos_cat($string){
    return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
}

?>