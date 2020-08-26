<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
$condition = array();
$contidion[] = "user = {$_SESSION['user_id']}";

$count = Table::Count('sites', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$categories = DB::LimitQuery('sites', array(
	'condition' => $condition,
	'order' => 'ORDER BY id ASC',
	'size' => $pagesize,
	'offset' => $offset,
));

include template('manage_xml_index');