<?php include template("manage_header");?>
<?php require("ini.php");?> 

 

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="leader">
	<div id="content" class="clear mainwide">
        <div class="clear box"> 
            <div class="box-content">
                <div class="sect">
				<form id="nform" id="nform"  method="post" action="/vipmin/team/atributos.php?id=<?php echo $team['id']; ?>" enctype="multipart/form-data" class="validator">
				<input type="hidden" id="id" name="id" value="<?php echo $team['id']; ?>" />
				<input type="hidden" name="guarantee" value="Y" />
				<input type="hidden" name="system" value="Y" /> 
				<input type="hidden" name="www" id="www"  value="<?=$INI['system']['wwwprefix']?>" /> 
				<div class="option_box">
					<div class="top-heading group">
						<div class="left_float"><h4>Gerenciar Atributos</h4></div>
							<div class="the-button" style="width:203px;">   
								<div style="float:left;"><button onclick="doupdate();" id="run-button" class="input-btn" type="button"><div name="spinner-top" id="spinner-top" style="width: 83px; display: block;"><img name="imgrec" id="imgrec" src="<?=$ROOTPATH?>/media/css/i/lendo.gif" style="display: none;"></div><div id="spinner-text"  >Salvar</div></button></div>
						  </div> 
					</div> 
				 
					 <div id="container_box">
						<div id="option_contents" class="option_contents">  
							<div class="form-contain group">
								<!-- =============================   coluna esquerda   =====================================-->
								<div class="starts">
									<input type="hidden" value="normal" name="team_type">  
									<div style="clear:both;"class="report-head">Nome do produto: <span class="cpanel-date-hint"></span></div>
									<div class="group">
										<b><?=$team[title]?></b>
									 </div>  
									<div id="c_categoria">
										<div class="report-head">Categoria: <span class="cpanel-date-hint"></span></div>
										<div class="group">
											<div class="cjt-wrapped-select" id="type-select-cjt-wrapped-select">
											<select  name="group_id" id="group_id" onchange="$('#select_group_id').text($('#group_id').find('option').filter(':selected').text())"> 
												<option value=""> </option>
												 <?php 
														 
												   $indentacao = "....";
											       $sql = "select * from category where display ='Y' and idpai=0 order by sort_order desc";

													$rs = mysql_query($sql);
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
														data: { filtro: 'atributos', idcategoria: jQuery('#group_id').val(),team_id: '<?= $team['id']; ?>' },
														beforeSend: function() {
															//jQuery('#select_id_atributo').html('Carregando...');
															//jQuery('#id_atributo').html('<option>Carregando...</option>');
														},
														success: function(r) {
															jQuery('#select_id_atributo').html('Selecione os atributos (Opcional)');
															 jQuery('#select_id_atributo').html(r);
														}
													});
												});
											});
										</script>
										
											<div name="select_group_id" id="select_group_id" class="cjt-wrapped-select-skin"><B>Informe a categoria</B></div>
											<div class="cjt-wrapped-select-icon"></div>
											</div> &nbsp;<img class="tTip" title="Para buscar os atributos você precisa escolher a categoria. Se você não cadastrou nenhum atributo de categoria, você pode cadastrar acessando o menu Sistema->Categorias, nos ícones a direita, clique em atributos." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
										</div>  
										</div>  
										
									</div> 
									<div class="ends"> 
										<div class="group"> 
									 	<div class="report-head">Selecione os atributos <span class="cpanel-date-hint">Primeiro escolha a categoria</span> <br><span class="cpanel-date-hint"><a href="/vipmin/category/atributoedit.php?zone=group&idcategoria=<?=$categoria[id]?>">Cadastrar atributos da categoria <?=$categoria[name]?></a> <B>OPCIONAL</B>   &nbsp;<img class="tTip" title="Atributos ajudam a filtrar ainda mais a busca do usuário. Ex: O produto Batedeira da Arno 110v está na categoria Eletroportáteis e no atributo filho Arno associado ao atributo pai Marcas" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png"></span></div>
											 
										
											<div id="select_id_atributo" class="select_id_atributo"></div>
										</div> 
								 </div>
								 
								</div>
								<!-- =============================   fim coluna esquerda   =====================================-->
								<!-- =============================   coluna direita   =====================================-->
							
								<!-- =============================  fim coluna direita  =====================================-->
							</div> 
						</div>
					</div>
				</div> 
				</div> 
				<div class="option_box"> 
					<div id="container_box">
						<div id="option_contents" class="option_contents">
							<div class="the-button"> 
								<button onclick="doupdate();" id="run-button" class="input-btn" type="button">
									<div id="spinner" style="width: 83px; display: block;"> <img name="imgrec2" id="imgrec2" src="<?=$ROOTPATH?>/media/css/i/lendo.gif" style="display: none;"></div>
									<div id="spinner-text2">Salvar</div>
								</button>
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
var www = jQuery("#www").val();
  
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
	
	 $('#posicionamento').val(11); 
	 $('#select_posicionamento').text("Apareça em Destaque") 
	 
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

function doupdate(){
 
		$("#spinner-text").css("opacity", "0.2");
		$("#spinner-text2").css("opacity", "0.2");
		jQuery("#imgrec").show()
		jQuery("#imgrec2").show()
		document.forms[0].submit();
	 
}

function campoobg(campo){
 
	$("#"+campo).css("background", "#F9DAB7");
 
}

