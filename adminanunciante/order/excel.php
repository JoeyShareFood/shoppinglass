<?php

require_once("../../include/configure/db.php");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: application/x-msexcel");
header("Content-Disposition: attachment;filename = \"RelatorioPedidos.xls\"");
header("Content-Description: - VipCom");

function numeroToMoeda($numero, $qtdDecimais = 2) {
	$numero = number_format($numero, $qtdDecimais);
	$numero = explode('.', $numero);
	return sprintf('%s,%s', str_replace(',', '.', $numero[0]), $numero[1]);
}

/* filter start */
$id = ($_GET['id'] != 'undefined') ? $_GET['id'] : null;

if($_GET['datapedido'] != 'undefined'){
	$datapedido = explode('/', $_GET['datapedido']);
	$datapedido = implode('-', array_reverse($datapedido));
}else{
	$datapedido = null;
}

$uemail = ($_GET['uemail'] != 'undefined') ? $_GET['uemail'] : null;
$team_id = ($_GET['team_id'] != 'undefined') ? $_GET['team_id'] : null;
$quantity = ($_GET['quantity'] != 'undefined') ? $_GET['quantity'] : null;
$origin = ($_GET['origin'] != 'undefined') ? $_GET['origin'] : null;
$state = ($_GET['state'] != 'undefined') ? $_GET['state'] : null;
$credit = ($_GET['credit'] != 'undefined') ? $_GET['credit'] : null;

$conecta = mysql_connect($value['host'],$value['user'],$value['pass']);
mysql_select_db($value['name']);
 
$consulta = array();
$consulta[] = 'SELECT o.*,o.id as numeropedido, ot.*,u.*, oe.*
FROM `order` AS o 
LEFT JOIN order_team AS ot ON ot.order_id = o.id 
INNER JOIN user AS u ON u.id = o.user_id';
  
if($uemail){
	$consulta[] = 'AND u.email is not null and u.email = "'. $uemail .'"';
} 
 
$consulta[] = ' LEFT JOIN order_enderecos AS oe ON o.id = oe.idpedido';

if($id){
	$consulta[] = 'WHERE o.id = ' . $id;
}

if($datapedido){

	if($id){
		$consulta[] = 'AND o.datapedido LIKE "' . $datapedido . '%"';
	}else{
		$consulta[] = 'WHERE o.datapedido LIKE "' . $datapedido . '%"';
	}
} 
if($team_id){
	if($id || $datapedido || $uemail){
		$consulta[] = 'AND ot.team_id = ' . $team_id;
	}else{
		$consulta[] = 'WHERE ot.team_id = ' . $team_id;
	}

}

if($quantity){
	if($id || $datapedido || $uemail || $team_id){
		$consulta[] = 'AND o.quantity = ' . $quantity;
	}else{
		$consulta[] = 'WHERE o.quantity = ' . $quantity;
	}	
}

if($origin){
	if($id || $datapedido || $uemail || $team_id || $quantity){
		$consulta[] = 'AND o.origin = ' . $origin;
	}else{
		$consulta[] = 'WHERE o.origin = ' . $origin;
	}	
}

if($state){
	if($id || $datapedido || $uemail || $team_id || $quantity || $origin){
		$consulta[] = 'AND o.state = "' . $state . '"';
	}else{
		$consulta[] = 'WHERE o.state = "' . $state . '"';
	}	
}
$consulta[] = 'ORDER BY o.id DESC';
$consulta = implode("\n", $consulta);
mysql_set_charset('utf8', $conecta);
// echo  $consulta;
$resultado = mysql_query($consulta);
$i = 0;
?>

<!--ID	ID Pedido(usar esse)	Nome	Email	Quantidade	Telefone	Logradouro	N	Complemento	Bairro	Cidade	UF	CEP	Produto (se aplicavel)	Tamanho	Lista	Data do Pedido-->
<table cellpadding="3" cellspacing="3" border="">
	<thead>
		<tr>
			<th>Data</th>
			<th>Número</th>
			<th>Status</th>
			<th>Nome</th>
			<th>Email</th>   
			<th>Valor dos Produtos</th>
			<th>Frete</th>
			<th>Vale Compras</th>
			<th>Total</th>
			<th>Telefone</th>
			<th>Endereço de entrega</th>
			<th>Numero</th>
			<th>Complemento</th>
			<th>Bairro</th>
			<th>Cidade</th>
			<th>Estado</th>
			<th>CEP</th>
			<th>Modo Envio</th>
			<th>Prazo</th>
			<th>Opção 1</th>
			<th>Opção 2</th> 
		</tr>
	</thead>
	<tbody>
		<?php while($reg = mysql_fetch_array($resultado)) : ?>
		<?php if($i % 2) { $style = 'background-color: #CCCCCC;'; } else { $style = ''; } ?>
		<?php
			switch ($reg['state']) {
				case 'pay':
					$state = 'Pago';
					break;
				
				case unpay:
					$state = 'Pendente';
					break;
			}

			$total = ($reg['valorfrete'] > 0) ? $reg['origin'] + $reg['valorfrete'] : $reg['valorfrete'];
			if(!strstr ($reg['zipcode'], "-")){
				$CEP = substr($reg['zipcode'], 0, 5) . "-" . substr($reg['zipcode'], 5, 3);
			}
			else{
				$CEP =  $reg['zipcode'];
			}
			
			 $codigovalecompras 	= $reg[codigovalecompras];
			 $valorcupomdesconto  = $reg[valecompras];
			 if(!$valorcupomdesconto){
				$valorcupomdesconto=0;
			} 
			$valortotal = $reg['origin'] + $reg['valorfrete']  - $valorcupomdesconto ;
			
		?>
		<tr> 
			<td style="text-align:left"><?=$reg['datapedido']?></td>
			<td style="text-align:left"><?=$reg['numeropedido']?></td>
			<td style="text-align:left"><?=$state?></td>
			<td style="text-align:left"><?=utf8_decode($reg['realname'])?></td>
			<td style="text-align:left"><?=utf8_decode($reg['email'])?></td>
			<td style="text-align:left">R$ <?=number_format($reg['origin'], 2, ',', '.') ?></td>
			<td style="text-align:left">R$ <?=number_format($reg['valorfrete'], 2, ',', '.') ?></td>
			<td style="text-align:left">R$ <?=number_format($reg[valecompras], 2, ',', '.') ?></td>
			<td style="text-align:left">R$ <?=number_format($valortotal, 2, ',', '.') ?></td>
			<td style="text-align:left"><?=utf8_decode($reg['mobile'])?></td>
			<td style="text-align:left"><?=utf8_decode($reg['entrega_endereco'])?></td>
			<td style="text-align:left"><?=$reg['entrega_numero']?></td>
			<td style="text-align:left"><?=$reg['entrega_complemento']?></td>
			<td style="text-align:left"><?=utf8_decode($reg['entrega_bairro'])?></td>
			<td style="text-align:left"><?=utf8_decode($reg['entrega_cidade'])?></td>
			<td style="text-align:left"><?=utf8_decode($reg['entrega_estado'])?></td>
			<td style="text-align:left"><?=utf8_decode($reg['entrega_cep'])?></td>
			<td style="text-align:left"><?=utf8_decode($reg['modo_envio'])?></td>
			<td style="text-align:left"><?=utf8_decode($reg['prazofrete'])?></td>
			<td style="text-align:left"><?=utf8_decode($reg['condbuy'])?></td>
			<td style="text-align:left"><?=utf8_decode($reg['condbuy2'])?></td> 
		</tr>
		<?php $i++; endwhile; ?>
	</tbody>
</table>