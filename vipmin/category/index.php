<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
$condition = array();
  
$id = strval($_GET['group_id']);
if ($id) { $condition['id'] = $id; }

$idpai = strval($_GET['idpai']);
if ($idpai) { $condition['idpai'] = $idpai; }

$stringzone = "&zone=".$zone;
/*
if($zone =="group" ){
	$condition = array( 
		'tipo is null', 
	);
}*/

$cates = get_zones();

$count = Table::Count('category', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 20);
 
$categories = DB::LimitQuery('category', array(
	'condition' => $condition,
	'order' => 'ORDER BY idpai, sort_order DESC, id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));

include template('manage_category_index');
