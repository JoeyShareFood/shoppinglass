<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
 
need_anunciante(); 
 
$now = time();
if($_REQUEST['acao']=='site'){
	$condition = array( 
		"end_time > {$now}",
		'partner_id' => $_SESSION['user_id'], 
		"status is null or status = 1",
	);
}
else{
	$condition = array(
		 'partner_id' => $_SESSION['user_id'], 
	);
}

if(isset($_GET['idoferta'])){
	$idoferta = strip_tags($_GET['idoferta']);
	$condition[] = "id = " . $idoferta;
}

/* filter start */
$team_type = strval($_GET['team_type']);
$team_title = strval(RemoveXSS($_GET['team_title']));
$city_id = strval($_GET['city_id']); 

if ($team_type) { $condition['team_type'] = $team_type; }
if ($city_id) { $condition['city_id'] = $city_id; } 
if ($team_title) { 
	$condition[] = "title LIKE '%".mysql_escape_string($team_title)."%'";
 }
 
/* filter end */ 
$count = Table::Count('team', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$teams = DB::LimitQuery('team', array(
	'condition' => $condition,
	'order' => 'ORDER BY id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));

$cities = Table::Fetch('cidades', Utility::GetColumn($teams, 'city_id'));
//$groups = Table::Fetch('category', Utility::GetColumn($teams, 'group_id')); 

$selector = 'index';
include template('manage_team_anunciante_index');


