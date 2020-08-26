var retornoMoip;

function processaPagtoCredito(Instituicao, Parcelas, Recebimento, Numero, Expiracao, CVV, Nome, DataNascimento, Telefone, CPF) {
    this.settings = {
        "Forma"         :       "CartaoCredito",
        "Instituicao"   :       Instituicao,
        "Parcelas"      :       Parcelas,
        "Recebimento"   :       "AVista",
        "CartaoCredito" :       {
            "Numero"            :       Numero,
            "Expiracao"         :       Expiracao,
            "CodigoSeguranca"  :       CVV,
            "Portador"          :       {
                "Nome"          :       Nome,
                "DataNascimento":       DataNascimento,
                "Telefone"      :       Telefone,
                "Identidade"    :       CPF
            }
        }
    };
}

processaPagtoCredito.prototype.executa = function() {
    MoipWidget(this.settings);
}

var bandeira;
var numero;
var validade;
var cvv;
var nome;
var dataNascimento;
var parcelas;
var idPedido;
var paginaInicial;
var nomeCliente;
var telefoneCliente;
var CPFCliente;
var cliente; 
var idcliente; 
var Valor;

function processaPagamento(Cliente, Pedido, Valor) {
	   
    if (jQuery('#linhaNascimento').css('display') == 'none') {
        jQuery('#linhaNascimento').fadeIn(500);
    } else {
	
        bandeira = jQuery('input[name=bandeira]:radio:checked').val();
        numero   = jQuery('#numerocartao').val();
        validade = jQuery('#validadecartao').val();
        id_rand_ = jQuery('#id_rand').val();
        cvv      = jQuery('#segurancacartao').val();
        nome     = jQuery('#nomecartao').val();
        dataNascimento = jQuery('input[name=data_nascimento]').val();
        parcelas = jQuery('select[name=parcelas]').val();
		if(Valor==""){
				Valor =  jQuery('#valoranuncio').val();
		}
		 
        idPedido = Pedido;
        idcliente = Cliente;
		    
		J.colorbox({html:"<img src="+WEB_ROOT+"/skin/padrao/images/ajax-loader2.gif> <font color='black' size='2'>Validando os dados com a operadora do cartão. Por favor, aguarde...</font> "});
	 
        jQuery.ajax({
            type: 'POST',
            data: {
                cliente: Cliente,
                pedido: Pedido,
                id_rand: id_rand_,
                valor: Valor,
                bandeira: bandeira,
                numero: numero,
                validade: validade,
                cvv: cvv,
                nome: nome,
                parcelas: parcelas
            },
			 
            url: WEB_ROOT+"/include/moip/moip.php",
            success: function(response) {
                retornoXML(response);
            }
        })
    }
}

function finalizaanuncio(idcliente,idPedido){
  
	 Valor =  jQuery('#valoranuncio').val();
		 
	 J.get(WEB_ROOT+"/include/funcoes.php?acao=finalizaanuncio&partner_id="+idcliente+"&idpedido="+idPedido+"&valor="+Valor+"&idplano="+jQuery('#idplano').val()+"&team_id="+team_id ,
	  function(data){
		  if(jQuery.trim(data)!=""){ 
				alert(data)
		 }
		 else{
			J.colorbox({html:"<font color='black' size='2'> Pagamento realizado com sucesso!</font>"});
			 location.href = WEB_ROOT+"/adminanunciante/";
		}
	   });   
}
	
