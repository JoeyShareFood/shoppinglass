<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons"> 
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear"> 
            <div class="box-content">
				<div class="option_box">
					 <div class="top-heading group"> <div class="left_float"><h4>Parceiros</h4></div> 
						 
						<div style="padding: 10px;">
							<ul id="log_tools"> <li id="log_switch_referral"><a title="Cadastrar um novo parceiro ou afiliado" href="/vipmin/parceiro/edit.php">Novo Parceiro</a></li> </ul> 
						</div>
							
					</div> 
							 
					<div class="paginacaotop"><?php echo $pagestring; ?></div>
				 
					<div class="sect" style="clear:both;">
						<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
						
						<form method="get">
						<tr>
						<th width="10">Id </th>
						<th width="150">Nome <input type="text"  value="<?=$_REQUEST['title']?>" name="title"  id="title" style="width: 100%;color:#303030;font-size:11px;"></th>
						<th width="30">Usuario <input type="text"  value="<?=$_REQUEST['username']?>" name="username"  id="username" style="width: 100%;color:#303030;font-size:11px;"></th>
						<th width="50">Email <input type="text"  value="<?=$_REQUEST['contact']?>" name="contact"  id="contact" style="width: 100%;color:#303030;font-size:11px;"></th>
						<th width="100">Cidade <input type="text"  value="<?=$_REQUEST['cidade']?>" name="cidade"  id="cidade" style="width: 100%;color:#303030;font-size:11px;"></th>
						<th width="50">Link Ofertas </th>
						<th width="20">Telefone <input type="text"  value="<?=$_REQUEST['mobile']?>" name="mobile"  id="mobile" style="width: 96%;color:#303030;font-size:11px;"></th>
 						<th width="50">Banner </th>
						<th width="70">Imagem na Navegação </th>  
						  
						<th width="190">  
						<button style="width: 60px;" type="submit"><span>Buscar</span></button>
						<button style="width: 60px"  onclick="resetFilter()" type="button"><span>Limpar</span></button>

						<button style="width: 60px"  onclick="gerarExcel()" type="button"><span>Excel</span></button>

						</th>
						</tr>
						</form> 
						<?php if(is_array($partners)){foreach($partners AS $index=>$one) { $bregistro =  true; 
							$linkofertas  = $ROOTPATH."/index.php?page=parceiros&idparceiro=".$one['id']."&pagina=1&nome=".$one['title'];
							
							$imagemnavegacao = "Não";
							if($one['imagemnavegacao']=="Y"){
									$imagemnavegacao = "<span style='color:#E63300'>Sim</a>";
									if(empty($one['imagemparceiro'])){
										$imagemnavegacao .= " (Imagem não enviada) ";
									}
							}	
							
							$banner = "Não enviado"; 
							$bannerparceiro = trim($one['bannerparceiro']);
							if(!empty($bannerparceiro)){
								$banner = "Enviado";
							}
						  
							
							?>
						<tr <?php echo $index%2?'':'class="alt"'; ?> id="team-list-id-<?php echo $one['id']; ?>">
							<td><?php echo $one['id']; ?></td>
							<td style="text-align:left;"> <?php echo $one['title']; ?></td>
							<td style="text-align:left;"> <?php echo $one['username']; ?></td>
							<td style="text-align:left;"> <?php echo $one['contact']; ?></td>
							<td style="text-align:left;"> <?php echo $one['cidade']; ?></td>
							<td style="text-align:left;"> <a target="_blank" style="color:#A2C92D;" href="<?php echo $linkofertas?>">Copiar Link</a>  <img style="cursor:help" class="tTip" title="Este link contém todas as ofertas ativas deste parceiro. Na nova janela que irá abrir, copie o link do navegador. Você pode usar este link de diversas formas como por exemplo em um banner na página principal, ou em um link externo de categoria ou enviar este link para um amigo ou compartilhar em redes socias." src="<?=$ROOTPATH?>/media/css/i/info.png"></td>
							<td style="text-align:left;"> <?php echo $one['mobile']; ?></td> 
							<td style="text-align:left;"> <?php echo $banner?></td>  
							<td style="text-align:left;"> <?php echo $imagemnavegacao; ?></td>    
					 
							<td class="op" nowrap>
							<a href="/vipmin/parceiro/edit.php?id=<?php echo $one['id']; ?>"><img alt="Editar parceiro" title="Editar parceiro" src="/media/css/i/editar.png" style="width: 22px;"></a>   
							<a href="/ajax/manage.php?action=partnerremove&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="Você tem certeza que deseja apagar esse parceiro ?" ><img alt="Excluir" title="Excluir" style="width: 22px;" src="/media/css/i/excluir.png"></a>
							</td>
						</tr>
						<?php }}?>
						<?if(!$bregistro){?><tr><td colspan="13" style="text-align: center;">Nenhum registro encontrado. Redefina sua pesquisa</tr><? } ?>
						<tr><td colspan="13"><?php echo $pagestring; ?></td></tr>
						</table>
					</div>
				</div>
            </div>
            <div class="box-bottom"></div>
        </div>
    </div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->



 <script> 
 function resetFilter(){
	location.href  = '<?php echo $_SERVER["PHP_SELF"] ?>';
 }
function gerarExcel(){
	var url = <?php echo "'" . $INI['system']['wwwprefix'] . "';"; ?>

	if($('#title').val() != ''){
		var title = $('#title').val();
	}else{
		var title = 'undefined';
	}

	if($('#username').val() != ''){
		var username = $('#username').val();
	}else{
		var username = 'undefined';
	}

	if($('#contact').val() != ''){
		var contact = $('#contact').val();
	}else{
		var contact = 'undefined';
	}

	if($('#cidade').val() != ''){
		var cidade = $('#cidade').val();
	}else{
		var cidade = 'undefined';
	}

	if($('#homepage').val() != ''){
		var homepage = $('#homepage').val();
	}else{
		var homepage = 'undefined';
	}

	if($('#mobile').val() != ''){
		var mobile = $('#mobile').val();
	}else{
		var mobile = 'undefined';
	}

	if($('#bank_name').val() != ''){
		var bank_name = $('#bank_name').val();
	}else{
		var bank_name = 'undefined';
	}

	var params = 'title='+title+'&username='+username+'&contact='+contact+'&cidade='+cidade+'&homepage='+homepage+'&mobile='+mobile+'&bank_name='+bank_name;
	window.open(url + '/vipmin/parceiro/excel.php?'+params, '_blank');
}

  function msg(){
	jQuery.colorbox({html:"<div class='msgsoft'><img src='<?=$PATHSKIN?>/images/ajax-loader2.gif'> Deletando este parceiro...</div>"});
}  

 </script>