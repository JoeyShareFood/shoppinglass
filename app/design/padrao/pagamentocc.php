<?php
require_once("include/head.php");
?>
<script>
   paginaInicial = '<?=$ROOTPATH?>';
   nomeCliente = '<?php echo $_POST['nomeUsuario']; ?>';
   telefoneCliente = '<?php echo $_POST['telefoneUsuario']; ?>';
   CPFCliente = '<?php echo $_POST['cpfUsuario']; ?>';
</script>
 

<script type="text/javascript" src="https://www.moip.com.br/transparente/MoipWidget-v2.js"></script>

<!-- SANDBOX
<script type="text/javascript" src="<?=$ROOTPATH?>/include/moip/MoipWidget-v2.js"></script>
-->
 
<script type="text/javascript" src="<?=$ROOTPATH?>/include/moip/moip.js"></script>

<body id="page1">
<div style="display:none;" class="tips"><?=__FILE__?></div>
<div class="cabecalhosub"></div>
<div class="tail-top">
    <div class="main">
       <?php  require_once(DIR_BLOCO."/header.php"); ?>
		<section id="content">
            <div class="inside">
				<div class="container">
					<div class="col-1c" style="margin-top:7px;">
						<div class="container">
						   <div class="col-6" style="box-shadow: 0px 2px 4px 0 #888888;  height: 401px; width:722px;"> 
								<div id="contentmoip"></div>
								 <h3 style="color:#303030;text-align:center;">Informe os dados do seu cartão de crédito</h3>

								   <?php  if ($_POST['acao']=="") { ?>
									  
									 <form id="formcadpg" name="formcadpg" method="post" action="">
									 
										<table width="629" border="0" class="oferdir">
										 <tr>  <td colspan="3"> &nbsp; </td>  </tr>
										  <tr>
											<td colspan="3" style="text-align:center;">
										        <input style="width:15px;" type="radio" id="bandeira" name="bandeira" value="Visa" checked="checked"> &nbsp;<img  title="Visa" alt="Visa"  src="<?=$PATHSKIN?>/images/visa-icon.png" />&nbsp;
										        <input style="width:15px;"type="radio" id="bandeira"  name="bandeira" value="Mastercard"> &nbsp;<img title="Mastercard" alt="Mastercard" src="<?=$PATHSKIN?>/images/mastercard-icon.png" />&nbsp;
										        <input style="width:15px;"type="radio" id="bandeira"  name="bandeira" value="Diners"> &nbsp;<img title="Diners Club" alt="Diners Club" src="<?=$PATHSKIN?>/images/diners-icon.png" />&nbsp;
										        <input style="width:15px;"type="radio" id="bandeira"  name="bandeira" value="AmericanExpress"> &nbsp;<img title="America Express" alt="America Express" src="<?=$PATHSKIN?>/images/american-express-icon.png" />&nbsp;
										    </td>
										  </tr>
											<tr>
											<td colspan="3">
											   Parcelas:<br/>
												<select name="parcelas" id="parcelas" style="width:703px;height:26px; padding:5px; font-size:11px;color:#000;">  </select>
											</td>
											</tr>
										  <tr>
											<td style="float: left;">Número do Cartão</td>
											<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
											<td style="float: left;">Validade Cartão (MM/AA)</td>
										  </tr>
										  <tr>
											<td><label for="nomeuso2"></label>
											  <input maxlength="16" size="18" name="numerocartao" id="numerocartao" onKeyPress="return isNumberKey(event);" style="width:324px;font-size:11px;color:#000;" value="" />
											</td>
											<td>&nbsp;</td>
											<td><label for="email"></label>
												 <input maxlength="5" size="12" name="validadecartao" id="validadecartao" style="width:324px;font-size:11px;color:#000;" value="" />
											</td>
										  </tr>

										 <tr>
											<td style="float: left;">Código de Segurança:</td>
											<td >&nbsp;&nbsp;&nbsp;&nbsp;</td>
											<td style="float: left;">Nome Impresso no Cartão:</td>
										  </tr>
										  <tr>
											<td><label for="nomeuso2"></label>
											  <input maxlength="5" size="6" name="segurancacartao" id="segurancacartao" onKeyPress="return isNumberKey(event);"  style="width:324px;font-size:11px;color:#000;"  value="" />
											  </td>
											<td>&nbsp;</td>
											<td><label for="email"></label>
											 <input maxlength="50" size="40" name="nomecartao" id="nomecartao"  value=""  style="width:324px;font-size:11px;color:#000;" />
											</td>

											<input type='hidden' readonly="readonly" name='valor' value='<?php echo $_POST["valor"]   ?>'>
											<input type="hidden" readonly="readonly" name="pedido" value="<?php echo  $_POST["pedido"] ?>">
											<input type="hidden" readonly="readonly" name="team_id" value="<?php echo $_POST["team_id"] ?>">
											<input type="hidden" readonly="readonly" id="bandeirainput" name="bandeirainput" value="">
											<input type="hidden" readonly="readonly" id="id_rand" name="id_rand" value="<?=mt_getrandmax()?>">
											<input type="hidden" readonly="readonly" name="acao" value="1">
										  </tr>
											<tr id="linhaNascimento">
											   <td colspan="3">
												  Data de Nascimento: Ex: 10/09/1981<br/>
												  <input type="text" id="data_nascimento"  name="data_nascimento" style="width:324px;font-size:11px;color:#000;"  />
											   </td>
											</tr>
										  <tr>
											<td colspan="3"> &nbsp;	</td>
										  </tr>

										  <tr>
											<td colspan="3">
											<a  href="#" onclick="realizarpagamento();" class="link-1"><em><b>ENVIAR</b></em></a>
											</td>
										  </tr>
										</table>
									 </form>
									 <? } ?>
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

