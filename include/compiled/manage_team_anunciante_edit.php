<?php include template("manage_anunciante_header"); ?>
<?php //require("ini.php");?> 

 
<style>
	.cjt-wrapped-select,
	.option_contents INPUT[type="text"]	{
		width: 100%;
	}
	#type-select-cjt-wrapped-select .cjt-wrapped-select-skin,
	#type-select-cjt-wrapped-select select {
		height: 34px;
	}
	.report-head {
		margin-top: 10px;
		font-size: 13px;
	}
	.label {
		color: #586061 !important;
		padding: 0 !important;
		margin: 0 !important;
		font-size: 13px !important;
		font-weight: bold !important;
	}
	#run-button {
		height: 35px;
		overflow: visible;
		margin-bottom: 15px;
		font-weight: bold;
		text-transform: uppercase;
	}
	.top-heading.group h4 {
		color: #FFF;
	}
</style>

<div id="leader" class="container-fluid">
	<div id="content" class="clear mainwide row">
        <div class="clear box"> 
            <div class="box-content">
                <div class="sect">
				<form id="nform" id="nform"  method="post" action="/adminanunciante/team/edit.php?id=<?php echo $team['id']; ?>" enctype="multipart/form-data" class="validator">
				<input type="hidden" id="id" name="id" value="<?php echo $team['id']; ?>" />
				<input type="hidden" name="guarantee" value="Y" />
				<input type="hidden" name="system" value="Y" /> 
				<input type="hidden" name="www" id="www"  value="<?=$INI['	']['wwwprefix']?>" /> 
				<div class="option_box">
					<div class="top-heading group">
						<div class="col-md-6 col-xs-12 col-sm-12" style="padding-top: 6px; padding-left: 0px;">
							<h4>Informações gerais do anúncio <?=$team['id']?></h4>
						</div>
						<div class="the-button col-md-6 col-xs-12 col-sm-12">
							<input type="hidden" value="remote" id="deliverytype" name="deliverytype">
							<input type="hidden" value="" id="cadastraratributos" name="cadastraratributos">
							<input type="hidden" value="" id="idpacote" name="idpacote">
							<div class="col-md-3 col-xs-12 col-sm-12 pull-right">
								<button onclick="doupdate();" class="btn btn-success btn-block" type="button">
									Salvar
								</button>
							</div>
							<div class="col-md-3 col-xs-12 col-sm-12 pull-right">
								<button  onclick="javascript:location.href='index.php'" class="btn btn-warning btn-block" type="button">
									Cancelar
								</button>
							</div>
						</div> 
					</div> 
				 
					 <div id="container_box">
						<div id="option_contents" class="option_contents">  
							<div class="form-contain group">
								<!-- =============================   coluna esquerda   =====================================-->
								<div class="starts col-md-6 col-xs-12 col-sm-12">
									<input type="hidden" value="normal" name="team_type">    
									<div style="clear:both;"class="report-head">Nome do produto: <span class="cpanel-date-hint"></span>  <img style="cursor:help" class="tTip" title="Tenha certeza que este campo irá conter as principais palavras chaves deste produto. Não se esqueça que estas mesmas palavras devem estar no campo descrição de produto para otimizar ainda mais as buscas." src="<?=$ROOTPATH?>/media/css/i/info.png"></div>
									<div class="group">
										<input type="text" name="title"  maxlength="172" id="title" class="form-control ckeditor" value="<?php echo htmlspecialchars($team['title']); ?>" /> 
									</div>  
									<div style="clear:both;"class="report-head">Nome do produto Resumido até 50 caracteres: <span class="cpanel-date-hint"> </span></div>
									<div class="group">
										<input type="text" name="titleresumido"  maxlength="50" id="titleresumido" class="form-control ckeditor" value="<?php echo htmlspecialchars($team['titleresumido']); ?>" />  
									</div>  
									<div style="clear:both;"class="report-head">Condições do produto:  <span class="cpanel-date-hint"> </span></div>
									<div class="group">
										<div class="cjt-wrapped-select" id="type-select-cjt-wrapped-select">
										<select  name="condicoes_produto" id="condicoes_produto" onchange="$('#select_condicoes_produto').text($('#condicoes_produto').find('option').filter(':selected').text())"> 
											<option value=""> </option>
											<option value="usado" <?php if($team['condicoes_produto'] == "usado") { ?>selected<?php } ?>>Usado</option>
											<option value="nunca usado" <?php if($team['condicoes_produto'] == "nunca usado") { ?>selected<?php } ?>>Nunca usado</option>
										</select>										
										<div name="select_condicoes_produto" id="select_condicoes_produto" class="cjt-wrapped-select-skin"><B><?php if(empty($team['condicoes_produto'])) { ?>Informe a condição do produto<?php } else { echo ucfirst($team['condicoes_produto']); } ?></B></div>
										<div class="cjt-wrapped-select-icon"></div>
										</div>
									</div> 				
								</div>
								<!-- =============================   fim coluna esquerda   =====================================-->
								<!-- =============================   coluna direita   =====================================-->
								<div class="ends col-md-6 col-xs-12 col-sm-12">
								
									<div id="c_categoria">
										<div class="report-head">Categoria: <span class="cpanel-date-hint"></span> &nbsp;<img class="tTip" title="Você pode escolher uma categoria para este produto. Isso ajuda os usuários a encontrar mais facilmente um produto." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png"></div>
										<div class="group">
											<div class="cjt-wrapped-select" id="type-select-cjt-wrapped-select">
											<select  name="group_id" id="group_id" onchange="$('#select_group_id').text($('#group_id').find('option').filter(':selected').text())" class="form-control ckeditor"> 
												<option value=""> </option>
												 <?php 
														 
												   $indentacao = "....";
											     $sql = "select * from category where display ='Y' and idpai=0 order by sort_order desc,name";

													$rs = mysql_query($sql) or die(mysql_error());
													while($l = mysql_fetch_assoc($rs)){
													 $selected ="";
													 if($team['group_id'] == $l['id']){
															$selected =  " selected ";
													 }
		
														echo "<option value='$l[id]' $selected>".displaySubStringWithStrip($l[name],30)."</option>";
														exibe_filhos($l["id"],$indentacao,$team['group_id']);
													}
													
													 ?>
											</select>
										<script>
											URL = "<?php echo $ROOTPATH; ?>/ajax/filtro_pesquisa.php";
											jQuery(function() {
												jQuery('#group_id').bind('change', function(ev) {
													jQuery.ajax({
														url: URL,
														type: 'POST',
														data: { filtro: 'atributos', idcategoria: jQuery('#group_id').val() },
														beforeSend: function() {
															jQuery('#select_id_atributo').html('Carregando...');
															jQuery('#id_atributo').html('<option>Carregando...</option>');
														},
														success: function(r) {
															jQuery('#select_id_atributo').html('Selecione o atributo (Opcional)');
															jQuery('#id_atributo').html(r);
														}
													});
												});
											});
										</script>
										
											<div name="select_group_id" id="select_group_id" class="cjt-wrapped-select-skin">Informe a categoria</div>
											<div class="cjt-wrapped-select-icon"></div>
											</div>
										</div>   
									</div> 
									<div id="url_botao_comprar">									
										<div class="report-head">Código de Referência: <span class="cpanel-date-hint">Código externo do produto (opcional)</span></div>
										<div class="group">
											<input type="text" id="codreferencia" name="codreferencia" value="<?php echo  $team['codreferencia'] ; ?>" class="form-control ckeditor"> 
										</div>	
									</div>									
								 </div>
								<!-- =============================  fim coluna direita  =====================================-->
							</div> 
						</div>
					</div>
				</div>

				<!-- ********************************************* ABA Controle de Estoque e periodo --> 
				<div class="option_box">
					<div class="top-heading group">
						<h4>Opcionais do produto</h4>
					</div> 
					<div id="container_box">
						<div id="option_contents" class="option_contents">  
							<div class="form-contain group">
								<!-- =============================   coluna esquerda   =====================================-->
								<div class="starts col-md-6 col-xs-12 col-sm-12">
									<?php
										if($option_data) {
											while($option = mysql_fetch_assoc($rs_options)) {
									?>
									<div id="c_vendas" class="option_<?php echo $option['id']; ?>_content">	 
										<div id="c_estoque" class="c_estoque_add">
											<a href="#option_<?php echo $option['id']; ?>_content" class="delete_option" attr-id="<?php echo $option['id']; ?>">
												<img src="<?php echo $ROOTPATH; ?>/media/css/i/excluir.png" style="max-width:10px;"> Apagar opção
											</a>
											<div id="stock_content">
												<div style="clear:both;"class="report-head">Estoque: <span class="cpanel-date-hint"></span><img style="cursor:help" class="tTip" title="Quantidade em estoque." src="<?=$ROOTPATH?>/media/css/i/info.png"></div>
												<div class="group">
													<input type="text" name="stock[]"  onKeyPress="return SomenteNumero(event);"  id="stock" class="form-control ckeditor"  value="<?php echo $option['stock']; ?>" maxlength="6"  /> 
												</div> 
											</div> 
											<div id="size_content">
												<div style="clear:both;"class="report-head">Numeração: <span class="cpanel-date-hint"></span><img style="cursor:help" class="tTip" title="Tamanho do produto." src="<?=$ROOTPATH?>/media/css/i/info.png"> </div>
												<div class="group">
													<input type="text" name="size[]" id="size" maxlength="2" class="form-control ckeditor"  value="<?php echo $option['size']; ?>" >
												</div> 
											</div> 
											<div id="color_content">
												<div style="clear:both;"class="report-head">Cor: <span class="cpanel-date-hint"></span><img style="cursor:help" class="tTip" title="Cor do produto." src="<?=$ROOTPATH?>/media/css/i/info.png"> </div>
												<div class="group">
													<input type="text" name="color[]" id="color" maxlength="100" class="form-control ckeditor"  value="<?php echo $option['color']; ?>">
												</div> 
											</div> 
											<input type="hidden" name="id_option[]" value="<?php echo $option['id']; ?>">
										</div> 
									</div> 
									<?php } } else { ?>
									<div id="c_vendas">	 
										<div id="c_estoque" class="c_estoque_add">
											<div id="stock_content">
												<div style="clear:both;"class="report-head">Estoque: <span class="cpanel-date-hint">Obrigatório</span> <img style="cursor:help" class="tTip" title="Quantidade em estoque." src="<?=$ROOTPATH?>/media/css/i/info.png"></div>
												<div class="group">
													<input type="text" name="stock[]"  onKeyPress="return SomenteNumero(event);"  id="stock" class="form-control ckeditor" maxlength="6"  />
												</div> 
											</div> 
											<div id="size_content">
												<div style="clear:both;"class="report-head">Numeração: <span class="cpanel-date-hint">Opcional</span> <img style="cursor:help" class="tTip" title="Tamanho do produto." src="<?=$ROOTPATH?>/media/css/i/info.png"></div>
												<div class="group">
													<input type="text" name="size[]" id="size" maxlength="2" class="form-control ckeditor"> 
												</div> 
											</div> 
											<div id="color_content">
												<div style="clear:both;"class="report-head">Cor: <span class="cpanel-date-hint">Opcional</span> <img style="cursor:help" class="tTip" title="Cor do produto." src="<?=$ROOTPATH?>/media/css/i/info.png"> </div>
												<div class="group">
													<input type="text" name="color[]" id="color" maxlength="100" class="form-control ckeditor">  
												</div> 
											</div> 
										</div> 
									</div>									
									<?php } ?>
								</div>
								<!-- ============================= // fim coluna esquerda // =====================================-->
								<!-- ============================= // coluna direita // =====================================-->
								<div class="ends col-md-6 col-xs-12 col-sm-12"> 
									<div class="input_fields_wrap">
										<button class="add_field_button btn btn-primary">Adicione mais opções</button>
									</div>								 
								</div>
							</div>
								<!-- ============================= // fim coluna direita // =====================================-->
						</div> 
					</div>
				</div>
					
				<!-- ********************************************* ABA Controle de Estoque e periodo --> 
				<div class="option_box">
					<div class="top-heading group">
						<h4>Controle</h4>
					</div> 
					<div id="container_box">
						<div id="option_contents" class="option_contents">  
							<div class="form-contain group">
								<!-- =============================   coluna esquerda   =====================================-->
								<div class="starts col-md-6 col-xs-12 col-sm-12">
									<div id="c_vendas">	 
										<div style="clear:both;"class="report-head">Quantidade mínima por pessoa: <span class="cpanel-date-hint"></span> <img style="cursor:help" class="tTip" title="Quantidade mínima para finalizar o pedido. Ex: Para comprar este produto, o cliente deverá comprar 5 unidades ou mais." src="<?=$ROOTPATH?>/media/css/i/info.png"> </div>
										<div class="group">
											<input type="text" name="minimo_pessoa"  onKeyPress="return SomenteNumero(event);"   id="minimo_pessoa" class="form-control ckeditor"  value="<?php echo intval($team['minimo_pessoa']); ?>" maxLength="6"  /> 
										</div>

									</div> 
								</div>
								<!-- ============================= // fim coluna esquerda // =====================================-->
								<!-- ============================= // coluna direita // =====================================-->
								<div class="ends col-md-6 col-xs-12 col-sm-12"> 
								
									
											<div style="clear:both;"class="report-head">Quantidade máxima por pessoa: <span class="cpanel-date-hint"></span><img style="cursor:help" class="tTip" title="Quantidade máxima que cada cliente poderá comprar." src="<?=$ROOTPATH?>/media/css/i/info.png"> </div>
										<div class="group">
											<input type="text" name="per_number"  onKeyPress="return SomenteNumero(event);"   id="per_number" class="form-control ckeditor"  value="<?php echo intval($team['per_number']); ?>" maxLength="6"  /> 
										</div> 
										
									<div style="display:none;">
										<div class="report-head">Data início: <span class="cpanel-date-hint"></span></div>
										<div class="group">
											<input style="width:40%;" type="text"  xd="<?php echo date('d/m/Y', $team['begin_time']); ?>" name="begin_time" id="begin_time" class="form-control ckeditor"  maxlength="10"  value="<?php echo date('d/m/Y', $team['begin_time']); ?>"/>
											 <img  style="cursor:pointer;" onclick="javascript:displayCalendar(document.forms[0].begin_time,'dd/mm/yyyy',this);" alt="select date" src="<?=$ROOTPATH?>/media/css/i/calendar.png"> 
										</div> 
									 
										<div class="report-head">Hora início: <span class="cpanel-date-hint"></span></div>
										<div class="group">
											<input style="width:40%;" type="text" id="begin_time2"  name="begin_time2"  value="<?php echo  $team['begin_time2'] ; ?>"  class="form-control ckeditor"  maxlength="10"  />
										</div>   
										<div class="report-head">Data fim: <span class="cpanel-date-hint"></span></div>
										<div class="group">
											<input style="width:40%;" type="text"  xd="<?php echo date('d/m/Y', $team['end_time']); ?>" name="end_time" id="end_time" class="form-control ckeditor"  maxlength="10"  value="<?php echo date('d/m/Y', $team['end_time']); ?>"/>
											 <img  style="cursor:pointer;" onclick="javascript:displayCalendar(document.forms[0].end_time,'dd/mm/yyyy',this);" alt="select date" src="<?=$ROOTPATH?>/media/css/i/calendar.png"> 
										</div> 
									 
										<div class="report-head">Hora fim: <span class="cpanel-date-hint"></span></div>
										<div class="group">
											<input style="width:40%;" type="text" name="end_time2" id="end_time2"   value="<?php echo  $team['end_time2'] ; ?>"  class="form-control ckeditor"  maxlength="10"  />
										</div> 
									</div>
							 
								 </div>
								</div>
								<!-- ============================= // fim coluna direita // =====================================-->
							</div> 
						</div>
					</div>
					
					<!-- ********************************************* ABA Informações de preço e pagamento --> 
				 
				<div class="option_box" id="abapagamento">
					<div class="top-heading group">
						<h4>Informações de Preço e Pagamento</h4>
					</div> 
					<div id="container_box">
						<div id="option_contents" class="option_contents">  
							<div class="form-contain group">
								<!-- =============================   coluna esquerda   =====================================-->
								<div class="starts col-md-6 col-xs-12 col-sm-12">   
									<div id="c_valores">
										<div style="clear:both;"class="report-head">De:  <span class="cpanel-date-hint"></span><img style="cursor:help" class="tTip" title="Valor antigo do produto." src="<?=$ROOTPATH?>/media/css/i/info.png"> </div>
										<div class="group">
											<input type="text" name="market_price"  id="market_price" class="form-control ckeditor"   value="<?php echo $team['market_price'] ; ?>" />
										</div> 
										<div style="clear:both;"class="report-head">Por: <span class="cpanel-date-hint"></span><img style="cursor:help" class="tTip" title="Valor atual do produto" src="<?=$ROOTPATH?>/media/css/i/info.png"> </div>
										<div class="group">
											<input type="text" name="team_price"  id="team_price"  class="form-control ckeditor"   value="<?php echo  $team['team_price'] ; ?>"  />
										</div> 	
									</div> 
								</div>
								<!-- ============================= // fim coluna esquerda // =====================================-->
								<!-- ============================= // coluna direita // =====================================-->
								<div class="ends col-md-6 col-xs-12 col-sm-12"> 
								 
								 	<div class="report-head">Observação: <span class="cpanel-date-hint">Ex: 10x de R$ 12,00 sem juros pelo pagseguro. <img style="cursor:help" class="tTip" title="Máx de 40 caracteres em letras minúsculas. Você pode colocar letras maiúsculas com menor número de caracteres. Cuidado para não quebrar o layout." src="<?=$ROOTPATH?>/media/css/i/info.png">  </span></div>
										<div class="group">
											<input type="text" class="form-control" maxlength="40"  id="observacao_preco" name="observacao_preco" value="<?php echo  $team['observacao_preco'] ; ?>"> 
										</div> 
								   </div> 
								</div>
								<!-- ============================= // fim coluna direita // =====================================-->
							</div> 
						</div>
					</div>
				 
				 <!-- ********************************************* ABA Fotos --> 
				<div class="option_box">
					<div class="top-heading group"> 
					<h4>Imagens do Produto </h4> </div> 
					<div id="container_box">
						<div id="option_contents" class="option_contents">  
							<div class="form-contain group">
								<!-- =============================   coluna esquerda   =====================================-->
								<div class="starts col-md-6 col-xs-12 col-sm-12">  
									<div style="clear:both;"class="report-head">Foto 1:  <span class="cpanel-date-hint"> <!-- <a target="_blank" href="<?=$ROOTPATH?>/media/css/i/fotoexemplo.jpg">baixar</a> imagem exemplo --> </span>  
									</div>
									<div class="group">
										<input type="file" name="upload_image"  id="upload_image" class="form-control ckeditor photovalidator"  value="<?php  $team['upload_image'] ; ?>" />  <?php if($team['image']){?> <br><span style="clear:both;" class="cpanel-date-hint"> <?php echo team_image($team['image']); ?>&nbsp;&nbsp;<a href="javascript:delimagem(<?php echo $team['id']; ?>, 'image');" ><img style="width: 13px;" src="<?=$ROOTPATH?>/media/css/i/excluir.png" /> </a></span> <?php }?>
									 </div> 
									<div style="clear:both;"class="report-head">Foto 2: <span class="cpanel-date-hint"></span></div>
									<div class="group">
										<input type="file" name="upload_image1"  id="upload_image1" class="form-control ckeditor photovalidator"   value="<?php  $team['upload_image1'] ; ?>" />   <?php if($team['image1']){?> <br><span style="clear:both;" class="cpanel-date-hint"><?php echo team_image($team['image1']); ?>&nbsp;&nbsp;<a href="javascript:delimagem(<?php echo $team['id']; ?>, 'image1');"><img style="width: 13px;" src="<?=$ROOTPATH?>/media/css/i/excluir.png" /> </a> </span><?php }?> 
									</div> 
									<div style="clear:both;"class="report-head">Foto 3: <span class="cpanel-date-hint"></span></div>
									<div class="group">
										<input type="file" name="upload_image2"  id="upload_image2" class="form-control ckeditor photovalidator"   value="<?php  $team['upload_image2'] ; ?>" />   <?php if($team['image2']){?><br><span style="clear:both;" class="cpanel-date-hint"> <?php echo team_image($team['image2']); ?>&nbsp;&nbsp;<a href="javascript:delimagem(<?php echo $team['id']; ?>, 'image2');"><img style="width: 13px;" src="<?=$ROOTPATH?>/media/css/i/excluir.png" /> </a> </span><?php }?>
									</div> 
									<div style="clear:both;"class="report-head">Foto 4: <span class="cpanel-date-hint"></span></div>
									<div class="group">
										<input type="file" name="gal_upload_image1"  id="gal_upload_image1" class="form-control ckeditor photovalidator"   value="<?php  $team['gal_upload_image1'] ; ?>" />   <?php if($team['gal_image1']){?> <br><span style="clear:both;" class="cpanel-date-hint"><?php echo team_image($team['gal_image1']); ?>&nbsp;&nbsp;<a  href="javascript:delimagem(<?php echo $team['id']; ?>, 'gal_image1');"><img style="width: 13px;" src="<?=$ROOTPATH?>/media/css/i/excluir.png" /> </a> </span><?php }?>
									</div>  
									<div style="clear:both;"class="report-head">Foto 5: <span class="cpanel-date-hint"></span></div>
									<div class="group">
										<input type="file" name="gal_upload_image2"  id="gal_upload_image2" class="form-control ckeditor photovalidator"   value="<?php  $team['gal_upload_image2'] ; ?>" /> <?php if($team['gal_image2']){?><br><span style="clear:both;" class="cpanel-date-hint"> <?php echo team_image($team['gal_image2']); ?>&nbsp;&nbsp;<a  href="javascript:delimagem(<?php echo $team['id']; ?>, 'gal_image2');"><img style="width: 13px;" src="<?=$ROOTPATH?>/media/css/i/excluir.png" /> </a></span> <?php }?>   
								 </div> 
								</div>
								<!-- ============================= // fim coluna esquerda // =====================================-->
								<!-- ============================= // coluna direita // =====================================-->
								<div class="ends col-md-6 col-xs-12 col-sm-12"> 
								 
									<div style="clear:both;"class="report-head">Foto 6: <span class="cpanel-date-hint"></span></div>
									<div class="group">
										<input type="file" name="gal_upload_image3"  id="gal_upload_image3" class="form-control ckeditor photovalidator"   value="<?php  $team['gal_upload_image3'] ; ?>" />   <?php if($team['gal_image3']){?><br><span style="clear:both;" class="cpanel-date-hint"> <?php echo team_image($team['gal_image3']); ?>&nbsp;&nbsp;<a  href="javascript:delimagem(<?php echo $team['id']; ?>, 'gal_image3');"><img style="width: 13px;" src="<?=$ROOTPATH?>/media/css/i/excluir.png" /> </a></span><?php }?>
									</div> 
									<div style="clear:both;"class="report-head">Foto 7: <span class="cpanel-date-hint"></span></div>
									<div class="group">
										<input type="file" name="gal_upload_image4"  id="gal_upload_image4" class="form-control ckeditor photovalidator"   value="<?php  $team['gal_upload_image4'] ; ?>" />  <?php if($team['gal_image4']){?> <br><span style="clear:both;" class="cpanel-date-hint"><?php echo team_image($team['gal_image4']); ?>&nbsp;&nbsp;<a  href="javascript:delimagem(<?php echo $team['id']; ?>, 'gal_image4');"><img style="width: 13px;" src="<?=$ROOTPATH?>/media/css/i/excluir.png" /> </a></span> <?php }?> 
									</div> 
									<div style="clear:both;"class="report-head">Foto 8: <span class="cpanel-date-hint"></span></div>
									<div class="group">
										<input type="file" name="gal_upload_image5"  id="gal_upload_image8" class="form-control ckeditor photovalidator"   value="<?php  $team['gal_upload_image5'] ; ?>" />   <?php if($team['gal_image5']){?> <br><span style="clear:both;" class="cpanel-date-hint"><?php echo team_image($team['gal_image5']); ?>&nbsp;&nbsp;<a href="javascript:delimagem(<?php echo $team['id']; ?>, 'gal_image5');"><img style="width: 13px;" src="<?=$ROOTPATH?>/media/css/i/excluir.png" /> </a> </span><?php }?>
									</div>  
									 <div style="clear:both;"class="report-head">Foto 9: <span class="cpanel-date-hint"></span></div>
									<div class="group">
										<input type="file" name="gal_upload_image6"  id="gal_upload_image6" class="form-control ckeditor photovalidator"   value="<?php  $team['gal_upload_image6'] ; ?>" />   <?php if($team['gal_image6']){?> <br><span style="clear:both;" class="cpanel-date-hint"><?php echo team_image($team['gal_image6']); ?>&nbsp;&nbsp;<a href="javascript:delimagem(<?php echo $team['id']; ?>, 'gal_image6');"><img style="width: 13px;" src="<?=$ROOTPATH?>/media/css/i/excluir.png" /> </a> </span><?php }?>
									 </div> 
									 	<div style="clear:both;"class="report-head">Foto 10: <span class="cpanel-date-hint"></span></div>
									<div class="group">
											<input type="file" name="gal_upload_image7"  id="gal_upload_image7" class="form-control ckeditor photovalidator"   value="<?php  $team['gal_upload_image7'] ; ?>" />   <?php if($team['gal_image7']){?> <br><span style="clear:both;" class="cpanel-date-hint"><?php echo team_image($team['gal_image7']); ?>&nbsp;&nbsp;<a  href="javascript:delimagem(<?php echo $team['id']; ?>, 'gal_image7');"><img style="width: 13px;" src="<?=$ROOTPATH?>/media/css/i/excluir.png" /> </a> </span><?php }?>
									 </div>  
								 </div> 
							</div>
						</div>
					</div> 
					
				<!-- ********************************************* ABA Foto Auxiliar --> 
				<div class="option_box" id="c_estaticas" style="display:none;">
					<div class="top-heading group">
					<h4>Imagens Estáticas (  Opcional )</h4> </div> 
					<div id="container_box">
						<div id="option_contents" class="option_contents">  
							<div class="form-contain group">
								<!-- =============================   coluna esquerda   =====================================-->
								<div class="starts col-md-6 col-xs-12 col-sm-12">  
								
									<div style="clear:both;"class="report-head">Home:  <span class="cpanel-date-hint"> Dimensão exata: 192px x 163px.  </span> &nbsp;<img class="tTip" title="Opcionalmente, você pode fazer o upload da imagem redimensionada manualmente por você para este bloco. Note que se você fizer este upload, o sistema irá ignorar o redimensionamento automático para esse bloco e usar a sua imagem. Dimensão exata para a Home: 209px x 163px." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png"> 
									</div>
									<div class="group">
										<input type="file" name="estatica_home"  id="estatica_home" class="form-control ckeditor photovalidator"  value="<?php  $team['estatica_home'] ; ?>" />  <?php if($team['estatica_home']){?> <br><span style="clear:both;" class="cpanel-date-hint"> <?php echo team_image($team['estatica_home']); ?>&nbsp;&nbsp;<a href="#" onclick="delimagem(<?php echo $team['id']; ?>, 'estatica_home');"><img style="width: 13px;" src="<?=$ROOTPATH?>/media/css/i/excluir.png" /> </a></span> <?php }?>
									 </div> 
									<div style="clear:both;"class="report-head">Direita: <span class="cpanel-date-hint"> Dimensão exata: 110px x 67px.</span> &nbsp;<img class="tTip" title="Opcionalmente, você pode fazer o upload da imagem redimensionada manualmente por você para este bloco. Note que se você fizer este upload, o sistema irá ignorar o redimensionamento automático para esse bloco e usar a sua imagem. Dimensão exata para a lateral: 110px x 67px." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png"> </div>
									<div class="group">
										<input type="file" name="estatica_direita"  id="estatica_direita" class="form-control ckeditor photovalidator"   value="<?php  $team['estatica_direita'] ; ?>" />   <?php if($team['estatica_direita']){?> <br><span style="clear:both;" class="cpanel-date-hint"><?php echo team_image($team['estatica_direita']); ?>&nbsp;&nbsp;<a href="#" onclick="delimagem(<?php echo $team['id']; ?>, 'estatica_direita');"><img style="width: 13px;" src="<?=$ROOTPATH?>/media/css/i/excluir.png" /> </a> </span><?php }?> 
									</div> 
								 
								</div>
								<!-- ============================= // fim coluna esquerda // =====================================-->
								<!-- ============================= // coluna direita // =====================================-->
								<div class="ends col-md-6 col-xs-12 col-sm-12"> 
									<!--
									<div style="clear:both;"class="report-head">Detalhe: <span class="cpanel-date-hint">Dimensão exata: 701px x 273px.</span>&nbsp;<img class="tTip" title="Opcionalmente, você pode fazer o upload da imagem redimensionada manualmente por você para este bloco. Note que se você fizer este upload, o sistema irá ignorar o redimensionamento automático para esse bloco e usar a sua imagem. Dimensão exata para a lateral: 701px x 273px." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png"> </div>
									<div class="group">
										<input type="file" name="estatica_detalhe"  id="estatica_detalhe" class="form-control ckeditor"   value="<?php  $team['estatica_detalhe'] ; ?>" />   <?php if($team['estatica_detalhe']){?><br><span style="clear:both;" class="cpanel-date-hint"> <?php echo team_image($team['estatica_detalhe']); ?>&nbsp;&nbsp;<a href="#" onclick="delimagem(<?php echo $team['id']; ?>, 'estatica_detalhe');"><img style="width: 13px;" src="<?=$ROOTPATH?>/media/css/i/excluir.png" /> </a> </span><?php }?>
									</div>
									-->
									<!--
									<div style="clear:both;"class="report-head">Recentes: <span class="cpanel-date-hint">Dimensão exata: 268px x 162px.</span>&nbsp;<img class="tTip" title="Opcionalmente, você pode fazer o upload da imagem redimensionada manualmente por você para este bloco. Note que se você fizer este upload, o sistema irá ignorar o redimensionamento automático para esse bloco e usar a sua imagem. Dimensão exata para a lateral: 268px x 162px." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png"> </div>
									<div class="group">
										<input type="file" name="estatica_recentes"  id="estatica_recentes" class="form-control ckeditor"   value="<?php  $team['estatica_recentes'] ; ?>" />   <?php if($team['estatica_recentes']){?> <br><span style="clear:both;" class="cpanel-date-hint"><?php echo team_image($team['estatica_recentes']); ?>&nbsp;&nbsp;<a href="#" onclick="delimagem(<?php echo $team['id']; ?>, 'estatica_recentes');"><img style="width: 13px;" src="<?=$ROOTPATH?>/media/css/i/excluir.png" /> </a> </span><?php }?>
									</div> 
									-->
								 </div> 
								</div>
								<!-- ============================= // fim coluna direita // =====================================-->
							</div> 
						</div>
					</div>
					
					<!-- ********************************************* ABA FRETE --> 
					<div class="option_box" id="c_frete"> 
						<div class="top-heading group"> 
						<h4>Frete </h4></div> 
						<div id="container_box">
							<div id="option_contents" class="option_contents">  
								<div class="form-contain group">
									<!-- =============================   coluna esquerda   =====================================-->
									<div class="starts col-md-6 col-xs-12 col-sm-12">
										
										<div style="float:left; width:100%; margin-top: 15px;margin-bottom:11px;">
										   <span class="report-label">Por peso:</span>  
											<input style="width:20px;" type="radio"  <?php if($team['frete'] == 1 || !(isset($_GET['id']))) { ?>checked<?php } ?> value="1"    id="frete" name="frete"> Ativado  &nbsp;<img class="tTip" title="Se ativado, o sistema irá mostrar a opção de endereço de entrega e calcular o valor do frete baseado em uma consulta nos correios. Esse valor será adicionado ao valor da compra. O usuário irá pagar o valor da compra + o valor do frete." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											<!--<input style="width:20px;" type="radio"  <?php if($team['frete'] == 0) { ?>checked<?php } ?>  value="0" id="frete"  name="frete" > Desativado  &nbsp; -->
										 </div> 
										<div style="float:left;margin-top: 15px;margin-bottom:11px;display:none;" id="seguro_div">
										 	<input type="checkbox" name="seguro" id="seguro" checked="checked"> <span class="seguro_valor"></span> &nbsp;<a href="#" id="seguro_msg"><img class="tTip" src="<?=$ROOTPATH?>/media/css/i/info.png"> O que é isso?</a>
											<p>
												<b>AVISO:</b> O valor do seguro será descontado do seu pgto.
											</p>
										 </div> 										 
										<div style="clear:both;"class="report-head"><span class="cpanel-date-hint">Veja as opções de frete no seu gateway de pagamento. Ex: www.pagseguro.com.br em Preferencias->Frete</span></div>
										<div style="clear:both;"class="report-head">Cep de Origem: <span class="cpanel-date-hint">Apenas números: Ex: 30480000</span>&nbsp; <img style="cursor:help" class="tTip" title="O valor do frete será calculado baseado no cep de origem. Ou seja, o cep de onde este produto está sendo enviado." src="<?=$ROOTPATH?>/media/css/i/info.png"> </div>
										<div class="group">
											<input type="text" name="ceporigem"  maxlength="8" onKeyPress="return SomenteNumero(event);" id="ceporigem" class="form-control ckeditor" value="<?php echo  $team['ceporigem'] ; ?>" />  
										</div> 
										<div style="clear:both;"class="report-head">Peso: <span class="cpanel-date-hint">2 (significa 2 kilos), 0.2  (significa 200 gramas)</span>&nbsp; <img style="cursor:help" class="tTip" title="O valor do frete será calculado baseado no peso deste produto. Ex: 2 (significa 2 kilos), 0.2  (significa 2 gramas)" src="<?=$ROOTPATH?>/media/css/i/info.png"> </div>
										<div class="group">
											<input type="text" name="peso"  maxlength="162"   id="peso" class="form-control ckeditor" value="<?php echo  $team['peso'] ; ?>" />
										</div> 
										<div style="clear:both;"class="report-head">Altura: <span class="cpanel-date-hint">A altura nao pode ser inferior a 2 cm</span>&nbsp; <img style="cursor:help" class="tTip" title=" O valor do frete será calculado baseado na altura deste produto. Ex: 2" src="<?=$ROOTPATH?>/media/css/i/info.png"> </div>
										<div class="group">
											<input type="text" name="altura"  maxlength="162"  id="altura" class="form-control ckeditor" value="<?php echo  $team['altura'] ; ?>" />  
										</div>
										  
									</div>
									<!-- =============================   fim coluna esquerda   =====================================-->
									<!-- =============================   coluna direita   =====================================-->
									<div class="ends col-md-6 col-xs-12 col-sm-12">
										 											 
										<div style="clear:both;"class="report-head">Largura: <span class="cpanel-date-hint">A largura nao pode ser inferior a 11 cm</span>&nbsp; <img style="cursor:help" class="tTip" title="O valor do frete será calculado baseado na largura deste produto. Ex: 11" src="<?=$ROOTPATH?>/media/css/i/info.png"> </div>
										<div class="group">
											<input type="text" name="largura"  maxlength="162"  id="largura" class="form-control ckeditor" value="<?php echo  $team['largura'] ; ?>" />
										</div> 
										<div style="clear:both;"class="report-head">Comprimento: <span class="cpanel-date-hint">O comprimento nao pode ser inferior a 16 cm</span>&nbsp; <img style="cursor:help" class="tTip" title="O valor do frete será calculado baseado no comprimento deste produto. Ex: 16" src="<?=$ROOTPATH?>/media/css/i/info.png"> </div>
										<div class="group">
											<input type="text" name="comprimento"   maxlength="162" id="comprimento" class="form-control ckeditor" value="<?php echo  $team['comprimento'] ; ?>" />
										</div>	
										
										<div style="clear:both;"class="report-head">Fixar valor do frete: <span class="cpanel-date-hint"> Deixe em 0,00 para não fixar.</span>&nbsp; <img style="cursor:help" class="tTip" title="Você pode alterar o valor do frete, neste caso, o sistema irá usar o valor que você escolher. Talvez seja necessário limpar o cache de seu navegador para que estas alterações surgem efeito." src="<?=$ROOTPATH?>/media/css/i/info.png"> </div>
										<div class="group">
											<input type="text" name="valorfrete"  maxlength="162" id="valorfrete" class="form-control ckeditor" value="<?php echo  $team['valorfrete'] ; ?>" />
										</div> 
										
										<div style="float:left; width:100%; margin-top: 15px;margin-bottom:11px;">
										   <span class="report-label">Frete grátis:</span>  
											<input style="width:20px;" type="radio"  <?php if($team['frete'] == 2) { ?>checked<?php } ?> value="2"    id="fretegratuito" name="frete"> Ativado  &nbsp;<img class="tTip" title="O custo do envio será por sua conta." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											<!--<input style="width:20px;" type="radio"  <?=$fretegratuito_nao?>  value="0" id="fretegratuito"  name="fretegratuito" > Desativado  &nbsp; -->
										</div> 				
										
										<div style="float:left; width:100%; margin-top: 15px;margin-bottom:11px;">
										   <span class="report-label">Retirada no local:</span>  
											<input style="width:20px;" type="radio"  <?php if($team['frete'] == 3) { ?>checked<?php } ?> value="3"    id="retirada_local" name="frete"> Ativado  &nbsp;<img class="tTip" title="Indicado para produtos de grande porte, os usuários deverão combinar entre si um local de entrega." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											<!--<input style="width:20px;" type="radio"  <?=$fretegratuito_nao?>  value="0" id="retirada_local"  name="retirada_local" > Desativado  &nbsp; -->
										</div> 
										 
								 </div>
								<!-- =============================  fim coluna direita  =====================================-->
							</div> 
						</div>
					</div>
				</div>

					<!-- ********************************************* ABA Descrição da oferta --> 
					<div class="option_box">
						<div class="top-heading group"> 
						<h4>Termos de aceite</h4></div> 
						 
						<div id="container_box">
							<div id="option_contents" class="option_contents">  
								<div class="form-contain group"> 
									<div class="text_area">  
										<textarea cols="45" rows="5" name="termos_de_uso" style="width:100%" id="termos_de_uso" class="form-control ckeditor" >
											<?php echo htmlspecialchars($team['termos_de_uso']); ?>
										</textarea>
									</div> 
								</div> 
							</div> 
						</div>
					</div>	
					  
					<!-- ********************************************* ABA Descrição da oferta --> 
					<div class="option_box">
						<div class="top-heading group"> 
							<div class="col-md-9 col-xs-12 col-sm-12">
								<h4>
									Aba - Informações do Produto
								</h4>
							</div>
							<div class="col-md-3 col-xs-12 col-sm-12">
								<button onclick="gera_tabela_caracteristicas('summary');" class="btn btn-primary pull-right" type="button" style="margin-right:10px;">
									Gerar tabela de características
								</button>  
							</div>  
						</div> 
						 
						<div id="container_box">
							<div id="option_contents" class="option_contents">  
								<div class="form-contain group"> 
									<div class="text_area">  
									<textarea cols="45" rows="5" name="summary" style="width:100%" id="summary" class="form-control ckeditor" ><?php echo htmlspecialchars($team['summary']); ?></textarea>
									</div> 
								</div> 
							</div> 
						</div>
					</div>	 
					
					<!-- ********************************************* ABA Regulamento da oferta --> 
					<div class="option_box">
						<div class="top-heading group" > 
							<div class="col-md-9 col-xs-12 col-sm-12">
								<h4>
									Nova Aba - OPCIONAL
								</h4> 
							</div>
							<div class="col-md-3 col-xs-12 col-sm-12">
								<button onclick="gera_tabela_caracteristicas('notice');" class="btn btn-primary pull-right" type="button" style="margin-right:10px;">
									Gerar tabela de características
								</button> 
							</div>								
						</div> 
						 
						<div id="container_box">
							<div id="option_contents" class="option_contents">
								<div class="col-md-6 col-xs-12 col-sm-12" style="margin-bottom:15px;">
									<div style="clear:both;"class="report-head">
										Nome da Aba: <img style="cursor:help" class="tTip" title="Informe o nome desta aba. Máximo de 23 caracteres, contudo fique atento para o tamanho de cada aba para não prejudicar o layout.  Deixe em branco para não aparecer." src="<?=$ROOTPATH?>/media/css/i/info.png"> 
									</div> 
									<input class="form-control ckeditor" type="text" name="nomeaba1"  maxlength="23" id="nomeaba1" value="<?php echo  $team['nomeaba1'] ; ?>" />
								</div>								
								<div class="form-contain group"> 
									<div class="text_area">  
										<textarea cols="45" rows="5" name="notice" style="width:100%" id="notice" class="form-control ckeditor" ><?php echo htmlspecialchars($team['notice']); ?></textarea>
									</div> 
								</div> 
							</div> 
						</div>
					</div> 	
					
					<div class="option_box">  
						<div class="top-heading group" > 
							<div class="col-md-9 col-xs-12 col-sm-12">
								<h4>
									Nova Aba - OPCIONAL
								</h4> 
							</div>
							<div class="col-md-3 col-xs-12 col-sm-12">
								<button onclick="gera_tabela_caracteristicas('detail');" class="btn btn-primary pull-right" type="button" style="margin-right:10px;">
									Gerar tabela de características
								</button> 
							</div>
						</div> 
						
						 <div id="container_box">
							<div id="option_contents" class="option_contents"> 
								<div class="col-md-6 col-xs-12 col-sm-12" style="margin-bottom:15px;margin-top:10px;">
									<span class="report-head"  style="margin-right: 5px; color:#303030;">
										Nome da Aba: 
									</span> 
									<input type="text" name="nomeaba2"  maxlength="23" id="nomeaba2" class="form-control ckeditor" value="<?php echo  $team['nomeaba2'] ; ?>" />  
								</div>								
								<div class="form-contain group"> 
									<div class="text_area">  
									 <textarea cols="45" rows="5" name="detail" style="width:100%" id="detail" class="form-control ckeditor" ><?php echo htmlspecialchars($team['detail']); ?></textarea>
									</div> 
								</div> 
							</div> 
						</div>
					</div> 	
					
					<!-- ********************************************* ABA Mais informações da oferta --> 
					<div class="option_box"  style="display:none;" id="maisinfo">
						<div class="top-heading group"> 
						<h4>Mais informações na tela de pagamento</h4> </div> 
						
						 <div id="container_box">
							<div id="option_contents" class="option_contents">  
								<div class="form-contain group"> 
									<div class="text_area">  
									<textarea cols="45" rows="5" name="maisinformacoes" style="width:100%" id="maisinformacoes" class="form-control ckeditor" ><?php echo htmlspecialchars($team['maisinformacoes']); ?></textarea>
									</div> 
								</div> 
							</div> 
						</div>
					</div> 
    
					<div class="option_box">  
						<div class="top-heading group"> 
							<div class="col-md-9 col-xs-12 col-sm-12">
								<h4>
									Condições de Envio (opcional) 
								</h4>  
							</div> 
							<div class="col-md-3 col-xs-12 col-sm-12">
								<button onclick="gera_tabela_caracteristicas('condicaoenvio');" class="btn btn-primary pull-right" type="button" style="margin-right:10px;">
									Gerar tabela de características
								</button> 
							</div>
						</div> 						 
						 <div id="container_box">
							<div id="option_contents" class="option_contents">  
								<div class="form-contain group"> 
									<div class="text_area">  
									 <textarea cols="45" rows="5" name="condicaoenvio" style="width:100%" id="condicaoenvio" class="form-control ckeditor" ><?php echo htmlspecialchars($team['condicaoenvio']); ?></textarea>
									</div> 
								</div> 
							</div> 
						</div>
					</div> 							
					
					<div class="option_box">  
						<div class="top-heading group"> 
							<div class="col-md-9 col-xs-12 col-sm-12">
								<h4>
									Garantia (opcional)
								</h4>  
							</div> 		
							<div class="col-md-3 col-xs-12 col-sm-12">
								<button onclick="gera_tabela_caracteristicas('garantia');" class="btn btn-primary pull-right" type="button" style="margin-right:15px;">
									Gerar tabela de características
								</button> 
							</div>	
						</div>
						 <div id="container_box">
							<div id="option_contents" class="option_contents">  
								<div class="col-md-6 col-xs-12 col-sm-12" style="margin-top:10px;margin-bottom:15px;">
									<span class="report-head"  style="margin-right: 5px; color:#303030;">
										Nome da Aba: 
									</span> 
									<input type="text" name="nomeaba5"  maxlength="23" id="nomeaba5" class="form-control ckeditor" value="<?php echo  $team['nomeaba5'] ; ?>" />  
								</div>	
								<div class="form-contain group"> 
									<div class="text_area">  
										<textarea cols="45" rows="5" name="garantia" style="width:100%" id="garantia" class="form-control ckeditor" ><?php echo htmlspecialchars($team['garantia']); ?></textarea>
									</div> 
								</div> 
							</div> 
						</div>
					</div> 		
					
					<!-- ********************************************* Relacionamentos --> 
					<div  id="infopagamento"  class="option_box">  
						<div class="top-heading group"> <h4>Auto Relacionamento de Produtos - Produtos Similares</h4> </div> 
						 <div id="container_box">
							<div id="option_contents" class="option_contents">  
								<div class="form-contain group"> 
								<div class="report-head">Palavra chave: <span class="cpanel-date-hint">Informe as palavras chaves separadas por virgula. Ex: secador, chapinha, prancha.   ATENÇÃO: <b> Não informe palavras compostas.</b> Ex: televisão de LCD <b>(errado)</b>, LCD (certo), televisão (certo).</span>&nbsp;<img class="tTip" title="O sistema irá buscar todos os produtos que contenham esta mesma palavra chave e listá-los em produtos relacionados na página de detalhes deste produto. Não informe palavras compostas. Ex: televisão de LCD (errado), LCD (certo), televisão (certo)." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png"></div>
									<div class="group">
										<input type="text" id="seo_keyword" name="seo_keyword" value="<?php echo  $team['seo_keyword'] ; ?>" class="form-control ckeditor"> 
									</div>	
								</div> 
							</div> 
						</div>
					</div>  
				</div> 
				<div class="option_box"> 
					<div id="container_box">
						<div id="option_contents" class="option_contents">
							<div class="the-button" style="width:243px;">
								<input type="hidden" value="remote" id="deliverytype" name="deliverytype">
								<button onclick="doupdate();" class="btn btn-success" type="button">
									Salvar
								</button>	
								<!--
								<button onclick="doupdate('cadastraratributos');" id="run-button" class="input-btn" type="button">
									<div id="spinner" style="width: 83px; display: block;"> <img name="imgrec2" id="imgrec2" src="<?=$ROOTPATH?>/media/css/i/lendo.gif" style="display: none;"></div>
									<div id="spinner-text2">Salvar e cadastrar atributos</div>
								</button>
								-->
							</div> 
						</div>
					</div>
				</div> 
				</form>
                </div>
            </div> 
        </div>
	</div> 
