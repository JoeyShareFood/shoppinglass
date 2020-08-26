<?php 	
	require_once(dirname(dirname(__FILE__)). '/app.php');
	$id  	= (int) $_REQUEST['id'];  
	$code  	= strip_tags($_REQUEST['code']);  
	$order = Table::Fetch('order', $id); 
	$user = Table::Fetch('user', $order['user_id']);	
	$items = mysql_query("SELECT * FROM order_team WHERE order_id = " . $id);	  
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
				<?php echo strtoupper($user['realname']); ?>,
			</p>		
			<p style="text-align:center;font-weight:bold;font-size:16px;">			
				TOC TOC, TEM ALGU&Eacute;M EM CASA?	
			</p>		
			<p style="text-align:center; line-height:26px; font-size:12px;">		
				Sua belezinha est&aacute; chegando!!	
			</p>	
			<p style="text-align:center; line-height:26px; font-size:12px;">		
				<ul style="list-style-type:none;">		
					<?php 				
						while($item = mysql_fetch_array($items, MYSQL_ASSOC)) {
							
							$team = mysql_fetch_object(mysql_query("SELECT * FROM team WHERE id = " . $item['team_id']));
					?>			
						<li>			
							<p style="text-align:center; line-height:18px; color:#F77275; font-weight:bold; text-transform:capitalize;">
								<a style="color:#F77275;" href="<?php echo $ROOTPATH; ?>/?idoferta=<?php echo $team->id; ?>">
									<?php echo $team->title; ?>	
								</a>
								<br />
								<span style="text-align:center;color:#F77275; font-weight:bold;">	
									C&oacute;digo do produto: #<?php echo $team->id; ?>	
								</span>	
							</p>		
						</li>		
					<?php		
					}			
					?>	
				</ul>		
			</p>	
			<p style="text-align:center; line-height:18px; font-size:12px;">	
				Anota o c&oacute;digo de rastreamento dos correios:		
			</p>			
			<p style="margin-top:-10px; text-align:center;color:#FFF; padding:20px; background:#F77275; text-transform: uppercase; font-weight:bold; font-size:25px;">			
				<?php echo $code; ?>		
			</p>			
			<p style="text-align:center; line-height:18px; font-size:12px;">
				Voc&ecirc; tamb&eacute;m pode acompanhar o status do seu pedido acessando sua conta em "<b>minhas compras</b>".	
			</p>			
			<p style="text-align:center; line-height:18px; font-size:12px;">	
				Ahh, quando receber o produto, n&atilde;o esquece de avisar a gente <a style="color:#F77275;" href="<?php echo $ROOTPATH; ?>/contato">aqui</a> e qualificar sua compra t&aacute;, precisamos saber se deu tudo certinho com seu pedido! Afinal, s&oacute; vamos liberar o pagamento ao vendedor depois de confirmar o recebimento.	
			</p>	
			<p style="text-align:center; line-height:18px;margin-top:25px; font-size:12px;">	
				Abra&ccedil;os e at&eacute; logo		
			</p>
			<p style="text-align:center;line-height:18px;margin-top:25px;font-weight: bold;text-transform: uppercase; font-size:12px;">
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