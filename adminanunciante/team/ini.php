<?php 

if($team['fretegratuito']=="1"){
	$fretegratuito_sim='checked="checked"';
}
else {
	$fretegratuito_nao='checked="checked"';
}
if($team['republicacao']=="1"){
	$republicacao_sim='checked="checked"';
}
else {
	$republicacao_nao='checked="checked"';
}
 
if($team['mostrarpreco']=="" or $team['mostrarpreco']=="1"  ){
	 $mostrarprecosim='checked="checked"';
}
else { 
	$mostrarpreconao='checked="checked"';
}

if($team['mostrarseguranca']=="" or $team['mostrarseguranca']=="1"  ){
	 $mostrarsegurancasim='checked="checked"';
}
else { 
	$mostrarsegurancanao='checked="checked"';
}

if($team['team_type']=="normal"){
	$checknormal='checked="checked"';
}
else if($team['team_type']=="off"){
	$checkoff='checked="checked"';
}
else  if($team['team_type']=="participe"){
	$checkparticipe='checked="checked"';
}
else  if($team['team_type']=="cupom"){
	$checkcupom='checked="checked"';
}
else  if($team['team_type']=="especial"){
	$checkoespecial='checked="checked"';
}
else{
	$checknormal='checked="checked"';
} 

if($team['frete']=="1"){
	$frete_sim='checked="checked"';
}
else{
	$frete_nao='checked="checked"';
}
 
 
if($team['retornoparticipe']==""){
  $team['retornoparticipe'] = " &lt;font color='black' size='10'>Sua participa&ccedil;&atilde;o foi registrada com sucesso ! &lt;/font>";
  }
  $option_posicao = array(
  "6"=>"Oferta Destaque", 
  "11"=>"Apare&ccedil;a em Ofertas Populares", 
  "10"=>"Oferta Destaque Nacional", 
  "4"=>"Apare&ccedil;a na coluna da direita", 
  "5"=>"Oferta Desativada"
  );  
  
 
  
  
  $categoria_valejunto= array(
  ""=>" Escolha a categoria",
  "01"=>"Esporte",
  "02"=>"Curso",
  "03"=>"Bar",
  "04"=>"Beleza",
  "05"=>"Turismo",
  "06"=>"Loja",
  "07"=>"Gastronomia",
  "08"=>"Eventos",
  "09"=>"Cultura",
  "10"=>"Fashion",
  "11"=>"Servi&ccedil;o",
  );
  $metodo_pagamento= array( 
  ""=>"Todos",
  "pagseguro"=>"Pagseguro",
  "pagamentodigital"=>"Pagamento Digital",
  "moip"=>"moip",
  "dinheiro"=>"DinheiroMail",
  "paypal"=>"paypal",
  "99"=>"Nenhum (Informa&ccedil;&otilde;es sobre este pagamento no campo Informa&ccedil;&otilde;es adicionais)",
  //"mercadopago"=>"Mercado Pago", 
  ); 
  $processo_compra= array(
  "1"=>"Compra R&aacute;pida",
  "0"=>"Normal ( fluxo tradicional )", 
  );
  
  if($team['processo_compra']==""){
  $team['processo_compra'] = 0 ;
  }
  $categoria_agrupi= array(
  ""=>" Escolha a categoria",
  "2"=>"Sa&uacute;de",
  "25"=>"Educa&ccedil;&atilde;o &amp; Leitura", 
  "22"=>"Gastronomia",
  "21"=>"Servi&ccedil;o",
  "20"=>"Beleza", 
  "19"=>"Produto", 
  "65"=>"Eventos", 
  "129"=>"Lazer", 
  );
  $categoria_dsconto= array(
  ""=>" Escolha a categoria",
  "1"=>"Sa&uacute;de &amp; Beleza",
  "2"=>"Divers&atilde;o &amp; Entretenimento",
  "3"=>"Cursos",
  "4"=>"Comidas &amp; bebidas",
  "5"=>"Hot&eacute;is &amp; Viagens",
  "6"=>"Compras",
  "7"=>"Neg&oacute;cios", 
  );
  //sort($categoria_dsconto);
