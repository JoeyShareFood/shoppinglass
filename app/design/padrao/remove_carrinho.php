<?php
$post = $_POST;
if (isset($post['id']))
	$itens = json_decode($_SESSION['carrinhoitens'], true);
	foreach($itens as $chave => $item) {
		if ($item['id'] == $post['id']) {
			unset($_SESSION['qty_'.$item['id']]);
			unset($itens[$chave]);
		}
			
	}
	$_SESSION['carrinhoitens'] = json_encode($itens);
?>