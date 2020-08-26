<pre>
   <?php

       /**
        * CLASSES
        */
       class xmlHandler {

          private $url;
          private $buff = Array();
          private $xml;
          private $array;

          public function __construct($url) {
             if (is_null($url))
                $url = 'http://www.grupara.com.br/agregadores/xml/agrupi.xml';
             $ch = curl_init();
             curl_setopt($ch, CURLOPT_URL, $url);
             curl_setopt($ch, CURLOPT_TIMEOUT, 180);
             curl_setopt($ch, CURLOPT_HEADER, 0);
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
             curl_setopt($ch, CURLOPT_POST, 1);
             curl_setopt($ch, CURLOPT_POSTFIELDS, $urlstring);
             $data = curl_exec($ch);
             curl_close($ch);
             $this->xml = simplexml_load_string($data);
             $toArray = new xmlToArray($data);
             $array = $this->array = $toArray->array;
             $this->foreach_loop($array);
          }

          private function foreach_loop($array) {
             foreach ($array as $key => $value) {
                if (!is_array($value)) { // if it isn't an array show $key and $value
                   $this->buff[$key] = $value;
                } else {  //if it is an array -> show $key -> then process $value again will same function.
                   $this->foreach_loop($value);
                }
             }
          }

          public function printArray() {
             print_r($this->array);
          }

          public function printXml() {
             print_r($this->xml);
          }

          public function printBuff() {
             print_r($this->buff);
          }

          public function getBuff() {
             return $this->buff;
          }

          public function getArray() {
             return $this->array;
          }

       }

       class xmlToArray {

          /**
           * The array which is built from the data supplied in the XML string
           *
           * @access public
           * @var array
           */
          public $array = array();

          /**
           * Collapses single array elements
           *
           * This method scans an array for collapsable elements. An element is collapsable if it
           * contains an indexed array holding only a single element. For example, if a Person only
           * has one BirthDate, $array['People']['Person'][4]['BirthDate'][0] becomes
           * $array['People']['Person'][4]['BirthDate']. This should be called recursively so that
           * all levels of the array will be collapsed (as is done by the _worker() method).
           *
           * @access private
           * @param array $array The array which is to be collapsed
           * @return array The collapsed array
           */
          private function _collapse($array) {
             foreach ($array as $tag => $data) {
                if (is_array($data) && (count($data) == 1)) {
                   $array[$tag] = $data[0];
                }
             }
             return $array;
          }

          /**
           * Worker method
           *
           * This method recursively walks the output of xml_parse_into_struct(), creating a
           * threaded associative array.
           *
           * @access private
           * @param array $a_values A "values" array created by xml_parse_into_struct()
           * @param boolean $collapse True if the array should be collapsed
           * @return array The resulting multi-level array
           */
          private function _worker(&$a_values, $collapse) {
             while ($element = array_shift($a_values)) {
                switch ($element['type']) {
                   case 'open':
                      $array[$element['tag']][] = $this->_worker($a_values, $collapse);
                      break;
                   case 'complete':
                      if (isset($element['value'])) {
                         $array[$element['tag']][] = $element['value'];
                      }
                      break;
                   case 'close':
                      return $collapse ? $this->_collapse($array) : $array;
                }
             }
             return $collapse ? $this->_collapse($array) : $array;
          }

          /**
           * Constructor
           *
           * The constructor takes the input XML string and builds an associative array out of it
           *
           * @access public
           * @param string $xml_string The input string in XML format
           * @param boolean $collapse True if the array should be collapsed
           */
          public function __construct($xml_string, $collapse = true) {
             xml_parse_into_struct($xml_parser = xml_parser_create(), $xml_string, $a_values);
             xml_parser_free($xml_parser);
             $this->array = $this->_worker($a_values, $collapse);
          }

       }

       /**
        *FUNCOES
        */
       $ofertas = Array();
       function findRoot($array, $haystack) {
          global $ofertas;
            //echo "Haystack: $haystack<br/>".PHP_EOL;
             foreach ($array as $key => $value) {
                //echo "Chave: $key | Valor: $value <br/>".PHP_EOL;
                if ($key == $haystack) {
                   $ofertas = $value;
                } else if (is_array($value)) {
                   findRoot($value, $haystack);
                }
             }
          }

       //PEGAR URL PELO POST
       $handler = new xmlHandler(null);
   ?>
    <form method="post" action="">
         <table style="border: 1px solid #000; border-collapse: collapse;">
            <thead style="border: 1px solid #000; border-collapse: collapse;">
               <th style="border: 1px solid #000; border-collapse: collapse;">Marque para usar</th>
               <th style="border: 1px solid #000; border-collapse: collapse;">Campo</th>
               <th style="border: 1px solid #000; border-collapse: collapse;">Valor</th>
               <th style="border: 1px solid #000; border-collapse: collapse;">Usar para</th>
            </thead>
            <tbody>
            <?php
                foreach ($handler->getBuff() as $campo => $valor) {
                   echo "<tr style=\"border: 1px solid #000; border-collapse: collapse;\">";
                   echo "<td style=\"border: 1px solid #000; border-collapse: collapse;\"><input type='checkbox' name='{$campo}' /></td>";
                   echo "<td style=\"border: 1px solid #000; border-collapse: collapse;\">{$campo}</td>";
                   echo "<td style=\"border: 1px solid #000; border-collapse: collapse;\">{$valor}</td>";
                   ?>
                                                                           <td style="border: 1px solid #000; border-collapse: collapse;">
                                                                           <select name="use_for_<?php echo $campo; ?>">
                                                                           <option value="idoferta">ID da Oferta</option>
                                                                           <option value="titulo">Titulo</option>
                                                                           <option value="descricao">Descricao</option>
                                                                           <option value="datainicio">Data Inicio</option>
                                                                           <option value="datafinal">Data Final</option>
                                                                           <option value="dataexpiration">Data Expiração</option>
                                                                           <option value="avisos">Avisos</option>
                                                                           <option value="preconormal">Preço Normal</option>
                                                                           <option value="precooferta">Preço Oferta</option>
                                                                           <option value="urloferta">URL Oferta</option>
                                                                           <option value="urllogo">URL Logo</option>
                                                                           <option value="siteoferta">Site da Oferta</option>
                                                                        </select>
                                                                      </td>
                <?php
             }
         ?>
            </tbody>
         </table>
       <input type="hidden" name="acao" value="campos">
       <input type="submit" value="Executar" />
       </form>
   <?php
       if (isset($_POST)) {
          if ($_POST['acao'] == "campos") {
             $campos = Array();
             foreach ($_POST as $chave => $post) {
                if ($post == 'on') {
                   $usefor = $_POST['use_for_' . $chave];
                   $campos[$chave] = $usefor;
                }
             }
             if (sizeof($campos) > 0) {
                //print_r($campos);
                findRoot($handler->getArray(), "OFERTA");
                echo "Ofertas:<br/>";
                //print_r($ofertas);
                if (sizeof($ofertas) > 0) {
                   echo "<TABLE>".PHP_EOL;
                   echo "<THEAD>".PHP_EOL;
                   foreach ($campos as $key => $value) {
                      echo "<TH>{$value}</TH>".PHP_EOL;
                   }
                   echo "</THEAD>".PHP_EOL;
                   echo "<TBODY>".PHP_EOL;
                   foreach ($ofertas as $offer) {
                      echo "<TR>";
                      foreach($campos as $key => $value) {
                         echo "<TD>$offer[$key]</TD>".PHP_EOL;
                      }
                      echo "</TR>";
                   }
                   echo "</TBODY>".PHP_EOL;
                   echo "</TABLE>".PHP_EOL;
                }
             }
             ?>

             <?
          }
       }
   ?>