<div style="display:none;" class="tips"><?=__FILE__?></div>
<?php
	/* Primeiramente, todas as categorias que serão apresentadas na home são recuperadas. */
	$sql = "select id, name, imagemcateghome from category where displaycateg = 'Y' and imagemcateghome IS NOT NULL order by sort_order";
	$rs = mysql_query($sql);
	
	/* É verificado se houve algum retorno. */
	$row = mysql_num_rows($rs);
?>

<?php if($row >= 1) { ?>
<div data-spm="27" class="channel-container">
	<div class="channel-box clearfix">
		<?php while($CategoriaHome = mysql_fetch_assoc($rs)) { 
				$tituloseo =  str_replace(" ","+",mb_strtolower(utf8_decode($CategoriaHome['name'])));	
				$tituloseo =  str_replace("+&","",$tituloseo);
		?>
		<div class="channel-item channel-col-1 col-md-15 col-sm-15 col-lg-15"><div class="channel-item-inner"><a href="<?=$ROOTPATH?>/departamento/<?=$tituloseo?>/<?=$CategoriaHome['id']?>"><img src="<?php echo $ROOTHPATH . "/media/" . $CategoriaHome['imagemcateghome']; ?>"></a></div></div>
		<?php } ?>
	</div>
</div>
<?php } ?>