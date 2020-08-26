<head>
 <?php 
if(strpos($_SERVER["REQUEST_URI"],"departamento") and strip_tags(trim($category[seo_cat_title]))){?>
<title><?=strip_tags(utf8_decode($category[seo_cat_title]))?> - <?=utf8_decode($INI['system']['sitename'])?> </title>
<?php }
else if(!empty($BlocosOfertas->tituloferta)){?>
<title><?=$BlocosOfertas->tituloferta?> - <?=utf8_decode($INI['system']['sitename'])?> </title>
<?php }
else if($team['seo_title']){?>
<title><?php echo utf8_decode(  $team['seo_title'] )?> - <?=utf8_decode($INI['system']['sitename'])?>  </title>
<?}
else { ?>
<title><?php echo utf8_decode($INI['system']['sitename']) . "  ". strip_tags($pagetitle); ?> </title>
<?php }?>
<!--  SEO MOTORES DE BUSCA - DESCRIPTION -->
<?php  
if(strpos($_SERVER["REQUEST_URI"],"departamento") and strip_tags(trim($category[seo_cat_descricao]))){?>
<meta name="description" content="<?php echo mb_strimwidth(strip_tags(utf8_decode(strip_tags($category[seo_cat_descricao])) ), 0, 320); ?>" />
<? }
else if(strpos($_SERVER["REQUEST_URI"],"produto") and strip_tags(trim($BlocosOfertas->seo_description))){?>
<meta name="description" content="<?php echo mb_strimwidth(strip_tags(utf8_decode(strip_tags($BlocosOfertas->seo_description)) ), 0, 320); ?>" />
<?php } 
else if(strpos($_SERVER["REQUEST_URI"],"produto") and strip_tags(trim($BlocosOfertas->tituloferta))){?>
<meta name="description" content="<?php echo mb_strimwidth(strip_tags(utf8_decode(strip_tags($BlocosOfertas->tituloferta)) ), 0, 320); ?>" />
<?php } 
else if(strip_tags($INI['system']['seodescricao'])) { ?>
<meta name="description" content="<?php echo utf8_decode( strip_tags($INI['system']['seodescricao'])); ?> " />
<?php }  
else { ?>
<meta name="description" content="<?php echo utf8_decode( $INI['system']['sitename']); ?>, <?php echo utf8_decode($INI['system']['sitetitle']); ?> " />
<?php }?> 
<!--  SEO MOTORES DE BUSCA - PALAVRAS CHAVES -->
<? if(strpos($_SERVER["REQUEST_URI"],"departamento") and strip_tags(trim($category[seo_cat_key]))){?>
<meta name="keywords" content="<?php echo mb_strimwidth(strip_tags(utf8_decode(strip_tags($category[seo_cat_key])) ), 0, 320); ?>" />
<? }
else if(strpos($_SERVER["REQUEST_URI"],"produto") and strip_tags(trim($BlocosOfertas->seo_keyword))){?>
<meta name="keywords" content="<?php echo utf8_decode($BlocosOfertas->seo_keyword); ?>" />
<?php } 
else if($INI['system']['seochaves']){?>
<meta name="keywords" content="<?php echo utf8_decode($INI['system']['seochaves']); ?>" />
<?php } ?>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="shortcut icon" href="<?=$PATHSKIN?>/images/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?=$PATHSKIN?>/images/favicon.ico" type="image/x-icon">

<?php
	if(!(empty($team))) {
?>
<meta property="og:title" content="<?php echo utf8_decode($team['title']); ?>"/>
<meta property="og:image" content="<?php echo $ROOTPATH; ?>/media/<?php echo $team['image']; ?>"/>
<meta property="og:description" content="<?php echo utf8_decode($team['summary']); ?>" />
<?php } ?>

<script type="text/javascript">
var WEB_ROOT 	= "<?php echo WEB_ROOT; ?>";
var URLWEB	 	= "<?php echo $ROOTPATH?>";
var CITY_ID	 	= "<?php echo $city['id']?>";
var ID_CATEGORIA = "<?php echo RemoveXSS($_REQUEST['idcategoria'])?>"; 
var ID_PARCEIRO = "<?php echo $_REQUEST['idparceiro']?>";
</script> 
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<?php
	$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
 ?> 
<!-- CSS  -->  
<link rel="stylesheet" href="<?=$PATHSKIN?>/css/pedido.css" type="text/css" media="all">
<link rel="stylesheet" href="<?=$PATHSKIN?>/css/carrinho.css" type="text/css" media="all">
<link rel="stylesheet" href="<?=$PATHSKIN?>/css/product.css" type="text/css" media="all">
<link rel="stylesheet" href="<?=$PATHSKIN?>/css/menudepartamentos.css" type="text/css" media="all">
<link rel="stylesheet" href="<?=$PATHSKIN?>/css/home.min.css?20171224" type="text/css" media="all">
<link rel="stylesheet" href="<?=$PATHSKIN?>/css/login.css" type="text/css" media="all"> 
<link rel="stylesheet" href="<?=$PATHSKIN?>/css/padrao.css" type="text/css" media="all"> 
<link rel="stylesheet" href="<?=$PATHSKIN?>/css/menucategorias.css" type="text/css" media="all"> 
<link rel="stylesheet" href="<?=$PATHSKIN?>/css/menupaginas.css?20171227" type="text/css" media="all">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"> 
<link rel="stylesheet" href="<?=$PATHSKIN?>/css/modelo_clean.css?20171224" type="text/css" media="all">
<link rel="stylesheet" href="<?=$PATHSKIN?>/css/style.css?20171227" type="text/css" media="all">
<!-- JS -->
<script type="text/javascript" src="<?=$ROOTPATH?>/js/jquery-1.7.1.min.js" ></script>  
 <script>
