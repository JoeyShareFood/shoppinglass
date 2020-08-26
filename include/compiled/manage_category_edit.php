<?php include template("manage_header");?>
<?php require("ini.php");?> 

 
 
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="leader">
	<div id="content" class="clear mainwide">
        <div class="clear box"> 
            <div class="box-content">
                <div class="sect">
				 <form id="login-user-form" method="post" action="/vipmin/category/edit.php?id=<?php echo $category['id']; ?>" enctype="multipart/form-data" class="validator">
					<input type="hidden" name="id" value="<?php echo $category['id']; ?>" />
					<input type="hidden" name="zone" value="<?php echo $zone; ?>" />
				<input type="hidden" name="www" id="www"  value="<?=$INI['system']['wwwprefix']?>" /> 
				<div class="option_box">
					<div class="top-heading group">
						<div class="left_float"><h4>Informações da <?=$tipo?> <?php echo $category['id']; ?></h4></div>
							<div class="the-button">
								<input type="hidden" value="remote" id="deliverytype" name="deliverytype">
								<button onclick="doupdate();" id="run-button" class="input-btn" type="button">
									<div name="spinner-top" id="spinner-top" style="width: 83px; display: block;"><img name="imgrec" id="imgrec" src="<?=$ROOTPATH?>/media/css/i/lendo.gif" style="display: none;"></div>
									<div id="spinner-text"  >Salvar</div>
								</button>
							</div> 
					</div> 
					<div id="container_box">
						<div id="option_contents" class="option_contents"> 
							<div class="form-contain group">
								<!-- =============================   coluna esquerda   =====================================-->
								<div class="starts"> 
									<div style="clear:both;"class="report-head">Nome: <span class="cpanel-date-hint"></span></div>
									<div class="group">
										<input type="text" name="name"  maxlength="152" id="name" class="format_input ckeditor" value="<?php echo $category['name'] ?>" /> 
									</div>
									
									<div class="report-head">Categoria Pai: <span class="cpanel-date-hint">Deixe em branco para ser uma categoria PAI</span></div>
									<div class="group">
										<div class="cjt-wrapped-select" id="type-select-cjt-wrapped-select">
										<select  name="idpai" id="idpai" onchange="$('#select_idpai').text($('#idpai').find('option').filter(':selected').text())"> 
											<option value=""> </option>
											 <?php  
													if($category['id']){
															$aux =  " and id <> ".$category['id'];
													}
													
													$indentacao = "....";  
													$sql = "select * from category where display ='Y' and  idpai=0 $aux order by sort_order desc,name";
													$rs = mysql_query($sql);
													while($l = mysql_fetch_assoc($rs)){
													 $selected ="";
													 if($category['idpai'] == $l['id']){
															$selected =  " selected ";
													 }
		
														echo "<option value='$l[id]' $selected>".displaySubStringWithStrip($l[name],30)."</option>";
														exibe_filhos($l["id"],$indentacao,$category['idpai'],$category['id']);
													}
													$tb = null; 

												 ?>
										</select>
										<div name="select_idpai" id="select_idpai" class="cjt-wrapped-select-skin">Informe a categoria pai</div>
										<div class="cjt-wrapped-select-icon"></div>
										</div> &nbsp;<img class="tTip" title="Quando você informa uma categoria pai, ela irá aparecer como uma subcategoria no menu de navegação do site. Se deixar em branco, esta categoria irá aparecer no menu de navegação principal. A quantidade de categorias principais está diretamente ligado ao tamanho em caracteres de cada categoria." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
									</div>  
									   
									<div class="group">
										<div style="clear:both;"class="report-head">Ativa: <span class="cpanel-date-hint"></span></div>
										<input style="width:20px;" type="radio" <? if($category['display'] =="Y" or $category['display'] ==""){echo "checked='checked'";}?>  value="Y" name="display" > Sim  &nbsp;   
										<input style="width:20px;" type="radio" <? if($category['display'] =="N"){echo "checked='checked'";}?>   name="display" value="N"> Não  &nbsp;<img class="tTip" title="Note que se a categoria pai estiver inativa, então todas as categorias filhas ficarão também inativas." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">  
									 </div> 
									 
									<div class="group"> 
										<div style="clear:both;"class="report-head">Exibir categoria no topo <span class="cpanel-date-hint">Somente se for PAI - O limite depende do tamanho das palavras</span>  <img class="tTip" title="Se o seu site tem muitas categorias PAI, então é ideal desmarcar este campo para algumas e mostrar somente as principais para que o seu site mantenha a estética. Todas as categorias Pai aparecem nas categorias laterais." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png"></div>
										<input style="width:20px;" type="radio" <? if($category['mostrartopo'] =="Y" or $category['mostrartopo'] ==""){echo "checked='checked'";}?>  value="Y" name="mostrartopo"   > Sim   
										<input style="width:20px;" type="radio" <? if($category['mostrartopo'] =="N"){echo "checked='checked'";}?>   name="mostrartopo" value="N"  > Não   
									 </div>
									   
									<div class="group" style="display:none;" >
										<div class="report-head" style="clear:both;">Exibir categoria na lateral: <span class="cpanel-date-hint">Somente se for PAI - Limite de 11 categorias</span></div>
										<input type="radio" name="displaycateg" value="Y" <?php if($category['displaycateg'] == "Y" || empty($category['displaycateg'])) { ?> checked="checked" <?php } ?> style="width:20px;"> Sim  &nbsp;   
										<input type="radio" value="N" <?php if($category['displaycateg'] == "N") { ?> checked="checked" <?php } ?> name="displaycateg" style="width:20px;"> Não   
									 </div>	

									 <div class="group"  >
										<div class="report-head" style="clear:both;">Exibir categoria na Index: <span class="cpanel-date-hint">A categoria aparecerá como destaque na home - Limitado a 4 categorias</span></div>
										<input type="radio" name="categoria_destaque" value="Y" <?php if($category['categoria_destaque'] == "Y" || empty($category['categoria_destaque'])) { ?> checked="checked" <?php } ?> style="width:20px;"> Sim  &nbsp;   
										<input type="radio" value="N" <?php if($category['categoria_destaque'] == "N") { ?> checked="checked" <?php } ?> name="categoria_destaque" style="width:20px;"> Não   
									 </div>	
									
									<div id="tipoblock" style="margin-top:2%;margin-bottom:2%;">										
										<div style="clear:both;"class="report-head">Imagem de categoria na home: <span class="cpanel-date-hint"> <span class="cpanel-date-hint"><span id="dimensao">  </span> Dimensão: 290px largura x 400px altura <a target="_blank" href="http://www.vipcomsites.com.br/planos-de-marketing">Adquirir Artes</a> </span></div>
										<div class="group">
											<input type="file" style="border: 1px solid #C1D0D3; color: #666666; width: 86%;" name="imagemcateghome"  id="imagemcateghome" class="format_input ckeditor"  />   
										</div>
									</div> 
									
								</div>
								<!-- =============================   fim coluna esquerda   =====================================-->
								<!-- =============================   coluna direita   =====================================-->
								<div class="ends"> 	 			 
							 
							 		 <div id="tipoblock">
									 
									 <!-- 
										 <div class="group">
											<div style="clear:both;"class="report-head">Ícone da navegação <a href="javascript:buscafoto('iconecattopo.jpg');">Clique aqui </a> para ver  <span class="cpanel-date-hint">Não inclua o nome da categoria no ícone</span></div>
											<input style="width:20px;" type="radio" <? if($category['imagemnavegacao'] =="Y"){echo "checked='checked'";}?>  value="Y" name="imagemnavegacao" > Sim  &nbsp;&nbsp;<img class="tTip" title="Válido somente para o tipo categoria de oferta. Você pode incluir algumas categorias de ofertas como destaque no topo do site. Note que existe um limite estético para a quantidade de imagens, sugerimos entre 7 e 8." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">   
											<input style="width:20px;" type="radio" <? if($category['imagemnavegacao'] =="" or $category['imagemnavegacao'] =="N"){echo "checked='checked'";}?>   name="imagemnavegacao" value="N"> Não  &nbsp;
										 </div>	
										 -->
										 <input   type="hidden"  checked='checked'  name="imagemnavegacao" value="Y"> 
										
										  <div class="group" style="display:none;">
												 <input type="file" style="border: 1px solid #C1D0D3; color: #666666; width: 86%;" name="imagemcateg"  id="imagemcateg" class="format_input ckeditor"  />   
										  </div>
										 <div class="infotxt">Note que, esta é uma área muito visível do seu site por isso, caso não tenha conhecimentos de edição de imagens, não tente criar e não coloque qualquer uma. Peça essa criação para um profissional. Para desativar este menu, vá no menu Sistema->Configurações (Ativar menu de categorias e parceiros em imagens)</div>
									</div> 							 	
									
									<div style="clear:both;"class="report-head">Seo - Titulo da categoria: <span class="cpanel-date-hint">Máximo de 63 caracteres</span></div>
									<div class="group">
										<input type="text" name="seo_cat_title"    id="seo_cat_title" class="format_input ckeditor" value="<?php echo $category['seo_cat_title'] ?>" /> 
									</div>	
									<div style="clear:both;"class="report-head">Seo - Descrição da categoria: <span class="cpanel-date-hint">Máximo de 152 caracteres</span></div>
									<div class="group">
										<input type="text" name="seo_cat_descricao"    id="seo_cat_descricao" class="format_input ckeditor" value="<?php echo $category['seo_cat_descricao'] ?>" /> 
									</div>
									
										<div style="clear:both;"class="report-head">Seo - Palavras chaves da categoria: <span class="cpanel-date-hint">separados por virgula</span></div>
									<div class="group">
										<input type="text" name="seo_cat_key"   id="seo_cat_key" class="format_input ckeditor" value="<?php echo $category['seo_cat_key'] ?>" /> 
									</div>
									
									<!-- 
									<? if( $category['linkexterno'] != "/index.php" and $category['linkexterno'] != "/parceiros.php" and $category['linkexterno'] != "/contato.php"  ){?>
									
									<div class="report-head">Link: <span class="cpanel-date-hint">O campo Link é Opcional. Inclua http:// se for um link externo</span></div>
									<div class="group">
										<input type="text" id="linkexterno"  name="linkexterno" value="<?php echo $category['linkexterno']?>"> &nbsp;<img class="tTip" title="Você pode informar um link de uma loja virtual ou um site externo quando o usuário clicar nesta categoria. Inclua http:// se for um link externo" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
									</div>
									<? } ?>
									<div class="report-head">Target: <span class="cpanel-date-hint">Ex: _blank</span></div>
									<div class="group">
										<input type="text" id="target"  name="target" value="<?php echo $category['target']?>"> &nbsp;<img class="tTip" title="Você pode informar um target para esse link. Exemplo _blank para abrir uma nova janela" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
									</div>	
									-->
										<div class="report-head">Ordenação: <span class="cpanel-date-hint">Sugestão: Informe intervalos de 50 para cada categoria</span></div>
									<div class="group">
										<input type="text" id="sort_order" onKeyPress="return SomenteNumero(event);"  name="sort_order" value="<?php echo $category['sort_order'] ? $category['sort_order'] : 0; ?>"> &nbsp;<img class="tTip" title="Informe a ordem de posicionamento. Ordenação maior fica na frente de ordenação menor." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
									</div>
									
								 </div>
								<!-- =============================  fim coluna direita  =====================================-->
							</div> 
						</div>
					</div>
				</div> 
					   
	 	 
				<div class="option_box">
					<div class="top-heading group"> <div class="left_float"><h4>Banner da categoria <a href="javascript:buscafoto('bancat.jpg');">Clique aqui </a> para ver - Dimensão: 940px x 150px </h4>  Mantenha a proporcionalidade <a href="javascript:buscafoto('propimg.jpg');"> Ver imagem  </a>  </div> &nbsp;<img class="tTip" title="Este banner irá aparecer somente quando o usuário clicar nesta categoria. Dimensão ideal 940px de largura por 150px de altura, você também pode colocar um código html clicando no ícone HTML" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png"> </div> 
					<div id="container_box">
						<div id="option_contents" class="option_contents">  
							<div class="form-contain group"> 
								<div class="text_area">  
								<textarea cols="45" rows="5" name="bannercategoria" style="width:100%" id="bannercategoria" class="format_input ckeditor" ><?php echo htmlspecialchars($category['bannercategoria']); ?></textarea>
								</div> 
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
</div> 
<script>
 
function validador(){
 
	limpacampos(); 

	if( jQuery("#name").val()==""){

		campoobg("name");
		alert("Por favor, informe o nome da <?php echo $tipo; ?>");
		jQuery("#name").focus();
		return false;
	} 
	return true;	
}
 
function verificatipocategoria(){
	
	tipo  = jQuery("input[name='tipo']:checked").val();
 
	if(tipo =="pagina"){ 
		jQuery("#tipoblock").hide();
	}	
	else{
		jQuery("#tipoblock").show();
	}
}
	
verificatipocategoria();

 if( jQuery("#id").val() ==""){
 
}
else{ 
 
	$('#select_idpai').text($('#idpai').find('option').filter(':selected').text());
}

function buscafoto(foto){
	jQuery(document).ready(function(){
		jQuery.colorbox({
			href: WEB_ROOT + '/media/css/i/'+foto
		});
	});

}

</script>   