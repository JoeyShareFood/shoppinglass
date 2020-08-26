<?php 
	require_once(dirname(dirname(__FILE__)). '/app.php'); 
  
    $idpedido 	 	= $_REQUEST['id'];  
    $name_user 	 	= $_REQUEST['realname'];  
	
	$nomesite = htmlentities($INI['system']['sitename'], ENT_COMPAT, 'UTF-8'); 
	
	$order 	 = Table::Fetch('order', $idpedido);
	$user 	 = Table::Fetch('user', $order['user_id']);
	$partner = Table::Fetch('user', $order['partner_id']);

	$items = mysql_query("SELECT * FROM order_team WHERE order_id = " . $idpedido); 
	
	$codigovalecompras 	= $order['codigovalecompras'];
	$valorcupomdesconto  = $order['valecompras'];
	
	if(!$valorcupomdesconto){
		$valorcupomdesconto=0;
	}
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
				<?php echo utf8_decode(strtoupper($user['realname'])); ?>,
			</p>
			<p style="text-align:center;font-weight:bold;font-size:16px;">
				OBA, SUA COMPRA FOI CONFIRMADA!
			</p>			
			<p style="text-align:center; line-height:18px; font-size:12px;">
				Obrigado por comprar no <?php echo $INI['system']['sitename']; ?>, estamos felizes por ter feito economia e ter dado
				um novo lar a um produto. O vendedor vai pular de alegria e o planeta terra tamb&eacute;m
			</p>			
			<p style="text-align:center; line-height:32px; font-size:12px;">
				<ul style="list-style-type: none; padding:0px;">
					<?php 
						while ($item = mysql_fetch_array($items, MYSQL_ASSOC)) {
							
							$team = mysql_fetch_object(mysql_query("SELECT * FROM team WHERE id = " . $item['team_id']));
					?>
					<li style="text-align:center; font-weight:bold;">
						<p style="text-align:center; line-height:18px; color:#F77275; font-size:16px;">
						<?php
							echo "<a style='color:#F77275;' href=" . $ROOTPATH . "/?idoferta=" . $team->id . ">" . ucfirst(utf8_decode($team->title)) . "</a><br />";
							echo "N&uacute;mero do seu pedido: #" . $idpedido;
						?>
						</p>
						<p style="text-align:center; line-height:18px; color:#7F7F7F; font-size:16px;font-weight:normal;">
						<?php
							echo "Data: " . date("d/m/Y", strtotime($order['datapedido']));
							echo "<br />";							
							echo "Valor: R$ " . number_format($item['team_price'],2,",",".");
							echo "<br />";
							
							if($order['valorfrete'] != 0) {								
								echo "Frete: " . str2num($order['valorfrete']);
								echo "<br />";
							}
							else {
								echo "Frete: " . number_format("0,00",2,",",".");
								echo "<br />";							
							}
							
							if($order['valorfrete'] != 0) {	
								echo "Total pago: <b>" . str2num($order['origin']) + str2num($order['valorfrete']) . "</b>";
							}
							else {
								echo "Total pago: <b>R$ " . number_format($order['origin'],2,",",".") . "</b>";
							}
						?>	
						</p>
						<p style="text-align:center; color:#7F7F7F; font-size:16px;font-weight:bold; text-transform:uppercase;">
							Dados do vendedor:
						</p>						
						<p style="text-align:center; line-height:16px; color:#7F7F7F; font-size:12px;font-weight:normal;margin-top:-15px;">
							<?php
								echo "<b>Nome:</b> " . utf8_decode($partner['realname']);
								echo "<br />";
								echo "<b>E-mail:</b> <span style='color:#F77275;text-decoration:underline;'>" . utf8_decode($partner['email']) . "</span>";
								echo "<br />";
								echo utf8_decode($partner['cidadeusuario']) . " - " . utf8_decode($partner['estado']) . " " . $partner['mobile'];
								echo "<br />";
							?>
						</p>
					</li>
					<?php } ?>
				</ul>
			</p>			
			<p style="text-align:center; line-height:18px; color:#F77275; font-size:12px;">
				Agora preste aten&ccedil;&atilde;o nas orienta&ccedil;&otilde;es abaixo e siga as instru&ccedil;&otilde;es:
			</p>		
			<p style="text-align:center; line-height:18px; font-size:12px;">
				a) Se voc&ecirc; optou em receber o produto <b>"via correio"</b>, vamos te enviar o
				c&oacute;digo de rastreio assim que o vendedor fazer a postagem beleza?
				Voc&ecirc; tamb&eacute;m pode acompanhar o status do seu pedido em <b>"minhas
				compras"</b>.
			</p>		
			<p style="text-align:center; line-height:18px; font-size:12px;">
				b) Se voc&ecirc; optou pela <b>"retirada no local"</b>, corre e combine direitinho com
				o vendedor o dia, hor&aacute;rio e lugar para retirar o produto :)
			</p>				
			<p style="text-align:center; line-height:18px; font-size:12px;">
				<span style="color:#F77275;font-weight:bold;">Importante:</span> N&atilde;o esque&ccedil;a de avisar a gente assim que receber o produto e qualificar a
				compra t&aacute;! A gente s&oacute; libera o pagamento do vendedor depois de receber a
				confirma&ccedil;&atilde;o de recebimento.
			</p>				
			<p style="text-align:center; line-height:18px; font-size:12px;">
				<b>Vamos combinar uma coisa, o papo &eacute; reto:</b> <br />
				Se voc&ecirc; n&atilde;o tiver sinal de vida sobre a entrega do produto em at&eacute; 5 dias &uacute;teis, d&aacute; um
				salve <a href="<?php echo $ROOTPATH; ?>/contato" target="_blank" style="color:#F77275;">aqui</a> pra gente.
			</p>						
			<p style="text-align:center; line-height:18px; font-size:12px;">
				Esperamos voc&ecirc; em breve para fazer novas compras!
			</p>						
			<p style="text-align:center; line-height:18px; font-size:12px;">
				Abra&ccedil;os,
			</p>		
			<p style="text-align:center;line-height:26px;margin-top:25px;font-weight: bold;text-transform: uppercase; font-size:12px;">
				Equipe <?php echo $INI['system']['sitename']; ?>
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