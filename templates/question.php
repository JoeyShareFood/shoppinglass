<?php
	require_once(dirname(dirname(__FILE__)). '/app.php');   

	$idquestion = strip_tags($_REQUEST['idquestion']);  	
	
	$questions = Table::Fetch('questions', $idquestion); 
	$vendedor 	= Table::Fetch('user', $questions['id_vendedor']);
	$name_user = $vendedor['realname'];
	
	$team = Table::Fetch('team', $questions['id_produto']);
	
	$data = date("d/m/Y H:i", strtotime($questions['data']));
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
				<?php echo strtoupper($name_user); ?>,
			</p>
			<p style="text-align:center;font-weight:bold;font-size:16px;">
				QUE LEGAL, VOC&Ecirc; TEM UMA MENSAGEM
			</p>					
			<p style="text-align:center; line-height:26px;font-size:12px;">
				Isso quer dizer que algu&eacute;m pode estar querendo comprar um produto, saber mais sobre ele, tirar
				uma d&uacute;vida ou fazer um elogio.
			</p>			
			<p style="text-align:center; line-height:26px;font-size:12px;">
				Clique <a href="<?php echo $ROOTPATH; ?>/perguntas/recebidas" style="color: #A9D6CF;text-decoration: none;">aqui</a> para responder ou acesse sua conta no menu "Perguntas recebidas" e seja gentil na
				resposta.
			</p>			
			<p style="text-align:center; line-height:26px;margin-top:25px;font-size:12px;">
				Boa sorte!
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