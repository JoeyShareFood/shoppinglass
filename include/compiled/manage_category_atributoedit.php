<?php include template("manage_header");?>
<?php require("ini.php");
//print_r($categoriapai);
?> 

 
 
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="leader">
	<div id="content" class="clear mainwide">
        <div class="clear box"> 
            <div class="box-content">
                <div class="sect">
				 <form id="login-user-form" method="post" action="<?=$ROOTPATH?>/vipmin/category/atributoedit.php" enctype="multipart/form-data" class="validator">
					<input type="hidden" name="category_id" value="<?php echo $category['id']; ?>" />
					<input type="hidden" name="id" value="<?php echo $category_atributos['id'] ?>" />
					<input type="hidden" name="zone" value="<?php echo $zone; ?>" />
				<input type="hidden" name="www" id="www"  value="<?=$INI['system']['wwwprefix']?>" /> 
				<div class="option_box">
					<div class="top-heading group">
						<div class="left_float"><h4>Atributos da Categoria <?=$tipo?> <?php echo "<b>".$category['name']."</b>"; ?> <? if($category['idpai']==0){ echo " - <span style=color:red> Atenção, esta é uma categoria Pai. O ideal é cadastrar atributos somente em categorias filhas</span>";} if($categoriapai) { echo " em ". $categoriapai['name']."";}?></h4></div>
							<div class="the-button" style="width:243px;"> 
								<input type="hidden" value="remote" id="deliverytype" name="deliverytype">
								<div style="float:left;"><button onclick="doupdate();" id="run-button" class="input-btn" type="button"> 
									<div name="spinner-top" id="spinner-top" style="width: 83px; display: block;"><img name="imgrec" id="imgrec" src="<?=$ROOTPATH?>/media/css/i/lendo.gif" style="display: none;"></div>
									<div id="spinner-text"  >Salvar</div>
									</button></div>
									<div style="float:left;"><button  onclick="javascript:location.href='<?=$ROOTPATH?>/vipmin/category/index.php?zone=group'"  id="run-button" class="input-btn" type="button"><div name="spinner-top" id="spinner-top" style="width: 83px; display: block;"><img name="imgrec" id="imgrec" src="<?=$ROOTPATH?>/media/css/i/lendo.gif" style="display: none;"></div><div id="spinner-text"  >Voltar</div></button></div>
								</div>  
					</div> 
					<div id="container_box">
						<div id="option_contents" class="option_contents"> 
							<div class="form-contain group">
								<!-- =============================   coluna esquerda   =====================================-->
								<div class="starts"> 
									<div style="clear:both;"class="report-head">Nome: <span class="cpanel-date-hint"></span></div>
									<div class="group">
										<input type="text" name="nome_atributo"  maxlength="50" id="nome_atributo" class="format_input ckeditor" value="<?php echo $category_atributos['nome_atributo'] ?>" /> 
									</div> 
									 
									<div class="report-head">Atributo Pai: <span class="cpanel-date-hint">Ex: Atributo Pai: <b>Marcas</b> - Atributo Filho: <b>Philips</b> ( Deixe em branco se este for o atributo Pai )</span></div>
									<div class="group">
										<div class="cjt-wrapped-select" id="type-select-cjt-wrapped-select">
										<select  name="id_atributopai" id="id_atributopai" onchange="$('#select_id_atributopai').text($('#id_atributopai').find('option').filter(':selected').text())"> 
											<option value=""> </option>
											 <?php  
													if($category_atributos['id']){
															$aux =  " and id <> ".$category_atributos['id'];
													}
													
													$indentacao = "....";  
													$sql = "select * from category_atributos where category_id='".$category['id']."' and (id_atributopai ='' or id_atributopai is Null or id_atributopai =0 )$aux order by ordem and status <> 1 desc";
													$rs = mysql_query($sql);
													while($l = mysql_fetch_assoc($rs)){
													 $selected ="";
													 if($category_atributos['id_atributopai'] == $l['id']){
															$selected =  " selected ";
													 }
		
														echo "<option value='$l[id]' $selected>".displaySubStringWithStrip($l[nome_atributo],30)."</option>";
														//exibe_atributos_filhos($l["id"],$indentacao,$category_atributos['id_atributopai'],$category_atributos['id']);
													}
													$tb = null; 

												 ?>
										</select>
										<div name="select_id_atributopai" id="select_id_atributopai" class="cjt-wrapped-select-skin">Informe o atributo pai</div>
										<div class="cjt-wrapped-select-icon"></div>
										</div> &nbsp;<img class="tTip" title="Quando você informa um atributo pai, ele irá aparecer como opções de filtro do atributo superior. Não é possível associar um atributo a um outro que já seja filho ou seja, se o atributo B já tem um pai A então B não pode ser pai de outro." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
									</div> 
									
									<div class="group">
										<div style="clear:both;"class="report-head">Ativa: <span class="cpanel-date-hint"></span></div>
										<input style="width:20px;" type="radio" <? if($category_atributos['status'] =="1" or $category_atributos['status'] ==""){echo "checked='checked'";}?>  value="1" name="status" > Sim  &nbsp;   
										<input style="width:20px;" type="radio" <? if($category_atributos['status'] =="0"){echo "checked='checked'";}?>   name="status" value="0"> Não  &nbsp;  
									 </div>
									 
								</div>
								<!-- =============================   fim coluna esquerda   =====================================-->
								<!-- =============================   coluna direita   =====================================-->
								<div class="ends"> 	 	 
								
									<div class="report-head">Ordenação: <span class="cpanel-date-hint">Sugestão: Informe intervalos de 50 para cada categoria</span></div>
									<div class="group">
										<input type="text" id="ordem" onKeyPress="return SomenteNumero(event);"  name="ordem" value="<?php echo $category_atributos['ordem'] ? $category_atributos['ordem'] : 0; ?>"> &nbsp;<img class="tTip" title="Informe a ordem de posicionamento. Ordenação maior fica na frente de ordenação menor." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
									</div>	
								 <div class="report-head">  <span class="cpanel-date-hint"> Atenção: Os produtos são associados somente em atributos filhos. <br>Exemplo: Ao cadastrar o produto <b>Chapinha Titanium</b> que é da marca Philips, este será associado na categoria Beleza e no Atributo filho: <b>Philips</b> </span></div>
								 </div>
								<!-- =============================  fim coluna direita  =====================================-->
							</div> 
						</div>
					</div>
						<div class="top-heading group"> <div class="left_float"><h4>Atributos Cadastrados</h4></div></div>
						<div class="form-contain group">
								<!-- =============================   coluna esquerda   =====================================-->
								<?php
								$sqlCat = "select id, nome_atributo from category_atributos where ( id_atributopai=0 or id_atributopai is null) and category_id=".$category['id'];
								$rsCat = mysql_query($sqlCat);
								?>
								<div class="starts"> 
									<?
									while($r1 = mysql_fetch_assoc($rsCat)) {?> 
										<div style="clear:both;" style="font-size:14px;font-family:verdana;color:#586061;font-weight:bold;"><?=$r1['nome_atributo'] ?> <a href="<?=$ROOTPATH?>/ajax/manage.php?action=atributoremove&id=<?php echo $r1['id']; ?>" class="ajaxlink" ask="Você tem certeza que deseja apagar?" ><img alt="Excluir" title="Excluir" style="width: 10px;" src="/media/css/i/excluir.png"></a></div>
										<? 
										$sqlAtrib = "select id,nome_atributo from category_atributos where id_atributopai=".$r1['id'];
										$rsAtrib = mysql_query($sqlAtrib);
										
										if(mysql_num_rows($rsAtrib)>0){
											?>
											<div class="ends" style="padding-left:33px;min-height:5px;">
											<?											
											while($r2 =  mysql_fetch_assoc($rsAtrib)) {?> 
												 	 <div style="clear:both;"class="report-head"><?=$r2['nome_atributo'] ?> <a href="<?=$ROOTPATH?>/ajax/manage.php?action=atributoremove&id=<?php echo $r2['id']; ?>" class="ajaxlink" ask="Você tem certeza que deseja apagar?" ><img alt="Excluir" title="Excluir" style="width: 10px;" src="/media/css/i/excluir.png"></a></div>
											 <? }?>
											 </div>
										 <? }
									} ?>
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
 

 if( jQuery("#id").val() ==""){
 
}
else{ 
 
	$('#select_id_atributopai').text($('#id_atributopai').find('option').filter(':selected').text());
}
 
function msg(){
		return true;
 }
 </script>