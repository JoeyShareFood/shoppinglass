<?php

require_once("../../include/configure/db.php");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: application/x-msexcel; charset='utf-8'");
header("Content-Disposition: attachment;filename = \"RelatorioOfertas.xls\"");
header("Content-Description:  VipCom");

function numeroToMoeda($numero, $qtdDecimais = 2) {
	$numero = number_format($numero, $qtdDecimais);
	$numero = explode('.', $numero);
	return sprintf('%s,%s', str_replace(',', '.', $numero[0]), $numero[1]);
}

/* filter start */
$team_type = ($_GET['team_type'] != 'undefined') ? $_GET['team_type'] : null;
$team_title = ($_GET['team_title'] != 'undefined') ? $_GET['team_title'] : null;
$category_id = ($_GET['category_id'] != 'undefined') ? $_GET['category_id'] : null;
$partner_id = ($_GET['partner_id'] != 'undefined') ? $_GET['partner_id'] : null;

$conecta = mysql_connect($value['host'],$value['user'],$value['pass']);
mysql_select_db($value['name']);

#group_id (categorias), preco_comissao,market_price,per_number,min_number,max_number,now_number
#title, name, parceiro, begin_time, end_time, team_price
  
$consulta = array();
$consulta[] = 'SELECT t.id, t.title, t.begin_time, t.codreferencia, t.end_time,  t.market_price, t.per_number, 
t.min_number, t.max_number, t.now_number, t.team_price, c.name AS categoria, p.title AS parceiro
FROM team AS t 
LEFT JOIN category AS c ON c.id = t.group_id AND c.zone = "group"
LEFT JOIN partner AS p ON p.id = t.partner_id';

if($team_title){
	$consulta[] = 'WHERE t.title LIKE "%' . $team_title . '%"';
}
 

if($category_id){
	if($team_title){
		$consulta[] = 'AND t.group_id = ' . $category_id;
	}else{
		$consulta[] = 'WHERE t.group_id = ' . $category_id;
	}

}

if($partner_id){
	if($team_title  || $category_id){
		$consulta[] = 'AND t.partner_id = ' . $partner_id;
	}else{
		$consulta[] = 'WHERE t.partner_id = ' . $partner_id;
	}	
}

$consulta[] = 'ORDER BY t.id DESC';

$consulta = implode("\n", $consulta);

mysql_set_charset('utf8', $conecta);

$resultado = mysql_query($consulta);

$i = 0;

?>
<table cellpadding="3" cellspacing="3" border="0">
	<thead>
		<tr>
			<th>Cod</th> 
			<th>Produto</th> 
			<th>Cod. Referencia</th> 
			<!-- <th>Parceiro</th> -->
			<th>Vendidos</th> 
			<th>Estoque</th> 
			<th>Preco Antigo</th>
			<th>Preco</th>
		</tr>
	</thead>
	<tbody>
		<?php while($reg = mysql_fetch_array($resultado)) : ?>
		<?php if($i % 2) { $style = 'background-color: #CCCCCC;'; } else { $style = ''; } ?>
		<tr> 
			<td style="whidth:50px; text-align:left"><?=utf8_decode($reg['id'])?></td>
			<td style="whidth:550px; text-align:left"><?=utf8_decode($reg['title'])?></td>
			<td style="text-align:left"><?=utf8_decode($reg['codreferencia'])?></td> 
			<!-- <td style="text-align:left"><?=utf8_decode($reg['parceiro'])?></td> -->
			<td style="text-align:left"><?=(INT)$reg['now_number']?></td>
			<td style="text-align:left"><?=(INT)$reg['max_number']?></td>
			<td style="text-align:left"> R$ <?=number_format($reg[market_price], 2, ',', '.') ?> </td>
			<td style="text-align:left">R$ <?=number_format($reg[team_price], 2, ',', '.') ?>  </td>
		</tr>
		<?php $i++; endwhile; ?>
	</tbody>
</table>