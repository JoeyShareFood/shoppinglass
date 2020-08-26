<?php

require_once(dirname(dirname(__FILE__)) . '/app.php');

if(isset($_POST["login"]) and isset($_POST["acao"])) {
	
	if($_POST["acao"] ==  "verifica_login") {
			
		/* Caso o usuário tenha informado um login, a query procura pelo banco de dados para
	   	verificar se já existe algum login similar.
		*/
		$login = strip_tags($_POST["login"]);

		$sql = "select login from user where login = '" . $login . "'";
		$rs = mysql_query($sql);
		$result = mysql_num_rows($rs);
	
		echo $result;
	}
}
?>