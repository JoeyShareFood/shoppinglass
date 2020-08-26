<div style="display:none;" class="tips"><?=__FILE__?></div>

<?php  
require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/app.php');
 
?>

<!-- DIV PARA CADASTRAR -->
	<div style='padding:10px;background:#fff;height:500px;width:900px;'>
	 
		<? if($INI['other']['admin_id_login'] != "" and $INI['other']['app_id_login'] != ""){ ?>
					<div class="loginface" style="margin-left:377px;margin-top:4px;height:31px;"><a href="<?=$ROOTPATH?>/autenticacao/fb/login_facebook.php"> <img  src="<?=$PATHSKIN?>/images/fb-connect-large.png"> </a></div>
		<? } ?>
			   
			<form style="clear: both;" id="formcad" name="formcad"  METHOD="POST" action="autenticacao/login.php">
		   
			<div id="loading" style="display:none;clear: both;color:303030;font-size:12px;">  <div style="margin-left:20px;" id="txt"></div> </div>
			 
			 <img style="right:-10px;position:absolute;margin-top:56px;" src="<?=$ROOTPATH?>/skin/padrao/images/imagemcadastro.jpg" title="Receba por email nossas ofertas de compra coletiva de até 90% de desconto" alt="Receba por email nossas ofertas de compra coletiva de até 90% de desconto"> 
			
			<div style="width:300px;">
				<h2 style="font-size:25px;">Formulário de Cadastro</h2>
			 </div>
		
			<div style="float: left;clear: both;">
					<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:303030;font-size:12px;">Nome Completo*</span></div>
					 <input style="width:316px;font-size:12px;color:#303030;margin-right:10px;" name="username" type="text"  id="username" onFocus="if(this.value =='Insira o seu nome' ) this.value=''" onBlur="if(this.value=='') this.value='Insira o seu nome'" value="Insira o seu nome"  />
			</div>
			<div>
					<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:303030;font-size:12px;">Email*</span></div>
					<input style="width:238px;font-size:12px;color:#303030;" name="emailcadastro"  type="text"  id="emailcadastro" onFocus="if(this.value =='Insira o seu e-mail' ) this.value=''" onBlur="if(this.value=='') this.value='Insira o seu e-mail'" value="Insira o seu e-mail"  />
			</div>
			
			<? if($INI['option']['cpf']=="Y"){ ?>
				<div>
					<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:303030;font-size:12px;">CPF*</span></div>
					 <input   style="width:599px;font-size:12px;color:#303030;"  name="cpf" type="text" id="cpf" />
			 </div>
			<? } ?>
			
			<div style="float: left;clear: both;">
					 <div style="margin-bottom: 5px;"><span style="font-family:verdana;color:303030;font-size:12px;">Diga onde nos conheceu</span></div>
					 <input style="width:316px;font-size:12px;color:#303030;margin-right:10px;"  name="local"   type="text" id="local"    />
			 </div>
		
		    <div>
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:303030;font-size:12px;">Quero ver as ofertas desta cidade*</span></div>
				<select name="websites3" id="websites3" style="width: 258px;margin-right:8px;height:34px;padding:2px;" >
				<option value="">Escolha sua Cidade</option>
					<?php echo Utility::Option(Utility::OptionArray($allcities, 'id', 'name'), $city['id']); ?>
				</select>

			</div>
			<div class="meuendereco" style="clear: both;">   <img style="" src="<?=$ROOTPATH?>/skin/padrao/images/meuendereco.jpg">  </div>
			
			<div style="float: left;clear: both;" >
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:303030;font-size:12px;">Cep (apenas números)*</span></div>
				 <input style="width:316px;font-size:12px;color:#303030;margin-right:10px;"  onKeyPress="return SomenteNumero(event);" name="cep"  onblur="getEndereco();" type="text" id="cep"    />
			 </div>
			<div>
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:303030;font-size:12px;">Endereço*</span></div>
				 <input style="width:238px;font-size:12px;color:#303030;"  name="endereco"   type="text" id="endereco"    />
			</div>
			
			 <div style="float: left;clear: both;" >
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:303030;font-size:12px;">Número*</span></div>
				 <input style="width:56px;font-size:12px;color:#303030;margin-right:10px;"  name="numero"   type="text" id="numero"    />
			 </div> 
			 <div style="float: left;" >
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:303030;font-size:12px;">Complemento</span></div>
				 <input style="width:231px;font-size:12px;color:#303030;margin-right:10px;"  name="complemento"   type="text" id="complemento"    />
			 </div>
			<div>
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:303030;font-size:12px;">Bairro*</span></div>
				 <input style="width:238px;font-size:12px;color:#303030;"  name="bairro"   type="text" id="bairro"    />
			</div>
			<div style="float: left;clear: both;" >
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:303030;font-size:12px;">Cidade*</span></div>
				 <input style="width:318px;font-size:12px;color:#303030;margin-right:10px;"  name="cidadeusuario"   type="text" id="cidadeusuario"    />
			 </div>
			<div>
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:303030;font-size:12px;">Estado*</span></div>
				 <input style="width:238px;font-size:12px;color:#303030;"  name="estado"   type="text" id="estado"    />
			</div>

			 <div style="float: left;clear: both;">
					<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:303030;font-size:12px;">Telefone*</span></div>
					 <input style="width:209px;font-size:12px;color:#303030;margin-right:10px;" name="telefone" type="text" id="telefone"  />
			 </div>
			 <div style="float: left;">
					<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:303030;font-size:12px;">Senha*</span></div>
					 <input style="width:158px;font-size:12px;color:#303030;margin-right:10px;" name="passwordcad" type="password" id="passwordcad"  />
			 </div>
			<div>
				  <div style="margin-bottom: 5px;"><span style="font-family:verdana;color:303030;font-size:12px;">Redigite a senha*</span></div>
				  <input style="width:160px;font-size:12px;color:#303030;" name="password2"  type="password"  id="password2"   />
			</div>
			<div style="float: left;clear: both;">
				  <div > 
					<input style="width:20px;" type="checkbox" class="cinput" id="receberofertas" checked name="receberofertas"/> <span style="font-family:verdana;color:303030;font-size:12px;"> Gostaria de receber ofertas diárias por e-mail</span>
				  </div> 
			</div>
			<div>
				  <span style="font-family:verdana;color:303030;font-size:12px;">    &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;    * Campos obrigatórios</span> 
			</div>
			   
		
			<div style="padding-top: 20px;float: left;margin-right:23px; ">
				<div class="user-interactions clearfix">
					<button class="btn btn-primary btn-email">
						<span class="icon icon-email"></span>
						<a class="link-1" style="" href="javascript:cadastropop();"><em><b>Cadastrar</b></em></a>
					</button>
				</div>
			</div>
			 
				
	  </div>
	  
	 