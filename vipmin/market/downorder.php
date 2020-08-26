<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('market');

if ( $_POST ) {
	$team_id = abs(intval($_POST['team_id']));
	//$service = $_POST['service'];
	$state = $_POST['state'];
	if (!$team_id  || !$state) die('Por favor, existem campos a serem marcados. Verifique o filtro.');

	$condition = array(
			//'service' => $service,
			'state' => $state,
			'team_id' => $team_id,
			);
	$orders = DB::LimitQuery('order', array(
				'condition' => $condition,
				'order' => 'ORDER BY pay_time DESC, id DESC',
				));

	if (!$orders) die('Nenhum pedido encontrado');
	$team = Table::Fetch('team', $team_id);
	$name = 'order_'.date('Ymd');
	$kn = array(
			'id' => 'No. Pedido',
			'price' => 'Valor da Compra',
			'quantity' => 'Quantidade',
			'condbuy' => 'Opcao',
			'origin' => 'total',
			'money' => 'Valor Pago',
			'credit' => 'Balanca de credito',
			'state' => 'Status do pagmento',
			'remark' => 'Notas',
			'express' => 'Expresso',
			'realname' => 'Nome',
			'useremail' => 'Email',
			'usermobile' => 'Celular',
			);

	if ( $team['delivery'] == 'express' ) {
		$kn = array_merge($kn, array(
					'realname' => 'Destinatario',
					'mobile' => 'Celular',
					'zipcode' => 'Cep',
					'address' => 'Endereco',
					));
	}
	$pay = array(
			'alipay' => 'alipay',
			'pagamentodg' => 'Pagamento Digital',
			'moip' => 'Moip',
			'credit' => 'Credito',
			'cash' => 'Dinheiro',
			'pagseguro' => 'Pagseguro',
			'' => 'other',
			);
	$state = array(
			'unpay' => 'Pendente',
			'pay' => 'Pago',
			);
	$eorders = array();

	$expresses = option_category('express');
	$users = Table::Fetch('user', Utility::GetColumn($orders, 'user_id'));

	foreach( $orders AS $one ) {
		$oneuser = $users[$one['user_id']];
		$one['username'] = $oneuser['realname'];
		$one['useremail'] = $oneuser['email'];
		$one['usermobile'] = $oneuser['mobile'];
		$one['fare'] = ($one['delivery'] == 'express') ? $one['fare'] : 0;
		$one['service'] = $pay[$one['service']];
		$one['price'] = $team['market_price'];
		$one['state'] = $state[$one['state']];
		$one['express'] = ($one['express_id'] && $one['express_no']) ?
			$expresses[$one['express_id']] . ":" . $one['express_no']
			: "";
		$eorders[] = $one;
	}
	down_xls($eorders, $kn, $name);
}

include template('manage_market_downorder');
