<?php

include ('../app.php');

/* É verificado o que o usuário digitou no campo de busca. Assim é feito a busca. */
if(isset($_POST["query"]) and !(empty($_POST["query"])))
{
	/* O único tipo é "team". */
	$query = strip_tags($_POST["query"]);
	$type = strip_tags($_POST["type"]);
	
	if($type == "team")
	{
		/* É buscado as ofertas que estão ativas com o limite de busca de 20. */
		$team = mysql_query("select id, title, image from team where title like '%" . $query . "%'  and moderacao = 'Y' and posicionamento != 5 limit 10");
		$rows = mysql_num_rows($team);
		
		/* É feito o retorno de acordo com a busca na base de dados. */
		if($rows >= 1)
		{
			while($row = mysql_fetch_assoc($team)) 
			{
				$url = urlamigavel(tratanome($row['title']));
				echo "<li><a href='" . $ROOTPATH . "/produto/" . $row['id'] . "/"  . $url . "'><img align='left' src='" . $ROOTPATH . "/media/" . $row['image'] . "'> <p>" . $row['title'] . "</p></a></li>";
			}
		}
		else 
		{
			echo "<li class='ResultNone'><p>Não encontramos nenhum produto para a sua busca!</p></li>";
		}
	}
	else
	{
		/* Caso o valor do $type seja invalido. */
		return false;
	}
}
else 
{
	return false;
}

?>