<?php 
	require_once(dirname(dirname(__FILE__)). '/app.php');   
	
	$idoffer = strip_tags($_REQUEST['idoffer']);  	
	$name_user = strip_tags($_REQUEST['name']);  	
	
	$offer = Table::Fetch('team', $idoffer); 	
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
				<?php echo utf8_decode(strtoupper($name_user)); ?>,
			</p>
			<p style="text-align:center;font-weight:bold; font-size:16px;">
				SEU PRODUTO T&Aacute; NO AR!!
			</p>			
			<p style="text-align:center;line-height:26px; font-size:12px;">
				Aperta o cinto e segura a&iacute; que seu produto est&aacute; pronto pra voar!!!
				<br />
				Enquanto isto, d&aacute; uma espiadinha:
			</p>						
			<p style="text-align:center;color: #F77274;font-weight: bold; font-size:12px;">
				<a href="<?php echo $ROOTPATH; ?>/?idoferta=<?php echo $offer['id']; ?>" style="color: #F77274;text-decoration:underline;">
					<?php echo $offer['title']; ?>
				</a>
				<br />
				C&oacute;digo do produto: #<?php echo $idoffer; ?>
			</p>							
			<p style="text-align:center;line-height:26px; font-size:12px;">
				Vamos cruzar os dedos e torcer para algu&eacute;m se apaixonar e levar para casa.
				<br />
				Torce da&iacute; que a gente torce daqui.
			</p>			
			<p style="text-align:center;line-height:26px;margin-top:25px; font-size:12px;">
				Boas vendas!
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