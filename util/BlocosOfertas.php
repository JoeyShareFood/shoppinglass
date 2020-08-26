<?php

class BlocosOfertas{
  	
	public $ofertadestaqueprincipal;	
	public $nomeurl; 		
	public $descricao; 	
	public $economia; 	
	public $porcentagem; 	
	public $linkoferta; 	
	public $tituloferta; 	
	public $imagemoferta;        
	public $id;			 
	public $detalhe_oferta; 
	public $url_comprar; 
	public $metodo_pagamento; 
	public $bonuslimite;		 
	public $fim_oferta;		 
	public $inicio_oferta;	 
	public $tipo_oferta;		 
	public $obs_pagamento;	 
	public $venda_maxima;		 
	public $minimo_pessoa;	 
	public $minimo_ativar;	 
	public $id_parceiro;		 
	public $preco_comissao;	 
	public $id_categoria;		 
	public $id_cidade;		 
	public $layout;			 
	public $vendidos;			 
	public $preco;			 
	public $processo_compra;			 
	public $preco_antigo;		  
	public $pre_number;		 
	public $per_number;		 
	public $imagemoferta2;
	public $imagemoferta3;
	public $imagemoferta4;
	public $imagemoferta5;
	public $imagemoferta6;
	public $imagemoferta7;
	public $imagemoferta8;	
	public $imagemoferta9;	
	public $tambarraprogresso;	
	public $porcentoarrecadado;	
	public $oferta_ativa;	
	public $titulofertaresumo;	
	public $republicacao;	
	public $pontos;	
	public $pontosgerados;	
	public $desconto;	
	public $observacao_preco;	
	public $seo_keyword;	
	public $seo_description;	
	
