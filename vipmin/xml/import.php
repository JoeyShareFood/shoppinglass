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
     * FUNCOES
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

?>
<?php

    require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

    need_manager();
    need_auth('market');

    $id = $_GET['id'];
    $config = Table::Fetch('sites', $id);

    if (!empty($config)) {
       $edicao = true;
    }

    if (!$edicao) {
       Session::Set('notice', 'Site não importado ou erro no site, informe o suporte');
       redirect(WEB_ROOT . "/vipmin/xml/index.php");
    } else { // edicao
       $xml = new xmlHandler($config['xml']);
       findRoot($xml->getArray(), $config['raiz_ofertas']);
       include template('manage_xml_import');
       if (isset($_POST['run'])) {
          $dados = Array();
          $existia = Array();
          foreach ($ofertas as $oferta) {
             if (in_array($oferta[$config['oferta_id']], $_POST['importar']) || $_POST['todos'] == 'on') {
                $existe = mysql_fetch_row(mysql_query("SELECT * FROM team WHERE id_oferta_parceiro = {$oferta[$config['oferta_id']]}"));
                if (!is_array($existe)) {
                   if (isset($config['oferta_id']) && $config['oferta_id'] != '')
                      $dados['id_oferta_parceiro'] = $oferta[$config['oferta_id']];

                   if (isset($config['oferta_titulo']) && $config['oferta_titulo'] != '')
                      $dados['title'] = $oferta[$config['oferta_titulo']];

                   if (isset($config['oferta_preco']) && $config['oferta_preco'] != '')
                      $dados['team_price'] = $oferta[$config['oferta_preco']];

                   if (isset($config['oferta_precomercado']) && $config['oferta_precomercado'] != '')
                      $dados['market_price'] = $oferta[$config['oferta_precomercado']];

                   if (isset($config['oferta_descricao']) && $config['oferta_descricao'] != '')
                      $dados['summary'] = $oferta[$config['oferta_descricao']];

                   if (isset($config['oferta_imagem']) && $config['oferta_imagem'] != '')
                      $dados['image'] = $oferta[$config['oferta_imagem']];

                   if (isset($config['oferta_url']) && $config['oferta_url'] != '')
                      $dados['url_comprar'] = $oferta[$config['oferta_url']];

                   $dados['city_id'] = $config['oferta_cidade'];
                   $dados['begin_time'] = time();
                   $dados['expire_time'] = strtotime('+1 week');
                   $dados['end_time'] = strtotime('+1 week');
                   $dados['user_id'] = $_SESSION['user_id'];

                   $Table = new Table('team', $dados);
                   $uArray = Array();

                   foreach ($dados as $key => $value) {
                      $uArray[] = $key;
                   }

                   $flag = $Table->insert($uArray);
                   if (!$flag) {
                      $string = 'Erro na importação das ofertas';
                      Session::Set('notice', $string);
                      redirect(WEB_ROOT . "/vipmin/xml/index.php");
                   }
                } else {
                   $existia[] = $oferta[$config['oferta_id']];
                }
             }
          }
          $string = 'Ofertas importadas com sucesso!';
          Session::Set('notice', $string);
          redirect(WEB_ROOT . "/vipmin/xml/index.php");
       }
    }