function SomenteNumero(e){
    var tecla=(window.event)?event.keyCode:e.which;   
    if((tecla>47 && tecla<58)) return true;
    else{
    	if (tecla==8 || tecla==0) return true;
	else  return false;
    }
}
function retornoXML(retorno) {
	  
	retornoarr = retorno.split('#');
	Status = jQuery.trim(retornoarr[0]);
	Erro = jQuery.trim(retornoarr[1]);
	token = jQuery.trim(retornoarr[2]);
	 /*
	// insere os dados do pagamento
	 J.get(WEB_ROOT+"/include/funcoes.php?acao=insere_dados_pagamento&partner_id="+idcliente+"&idpedido="+idPedido+"&valor="+Valor+"&idplano="+jQuery('#idplano').val()+"&team_id="+team_id+"&status_pagamento="+Status+"&mensagem="+Erro ,
	  function(data){
		  if(jQuery.trim(data)!=""){ 
				alert(data)
		 }   
	   });
	 */
		  
 
	if(Status==""){
	   J.colorbox({html:"<font color='black' size='2'> Token Inválido. Por favor, entre em contato conosco!</font>"});
	}		 
	else if(Status=="Falha") { // status do curl do php. ValidaÃ§Ã£o dos dados
				J.colorbox({html:"<font color='black' size='2'>"+Erro+"</font>"});
				 
				// busca um novo id para o pagamento
				J.get(WEB_ROOT+"/include/funcoes.php?acao=get_id_rand",
				  function(data){
					  if(jQuery.trim(data)!=""){ 
							jQuery('#id_rand').val(data)
					 }  
					  else{
						alert("Houve um erro ao requisitar a transação. Por favor, faça outro pedido.");
						 location.href = WEB_ROOT+"/adminanunciante/";
					  }
				   }); 
	}
	else if(Status=="Sucesso"){ 
	 
		jQuery('#contentmoip').append('<div id="MoipWidget" data-token="' + token + '" callback-method-success="functionSucessoPagamento" callback-method-error="functionFalhaPagamento"></div>');
		//EXECUTA PAGAMENTO
		//function processaPagtoCredito(Instituicao, Parcelas, Recebimento, Numero, Expiracao, CVV, Nome, DataNascimento, Telefone, CPF) {
		/*
		alert(bandeira)
		alert(parcelas)
		alert(numero)
		alert(validade)
		alert(cvv)
		alert(nome)
		alert(dataNascimento)
		alert(telefoneCliente)
		alert(CPFCliente) 
		*/
		
		Credito = new processaPagtoCredito(bandeira, parcelas, 'AVista', numero, validade, cvv, nome, dataNascimento, telefoneCliente, CPFCliente);
		Credito.executa();
    //alert('Estamos enviado o seu pagamento, aguarde enquanto ele Ã© processado.');
	}
	else {
		J.colorbox({html:"<font color='black' size='2'>Erro desconhecido. Por favor, volte mais tarde. Desculpe pelo transtorno</font>"});
	}
}

function functionSucessoPagamento(data) { 
	 //console.log(data)
	 var TotalPago = data.TotalPago;
	 var StatusPag = data.Status;
	 var CodigoMoIP = data.CodigoMoIP;
	 var MensagemPag = data.Mensagem;
	 
	 J.colorbox({html:"<img src="+WEB_ROOT+"/skin/padrao/images/ajax-loader2.gif><font color='black' size='2'>"+data.Mensagem+" - Aguarde a finalização do processo.</font>"});
	
	 J.get(WEB_ROOT+"/include/funcoes.php?acao=retorno_pagamento_moiptrans&idpedido="+idPedido+"&valor="+data.TotalPago+"&status_pagamento="+data.Status+"&gateway=moiptransparente&idtransacao="+data.CodigoMoIP+"&mensagem="+data.Mensagem,
	  function(data2){
			if(jQuery.trim(data2)!=""){ 
				alert(data2)
			}
			else{
				  location.href = WEB_ROOT+"/index.php?page=pagamentoEfetuado&p="+CodigoMoIP+"&mensagem="+MensagemPag+"&status_pagamento="+StatusPag;	
			}
		 
	   });
	   
}
 

function functionFalhaPagamento(data) {
   // alert('Houve um erro ao processar o seu pagamento, por favor, tente novamente em alguns instantes.');
    // J.colorbox.close();
	 retornoMoip = data;
	// console.log(retornoMoip)
	 htmlbox = "";
	//executo este laÃ§o para ecessar os itens do objeto javaScript
	for(i=0; i < retornoMoip.length; i++){
	// coloco o nome e sobre nome
		codigore =  retornoMoip[i].Codigo ;
		mensagemre =  retornoMoip[i].Mensagem ;
		htmlbox += "<strong>Codigo:</strong> "+codigore +" "+ mensagemre;
	// coloco a cidade
		 
	// e por ultimo dou uma quebra de linha
		htmlbox += "<br />";
	}//fim do laÃ§o
    
	J.colorbox({html: htmlbox});
 
	//alert(htmlbox);
 
	/*
    setTimeout(function() {
        location.href = WEB_ROOT;
    },5000);*/
}