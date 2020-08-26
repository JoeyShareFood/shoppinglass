<?php include template("manage_header");?>

 

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner"> 
<form id="nform" id="nform"  method="post" action="/vipmin/system/pageadd.php?id=<?php echo $team['id']; ?>" enctype="multipart/form-data" class="validator">
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="box-top"></div>
            <div class="box-content">  
				<input  type="hidden"  value="<?=$id ?>" name="idmodelo"  id="idmodelo"  >
				<input  type="hidden"  value="<?=$id?>" name="id"  id="id"  > 
				<div class="option_box">
					 <div class="top-heading group">
							<div class="left_float"><h4><b><span name="modificacao" id="modificacao"></span></b> </h4></div>
							<div class="the-button" style="width:337px;">
								<input type="hidden" value="remote" id="deliverytype" name="deliverytype">
								<div style="float:left;"><button onclick="doupdate();" id="run-button" class="input-btn" type="button"><div name="spinner-top" id="spinner-top" style="width: 83px; display: block;"><img name="imgrec" id="imgrec" src="<?=$ROOTPATH?>/media/css/i/lendo.gif" style="display: none;"></div><div id="spinner-text"  >Salvar</div></button></div>
								<button onclick="visualizar();" id="run-button" class="input-btn" type="button"> <div name="spinner-top" id="spinner-top" style="width: 83px; display: block;"><img name="imgrec" id="imgrec" src="<?=$ROOTPATH?>/media/css/i/lendo.gif" style="display: none;"></div><div id="spinner-text"  >Visualizar</div></button>
								<button onclick="javascript:location.href='pageadd.php'" id="run-button" class="input-btn" type="button"> <div name="spinner-top" id="spinner-top" style="width: 83px; display: block;"><img name="imgrec" id="imgrec" src="<?=$ROOTPATH?>/media/css/i/lendo.gif" style="display: none;"></div><div id="spinner-text"  >Nova</div></button>  
							</div> 
						</div>  
				</div> 
				
				<div  class="option_box">  
					<div id="container_box">
						<div id="option_contents" class="option_contents"> 
							<div class="form-contain group"> 
							<!-- =============================   coluna esquerda   =====================================-->
								<div class="starts" style="min-height:114px;"> 
									<div style="clear:both;"class="report-head">Título <span class="cpanel-date-hint"> Máximo de 40 caracteres </span></div>
									<div class="group">
										<input type="text" name="titulo"  maxlength="40"  id="titulo" class="format_input ckeditor" value="<?=$page[titulo]?>" />  
									</div>	
							
									 
								</div>
								<!-- ============================= // fim coluna esquerda // =====================================-->
								<!-- ============================= // coluna direita // =====================================-->
								<div class="ends" style="min-height:109px;"> 
									<div class="group">
										<div style="clear:both;"class="report-head">Ativa: <span class="cpanel-date-hint"></span></div>
										<input style="width:20px;" type="radio" <? if($page[status]=="1" or $page[status]  ==""){ echo "checked='checked'";}?>  value="1" name="status" id="status" > Sim  &nbsp;   
										<input style="width:20px;" type="radio" <? if( $page[status] =="0"){echo "checked='checked'";}?>   name="status"  id="status"  value="0"> Não   &nbsp;<img class="tTip" title="Páginas desativadas não aparecem no site. Isto pode ser ideal para você visualizar uma página antes de seus clientes. Para isso, salve a página como desativada, faça as alterações e ao finalizar, visualize, altere para ativa e clique no botão salvar." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
									</div>									
									<div class="group" style="margin-top:2%;">
										<div style="clear:both;"class="report-head">Menu do topo do site: <span class="cpanel-date-hint"></span></div>
										<input style="width:20px;" type="radio" <? if($page['maintop']=="1" or $page['maintop']  ==""){ echo "checked='checked'";}?>  value="1" name="maintop" id="maintop" > Sim  &nbsp;   
										<input style="width:20px;" type="radio" <? if( $page['maintop'] =="0"){echo "checked='checked'";}?>   name="maintop"  id="maintop"  value="0"> Não   &nbsp;<img class="tTip" title="Caso esta opção esteja ativa, o link da página irá aparecer na parte direita superior da loja." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
									</div>
		 
								</div> 
							</div> 
						</div>  
					</div> 
					<div class="sect" style="clear:both;" >
						<div class="field" style="width:99%">
							<textarea  id="value" style="width:100%;height:450px;" class="ckeditor" name="value"><?=htmlspecialchars($page[value]);?> </textarea> 
						</div>
					</div>
			</div>
		</div>
		<div class="box-bottom"></div>
	</div>
</div>
</div>

<div id="sidebar">
</div>

</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<script>
  
function visualizar( ){ 
		if(jQuery.trim(jQuery("#idmodelo").val()) != ""){ 
			
			  var windowSizeArray = [ "width=200,height=200",
                                    "width=300,height=400,scrollbars=yes" ];
    
				var url = "<?=$ROOTPATH?>/page/"+jQuery.trim(jQuery("#idmodelo").val());
				var windowName = "popUp";//$(this).attr("name");
				var windowSize = windowSizeArray[$(this).attr("rel")];

				window.open(url, windowName, windowSize);

				//event.preventDefault(); 
		}
		else{
			alert("Para visualizar esta página, você precisa salvá-la.")
		}
} 
   
 function limpacampos(){		 
	$("input[type=text]").each(function(){ 
		$("#"+this.id).css("background", "#fff");
	});  
	
}

function campoobg(campo){
	$("#"+campo).css("background", "#F9DAB7");
}

function validador(){
 
	limpacampos(); 
	titulo = jQuery("#titulo").val(); 
	value = tinyMCE.get("value").getContent(); 
	value=value.replace(/&/g,"|");
    
	if(titulo==""){
		alert("Por favor, informe o titulo da página")
		return false;
   }    
   if(value==""){
		alert("Por favor, informe algum conteúdo para esta página")
		return false;
   }
  return true;
}

 function doupdate(acao){
	 
	if(validador()){ 
		$("#spinner-text").css("opacity", "0.2");
		$("#spinner-text2").css("opacity", "0.2");
		jQuery("#imgrec").show()
		jQuery("#imgrec2").show()
	 
		document.forms[0].submit();
	}
}

</script>
 

<script>
if( jQuery("#id").val() ==""){
 
}
else{  
	$('#select_idpai').text($('#idpai').find('option').filter(':selected').text());
}
</script>