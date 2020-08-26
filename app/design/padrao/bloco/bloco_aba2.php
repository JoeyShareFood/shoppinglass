<? if(!empty($team['detail'])){?>
	<div style="display:none;" class="tips"><?=__FILE__?></div>  
		<div class="indent" id="formas_pagamento">
			<div class="container1">	
				<h2>
					<div align="left">
					<span class="icon-description"></span>
					<div class="titofc"><?=utf8_decode($team['nomeaba2'])?></font> </div>
				</h2>
				<div class="descricaooferta"> 
					<?php  
						echo utf8_decode($team['detail']); 
					 ?> 
				</div>
				 </div>
			</div>
<? } ?>