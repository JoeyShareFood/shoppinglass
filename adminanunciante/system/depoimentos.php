<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('market');

$condition = array();

/* filter */
$condition[] = "";
  
/* filter end */ 
$count = Table::Count('avaliacao_produto', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 2000);

$boates = DB::LimitQuery('avaliacao_produto', array( 
	'order' => 'ORDER BY id DESC',
	'size' => $pagesize,
	'offset' => $offset,
)); 
 
include template('manage_system_depoimentos');
