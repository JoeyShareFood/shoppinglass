<?php

require_once("../../include/configure/db.php");
require_once('../../include/library/tcpdf/tcpdf.php');

/* filter start */
$coupon = ($_GET['coupon'] != 'undefined') ? $_GET['coupon'] : null;
$tid = ($_GET['tid'] != 'undefined') ? $_GET['tid'] : null;
$uname = ($_GET['uname'] != 'undefined') ? $_GET['uname'] : null;
$partner_id = ($_GET['partner_id'] != 'undefined') ? $_GET['partner_id'] : null;
$order_id = ($_GET['order_id'] != 'undefined') ? $_GET['order_id'] : null;
$consume = ($_GET['consume'] != 'undefined') ? $_GET['consume'] : null;
$nome = ($_GET['nome'] != 'undefined') ? $_GET['nome'] : null;
$envioucupom = ($_GET['envioucupom'] != 'undefined') ? $_GET['envioucupom'] : null;

$conecta = mysql_connect($value['host'],$value['user'],$value['pass']);
mysql_select_db($value['name']);

$consulta = array();
$consulta[] = 'SELECT c.id, c.secret, c.create_time, t.title, p.title AS parceiro, c.order_id, c.consume, u.realname, c.expire_time, c.envioucupom,
u.email
FROM coupon AS c 
LEFT JOIN team AS t ON t.id = c.team_id
LEFT JOIN user AS u ON u.id = c.user_id
LEFT JOIN partner AS p ON p.id = c.partner_id';

if($coupon){
	$consulta[] = 'WHERE c.id = "' . $coupon . '"';
}

if($tid){

	if($coupon){
		$consulta[] = 'AND c.team_id = "' . $tid . '"';
	}else{
		$consulta[] = 'WHERE c.team_id = "' . $tid . '"';
	}
}

if($uname){

	if($coupon || $tid){
		$consulta[] = 'AND u.email LIKE "%' . $uname . '%"';
	}else{
		$consulta[] = 'WHERE u.email LIKE "%' . $uname . '%"';
	}
}

if($partner_id){
	if($coupon || $tid || $uname){
		$consulta[] = 'AND c.partner_id = ' . $partner_id;
	}else{
		$consulta[] = 'WHERE c.partner_id = ' . $partner_id;
	}	
}

if($order_id){
	if($coupon || $tid || $uname || $order_id){
		$consulta[] = 'AND c.order_id = ' . $order_id;
	}else{
		$consulta[] = 'WHERE c.order_id = ' . $order_id;
	}	
}

if($consume){
	if($coupon || $tid || $uname || $order_id || $order_id){
		$consulta[] = 'AND c.consume = ' . $consume;
	}else{
		$consulta[] = 'WHERE c.consume = ' . $consume;
	}	
}

if($nome){
	if($coupon || $tid || $uname || $order_id || $order_id || $consume){
		$consulta[] = 'AND u.realname = ' . $nome;
	}else{
		$consulta[] = 'WHERE u.realname = ' . $nome;
	}	
}

if($envioucupom){
	if($coupon || $tid || $uname || $order_id || $order_id || $consume || $nome){
		$consulta[] = 'AND c.envioucupom = ' . $envioucupom;
	}else{
		$consulta[] = 'WHERE c.envioucupom = ' . $envioucupom;
	}	
}

$consulta[] = 'ORDER BY c.id ASC';

$consulta = implode("\n", $consulta);

$resultado = mysql_query($consulta);

function numeroToMoeda($numero, $qtdDecimais = 2) {
	$numero = number_format($numero, $qtdDecimais);
	$numero = explode('.', $numero);
	return sprintf('%s,%s', str_replace(',', '.', $numero[0]), $numero[1]);
}

class VipPDF extends TCPDF{

	public function isFimPagina($tamanho = null) {

		if ($this->CurOrientation == 'P') {

			$tamanho = isset($tamanho) ? $tamanho : 280;

			if ($this->GetY() >= $tamanho) {
				$this->endPage();
				$this->startPage();
				return true;
			}
		} else {

			$tamanho = isset($tamanho) ? $tamanho : 198;

			if ($this->GetY() >= $tamanho) {
				$this->endPage();
				$this->startPage();
				return true;
			}
		}
	}

