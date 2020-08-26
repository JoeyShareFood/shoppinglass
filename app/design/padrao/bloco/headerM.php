	<div style="display:none;" class="tips"><?=__FILE__?></div> 
	<div class="headerM">
        <div class="navigation col-20">
            <a href="#">
                <i class="material-icons md-48">&#xE5D2;</i>
            </a>
        </div>

        <div class="col-60">
			<a href="<?php echo $ROOTPATH; ?>" class="logo">
				<img src="<?php echo $ROOTPATH; ?>/include/logo/logo.png"
                     alt="<?php echo $INI['system']['sitename'];?>"
                     title="<?php echo $INI['system']['sitename'];?>">
			</a>
		</div>

        <div class="search-icon-div col-20" style="margin-top: 7%">
            <i style="color: #AAAAAA;margin-left:27%;" class="material-icons md-48">&#xE8B6;</i>
        </div>
	</div>

    <div class="input-search hidden">
        <form method="GET" action="<?php echo $ROOTPATH; ?>">
            <div class="formContent">
                <input type="text" name="q" id="query" placeholder="Informe o que voc&ecirc; procura" style="width:93%;">
            </div>
            <div class="formContent">
                <select name = "categories" style="width:100%;">
                    <option value="">Escolha uma categoria</option>
                    <?php
                    $indentacao = "....";

                    $sql = "select * from category where display ='Y' and idpai=0 order by sort_order desc,name";
                    $rs = mysql_query($sql) or die(mysql_error());

                    while($l = mysql_fetch_assoc($rs)){

                        echo "<option " . $selected . " value='" . $l['id'] . "'" . $selected . ">" . utf8_decode(displaySubStringWithStrip($l['name'],30)) . "</option>";
                        exibe_filhos_mobile($l["id"], $indentacao, $l['group_id']);
                    }
                    ?>
                </select>
            </div>
            <div class="formContent">
                <input type="submit" class="btn-form-search" value="Buscar">
            </div>
        </form>
    </div>

	<div class="navigationMobile hidden">
		<ul>		
			<li class="linkPanel">
				<a href="<?php echo $ROOTPATH; ?>">
					<span class="navigationText">
					<?php if($login_user) { ?>
						<a href="<?php echo $ROOTPATH; ?>">Ol&aacute; <?php echo utf8_decode($login_user['realname']); ?>!</a>
					<?php } else { ?>
						<a href="<?php echo $ROOTPATH; ?>/mlogin">LOGIN ou cadastre-se</a>
					<?php } ?>
					</span>
				</a>
			</li>			
			<li class="linkPanel">
				<?php if($login_user) { ?>
				<a href="<?php echo $ROOTPATH; ?>/adminanunciante/team/edit.php">
					Quero vender
				</a>
				<?php } else { ?>
				<a href="<?php echo $ROOTPATH; ?>/mlogin">
					Quero vender
				</a>				
				<?php } ?>
			</li>				
			<li class="linkPanel <?php if(!($login_user)) { ?>hidden<?php } ?>">
				<?php if($login_user) { ?>
					<a class="openLinkPanelUser" href="#">Minha conta</a>
				<?php } ?>
				<ul class="linkPanelUser hidden">
					<li><a href="<?php echo $ROOTPATH; ?>/store/<?php echo $login_user_id; ?>">Ver minha lojinha</a></li>
					<li><a href="<?php echo $ROOTPATH; ?>/pedidos">Minhas compras</a></li>
					<li><a href="<?php echo $ROOTPATH; ?>/adminanunciante/order/index.php">Minhas vendas</a></li>
					<li><a href="<?php echo $ROOTPATH; ?>/adminanunciante">Meus an&uacute;ncios</a></li>
					<li><a href="<?php echo $ROOTPATH; ?>/adminanunciante/system/index.php">Personalizar minha lojinha</a></li>
					<!--<li><a href="<?php echo $ROOTPATH; ?>/store/<?php echo $login_user['id']; ?>">Ver minha lojinha</a></li>-->
					<li><a href="<?php echo $ROOTPATH; ?>/qualificacoes/enviadas">Qualifica&ccedil;&otilde;es enviadas</a></li>
					<li><a href="<?php echo $ROOTPATH; ?>/qualificacoes/recebidas">Qualifica&ccedil;&otilde;es recebidas</a></li>
					<li><a href="<?php echo $ROOTPATH; ?>/perguntas/enviadas">Perguntas enviadas</a></li>
					<li class="lastList"><a href="<?php echo $ROOTPATH; ?>/perguntas/recebidas">Perguntas recebidas</a></li>
				</ul>
			</li>
			<?php if($login_user) { ?>
			<li class="linkPanel">
				<a href="<?php echo $ROOTPATH; ?>/sair">
					Sair
				</a>
			</li>			
			<?php } ?>
		</ul>
	</div>