</div>
<script>
var www = jQuery("#www").val();

	
<?php
	if(!(empty($team['seguro_val']))) {
?>
$('document').ready(function(){
	$('#frete').click();
});
<?php } ?>

$('#seguro').click(function() {
	
	if($(this).is(':checked')) {
		$('#frete').click();
	}
	else {
		$('#seguro_val').val("");
	}
});
	
$('#seguro_msg').click(function(){
	alert("O seguro contra extravio garante a indenização do valor pelo qual o produto foi vendido, caso aconteça algum problema durante a entrega dos correios. Para contratá-lo, selecione a opção ao anunciar um produto na forma de envio \"frete por peso\"");
});

$("#frete").click(function(){

	var PrecoProduto = $("#team_price").val();
	PrecoProduto = PrecoProduto.split("R$ ");

	if(parseFloat(PrecoProduto[1]) >= 50) {
	
		$.ajax({
			url: "<?php echo $ROOTPATH; ?>/ajax/comissao_site.php",
			type: 'post',
			data: "filtro=seguro&valor=" + PrecoProduto[1],
			success: function(retorno){
				if(retorno){
					$('.seguro_valor').html('<b>SEGURO CONTRA EXTRAVIO POR ' + retorno + '</b>');
					$('#seguro_div').css('display', 'block');
					$('#seguro_val').val(retorno);
				}  	  
			}
		});		
	}
});
 