	public function getDados($team,$nm_imagem=false){
  
		global $INI,$PATHSKIN;
		
		$this->id 				= $team['id'];
		$this->pontosgerados  	= number_format($team['pontosgerados'],null,"",".") ;
		$this->pontos 		 	= number_format($team['pontos'],null,"",".") ;
		$this->oferta_ativa 	= false; 
		$this->detalhe_oferta	= $team['notice']; 
		$this->republicacao		= $team['republicacao']; 
		$this->metodo_pagamento	= $team['metodo_pagamento']; 
		$this->bonuslimite		= $team['bonuslimite']; 
		$this->fim_oferta		= $team['end_time']; 
		$this->inicio_oferta	= $team['begin_time']; 
		$this->tipo_oferta		= $team['team_type']; 
		$this->obs_pagamento	= $team['detail']; 
		$this->venda_maxima		= $team['max_number'];
		$this->url_comprar		= $team['url_comprar'];
		$this->processo_compra	= $team['processo_compra'];
		$this->minimo_pessoa	= $team['minimo_pessoa'];
		$this->minimo_ativar	= $team['min_number'];
		$this->id_parceiro		= $team['partner_id']; 
		$this->id_categoria		= $team['group_id'];
		$this->id_cidade		= $team['city_id'];
		$this->layout			= $team['layout'];
		$this->vendidos			= $team['now_number'];
		$this->observacao_preco	 = utf8_decode($team['observacao_preco']);
		$this->pre_number		= $team['pre_number']; 
		$this->per_number		= $team['per_number']; 
		$this->seo_keyword		= $team['seo_keyword']; 
		$this->seo_description  = $team['seo_description']; 
	  
		$this->restante			= $team['max_number'] - $team['now_number'];
		$this->disponibilidade	 = "<div class='dispo'> Em estoque</div>"; 
		$this->verificatipo($team);
	
		$this->nomeurl 			= urlamigavel(tratanome($team['title']));
		$this->descricao 		= substr($team['summary'],0,200)."...";
		$this->linkoferta 		= $this->getLinkOferta($team); 
		$this->tituloferta 		= utf8_decode($team['title']);
		$this->titulofertaresumido 	 = utf8_decode(ucwords(strtolower($team['titleresumido'])));

		if($team['titleresumido']==""){
			$this->titulofertaresumido = utf8_encode(substr($this->tituloferta,0,46) ."...") ;
		}
		 
		$this->oferta_esgotada	=	false;
		$this->oferta_cancelada	=	false;
		$this->preco_comissao   = number_format($team['preco_comissao'],2, ',', '.'); 
		$esgotado 				=	false;
		$end_time 				= 	date('YmdHis', $team['end_time']); 
		$date 					= 	date('YmdHis');
	 
	 	if($team['preco_comissao']!="" and $team['preco_comissao']!="0.00" ){
			$this->precovirtual		= $this->preco_comissao;
		}
		else{
			$this->precovirtual		= $this->preco;
		}
		
		/*
		if( $team['max_number']==0){
			$this->disponibilidade="<span class='indispo' style='color:#EE2D2F'> Esgotado</span>";
			$this->oferta_esgotada=true;
		}
		else if((int)$this->vendidos >= (int)$this->venda_maxima){
				$this->oferta_esgotada=true;
				$this->disponibilidade="<span class='indispo' style='color:#EE2D2F'> Esgotado</span>";
		} 
		*/

		if(checkStock($team['id']) == 0) {
			
			$this->disponibilidade = "<span class='indispo' style='color:#EE2D2F'> Esgotado</span>";
			$this->oferta_esgotada = true;	
			
			unset($sql_o, $rs_o, $row_o);
		}
		
		if( $end_time  < $date){
			$this->oferta_cancelada=true;
		}
			
		if(!$this->oferta_esgotada and !$this->oferta_cancelada and (int)$this->vendidos >= (int)$this->minimo_ativar){
			$this->oferta_ativa 	= true;
		}
		$this->desconto	=  round(100 - $team['team_price']/$team['market_price']*100,0);
		
		
		$this->imagemoferta 	= ""; 
		$this->imagemoferta2 	= ""; 
		$this->imagemoferta3 	= ""; 
		$this->imagemoferta4 	= ""; 
		$this->imagemoferta5 	= ""; 
		$this->imagemoferta6 	= ""; 
		$this->imagemoferta7 	= ""; 
		$this->imagemoferta8 	= ""; 
		$this->imagemoferta9 	= ""; 
		$this->imagemoferta10 	= ""; 
		$this->imagemoferta11 	= ""; 		
		
		$this->imagemofertathumb 	= ""; 
		$this->imagemoferta2thumb 	= ""; 
		$this->imagemoferta3thumb 	= ""; 
		$this->imagemoferta4thumb 	= ""; 
		$this->imagemoferta5thumb 	= ""; 
		$this->imagemoferta6thumb 	= ""; 
		$this->imagemoferta7thumb 	= ""; 
		$this->imagemoferta8thumb 	= ""; 
		$this->imagemoferta9thumb 	= ""; 
		$this->imagemoferta10thumb 	= ""; 
		$this->imagemoferta11thumb 	= ""; 
		
		$nm_imagem="";
		
		/*
		if($nm_imagem){
		    if($team['image']){
				$this->imagemoferta 	= $INI['system']['wwwprefix']."/media/".substr($team['image'],0,-4)."_".$nm_imagem; 
				$this->imagemofertathumb 	= $INI['system']['wwwprefix']."/media/".substr($team['image'],0,-4)."_popular_mini.jpg";
			}
			if($team['image1']){
				$this->imagemoferta2 	= $INI['system']['wwwprefix']."/media/".substr($team['image1'],0,-4)."_".$nm_imagem;
				$this->imagemoferta2thumb 	= $INI['system']['wwwprefix']."/media/".substr($team['image1'],0,-4)."_popular_mini.jpg";
			}
			if($team['image2']){
				$this->imagemoferta3 	= $INI['system']['wwwprefix']."/media/".substr($team['image2'],0,-4)."_".$nm_imagem;
				$this->imagemoferta3thumb 	= $INI['system']['wwwprefix']."/media/".substr($team['image2'],0,-4)."_popular_mini.jpg";
			}
			if($team['gal_image1']){
				$this->imagemoferta4 	= $INI['system']['wwwprefix']."/media/".substr($team['gal_image1'],0,-4)."_".$nm_imagem;
				$this->imagemoferta4thumb 	= $INI['system']['wwwprefix']."/media/".substr($team['gal_image1'],0,-4)."_popular_mini.jpg";
			}
			if($team['gal_image2']){
				$this->imagemoferta5 	= $INI['system']['wwwprefix']."/media/".substr($team['gal_image2'],0,-4)."_".$nm_imagem;
				$this->imagemoferta5thumb 	= $INI['system']['wwwprefix']."/media/".substr($team['gal_image2'],0,-4)."_popular_mini.jpg";
			}
			if($team['gal_image3']){
				$this->imagemoferta6 	= $INI['system']['wwwprefix']."/media/".substr($team['gal_image3'],0,-4)."_".$nm_imagem;
				$this->imagemoferta6thumb 	= $INI['system']['wwwprefix']."/media/".substr($team['gal_image3'],0,-4)."_popular_mini.jpg";
			}
			if($team['gal_image4']){
				$this->imagemoferta7 	= $INI['system']['wwwprefix']."/media/".substr($team['gal_image4'],0,-4)."_".$nm_imagem;
				$this->imagemoferta7thumb 	= $INI['system']['wwwprefix']."/media/".substr($team['gal_image4'],0,-4)."_popular_mini.jpg";
			}
			if($team['gal_image5']){			
				$this->imagemoferta8 	= $INI['system']['wwwprefix']."/media/".substr($team['gal_image5'],0,-4)."_".$nm_imagem;
				$this->imagemoferta8thumb 	= $INI['system']['wwwprefix']."/media/".substr($team['gal_image5'],0,-4)."_popular_mini.jpg";
			}
			if($team['gal_image6']){
				$this->imagemoferta9 	= $INI['system']['wwwprefix']."/media/".substr($team['gal_image6'],0,-4)."_".$nm_imagem;
				$this->imagemoferta9thumb 	= $INI['system']['wwwprefix']."/media/".substr($team['gal_image6'],0,-4)."_popular_mini.jpg";
			} 
			if($team['gal_image7']){			
				$this->imagemoferta10 	= $INI['system']['wwwprefix']."/media/".substr($team['gal_image7'],0,-4)."_".$nm_imagem; 
				$this->imagemoferta10thumb 	= $INI['system']['wwwprefix']."/media/".substr($team['gal_image7'],0,-4)."_popular_mini.jpg";
			} 		
		}
		else{ 
		*/
		  if($team['image']){
				$this->imagemoferta 	= $INI['system']['wwwprefix']."/media/".$team['image']; 
				$this->imagemofertathumb 	= $INI['system']['wwwprefix']."/media/".substr($team['image'],0,-4)."_destaque.jpg";
			}
			if($team['image1']){
				$this->imagemoferta2 	= $INI['system']['wwwprefix']."/media/".$team['image1'];
				$this->imagemoferta2thumb 	= $INI['system']['wwwprefix']."/media/".substr($team['image1'],0,-4)."_destaque.jpg";
			}
			if($team['image2']){
				$this->imagemoferta3 	= $INI['system']['wwwprefix']."/media/".$team['image2'];
				$this->imagemoferta3thumb 	= $INI['system']['wwwprefix']."/media/".substr($team['image2'],0,-4)."_destaque.jpg";
			}
			if($team['gal_image1']){
				$this->imagemoferta4 	= $INI['system']['wwwprefix']."/media/".$team['gal_image1'];
				$this->imagemoferta4thumb 	= $INI['system']['wwwprefix']."/media/".substr($team['gal_image1'],0,-4)."_destaque.jpg";
			}
			if($team['gal_image2']){
				$this->imagemoferta5 	= $INI['system']['wwwprefix']."/media/".$team['gal_image2'];
				$this->imagemoferta5thumb 	= $INI['system']['wwwprefix']."/media/".substr($team['gal_image2'],0,-4)."_destaque.jpg";
			}
			if($team['gal_image3']){
				$this->imagemoferta6 	= $INI['system']['wwwprefix']."/media/".$team['gal_image3'];
				$this->imagemoferta6thumb 	= $INI['system']['wwwprefix']."/media/".substr($team['gal_image3'],0,-4)."_destaque.jpg";
			}
			if($team['gal_image4']){
				$this->imagemoferta7 	= $INI['system']['wwwprefix']."/media/".$team['gal_image4'];
				$this->imagemoferta7thumb 	= $INI['system']['wwwprefix']."/media/".substr($team['gal_image4'],0,-4)."_destaque.jpg";
			}
			if($team['gal_image5']){			
				$this->imagemoferta8 	= $INI['system']['wwwprefix']."/media/".$team['gal_image5'];
				$this->imagemoferta8thumb 	= $INI['system']['wwwprefix']."/media/".substr($team['gal_image5'],0,-4)."_destaque.jpg";
			}
			if($team['gal_image6']){
				$this->imagemoferta9 	= $INI['system']['wwwprefix']."/media/".$team['gal_image6'];
				$this->imagemoferta9thumb 	= $INI['system']['wwwprefix']."/media/".substr($team['gal_image6'],0,-4)."_destaque.jpg";
			} 
			if($team['gal_image7']){			
				$this->imagemoferta10 	= $INI['system']['wwwprefix']."/media/".$team['gal_image7']; 
				$this->imagemoferta10thumb 	= $INI['system']['wwwprefix']."/media/".substr($team['gal_image7'],0,-4)."_destaque.jpg";
			}  
		//} 
	}
	public function verificatipo($team){
	  
			 if($this->tipo_oferta =="pacote"){
			 
				// busca a oferta filha com valor mais barato para substituir no detalhe da oferta pacote
				$sql 	= "select id,team_price,market_price from team where idpacote = ".$team['id']."  and begin_time < '".time()."' and end_time > '".time()."' and now_number < max_number order by team_price asc limit 1 ";
				$rsd 	= mysql_query($sql);
				$row 	= mysql_fetch_assoc($rsd) ; 
			 
				if(mysql_num_rows($rsd)>0){
					$this->preco			= number_format($row['team_price'], 2, ',', '.'); 
					$this->preco_antigo		= number_format($row['market_price'], 2, ',', '.');  
					$this->economia 		= number_format($row['market_price'] - $row['team_price'],2, ',', '.'); 
					$this->porcentagem 		= round(100 - $row['team_price']/$row['market_price']*100,0);
				}
				else{
					$sql 	= "select id,team_price,market_price from team where idpacote = ".$team['id']."  order by team_price asc limit 1 ";
					$rsd 	= mysql_query($sql);
					$row 	= mysql_fetch_assoc($rsd) ; 
					
					$this->preco			= number_format($row['team_price'], 2, ',', '.'); 
					$this->preco_antigo		= number_format($row['market_price'], 2, ',', '.');  
					$this->economia 		= number_format($row['market_price'] - $row['team_price'],2, ',', '.'); 
					$this->porcentagem 		= round(100 - $row['team_price']/$row['market_price']*100,0);
				}
			}
			else{
				$this->preco			= number_format($team['team_price'], 2, ',', '.'); 
				$this->preco_antigo		= number_format($team['market_price'], 2, ',', '.');  
				$this->economia 		= number_format($team['market_price'] - $team['team_price'],2, ',', '.'); 
				$this->porcentagem 		= round(100 - $team['team_price']/$team['market_price']*100,0);	
			}
	}
	
