<div style="display:none;height:36px;" class="tips"><?=__FILE__?></div>
<?php
	
	if(!(empty($team['image']))) {		
		$dirImage = getImagem($team,"fit");
	}	
	
	if(!(empty($teams['image']))) {		
		$dirImage = getImagem($teams,"fit");
	}
	
	if(!(empty($teamss['image']))) {		
		$dirImage = getImagem($teamss,"fit");
	}
	
	$tamanho_prod = $BlocosOfertas->tamanho_produto;
?>

<div class="owl-item">

    <a title="<?=$BlocosOfertas->tituloferta?>"
       href="<?php echo $BlocosOfertas->linkoferta ?>"
        style="height: 100%; display: block;">

        <div class="bordalist">
		    <div class="shelf-item clearfix">
                <?php
                if($team['condicoes_produto'] == "nunca usado") {
                    ?>
                    <div class="conditions-product">
                        <?php echo empty($team['condicoes_produto']) ? "" : $team['condicoes_produto']; ?>
                    </div>
                <?php } ?>
                <figure class="listra">
                    <div class="imagem-produto-container" style="display: table-cell; vertical-align: middle;">
                        <img class="lazyOwl"
                             alt="<?=$BlocosOfertas->tituloferta?>"
                             src="<?php echo $BlocosOfertas->imagemoferta ?>">
                    </div>
                </figure>
            </div>


            <p class="name-product">
                <?php echo displaySubStringWithStrip($BlocosOfertas->tituloferta, 45); ?>
            </p>

            <div class="price">
                <!-- Session Preço -->
                <p style="text-align: center">
                    <!--De:-->
                    <?php
                    if($team['market_price'] != "0.01" && $team['market_price'] != "0.00") {
						if($team['market_price'] != $team['team_price']) {
                    ?>
                    <span class="preco-de">R$ <?=getpreco($team['market_price'])?></span>
                    <?php }} ?>

                    <!--Por:-->
                    <span class="preco-por">
						R$ <?=getpreco($team['team_price'])?>
					</span>

                    <!--session Desconto produto-->
                    <?php
                    if($team['market_price'] != "0.01" && $team['market_price'] != "0.00" && !(empty($BlocosOfertas->porcentagem))) {
                    ?>
                    <span class="discount-product">
                        <?php echo empty($BlocosOfertas->porcentagem) ? "" : $BlocosOfertas->porcentagem . "%"; ?> off
                    </span>
                    <?php } ?>
                    <!--endsession Desconto produto-->
                </p>
                <!-- End Session Preço -->
            </div>
            <!-- Session Frete Grátis -->
            <?php if($team['frete'] == 2) {	?>
                <div class="frete">
                    <i class="fa fa-truck fa-flip-horizontal" aria-hidden="true"></i> Frete gr&aacute;tis
                </div>
            <?php } ?>
            <!-- Endsession Frete Grátis -->
    </div>
    </a>
</div>