$("#team_price").blur(function(){

	var PrecoProduto = $("#team_price").val();
	
		if(PrecoProduto != "" || PrecoProduto != 0.00) {
		
		/* Ajax para calcular valor da comissão que será recebida pelo site caso ocorra alguma venda. */
		$.ajax({
			url: "<?php echo $ROOTPATH; ?>/ajax/comissao_site.php",
			type: 'post',
			data: "filtro=comissao&valor=" + PrecoProduto + "&usuario=" + <?php echo $login_user['id']; ?>,
			success: function(retorno){
				if(retorno){
					alert("Aviso: Valor da comissão do site: \n" + retorno);
				}  	  
			}
		});		
	}
});
  
verifica_tipo_oferta("<?php echo $team['team_type']; ?>");
 
$("#end_time").mask("99/99/9999");
$("#begin_time").mask("99/99/9999");
$("#end_time2").mask("99:99");
$("#begin_time2").mask("99:99");

$('#market_price').priceFormat({
    prefix: '<?=$currency?> ',
    centsSeparator: ',',
    thousandsSeparator: '.'
});
$('#team_price').priceFormat({
    prefix: '<?=$currency?> ',
    centsSeparator: ',',
    thousandsSeparator: '.'
});
$('#preco_comissao').priceFormat({
    prefix: '<?=$currency?> ',
    centsSeparator: ',',
    thousandsSeparator: '.'
});

