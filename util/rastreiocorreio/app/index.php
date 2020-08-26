<?php header('Content-Type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>
<html>

	<head> 
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>

	<body>
		<?php
			$code = @$_REQUEST['code'];
		?>   
		<?php
		if ($code):
		include_once '../correio.php';
		$c = new Correio($code);
		if (!$c->erro):
		?>

		<h2>Código: <?=$code?> Status: <?php echo $c->status ?></h2>
		
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
