<?php	

require_once(dirname(dirname(__FILE__)). '/app.php');   		
$id_order = strip_tags($_REQUEST['id_order']);  	
$id_qualificado	= strip_tags($_REQUEST['id_qualificado']);	
$name	= strip_tags($_REQUEST['name']);		
$questions = Table::Fetch('order', $id_order); 	
$items = mysql_query("SELECT * FROM order_team WHERE order_id = " . $id_order);		
$data = date("d/m/Y H:i", strtotime($qualification['data']));	
$nomesite = $INI['system']['sitename']; ?>
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
				<?php echo utf8_decode(strtoupper($name)); ?>,		
			</p>						
			<p style="text-align:center;font-weight:bold;font-size:16px;">	
				VOC&Ecirc; RECEBEU UMA QUALIFICA&Ccedil;&Atilde;O
			</p>	
			<p style="text-align:center; line-height:26px;font-size:12px;">
				Um passarinho verde nos contou que sua venda foi avaliada. Vai l&aacute; dar uma olhada!			
			</p>							
			<p style="text-align:center; line-height:26px;font-size:12px;">
				<ul style="list-style-type:none;">
					<?php 						
						while($item = mysql_fetch_array($items, MYSQL_ASSOC)) {								
							$team = mysql_fetch_object(mysql_query("SELECT * FROM team WHERE id = " . $item['team_id']));
					?>					
					<li>						
						<p style="text-align:center; line-height:26px; color:#F77275; font-weight:bold; text-transform:capitalize;">	
							<a style="color:#F77275;" href="<?php echo $ROOTPATH; ?>/?idoferta=<?php echo $team->id; ?>">
								<?php echo $team->title; ?>	
							</a>
							<br />
							<span style="text-align:center; line-height:26px; color:#F77275; font-weight:bold;">
								C&oacute;digo do produto: #<?php echo $team->id; ?>				
							</span>	
						</p>										
					</li>					
					<?php						
						}					
					?>				
				</ul>			
			</p>						
			<p style="text-align:center; line-height:26px;font-size:12px;">
				Clique <a style="color:#A8D7D1; text-decoration:none;" href="<?php echo $ROOTPATH; ?>/qualificacoes/recebidas">aqui</a> para ver como te avaliaram ou acesse sua conta em "Qualifica&ccedil;&otilde;es recebidas" :D			
			</p>									
			<p style="text-align:center; line-height:26px;margin-top:25px;font-size:12px;">	
				Um grande abra&ccedil;o			
			</p>			
			<p style="text-align:center;line-height:26px;margin-top:25px;font-weight: bold;text-transform: uppercase;font-size:12px;">
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