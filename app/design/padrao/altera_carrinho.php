<?php
	$id = $_POST['id'];
	$qty = $_POST['qty'];
	$id_option = (int) strip_tags($_POST['id_option']);

	$_SESSION['qty_'.$id] = $qty;	
	
	if(!(empty($id_option))) {
		
		$sql = "select stock from options where id = " . $id_option;
		$rs = mysql_query($sql);
		$row = mysql_fetch_assoc($rs);
		
		if($row['stock'] < $qty) {

			$message = 'A quantidade solicitada é superior ao estoque!';	
			echo utf8_encode($message);
		}
		else {
			
			return false;
		}
	}
?>