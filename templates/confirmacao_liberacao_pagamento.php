<?php 	
	require_once(dirname(dirname(__FILE__)). '/app.php');

	$nome 	= urldecode($_REQUEST['realname']);	
	$idpedido = $_REQUEST["id"];	
	
	$order = Table::Fetch('order', $idpedido);	
	$comprador = Table::Fetch('user', $order['user_id']);
	
	$sqlO = "SELECT * FROM `order_team` WHERE order_id = " . $idpedido;
	$orderS = mysql_query($sqlO);
	
	$nomesite = $INI['system']['sitename']; 
?>
<html>	
	<head>		
		<meta http-equiv="Content-Language" content="pt-BR">	
	</head>	
	<body style="width:580px;margin:0 auto;font-family:Helvetica;">		
		<div class="header">	
			<img src="<?php echo $PATHSKIN; ?>/images/topo_email.jpg" style="max-width:580px;">	
		</div>	
		<div class="content" style="color:#7F7F7F;">	
			<p style="text-align:center;font-size:18px;">
				HELLOO	
			</p>		
			<p style="text-align:center;text-transform:uppercase;font-size:18px;">
				 <?php echo utf8_decode(strtoupper($nome)); ?>,	
			</p>		
			<p style="text-align:center; line-height:26px; font-size:16px;font-weight:bold;">		
				AEEE, VENDEMOS SEU PRODUTO!		
			</p>		
			<p style="text-align:center; line-height:26px; font-size:12px;">	
				vamo pul&aacute;, vamo pul&aacute;, vamo pul&aacute;, vamo pul&aacute;		
			</p>		
			<p>	
				<ul style="list-style-type:none;">	
					<?php 			
						while($item = mysql_fetch_assoc($orderS)) {	
						
							$team = mysql_fetch_object(mysql_query("SELECT * FROM team WHERE id = " . $item['team_id']));	
					?>		
					<li>				
						<p style="line-height:16px; font-size:12px;">		
							<p style="text-align:center; text-transform:capitalize;color:#F77275; font-weight:bold; ">
								<?php echo utf8_decode($team->title); ?>
								<br />								
								C&oacute;digo do produto: #<?php echo $team->id; ?>
							</p>	
						</p>		
					</li>		
					<?php			
					}				
					?>				
				</ul>		
			</p>		
			<p style="text-align:center;font-weight:bold; font-size:12px; text-transform: uppercase;">		
				Dados do comprador:	
			</p>			
			<p style="text-align:center; line-height:16px; font-size:12px;">	
				<b>
					Nome:
				</b> 
				<?php echo $comprador['realname']; ?> <br />
				<b>
					E-mail:
				</b> 
				<?php echo $comprador['email']; ?> <br />	
				<b>
					Telefone:
				</b>
				<?php echo $comprador['mobile']; ?> <br />					
				<?php echo $comprador['cidadeusuario'] . " - " . $comprador['estado']; ?> <br />		
			</p>				
			<?php		
				if($order['modo_envio'] == "PAC" || $order['modo_envio'] == "Sedex") {	
			?>		
			<p style="text-align:center; line-height:26px; font-size:12px;">	
				&Eacute; hora da arruma&ccedil;&atilde;o...<br />	
				...deixe o produto limpinho e cheiroso e embale com capricho, se quiser ser ainda mais gentil, que tal escrever um bilhetinho bem simp&aacute;tico e mandar junto? Vai ser sucesso!			
				<br />
				J&aacute; fez tudo isso ai e t&aacute; tudo no esquema? <br />
				Legal, dentro de instantes voc&ecirc; receber&aacute; a etiqueta de postagem para imprimir e levar at&eacute; uma ag&ecirc;ncia do correio mais pr&oacute;xima??			
			</p>	
			<?php } else if($order['modo_envio'] == "gratis") { ?>	
			<p style="text-align:center; line-height:26px; font-size:12px;">
				&Eacute; hora da arruma&ccedil;&atilde;o...<br />	
				...deixe o produto limpinho e cheiroso e embale com capricho, se quiser ser ainda mais gentil, que tal escrever um bilhetinho bem simp&aacute;tico e mandar junto? Vai ser sucesso!			
				<br />
				J&aacute; fez tudo isso ai e t&aacute; tudo no esquema? <br />
				Ent&atilde;o corre at&eacute; uma ag&ecirc;ncia do correio mais pr&oacute;xima e envie o produto. Lembre-se que voc&ecirc; deve fazer o pagamento no momento da postagem e acessar sua conta
				<a style="color:#A8D7D1;text-decoration:none;" href="<?php echo $ROOTPATH; ?>/adminanunciante/order/index.php">
					aqui
				</a>
				para informar o c&oacute;digo de rastreio, para que o comprador saiba que o produto foi enviado.
				<br />	
			</p>	
			<p style="text-align:center; line-height:26px;font-size:12px; color:#F77275; ">		
				A gente s&oacute; libera o pagamento quando o comprador confirmar o recebimento do produto;)	
			</p>	
			<?php } else { ?>
			<p style="text-align:center; line-height:18px;font-size:12px;">	
				É hora da arrumação...
				<br />
				<br />
				- Combine direitinho com o comprador a data, horario e o local de entrega.
				<br />
				<br />
				- Deixe o produto limpinho e cheiroso e embale com capricho, se quiser ser ainda mais gentil, que tal escrever um bilhetinho bem simpático e entregar junto? Vai ser sucesso!
				<br />
				<br />
				<br />
				- Peça ao comprador no momento da entrega pra confirmar o recebimento do produto no site e qualificar a venda.
			</p>
			<p style="text-align:center; line-height:26px;font-size:12px; color:#F77275; ">		
				A gente s&oacute; libera o pagamento quando o comprador confirmar o recebimento do produto;)	
			</p>	
			<?php } ?>
			<p style="text-align:center; line-height:26px; font-size:12px;">		
				E &eacute; claro, se precisar de ajuda, d&aacute; um salve pra gente 
				<a style="color:#A8D7D1;text-decoration:none;" href="<?php echo $ROOTPATH; ?>/contato">
					aqui
				</a>.
			</p>	
			<p style="text-align:center; line-height:32px;margin-top:25px;font-weight:bold; font-size:12px;">
				Equipe <?php echo $nomesite; ?>		
			</p>	
			<ul style="text-align: center;padding: 0px;">
				<li style="list-style-type: none;display: inline;">
					<a href="<?php echo $INI['other']['facebook']; ?>" target="_blank" style="text-decoration: none;">
						<img src="<?php echo $PATHSKIN; ?>/images/facebook_email.png" style="max-width:48px;margin-right:10px;">
					</a>
				</li>					
				<li style="list-style-type: none;display: inline;">
					<a href="<?php echo $INI['other']['orkut']; ?>" target="_blank" style="text-decoration: none;">
						<img src="<?php echo $PATHSKIN; ?>/images/instagram_email.png" style="max-width:48px;">
					</a>
				</li>
			</ul>
		</div>	
		<div class="footer">
			<img src="<?php echo $PATHSKIN; ?>/images/rodape_email.jpg" style="max-width:580px;">
			<div class="content">
				<p style="color:#7F7F7F;text-align:center;font-size:9px;line-height: 2px;">
					Copyright <?php echo date("Y"); ?> <?php echo $nomesite; ?>. Todos os direitos reservados
				</p>
				<p style="color:#7F7F7F;text-align:center;font-size:9px;line-height: 2px;">	
					Voc&ecirc; recebeu este e-mail porque se cadastrou no 
					<b>
						<a href="<?php echo $INI['system']['wwwprefix']; ?>" style="color:#7F7F7F;">
							<?php echo $INI['system']['wwwprefix']; ?>
						</a>
					</b>
				</p>											
				<p style="color:#7F7F7F;text-align:center;font-size:9px;line-height: 2px;">
					<a href="<?php echo $INI['system']['wwwprefix']; ?>/contato" style="color:#7F7F7F;text-decoration:underline;">	
						N&atilde;o quero mais receber este e-mail.		
					</a>	
				</p>
			</div>
		</div>	
	</body>
</html>