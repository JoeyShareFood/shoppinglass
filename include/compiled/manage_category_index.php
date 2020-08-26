<?php include template("manage_header");?>
 
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons"> 
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear"> 
            <div class="box-content">
			<div class="option_box">
				 <div class="top-heading group"> <div class="left_float"><h4><?php echo $cates[$zone]; ?></h4></div> 
				
					<div style="padding: 10px;">
						<ul id="log_tools"> <li id="log_switch_referral"><a title="Cadastrar <?php echo $cates[$zone]; ?>" href="/vipmin/category/edit.php?zone=<?php echo $zone; ?>">Adicionar <?php echo $cates[$zone]; ?></a></li> </ul> 
					 </div>
						
				</div> 
			 
					<div class="paginacaotop"><?php echo $pagestring; ?></div>
					 
					 <div class="sect" style="clear:both;">
							 
						<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
						<form method="get">
						<tr><th width="10">ID</th>
						<th width="100">Nome
							<select  name="group_id" id="group_id">  
							 	<option value=""> </option>
								 <?php  
								   $indentacao = "....";
								   $sql = "select * from category where display ='Y'  and idpai=0 order by sort_order desc,name";

									$rs = mysql_query($sql);
									while($l = mysql_fetch_assoc($rs)){
									 $selected ="";
									 if($_REQUEST['group_id'] == $l['id']){
											$selected =  " selected ";
									 } 
										echo "<option value='$l[id]' $selected>".displaySubStringWithStrip($l[name],30)."</option>";
										exibe_filhos($l["id"],$indentacao,$_REQUEST['group_id']);
									} 
								  ?> 		 
							 </select>
						</th> 
						<th width="50">Categoria Pai no topo ?</th> 
						<th width="10" nowrap>Status</th>
						<th width="50">Banner Categoria</th> 
						<th width="40" nowrap>Pai 
							<select  name="idpai" id="idpai">  
							 	<option value=""> </option>
								 <?php  
								   $indentacao = "....";
								   $sql = "select * from category where display ='Y' and idpai=0 order by sort_order desc,name";

									$rs = mysql_query($sql);
									while($l = mysql_fetch_assoc($rs)){
									 $selected ="";
									 if($_REQUEST['idpai'] == $l['id']){
											$selected =  " selected ";
									 } 
										echo "<option value='$l[id]' $selected>".displaySubStringWithStrip($l[name],30)."</option>";
										exibe_filhos($l["id"],$indentacao,$_REQUEST['idpai']);
									} 
								  ?> 		 
							 </select>
						</th>
						<th width="40" nowrap>Ordenação</th>
						<th width="100"> 
							<button style="width: 60px;" type="submit"><span>Buscar</span></button>
						    <button style="width: 60px"  onclick="resetFilter()" type="button"><span>Limpar</span></button>
						</th></tr>
						</form>
						
						<?php if(is_array($categories)){foreach($categories AS $index=>$one) { ?>
						<tr <?php echo $index%2?'':'class="alt"'; ?>>
							<td><?php echo $one['id']; ?></td>
							<td><?php echo $one['name']; ?></td>   
							<? 
								$imagemnavegacao = " - ";
								if($one['imagemnavegacao']=="Y"){
										$imagemnavegacao = '<img style="max-height:23px;max-width:28px;" src="'.$ROOTPATH."/media/".$one['imagemcateg'].'">';
										if(empty($one['imagemcateg'])){
											$imagemnavegacao .= "(Imagem não enviada)";
										}
										else{
											//$imagemnavegacao .= " (enviada)";
										}
								}	
								
								$banner =" - "; 
								$imagemcateg = trim($one['bannercategoria']);
								if(!empty($imagemcateg)){
									$banner = "enviado";
								}
								
								$notopo = "N";
								if( $one['mostrartopo'] == "Y" and $one['idpai']==0){
									$notopo = "<span style='color:#333'>Sim</span>";
								}
								
								
							 
								$ativo = "<span style='color:orange'>Ativo</span>";
								if($one['display']!="Y"){
									$ativo = "Desativado";
								}
								$catpai  = Table::Fetch('category',$one['idpai']);
								
							?>
							<td><?php echo $notopo; ?></td>
							<td><?php echo $ativo; ?></td>
							<td style="text-align:left;"> <?php echo $banner?></td>      
							<td><?php if($one['idpai']!=0){ echo  $one['idpai']." - ".$catpai[name]; } else { echo " - "; } ; ?></td>
							<td><?php echo intval($one['sort_order']); ?></td>
							<td class="op">
								<div style="float: left; margin-right: 2px;"><a href="/vipmin/category/edit.php?zone=<?php echo $zone; ?>&id=<?php echo $one['id']; ?>"><img alt="Editar" title="Editar" src="/media/css/i/editar.png" style="width: 22px;"></a></div>
								<div style="float: left; margin-right: 2px;">
								<a href="/ajax/manage.php?action=categoryremove&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="Você tem certeza que deseja apagar?" ><img alt="Excluir" title="Excluir" style="width: 17px;" src="/media/css/i/excluir.png"></a>
							 </div> 
							 </td>
						</tr>
						<?php }}?>
						<tr><td colspan="18"><?php echo $pagestring; ?></td></tr>
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
 </script>
 
 <script>
  function msg_edit(){
	jQuery.colorbox({html:"<div class='msgsoft'><img src='<?=$PATHSKIN?>/images/ajax-loader2.gif'> Aguarde enquanto carregamos os dados...</div>"});
}
 </script>
 
  <script>
  function msg(){
		return true;
 }
 </script>
 