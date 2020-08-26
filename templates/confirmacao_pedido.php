<?php 
	require_once(dirname(dirname(__FILE__)). '/app.php');  
	
	$idpedido 	 	= $_REQUEST['id'];  
	$name_user 	 	= $_REQUEST['realname'];  
	
	$nomesite = htmlentities($INI['system']['sitename'],ENT_COMPAT,'UTF-8'); 

	$order 	= Table::Fetch('order', $idpedido);
	$user 		= Table::Fetch('user', $order[user_id]);
	$vendedor  = Table::Fetch('user', $order['partner_id']); 
	
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
				<?php echo utf8_decode(strtoupper($name_user)); ?>,
			</p>
			<p style="text-align:center;font-weight:bold;font-size:16px;">
				O PRODUTO &Eacute; QUASE SEU
			</p>			
			<p style="text-align:center; line-height:26px; font-size:12px;">
				<ul style="list-style-type:none;">
					<?php 
						while ($item = mysql_fetch_array($items, MYSQL_ASSOC)) {	
						
							$team = mysql_fetch_object(mysql_query("SELECT * FROM team WHERE id = " . $item['team_id']));
					?>
					<li>
						<p style="text-align:center; line-height:26px; color:#F77275; font-weight:bold; text-transform:capitalize; font-size:12px;">
							<a href="<?php echo $ROOTPATH; ?>/?idoferta=<?php echo $team->id; ?>" style="color:#F77275;">
								<?php echo $team->title; ?>
							</a>
							<br />
							<span style="text-align:center; line-height:26px; color:#F77275; font-weight:bold; font-size:12px;">
								C&oacute;digo do produto: #<?php echo $team->id; ?>
							</span>
						</p>
					</li>
					<?php
						}
					?>
				</ul>
			</p>			
			<p style="text-align:center; line-height:26px; font-size:12px;">
				Assim que o pagamento for confirmado, vamos avisar o vendedor para postar o produto beleza?
			</p>			
			<p style="text-align:center; line-height:26px; font-size:12px;">
				N&atilde;o se esque&ccedil;a que os bancos podem demorar at&eacute; <b>4 dias</b> &uacute;teis para confirmar a compra t&aacute;.
			</p>			
			<p style="text-align:center; line-height:26px; font-size:12px;">
				Se o pagamento foi via <span style="font-weight:bold;">boleto banc&aacute;rio</span>, corre l&aacute; para paga-lo e se atente para n&atilde;o perder a data
				de vencimento hein!
			</p>			
			<p style="text-align:center; line-height:26px;margin-top:25px; font-size:12px;">
				Abra&ccedil;os e vamos nos falando
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