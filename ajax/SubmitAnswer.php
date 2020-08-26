<?php

include ('../app.php');
include('../include/function/commom.php');
$nomesite = $INI['system']['sitename'];
global $INI;

/* � verificado se todas as informa��es foram criadas corretamente. */
if(isset($_POST["acao"]) and isset($_POST["answer"]) and isset($_POST["id_answer"])) {
	
	/* � verificado a a��o recebida via POST. */
	if($_POST["acao"] == "submit_answer") {
		
		$answer = strip_tags($_POST["answer"]);
		$id_question = strip_tags($_POST["id_answer"]);
		
		/* � buscado algumas informa��es acerca da d�vida, para preenchimento
		   da tabela answer.
	   */
	   $sql = "select * from questions where id = '" . $id_question . "'";
	   $rs = mysql_query($sql);
	   $num = mysql_num_rows($rs);
	   
	   
	   /* Caso encontre alguma informa��o, os valores s�o extraidos, e � montado
		  a query de cadastro da tabela answer.	
	  */
	   if($num >= 1) {
			$data = date("Y-m-d H:i:s");
			$dados = mysql_fetch_assoc($rs);
			$user = Table::Fetch('user', $dados['id_cliente']);
			
			/* Query de inser��o na tabela answer. */
			$sql = "insert into answer(id_questions, id_cliente, resposta, data) values('" . $id_question . "', '" . $dados['id_cliente'] . "', '" . $answer . "', '" . $data . "')";
			$rs = mysql_query($sql);
			$retorno = mysql_affected_rows();
			$idAnswer = mysql_insert_id();
			
			if($retorno <= 0) {
				// Tratamento de erro!
			}			
			else {	

				/* Envia mensagem direto para usu�rio. */
				if($INI['option']['moderacao_msg'] == "N"){
				
					$sql_a = "update answer set status = 1 where id = " . $idAnswer;
					$rs_a = mysql_query($sql_a);
					
					/* Caso a resposta tenha sido inserido no banco de dados, o numero de pontos � atualizado. */
					$pts = 1;							
					UpdatePoints($pts, $dados['id_vendedor']);

					/* Ap�s a atualiza��o de pontos do usu�rio, � enviado um email ao cliente comunicando
					   sobre a resposta enviada pelo vendedor.
					*/
					$parametros = array('id' => $id_question, 'name' => $user['realname']);
					$request_params = array(
						'http' => array(
							'method'  => 'POST',
							'header'  => implode("\r\n", array(
								'Content-Type: application/x-www-form-urlencoded',
								'Content-Length: ' . strlen(http_build_query($parametros)),
							)),
							'content' => http_build_query($parametros),
						)
					);

					$request = stream_context_create($request_params);
					$body = file_get_contents($INI["system"]["wwwprefix"] . "/templates/answer.php", false, $request);
					Util::postemailCliente($body, "Responderam sua mensagem", $user['email']);
				}
				else {
				
					/* Caso a resposta tenha sido inserido no banco de dados, o numero de pontos � atualizado. */
					$pts = 1;							
					UpdatePoints($pts, $dados['id_vendedor']);

					/* Ap�s a atualiza��o de pontos do usu�rio, � enviado um email ao cliente comunicando
					   sobre a resposta enviada pelo vendedor.
					*/
					$parametros = array('id' => $id_question);
					$request_params = array(
						'http' => array(
							'method'  => 'POST',
							'header'  => implode("\r\n", array(
								'Content-Type: application/x-www-form-urlencoded',
								'Content-Length: ' . strlen(http_build_query($parametros)),
							)),
							'content' => http_build_query($parametros),
						)
					);

					$request = stream_context_create($request_params);
					$body = file_get_contents($INI["system"]["wwwprefix"] . "/templates/answer_admin.php", false, $request);
					
					$EmailAdmin = $INI["mail"]["from"];
					
					if(!enviar($EmailAdmin,utf8_decode($INI["system"]["sitename"]). " - ".utf8_encode("Nova resposta"), $body)){
						 echo "O email nao foi enviado para o administrador.";
						 Util::log($id. "avalia_produto - O email nao foi enviado para o administrador (".$EmailAdmin.")");  
					}
					else{
						Util::log($id. "avalia_produto - O email enviado com sucesso para (".$EmailAdmin.")");  
					}				
				}
			}
	   } 
	   else {
			// Tratamento de erro!
	   }
	} 
	else {
		return false;
	}
} 
else {
	/* Caso exista alguma falha no envio via formul�rio. */
	return false;
}

?>