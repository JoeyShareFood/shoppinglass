<?php include template("manage_html_header");?>

<!--<script type="text/javascript" src="<?=$ROOTPATH?>/media/js/jquery-1.4.2.min.js"></script> -->
 
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
 
<!-- EDITOR: INCLUSAO DAS LIBS -->
	<script src="/media/ckeditor/ckeditor.js"></script>
<!-- EDITOR FIM -->

<script type="text/javascript">

	$(document).ready(function(){
		$('.tTip').betterTooltip({speed: 100, delay: 30});
	});

</script> 
 
<div id="hdw" style="color:#FFF;">
	<div class="anuncianteheader_background"></div>
	<div id="hd">
	
	
	 <div id="logo" style="height: 92px;"><a href="/vipmin/index.php" class="link" ><img  src="/include/logo/logo.png" style="max-width: 330px; max-height:61px;" /></a></div> 
	 
	<!-- 
	<? if(file_exists(WWW_ROOT."/include/logo/logo.png")){?>
		 <div id="logo"><a href="/index.php" class="link" target="_blank"><img  src="/include/logo/logo.png" style="max-width: 330px; height:89px;" /></a></div> 
	<? } 
	else{?>
		 <div id="logo"><a href="/index.php" class="link" target="_blank"><img  src="/include/logo/logo.jpg" style="max-width: 330px;height:89px;" /></a></div> 
	<? } ?>
	
	-->
 
 
		<div class="guides" style="top:3px;width:300px;" > 
			 <div style="font-size:11px;color:#303030;"><?php if($login_user){ echo "Usuário: ". $login_user['realname']; } ?></div>
		</div>
		<?php if($login_user){require_once("menu.php");}?> 
		<?php if(is_manager()){?><div class="vcoupon">&raquo;&nbsp;<a href="/sair"><span style="color:#303030;">Sair</span></a></div><?php }?>
	</div>
</div>

<?php if($session_notice=Session::Get('notice',true)){?>
	<script>
		jQuery(document).ready(function(){   
			jQuery.colorbox({html:"<div class='msgsoft'> <img src='<?=$ROOTPATH?>/media/css/i/Accept-icon.png'> <?php echo $session_notice; ?></div>"});
		});
	</script>
<?php }?>
<?php if($session_notice=Session::Get('error',true)){?>
	<script>
		jQuery(document).ready(function(){   
			jQuery.colorbox({html:"<div class='msgsoft'> <img src='<?=$ROOTPATH?>/media/css/i/falha.png'> <?php echo $session_notice; ?></div>"});
		});
	</script>
<?php }?>
<?php
	
?>
 