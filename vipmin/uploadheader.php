<?
require_once(dirname(dirname(__FILE__)) . '/app.php');
?>
<form action="<?php echo $INI['system']['wwwprefix'] ?>/include/upload.php?tipo=imagemheader&nome=<?=$_REQUEST['tipo']?>" target="upload_target" method="POST" enctype="multipart/form-data"   onsubmit="startUpload();" >
		<div class="wholetip clear"></div>

		<div class="field" style="width: 100%">
			<input name="myfile" type="file" />
			<input type="submit" name="submitBtn"  class="formbutton" value="Upload" />
		</div>
		<input type="hidden" value="<?php echo $INI['system']['wwwprefix'] ?>" id="local" name="local">
		<input type="hidden" value="<?=$_REQUEST['tipo']?>" id="tipo" name="tipo">
</form>  
<iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe> 


<script> 
function startUpload(){ 
	return true;
} 
</script>
	