function verlayout(){ 
   if(jQuery("#posicionamento").val() == "6"){ // posicionalmento 6 = super banner
   
	   $.get(WEB_ROOT+"/vipmin/funcoes.php?acao=destaque",
	   
	   function(data){
		  if(jQuery.trim(data)!=""){
			alert(data); 
			jQuery("#posicionamento").val(4)  // posicionamento 4  =  detalhes
			$('#select_posicionamento').text($('#posicionamento').find('option').filter(':selected').text());
			jQuery("#dimensao").html("Dimensão ideal: 500px de largura por 500px de altura.")
		  } 
		 
	   });
   }
   else if(jQuery("#posicionamento").val() == "10"){
   
	   $.get(WEB_ROOT+"/vipmin/funcoes.php?acao=destaquenacional",
				
	   function(data){
		  if(jQuery.trim(data)!=""){
			alert(data); 
			jQuery("#posicionamento").val(4)
			$('#select_posicionamento').text($('#posicionamento').find('option').filter(':selected').text());
		  }  
		 
	   });
	   jQuery("#dimensao").html("Dimensão ideal na página detalhe: 500px de largura por 500pxpx de altura.")
   }
   else{
	jQuery("#dimensao").html("Dimensão ideal na página detalhe: 500px de largura por 500px de altura.")
   }
 
}


function verposicionamento(){
   
   if(jQuery("#posicionamento").val() == "6"){ // posicionalmento 6 = super banner
		jQuery("#dimensao").html("Dimensão ideal no super banner: 944px de largura por 256px de altura")	 
   } 
   else{
		jQuery("#dimensao").html("Dimensão ideal: 500px de largura por 500px de altura.");
	}
}

function delimagem(idoferta,campo){
 
$.get(WEB_ROOT+"/vipmin/delgal.php?id="+idoferta+"&gal="+campo,
 			
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
	
		if( jQuery("#market_price").val()=="<?=$currency?> 0,00"){
			campoobg("market_price");
			alert("Por favor, informe o preço antigo.");
			jQuery("#market_price").focus();
			return false;
		}	 
		
		if(Number(jQuery("#market_price").val().replace(/[^0-9]+/g,""))  < Number(jQuery("#team_price").val().replace(/[^0-9]+/g,"")) ){
			campoobg("market_price");
			alert("Observe que o valor do preço antigo não pode ser menor do que o valor do preço atual.");
			jQuery("#market_price").focus();
			return false;
		}
	/*
		if( Number(jQuery("#pre_number").val().replace(/[^0-9]+/g,""))  > Number(jQuery("#max_number").val().replace(/[^0-9]+/g,""))){
			campoobg("pre_number");
			alert(" O campo Quant. virtual. não pode ser maior do que o campo Estoque");
			jQuery("#pre_number").focus();
			return false; 
		}
*/
		if( Number(jQuery("#per_number").val().replace(/[^0-9]+/g,""))  > Number(jQuery("#max_number").val().replace(/[^0-9]+/g,""))){
			campoobg("per_number");
			alert(" O campo Quantidade máxima por pessoa não pode ser maior do que o campo Estoque");
			jQuery("#per_number").focus();
			return false;

		}
	 /*
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
	
	if( jQuery("#url_comprar").val() !=""  ){
			campoobg("url_comprar");
		  alert("Ao informar um link de redirecionamento no botão comprar, as regras dos campos venda min,Estoque,max/pessoa,min/pessoa, metodo pagamento, formas pagamento serão omitidas. ");
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
		jQuery("#c_pontos_ganho").show();
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
		jQuery("#url_comprar").val(""); 
		jQuery("#url_botao_comprar").hide();
		jQuery("#metododepagamento").hide(); 
		jQuery("#bk_processo_compra").hide(); 
		jQuery("#infoagregadores").hide(); 
		jQuery("#retorno_participe").show(); 
		jQuery("#preco_comissao").val("");
		jQuery("#c_pontos_quant").hide();
		jQuery("#c_pontos_ganho").hide();
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
		jQuery("#url_comprar").val(""); 
		jQuery("#url_botao_comprar").hide(); 
		jQuery("#metododepagamento").hide(); 
		jQuery("#bk_processo_compra").hide(); 
		jQuery("#infoagregadores").hide(); 
		jQuery("#retorno_participe").hide(); 
		jQuery("#preco_comissao").val("");
		jQuery("#c_pontos_quant").hide();
		jQuery("#c_pontos_ganho").hide();
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
		jQuery("#c_pontos_ganho").hide(); 
		jQuery("#parceirobk").show(); 
		jQuery("#cupomate").show(); 
		jQuery("#c_comissao").hide(); 
		jQuery("#processo_compra").val("0"); 
		jQuery("#team_price").val("0"); 
		jQuery("#preco_comissao").val("0");
		jQuery("#frete").val("0"); 
	//	jQuery("#pre_number").val("0"); 
		jQuery("#url_comprar").val(""); 
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
		jQuery("#c_pontos_ganho").show();		 
		jQuery("#url_botao_comprar").show();
		jQuery("#metododepagamento").show();
		jQuery("#bk_processo_compra").show();
		jQuery("#infoagregadores").show();
		jQuery("#retorno_participe").hide();
		jQuery("#preco_comissao").val("");
	}
} 

verposicionamento();


											
$.get(WEB_ROOT+"/ajax/filtro_pesquisa.php?filtro=atributos&idcategoria="+$('#group_id').find('option').filter(':selected').val()+"&team_id=<?=$team['id']?>",
 			
   function(r){
      jQuery('#select_id_atributo').html('Selecione os atributos (Opcional)');
	 jQuery('#select_id_atributo').html(r);
   });							
</script>   