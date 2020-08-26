 <?php 
	
	// De acordo com as novas regras do facebook, uma alteração no plugin foi necessária para se adequar as novas medidas estabelecidas de acordo com o link
	//https://developers.facebook.com/docs/reference/plugins/like/
	
	/*
	After July 2013 migration, the Like button required an absolute URL in the href parameter.	
	*/
	if($INI['other']['box-facebook'] != ""  ) { ?> 
		 
			<img style="margin-left:-9px;" alt="Facebook" src="<?=$PATHSKIN?>/images/faceimg.jpg"> 
			<div style="display:none;height:35px;width:100px;" class="tips"><?=__FILE__?></div> 
			<div class="body" id="deal-subscribe-body" style="margin-top:0px;background:#FFF;width:224px;margin-left:-2px">
		 
				<iframe scrolling="no" frameborder="0" allowtransparency="true" style="border:none; overflow:hidden; width:216px; height:258px;" src="http://www.facebook.com/plugins/likebox.php?href=<?php echo $INI['system']['fanpagefacebook']; ?>/&amp;width=235&amp;height=259&amp;show_faces=true&amp;colorscheme=light&amp;stream=false&amp;show_border=false&amp;header=false"></iframe>
		 
		    </div> 
<?php } ?>