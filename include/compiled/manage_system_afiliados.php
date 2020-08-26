<?php include template("manage_header");?>
 
<div id="bdw" class="bdw">
<div id="bd" class="cf" style="margin-top:-52px;">
<div id="partner"> 
	<div id="content" class="clear mainwide">
        <div class="clear box"> 
            <div class="box-content">
			 <div class="option_box">
					<div class="top-heading group"> <div class="left_float"><h4>Programa de Afiliados</h4></div> </div> 
						<div class="sect">
						<form method="post">
	 
					   <div class="field"> 
							<div class="inputtip"> 
							<img style="" src="/media/afiliados/imgFluxo.png"><br>
							 <br>Um programa de afiliados nada mais é que uma empresa que faz a relação entre anunciantes e donos de sites, visando compra e venda de publicidade. Um programa de afiliados, pode possuir campanhas dos seguintes tipos:
							- CPC - Custo por clique, é quando os anunciantes do programa de afiliados pagam por cada clique em um link ou banner;
							- CPM - Custo por Mil, é quando os anunciantes do programa de afiliados pagam a cada mil visualizações de seus banners;
							- CPA - Custo por Ação, é quando os anunciantes do programa de afiliados pagam por cada ação que o leitor toma acessando através de um banner ou link presente em um determinado site. Uma ação por exemplo seria realizar um cadastro.
							</div>
						</div>	
						 
						 <div class="wholetip clear"><h3><?php echo ++$index; ?>. <img style="width:184px;" src="/media/afiliados/afilio.png">  </h3></div>
						  <div class="field">
							<a target="_blank" href="http://www.afilio.com.br">acessar o site www.afilio.com.br</a>  
							<div class="inputtip">
								<br /><b>Informações:</b>
								Afiliads é uma rede de publicidade que trabalha com o CPC (Custo por Clique). Após o webmaster ou blogger ser aceito na rede, é disponibilizada a tag para que o mesmo coloque em seu blog o site banners dos anunciantes da Afiliads, e a rentabilização é feita sempre que um clique único é efetuado em um desses banners. 
							 </div>
						 </div>		
 

						<div class="wholetip clear"><h3><?php echo ++$index; ?>. <img style="width:184px;" src="/media/afiliados/lomadee.jpg"></h3></div>
						<div class="field">  
						<a target="_blank" href="http://www.lomadee.com">acessar o site www.lomadee.com</a>  
						<br /><b>Informações:</b>
						Esta rede de publicidade possui várias campanhas na qual o afiliado pode se inscrever na que for de seu interesse. Tais campanhas trabalham com CPC, CPM e CPA. Interessante forma de publicidade, uma vez que o afiliado escolhe o programa que lhe agrada. </div>		

 
						 </div>	
	  
						</form>
							</div>
						</div>
					</div>
                </div>
			<div class="box-bottom" style="margin-top:65px;"></div>
            </div> 
        </div>
	</div>

<div id="sidebar">
</div>

 
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->


<script>

 
function atualizar(tipo){
	
jQuery("#"+tipo).html("<img style=margin-left:50px; src=<?=$INI['system']['wwwprefix']?>/skin/padrao/images/ajax-loader2.gif> Gerando...");
	
	
$.get("<?=$INI['system']['wwwprefix']?>/agregadores/gera_xml_"+tipo+".php",
 			
   function(data){
	 jQuery("#"+tipo).html("");
     alert("xml atualizado com sucesso");
   });
}
</script> 