$('#bonuslimite').priceFormat({
    prefix: '<?=$currency?> ',
    centsSeparator: ',',
    thousandsSeparator: '.'
});
$('#valorfrete').priceFormat({
    prefix: '<?=$currency?> ',
    centsSeparator: ',',
    thousandsSeparator: '.'
});

	 	
if( jQuery("#id").val() ==""){
	$('#buyonce').val('N'); 
	$('#select_buyonce').text("É possível comprar mais de uma oferta ou promoção")	
	
	// $('#posicionamento').val(""); 
	// $('#select_posicionamento').text("") 
	 
	 $('#metodo_pagamento').val(""); 
	 $('#select_metodo_pagamento').text("Todos")
	 
	 $('#processo_compra').val("0"); 
	 $('#select_processo_compra').text("Normal ( fluxo tradicional )")
}
else{ 
	$('#select_partner_id').text($('#partner_id').find('option').filter(':selected').text());
	$('#select_city_id').text($('#city_id').find('option').filter(':selected').text());
	$('#select_group_id').text($('#group_id').find('option').filter(':selected').text());
	$('#select_buyonce').text($('#buyonce').find('option').filter(':selected').text());
	$('#select_posicionamento').text($('#posicionamento').find('option').filter(':selected').text());
	$('#select_metodo_pagamento').text($('#metodo_pagamento').find('option').filter(':selected').text());
	$('#select_processo_compra').text($('#processo_compra').find('option').filter(':selected').text());
	$('#select_cidade_valejunto').text($('#cidade_valejunto').find('option').filter(':selected').text());
	$('#select_categoria_valejunto').text($('#categoria_valejunto').find('option').filter(':selected').text());
	$('#select_cidade_apontaofertas').text($('#cidade_apontaofertas').find('option').filter(':selected').text());
	$('#select_categoria_apontaofertas').text($('#categoria_apontaofertas').find('option').filter(':selected').text());
	$('#select_categoria_dsconto').text($('#categoria_dsconto').find('option').filter(':selected').text());
	$('#select_categoria_agrupi').text($('#categoria_agrupi').find('option').filter(':selected').text());
}