J("#validadecartao").mask("99/99"); 
J("#data_nascimento").mask("99/99/9999"); 

 buscaParcelas('<?php echo $_POST["valorPedido"]; ?>')
 
function realizarpagamento(){

	if(validador()){ 
		 
		//idpagamento =  jQuery('#idpagamento').val() 
		//processaPagamento('<?php echo $idparceiro; ?>',idpagamento, ''); 
		processaPagamento('<?php echo $_POST['idUsuario']; ?>', '<?php echo $_POST["idPedido"]; ?>', '<?php echo $_POST["valorPedido"]; ?>');
	}
}

	function isNumberKey(Key)
	{
       var charCode = (Key.which) ? Key.which : event.keyCode
       if (charCode > 47 && charCode < 58 || charCode == 8)
          return true;
       return false;
    }


	function isCardDate(valor)
	{
		ano = new Date();
		hoje = ano.getFullYear();
		h = String(hoje).substr(2,2);
		m = Number(valor.substr(0,2));
		a = Number(valor.substr(3,2));
		if((isNaN(m))||(isNaN(a))||(m<1)||(m>12)||(a<Number(h)-1)||(a>Number(h)+10))
		    return false;
        else
		    return true;
	}

function buscaParcelas(valor){
  
		var mySelect = document.getElementById('parcelas');
		mySelect.options.length = 0;

		 J('#parcelas').append(J('<option></option>').val(1).html(1)); 
		if(valor/2 >= 5) { J('#parcelas').append(J('<option></option>').val(2).html(2));}
		if(valor/3 >= 5) { J('#parcelas').append(J('<option></option>').val(3).html(3));}
		if(valor/4 >= 5) { J('#parcelas').append(J('<option></option>').val(4).html(4));}
		if(valor/5 >= 5) { J('#parcelas').append(J('<option></option>').val(5).html(5));}
		if(valor/6 >= 5) { J('#parcelas').append(J('<option></option>').val(6).html(6));}
		if(valor/7 >= 5) { J('#parcelas').append(J('<option></option>').val(7).html(7));}
		if(valor/8 >= 5) { J('#parcelas').append(J('<option></option>').val(8).html(8));}
		if(valor/9 >= 5) { J('#parcelas').append(J('<option></option>').val(9).html(9));}
		if(valor/10 >= 5) { J('#parcelas').append(J('<option></option>').val(10).html(10));}
		if(valor/11 >= 5) { J('#parcelas').append(J('<option></option>').val(11).html(11));}
		if(valor/12 >= 5) { J('#parcelas').append(J('<option></option>').val(12).html(12));} 
		
		J('#select_parcelas').text(J('#parcelas').find('option').filter(':selected').text());
 
}