$categoria_apontaofertas= array(
  ""=>" Escolha a categoria",
  "beleza"=>"Beleza e Sa&uacute;de",
  "cultura"=>"Cultura e Esporte",
  "cursos"=>"Cursos e Aulas",
  "produtos"=>"Produtos",
  "restaurantes"=>"Restaurantes e Bares",
  "servicos"=>"Servi&ccedil;os",
  "turismo"=>"Hot&eacute;is e Turismo",
  ); 
$cidade_apontaofertas= array(
  ""=>" Escolha a cidade",
  "0"=>"Oferta Nacional",
  "17"=>"ABCD-SP	SP",
  "76"=>"Americana	SP",
  "90"=>"Amparo	SP",
  "82"=>"An&aacute;polis	GO",
  "95"=>"Angra dos Reis	RJ",
  "131"=>"Aparecida	SP",
  "18"=>"Aracaju	SE",
  "51"=>"Balne&aacute;rio Cambori&uacute;	SC",
  "45"=>"Barra Mansa	RJ",
  "53"=>"Barueri	SP",
  "63"=>"Bauru	SP",
  "19"=>"Bel&eacute;m	PA",
  "3"=>"Belo Horizonte	MG",
  "107"=>"Betim	MG",
  "58"=>"Blumenau	SC",
  "20"=>"Boa Vista	RR",
  "64"=>"Botucatu	SP",
  "6"=>"Brasilia	DF",
  "100"=>"Ca&ccedil;apava	SP",
  "138"=>"Cachoeira Paulista	SP",
  "102"=>"Cama&ccedil;ari	BA",
  "118"=>"Campina Grande	PB",
  "10"=>"Campinas	SP",
  "21"=>"Campo Grande	MS",
  "61"=>"Campo Mour&atilde;o	PR",
  "134"=>"Campos do Jord&atilde;o	SP",
  "74"=>"Canoas	RS",
  "144"=>"Caraguatatuba	SP",
  "147"=>"Caruaru	PE",
  "111"=>"Casa Branca	SP",
  "77"=>"Cascavel	PR",
  "44"=>"Caxias do Sul	RS",
  "85"=>"Chapec&oacute;	SC",
  "62"=>"Cianorte	PR",
  "50"=>"Contagem	MG",
  "71"=>"Cotia	SP",
  "96"=>"Crici&uacute;ma	SC",
  "139"=>"Cruzeiro	SP",
  "22"=>"Cuiab&aacute;	MT",
  "5"=>"Curitiba	PR",
  "120"=>"Dois Vizinhos	PR",
  "72"=>"Embu	SP",
  "52"=>"Feira de Santana	BA",
  "16"=>"Florian&oacute;polis	SC",
  "9"=>"Fortaleza	CE",
  "99"=>"Foz do Igua&ccedil;u	PR",
  "59"=>"Franca	SP",
  "121"=>"Francisco Beltr&atilde;o	PR",
  "106"=>"Gar&ccedil;a	SP",
  "13"=>"Goi&acirc;nia	GO",
  "108"=>"Gramado	RS",
  "94"=>"Guarapuava	PR",
  "145"=>"Guaratinguet&aacute;	SP",
  "43"=>"Guarulhos	SP",
  "143"=>"Ilhabela	SP",
  "83"=>"Indaiatuba	SP",
  "126"=>"Itaja&iacute;	SC",
  "140"=>"Itanhandu	MG",
  "128"=>"Itapema	SC",
  "87"=>"Itapira	SP",
  "125"=>"Itatiba	SP",
  "54"=>"Itu	SP",
  "133"=>"Jacare&iacute;	SP",
  "23"=>"Jo&atilde;o Pessoa	PB",
  "36"=>"Joinville	SC",
  "11"=>"Juiz de Fora	MG",
  "35"=>"Jundia&iacute;	SP",
  "86"=>"Lages	SC",
  "40"=>"Londrina	PR",
  "132"=>"Lorena	SP",
  "84"=>"Maca&eacute;	RJ",
  "24"=>"Macap&aacute;	AP",
  "25"=>"Macei&oacute;	AL",
  "26"=>"Manaus	AM",
  "103"=>"Mar&iacute;lia	SP",
  "47"=>"Maring&aacute;	PR",
  "122"=>"Medianeira	PR",
  "117"=>"Mococa	SP",
  "91"=>"Mogi das Cruzes	SP",
  "89"=>"Mogi Gua&ccedil;&uacute;	SP",
  "88"=>"Mogi Mirim	SP",
  "97"=>"Mossor&oacute;	RN",
  "27"=>"Natal	RN",
  "15"=>"Niter&oacute;i	RJ",
  "68"=>"Nova Friburgo	RJ",
  "67"=>"Nova Igua&ccedil;u	RJ",
  "130"=>"Orl&acirc;ndia	SP",
  "70"=>"Osasco	SP",
  "28"=>"Palmas	TO",
  "146"=>"Paraty	RJ",
  "119"=>"Passo Fundo	RS",
  "123"=>"Pato Branco	PR",
  "75"=>"Pelotas	RS",
  "148"=>"Penha	SC",
  "57"=>"Petr&oacute;polis	RJ",
  "137"=>"Pindamonhangaba	SP",
  "48"=>"Piracicaba	SP",
  "113"=>"Pirassununga	SP",
  "78"=>"Po&ccedil;os de Caldas	MG",
  "56"=>"Ponta Grossa	PR",
  "8"=>"Porto Alegre	RS",
  "129"=>"Porto Belo	SC",
  "112"=>"Porto Ferreira	SP",
  "69"=>"Porto Seguro	BA",
  "29"=>"Porto Velho	RO",
  "60"=>"Presidente Prudente	SP",
  "14"=>"Recife	PE",
  "101"=>"Regi&atilde;o do Cariri	CE",
  "46"=>"Resende	RJ",
  "34"=>"Ribeir&atilde;o Preto	SP",
  "30"=>"Rio Branco	AC",
  "92"=>"Rio Claro	SP",
  "2"=>"Rio de Janeiro	RJ",
  "4"=>"Salvador	BA",
  "110"=>"Santa Cruz das Palmeiras	SP",
  "105"=>"Santa Cruz do Sul	RS",
  "149"=>"Santa Maria	RS",
  "116"=>"Santa Rita do Passa Quatro	SP",
  "115"=>"Santa Rosa de Viterbo	SP",
  "135"=>"Santo Ant&ocirc;nio do Pinhal	SP",
  "12"=>"Santos	SP",
  "136"=>"S&atilde;o Bento do Sapuca&iacute;	SP",
  "49"=>"S&atilde;o Carlos	SP",
  "114"=>"S&atilde;o Jo&atilde;o da Boa Vista	SP",
  "55"=>"S&atilde;o Jos&eacute; do Rio Preto	SP",
  "37"=>"S&atilde;o Jos&eacute; dos Campos	SP",
  "66"=>"S&atilde;o Jos&eacute; dos Pinhais	PR",
  "31"=>"S&atilde;o Lu&iacute;s	MA",
  "1"=>"S&atilde;o Paulo	SP",
  "142"=>"S&atilde;o Sebasti&atilde;o	SP",
  "80"=>"Sert&atilde;ozinho	SP",
  "93"=>"Sete Lagoas	MG",
  "38"=>"Sorocaba	SP",
  "73"=>"Tabo&atilde;o da Serra	SP",
  "109"=>"Tamba&uacute;	SP",
  "98"=>"Taubat&eacute;	SP",
  "32"=>"Teresina	PI",
  "127"=>"Tijucas	SC",
  "124"=>"Toledo	PR",
  "79"=>"Tri&acirc;ngulo Mineiro	MG",
  "81"=>"Tubar&atilde;o	SC",
  "141"=>"Ubatuba	SP",
  "104"=>"Uberaba	MG",
  "42"=>"Uberl&acirc;ndia	MG",
  "65"=>"Vale do A&ccedil;o	MG",
  "39"=>"Vale dos Sinos	RS",
  "150"=>"Varginha	MG",
  "33"=>"Vit&oacute;ria	ES",
  "41"=>"Volta Redonda	RJ",
  
  );
  //sort($cidade_apontaofertas);
