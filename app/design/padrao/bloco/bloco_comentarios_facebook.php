<div style="display:none;" class="tips"><?=__FILE__?></div>	
<?php 
 
if($INI['other']['admin_id'] != "" and $INI['other']['app_id'] != ""  ) { ?>
	<html xmlns:fb="http://www.facebook.com/2008/fbml"
	xmlns:og="http://opengraphprotocol.org/schema/">
	<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">  
	<meta property="fb:admins" content="<?=$INI['other']['admin_id']?>" />
	<meta property="fb:app_id" content="<?=$INI['other']['app_id']?>" />
	</head>
	<body>
	<div class="col-1 bordasmoldura">
		<div class="indent" style="padding-left: 10px;">
			<div class="container1"> 
				 <div id="fb-root"></div> 
					<div class="fb-comments" data-href="<?=$this->linkoferta?>" data-num-posts="20" data-width="620" style="border: none; overflow: hidden; height: 160px; width: 800px;/*padding-left: 100px*/"></div>
					<script>
					  window.fbAsyncInit = function() {
						FB.init({appId: '<?=$INI['other']['app_id']?>', status: true, cookie: true,
								 xfbml: true});
					  };
					  (function() {
						var e = document.createElement('script'); e.async = true;
						e.src = document.location.protocol +
						  '//connect.facebook.net/pt_BR/all.js';
						document.getElementById('fb-root').appendChild(e);
					  }());
					</script>
			</div>
		</div>
   </div>
  </body>
 </html>
<? } ?> 
 