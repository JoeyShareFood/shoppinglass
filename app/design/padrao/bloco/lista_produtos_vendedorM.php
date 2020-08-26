
<?php

/* Recupera a ID do produto que está sendo apresentado. */
$IdProduto = explode("/", strip_tags($_GET["idoferta"]));

/* É buscado a ID do parceiro que cadastrou a oferta, e a categoria que ele está vinculado da página atual. */
$sql = "select partner_id, group_id from team where id = " . $IdProduto[0] . " and moderacao = 'Y'";
$rs = mysql_query($sql);
$row = mysql_fetch_assoc($rs);

/* Recupera os demais produtos daquele vendedor, exceto o produto da página atual. */
$sql = "select * from team where partner_id = " . $row['partner_id'] . " and moderacao = 'Y' and id != " . $IdProduto[0] . " order by rand()";
$rs = mysql_query($sql);
$retorno_rs = mysql_num_rows($rs);

/* Recupera alguns produtos que podem ser similares e que pertence a mesma categoria. */
$sqls = "select * from team where group_id = " . $row['group_id'] . " and moderacao = 'Y' and id != " . $IdProduto[0] . " and partner_id <> " . $row['partner_id'] . " order by rand()";
$rss = mysql_query($sqls);
$retorno_rss = mysql_num_rows($rss);

?>
<?php if($retorno_rs >= 1) { ?>
<div class="produtoslista">
	<div class="telefonia home-list clearfix hover">   
		<div class="titlePage">
			<p>
				Outros produtos deste vendedor
			</p>
		</div>
		<div class="owl-wrapper">	
		<?php
			/* Neste loop é listado algumas ofertas do parceiro responsável pelo anúncio
			   da página atual.
		   */ 
			if($retorno_rs >= 1) {
				while($team = mysql_fetch_assoc($rs)) {  
					
					$BlocosOfertas->getDados($team);
					require(DIR_BLOCO."/lista_produtos.php"); 
				}
			}
		?>
		</div>		
	</div>  
</div> 
<?php } ?>
<?php if($retorno_rss >= 1) { ?>
<div class="produtoslista">
	<div class="telefonia home-list clearfix hover">   
		<div class="titlePage">
			<p>
				Produtos de outros vendedores
			</p>
		</div>
		<div class="owl-wrapper">	
		<?php
			/* Neste loop é listado algumas ofertas vinculadas a mesma categoria
		   */ 
			while($team = mysql_fetch_assoc($rss)) {  
				$BlocosOfertas->getDados($team);
				require(DIR_BLOCO."/lista_produtos.php"); 
			} 
		?>
		</div>			
	</div>  
</div> 
<?php } ?>