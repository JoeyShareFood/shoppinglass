<script type="text/javascript">
$(function() {
  if ($.browser.msie && $.browser.version.substr(0,1)<7)
  {
	$('li').has('ul').mouseover(function(){
		$(this).children('ul').show();
		}).mouseout(function(){
		$(this).children('ul').hide();
		})
  }
});        
</script>

<ul id="menu">  

<li><a href="<?php echo $ROOTPATH; ?>">Voltar ao site</a></li>
<li><a href="/adminanunciante/team/index.php">Meus anúncios</a> </li> 
<li><a href="/adminanunciante/order/index.php">Minhas vendas</a> </li> 
<li><a href="/adminanunciante/system/index.php">Personalize sua lojinha</a> </li> 
 
</ul> 
