<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('team');

$now = time();
if($_REQUEST['acao']=='site'){
	$condition = array(
		'system' => 'Y',
		'team_type not in ("simples","pacote")',
		"end_time > {$now}",
	);
}
else{
	$condition = array(
		'system' => 'Y',
		'team_type not in ("simples","pacote")',
	);
}

/* filter start */
$team_type = strval($_GET['team_type']);
$team_title = strval($_GET['team_title']);
$city_id = strval($_GET['city_id']);
$partner_id = strval($_GET['partner_id']);

if(isset($_GET['moderacao'])) {
	$moderacao = strval($_GET['moderacao']);
}

if ($team_type) { $condition['team_type'] = $team_type; }
if ($city_id) { $condition['city_id'] = $city_id; }
if ($partner_id) { $condition['partner_id'] = $partner_id; }

if ($moderacao == 1) { 
	$condition['moderacao'] = "Y";
} 
else if($moderacao == 2) { 
	$condition['moderacao'] = "N"; 
}

if ($team_title) { 
	$condition[] = "title LIKE '%".mysql_escape_string($team_title)."%'";
 }


 
  $idoferta = strval($_GET['idoferta']);
if ($idoferta) { $condition['id'] = $idoferta; }

 
/* filter end */ 
$count = Table::Count('team', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$teams = DB::LimitQuery('team', array(
	'condition' => $condition,
	'order' => 'ORDER BY id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));
$cities = Table::Fetch('category', Utility::GetColumn($teams, 'city_id'));
$groups = Table::Fetch('category', Utility::GetColumn($teams, 'group_id'));
$partner = Table::Fetch('user', Utility::GetColumn($teams, 'partner_id'));

$condition_p[] = " tipo = 'parceiro' or tipo is null";
$partners = DB::LimitQuery('user', array(
			'condition' => array( $condition_p ),
			'order' => 'ORDER BY id DESC',
			));
$partners = Utility::OptionArray($partners, 'id', 'title');
 

$selector = 'index';
include template('manage_team_index');


