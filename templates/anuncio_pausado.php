<?php 

	require_once(dirname(dirname(__FILE__)). '/app.php');    
    $nomesite = $INI['system']['sitename']; 
	
	$id = strip_tags($_REQUEST['idoffer']);
	
	$team = Table::Fetch('team', $id);
	
	if(empty($id)) {
		exit;
	}

?>

<html>
	<head>
	</head>
	<body>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-88591" />
		<meta http-equiv="Content-Language" content="pt-BR" />
		<style>
			.maisOfertas {display: block;font-family:"Arial";font-size: 14px;overflow: hidden;width: 213;color: #303030;font-family:verdana;font-size:11px;	margin-left:17px; }
			.boxfundo {-moz-border-radius: 10px 10px 10px 10px;	background: none repeat scroll 0 0 #F0F0F0;	border: 1px solid #E8E8E8;	padding: 10px;	}
		</style>
		<table width="100%"  border="0" cellpadding="0" cellspacing="0">
			<tbody>
				<tr>
					<td style="padding: 20px;" name="tid" description="mediumBgcolor" >
						<div style="padding: 0px; margin: 0px;">
							<table style="font-family: 'Verdana';" width="70%" align="center" cellpadding="0" cellspacing="0">
								<tbody>
									<tr>
										<td colspan="5" >&nbsp;</td>
									</tr>
									<tr>
										<td>
											<table width="70%" border="0" cellpadding="0" cellspacing="0">
												<tbody>
													<tr bgcolor="#ffffff">
														<td valign="top" align="left" bgcolor="#ffffff"></td>
														<td style="padding: 10px 15px 15px 15px;" valign="top" width="570" align="left">
														</td>
														<td></td>
													</tr>
													<tr bgcolor="#ffffff">
														<td valign="top" align="left"></td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
									<tr>
										<td style="padding: 10px 30px;" bgcolor="#ffffff">
											<table width="100%" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">
												<tbody>
													<tr style="font-size: 14px;   color: #303030; padding: 2px 0px; margin: 0px; font-family: 'Verdana';">
														<td style="padding: 4px;border:1px solid #DCDCDC;" valign="top" width="57%">
															<div style="background:#fff;">
																<img style="max-width:223px;" src="<?=$ROOTPATH?>/include/logo/logo.png" alt="<?= $nomesite ?>">
															</div>  
															<div>
															</div>
															<div class="titulo" style="background:#20547E; box-shadow: 2px 2px 4px 0 #888888;font-family: helvetica;font-size: 19px; height: 28px; padding: 0px 12px 0;color:#FFF;margin-bottom:16px;">An&uacute;ncio pausado</div> 
															<p>O seu an&uacute;ncio foi pausado. O mesmo se encontra em análise, e assim que for reativado, você receberá uma notificação via email.</p><br />
															<p><b>ID da oferta:<b/> <?php echo $team['id']; ?></p>	
															<p><b>Título:<b/> <?php echo $team['title']; ?></p>
															<p><b>Valor:<b/> R$<?php echo number_format($team['team_price'], 2, ',', '.'); ?></p>														
															<br />
															<p><b><?=$nomesite ?></b></p>
														</td>
														<td style="padding: 10px 0px 10px 0px;" valign="top" width="43%">  
															<p style="font-size: 10px; line-height: 14px; color: #666633; padding: 5px 0px; margin: 0px; font-family: 'Verdana';">&nbsp;</p>
														</td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
									<tr>
										<td>
											<table style="padding: 0px;" width="100%" border="0" cellpadding="0" cellspacing="0">
												<tbody>
													<tr bgcolor="#ffffff">
														<td></td>
													<td style="padding: 5px 15px;"><p style="font-size: 10px; font-family: Verdana; color: #999999; text-align: center;" align="center"><br />
													</p>
													</td>
													<td></td>
													</tr>
													<tr>
														<td colspan="3" style="padding: 0px;" >
															<p style="font-family: Verdana; font-size: 10px; color: #ffffff; text-align: center;" align="center">
															  <?=$nomesite ?> 
															</p>
														</td>
													</tr>  
												</tbody>
											</table>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</td>
				</tr>
			</tbody>
	</table>
	</body>
</html>