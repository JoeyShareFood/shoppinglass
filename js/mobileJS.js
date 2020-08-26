
jQuery('document').ready(function(){

	//jQuery('#telefone').mask('(99) 9999-9999');
	
	jQuery('.navigation a').click(function() {		
		jQuery('.navigationMobile').toggleClass('hidden');
	});

	jQuery('.search-icon-div i').click(function() {
		jQuery('.input-search').toggleClass('hidden');
	});
	
	jQuery('.openLinkPanelUser').click(function() {		
		jQuery('.linkPanelUser').toggleClass('hidden');
	});
	
	jQuery(".rslides").responsiveSlides({
		manualControls: '#slider3-pager',
		width: 986
	});
	
	jQuery('#orderButton').click(function(){
		jQuery('.formularioCarrinhoM').submit();
	});
	
	jQuery('#formAuthRecover').click(function(){
		
		if(J("#emailM_recover").val() == ""){
			alert("Por favor, informe seu email.");
			jQuery("#loading").html("");
			document.getElementById("email").focus();
			return;
		}

		J.ajax({
			   type: "POST",
			   cache: false,
			   async: false,
			   url: URLWEB + "/autenticacao/repass.php",
			   data: "email="+J("#emailM_recover").val(),
			   success: function(retorno){
			   
			   if(jQuery.trim(retorno)==""){  
					alert("Sua senha foi enviada com sucesso para o seu email")
				 } 
			   else {			 
					alert(retorno);
			   }
			}
		});	
	});
	
	/* Login mobile. */
	jQuery('#formAuthLogin').click(function(){
	
		var email = jQuery("#emailM").val();
		var senha = jQuery("#passwordM").val();
		var referer = jQuery("#referer").val();
	
		jQuery.ajax({
			type: "POST",
			cache: false,
			async: true,
			url: URLWEB + "/autenticacao/login.php",
			data: "acao=logintoupup&email=" + email + "&password=" + senha,
			success: function(user_id){

				idusuario = jQuery.trim(user_id);
				
				if(jQuery.trim(idusuario)=="00"){
					alert("N&atilde;o foi poss&iacute;vel fazer o seu login. Por favor, verifique os seus dados.");
					jQuery("#loading").html("");
				} 
				else { 
					//alert (referer);
					location.href  = referer;
				}	
			}		  
		});
	});	
	
	/* Cadastro mobile. */
	jQuery('#formAuthRegister').click(function(){
	
		var cpf="";
		var cnpj="";
		var errocnpj	=	true;
		var errocpf		=	true;
		 
		if(J("#usernameM").val() == ""){
			alert("Por favor, informe seu nome.");
			jQuery("#loading").hide();
			document.getElementById("usernameM").focus();
			return;
		}
		
		if(J("#logincadastroM").val() == ""){
			alert("Por favor, informe seu login.");
			jQuery("#loading").hide();
			jQuery("#logincadastroM").val('');
			document.getElementById("logincadastroM").focus();
			return;
		}
			
		if(J("#emailM").val() == "Insira seu e-mail"){
			alert("Por favor, informe seu email.");
			jQuery("#loading").hide();
			document.getElementById("emailM").focus();
			return;
		} 
		cpf = J("input[name*='cpf']").val();
		
		if(cpf == ""){
			alert("Informe o seu CPF ou CNPJ.")
			document.getElementById("doccpfcnpj").focus();
			return;
		}	 
		
		// valida��o de CPF e CNPJ
		cpf_valida =  cpf.replace("-","");
		cpf_valida =  cpf_valida.replace(".","");
		cpf_valida =  cpf_valida.replace(".","");
		 

		if(!validaCPF(cpf_valida)){   
			  if(validaCNPJ(cpf)){ // � usado o mesmo campo para cpf e cnpj
				tipopessoa = "CPF";
				errocnpj = false;
			  } 
		}
		else{ 
			errocpf= false;
			tipopessoa = "CPF";
			
		}	
		
		if( errocpf==true & errocnpj==true){
			 alert("CPF ou CNPJ inv&aacute;lido. Por favor, verifique e tente novamente.")
			 document.getElementById("doccpfcnpj").focus();
			 return; 
		}		
		
		  
	  // dados de enrede�o
		 
		if(J("#cep").val() == ""){

			alert("Por favor, informe seu cep.");
			jQuery("#loading").hide();
			document.getElementById("cep").focus();
			return;
		}
		 if(J("#endereco").val() == ""){

			alert("Por favor, informe seu endereco.");
			jQuery("#loading").hide();
			document.getElementById("endereco").focus();
			return;
		} 
		if(J("#numero").val() == ""){

			alert("Por favor, informe o n&uacute;mero.");
			jQuery("#loading").hide();
			document.getElementById("numero").focus();
			return;
		}
		if(J("#bairro").val() == ""){

			alert("Por favor, informe seu bairro.");
			jQuery("#loading").hide();
			document.getElementById("bairro").focus();
			return;
		}
		if(J("#cidadeusuario").val() == ""){

			alert("Por favor, informe sua cidade.");
			jQuery("#loading").hide();
			document.getElementById("cidadeusuario").focus();
			return;
		}
		if(J("#estado").val() == ""){

			alert("Por favor, informe seu estado.");
			jQuery("#loading").hide();
			document.getElementById("estado").focus();
			return;
		}	
		if(J("#telefone").val() == ""){

			alert("Por favor, informe seu telefone.");
			jQuery("#loading").hide();
			document.getElementById("telefone").focus();
			return;
		}
		if(J("#passwordCM").val() == ""){
			alert("Por favor, informe sua senha.");
			jQuery("#loading").hide();
			document.getElementById("passwordCM").focus();
			return;
		}
		
		if(J("#password2").val() == ""){

			alert("Por favor, redigite sua senha.");
			jQuery("#loading").hide();
			document.getElementById("password2").focus();
			return;
		}
		
		if(J("#password2").val() != J("#passwordCM").val() ){
			alert("Por favor, revise suas senhas, elas n&atilde;o conferem.");
			jQuery("#loading").hide();
			document.getElementById("passwordCM").focus();
			return;
		}
	   
		J.ajax({
			   type: "POST",
			   cache: false,
			   async: false,
			   url: URLWEB + "/autenticacao/login.php",
			   data: "acao=cadastro&logincadastro="+J("#logincadastroM").val()+"&tipopessoa="+tipopessoa+"&telefone="+J("#telefone").val()+"&numero="+J("#numero").val()+"&cidadeusuario="+J("#cidadeusuario").val()+"&cep="+J("#cep").val()+"&endereco="+J("#endereco").val()+"&estado="+J("#estado").val()+"&complemento="+J("#complemento").val()+"&bairro="+J("#bairro").val()+"&cpf="+J("#doccpfcnpj").val()+"&username="+J("#usernameM").val()+"&passwordcad="+J("#passwordCM").val()+"&emailcadastro="+J("#emailCM").val()+"&websites3="+J("#websites3").val()+"&local="+J("#local").val()+"&password2="+J("#password2").val(),
			   success: function(user_id){
			 
			   flag =  user_id.indexOf("Falha");
			 
				if(flag!=-1){ 
					 alert(user_id);
					jQuery("#loading").hide();
				} 
				else {  
				  J("#idusuario").val(user_id);
				  idusuario = jQuery.trim(user_id);
					if(J("#utm").val()=="1"){
						  if(J("#tipooferta").val()=="participe"){
							participar(1);
						  }else{
							 enviapag() ;
						  }
					}
					  else{
						   alert("Realizamos seu cadastro com sucesso!");
						   location.href  = URLWEB + '/adminanunciante/system/index.php';;
					  }	 	
				 }
			}
		});	
	});
});