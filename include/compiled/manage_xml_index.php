<?php include template("manage_header"); ?>
<div id="bdw" class="bdw">
   <div id="bd" class="cf">
      <div id="coupons">
         <div id="content" class="coupons-box clear mainwide">
            <div class="box clear">
               <div class="box-content">
                  <div class="option_box">
                     <div class="top-heading group"> <div class="left_float"><h4>Sites Registrados para Importação</h4></div>
                        <div style="padding: 10px;">
                           <ul id="log_tools"> <li id="log_switch_referral"><a title="Cadastrar Site" href="/vipmin/xml/edit.php">Adicionar Site</a></li></ul>
                        </div>
                     </div>
                     <div class="paginacaotop"><?php echo $pagestring; ?></div>
                     <div class="sect" style="clear:both;">
                        <table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
                           <tr>
                              <th width="10">ID</th>
                              <th width="150">Titulo</th>
                              <th width="300">Link</th>
                              <th width="300">XML</th>
                              <th width="100">Importar</th>
                              <th width="100">Operação</th></tr>
                           <?php if (is_array($categories)) {
                                  foreach ($categories AS $index => $one) { ?>
                                     <tr <?php echo $index % 2 ? '' : 'class="alt"'; ?>>
                                        <td><?php echo $one['id']; ?></td>
                                        <td><?php echo $one['titulo']; ?></td>
                                        <td><?php echo $one['endereco']; ?></td>
                                        <td><?php echo $one['xml']; ?></td>
                                        <td><a href="/vipmin/xml/import.php?id=<?php echo $one['id']; ?>">Importar</a></td>
                                        <td class="op">
                                           <div style="float: left; margin-right: 2px;"><a href="/vipmin/xml/edit.php?id=<?php echo $one['id']; ?>"><img alt="Editar" title="Editar" src="/media/css/i/editar.png" style="width: 22px;"></a></div>
                                           <div style="float: left; margin-right: 2px;"><a href="/ajax/manage.php?action=xmlremove&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="Você tem certeza que deseja apagar?" ><img alt="Excluir" title="Excluir" style="width: 17px;" src="/media/css/i/excluir.png"></a></div>
                                        </td>
                                     </tr>
                                     <?php
                                  }
                               }
                           ?>
                           <tr><td colspan="8"><?php echo $pagestring; ?></td></tr>
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
   function msg_edit(){
      jQuery.colorbox({html:"<div class='msgsoft'><img src='<?= $PATHSKIN ?>/images/ajax-loader2.gif'> Aguarde enquanto carregamos os dados...</div>"});
   }
</script>

<script>
   function msg(){
      return true;
   }
</script>
