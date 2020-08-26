<div style="display:none;" class="tips"><?=__FILE__?></div>
<style>
#pgofertas {margin-left: 0; margin-top: -24px; }
.owl-carousel .owl-wrapper, .owl-carousel .owl-item { width: 22.5%;} 
.NameOffer {
  height: 18px;
}

</style>
<?   
 
 if( $INI['option']['ofertas_finalizadas_populares'] == "N"){
	$condicao =  " and end_time > '".time()."'";
}

getcategoriafilhas($idcategoria);   				
$idcategorias.= $categoriasfilhasprod.$idcategoria;

$sql ="select id,title, market_price, team_price, image, condicoes_produto from team where moderacao = 'Y' and posicionamento <> 5 and group_id in( ".$idcategorias." )  $condicao order by sort_order, `id` DESC , `now_number` DESC";

$rs = mysql_query($sql) or die(mysql_error()); 
$contador = mysql_num_rows($rs);	

//echo $sql ;  
?>
		
<div class="telefonia home-list clearfix hover" style="margin-top:30px;">   
		<div class="shelf-home shelf-container shelf-horizontal  two-rows" style="width:975px;">	
			<div class="shelf-itens carousel-shelf-home arrow-big clearfix owl-carousel owl-theme" style="opacity: 1; display: block;">
				<div class="owl-wrapper-outer">
					<div class="owl-wrapper" style="width: 104%; left: 0px; display: block; margin-top: 5px;">
 
						<?
						while ($team = mysql_fetch_assoc($rs)){    
							$BlocosOfertas->getDados($team);
							$avaliacaomedia = avaliacaomedia($team['id']);
							$avaliacaomediaformat1 =  number_format($avaliacaomedia, 1, '.', ''); 
							$avaliacaomediaformat = str_replace(".","_",$avaliacaomediaformat1); 
							
							require(DIR_BLOCO."/lista_produtos.php");   
						}  
						 if($contador==0){?>  
								<div class="empty-cart-header-message"><div class="empty-cart-sign" style="font-size: 25px;margin-top: 151px;margin-left: 214px;color: #666;position:static !important;"> Nenhum produto encontrado  :(</div>    </div>
								<!-- problema do rodape que  sobe  -->
						<? } ?>
						<div class='telefonia home-list clearfix'> 
						</div>
					</div>
				</div>
			</div>			
		</div> 
 </div> 