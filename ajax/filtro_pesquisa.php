<?php
include ('../app.php');
echo "<!--".PHP_EOL;
print_r($_REQUEST);
echo "-->".PHP_EOL;
if (isset($_REQUEST['filtro'])) {
	$FILTRO = $_REQUEST['filtro']; 
	switch ($FILTRO) { 
	
	case 'atributos':
		$team_id = $_REQUEST['team_id'];
		$atributos = mysql_query("SELECT  * FROM `category_atributos` WHERE id_atributopai = 0 and status = 1 and category_id = '{$_REQUEST['idcategoria']}' ORDER BY ordem desc, nome_atributo ASC");		
		$indentacao = "....";  
		while ($row = mysql_fetch_array($atributos, MYSQL_ASSOC)) {			 
			echo "<br><BR><div><input type='checkbox' value='{$row['id']}' name='atributos[]' class='cinput' > <b>{$row['nome_atributo']}</b></div> ";
			exibe_filhos_atributo($row["id"],$indentacao,$team_id);			
		} 
		break;		 
	case 'cidades':
		$cidades = mysql_query("SELECT * FROM `cidades` WHERE uf = '{$_POST['estado']}' ORDER BY nome ASC");		
		while ($row = mysql_fetch_array($cidades, MYSQL_ASSOC)) {			
			echo "<option value='{$row['id']}'>{$row['nome']}</option>";		
		}		
		break;		
	case 'options_product':
		$sql_option = "select id, color from options where team_id = " . $_GET['product_id'] . " and size = '" . $_GET['size_id'] . "' and stock >= 1 group by color order by color";
		$rs_option = mysql_query($sql_option);
		$row = mysql_num_rows($rs_option);
		
		if($row >= 1) {
	?>
		<ul class="list-options">
		<?php
			while($options = mysql_fetch_assoc($rs_option)) {
		?>
			<li>
				<input type="radio" class="choice-product-color" name="options-color-product" value="<?php echo $options['id']; ?>"> Cor: <span class="color-size"><?php echo $options['color']; ?></span>
			</li>
		<?php } } else { ?>	
			<li>
				Nenhuma opção de cor foi encontrada para este tamanho!
			</li>
		<?php } ?>
		</ul>
		<script>
			J('document').ready(function(){
				J('.choice-product-color').click(function(){
					
					var id_option = J(this).val();
				
					if(id_option != "" && id_option != undefined) {
						
						if(J('#id_option').length == 0) {
							
							J('#dadospedido').append("<input type='hidden' name='id_option' id='id_option' value='" + id_option + "'>");
						}
						else {
							
							J('#id_option').val(id_option);
						}
					}
					else {
						window.alert("Ocorreu um erro! Tente novamente mais tarde!");
					}
					
					J('.end-options-message').html("<img src='<?php echo $ROOTPATH; ?>/media/css/i/Accept-icon.png' style='max-width:18px;'> Salvamos sua escolha! Prossiga para fechar o seu pedido.");
					J('.end-options-message').show("slow");
				});			
			});
		</script>		
	<?php
	break;		 
	default:
		echo "<option>Erro ao filtrar</option>";
		break;
	}
}
?>