function validador(){ 
		
		limpacampos();
	
		bandeira 		= jQuery('input[name=bandeira]:radio:checked').val();
        parcelas   		= jQuery('#parcelas').val();
        numero   		= jQuery('#numerocartao').val();
        validade 		= jQuery('#validadecartao').val();
        cvv      		= jQuery('#segurancacartao').val();
        nome     		= jQuery('#nomecartao').val();
        dataNascimento 	= jQuery('input[name=data_nascimento]').val();
        parcelas 		= jQuery('select[name=parcelas]').val();
		Valor		 	=  jQuery('#valoranuncio').val();
	 
		
		if(!bandeira){
			campoobg("bandeira");
			alert("Por favor, informe a bandeira do cartão");
			jQuery("#bandeira").focus();
			return false;
		}
		
		if(parcelas==""){
			campoobg("parcelas");
			alert("Por favor, informe o número de parcelas");
			jQuery("#parcelas").focus();
			return false;
		}	
		
		if(numero==""){
			campoobg("numerocartao");
			alert("Por favor, informe o número do cartão");
			jQuery("#numerocartao").focus();
			return false;
		}
		
		
		if (numero.length < 13)
		{
			campoobg("numerocartao");
			alert("Número de cartão inválido.");
			jQuery("#numerocartao").focus();
			return false;
		}
		if (numero.length > 19)
		{
			campoobg("numerocartao");
			alert("Número de cartão inválido.");
			jQuery("#numerocartao").focus();
			return false;
		}
		
		if(validade==""){
			campoobg("validadecartao");
			alert("Por favor, informe a data de validade do cartão");
			jQuery("#validadecartao").focus();
			return false;
		}	
  
		if(cvv==""){
			campoobg("segurancacartao");
			alert("Por favor, informe o código de segurança do cartão");
			jQuery("#segurancacartao").focus();
			return false;
		}
		
			
		if(bandeira=="Visa" || bandeira=="Mastercard" || bandeira=="Diners"){
			if (cvv.length != 3)
			{
				campoobg("segurancacartao");
				alert("Código de segurança para essa bandeira é de 3 números.");
				jQuery("#segurancacartao").focus();
				return false;
			}
		}	
		
		if(bandeira=="AmericanExpress"){
			if (cvv.length != 4)
			{
				campoobg("segurancacartao");
				alert("Código de segurança para essa bandeira é de 4 números.");
				jQuery("#segurancacartao").focus();
				return false;
			}
		}
		
		if(nome==""){
			campoobg("nomecartao");
			alert("Por favor, informe o nome impresso no cartão");
			jQuery("#nomecartao").focus();
			return false;
		}	
		
		if(dataNascimento==""){
			campoobg("data_nascimento");
			alert("Por favor, informe a data de nascimento do titular do cartão");
			jQuery("#data_nascimento").focus();
			return false;
		}
		 
	return true;	
}


function campoobg(campo){
 
	J("#"+campo).css("background", "#F9DAB7");
 
}
 
function limpacampos(){		 
	J("input[type=text]").each(function(){ 
		J("#"+this.id).css("background", "#fff");
	}); 
	J("#upload_image").css("background", "#fff");
	
}


</script>
 <?php if ($_POST['acao']=="1" and $_SESSION['PG']=="sim") {
 	$_SESSION['PG'] =  "";
 ?>
	 <script>
		J(document).ready(function(){
		J.colorbox({html:"<div style='text-align:center;width:350px;heigth:300px;margin-top:3px;'><img width='160' src='"+URLWEB+"/include/logo/logo.jpg'></div><br><span style='margin-left:26px;font-size:13px;color:#303030'><?=$pagetitle?></span>"});
	});
	</script>
 <? }?>

</body>
</html>
