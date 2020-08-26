<?php

require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('admin');

$iduser = (int) strip_tags($_GET["iduser"]);

if(!(empty($iduser))) {
	$condition[] = "id_user = '" . $iduser . "'";
}

if(!(empty($_GET["id"]))) {
	
	$IdBiling = (int) trim(strip_tags($_GET["id"]));
	$condition[] = "id = '" . $IdBiling . "'";
}

if(!(empty($_GET["valor"]))) {
	
	$ValueBiling = (int) trim(strip_tags($_GET["id"]));
	$condition[] = "valor = '" . $ValueBiling . "'";
}

if(!(empty($_GET["status"]))) {
	
	$StatusBiling = trim(strip_tags($_GET["status"]));
	$condition[] = "status = '" . $StatusBiling . "'";
}

$count = Table::Count('faturas', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$users = DB::LimitQuery('faturas', array(
	'condition' => $condition,
	'order' => 'ORDER BY id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));

$user = Table::Fetch('user', $iduser);

include template('manage_user_billing');