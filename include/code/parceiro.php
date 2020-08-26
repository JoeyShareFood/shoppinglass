<?php

header('Content-Type: text/html; charset=ISO-8859-1');

if($_POST["acao"] == "enviadados"){
  
	 $body = 
	"<h2> Formulário de Contato de Parceria</h2><br>
	<h3> Dados Gerais</h3>

	<p>Nome: ".$_REQUEST["nome"]."</p>
	<p>Sobrenome:	".$_REQUEST["sobrenome"]."</p>
	<p>Empresa: ".$_REQUEST["empresa"]."</p>
	<p>Email: ".$_REQUEST["email"]."</p> 

	<h3> Dados do Negócio</h3>

	<p>Categoria: ".$_REQUEST["categoria"]."</p>
	<p>Telefone: ".$_REQUEST["telefoneparceiro"]."</p> 
	<p>Site: ".$_REQUEST["site"]."</p>
	<p>Endereço: ".$_REQUEST["enderecoparceiro"]."</p> 
	<p>Estado: ".$_REQUEST["websites3parceiro"]."</p>
	<p>Cidade: ".$_REQUEST["cidade"]."</p>
	<p>Bairro: ".$_REQUEST["bairroparceiro"]."</p>
	<p>Cep: ".$_REQUEST["cepparceiro"]."</p>

	<h3> Outras Informações</h3>

	<p>Mais Informações: ".$_REQUEST["informacoes"]."</p>" ;
	 
	if($INI['mail']['mailparceria'] != ""){
		$para = $INI['mail']['mailparceria']; 
	}
	else if($INI['mail']['mail'] == "smtp"){
		$para = $INI['mail']['user'];  
	}
	else{
		$para = $INI['mail']['mailparceria'];
	}
    
	 if(enviar( $para,"Contato de Parceria",utf8_encode($body))){
		 $enviou =  true;
 	 }
 	 else{
		$enviou =  false;
	 }
}



?>