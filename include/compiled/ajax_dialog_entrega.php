 <?
 require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
 $order 	= Table::Fetch('order', $_REQUEST['id']);
 $user 		= Table::Fetch('user', $order['user_id']);
 //header("Content-Type: text/html; charset=UTF-8");  
 
 ?>
 <form>
<div id="order-pay-dialog" class="order-pay-dialog-c" style="width:500px;">
	<h3> Pedido: <b><?=$order[id]?></b> </h3>
 
	 <p class="notice">Um email será enviado para <b><?=$user[email]?></b><br>notificando sobre o andamento do seu pedido .</p> 
	<p class="act">
	Status da entrega:
	<select name="statusentrega" id="statusentrega" style="height: 33px;">
	<option value="">Informe o status</option> 
	<option value="Saiu para entregar">Saiu para entregar</option>
	<option value="Produtos postados nos correios">Produtos postados nos correios</option>
	<option value="Destinatário ausente">Destinatário ausente</option>
	<option value="Endereço não localizado">Endereço não localizado</option>
	<option value="Pedido entregue">Pedido entregue</option>
	<option value="Pedido não entregue">Pedido não entregue</option>
	<option value="Produtos enviados para transportadora">Produtos enviados para transportadora</option>
	<option value="Coletando produtos para envio">Coletando produtos para envio</option>
	<option value="Produtos sem estoque. Aguardando reposição...">Produtos sem estoque. Aguardando reposição...</option>
	<option value="Aguardando contato do cliente">Aguardando contato do cliente</option>
	</select>
	<br> 
 </form>							
										
	<BR>
	
	<button onclick="salvar();" id="run-button" class="input-btn" type="button"><div name="spinner-top" id="spinner-top" style="width: 83px; display: block;"><img name="imgrec" id="imgrec" src="<?=$ROOTPATH?>/media/css/i/lendo.gif" style="display: none;"></div><div id="spinner-text"  >Salvar</div></button>
	<br>Após clicar em salvar, aguarde a mensagem de retorno. Por favor, tenha paciência.
	</p>
 </div>

<script>

 

function salvar(){
		statusentrega = $("#statusentrega").val();
	   $.get(WEB_ROOT+"/ajax/manage.php?id=<?=$_REQUEST['id']?>&action=statusentrega&statusentrega="+statusentrega,
		    function(data){ 
				alert(data);   
		   });
	   }
</script>
 