	public function ofertas_destaques(){ 
	  
		global $city,$PATHSKIN;
		
		$order = " order by `sort_order` DESC, `id` DESC ";
		if( $INI['option']['ofertasdestaquerand'] == "Y"){
			$order =  "order by rand()";
		} 
	  
		$sql 		 = "select * from team where id <> ".$this->ofertadestaqueprincipal." and  posicionamento = 1 and city_id in(".$city['id'].",0 )    $order ";
		$rsd 		 = mysql_query($sql);
		
		while ($team = mysql_fetch_assoc($rsd)) {
		
			$this->getDados($team);
			include(DIR_BLOCO."/bloco_oferta_meio_home.php");
			
		 }  
	}
	public function ofertas_destaques_website_produtoafiliado(){ 
	    global $PATHSKIN;
		
		$order = " order by `sort_order` DESC, `id` DESC ";
		if( $INI['option']['ofertasdestaquerand'] == "Y"){
			$order =  "order by rand()";
		} 
	  
		$sql 		 = "select * from produtos_afiliados where id <> ".$this->ofertadestaqueprincipal." and posicionamento = 1 and  begin_time < '".time()."' and end_time > '".time()."'  $order ";
		$rsd 		 = mysql_query($sql);
		
		while ($team = mysql_fetch_assoc($rsd)) {
		
			$this->getDados($team);
			include(DIR_BLOCO."/bloco_oferta_meio_home.php");
			
		 }
	}
	