window.x_init_hook_teamchangetype = function(){
 
	X.team.changetype("{$team['team_type']}");
};

window.x_init_hook_page = function() {
	X.team.imageremovecall = function(v) {
	 
		jQuery('#team_image_'+v).remove();
	};
	X.team.imageremove = function(id, v) {
	 
		return !X.get(WEB_ROOT + '/ajax/misc.php?action=imageremove&id='+id+'&v='+v);
	};
};
/*
function doupdate(acao){

	if(validador()){
		$("#spinner-text").css("opacity", "0.2");
		$("#spinner-text2").css("opacity", "0.2");
		jQuery("#imgrec").show();
		jQuery("#imgrec2").show();
		
		if(acao=="cadastraratributos"){
			jQuery("#cadastraratributos").val("sim"); 
		}
		
		<?php if(!(empty($INI["system"]["termosdeusosite"]))) { ?>
		alert("Aviso: " + "<?php echo strip_tags(utf8_encode(html_entity_decode($INI['system']['termosdeusosite']))); ?>");
		<?php } ?>
		document.forms[0].submit();
	}
}
*/
function campoobg(campo){
 
	$("#"+campo).css("background", "#F9DAB7");
 
}

function delimagem(idoferta,campo){
 
$.get(WEB_ROOT+"/adminanunciante/delgal.php?id="+idoferta+"&gal="+campo,
 			
   function(data){
      if(jQuery.trim(data)==""){
     	alert("Imagem apagada com sucesso. Após finalizar a edição do produto clique no botão salvar para efetivar a exclusão desta imagem. ");
	  }  
	  else{
		  alert(data)
	  }
   });
}

