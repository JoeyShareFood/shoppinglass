 <div class="col-1 bordasmoldura floatnul">
	<div style="display:none;" class="tips"><?=__FILE__?></div>  
		<div class="indent" style="padding:12px;">
			<div class="container1">   
				<div class="descricaooferta">
				<?php  
					$descricao = str_replace("<p>","",$team['notice']);
					$descricao = str_replace("</p>","<br>",	$descricao );
					echo  nl2br($descricao )  ; 
				 ?> 
				</div>
			 </div>
		</div>
   </div> 