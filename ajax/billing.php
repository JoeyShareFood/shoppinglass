<?php

include ('../app.php');
include('../include/function/commom.php');
global $INI;
$nomesite = $INI['system']['sitename'];

/* É verificado se todas as informações foram criadas corretamente. */
if(isset($_POST["descricao"]) and isset($_POST["iduser"]) and isset($_POST["observacoes"]) and isset($_POST["pagamento"]) and isset($_POST["status"]) and isset($_POST["valor"])) {

	/* Caso seja diferente de 0, entende se que houve algum erro ao receber as informações. */
	$flag = 0;
	
	/* Data em que a fatura foi atualizada ou gerada. */
	$data_geracao = date("Y-m-d H:i:s");
				
	if(!(empty($_POST["descricao"]))) {		
		$descricao = strip_tags($_POST["descricao"]);
	}
	else {
		$flag = 1;
	}

	if(!(empty($_POST["observacoes"]))) {
		$observacoes = strip_tags($_POST["observacoes"]);
	}
	
	if(!(empty($_POST["pagamento"]))) {
		$pagamento = strip_tags($_POST["pagamento"]);
	}
	else {
		$flag = 1;
	}
	
	if(!(empty($_POST["status"]))) {
		$status = strip_tags($_POST["status"]);
		
		/* Caso a fatura seja criada ou alterada com o status pago, a data de pagamento é a mesma de geração ou edição. */
		if($status == "pay") {
			$data_pagamento = date("Y-m-d H:i:s");
		}
		else {
			unset($data_pagamento);
		}
	}
	else {
		$flag = 1;
	}
	
	if(!(empty($_POST["valor"]))) {
		$valor = strip_tags($_POST["valor"]);
		$valor = str_replace("R$", "", $valor);
		$valor_comissao = str_replace(",", ".", str_replace(".", "", $valor));
	}
	else {
		$flag = 1;
	}
	
	if(!(empty($_POST["iduser"]))) {
		$id_user = (int) strip_tags($_POST["iduser"]);
	}
	else {
		$flag = 1;
	}
	
	if(!(empty($_POST["enviarfatura"]))) {
		$SendBilli = (int) strip_tags($_POST["enviarfatura"]);
	}
		
	/* Neste ponto é efetuado a geração e envio da fatura. */
	if(isset($_POST["action"]) and $_POST["action"] == "criar") {
		
		if($flag == 0) {
			
			/* Caso esteja todo correto, é feito a inserção no banco de dados e é enviado o email notificando
			   ao usuário sobre a geração de fatura.		
			*/
		
			$sql = "insert into faturas(id_user, forma_pagamento, valor, descricao, data_geracao, data_pagamento, status, observacao) values('" . $id_user . "', '" . $pagamento . "', '" .$valor_comissao . "', '" . $descricao . "', '" . $data_geracao . "', '" . $data_pagamento . "', '" . $status . "', '" . $observacoes . "')";
			$rs = mysql_query($sql);
			$row = mysql_affected_rows();
			
			/* Caso não tenha acontecido nenhum erro na inserção da fatura gerada, o email é enviado ao usuário. */
			if($row >= 1) {
				/* Envia o email ao usuário. */
				if($SendBilli == 1) {
					
					/* Informações do usuário são buscadas para efetuar o envio do email. */
					$user = Table::Fetch('user', $id_user);
					$id_billi = mysql_insert_id();
					
					$parametros = array('id_billi' => $id_billi);
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
					
					$request  = stream_context_create($request_params);
					$mensagem = file_get_contents($INI["system"]["wwwprefix"]."/templates/envio_fatura.php", false, $request);
					
					/* Caso o email tenha sido enviado corretamente sem erros. */
					if(enviar($user['email'], $nomesite . "- Fatura", $mensagem)) {
						echo "Fatura gerada e enviada com sucesso!";
					}
					else {
						echo "Fatura gerada, entretanto ocorreu um erro ao enviar email ao usuário.";
					}
				}
				else {
					echo "Fatura salva com sucesso!";
				}
			}
			else {
				echo "Ocorreu algum erro ao salvar as informações. Tente novamente mais tarde!";
				return;			
			}
		}
		else {
			echo "Ocorreu algum erro inesperado. Tente novamente mais tarde!";
			return;
		}
	}
	else if(isset($_POST["action"]) and $_POST["action"] == "editar") {
	
		if(isset($_POST["idfatura"]) and !(empty($_POST["idfatura"]))) {
			$idfatura = (int) strip_tags($_POST["idfatura"]);
		}
		else {
			$flag = 1;
		}
		
		if($flag == 0) {
	
			/* Neste ponto é efetuado a edição de uma fatura que já foi gerada. */
			$sql = "update faturas set id_user = '" . $id_user . "', forma_pagamento = '" . $pagamento . "', valor = '" . $valor_comissao . "', descricao = '" . $descricao . "', data_geracao = '" . $data_geracao . "', data_pagamento = '" . $data_pagamento . "', status = '" . $status . "', observacao = '" . $observacoes . "' where id = " . $idfatura;
			$rs = mysql_query($sql);
			$row = mysql_affected_rows();
			
			/* Caso não tenha acontecido nenhum erro na atualização da fatura, o email é enviado ao usuário. */
			if($row >= 1) {
				/* Envia o email ao usuário. */
				if($SendBilli == 1) {
					
					/* Informações do usuário são buscadas para efetuar o envio do email. */
					$user = Table::Fetch('user', $id_user);
					$id_billi = mysql_insert_id();
					
					$parametros = array('id_billi' => $idfatura);
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
					
					$request  = stream_context_create($request_params);
					$mensagem = file_get_contents($INI["system"]["wwwprefix"]."/templates/envio_fatura.php", false, $request);
					
					/* Caso o email tenha sido enviado corretamente sem erros. */
					if(enviar($user['email'], $nomesite . "- Novo status da fatura", $mensagem)) {
						echo "Fatura atualizada e enviada com sucesso!";
					}
					else {
						echo "Fatura atualizada, entretanto ocorreu um erro ao enviar email ao usuário.";
					}
				}
				else {
					echo "Fatura atualizada com sucesso!";
				}
			}
			else {
				echo "Ocorreu algum erro ao atualizar as informações. Tente novamente mais tarde!";
				return;			
			}
		}
		else {
			echo "Ocorreu algum erro inesperado. Tente novamente mais tarde!";
			return;
		}
	}
}	
else {
	/* Caso exista alguma falha no envio via formulário. */
	echo "Ocorreu algum erro inesperado. Tente novamente mais tarde!";
	return;
}

?>