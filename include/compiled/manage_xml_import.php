<?php include template("manage_header"); ?>
<div id="bdw" class="bdw">
   <div id="bd" class="cf">
      <div id="coupons">
         <div id="content" class="coupons-box clear mainwide">
            <div class="box clear">
               <div class="box-content">
                  <div class="option_box">
                     <div class="top-heading group"> <div class="left_float"><h4>Importar Ofertas</h4></div>
                        <div style="padding: 10px;">
                           <ul id="log_tools"> <li id="log_switch_referral"><a title="Cadastrar Site" id="executaImportacao" href="#">Importar</a></li></ul>
                        </div>
                     </div>
                     <div class="paginacaotop"><?php echo $pagestring; ?></div>
                     <div class="sect" style="clear:both;">
                        <form method="post" action="" id="formularioOfertas" name="formularioImportacao">
                           <input type="hidden" value="true" name="run"/>
                           <table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
                              <tr>
                                 <th width="20">Importar Oferta</th>
                                 <th width="20">ID</th>
                                 <th >Titulo</th>
                                 <th width="100">Preço Oferta</th>
                                 <tr>
                                 <td><input type="checkbox" name="todos" value="on"/></td>
                                 <td></td><td>Importar todas ofertas</td><td></td>
                                 </tr>
                                 <?php if (is_array($ofertas)) {
                                        foreach ($ofertas AS $index => $one) {
                                           ?>
                                        <tr <?php echo $index % 2 ? '' : 'class="alt"'; ?>>
                                           <td><input type="checkbox" name="importar[]" value="<?php echo $one[$config['oferta_id']]; ?>"></td>
                                           <td><?php echo $one[$config['oferta_id']]; ?></td>
                                           <td><?php echo $one[$config['oferta_titulo']]; ?></td>
                                           <td><?php echo $one[$config['oferta_preco']]; ?></td>
                                        </tr>
                                        <?php
                                     }
                                  }
                              ?>
                              <tr><td colspan="8"><?php echo $pagestring; ?></td></tr>
                           </table>
                        </form>
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
   jQuery(document).ready(function() {
      $('#executaImportacao').bind('click', function(ev) {
         ev.preventDefault();
         jQuery('#formularioOfertas').submit();
      })
   });
</script>