	public function getLinkOferta($team){ 
	     global $INI;
		 
		 $destino =  "produto";
		 
	    return $INI['system']['wwwprefix']."/".$destino."/". $team['id']."/".urlamigavel( tratanome($team['title']));
	}	
	
	public function getComissao($team){ 
	       
		if($team){
			if($team['preco_comissao'] != "" and $team['preco_comissao'] != "0" and $team['preco_comissao'] != "0.00"){
				$comissao = true;
				return number_format($team['preco_comissao'], 2, ',', '.');
			}
		}
		return false;
	}	
	 
	public function ofertas_recentes($start,$per_page,$idofertadetalhe=false){ 
	    global  $city,$PATHSKIN,$INI,$ROOTPATH,$currency;
		 
		 $this->getOfertaDestaqueHome();
		 
		if($_REQUEST["idcategoria"]){
			$sqlcat =  " and group_id = ".RemoveXSS($_REQUEST["idcategoria"]);
		}
		if($idofertadetalhe){
			$sqlcat .=" and id <> ".$idofertadetalhe;
		}
	 
	    $sql 		= "select * from  team where  posicionamento <> 5 and   city_id in( ".$city['id'].",0) $sqlcat order by `end_time` DESC , `now_number` ASC limit $start,$per_page";
		$rsd 		= mysql_query($sql);
		  
		while ($value = mysql_fetch_assoc($rsd))
		{
			 $temoferta = true;
			 $this->getDados($value,"recentes_mod2.jpg");
			 include(DIR_BLOCO."/bloco_recentes.php"); 
			 
		}
		return $temoferta;
	}

