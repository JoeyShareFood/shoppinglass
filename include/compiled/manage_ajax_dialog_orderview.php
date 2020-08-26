 <style>
.coupons-table td, .coupons-table th {
    padding: 6px;
}
</style>
 <?
 require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
 $order 	= Table::Fetch('order', $_REQUEST['id']);
 $options 	= Table::Fetch('options', $order['id_option']);
 $items = mysql_query("SELECT * FROM order_team WHERE order_id = {$_REQUEST['id']}");
 $user 		= Table::Fetch('user', $order['user_id']);
 header("Content-Type: text/html; charset=UTF-8");  
 
$codigovalecompras 	= $order[codigovalecompras];
$valorcupomdesconto  = $order[valecompras];
if(!$valorcupomdesconto){
	$valorcupomdesconto=0;
} 
	   
$valortotal = str2num($order['origin']) + str2num($order['valorfrete'])  - $valorcupomdesconto ;
		 
 ?>
<div id="order-pay-dialog" class="order-pay-dialog-c" style="width:780px;">
	<h3>DETALHES DO PEDIDO</h3>
	<div style="overflow-x:hidden;padding:10px;">
		<table width="96%" class="coupons-table">
		<tr><td><b>Pedido N.:</b></td><td><?=$order['id']?> - REALIZADO EM  <?php echo date('d/m/Y H:i', strtotime($order['datapedido']) ); ?>  </td></tr>
		 <? if( $order['data_ultima_atualizacao']){ ?>
			<tr><td><b>Última atualização.:</b></td><td><?php echo date('d/m/Y H:i', strtotime($order['data_ultima_atualizacao'])); ?>  </td></tr>
		<? } ?> 
		<? if( $order['statusentrega']){ ?>
			<tr><td><b>Andamento do Pedido.:</b></td><td><?php echo $order['statusentrega'] ; ?>  </td></tr>
		<? } 	 
	  
		if( $order['statuspedido']=="cancelado"){ ?>
			<tr><td><b>PEDIDO CANCELADO.:</b></td><td> SIM em <? if($order['datacancelamento']){ echo date('d/m/Y H:i', strtotime($order['datacancelamento'])); } ?> </td></tr>
		<? }  
		
		if( $order['codigorastreio']){ ?>
			<tr><td><b>Código dos Correios.:</b></td><td>  <?=$order['codigorastreio'] ?> </td></tr>
		<? } ?>
	
		<tr><td width="150"><b>Usuário:</b></td><td><?=$user['realname']?></td></tr> 
		<tr><td><b>Total dos Produtos:</b></td><td><?=$currency?> <?=number_format($order['origin'],2,",",".")?></td></tr>
		<? if($codigovalecompras){?><tr><td><b>Cupom de desconto:</b></td><td> R$ <?=number_format($valorcupomdesconto, 2, ',', '.') ?> ( <?=$codigovalecompras?> ) </td></tr> <? } ?>
		<tr><td><b>Frete:</b></td><td><?=$currency?> <?=number_format($order['valorfrete'],2,",",".") ;?></td></tr>
		<tr><td><b>Total a Pagar:</b></td><td><?=$currency?> <?=number_format($valortotal,2,",",".") ;?></td></tr>
        <? if( $team['pontosgerados'] and $INI['option']['pontuacao']=="Y" ){ 
			$totalpontos = (int)$team['pontosgerados'] * (int)$order['quantity']; ?>
			<tr><td><b>Pontos gerados</b></td><td><?=number_format($totalpontos ,null,"",".") ?></td></tr>
  	  <? } ?>   
	  <? if( $team['pontos'] and $INI['option']['pontuacao']=="Y" ){  ?>
			<tr><td><b>Pontos Necessárois</b></td><td><?=number_format($team['pontos'],null,"",".") ?></td></tr>
  	  <? } ?>    
	 
	   <? if( $order['service']){ ?>
			<tr><td><b>Serviço:</b></td><td><?=$order['service']?></td></tr>
  	   <? } ?>
      
      	<tr><td><b>Status:</b></td><td><? if($order['state']=="pay"){echo "<font color='#8FC92E'>Pago em ".date('d/m/Y H:i', $order['pay_time'])."</font>";} else {echo "<font color='#DD3832'>Pendente</font>";} ?></td></tr>
        <? if($order['pay_id']){?><tr><td><b>Transação.:</b></td><td><?=$order['pay_id']?></td></tr><?}?>
		 
		<? if( $order['service'] !='credit'&& $order['money'] != "0.00" ){ ?> <tr><td><b>Dinheiro:</b></td><td> Usuário pagou <?=$currency?>  <?= $order['money']?>   <? } ?>  		 
		 </table>
		<table width="96%" class="coupons-table">
		<tr style="text-align: center;"><td colspan="7"><b>Produtos do Pedido</b></td> </tr>		
		
		<tr></tr>
		<tr> 
			<td><b>Quantidade</b></td>
			<td><b>Item</b></td>
			<td><b>Preço</b></td>
			<td><b>Seguro contra extravio</b></td>
			<td><b>Total</b></td>
		</tr>		
		<?php while ($item = mysql_fetch_array($items, MYSQL_ASSOC)) {		
				$uploadarquivo = $item['uploadarquivo'];
				if(!empty($uploadarquivo )){
						$link = $ROOTPATH."/media/arquivospedido/".$uploadarquivo.".png";
				}
				
				echo "<tr>";			
				echo "<td>{$item['team_qty']}</td>";			
				$team = mysql_fetch_object(mysql_query("SELECT * FROM team WHERE id = {$item['team_id']}"));			
				$seguro = $team->seguro_val == '0.00' ? 'Não' : 'Sim - ' . $currency . number_format($team->seguro_val,2, ",", ".");
				echo "<td>[{$team->id}] {$team->title} Tamanho: [" . $options['size'] . "] Cor: [" . $options['color'] . "]</td>";			
				echo "<td>$currency {$item['team_price']}</td>";			
				echo "<td>" . $seguro . "</td>";			
				echo "<td>$currency {$item['team_total']}</td>";			
				?>						
				<? echo "</tr>";		
			}		
			?>
	 </table>
	</div>
</div>