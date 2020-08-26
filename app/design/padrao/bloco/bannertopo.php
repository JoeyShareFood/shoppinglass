<div style="display:none;" class="tips"><?=__FILE__?></div>
<?
require_once( dirname(dirname(dirname(dirname(dirname(__FILE__))))). '/app.php');

if($_REQUEST["idoferta"]){ 
	if($INI['bulletin']['topotodos']){
		$banner = trim($INI['bulletin']['topotodos']);
	} 
}
else if($_REQUEST['idcategoria'] != "" or $idcategoria !=""){
	if($idcategoria!=""){
			$idcatbusca=$idcategoria;
	}
	else{
			$idcatbusca=RemoveXSS($_REQUEST['idcategoria']);
	}
	$categoria = $Categoria->getCategoria($idcatbusca) ;
	$banner =  $categoria['bannercategoria'];
}
if($banner ==""){
	$parceiro = Table::Fetch('partner',RemoveXSS( $_REQUEST['idparceiro']));
	if($parceiro['bannerparceiro']){
		$banner = $parceiro['bannerparceiro'];
	}
	else{
		$banner = trim($INI['bulletin']['topotodos']);
	}
}
if($banner!=""){?> 

	<div class="banner_ofertas_cat">
		<?=$banner?>  
	</div>
<? } ?>