	public function ofertas_recentes_website_produtosafiliados($idofertadetalhe){ 
	  
		if($idofertadetalhe){
			$aux =  " and id <> $idofertadetalhe";
		}
		$sql 		= "select * from  produtos_afiliados where end_time > '".time()."'  $aux  and posicionamento ='3' and begin_time < '".time()."' order by `end_time` DESC , `now_number` ";
		$rsd 		= mysql_query($sql);
 
		while ($value = mysql_fetch_assoc($rsd))
		{
			$temoferta = true;
			$this->getDados($value,"recentes_mod2.jpg");
			include(DIR_BLOCO."/bloco_recentes.php"); 
			 
		}
		return $temoferta;
	}
		
	public function produtos_websites_afiliados($start,$per_page){ 
	    global  $city,$PATHSKIN,$INI,$ROOTPATH;
		 
	    $sql 		= "select * from produtos_afiliados where posicionamento <> 5 and begin_time < '".time()."' and partner_id = ".RemoveXSS($_REQUEST['idparceiro'])." order by `begin_time` DESC , `now_number` DESC limit $start,$per_page ";
		$rsd 		= mysql_query($sql);
		   
		while ($value = mysql_fetch_assoc($rsd))
		{
			$temoferta = true;
			$this->getDados($value,"recentes_mod2.jpg");
			include(DIR_BLOCO."/bloco_recentes.php"); 
			 
		}
		return $temoferta;
	}	
	
