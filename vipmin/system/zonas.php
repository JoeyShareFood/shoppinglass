<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('market');

$condition = array();

/* filter */
$condition[] = "";
  
/* filter end */ 
$count = Table::Count('zonas_entrega', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 2000);

$zonas_entrega = DB::LimitQuery('zonas_entrega', array( 
	'order' => 'ORDER BY id DESC',
	'size' => $pagesize,
	'offset' => $offset,
)); 
 
include template('manage_system_zonas');
