<?php  

require_once("include/head.php");

$user = explode("/", strip_tags($_GET["idvendedor"]));
$pagetitle = "Loja";

if(isset($_GET['categories'])) {
	$sql = "select * from team where partner_id = " . $user[0] . " and group_id = " . (int) strip_tags(urldecode($_GET['categories'])) .  " and moderacao = 'Y'   and posicionamento <> 5 order by id DESC";
}
else {
	$sql = "select * from team where partner_id = " . $user[0] . " and moderacao = 'Y'   and posicionamento <> 5 order by id DESC";
}

$RsTeam = mysql_query($sql);
$num = mysql_num_rows($RsTeam);

$sqlS = "select count(*) as vendidos from `order` where partner_id = " . $user[0] . " and datapagamento is not null";
$RsS = mysql_query($sqlS);
$numS = mysql_fetch_assoc($RsS);

$sqlU = "select * from user where id = " . $user[0];
$RsUser = mysql_query($sqlU);
$UserInfo = mysql_fetch_assoc($RsUser);

/* É efetuado uma busca para recuperar as qualificações recebidas. */
$sqlQ = "select count(*) from qualification where id_qualificado = " . $user[0];
$RsQ = mysql_query($sqlQ);
$QualificationUser = mysql_fetch_assoc($RsQ);

if($QualificationUser['count(*)'] == 0) {
	$Qualification = " Este vendedor ainda não possui nenhuma qualificação.";
}
else {
	$Qualification = $QualificationUser['count(*)'] . " qualificações em negociações com outros usuários. <a href='$ROOTPATH/avaliation/".$user[0]."'>Ver qualificações</a>";
}

/* O numero de pontos, é multiplicado pelo valor unitário de pontuação. */
if($UserInfo['pontuacao'] > 1) {
	$pontuacao = $INI['system']['pontuacao'] * $UserInfo['pontuacao'];
}

$sql_logo = "select logo, banner from info where id_vendedor = " . $user[0];
$rs_logo = mysql_query($sql_logo);
$row_logo = mysql_fetch_assoc($rs_logo);

?> 
<div style="display:none;" class="tips"><?=__FILE__?></div> 
<style>
	.content-page-info h2 {
		font-size: 35px;
		text-transform: uppercase;
	}
	input#btn-categories-filter {
		width: 150px;
		border: 1px solid #d3100d !important;
	}
