<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

$key = $INI['moip']['sec'];
$v_oid     = trim($_POST['v_oid']);  // Business???v_oid????
$v_pmode   = trim($_POST['v_pmode']); // ?????????
$v_pstatus = trim($_POST['v_pstatus']);   //???? ?20 ??,30 ??
$v_pstring = trim($_POST['v_pstring']);   // ??????
$v_amount  = trim($_POST['v_amount']);     // ????????
$v_moneytype = trim($_POST['v_moneytype']); //????????
$remark1   = trim($_POST['remark1' ]);      //????1
$remark2   = trim($_POST['remark2' ]);     //????2
$v_md5str  = trim($_POST['v_md5str' ]);   //????MD5???

/* ????md5?? */
$text = "{$v_oid}{$v_pstatus}{$v_amount}{$v_moneytype}{$key}";
$md5string = strtoupper(md5($text));

/* ??????????????????????????????? */
if ($v_md5str == $md5string) {
	list($_, $order_id, $city_id, $_) = explode('-', $v_oid, 4);
	if($v_pstatus=="20") {

		/* charge */
		if ( $_ == 'charge' ) {
			@list($_, $user_id, $create_time, $_) = explode('-', $v_oid, 4);
			ZFlow::CreateFromCharge($v_amount, $user_id, $create_time, 'moip');
			die('ok');
		}
		/* end charge */
		$currency = 'CNY';
		$service = 'moip';
		$bank = mb_convert_encoding($v_pmode,'UTF-8','GBK');
		ZOrder::OnlineIt($order_id, $v_oid, $v_amount, $currency, $service, $bank);
		die('ok');
	}
}
die('error');
?>
