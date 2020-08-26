<div style="display:none;" class="tips"><?=__FILE__?></div>
<?
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
?>
<html>
<head>

</head>
<body>
<?php $systeminvitecredit = $INI['system']['invitecredit'] ;?>
<?php if(!$login_user_id){ ?>

	<div style="width:650px; height:540px;" id="naologado">

			<div style="text-align:left; font-size:14px">
			  <h2 style="margin-left:95px;width:437px;"><?=utf8_encode("Autentique-se para convidar")?></h2>
				<span> Email</span>
				<input type="text" style="margin-left:61px;font-size:15px;color:#000;background:#fff;-moz-box-shadow:0 0;width:400px;" name="email" id="email" onFocus="if(this.value =='Insira seu e-mail' ) this.value=''" onBlur="if(this.value=='') this.value='Insira seu e-mail'" value="Insira seu e-mail"   />
				<br>
				<span> Senha</span>
				<input  style="margin-left:56px;font-size:15px;color:#000;background:#fff;-moz-box-shadow:0 0;width:400px;" name="password" type="password" id="password" />
				 <br> 
				<div id="loadingcontato" style="display:none;"> <img style="margin-left:152px"; src="<?=$ROOTPATH?>/skin/padrao/images/ajax-loader.gif"> <span style="font-size:12px;color:#303030">Aguarde...</span><br></div>
			 </div>
				<?=utf8_encode("<span style='margin-left:72px;font-size:13px';> Após fazer o seu login, você deverá informar os dados de acesso do seu Gmail<br></span>")?>
				<span style='margin-left:72px;font-size:13px'> </span>
			<br><br>
			<a  id="btnimportar" style="margin-left:243px;"  href="javascript:loginajax(document.getElementById('email').value,document.getElementById('password').value );" class="link-1"><em><b>Entrar</b></em></a>

			<img  style="margin-left:245px;margin-top:30px; width:105px;"    src="<?=$ROOTPATH?>/skin/padrao/images/importacaocontatos.png">

	</div>

 <? } else{ ?>

	<div style="width:600px; height:530px;" id="conteudo">

			<div style="text-align:left; font-size:14px">
			  <h2 style="font-size:20px;"><?=utf8_encode("Convide e tenha mais chances de ganhar créditos")?> </h2>
                <span><?=utf8_encode(" Digite o seu e-mail e senha do Gmail para importar de forma fácil e prática todos os seus contatos e tenha mais chances de ganhar créditos a cada cadastro bem sucedido.")?></span>
				<br><br>
				<span> Email</span>
				<input type="text" style="margin-left:61px;font-size:15px;color:#000;background:#fff;-moz-box-shadow:0 0;width:400px;" name="emailshare" id="emailshare" onFocus="if(this.value =='Insira o email do Gmail' ) this.value=''" onBlur="if(this.value=='') this.value='Insira o email do Gmail'" value="Insira o email do Gmail"   />
				<br>
				<span> Senha</span>
				<input  style="margin-left:56px;font-size:15px;color:#000;background:#fff;-moz-box-shadow:0 0;width:400px;" name="passwordshare" type="password" id="passwordshare" />
				 <br><br>
				<div id="loadingcontato" style="display:none;"> <img style="margin-left:182px"; src="<?=$ROOTPATH?>/skin/padrao/images/ajax-loader.gif"> <span style="font-size:12px;color:#303030">Aguarde...</span><br></div>
			 </div>
				<?=utf8_encode("<span style='margin-left:0px;font-size:13px';> O ".utf8_decode($INI['system']['sitename'])." não armazena a senha do seu e-mail e nem dispara e-mails sem a sua autorização prévia. <b>Este processo pode demorar vários minutos. Por favor, tenha paciência.</b></span>")?>
			<br><br>

            <a  id="btnimportar" style="margin-left:220px;" href="javascript:importarcontatos( );"  class="link-1"><em><b>Importar contatos</b></em></a>

			<img  style="margin-left:245px;margin-top:30px;width:105px;"  src="<?=$ROOTPATH?>/skin/padrao/images/importacaocontatos.png">

	</div>

<? } ?>

<script>

function importarcontatos(email, senha){

	 erro = "0";
	 email = J("#emailshare").val()
	 senha = J("#passwordshare").val()


	   if(email == "" || email == "Insira o email do Gmail"){
			jQuery("#loadingcontato").hide();
			alert("<?=utf8_encode("Informe o seu email do Gmail")?>")
			erro = "1";
		}
		if( erro == "0" & senha== ""){
			jQuery("#loadingcontato").hide();
			alert("Informe a sua senha da rede social.")

			erro = "1";
		}
       if(erro == "0"){
		   jQuery("#loadingcontato").show();

			jQuery.ajax({
				   type: "POST",
				   cache: false,
				   async: true,
				   url: URLWEB+"/util/OpenInviter/postconvidar.php",
				   data: "username="+email+"&senha="+senha,
				   success: function(msg){
						  jQuery("#conteudo").html(msg);
				 }
			});
		}
}

</script>

</body>


</html>
