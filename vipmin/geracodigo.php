<?php
  echo uniqueAlfa();
 
 function uniqueAlfa($length=10)
{
	 $salt = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	 $len = strlen($salt);
	 $pass = '';
	 mt_srand(10000000*(double)microtime());
	 for ($i = 0; $i < $length; $i++)
	 {
	   $pass .= $salt[mt_rand(0,$len - 1)];
	 }
	 return $pass;
}

?>