	public function Header(){
		$this->SetY(3);
		#$this->Image('../../include/logo/logo.png', 5, 3, 50, 20, '');
		#$this->SetY(5);
		$this->SetFont('Arial', 'BU');
		$this->MultiCell(0, 4, ' Relatório de Cupons ', 0, 'C', false, 1);
		$this->SetFont('Arial', '', 8);
		$this->SetY(10);

		$pageH = 10;

		$this->MultiCell(15, 4, 'Cupon', 1, 'C', false, 0);

		$this->MultiCell(15, 4, 'Senha', 1, 'C', false, 0);

		$this->MultiCell(15, 4, 'Gerado', 1, 'C', false, 0);

		$this->MultiCell(80, 4, 'Oferta', 1, 'C', false, 0);

		$this->MultiCell(30, 4, 'Usuário', 1, 'C', false, 0);

		$this->MultiCell(30, 4, 'Parceiro', 1, 'C', false, 0);

		$this->MultiCell(15, 4, 'Pedido', 1, 'C', false, 0);

		$this->MultiCell(20, 4, 'Status', 1, 'C', false, 0);

		$this->MultiCell(30, 4, 'Utilizador', 1, 'C', false, 0);

		$this->MultiCell(15, 4, 'Prazo', 1, 'C', false, 0);

		$this->MultiCell(15, 4, 'Enviado', 1, 'C', false, 0);

		$this->Ln();
	}

	public function Footer(){
		$this->line(5, 200, $this->GetPageWidth() - 10, 200);
		$this->Ln();
		$this->SetY(-8);
		$this->SetFontSize(7);
		$this->MultiCell(0, 4, 'Página: ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 'R');
	}

}

// create new PDF document
$pdf = new VipPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('VipCom');
$pdf->SetTitle('Relatório Cupons');

//set margins
$pdf->SetMargins(5, 25, 5);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);
// ---------------------------------------------------------

// set font
$pdf->SetFont('Arial', '', 7);

// add a page
$pdf->AddPage();

// ----------------------------------------------------------

$pdf->SetY(15);
while ($reg = mysql_fetch_array($resultado)) {

	if(strlen($reg['title']) > 80){
		$title = substr($reg['title'], 0, 77) . '...';
	}else{
		$title = $reg['title'];
	}

	#$h = 5;
	$h = ($pdf->GetStringWidth($title) > 8) ? 8 : $pdf->GetStringWidth($title);

	$pdf->MultiCell(15, $h, $reg['id'], 0, 'C', false, 0);
	$pdf->MultiCell(15, $h, $reg['secret'], 0, 'C', false, 0);
	$pdf->MultiCell(15, $h, date('d/m/Y', $reg['create_time']), 0, 'C', false, 0);
	$pdf->MultiCell(80, $h, utf8_encode($title), 0, 'C', false, 0);
	$pdf->MultiCell(30, $h, $reg['email'], 0, 'C', false, 0);
	$pdf->MultiCell(30, $h, utf8_encode($reg['parceiro']), 0, 'C', false, 0);
	$pdf->MultiCell(15, $h, $reg['order_id'], 0, 'C', false, 0);
	$pdf->MultiCell(20, $h, ($reg['consume'] == 'Y') ? 'Consumido' : 'Não Consumido', 0, 'C', false, 0);
	$pdf->MultiCell(30, $h, $reg['realname'], 0, 'C', false, 0);
	$pdf->MultiCell(15, $h, date('d/m/Y', $reg['expire_time']), 0, 'C', false, 0);
	$pdf->MultiCell(15, $h, ($reg['envioucupom'] == 1) ? 'Sim' : 'Não', 0, 'C', false, 0);
	
	$pdf->Ln();

	if($pdf->isFimPagina()){
		$pdf->SetY(15);
	}
}

//Close and output PDF document
$pdf->Output('Cupons.pdf', 'I');