<?php
	
	require_once(dirname(dirname(dirname(__FILE__))) . '/util/Util.php'  );
	require_once(dirname(dirname(dirname(__FILE__))) . '/app.php'  );
  
    if (isset($_POST)) {
	
       $idCliente = $_POST['cliente'];
       $randmax = $_POST['id_rand'];
       $idPedido = $_POST['pedido'];
       $valorPedido = $_POST['valor'];
       $bandeira = $_POST['bandeira'];
       $numero = $_POST['numero'];
       $validade = $_POST['validade'];
       $cvv = $_POST['cvv'];
       $parcelas = $_POST['parcelas'];
       $nome = $POST['nome'];
 
	   $cliente = Table::Fetch('user',$idCliente);
	  
       $cliente['mobile'] = '(00)0000-0000';
       
       $cliente['numero'] = $cliente['numero'];
       $cliente['complemento'] = '';

       $CEP = substr($cliente['zipcode'], 0, 5) . "-" . substr($cliente['zipcode'], 5, 3);
       //$CEP =  $cliente['cep'] ;

       $ch = curl_init();
	   
	   $chavetrans =  $INI['moip']['chavetrans'];
	   $tokentrans =  $INI['moip']['tokentrans'];
	   $urlmoip =  $INI['moip']['urlmoip'];
	   $site = utf8_decode($INI["system"]["sitename"]);
	   $preid = utf8_decode($INI["system"]["abbreviation"]);
	   
	   Util::log("Autenticacao: $tokentrans:$chavetrans");
	   Util::log("url moip: $urlmoip");
	   
       $header[] = "Authorization: Basic " . base64_encode("$tokentrans:$chavetrans");
	    
       $rand = rand(10000, 999999);
       //$randmax = mt_getrandmax();
       $options = array(CURLOPT_URL => $urlmoip,
	   
           CURLOPT_HTTPHEADER => $header,
           CURLOPT_SSL_VERIFYPEER => false,
           CURLOPT_POST => true,
           CURLOPT_POSTFIELDS => utf8_encode(
                   "
                 <EnviarInstrucao>
                  <InstrucaoUnica TipoValidacao='Transparente'>
                        <Razao>".$site."</Razao>
                        <Valores>
                              <Valor moeda='BRL'>{$valorPedido}</Valor>
                        </Valores>
                        <IdProprio>$idPedido-$preid-$randmax</IdProprio>
                        <Pagador>
                              <Nome>{$cliente['realname']}</Nome>
                              <Email>{$cliente['username']}</Email>
                              <IdPagador>{$cliente['id']}</IdPagador>
                              <EnderecoCobranca>
                                 <Logradouro>{$cliente['address']}</Logradouro>
                                 <Numero>{$cliente['numero']}</Numero>
                                 <Complemento>{$cliente['complemento']}</Complemento>
                                 <Bairro>{$cliente['bairro']}</Bairro>
                                 <Cidade>{$cliente['cidadeusuario']}</Cidade>
                                 <Estado>".strtoupper($cliente['estado'])."</Estado>
                                 <Pais>BRA</Pais>
                                 <CEP>{$CEP}</CEP>
                                 <TelefoneFixo>{$cliente['mobile']}</TelefoneFixo>
                              </EnderecoCobranca>
                        </Pagador>
                        <Parcelamentos>
                              <Parcelamento>
                                 <MinimoParcelas>1</MinimoParcelas>
                                 <MaximoParcelas>12</MaximoParcelas>
                                 <Juros>0.00</Juros>
                                 <Repassar>true</Repassar>
                              </Parcelamento>
                        </Parcelamentos>
                  </InstrucaoUnica>
               </EnviarInstrucao>
              "
           ),
           CURLOPT_RETURNTRANSFER => true
       );

       curl_setopt_array($ch, $options);

       // Executa cURL
       $response = curl_exec($ch);
	   Util::log("Retorno do Curl_Exec: ".$response);

       // Fecha coneçao cURL
       curl_close($ch);

       // Transforma string em elemento XML
       $xml = simplexml_load_string($response);

       // Acessa XML e pega "Token de Pagamento"
       $payment_token = $xml->Resposta->Token;
       $Status = $xml->Resposta->Status;
       $Erro = $xml->Resposta->Erro;

	   echo trim($Status."#".$Erro."#".$payment_token);
		 
       //echo $payment_token;
    }
?>