	public function produtoafiliado_categoria($start,$per_page){ 
	
	    global  $city,$PATHSKIN,$INI,$ROOTPATH;
		 
		$sql 		= "select * from produtos_afiliados where posicionamento <> 5 and begin_time < '".time()."' and group_id = ".RemoveXSS($_REQUEST['idcategoria'])." order by `begin_time` DESC , `now_number` DESC limit $start,$per_page ";
		$rsd 		= mysql_query($sql);
		   
		while ($value = mysql_fetch_assoc($rsd))
		{ 
			$temoferta = true;
			$this->getDados($value,"recentes_mod2.jpg");
			include(DIR_BLOCO."/bloco_recentes.php"); 
			 
		}
		return $temoferta;
	}	
	 
	public function tem_outras_ofertas(){ 
	
		global $city,$id_ofertas_destaque, $idoferta,$id_oferta_destaque,$idcidade,$horaatual;
  
		$sql   = "select id from team where  city_id in(".$city['id'].",0 ) and posicionamento=4 $sqlaux order by `sort_order` DESC, `id` DESC LIMIT 1";
		$maisofertas  	= mysql_query($sql);
		if(mysql_num_rows($maisofertas) > 0){
			return true;
		}
		else{
			return false;
		}
	}	
	
	public function tem_ofertas_cidade(){ 
	
		global $city ;

		$posicao = "3,4,1,5";
 
		if($this->ofertadestaqueprincipal != ""){
		//	$sqlaux = " and id not in (".$this->ofertadestaqueprincipal.")";
		} 
		if($id_oferta_destaque!= ""){ // oferta destaque
		//	$sqlaux .= " and id not in ($id_oferta_destaque)";
		} 
		if($id_ofertas_destaque!= ""){ // multi ofertas destaques
			//$sqlaux.= " and id not in ($id_ofertas_destaque)";
		} 
	    $sql   = " select id from team where city_id in(".$city['id'].",0 )    $sqlaux  limit 1 ";
		$maisofertas  	= mysql_query($sql);
		if(mysql_num_rows($maisofertas) > 0){
			return true;
		}
		else{
			return false;
		}
	}
	public function tem_ofertas_anunciante($idanunciante){ 
	  
		$sql   = " select id from produtos_afiliados where partner_id=$idanunciante and  begin_time < '".time()."' and end_time > '".time()."' and posicionamento <> 5 order by `sort_order` DESC, `id` DESC  limit 1 ";
		$maisofertas  	= mysql_query($sql);
		if(mysql_num_rows($maisofertas) > 0){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function tem_ofertas_parceiro_posicao($posicao){ 
	
		global $city,$id_oferta_destaque,$idoferta ;
  
		if($this->ofertadestaqueprincipal != ""){
			$sqlaux = " and id not in (".$this->ofertadestaqueprincipal.")";
		} 
		if($id_oferta_destaque!= ""){ // oferta destaque
			$sqlaux .= " and id not in ($id_oferta_destaque)";
		} 
		if($id_ofertas_destaque!= ""){ // multi ofertas destaques
			$sqlaux.= " and id not in ($id_ofertas_destaque)";
		} 
	    $sql   = "select id from team where city_id in(".$city['id'].",0 ) and posicionamento in($posicao) and begin_time < '".time()."' and end_time > '".time()."' $sqlaux order by `sort_order` DESC, `id` DESC limit 1";
		$maisofertas  	= mysql_query($sql);
		if(mysql_num_rows($maisofertas) > 0){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function tem_ofertas_afiliado_posicao($posicao){ 
	
		global $city,$id_oferta_destaque,$idoferta ;
  
		if($this->ofertadestaqueprincipal != ""){
			$sqlaux = " and id not in (".$this->ofertadestaqueprincipal.")";
		} 
		if($id_oferta_destaque!= ""){ // oferta destaque
			$sqlaux .= " and id not in ($id_oferta_destaque)";
		} 
		if($id_ofertas_destaque!= ""){ // multi ofertas destaques
			$sqlaux.= " and id not in ($id_ofertas_destaque)";
		} 
		$sql   = "select id from produtos_afiliados where  posicionamento in($posicao) and begin_time < '".time()."' and end_time > '".time()."' $sqlaux order by `sort_order` DESC, `id` DESC limit 1";
		$maisofertas  	= mysql_query($sql);
		if(mysql_num_rows($maisofertas) > 0){
			return true;
		}
		else{
			return false;
		}
	}
  
	public function blocos_website_produtosafiliados($posicao){ 
	
		global $idoferta,$city,$PATHSKIN,$INI;
	 
		if($this->ofertadestaqueprincipal != ""){
			$sqlaux = " and id not in (".$this->ofertadestaqueprincipal.")";
		} 
		$sql  			= "select * from produtos_afiliados where posicionamento in($posicao) and begin_time < '".time()."' and end_time > '".time()."' $sqlaux order by `sort_order` DESC, `id` DESC ";
		$result  		= mysql_query($sql);	

		while ($value = mysql_fetch_assoc($result)){ 

			$botao = "btn-quero.png";
			if($value['team_type']=="off"){
				$botao = "bt_imprimir_cupom.png";
			}
			else if($value['team_type']=="cupom"){
				$botao = "comprar_cupom.png";
			} 
			 $this->getDados($value,"lateral.jpg"); 
			 include(DIR_BLOCO."/bloco_oferta.php"); 
		}
	}
	
	public function coluna_direita($posicao){ 
	
		global $idoferta,$city,$PATHSKIN,$INI,$currency;
 
		$order = " order by `sort_order` DESC, `id` DESC ";
		if( $INI['option']['rand_direita'] == "Y"){
			$order =  "order by rand()";
		}
		  
	   $sql  			= "select * from team where posicionamento in($posicao) and city_id in(0,".$city['id']." )   $order ";
		$result  		= mysql_query($sql);	

		while ($value = mysql_fetch_assoc($result)){ 
    
			if( !strpos($_SERVER["QUERY_STRING"],"IDOFERTASDESTAQUE")){
			 }
			$botao = "btn-quero.png";
			if($value['team_type']=="off"){
				$botao = "bt_imprimir_cupom.png";
			}
			else if($value['team_type']=="cupom"){
				$botao = "comprar_cupom.png";
			} 
			
			if($posicao=="10"){
				$this->getDados($value,"lateral_nacional.jpg"); 
				include(DIR_BLOCO."/bloco_oferta_nacional.php");  
			}
			else{
				$this->getDados($value,"lateral.jpg"); 
				include(DIR_BLOCO."/bloco_oferta_direita.php"); 
			}
		}
	}
	
	public function blocos($posicao){ 
	
		global $idoferta,$city,$PATHSKIN,$INI,$currency;

		if($this->ofertadestaqueprincipal != ""){ 
			$sqlaux = " and id not in (".$this->ofertadestaqueprincipal.")";
		} 
		else if($idoferta != ""){ 
			$sqlaux = " and id not in (".$idoferta.")";
		} 
		if($sqlaux==""){
			$posicao = "4";
		}
	    $sql  			= "select * from team where posicionamento in($posicao)  and city_id in(0,".$city['id']." )   $sqlaux order by `sort_order` DESC, `id` DESC ";
		$result  		= mysql_query($sql);	
 
		while ($value = mysql_fetch_assoc($result)){ 
    
			if( !strpos($_SERVER["QUERY_STRING"],"IDOFERTASDESTAQUE")){
			 }
		 
			 $this->getDados($value,"lateral.jpg"); 
			 include(DIR_BLOCO."/bloco_oferta.php"); 
		}
	}
	
	public function getBlocoPrincipal(){ 
		global $PATHSKIN,$login_user_id,$INI,$ROOTPATH,$team,$city,$currency,$currency;
		require_once(DIR_BLOCO."/home.php");		 
	}		
	
	public function getBlocoPrincipalM(){ 
		global $PATHSKIN,$login_user_id,$INI,$ROOTPATH,$team,$city,$currency,$currency;		 
	}		
	
	public function getBlocoDetalheProduto($idoferta,$tipo=null){ 
		global $PATHSKIN,$login_user_id,$INI,$ROOTPATH,$team,$currency;
		if($tipo=="especial"){
			require_once(DIR_BLOCO."/detalhe_produto_especial.php");
		}
		else{
			require_once(DIR_BLOCO."/detalhe_produto.php"); 
		}
	}		
	
	public function getBlocoDireita(){ 
		global $PATHSKIN,$login_user_id,$INI,$ROOTPATH,$team,$semcart,$currency;
		include_once(DIR_BLOCO."/coluna_direita.php");
		 
	}	
	 
	public function getOferta($idOferta){ 
	
		$sql  			= "select * from team where team_id = $idOferta ";
		$result  		= mysql_query($sql);
		$team 			= mysql_fetch_assoc($result);

		$nomeurl 	=    urlamigavel( tratanome($value['title'])) ;
		$temoferta	=	true;
		$end_time 	= 	date('YmdHis', $value['end_time']); 
		$date 		= 	date('YmdHis');
		$ofertafechada = false;
		 if( $end_time  < $date){
			$ofertafechada = true;
			 continue;
		  }
		$esgotado =	false;
		if($value['now_number'] >= $value['max_number']){
			$esgotado=true;
		}
		$discount_rate = round(100 - $value['team_price']/$value['market_price']*100,0);
		$summary = substr($value['summary'],0,200)."...";
		
		if($value['now_number'] < $value['min_number']){  
			$min = $value['min_number'] - $value['now_number'] ; 
		}
		$imagem  	=  $value['image'] ; 
		if( !strpos($_SERVER["QUERY_STRING"],"IDOFERTASDESTAQUE")){
			//$value['title'] =  utf8_decode($value['title']);
		 }
		$botao = "btn-quero.png";
		if($value['team_type']=="off"){
			$botao = "bt_imprimir_cupom.png";
		}
		else if($value['team_type']=="cupom"){
			$botao = "comprar_cupom.png";
		}
		 
		$comissao = false;
		if($team['preco_comissao'] != "" and $team['preco_comissao'] != "0" and $team['preco_comissao'] != "0.00"){
			$comissao = true;
			$valoronline = number_format($team['preco_comissao'], 2, ',', '.');
		}
	
		$team['economia'] 		= number_format($team['market_price'] - $team['team_price'],2);
		$team['linkoferta']		= $INI['system']['wwwprefix']."/produto/". $team['id']."/".urlamigavel( tratanome($team['title'])) ;
		$team['tituloferta'] 	= utf8_decode($team['title']); 
		$team['imagemoferta'] 	= $INI['system']['wwwprefix']."/media/".$team['image']; 
		$team['desconto'] 		= round(100 - $team['team_price']/$team['market_price']*100,0);
		
		return $team;
		  
	} 

	public function getOfertaDestaqueHome($idoferta=false){ 
	
		global $city,$INI,$ROOTPATH;
		$horaatual =  time(); 
		$aux_imagem= "destaque_op.jpg";
		 
		 $order = " order by `sort_order` DESC, `id` DESC "; 
		// $sql   = "select * from team where posicionamento in(6)  and city_id in(0,".$city['id']." )    $order limit 1";
		 $sql   = "select * from team where posicionamento in(6)   $order limit 1";
		 $result  		= mysql_query($sql);
		  
		 if($idoferta){ 
			$aux_imagem= "destaque.jpg";
			$sql  			= "select * from team where id = $idoferta $order limit 1";
			$result  		= mysql_query($sql);
		 } 
		if(mysql_num_rows($result) == 0){
			//$sql  	 	= "select * from team where posicionamento <> '5' and city_id in(0,".$city['id']." )    $order  limit 1";
			$sql  			= "select * from team where posicionamento <> '5'  $order  limit 1";
			$result  		= mysql_query($sql);
		} 
		$team 	= mysql_fetch_assoc($result); 
		
		if($team){ 
			$this->ofertadestaqueprincipal = $team['id'];
			$this->getDados($team,$aux_imagem); 
		} 
		return $team; 
	}

	public function ofertas_parceiro($start,$per_page){ 
	
	    global  $city,$PATHSKIN,$INI,$ROOTPATH; 
		require(DIR_BLOCO."/produtos_parceiro.php"); 
	 
	}	
	
}
	

 
?>