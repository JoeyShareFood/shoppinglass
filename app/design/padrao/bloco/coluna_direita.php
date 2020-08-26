<div class="ColunaDireita">
	<h2 class="menu-title">	 
	</h2>
	<div class="telefonia home-list clearfix hover">   
		<div class="shelf-home shelf-container shelf-horizontal  two-rows">	
			<div class="shelf-itens carousel-shelf-home arrow-big clearfix owl-carousel owl-theme" style="opacity: 1; display: block;">
				<div class="owl-wrapper-outer">
					<div class="owl-wrapper" style="width: 104%; left: 0px; display: block;">	
						<div class="OfertasLateralDireita">
							<p>Ofertas</p>
						</div>
						<? foreach ($teams as $team) {    
								$BlocosOfertas->getDados($team);
								$avaliacaomedia = avaliacaomedia($team['id']);
								$avaliacaomediaformat1 =  number_format($avaliacaomedia, 1, '.', ''); 
								$avaliacaomediaformat = str_replace(".","_",$avaliacaomediaformat1);
								require(DIR_BLOCO."/lista_produtos_coluna_direita.php"); 
						} 
						if($count==0){
							if(!empty($cppesquisa )){?> 
								<div style="font-size: 13px; margin-left: 18px; color:#303030;">
									A pesquisa pela palavra "<b> <?=$cppesquisa?> </b>" não retornou nenhum produto.
								</div>
							<? } 
						}
						?>
					</div>
				</div>
			</div>
		</div>			
	</div>  
</div>