function limpacampos(){		 
	$("input[type=text]").each(function(){ 
		$("#"+this.id).css("background", "#fff");
	}); 
	$("#upload_image").css("background", "#fff");
	
}
function validador(){
	
	limpacampos();
	tipopferta = $("input[@name=team_type]:checked").attr('value');

	if( jQuery("#title").val()==""){

		campoobg("title");
		alert("Por favor, informe o nome da produto.");
		jQuery("#title").focus();
		return false;
	}
	if(jQuery("#stock").val()==""){

		campoobg("stock");
		alert("Por favor, informe o valor de estoque.");
		jQuery("#stock").focus();
		return false;
	}
	/*	
	if(jQuery("#size").val()==""){

		campoobg("size");
		alert("Por favor, informe o tamanho do produto.");
		jQuery("#size").focus();
		return false;
	}
	
	if(jQuery("#color").val()==""){

		campoobg("color");
		alert("Por favor, informe a cor do produto.");
		jQuery("#color").focus();
		return false;
	}
	*/
	if( jQuery("#titleresumido").val()==""){

		campoobg("titleresumido");
		alert("Por favor, informe o nome da produto resumido.");
		jQuery("#titleresumido").focus();
		return false;
	}
   if( jQuery("#group_id").val()==""){

		campoobg("group_id");
		alert("Por favor, informe a categoria do produto.");
		jQuery("#group_id").focus();
		return false;
	}
 
	if((jQuery("#layout").val() == "5" || jQuery("#layout").val() == "6") & jQuery("#flv").val()==""){
		campoobg("flv");
		alert("Para esse tipo de layout, você deve informar o código do vídeo do youtube");
		jQuery("#flv").focus();
		return false;
	}

	if(tipopferta =="cupom"){
	
		if( jQuery("#preco_comissao").val()=="<?=$currency?> 0,00"){
			campoobg("preco_comissao");
			alert("Por favor, informe o preço do cupom.");
			jQuery("#preco_comissao").focus();
			return false;
		}
	
		if(Number(jQuery("#preco_comissao").val().replace(/[^0-9]+/g,""))  >= Number(jQuery("#team_price").val().replace(/[^0-9]+/g,"")) ){
			campoobg("preco_comissao");
			alert("Observe que o valor do cupom  não deve ser maior do que o valor da produto, campo Por");
			jQuery("#preco_comissao").focus();
			return false;
		}
	}
	
	if(tipopferta =="cupom"){
	
		if( jQuery("#preco_comissao").val() == "" ||  jQuery("#preco_comissao").val() == "0.00" ||  jQuery("#preco_comissao").val() == "0" ){
			campoobg("preco_comissao");
			alert("Para este tipo de produto, você deve informar o valor do cupom.");
			jQuery("#preco_comissao").focus();
			return false;

		}
	}
 
	if(tipopferta !="participe"){
	/*
		if( jQuery("#market_price").val()=="<?=$currency?> 0,00"){
			campoobg("market_price");
			alert("Por favor, informe o preço antigo.");
			jQuery("#market_price").focus();
			return false;
		}	 
		*/
		
		if(jQuery("#market_price").val() != 'R$ 0,00' && jQuery("#team_price").val() != 'R$ 0,00') {
			if(Number(jQuery("#market_price").val().replace(/[^0-9]+/g,""))  < Number(jQuery("#team_price").val().replace(/[^0-9]+/g,"")) ){
				campoobg("market_price");
				alert("Observe que o valor do preço antigo não pode ser menor do que o valor do preço atual.");
				jQuery("#market_price").focus();
				return false;
			}
		}
	
		/*
		if( Number(jQuery("#pre_number").val().replace(/[^0-9]+/g,""))  > Number(jQuery("#max_number").val().replace(/[^0-9]+/g,""))){
			campoobg("pre_number");
			alert(" O campo Quant. virtual. não pode ser maior do que o campo Estoque");
			jQuery("#pre_number").focus();
			return false; 
		}

		if( Number(jQuery("#per_number").val().replace(/[^0-9]+/g,""))  > Number(jQuery("#max_number").val().replace(/[^0-9]+/g,""))){
			campoobg("per_number");
			alert(" O campo Quantidade máxima por pessoa não pode ser maior do que o campo Estoque");
			jQuery("#per_number").focus();
			return false;

		}

		if( Number(jQuery("#min_number").val().replace(/[^0-9]+/g,"")) > Number(jQuery("#max_number").val().replace(/[^0-9]+/g,"")) ){
			campoobg("min_number");
			alert(" O campo Venda Min. não pode ser maior do que o campo Estoque");
			jQuery("#min_number").focus();
			return false;

		}	*/
	 
		if(Number(jQuery("#minimo_pessoa").val().replace(/[^0-9]+/g,"")) > Number(jQuery("#per_number").val().replace(/[^0-9]+/g,"")) ){
			campoobg("per_number");
			alert("Para uma pessoa poder comprar o mínimo de "+jQuery("#minimo_pessoa").val()+" unidades deste produto, então o campo Quantidade máxima por pessoa:  não pode ser "+jQuery("#per_number").val() + ", deve ser maior.");
			jQuery("#per_number").focus();
			return false;

		}
	}
	/*
	if(tipopferta =="off"){
		if( Number(jQuery("#pre_number").val().replace(/[^0-9]+/g,""))  < Number(jQuery("#min_number").val().replace(/[^0-9]+/g,""))){
			campoobg("min_number");
			alert("Para este tipo de oferta, ou seja, pagamento total no parceiro, a oferta já deve iniciar ativa, sendo assim, o campo Venda Min deve ser igual ou menor do que o campo Quant. virtual.")
			jQuery("#min_number").focus();
			return false;
		}
		
	}*/
	  if(tipopferta =="normal"){
	
		if(Number(jQuery("#bonuslimite").val().replace(/[^0-9]+/g,""))  >= Number(jQuery("#team_price").val().replace(/[^0-9]+/g,"")) ){
			campoobg("bonuslimite");
			alert("Observe que o valor do campo Bonus Até: deve ser menor do que o valor da oferta.");
			jQuery("#bonuslimite").focus();
			return false;

		}
	} 
	 if( jQuery("#id").val() ==""){ 
		if( jQuery("#upload_image").val() =="" ){
			campoobg("upload_image");
			alert("Por favor, faça upload da primeira foto ao menos.");
			jQuery("#upload_image").focus();
			return false;
		}
	 } 
	 
	if( jQuery("#processo_compra").val() =="1" ){
		if( jQuery("#metodo_pagamento").val() =="" || jQuery("#metodo_pagamento").val() =="99" ){
			campoobg("metodo_pagamento");
			alert("Para o processo de compra rápida, você deve informar um método de pagamento");
			jQuery("#metodo_pagamento").focus();
			return false;
		}
	} 
	
	if( jQuery("#metodo_pagamento").val() =="99"  ){
		if( jQuery("#detail").val()=="" ){
			campoobg("detail");
			alert("Ao informar nenhum método de pagamento, você deve preencher informações adicionais na tela de pagamento ");
			jQuery("#detail").focus();
			return false;
		}
	} 
	  
	frete  = $("input[name='frete']:checked").val();
	
	if(frete =="1"){ 
		if( jQuery("#ceporigem").val() == "" ){
			campoobg("ceporigem");
			alert("Por favor, informe o cep de origem");
			jQuery("#ceporigem").focus();
			return false;

		}	
		if( jQuery("#peso").val() == "" ){
			campoobg("peso");
			alert("Por favor, informe o peso do produto");
			jQuery("#peso").focus();
			return false;

		}
		if( jQuery("#altura").val() == "" ){
			campoobg("altura");
			alert("Por favor, informe a altura do produto");
			jQuery("#altura").focus();
			return false;

		}	
		if( jQuery("#largura").val() == "" ){
			campoobg("largura");
			alert("Por favor, informe a largura do produto");
			jQuery("#largura").focus();
			return false;

		}	
		if( jQuery("#comprimento").val() == "" ){
			campoobg("comprimento");
			alert("Por favor, informe o comprimento do produto");
			jQuery("#comprimento").focus();
			return false;

		}
		if(Number(jQuery("#altura").val().replace(/[^0-9]+/g,""))  <  2 ){
			campoobg("altura");
			alert("A altura do produto não pode ser menor do que 2");
			jQuery("#altura").focus();
			return false; 
		}
		if(Number(jQuery("#largura").val().replace(/[^0-9]+/g,""))  <  11 ){
			campoobg("largura");
			alert("A largura do produto não pode ser menor do que 11");
			jQuery("#largura").focus();
			return false; 
		}	
		if(Number(jQuery("#comprimento").val().replace(/[^0-9]+/g,""))  <  16 ){
			campoobg("comprimento");
			alert("O comprimento do produto não pode ser menor do que 16");
			jQuery("#comprimento").focus();
			return false; 
		}
	
	}
	if(tipopferta =="off" || tipopferta =="participe"){
		if(frete =="1"){ 
			alert("O frete não precisa estar ativo para ofertas do tipo Pagar no parceiro ou Promoção. Por favor, desative o frete.");
			jQuery("#frete").focus();
			return false;
		}
	}
	 
	return true;	
}

