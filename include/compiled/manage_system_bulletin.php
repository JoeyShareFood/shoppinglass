<?php include template("manage_header");?>



<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="system"> 
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="box-top"></div>
            <div class="box-content">
				<div class="option_box">
					<div class="top-heading group"> <div class="left_float"><h4>Banner do Topo - Sugest&atilde;o: 1200px x 223px  - Mantenha a proporcionalidade  </h4></div> 
						<div class="the-button" style="width:108px;">  
								<div style="float:left;"><button onclick="doupdate();" id="run-button" class="input-btn" type="button"><div name="spinner-top" id="spinner-top" style="width: 83px; display: block;"><img name="imgrec" id="imgrec" src="<?=$ROOTPATH?>/media/css/i/lendo.gif" style="display: none;"></div><div id="spinner-text"  >Salvar</div></button></div>
						</div>  						
					</div>  
							 
					<div class="sect">
						Está sem idéias para criar seus banners ? <a target="_blank" href="http://www.vipcomsites.com.br/planos-de-marketing/criacao-de-banners">Veja nossos planos</a> de criação de banners profissionais e de alta qualidade
			
						<form id="login-user-form" method="post" action="/vipmin/system/bulletin.php">
							<input type="hidden" name="id" value="<?php echo $system['id']; ?>" /> 					  
							<div class="report-head"> </div>
							<div class="field" style="width:99%;display:none;">
								<textarea   style="width:100%;height:450px;" class="ckeditor" name="bulletin[bannermeio]"><?php echo htmlspecialchars($INI['bulletin']['bannermeio']); ?></textarea> 
							</div> 

							<div class="top-heading group" style="display:none;"> <div class="left_float"><b> Banner superior lateral direita - Home </b>- <span class="report-head"> Diversifique a sua homepage com novos banners na lateral superior.  - Sugest&atilde;o:  320x180.</span> </div> 
							 
								<div class="field" style="width:99%;display:none;">
									<textarea   style="width:100%;height:450px;" class="ckeditor" name="bulletin[bannertopoprodutoshome]"><?php echo htmlspecialchars($INI['bulletin']['bannertopoprodutoshome']); ?></textarea> 
								</div>
							</div> 
							
							
							<div class="top-heading group"> <div class="left_float"><b> Banner superior lateral direita - Página do produto </b>- <span class="report-head"> Diversifique a sua página do produto com novos banners na lateral superior direita. - Sugest&atilde;o:  320x180.</span> </div> 
							 
								<div class="field" style="width:99%">
									<textarea   style="width:100%;height:450px;" class="ckeditor" name="bulletin[bannerpageproduct]"><?php echo htmlspecialchars($INI['bulletin']['bannerpageproduct']); ?></textarea> 
								</div>
							</div> 
							
						 
						</form>
					</div>
				</div>
            </div>
            <div class="box-bottom"></div>
        </div>
	</div>

<div id="sidebar">
</div> 
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<script>
function validador(){
	return true;
}
 	
</script>
