 <style>
	.coupons-table td, .coupons-table th {
		padding: 6px;
	}
</style>

<?php

$id = (int) strip_tags(trim($_REQUEST['id']));

require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
$questions = Table::Fetch('questions', $_REQUEST['id']);
$cliente = Table::Fetch('user', $questions['id_cliente']);
$vendedor = Table::Fetch('user', $questions['id_vendedor']);
$team = Table::Fetch('team', $questions['id_produto']);

?>

<div id="order-pay-dialog" class="order-pay-dialog-c" style="width:580px;">
	<h3>Detalhes da pergunta</h3>
	<div style="overflow-x:hidden;padding:10px;">
		<table width="96%" class="coupons-table">
		<tr><td><b>Título:</b></td><td><?=$questions['titulo']?></td></tr>
		<tr><td><b>Dúvida:</b></td><td><?=$questions['duvida']?></td></tr>
		<tr><td><b>Cliente:</b></td><td><?=$cliente['login']?></td></tr>
		<tr><td><b>Vendedor:</b></td><td><?=empty($vendedor['login']) ? $vendedor['username'] : $vendedor['login']?></td></tr>
		<tr><td><b>Produto:</b></td><td><?=$team['title']?></td></tr>
	  </table>
	</div>
</div>