<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
 
need_manager(); 
 
$now = time();
 
/* filter end */ 
$count = Table::Count('propostas');
list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$propostas = DB::LimitQuery('propostas', array(
	'order' => 'ORDER BY id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));
 
$selector = 'index';
include template('manage_partner_contact');


