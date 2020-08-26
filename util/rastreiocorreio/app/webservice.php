<?php header('Content-Type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>
<html>

	<head>
		<title>Rastreamento nos correios</title>
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>

	<body>
		<?php
			$code = @$_REQUEST['code'];
		?>
		<h1>Rastreamento<?php echo $code ? ': ' . $code : ''?> - Pedido <?=$_REQUEST['id']?></h1>
 
		<?php
		if ($code):
		$c = json_decode(file_get_contents('http://tk21-pc:90/vipcart/util/rastreiocorreio/webservice/index.php?q=' . $code));
		if (!$c->erro):
		?>

		<h2 style="color:#0082DB;">Status: <?php echo $c->status ?></h2>
		
		<table>
			<tr>
				<td>Data</td>
				<td>Local</td>
				<td>Ação</td>
				<td>Detalhes</td>
			</tr>
			<?php foreach ($c->track as $l): ?>
				<tr>
					<td><?php echo $l->data ?></td>
					<td><?php echo $l->local ?></td>
					<td><?php echo $l->acao ?></td>
					<td><?php echo $l->detalhes ?></td>
				</tr>
			<?php endforeach; ?>
		</table>
		<?php else: ?>
		<?php echo $c->erro_msg ?>
		<?php endif; endif;?>
	</body>
</html>
