						<div style="display:none;" class="tips"><?=__FILE__?></div> 
						<style>
							#my-account-container.my-account-page {
								margin-left: 30px !important;
							}
							.link-list.list-right {
								margin-top: -155px !important;
							}
						</style>
						<div class="my-account">
							<div class="profile-top clearfix">
								<div class="profile-info pull-left" style="display:none;">
									<div data-complete="........." data-fields="9" id="profile-completeness">
										<a class="profile-photo" href="#profile">
											<span class="profile-photo-container">
											<img width="110" height="110" src="http://static.wmobjects.com.br/selfhelp/desktop/styles/images/user-picture.jpg"></span>
										</a>
										<svg height="150" version="1.1" width="150" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative; left: -0.5px;"><desc>Created with Raphaël 2.1.2</desc><defs/><path style="fill-opacity: 0;" fill="none" stroke="#ffffff" d="M75,21A54,54,0,1,1,74.99,21" stroke-width="6" fill-opacity="0" class=""/><path style="fill-opacity: 0;" fill="none" stroke="#f7f7f7" d="M75,3A72,72,0,1,1,74.99,3" stroke-width="15" fill-opacity="0"/><path style="fill-opacity: 0;" fill="none" stroke="#f2f2f2" d="M75,12A63,63,0,1,1,74.99,12" stroke-width="14" fill-opacity="0"/><path style="fill-opacity: 0;" fill="none" stroke="#f47b20" d="M75,12A63,63,0,1,1,74.99,12" stroke-width="14" fill-opacity="0"/></svg>
									</div> 
								</div>
								<div class="profile-summary pull-left">
									<h2 class="title">Helloo, <span class="highlight"><?=getnome($login_user_id)?></span>! Bem-vindo à sua conta ;)</h2>
									<ul class="link-list"> 
										<li><a class="tk_alterar_dados" href="#">Alterar meus dados</a></li> 
										<li><a class="" href="<?php echo $ROOTPATH; ?>/pedidos">Minhas compras</a></li>
										<li><a class="" href="<?php echo $ROOTPATH; ?>/adminanunciante/order/index.php">Minhas vendas</a></li>
										<li><a class="" href="<?php echo $ROOTPATH; ?>/perguntas/recebidas">Perguntas recebidas</a></li> 
										<li><a class="" href="<?php echo $ROOTPATH; ?>/perguntas/enviadas">Perguntas enviadas</a></li>    
									</ul>									
									<ul class="link-list list-right">
										<li><a class="" href="<?php echo $ROOTPATH; ?>/adminanunciante">Meus anúncios</a></li>  
										<li style="display:none;"><a class="" href="<?php echo $ROOTPATH; ?>/faturas">Minhas faturas</a></li>
										<li><a class="" href="<?php echo $ROOTPATH; ?>/qualificacoes/recebidas">Qualificações recebidas</a></li>
										<li><a class="" href="<?php echo $ROOTPATH; ?>/qualificacoes/enviadas">Qualificações enviadas</a></li>
										<li><a class="" href="<?php echo $ROOTPATH; ?>/adminanunciante/system/index.php">Personalizar minha lojinha</a></li>
										<li><a class="" href="<?php echo $ROOTPATH; ?>/store/<?php echo $login_user_id; ?>">Ver minha lojinha</a></li>
									</ul>
								</div>
							</div>
						</div>