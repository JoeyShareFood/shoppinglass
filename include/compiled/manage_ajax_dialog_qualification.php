 <style>
	.coupons-table td, .coupons-table th {
		padding: 6px;
	}
</style>

<?php

$id = (int) strip_tags(trim($_REQUEST['id']));

require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
$qualification = Table::Fetch('qualification', $_REQUEST['id']);
$qualificado = Table::Fetch('user', $qualification['id_qualificado']);
$qualificante = Table::Fetch('user', $qualification['id_qualificante']);

if($qualification['concretion'] == 1) {
	$result = "Qualificação positiva";
} else {
	$result = "Qualificação negativa";
}

?>

<div id="order-pay-dialog" class="order-pay-dialog-c" style="width:580px;">
	<h3>Detalhes da qualificação</h3>
	<div style="overflow-x:hidden;padding:10px;">
		<table width="96%" class="coupons-table">
		<tr><td width="80"><b>Qualificação:</b></td><td><?=$result?></td></tr>
		<tr><td width="80"><b>Qualificante:</b></td><td><?=$qualificante['login']?></td></tr>
		<tr><td><b>Qualificado:</b></td><td><?=$qualificado['login']?></td></tr>
		<tr><td><b>Título da qualificação:</b></td><td><?=$qualification['titulo']?></td></tr>
		<tr><td><b>Nota:</b></td><td><?=$qualification['nota']?></td></tr>
		<tr><td><b>Texto:</b></td><td><?=$qualification['text']?></td></tr>
	  </table>
	</div>
</div>