$cidade_valejunto= array(
  ""=>" Escolha a cidade",
  "Belem"=>"Belem",
  "Recife"=>"Recife",
  "Belo_Horizonte"=>"Belo Horizonte",
  "Ribeirao_Preto"=>"Ribeirao Preto",
  "Campo_Grande"=>"Campo Grande",
  "Blumenau"=>"Blumenau",
  "Rio_de_Janeiro"=>"Rio de Janeiro",
  "Brasilia"=>"Brasilia",
  "Salvador"=>"Salvador",
  "Barra_Mansa"=>"Barra Mansa",
  "Campinas"=>"Campinas",
  "Santos"=>"Santos",
  "Resende"=>"Resende",
  "Curitiba"=>"Curitiba",
  "Bauru"=>"Bauru",
  "Maringa"=>"Maringa",
  "Florianopolis"=>"Florianopolis",
  "Sao_Goncalo"=>"Sao Goncalo",
  "Duque_de_caxias"=>"Duque de caxias",
  "Fortaleza"=>"Fortaleza",
  "Sao_J_do_Rio_Preto"=>"Sao Jo&atilde;o do Rio Preto",
  "Nova_Friburgo"=>"Nova Friburgo",
  "Goiania"=>"Goiania",
  "Sao_J_dos_Campos"=>"Sao Jo&atilde;o dos Campos",
  "Cabo_Frio"=>"Cabo Frio",
  "Guaruja"=>"Guaruja",
  "Sao_Luis"=>"Sao Luis",
  "Buzios"=>"Buzios",
  "Guarulhos"=>"Guarulhos",
  "Sao_Paulo"=>"Sao Paulo",
  "Governador_Valadar"=>"Governador Valadar",
  "Joao_Pessoa"=>"Joao Pessoa",
  "Sorocaba"=>"Sorocaba",
  "Itu"=>"Itu",
  "Joinville"=>"Joinville",
  "Vitoria"=>"Vitoria",
  "Mogi_das_Cruzes"=>"Mogi das Cruzes",
  "Juiz_de_Fora"=>"Juiz de Fora",
  "Jundiai"=>"Jundiai",
  "Nilopolis"=>"Nilopolis",
  "Londrina"=>"Londrina",
  "ABCD_Sao_Paulo"=>"ABCD Sao Paulo",
  "Pocos_de_Calda"=>"Pocos de Calda",
  "Manaus"=>"Manaus",
  "Caxias_do_Sul"=>"Caxias do Sul",
  "Gramado"=>"Gramado",
  "Natal"=>"Natal",
  "Uberlandia"=>"Uberlandia",
  "Mogi_Mirim"=>"Mogi Mirim",
  "Niteroi"=>"Niteroi",
  "Cuiaba"=>"Cuiaba",
  "Rio_Claro"=>"Rio Claro",
  "Nova_Iguacu"=>"Nova Iguacu",
  "Volta_Redonda"=>"Volta Redonda",
  "Campos_dos_Goytacazes"=>"Campos dos Goytacazes",
  "Osasco"=>"Osasco",
  "Criciuma"=>"Criciuma",
  "Feira_de_Santana"=>"Feira de Santana",
  "Petropolis"=>"Petropolis",
  "Porto_Alegre"=>"Porto Alegre",
  "Aracaju"=>"Aracaju",
  "Maceio"=>"Maceio",
  "Palmas"=>"Palmas",
  "Vi&ccedil;osa"=>"Vi&ccedil;osa",
  "Teresina"=>"Teresina"
  );
  if($team['id']==""){
  $titutlo = "Informa&ccedil;&otilde;es gerais da nova oferta";
  }
  else{
  $titutlo = "Informa&ccedil;&otilde;es gerais da nova oferta: ".$team['id'];
  }
  
    $caracteristicas = explode(",",$team['vea_caracter']);
	$promocoes = explode(",",$team['vea_promocoes']);
	$necessidades = explode(",",$team['vea_necessidades']); 
	
?>
 