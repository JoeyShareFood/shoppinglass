<?  
if(strpos($_SERVER["REQUEST_URI"],"produto") or strpos($_SERVER["REQUEST_URI"],"departamento")  OR  $home){?>
	<div class="searchbox clearfix" style="margin-left: 0px;clear:both; ">	  
		<div style="display:none;" class="tips"><?=__FILE__?></div>
		 <?  
		$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		if($HOME=="sim" or strpos($url,"page=parceiros")){ 
			if($INI['option']['menuparceiros'] !="N"){
				echo getCategoriasNavegacao();
			}
			
			 if($titulobreadcrumb){?><div class="titulopartnerafilio"><?=$titulobreadcrumb?></div><? }  
		}
		else{ 
			//$idcategoria = $_REQUEST['idcategoria'];
			if(empty($idcategoria)){
				$idcategoria = $team['group_id'];
			}
		?>  
				<div><ul class="breadcrumb"> <?=geraBreadcrumb($idcategoria)?>  </ul></div>
				<? if($titulobreadcrumb){?><div class="titulopartner"><?=$titulobreadcrumb?></div><? } ?>
		  <? } ?>
	</div>
<? } ?>
	