function verifica_tipo_oferta(tipo){
  
  if(tipo == "cupom"){ 
		jQuery("#c_frete").show(); 
		jQuery("#abapagamento").show();
		jQuery("#infopagamento").show();
		jQuery("#c_categoria").show();
		jQuery("#c_obscupom").show();
		jQuery("#maisinfo").hide();  
		jQuery("#bonusate").show(); 
		jQuery("#cupomate").show(); 
		jQuery("#min_pessoa").show();
		jQuery("#c_vendas").show();
		jQuery("#c_compradores_virtuais").show();
		jQuery("#c_estoque").show();
		jQuery("#c_max_number").show();
		jQuery("#parceirobk").show();
		jQuery("#c_valores").show();
		jQuery("#c_comissao").show();
		jQuery("#bk_processo_compra").show(); 
		jQuery("#metododepagamento").show(); 
		jQuery("#url_botao_comprar").show(); 
		jQuery("#c_posicionamento").show(); 
		jQuery("#retorno_participe").hide(); 
		jQuery("#infoagregadores").show(); 
		jQuery("#c_pontos_quant").hide();
	}	
	else if(tipo == "participe"){
		jQuery("#c_frete").hide();
		jQuery("#abapagamento").hide();
		jQuery("#infopagamento").hide();
		jQuery("#c_obscupom").hide();
		jQuery("#maisinfo").hide(); 
		jQuery("#bonusate").hide(); 
		jQuery("#bonuslimite").val(""); 
		jQuery("#c_vendas").hide(); 
		jQuery("#c_max_number").hide(); 
		jQuery("#c_estoque").hide(); 
		jQuery("#c_valores").hide(); 
		jQuery("#min_pessoa").hide(); 
		jQuery("#c_compradores_virtuais").show(); 
		jQuery("#parceirobk").show(); 
		jQuery("#c_categoria").show();  
		jQuery("#c_posicionamento").show(); 
		jQuery("#cupomate").hide(); 
		jQuery("#c_comissao").hide(); 
		jQuery("#frete").val("0"); 
		jQuery("#processo_compra").val("0"); 
		jQuery("#url_botao_comprar").hide();
		jQuery("#metododepagamento").hide(); 
		jQuery("#bk_processo_compra").hide(); 
		jQuery("#infoagregadores").hide(); 
		jQuery("#retorno_participe").show(); 
		jQuery("#preco_comissao").val("");
		jQuery("#c_pontos_quant").hide();
	}	
	else if(tipo == "off"){
		jQuery("#c_frete").show(); 
		jQuery("#abapagamento").show();
		jQuery("#infopagamento").hide();
		jQuery("#c_obscupom").show();
		jQuery("#maisinfo").hide(); 
		jQuery("#bonusate").hide(); 
		jQuery("#bonuslimite").val(""); 
		jQuery("#c_vendas").show(); 
		jQuery("#c_compradores_virtuais").show(); 
		jQuery("#c_max_number").hide(); 
		jQuery("#c_estoque").show(); 
		jQuery("#c_valores").show(); 
		jQuery("#min_pessoa").show(); 
		jQuery("#parceirobk").show(); 
		jQuery("#c_categoria").show(); 
		jQuery("#c_posicionamento").show(); 
		jQuery("#cupomate").hide(); 
		jQuery("#c_comissao").hide();
		jQuery("#processo_compra").val("0"); 
		jQuery("#url_botao_comprar").hide(); 
		jQuery("#metododepagamento").hide(); 
		jQuery("#bk_processo_compra").hide(); 
		jQuery("#infoagregadores").hide(); 
		jQuery("#retorno_participe").hide(); 
		jQuery("#preco_comissao").val("");
		jQuery("#c_pontos_quant").hide();
	}	
	else if(tipo == "especial"){ 
		jQuery("#c_frete").hide();
		jQuery("#maisinfo").show();
		jQuery("#abapagamento").hide();
		jQuery("#c_categoria").hide();
		jQuery("#infopagamento").hide();
		jQuery("#c_obscupom").hide();
		jQuery("#bonusate").hide(); 
		jQuery("#bonuslimite").val(""); 
		jQuery("#c_vendas").hide(); 
		jQuery("#c_compradores_virtuais").hide(); 
		jQuery("#c_max_number").show(); 
		jQuery("#c_estoque").show(); 
		jQuery("#c_valores").hide();  
		jQuery("#min_pessoa").hide(); 
		jQuery("#c_pontos_quant").show(); 
		jQuery("#c_posicionamento").hide(); 
		jQuery("#parceirobk").show(); 
		jQuery("#cupomate").show(); 
		jQuery("#c_comissao").hide(); 
		jQuery("#processo_compra").val("0"); 
		jQuery("#team_price").val("0"); 
		jQuery("#preco_comissao").val("0");
		jQuery("#frete").val("0"); 
	//	jQuery("#pre_number").val("0"); 
		jQuery("#url_botao_comprar").hide();
		jQuery("#metododepagamento").hide(); 
		jQuery("#bk_processo_compra").hide(); 
		jQuery("#infoagregadores").hide(); 
		jQuery("#retorno_participe").hide(); 
		jQuery("#preco_comissao").val("");
	}
	else{
		jQuery("#c_frete").show(); 
		jQuery("#infopagamento").show();
		jQuery("#c_categoria").show();
		jQuery("#abapagamento").show();
		jQuery("#c_posicionamento").show();
		jQuery("#c_obscupom").show();
		jQuery("#min_pessoa").show(); 
		jQuery("#c_vendas").show(); 
		jQuery("#c_compradores_virtuais").show(); 
		jQuery("#c_estoque").show(); 
		jQuery("#c_valores").show(); 
		jQuery("#bonusate").show();  
		jQuery("#cupomate").show(); 
		jQuery("#maisinfo").hide();		 
		jQuery("#c_comissao").hide();		 
		jQuery("#c_pontos_quant").hide();		 
		jQuery("#url_botao_comprar").show();
		jQuery("#metododepagamento").show();
		jQuery("#bk_processo_compra").show();
		jQuery("#infoagregadores").show();
		jQuery("#retorno_participe").hide();
		jQuery("#preco_comissao").val("");
	}
} 

