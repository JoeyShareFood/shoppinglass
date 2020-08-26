<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons"> 
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear"> 
            <div class="box-content">
               	<div class="option_box"> 
					<div class="top-heading group"> <div class="left_float"><h4>Qualificações</h4></div> 
					</div> 
             	<div class="paginacaotop" style="width:50%"><?php echo $pagestring; ?></div>
				<div> 
				</div> 
				
                <div class="sect" style="clear:both;">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					  
					<form method="get">
					<tr>
					<th width="30">ID<input value ="<?=$_REQUEST['id']?>" type="text"  name="id"  id="id" style="width: 90%;color:#303030;font-size:11px;"> </th>
					 <th width="30">Pedido <input type="text"  value="<?=$_REQUEST['pedido']?>" name="pedido"  id="pedido" style="width: 100%;color:#303030;font-size:11px;"></th>
					<th width="30">Qualificado </th>
					<th width="30">Qualificante </th>					
					<th width="100">Título </th>
					<th width="80">Nota de 1 a 5 </th>
					<th width="100">Status da qualificação </th>
					<th width="200">Mensagem </th>
					 
					<!-- <th width="100">Onde? <input type="text"  value="<?=$_REQUEST['local']?>" name="local"  id="local" style="width: 100%;color:#303030;font-size:11px;"></th> -->
					<th width="100">Data de postagem</th>
					   
					<th width="80"> 
					<button style="width: 60px;" type="submit"><span>Buscar</span></button>
					<button style="width: 60px"  onclick="resetFilter()" type="button"><span>Limpar</span></button>
					</th>
					</tr>
					</form>
				   
				    <?php if(is_array($users)){foreach($users AS $index=>$one) { $bregistro =  true; ?>
					
					<?php
						$sql = "select login, realname from user where id = " . $one['id_qualificado'];
						$rs = mysql_query($sql);
						$rowU = mysql_fetch_assoc($rs);
						
						$sql = "select login from user where id = " . $one['id_qualificante'];
						$rs = mysql_query($sql);
						$rowP = mysql_fetch_assoc($rs);
						
						if($one['concretion'] == 1) {
							$one['concretion'] = "Positivo";
							$FundoCor = "#30682E";
						} else {
							$one['concretion'] = "Negativado";
							$FundoCor = "#FF0000";
						}
					?>
					
					<tr <?php echo $index%2?'':'class="alt"'; ?> id="team-list-id-<?php echo $one['id']; ?>">
						<td><?php echo $one['id'];?></td>
						<td><?php echo $one['id_order'];?></td>
						<td><?php echo empty($rowU['login']) ? $rowU['realname'] : $rowU['login']; ?></td>
						<td><?php echo $rowP['login']; ?></td> 
						<td><?php echo $one['titulo'];?></td> 
						<td><?php echo $one['nota'];?></td> 
						<td style="background:<?php echo $FundoCor; ?>"><?php echo $one['concretion'];?></td> 
						<td><?php echo $one['text'];?></td>  
						<td><?php echo data($one['data']); ?></td> 
						<td class="op">
						<a href="javascript:DetalheQualificacao('<?php echo $one['id']; ?>')" ><img alt="Detalhes da qualificação" title="Detalhes da qualificação" src="/media/css/i/detalhe2.png" style="width: 22px;"></a>
						<a href="/ajax/manage.php?action=qualificationProductremove&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="Você tem certeza que deseja apagar essa qualificação ?" ><img alt="Excluir" title="Excluir" style="width: 22px;" src="/media/css/i/excluir.png"></a>
					<?php }}?>
					<?if(!$bregistro){?><tr><td colspan="13" style="text-align: center;">Nenhum registro encontrado. Redefina sua pesquisa</tr><? } ?>
					<tr><td colspan="13"><?php echo $pagestring; ?></tr>
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
function DetalheQualificacao(id){
	jQuery.colorbox({html:"<div class='msgsoft'><img src='<?=$PATHSKIN?>/images/ajax-loader2.gif'> Buscando informações... </div>"});
	$.get(WEB_ROOT+"/include/compiled/manage_ajax_dialog_qualification.php?id="+id,
	function(data){ 
		jQuery.colorbox({html:data});
	}); 
} 
</script>