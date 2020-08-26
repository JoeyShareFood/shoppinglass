<div style="display:none;" class="tips"><?=__FILE__?></div>

<script>

jQuery('document').ready(function(){
	jQuery('.SendFormSearch').click(function(){
		jQuery('.topbar-search').submit();
	});
	
	jQuery('.search-button').click(function() {
		if(jQuery('#suggestion-search').val() == "") {
		  window.alert("Por favor, informe o produto que procura.");
		}
	});
});

</script>
 		
<div class="topbar-container"> 
	<header class="site-topbar">   
        <ul style="position: absolute; right: 0; top: 14px;font-size: 14px;padding-right: 20px;">
            
                <a href="<?=$ROOTPATH?>/page/20"
                   title="Quer saber mais sobre como funciona para vender e comprar no <?php echo $INI['system']['sitename'];?>?">
                    Como Funciona?
                </a>
            
                <a href="<?=$ROOTPATH?>/contato"
                   title="Surgiu uma d&uacute;vida ou precisa de ajuda? Fale com o <?php echo $INI['system']['sitename'];?>.">
                    Ajuda
                </a>
           
        </ul>

		
		<div class="LinksTop">
			<ul>
				<?php
					$sql = "select  *  from page where status = 1 and MainTop = 1 order by titulo limit 3";
					$rs = mysql_query($sql); 
					if(!$rs){
						echo mysql_error();
						exit;
					}	
			
				$SqlCategory = "select * from category where display = 'Y' order by sort_order desc, id";
				$RsCategory = mysql_query($SqlCategory);
				 			
				?> 
				<?php 
				$a = 0;
				while($l = mysql_fetch_assoc($rs)) {						
								
				  if ($a==0) { ?>
						<nav class="links-column-top">
					<? } ?>
						<li>
							<a href="<?=$ROOTPATH?>/page/<?=$l['id']?>">
								<?=utf8_decode(ucwords(mb_strtolower($l['titulo'], 'UTF-8')))?>
							</a>
						</li>	
					<? 
						$a++;
					if ($a==4) { $a =0;  ?>
						</nav> 
				<? } 
				}
				?> 
				<li><a href="<?=$ROOTPATH?>/contato">Fale Conosco</a></li>
			</ul>
		</div>
		<div class="PanelHeader">
			<div class="logo">
                <a href="<?=$ROOTPATH?>" title="<?php echo $INI['system']['sitename'];?>">
                    <img class="logotipo"
                         border="0"
                         src="<?=$ROOTPATH?>/include/logo/logo.png"
                         alt="Deixa Voar. Pra que guardar se n&atilde;o vai usar?" />
                </a>
            </div>
			<div class="pesquisasite">
				<form method="POST"  class="topbar-search" action="<?php echo $ROOTPATH; ?>/index.php">
					<input id="suggestion-search" type="text" class="input-box search-new" placeholder="Digite o nome do produto que procura" name="cppesquisa">
					<div class="search-category hidden-sm" id="search-cate" style="display:none;">
							<div class="search-cate-title"><span class="search-category-value" id="search-category-value">Todas as categorias</span></div>
						<select name="category" class="search-cate notranslate" id="search-dropdown-box" onchange="jQuery('#search-category-value').text(jQuery('#search-dropdown-box').find('option').filter(':selected').text())">
						<option value="0">Todas as categorias</option>
						<?php while($OptionCategory = mysql_fetch_assoc($RsCategory)) { ?>
							<option value="<?php echo $OptionCategory['id']; ?>"><?php echo utf8_decode($OptionCategory['name']); ?></option>	
						<?php } ?>					
						</select>
					</div>
						<input type="submit" value="" class="search-button">
				</form>			
					<ul class="ListSearch">
					</ul>
				<div class="loadhead" id="loadingcontatoheader"></div>
				<div class="LinksHeader">
					<?php if($login_user){ ?>
					<!--<img src="<?php echo $PATHSKIN; ?>/images/user-alt.png">-->
					<ul style="padding-right: 19px;">
                        <li>
                            <a
                                    title="Veja informa&ccedil;&otilde;es sobre sua conta."
                                    href="<?php echo $ROOTPATH; ?>/pedidos">
                                Ol&aacute;, <?php echo utf8_decode($login_user['realname']); ?>!
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $ROOTPATH; ?>/sair">Sair</a>
                        </li>
                        <li>
                            <a style="color:#fff"
                                    class="button-salmon large-font"
                                    href="<?php echo $ROOTPATH; ?>/adminanunciante/team/edit.php">
                                Quero vender
                            </a>
                        </li>
					</ul>
					<?php } else { ?>
                    <ul>
                        <li>
                            <a class="tk_logar" href="#" id="button-login"
                               title="Entre com a sua conta ou fa&ccedil;a seu cadastro no nosso site.">
                                LOGIN ou cadastre-se
                            </a>
                        </li>
                        <li>
                            <a title="" class="button-salmon large-font <?php if(!$login_user) { ?>tk_cadastrar<?php } ?>"
                               <?php if(!$login_user) { ?>href="#"<?php } else { ?>href="<?php echo $ROOTPATH; ?>/adminanunciante/team/edit.php"<?php } ?>
                            >
                                Quero vender
                            </a>
                        </li>
                    </ul>
					<?php }?>
				</div>
			</div> 
		</div>
			<!--
			<div class="wraper-right-icons" > 
				<? if($login_user){?><div class="cart"><a href="<?=$ROOTPATH."/carrinho" ?>" class="open-link cart-link"><span class="number">1</span><span class="cart-icon"></span></a></div><? } ?>
				<div class="profile"><a href="<?=$ROOTPATH?>/pedidos" class="<? if(!$login_user){?>tk_logar<? } ?> open-link topbar-buttons icon-topbar-link"><span class="number">1</span><div class="profile-img"></div></a> </div>
			</div> 
			--> 
		   <div id="self-help-footer"> 
				
			<!--
			<div class="buttop" style="display: table; width: 22%; padding-top: 50px;"> 
				<button class="btn btn-primary btn-chat" style="padding:2px 14px;float: left; margin-right: 10px;"><span class="icon icon-chat"></span>Chat</button>
				<button style="padding:2px 14px;float:left" class="btn btn-primary btn-email"><span class="icon icon-email"></span>E-mail</button> 
			</div>
			-->
			</div>
		<!-- 
		<div class="wraper-right-icons" > 
		Cart
			<? if($login_user){?><div class="cart"><a href="<?=$ROOTPATH."/carrinho" ?>" class="open-link cart-link"><span class="number">1</span><span class="cart-icon"></span></a></div><? } ?>
			<div class="profile"><a href="<?=$ROOTPATH.'/pedidos' ?>" class="<? if(!$login_user){?> tk_logar <? } ?> open-link topbar-buttons icon-topbar-link"><span class="number">1</span><div class="profile-img" style="background: url(http://static.wmobjects.com.br/webstore/images/global/profile.png) center center;"></div></a> </div>
		 </div> 
		--> 		
		 <div id="self-help-footer" class="footer-self-help" style="border-bottom:none;padding:0;"> 
	 
		 
		</div> 
	</header>
	
	<div class="searchbox clearfix" style="margin-left: 0px;clear:both; ">	
	<?   require(DIR_BLOCO."/bloco_menu.php"); ?>  
	</div> 
	  

	<?  if( mostratopo()){?>
		<div class="toptopo"></div>
	<?  } ?>
 