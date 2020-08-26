<?php include template("manage_header"); ?>
<?php require("ini.php"); ?>

<script type="text/javascript" src="/media/js/tinymce_pt/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="/media/js/tinymce_pt/jscripts/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php"></script>
<script src="/media/js/include_tinymce.js" type="text/javascript"></script>

<div id="bdw" class="bdw">
   <div id="bd" class="cf">
      <div id="leader">
         <div id="content" class="clear mainwide">
            <div class="clear box">
               <div class="box-content">
                  <div class="sect">
                     <form id="login-user-form" method="post" action="/vipmin/xml/edit.php?id=<?php echo $category['id']; ?>" enctype="multipart/form-data" class="validator">
                        <input type="hidden" name="id" value="<?php echo $category['id']; ?>" />
                        <input type="hidden" name="user" value="" />
                        <input type="hidden" name="www" id="www"  value="<?= $INI['system']['wwwprefix'] ?>" />
                        <div class="option_box">
                           <div class="top-heading group">
                              <div class="left_float"><h4>Informações do Site <?php echo $category['titulo']; ?></h4></div>
                              <div class="the-button">
                                 <input type="hidden" value="remote" id="deliverytype" name="deliverytype">
                                 <button onclick="doupdate();" id="run-button" class="input-btn" type="button">
                                    <div name="spinner-top" id="spinner-top" style="width: 83px; display: block;"><img name="imgrec" id="imgrec" src="<?= $ROOTPATH ?>/media/css/i/lendo.gif" style="display: none;"></div>
                                    <div id="spinner-text">Salvar</div>
                                 </button>
                              </div>
                           </div>
                           <div id="container_box">
                              <div id="option_contents" class="option_contents">
                                 <div class="form-contain group">
                                    <!-- =============================   coluna esquerda   =====================================-->
                                    <div class="starts">
                                       <div style="clear:both;"class="report-head">Titulo: <span class="cpanel-date-hint"></span></div>
                                       <div class="group">
                                          <input type="text" name="titulo" maxlength="255" id="name" class="format_input ckeditor" value="<?php echo $category['titulo'] ?>" />
                                       </div>

                                       <div style="clear:both;"class="report-head">Endereço do Site: <span class="cpanel-date-hint">O endereço do site. Ex: http://www.comprascoletivas.com.br</span></div>
                                       <div class="group">
                                          <input type="text" name="endereco" maxlength="255" id="name" class="format_input ckeditor" value="<?php echo $category['endereco'] ?>" />
                                       </div>

                                       <div style="clear:both;"class="report-head">Endereço do XML: <span class="cpanel-date-hint">Exemplo: www.groupbuying.com/xml/ofertas.xml</span></div>
                                       <div class="group">
                                          <input type="text" name="xml" maxlength="255" id="name" class="format_input ckeditor" value="<?php echo $category['xml'] ?>" />
                                       </div>

                                       <div class="report-head">Cidade das Ofertas: <span class="cpanel-date-hint">Deixe em branco para todas as cidades</span></div>
                                       <div class="group">
                                          <div class="cjt-wrapped-select" id="type-select-cjt-wrapped-select">
                                             <select  name="oferta_cidade" id="oferta_cidade" onchange="$('#select_oferta_cidade').text($('#oferta_cidade').find('option').filter(':selected').text())">
                                                <option value="0">Todas as cidades</option>
                                                <?php
                                                    $sql = "SELECT * FROM category WHERE zone = 'city' ORDER BY name ASC";
                                                    $rs = mysql_query($sql);
                                                    while ($l = mysql_fetch_array($rs, MYSQL_ASSOC)) {
                                                       $selected = "";
                                                       if ($category['oferta_cidade'] == $l['id']) {
                                                          $selected = " selected ";
                                                          $tmp_cidade = $l['name'];
                                                       }
                                                       echo "<option value='{$l[id]}' $selected>{$l['name']}</option>";
                                                    }
                                                ?>
                                             </select>
                                             <div name="select_oferta_cidade" id="select_oferta_cidade" class="cjt-wrapped-select-skin"><?php if (isset($tmp_cidade)) echo $tmp_cidade; else echo "Todas as cidades"; ?></div>
                                             <div class="cjt-wrapped-select-icon"></div>
                                          </div>
                                       </div>

                                       <div style="clear:both;"class="report-head">Dados de URL: <span class="cpanel-date-hint">Dados que vão ser enviados junto na url da oferta. Ex: ?idaffiliatte=009</span></div>
                                       <div class="group">
                                          <input type="text" name="dadosurl" maxlength="255" id="dadosurl" class="format_input ckeditor" value="<?php echo $category['dadosurl'] ?>" />
                                       </div>

                                       <div style="clear:both;"class="report-head">Raiz das Ofertas: <span class="cpanel-date-hint">Tag na qual as ofertas ficam, atenção, maisc. e minus. são diferentes. Ex: OFERTAS</span></div>
                                       <div class="group">
                                          <input type="text" name="raiz_ofertas" maxlength="255" id="raiz_ofertas" class="format_input ckeditor" value="<?php echo $category['raiz_ofertas'] ?>" />
                                       </div>
                                    </div>
                                    <!-- =============================   fim coluna esquerda   =====================================-->
                                    <!-- =============================   coluna direita   =====================================-->
                                    <div class="ends">
                                       <?php
                                           if ($edicao && $category['xml'] != '') {
                                              include('/include/xml/handler.php');
                                              $handler = new xmlHandler($category['xml']);
                                              ?>
                                              <div class="report-head">ID da Oferta: <span class="cpanel-date-hint">ID única da oferta no seu sistema</span></div>
                                              <div class="group">
                                                 <div class="cjt-wrapped-select" id="type-select-cjt-wrapped-select">
                                                    <select  name="oferta_id" id="oferta_id" onchange="$('#select_oferta_id').text($('#oferta_id').find('option').filter(':selected').text())">
                                                       <option value=""></option>
                                                       <?php
                                                       foreach ($handler->getBuff() as $campo => $valor) {
                                                          if ($campo == $category['oferta_id'])
                                                             echo "<option value='{$campo}' selected>{$campo}</option>";
                                                          else
                                                             echo "<option value='{$campo}'>{$campo}</option>";
                                                       }
                                                       ?>
                                                    </select>
                                                    <div name="select_oferta_id" id="select_oferta_id" class="cjt-wrapped-select-skin"><?php if (isset($category['oferta_id'])) echo $category['oferta_id']; else echo "Informe a chave"; ?></div>
                                                    <div class="cjt-wrapped-select-icon"></div>
                                                 </div>
                                              </div>

                                              <div class="report-head">Título da Oferta: <span class="cpanel-date-hint">Título da Oferta</span></div>
                                              <div class="group">
                                                 <div class="cjt-wrapped-select" id="type-select-cjt-wrapped-select">
                                                    <select  name="oferta_titulo" id="oferta_titulo" onchange="$('#select_oferta_titulo').text($('#oferta_titulo').find('option').filter(':selected').text())">
                                                       <option value=""></option>
                                                       <?php
                                                       foreach ($handler->getBuff() as $campo => $valor) {
                                                          if ($campo == $category['oferta_titulo'])
                                                             echo "<option value='{$campo}' selected>{$campo}</option>";
                                                          else
                                                             echo "<option value='{$campo}'>{$campo}</option>";
                                                       }
                                                       ?>
                                                    </select>
                                                    <div name="select_oferta_titulo" id="select_oferta_titulo" class="cjt-wrapped-select-skin"><?php if (isset($category['oferta_titulo'])) echo $category['oferta_titulo']; else echo "Informe a chave"; ?></div>
                                                    <div class="cjt-wrapped-select-icon"></div>
                                                 </div>
                                              </div>

                                              <div class="report-head">Descrição da Oferta: <span class="cpanel-date-hint">Descrição da Oferta</span></div>
                                              <div class="group">
                                                 <div class="cjt-wrapped-select" id="type-select-cjt-wrapped-select">
                                                    <select  name="oferta_descricao" id="oferta_descricao" onchange="$('#select_oferta_descricao').text($('#oferta_descricao').find('option').filter(':selected').text())">
                                                       <option value=""></option>
                                                       <?php
                                                       foreach ($handler->getBuff() as $campo => $valor) {
                                                          if ($campo == $category['oferta_descricao'])
                                                             echo "<option value='{$campo}' selected>{$campo}</option>";
                                                          else
                                                             echo "<option value='{$campo}'>{$campo}</option>";
                                                       }
                                                       ?>
                                                    </select>
                                                    <div name="select_oferta_descricao" id="select_oferta_descricao" class="cjt-wrapped-select-skin"><?php if (isset($category['oferta_descricao'])) echo $category['oferta_descricao']; else echo "Informe a chave"; ?></div>
                                                    <div class="cjt-wrapped-select-icon"></div>
                                                 </div>
                                              </div>

                                              <div class="report-head">Preço da Oferta: <span class="cpanel-date-hint">Preço que será cobrado quando a oferta for vendida</span></div>
                                              <div class="group">
                                                 <div class="cjt-wrapped-select" id="type-select-cjt-wrapped-select">
                                                    <select  name="oferta_preco" id="oferta_preco" onchange="$('#select_oferta_preco').text($('#oferta_preco').find('option').filter(':selected').text())">
                                                       <option value=""></option>
                                                       <?php
                                                       foreach ($handler->getBuff() as $campo => $valor) {
                                                          if ($campo == $category['oferta_preco'])
                                                             echo "<option value='{$campo}' selected>{$campo}</option>";
                                                          else
                                                             echo "<option value='{$campo}'>{$campo}</option>";
                                                       }
                                                       ?>
                                                    </select>
                                                    <div name="select_oferta_preco" id="select_oferta_preco" class="cjt-wrapped-select-skin"><?php if (isset($category['oferta_preco'])) echo $category['oferta_preco']; else echo "Informe a chave"; ?></div>
                                                    <div class="cjt-wrapped-select-icon"></div>
                                                 </div>
                                              </div>

                                              <div class="report-head">Preço de Mercado: <span class="cpanel-date-hint">Preço praticado normalmente no mercado</span></div>
                                              <div class="group">
                                                 <div class="cjt-wrapped-select" id="type-select-cjt-wrapped-select">
                                                    <select  name="oferta_precomercado" id="oferta_precomercado" onchange="$('#select_oferta_precomercado').text($('#oferta_precomercado').find('option').filter(':selected').text())">
                                                       <option value=""></option>
                                                       <?php
                                                       foreach ($handler->getBuff() as $campo => $valor) {
                                                          if ($campo == $category['oferta_precomercado'])
                                                             echo "<option value='{$campo}' selected>{$campo}</option>";
                                                          else
                                                             echo "<option value='{$campo}'>{$campo}</option>";
                                                       }
                                                       ?>
                                                    </select>
                                                    <div name="select_oferta_precomercado" id="select_oferta_precomercado" class="cjt-wrapped-select-skin"><?php if (isset($category['oferta_precomercado'])) echo $category['oferta_precomercado']; else echo "Informe a chave"; ?></div>
                                                    <div class="cjt-wrapped-select-icon"></div>
                                                 </div>
                                              </div>

                                              <div class="report-head">Imagem da Oferta: <span class="cpanel-date-hint">O caminho para a imagem que será mostrada na oferta</span></div>
                                              <div class="group">
                                                 <div class="cjt-wrapped-select" id="type-select-cjt-wrapped-select">
                                                    <select  name="oferta_imagem" id="oferta_imagem" onchange="$('#select_oferta_imagem').text($('#oferta_imagem').find('option').filter(':selected').text())">
                                                       <option value=""></option>
                                                       <?php
                                                       foreach ($handler->getBuff() as $campo => $valor) {
                                                          if ($campo == $category['oferta_imagem'])
                                                             echo "<option value='{$campo}' selected>{$campo}</option>";
                                                          else
                                                             echo "<option value='{$campo}'>{$campo}</option>";
                                                       }
                                                       ?>
                                                    </select>
                                                    <div name="select_oferta_imagem" id="select_oferta_imagem" class="cjt-wrapped-select-skin"><?php if (isset($category['oferta_imagem'])) echo $category['oferta_imagem']; else echo "Informe a chave"; ?></div>
                                                    <div class="cjt-wrapped-select-icon"></div>
                                                 </div>
                                              </div>

                                              <div class="report-head">Link da Oferta: <span class="cpanel-date-hint">Link para onde o cliente será redirecionado</span></div>
                                              <div class="group">
                                                 <div class="cjt-wrapped-select" id="type-select-cjt-wrapped-select">
                                                    <select  name="oferta_site" id="oferta_site" onchange="$('#select_oferta_site').text($('#oferta_site').find('option').filter(':selected').text())">
                                                       <option value=""></option>
                                                       <?php
                                                       foreach ($handler->getBuff() as $campo => $valor) {
                                                          if ($campo == $category['oferta_site'])
                                                             echo "<option value='{$campo}' selected>{$campo}</option>";
                                                          else
                                                             echo "<option value='{$campo}'>{$campo}</option>";
                                                       }
                                                       ?>
                                                    </select>
                                                    <div name="select_oferta_site" id="select_oferta_site" class="cjt-wrapped-select-skin"><?php if (isset($category['oferta_site'])) echo $category['oferta_site']; else echo "Informe a chave"; ?></div>
                                                    <div class="cjt-wrapped-select-icon"></div>
                                                 </div>
                                              </div>

                                              <div class="report-head">URL do Parceiro: <span class="cpanel-date-hint">Link para onde o cliente será redirecionado</span></div>
                                              <div class="group">
                                                 <div class="cjt-wrapped-select" id="type-select-cjt-wrapped-select">
                                                    <select  name="oferta_url" id="oferta_url" onchange="$('#select_oferta_url').text($('#oferta_url').find('option').filter(':selected').text())">
                                                       <option value=""></option>
                                                       <?php
                                                       foreach ($handler->getBuff() as $campo => $valor) {
                                                          if ($campo == $category['oferta_url'])
                                                             echo "<option value='{$campo}' selected>{$campo}</option>";
                                                          else
                                                             echo "<option value='{$campo}'>{$campo}</option>";
                                                       }
                                                       ?>
                                                    </select>
                                                    <div name="select_oferta_url" id="select_oferta_url" class="cjt-wrapped-select-skin"><?php if (isset($category['oferta_url'])) echo $category['oferta_url']; else echo "Informe a chave"; ?></div>
                                                    <div class="cjt-wrapped-select-icon"></div>
                                                 </div>
                                              </div>

                                              <div class="report-head">Logo do Parceiro: <span class="cpanel-date-hint">Link para onde o cliente será redirecionado</span></div>
                                              <div class="group">
                                                 <div class="cjt-wrapped-select" id="type-select-cjt-wrapped-select">
                                                    <select  name="oferta_logo" id="oferta_logo" onchange="$('#select_oferta_logo').text($('#oferta_logo').find('option').filter(':selected').text())">
                                                       <option value=""></option>
                                                       <?php
                                                       foreach ($handler->getBuff() as $campo => $valor) {
                                                          if ($campo == $category['oferta_logo'])
                                                             echo "<option value='{$campo}' selected>{$campo}</option>";
                                                          else
                                                             echo "<option value='{$campo}'>{$campo}</option>";
                                                       }
                                                       ?>
                                                    </select>
                                                    <div name="select_oferta_logo" id="select_oferta_logo" class="cjt-wrapped-select-skin"><?php if (isset($category['oferta_logo'])) echo $category['oferta_logo']; else echo "Informe a chave"; ?></div>
                                                    <div class="cjt-wrapped-select-icon"></div>
                                                 </div>
                                              </div>
    <?php } ?>
                                    </div>
                                    <!-- =============================  fim coluna direita  =====================================-->
                                 </div>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <script>

      function validador(){

         limpacampos();

         if( jQuery("#name").val()==""){

            campoobg("name");
            alert("Por favor, informe o nome da <?php echo $tipo; ?>");
            jQuery("#name").focus();
            return false;
         }
         return true;
      }


      if( jQuery("#id").val() ==""){

      }
      else{

         $('#select_idpai').text($('#idpai').find('option').filter(':selected').text());
      }


   </script>