</style>
<body id="page1" class="webstore home">
<?php
	if(detectResolution()) {
?>
<!-- Responsivo -->
<div class="containerM">
	<? require_once(DIR_BLOCO."/headerM.php"); ?>
	<div class="row">
		<div class="content-page-info"> 
			<?php
				if(!(empty($row_logo['banner']))) {
			?>
			<img src="<?php echo $ROOTPATH;?>/media/<?php echo $row_logo['banner']; ?>" style="max-width:100%;margin-top:10px;margin-bottom:10px;"> 
			<?php } else { ?>
			<img src="<?php echo $PATHSKIN;?>/images/human.png" style="max-width:100%;margin-top:10px;margin-bottom:10px;"> 
			<?php } ?>
			<br/>
			<?php
				if($row_logo['logo'] != "") {
			?>
			<div style="width:100%;text-align:center;">
				<p>
					<img src="<?php echo $ROOTPATH;?>/media/<?php echo $row_logo['logo']; ?>" style="border-radius:50%;max-width: 90px;"> 
				</p>
				<p>
					<h2>
						<?php echo empty($UserInfo['login']) ? utf8_decode(strtoupper($UserInfo['username'])) : utf8_decode(strtoupper($UserInfo['login'])); ?> 
					</h2>
				</p>
			</div>
			<?php } else { ?>
			<div style="width:100%;text-align:center;">
				<p>
					<img src="<?php echo $PATHSKIN;?>/images/store.png" style="border-radius:50%;max-width: 90px;"> 
				</p>
				<p>
					<h2>
						<?php echo empty($UserInfo['login']) ? utf8_decode(strtoupper($UserInfo['username'])) : utf8_decode(strtoupper($UserInfo['login'])); ?> 
					</h2>
				</p>
			</div>
			<?php } ?>					
			<br>
			<p class="user_localizacao" style="height: 59px;text-align:center;margin-bottom:0px;color:#999;">
				<?php echo ucwords(utf8_decode($UserInfo['cidadeusuario'])); ?>, <?php echo strtoupper(utf8_decode($UserInfo['estado'])); ?>
			</p>
			<p class="user_valores" style="float:right;text-align:center;margin-bottom:15px;margin-right:0px;">
				<span style="color:#f77274;font-weight:bold;font-size:18px;color:#797979;"><?php echo empty($numS['vendidos']) ? 0 : $numS['vendidos']; ?></span><br /> <span style="color:#999;"> vendidos</span>
			</p>
			<p class="user_valores" style="float:right;text-align:center;margin-bottom:15px;margin-right:20px;">
				<span style="color:#f77274;font-weight:bold;font-size:18px;"><?php echo empty($num) ? 0 : $num; ?></span><br /> <span style="color:#999;">&agrave; venda</span>
			</p>
			<div class="contentpage"> 
				<div class="produtoslista">
					<?php
					/* Neste loop é listado algumas ofertas do parceiro responsável pelo anúncio
						da página atual.
					*/ 
						if($num >= 1) {
							while($team = mysql_fetch_assoc($RsTeam)) {  
								$BlocosOfertas->getDados($team);
								$avaliacaomedia = avaliacaomedia($team['id']);
								$avaliacaomediaformat1 =  number_format($avaliacaomedia, 1, '.', ''); 
								$avaliacaomediaformat = str_replace(".","_",$avaliacaomediaformat1);
								require(DIR_BLOCO."/lista_produtos.php"); 
							}
						}
					?>
				</div> 				
			</div>
		</div> 
	</div>
</div>
<?php } else { ?>
<div class="cabecalhosub"></div>
<div class="container">  
	<div class="page">
		<?php  require_once(DIR_BLOCO."/header.php"); ?>
			<div class="main-content clearfix"> 
				 
				<div class="content-page-info"> 
					<?php
						if(!(empty($row_logo['banner']))) {
					?>
					<img src="<?php echo $ROOTPATH;?>/media/<?php echo $row_logo['banner']; ?>" style="width:1201px;height:270px;margin-top:10px;margin-bottom:10px;"> 
					<?php } else { ?>
					<img src="<?php echo $PATHSKIN;?>/images/human.png" style="width:1230px;height:270px;margin-top:10px;margin-bottom:10px;"> 
					<?php } ?>
					<br/>
					<?php
						if($row_logo['logo'] != "") {
					?>
					<div style="width:100%;text-align:center;">
						<p>
							<img src="<?php echo $ROOTPATH;?>/media/<?php echo $row_logo['logo']; ?>" style="border-radius:50%;max-width: 90px;"> 
						</p>
						<p>
							<h2>
								<?php echo empty($UserInfo['login']) ? utf8_decode(strtoupper($UserInfo['username'])) : utf8_decode(strtoupper($UserInfo['login'])); ?> 
							</h2>
						</p>
					</div>
					<?php } else { ?>
					<div style="width:100%;text-align:center;">
						<p>
							<img src="<?php echo $PATHSKIN;?>/images/store.png" style="border-radius:50%;max-width: 90px;"> 
						</p>
						<p>
							<h2>
								<?php echo empty($UserInfo['login']) ? utf8_decode(strtoupper($UserInfo['username'])) : utf8_decode(strtoupper($UserInfo['login'])); ?> 
							</h2>
						</p>
					</div>
					<?php } ?>					
					<br>
					<p class="user_localizacao" style="height: 59px;text-align:center;margin-bottom:0px;color:#999;">
						<?php echo ucwords(utf8_decode($UserInfo['cidadeusuario'])); ?>, <?php echo strtoupper(utf8_decode($UserInfo['estado'])); ?>
						<div class="user_valores" style="padding: 15px;">
						 
							<span style="color:#f77274;font-weight:bold;font-size:18px;color:#797979;"><?php echo empty($numS['vendidos']) ? 0 : $numS['vendidos']; ?></span>  <span style="color:#999;"> vendidos</span>
						   |  <span style="color:#f77274;font-weight:bold;font-size:18px;"><?php echo empty($num) ? 0 : $num; ?></span>  <span style="color:#999;">&agrave; venda</span>
						 
						</div>
					</p>
					<div class="categories-filter">
						<form method="GET" action="<?php echo $ROOTPATH; ?>">
							<input type="hidden" name="page" value="loja">
							<input type="hidden" name="idvendedor" value="<?php echo $user[0]; ?>">
							<select name="categories">
								<option value="">
									Escolha uma categoria
								</option>
								<?php 
									$sql = "select id, name from category where (idpai=0 or idpai is null) and display = 'Y' order by sort_order desc";
									$rs = mysql_query($sql);  
									
									while($item = mysql_fetch_assoc($rs)) {
								?>
								<option value="<?php echo $item['id']; ?>">
									<?php echo utf8_decode($item['name']); ?>
								</option>							
								<?php
										lista_filhos_categoria($item['id']);  								
									}
								?>
							</select>
							<input type="submit" class="button-salmon" id="btn-categories-filter" value="Buscar">
						</form>
						</div>
					</div>
					<!-- 
					<p class="user_valores" style="float:right;text-align:center;margin-bottom:15px;margin-right:0px;">
						<span style="color:#f77274;font-weight:bold;font-size:18px;color:#797979;"><?php echo empty($numS['vendidos']) ? 0 : $numS['vendidos']; ?></span><br /> <span style="color:#999;"> vendidos</span>
					</p>
					<p class="user_valores" style="float:right;text-align:center;margin-bottom:15px;margin-right:20px;">
						<span style="color:#f77274;font-weight:bold;font-size:18px;"><?php echo empty($num) ? 0 : $num; ?></span><br /> <span style="color:#999;">&agrave; venda</span>
					</p>
					-->
					<div class="contentpage"> 

						<div class="produtoslista">
							<div class="telefonia home-list clearfix hover">   
								<div class="shelf-home shelf-container shelf-horizontal  two-rows">	
									<div class="shelf-itens carousel-shelf-home arrow-big clearfix owl-carousel owl-theme" style="opacity: 1; display: block;">
										<div class="owl-wrapper-outer">
											<div class="owl-wrapper" style="background: #fff;width: 103%;left: 0px;display: block;border:none !important;margin-left: 2%;">	
											<?php
											/* Neste loop é listado algumas ofertas do parceiro responsável pelo anúncio
						   				da página atual.
					   					*/ 
												if($num >= 1) {
													while($team = mysql_fetch_assoc($RsTeam)) {  
														$BlocosOfertas->getDados($team);
														$avaliacaomedia = avaliacaomedia($team['id']);
														$avaliacaomediaformat1 =  number_format($avaliacaomedia, 1, '.', ''); 
														$avaliacaomediaformat = str_replace(".","_",$avaliacaomediaformat1);
														require(DIR_BLOCO."/lista_produtos.php"); 
													}
												}
											?>
											</div>
										</div>
									</div>		
								</div>			
							</div>  
						</div> 				
					</div>
				</div> 
			</div>
	<?php
		require_once(DIR_BLOCO."/rodape.php");
	?>
	
</div>
</div>
<?php } ?>
</body>
</html>
