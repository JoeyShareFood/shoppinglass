<?php include template("manage_html_header");?>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<link rel="stylesheet" href="<?=$PATHSKIN?>/css/bootstrap/bootstrap.min.css" type="text/css">
<script type="text/javascript" src="<?=$ROOTPATH?>/js/bootstrap/bootstrap.min.js" ></script>
<script type="text/javascript" src="<?=$ROOTPATH?>/media/js/jquery-1.4.2.min.js"></script> 
 
<link rel="stylesheet" type="text/css" href="<?=$ROOTPATH?>/js/colorbox/colorbox.css"/> 
<script type="text/javascript" src="<?=$ROOTPATH?>/js/colorbox/jquery.colorbox-min.js"></script> 
<link rel="stylesheet" type="text/css" href="<?=$ROOTPATH?>/js/color/farbtastic.css"/> 
<script type="text/javascript" src="<?=$ROOTPATH?>/js/farbtastic.js"></script>
<script type="text/javascript" src="<?=$ROOTPATH?>/js/jbase.js"></script>
<link rel="stylesheet" href="<?=$ROOTPATH?>/media/calendar/dhtmlgoodies/dhtmlgoodies_calendar.css" type="text/css" media="screen" charset="utf-8" /> 
<script src="<?=$ROOTPATH?>/media/calendar/dhtmlgoodies/dhtmlgoodies_calendar.js" type="text/javascript"></script> 
<link rel="stylesheet" type="text/css" href="<?=$ROOTPATH?>/media/tip/theme/style.css" />
<link rel="stylesheet" type="text/css" href="<?=$ROOTPATH?>/media/css/menu.css" />
<script src="<?=$ROOTPATH?>/media/tip/js/jquery.betterTooltip.js" type="text/javascript"></script> 
<script type="text/javascript" src="<?=$ROOTPATH?>/js/mascara.js"></script> 
<script type="text/javascript" src="<?=$ROOTPATH?>/media/js/main.js"></script> 
<script type="text/javascript" src="<?=$ROOTPATH?>/media/js/jquery.price_format.1.7.min.js"></script> 
 
<script type="text/javascript">

	$(document).ready(function(){
		$('.tTip').betterTooltip({speed: 100, delay: 30});
	});

</script>
<style> 
	.navbar-inverse {
		background-
		border-color: transparent !important;
	}
	.navbar-inverse .navbar-nav > .active > a, 
	.navbar-inverse .navbar-nav > .active > a:focus, 
	.navbar-inverse .navbar-nav > .active > a:hover {
		background-color: #FFF !important;
	}
	.navbar-inverse .navbar-nav > li > a {
		color: #FFF !important;
	}
</style>
<nav class="navbar navbar-inverse" role="navigation">
	<div class="navbar-header">		
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">	
			<span class="sr-only">
				Toggle navigation
			</span>	
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>	
			<span class="icon-bar"></span>	
		</button> 
	</div>
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<ul class="nav navbar-nav">
			<li class="active hidden-xs hidden-sm">	
				<a href="<?php echo $ROOTPATH; ?>/adminanunciante/index.php">	
					<img class="img-responsive" src="<?php echo $ROOTPATH; ?>/include/logo/logo.png" style="max-width: 125px;">
				</a>	
			</li>	
			<li>		
				<a href="<?php echo $ROOTPATH; ?>">		
					Voltar ao site	
				</a>		
			</li>	
			<li>
				<a href="<?php echo $ROOTPATH; ?>/adminanunciante/team/index.php">
					Meus anúncios
				</a> 
			</li>	
			<li>
				<a href="<?php echo $ROOTPATH; ?>/adminanunciante/order/index.php">
					Minhas vendas
				</a> 
			</li>		
			<li>
				<a href="<?php echo $ROOTPATH; ?>/adminanunciante/system/index.php">
					Personalize sua lojinha
				</a> 
			</li> 	
			<li> 
				<a href="<?php echo $ROOTPATH; ?>/autenticacao/logout.php">
					Sair
				</a>
			</li> 
		</ul>
		<ul class="nav navbar-nav navbar-right"></ul>
	</div>
</nav>
<?php if($session_notice=Session::Get('notice',true)){?>
	<script>
		jQuery(document).ready(function(){   
			jQuery.colorbox({html:"<div class='msgsoft'>  <div style='float:left;margin-right:10px;'> <img src='<?=$ROOTPATH?>/media/css/i/Accept-icon.png'></div> <?php echo $session_notice; ?></div>"});
		});
	</script>
<?php }?>
<?php if($session_notice=Session::Get('error',true)){?>
	<script>
		jQuery(document).ready(function(){   
			jQuery.colorbox({html:"<div class='msgsoft'> <div style='float:left;margin-right:10px;'> <img src='<?=$ROOTPATH?>/media/css/i/falha.png'></div> <?php echo $session_notice; ?></div>"});
		});
	</script>
<?php }?>

<?php
	 header("Content-Type: text/html; charset=UTF-8"); 
?>
 