function gera_tabela_caracteristicas(campo){
   var conteudo = '<table class="characteristics table-striped" style="border-bottom-width: 0px;" border="0" cellspacing="0">	<tfoot> 	<tr class="odd">	<td colspan="2">&nbsp;</td>	</tr>	</tfoot> 	<tbody>	<tr class="odd">	<th class="name-field Aviso-sobre-o-produto">Aviso sobre o produto</th>	<td class="value-field Aviso-sobre-o-produto">Imagem Meramente Ilustrativa</td>	</tr>	<tr>	<th class="name-field Aviso-sobre-o-produto">Aviso sobre o produto</th>	<td class="value-field Aviso-sobre-o-produto">Dura&ccedil;&atilde;o da bateria estimada de acordo com o uso do aparelho</td>	</tr>	<tr class="odd">	<th class="name-field Garantia-do-Fornecedor">Garantia do Fornecedor</th>	<td class="value-field Garantia-do-Fornecedor">1 Ano</td>	</tr>	<tr>	<th class="name-field Cor">Cor</th>	<td class="value-field Cor">Branco</td>	</tr>	<tr class="odd">	<th class="name-field Alimentacao">Alimenta&ccedil;&atilde;o</th>	<td class="value-field Alimentacao">Energia El&eacute;trica - Bivolt</td>	</tr>	<tr>	<th class="name-field Conteudo-da-Embalagem">Conte&uacute;do da Embalagem</th>	<td class="value-field Conteudo-da-Embalagem">01 Nokia Lumia 530 Preto<br /> 01 Carregador Port&aacute;til<br /></td>	</tr>	<tr class="odd">	<th class="name-field Referencia-do-Modelo">Refer&ecirc;ncia do Modelo</th>	<td class="value-field Referencia-do-Modelo">Lumia 530 - Branco</td>	</tr>	<tr class="odd">	<th class="name-field Plataforma">Plataforma</th>	<td class="value-field Plataforma">Windows Phone</td>	</tr>	<tr>	<th class="name-field Memoria-interna">Mem&oacute;ria interna</th>	<td class="value-field Memoria-interna">At&eacute; 4 GB</td>	</tr>	<tr class="odd limit">	<th class="name-field Processador">Processador</th>	<td class="value-field Processador">Quad Core</td>	</tr>	<tr class="limit">	<th class="name-field Conexao">Conex&atilde;o</th>	<td class="value-field Conexao">Wi-fi</td>	</tr>	<tr class="odd limit">	<th class="name-field Camera">C&acirc;mera</th>	<td class="value-field Camera">5 Megapixels</td>	</tr>	<tr class="limit">	<th class="name-field Numero-de-chips">N&uacute;mero de chips</th>	<td class="value-field Numero-de-chips">Dual chip</td>	</tr>	<tr class="odd limit">	<th class="name-field Modelo">Modelo</th>	<td class="value-field Modelo">Lumia</td>	</tr>	<tr class="limit">	<th class="name-field Processador">Processador</th>	<td class="value-field Processador">Processador Quad Core 1.2 GHz</td>	</tr>	<tr class="odd limit">	<th class="name-field Formato">Formato</th>	<td class="value-field Formato">Touch</td>	</tr>	<tr class="limit">	<th class="name-field Tela">Tela</th>	<td class="value-field Tela">Tamanho: 4"<br /> Resolu&ccedil;&atilde;o: 480 x 854<br /></td>	</tr>	<tr class="odd limit">	<th class="name-field Recursos-Gerais">Recursos Gerais</th>	<td class="value-field Recursos-Gerais">Agenda de Compromisso</td>	</tr>	<tr class="limit"><th class="name-field Rede-de-Dados">Rede de Dados</th>	<td class="value-field Rede-de-Dados">Redes Compat&iacute;veis: UMTS, GPRS, EDGE<br /></td>	</tr>	<tr class="odd limit">	<th class="name-field Bateria">Bateria</th>	<td class="value-field Bateria">Tipo: 1430 mAh<br /> Dura&ccedil;&atilde;o da bateria: Em conversa&ccedil;&atilde;o: 8.6h (GSM), 9.2h (WCDMA)<br /></td>	</tr>	<tr class="limit">	<th class="name-field Modelo">Modelo</th>	<td class="value-field Modelo">Touch</td>	</tr>	</tbody>	</table>';
   //tinyMCE.get(campo).setContent(conteudo); 
   CKEDITOR.instances[campo].setData(conteudo); 
 }


 	jQuery(document).ready(function(){
        jQuery('.photovalidator').change(function(e){
	        var input = e.target;
	        var reader = new FileReader();      
	        reader.readAsDataURL(input.files[0]);
	        var tamanho = (input.files[0].size/1024).toFixed(2);
	        var inputname = jQuery(this).attr('id');

	       if(tamanho > 2000){
	       		alert("Imagem acima do limite permitido (2MB)");
	       		jQuery(this).val(null);
	       		jQuery("#"+inputname).focus();
	       		return false;
	       }
		});
    });
 

</script> 

<script src="<?php echo $ROOTPATH; ?>/media/js/add_more_fields.js" type="text/javascript"></script> 
<script>
	jQuery('document').ready(function(){
		
		jQuery('.delete_option').click(function(){
			
			var id = jQuery(this).attr('attr-id');
			
			if(id != "" && id != "undefined") {
				
				var key = ".option_" + id + "_content";
				
				jQuery.ajax({
					url: "<?php echo $ROOTPATH; ?>/ajax/manage.php",
					type: 'GET',
					data: "action=delete_option&id=" + id,
					success: function(retorno){
						
						window.alert("Opção apagada com sucesso!");
						jQuery(key).hide("slow");
					}
				});	
			}
			else {
				
				window.alert("Erro ao processar solicitação! Tente novamente mais tarde.");
			}
		});
	});
</script>  