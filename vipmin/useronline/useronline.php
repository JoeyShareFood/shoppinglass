<?php
 
class users
{
    var $users; // Array que tem como �ndices os ips e armazema o tempo.

    /**
     * Fun��o que adiciona novo ip ao array $users e remove todos os ips que expiraram.
     * Nesse exemplo o tempo de um minuto
     */
   function adduser($ip)
   {
      $this->users[$ip] = time(); // Cria um novo �ndice no array e 
                                  // com tempo que ele foi criado
      $timeout = time() - 60;
      $keys = array_keys($this->users);
      $total = 0; // Vari�vel que armazena o n�mero de usu�rios online no momento
      for ($i = 0; $i < sizeof($keys); $i++) {
         $x = $keys[$i];
         if ($this->users[$x] > $timeout) {
            $str[$x] = $this->users[$x];
            $total++;
         }
      }
      $this->users = $str;
      return $total;
   }
}
session_id("contador"); // Nome da sess�o
session_start(); // Inicializa a sess�o
//$_SESSION['cont']  ; // Cria a variavel $cont se ela n�o existir
if (!isset($cont)) { // Se o objeto n�o foi inicializado, ele � criado.
   $cont = new users;
}
$ip = getenv("REMOTE_ADDR"); // IP do usuario
echo "document.write(\"Usuarios online no momento : ";
echo $cont->adduser($ip);
echo "\");";
?>