var j203 = jQuery.noConflict(); 
var j171 = jQuery.noConflict();  
</script>
<script type="text/javascript" src="<?=$ROOTPATH?>/js/jquery.cookie.js" ></script>
<script type="text/javascript" src="<?=$ROOTPATH?>/js/mascara.js" ></script>
<script type="text/javascript" src="<?=$ROOTPATH?>/js/countdown/jquery.countdown.js" ></script> 
<script type="text/javascript" src="<?=$ROOTPATH?>/js/slider.js" ></script>  
<script type="text/javascript" src="<?=$ROOTPATH?>/js/funcoes.js"></script> 
<script type="text/javascript" src="<?=$ROOTPATH?>/js/corner.js"></script>   
<!--<script type="text/javascript" src="<?=$ROOTPATH?>/js/menu/menu.js"></script> -->
<script src="<?=$ROOTPATH?>/js/startup.js"></script>    
<script type="text/javascript">var LOGINUID= <?php echo abs(intval($login_user_id)); ?>;</script>
<script type="text/javascript" src="<?=$ROOTPATH?>/js/SearchTop.js"></script>
<meta http-equiv="cache-control" content="public" /> <!-- reconhecida pelo HTTP 1.1 -->
<meta http-equiv="Pragma" content="public"> <!-- reconhecida por todas as versoes do HTTP -->
<meta content="document" name="resource-type"></meta> 
<meta content="ALL" name="robots"></meta> 
<?php if($INI['system']['googleanalitics'] != "") { ?>

	<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', '<?php echo $INI['system']['googleanalitics'] ?>']);
	_gaq.push(['_setCustomVar', 1,'cidade','SaoPaulo_D2581',2])
	_gaq.push(['_trackPageview']);

	(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
	</script > 

<?php  } ?>

<link rel="stylesheet" href="<?=$ROOTPATH?>/js/ui/jquery.ui.core.css" type="text/css"  /> 
<link rel="stylesheet" href="<?=$ROOTPATH?>/js/ui/jquery.ui.theme.css" type="text/css"  /> 
<link rel="stylesheet" href="<?=$ROOTPATH?>/js/ui/jquery.ui.tabs.css" type="text/css"  /> 

<script type="text/javascript" src="<?=$ROOTPATH?>/js/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="<?=$ROOTPATH?>/js/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="<?=$ROOTPATH?>/js/ui/jquery.ui.tabs.js"></script>

<link rel="stylesheet" href="<?=$ROOTPATH?>/js/slideshow/css/skitter.styles.css" type="text/css"  /> 
<script type="text/javascript" src="<?=$ROOTPATH?>/js/slideshow/js/jquery.skitter.js"></script>
<script type="text/javascript" src="<?=$ROOTPATH?>/js/slideshow/js/highlight.js"></script>
<script type="text/javascript" src="<?=$ROOTPATH?>/js/slideshow/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?=$ROOTPATH?>/js/slideshow/js/jquery.animate-colors-min.js"></script> 

<!-- Responsivo -->
<script type="text/javascript" src="<? echo $ROOTPATH?>/js/responsiveslides/responsiveslides.min.js"></script> 
<script type="text/javascript" src="<? echo $ROOTPATH?>/js/responsiveslides/demo.css"></script> 
<script type="text/javascript" src="<?=$ROOTPATH?>/js/mobileJS.js?20171224"></script>
<link href="<?php echo $PATHSKIN; ?>/css/responsive.css?20171224" rel="stylesheet" type="text/css">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"> 
<!-- Responsivo -->

<link href="https://fonts.googleapis.com/css?family=Arvo" rel="stylesheet"> 

<script>
	<!-- Init Plugin -->
 
	J(document).ready(function() {
		J(".box_skitter_large").skitter({
		 
			//animation: "fade","fadefour","circles","circlesinside","cubejelly","cubeshow",  
			numbers_align: "center", 
 			dots: false, 
 			preview: true, 
 			focus: true, 
 			focus_position: "leftTop", 
 			controls: true, 
 			controls_position: "leftTop", 
 			progressbar: true, 
 			progressbar_css: { 
				top:'5px', 
				left:'590px', 
				height:10, 
				borderRadius:'2px', 
				width:200, 
				backgroundColor:'#000', 
				opacity:.7 
			}, 
 			animateNumberOver: { 'backgroundColor':'#555' } ,
			enable_navigation_keys: true
			
		});
	}); 
</script> 

<? if($_REQUEST['unsub']){ ?>
	<script>
    alert("Cancelamento de newsletter feito com sucesso!");
    </script>
<?
} 
include_once("head_color.php");
 ?>
</head>