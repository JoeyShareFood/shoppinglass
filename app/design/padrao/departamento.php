<?php 

if($_REQUEST["idcategoria"]){ 
	$parametros 	= explode("/",$_REQUEST["idcategoria"]); // urlrewrite  
	$idcategoria = $parametros[1]; 
	$idsatributos = $parametros[2]; // se existir	 
}

// idcategoria e idsatributos vem da index.php
$category 	= Table::Fetch('category', $idcategoria);
$categoriasfilhas 	= Table::Fetch('category',$idcategoria,'idpai');
  
if($idparceiro =="" and $tiporequisicao=="lojista"){
	$idparceiro = $idcategoria; 
} 

if(!empty($idsatributos)){
	$a_idsatributo = explode(",",$idsatributos); 
}

$nomecategoriacorrente = utf8_decode($category['name']);
$nomecategoriacorrente_seo =  str_replace(" ","+",mb_strtolower($nomecategoriacorrente));

require_once("include/head.php"); 
?>  

<div style="display:none;" class="tips"><?=__FILE__?></div> 
<body id="page1" class="webstore home">
	<?php				
		if(detectResolution()) {		
	?>
	<!-- Responsivo -->
	<div class="containerM">
		<? require_once(DIR_BLOCO."/headerM.php"); ?>
		<div class="row">
			<div class="titlePage">
				<p>Categoria <?php echo utf8_decode($category['name']); ?></p>
			</div>
			<div class="productsPage">
			<?php	
				
				if($INI['option']['ofertas_finalizadas_populares'] == "N"){
					$condicao =  " and end_time > '".time()."'";
				}
				
				getcategoriafilhas($idcategoria);   
				$idcategorias.= $categoriasfilhasprod . "'" . $idcategoria . "'"; 

				$sql ="select id,title, market_price, team_price, condicoes_produto, image from team where moderacao = 'Y' and posicionamento <> 5 and group_id in( ".$idcategorias." )  $condicao order by sort_order, `id` DESC , `now_number` DESC";
				$rs = mysql_query($sql) or die(mysql_error()); 
				$contador = mysql_num_rows($rs);			
				
				while ($team = mysql_fetch_assoc($rs)){   
					
					$BlocosOfertas->getDados($team);
					require(DIR_BLOCO."/lista_produtos.php");   
				}  
				
				require_once(DIR_BLOCO."/rodapeM.php");
			?>	
			</div>				
		</div>
	</div>
	<?php
		} else {
	?>
	<div class="container"> 

		<div class="page">
			<?php  require_once(DIR_BLOCO."/header.php"); ?>
			<section id="content" class="content" style="background: #fff;">
				<div class="main-content clearfix"> 
					<aside class="menu-left" style="clear: both;min-height:395px;">   

						<!-- <div class="cat-title"><div style="float:left;margin-right:10px;"><a href="<?=$ROOTPATH?>"><img height="27px" src="<?=$PATHSKIN?>/images/home.png"></a></div><div style="width:259px;"> <?=$nomecategoriacorrente?></div></div>-->
						<div style="clear:both;"></div>
							<?     
							if($category[idpai] == 0) {
								$sqlaux = "idpai=$idcategoria"; // Foi clicado em uma categoria pai então busca todas as subcategorias da categoria $idcategoria
							 }
							 else{
								$sqlaux = "id=$idcategoria";  //Foi clicado em uma subcategoria então busca todos os atributos da subcategoria $idcategoria
							} 
							$sqlp = "select idpai,id,name from category where $sqlaux and display = 'Y' order by sort_order DESC ";
							$rsp = mysql_query($sqlp);
							$numsubcategorias = mysql_num_rows($rsp );						
							
							while($lp = mysql_fetch_object($rsp)){				
							 
								 $titulo  =  utf8_decode($lp->name);
								 $tituloseo =  str_replace(" ","+",retira_acentos($titulo));
								 $id  = $lp->id; 
								// if($category[idpai] == 0) {
								 if($categoriasfilhas) {
								?>  
								<p class="wrapper-menu-title <?=$id?>">
									<a class="arrow-menu open-sub-menu" href="#" data-menu="<?=$id?>">
										<span class="icon-arrow"></span>
									</a>
									<strong class="menu-title-cat <?=$id?> clearfix">
										<a class="left-menu-item" href="<?=$ROOTPATH.'/departamento/'.$tituloseo ?>/<?=$id ?>/<?=$idparceiro?>">
											<span class="menu-name-cat"><?=$titulo?></span> 
										</a> 
									</strong>
								</p> 
								<? }  
							
								//if($category[idpai] <> 0) { // Se a categoria clicada não é pai de ninguem, então busca os atributos dela
								if(!$categoriasfilhas) { // Se a categoria clicada não é pai de ninguem, então busca os atributos dela
									$sqlCat = "select id, nome_atributo from category_atributos where ( id_atributopai=0 or id_atributopai is null) and category_id=$id";
									$rsCat = mysql_query($sqlCat); 
									$numatributos = mysql_num_rows($rsCat);
									while($lc = mysql_fetch_assoc($rsCat)){ 
									
										?>
										<p class="wrapper-menu-title <?echo $lc['id']?>">
											<a class="arrow-menu open-sub-menu" href="#" data-menu="<?echo $lc['id']?>">
												<span class="icon-arrow"></span>
											</a>
											<strong class="menu-title-cat <?echo $lc['id']?> clearfix">
												<a title="<?=utf8_decode($lc['nome_atributo'])?>" class="left-menu-item" href="#">
													<span class="menu-name-cat"><?echo utf8_decode($lc['nome_atributo'])?></span> 
												</a> 
											</strong>
										</p> 
										<?
										$lcId = $lc['id'];
										$sqlAtrib = "select id,nome_atributo from category_atributos where id_atributopai=$lcId";
										$rsAtrib = mysql_query($sqlAtrib); 
										
										while($la = mysql_fetch_assoc($rsAtrib)){ // busca os atributos filhas: Ex: atributo Marca é pai dos atributos Philips e Arno
											$idatributo	=	$la["id"];
										?>
											<ul class="sub-menu <?echo $lc['id']?> clearfix">				
												<li class="sub-menu-item-cat">  
													<a title="<?=utf8_decode($lc['nome_atributo'])?>" class="sub-menu-link" href="javascript:buscaprodutosatrib('<?=$idatributo?>')"> 
													<?  
													if (in_array($idatributo, $a_idsatributo)) { ?>
														<span class="checkbox checked"></span> 
													<? } 
													else{?>
														 <span class="checkbox"></span> 
													<? } ?>
													
													<span class="menu-name-cat"><?echo utf8_decode($la['nome_atributo'])?></span> 
													</a> 
												</li>				
											</ul>
									   <?
										} 
									}
									if($numatributos==0){
										$categoriaavo 	= Table::Fetch('category',$category[idpai]);
										$idavo = $categoriaavo[id];
										?>
										<p class="wrapper-menu-title <?=$idavo?>">
											<a class="arrow-menu open-sub-menu" href="#" data-menu="<?=$idavo?>">
												<span class="icon-arrow"></span>
											</a>
											<strong class="menu-title-cat <?=$idavo?> clearfix">
												<a title="<?=utf8_decode($categoriaavo[name])?>" class="left-menu-item" href="#">
													<span class="menu-name-cat"><?=utf8_decode($categoriaavo[name])?></span> 
												</a> 
											</strong>
										</p> 
										<?
										$sqlsubcat = "select idpai,id,name from category where idpai=".$category[idpai]." and display = 'Y' order by sort_order DESC ";
										$rssubcat = mysql_query($sqlsubcat); 	 
										
										while($linha = mysql_fetch_object($rssubcat)){   
											 $titulo  =  utf8_decode($linha->name);
											 $tituloseo =  str_replace(" ","+",retira_acentos(strtolower($titulo)));
											 $idsubcat  = $linha->id;  
										?> 
											<ul class="sub-menu <?echo $id?> clearfix">				
												<li class="sub-menu-item-cat">  
													<a title="<?=$titulo?>" class="sub-menu-link" href="<?=$ROOTPATH.'/departamento/'.$tituloseo ?>/<?=$idsubcat ?>/<?=$idparceiro?>"> 
														<span class="menu-name-cat"><?echo $titulo ?></span> 
													</a> 
												</li>				
											</ul> 
										<? 
										}
									}
								}
								else{  // Se a categoria clicada é Pai, então busca as subcategorias filhas
								
									$sqlsubcat = "select idpai,id,name from category where idpai=".$id." and display = 'Y' order by sort_order DESC ";
									$rssubcat = mysql_query($sqlsubcat); 
									
									while($linha = mysql_fetch_object($rssubcat)){   
										 $titulo  =  utf8_decode($linha->name);
										 $tituloseo =  str_replace(" ","+",retira_acentos(strtolower($titulo)));
										 $idsubcat  = $linha->id;  
									?> 
										<ul class="sub-menu <?echo $id?> clearfix">				
											<li class="sub-menu-item-cat">  
												<a title="<?=$titulo?>"  class="sub-menu-link" href="<?=$ROOTPATH.'/departamento/'.$tituloseo ?>/<?=$idsubcat ?>/<?=$idparceiro?>"> 
													<span class="menu-name-cat"><?echo $titulo ?></span> 
												</a> 
											</li>				
										</ul> 
									<? 
									}
								}
							}
							if($numsubcategorias==0){
									if($tiporequisicao=="lojista"){
										$sqlp = "select idpai,id,name from category where idpai=0 and display = 'Y' order by sort_order DESC ";
										$rsp = mysql_query($sqlp);
										
										while($linha = mysql_fetch_object($rsp)){   
											$titulo  =  $linha->name ;
											$tituloseo =  str_replace(" ","+",retira_acentos(strtolower($titulo)));
											 $idl  = $linha->id;  
										?>  
											<p class="wrapper-menu-title <?=$idl?>">
												<a class="arrow-menu open-sub-menu" href="#" data-menu="<?=$idl?>">
													<span class="icon-arrow"></span>
												</a>
												<strong class="menu-title-cat <?=$idl?> clearfix">
													<a class="left-menu-item" href="<?=$ROOTPATH.'/departamento/'.$titulo ?>/<?=$idl ?>/<?=$idparceiro?>">
														<span class="menu-name-cat"><?=$titulo?></span> 
													</a> 
												</strong>
											</p> 
										<?
										$sqlz = "select idpai,id,name from category where idpai = $idl and display = 'Y' order by sort_order DESC ";
										$rsz = mysql_query($sqlz);
										$numsubcategorias = mysql_num_rows($rsz );						
										
										while($lp = mysql_fetch_object($rsz)){				
										 
											 $titulosub  =  utf8_decode($lp->name);
											 $tituloseob =  str_replace(" ","+",retira_acentos(strtolower($titulosub)));
											 $idb  = $lp->id; 
										 ?> 
											<ul class="sub-menu <?echo $idl?> clearfix">				
												<li class="sub-menu-item-cat">  
													<a title="<?=$titulosub?>"  class="sub-menu-link" href="<?=$ROOTPATH.'/departamento/'.$titulosub ?>/<?=$idb?>/<?=$idparceiro?>"> 
														<span class="menu-name-cat"><?echo $titulosub ?></span> 
													</a> 
												</li>				
											</ul> 
										<? } 
										}
									}
									else{ ?>
										<div class="cat-title"><div style="float:left;margin-right:10px;"><a href="<?=$ROOTPATH?>"><img height="27px" src="<?=$PATHSKIN?>/images/home.png"></a></div><div style="width:259px;"> <?=$nomecategoriacorrente?></div></div> 
								<? }
							} ?>
							</aside>
							<?php  require_once(DIR_BLOCO."/bannertopo.php"); ?>
							<div class="main-content-cat" style="min-height:400px;">
								<div class=" shelf-container"> 
									<div id="pgofertas">  
										<!-- Mostra os produtos com base na categoria selecionada ou atributo-->
										 <? include(DIR_BLOCO."/produtos_categoria.php"); ?>	 	
									</div> 	
								</div>
							</div>
						</div>
				</div>
			</section> 
			
		<?php require_once(DIR_BLOCO."/rodape.php"); ?>  
		 <input type="hidden" id="atributos" name="atributos" value="<?=$idsatributos?>">
		 
	</div>
	<?php } ?>
</div>
</body>
</html>

 <script> 
 function my_implode_js(separator,array){
	   var temp = '';
	   for(var i=0;i<array.length;i++){
		   temp +=  array[i] 
		   if(i!=array.length-1){
				temp += separator  ; 
		   }
	   }//end of the for loop

	   return temp;
}//end of the function


 var atributos;
 var ids;
 function buscaprodutosatrib(idatributo){
 
	 atributos = J("#atributos").val();
	 if(atributos!=""){
		ids = atributos.split(','); 
		if(J.inArray(idatributo, ids) != -1) { 
			ids.splice(J.inArray(idatributo, ids), 1);
			//console.log(ids);
			 atributos = my_implode_js(',',ids);
			//console.log(atributos);
		}
		else{ 
			atributos = atributos+","+idatributo;
		}
	 }
	 else{
		atributos = idatributo;
	 } 
	 J("#atributos").val(atributos);
 
	 location.href="<?=$ROOTPATH?>/departamento/<?=$nomecategoriacorrente_seo?>/<?=$idcategoria?>/"+atributos
 }
 </script>