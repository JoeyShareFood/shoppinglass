	<?php
		require_once("include/code/contato.php");
		$pagetitle = "Surgiu uma dúvida ou precisa de ajuda? Fale com o <span style='color:#01AAB5;'>". $INI['system']['sitename'] ."</span>";
		require_once("include/head.php"); 
	?>
	<style>		
		#formcadcontato li {
			width: 492px;
			float: left;
			margin-right: 60px;
		}
		#formcadcontato select,
		#formcadcontato input {
			width: 100%;
			float: left;
			height: 25px;
		}
		#formcadcontato select {
			height: 35px;
		}
		#formcadcontato label {
			float: left;
			font-size: 13px;
			padding-bottom: 10px;
			padding-top: 10px;
			color: #797979;
		}
		.link-1 {
			border-radius: 5px;
			float: right;
			padding: 10px;
			background: #F77274;
			margin-bottom: 15px;
			margin-top: 15px;
			margin-right: 32px;
			font-size: 13px;
		}
		section {
			background: #FFF;
		}
		
		@media only screen 
		and (max-width : 986px) {
			.tail-top {
				display: none !important;
			}
		}
	</style>
	<body id="page1">
		<div style="display:none;" class="tips"><?=__FILE__?></div>
		<?php
			if(detectResolution()) {
		?>
		<div class="containerM">
			<? require_once(DIR_BLOCO."/headerM.php"); ?>
			<div class="row">
				<div class="titlePage">
					<p>
						Entre em contato
					</p>
				</div>
				<form method="POST" name="formFaleConosco" id="formcadcontato">
					<div class="formContent">
						<label>
							Seu nome:
						</label>
						<input id="title" type="text" maxlength="50" name="title" placeholder="Nome completo" autocomplete="off">
					</div>
					<div class="formContent">
						<label>
							Seu email:
						</label>
						<input id="contact" type="text" maxlength="50" name="contact" placeholder="Email de contato" autocomplete="off">
					</div>					
					<div class="formContent">
						<label>
							Assunto:
						</label>
						<select name="subject" id="subject">
							<option value="Dúvida">
								Dúvida
							</option>
							<option value="Sugestão">
								Sugestão
							</option>
							<option value="Elogio">
								Elogio
							</option>
							<option value="Devolução">
								Devolução
							</option>
							<option value="Um outro assunto">
								Um outro assunto
							</option>													
						</select>
					</div>						
					<div class="formContent">
						<label>
							Mensagem:
						</label>
						<textarea id="content_text" name="content" maxlength="1000"></textarea>
					</div>					
					<div class="formContent">
						<div class="formButton">
							 <a id="formContactSubmit" href="javascript:envio_contato();">Enviar</a>  						  							
						</div>
					</div>
				</form>
			</div>
			<?php
				require_once(DIR_BLOCO."/rodapeM.php");
			?>
		</div>
		<?php } else { ?>
		<div class="tail-top"> 
			<div class="main">
				<?php  require_once(DIR_BLOCO."/header.php"); ?>
				<section id="content">  
					<div class="inside">
						<div class="container">
							<div class="col-1c">
								<div class="container">
								   <div class="col-6" style="margin-top: 11px;"> 
										<h2 style="margin-bottom: 21px;"><?php echo $pagetitle; ?> </h2>
										 <form id="formcadcontato" name="formcadcontato" method="post" action="">
											<ul> 
												<li>
													<label>
														Seu nome:
													</label>
													<input name="title" type="text" id="title">
												</li>
												<li>
													<label>
														Seu email:
													</label> 
													<input name="contact" type="text" id="contact">
												</li> 
												<li>
													<label>
														Sobre qual assunto você quer falar com a gente?
													</label>
													<select name="subject" id="subject" style="width:520px;color:#797979;">
														<option value="Dúvida">
															Dúvida
														</option>
														<option value="Sugestão">
															Sugestão
														</option>
														<option value="Elogio">
															Elogio
														</option>
														<option value="Devolução">
															Devolução
														</option>
														<option value="Um outro assunto">
															Um outro assunto
														</option>
													</select>
												</li>
												<li style="width:1110px;">
													<label>
														Mensagem:
													</label>
													<textarea cols="30" rows="5" name="content" id="content_text" ></textarea>
												</li> 
												<li style="float:right;">
													<a href="javascript:envio_contato();"  class="link-1">
														Enviar
													</a>
												</li>
											</ul>
										 </form>
									</div>
								 </div>
							</div>
						</div>
					</div>
				</section>
		   </div>
		</div> 	 
		<?php require_once(DIR_BLOCO."/rodape.php"); ?>
		<script language="javascript">	  
			J("#menu1").atli("class","");
			J("#menu2").atli("class","");
			J("#menu3").atli("class","");
			J("#menu4").atli("class","");
		</script>
		<?php } ?>
		<script language="javascript">
			  
			function envio_contato(){

					if(J("#title").val() == "Insira seu nome"){
						alert("Por favor, informe o seu nome.")
						document.getElementById("title").focus();
						return;
					}
										
					if(J("#contact").val() == "Insira seu e-mail"){
						alert("Por favor, informe o seu email.")
						document.getElementById("contact").focus();
						return;
					}
					  
		 
					if(J('#content_text').val() == ""){
						alert("Por favor, escreva a mensagem.")
						document.getElementById("content_text").focus();
						return;
					}		
					 
				   J("#formcadcontato").submit();	 
			}	
			 
		  <?php  
			if($enviou){ ?> 
				alert("Obrigado por entrar em contato com a gente, responderemos o mais rápido possível :)")
				location.href  = '<?php echo $INI['system']['wwwprefix']?>/index.php';
			   <? }
			else if($_POST and !$enviou){?>
				alert("Não foi possível enviar os dados, tente novamente mais tarde.")
			<? } ?>
		  
		</script>	
	</body>
</html>
