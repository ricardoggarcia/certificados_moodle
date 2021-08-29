<?php 
//============================================================+
// File name   : certificado.php
// Begin       : 2021-05-14
// Last Update : 2021-08-10
//
// Description : Genera certificado dinamicamente.
//
// Author: Ricardo Garcia
//
// (c) Copyright:
//               Ricardo Garcia              
//               www.degecomp.com
//               ricardo.garcia@degecomp.com
//============================================================+

require_once('tcpdf_include.php');
$persona = 1;//$_REQUEST['codigo'];

$link = mysqli_connect('localhost','root','','certificados');
$tildes = $link->query("SET NAMES 'utf8'"); 
//consulta para extraer informacion de moodle
/*
$sql_data = "SELECT user.id, user.firstname, user.lastname, g.quiz, g.userid, g.grade , q.name, user.auth  , from_unixtime(g.timemodified, '%d-%m-%Y') as 'fecha'
FROM mdlcd_role_assignments r
INNER JOIN mdlcd_user user ON (user.id= r.userid)
INNER JOIN mdlcd_context cn ON (r.contextid = cn.id)
inner join mdlcd_quiz_grades g on (user.id = g.userid)
left join mdlcd_quiz q on q.id = g.quiz
WHERE cn.contextlevel=50
AND r.roleid=5  and  g.userid = $persona
";*/

$sql_data = "SELECT u.id, u.firstname, u.lastname, u.quiz, u.userid, u.grade, u.name, u.auth, u.timemodified as 'fecha' FROM certificados.usuarios  u WHERE  u.id= $persona";

$result = mysqli_query($link, $sql_data);
$plantas ='';
$plantas = $plantas . ' SANTA LEONOR,';   
$lugar = substr($plantas, 0, -1);
mysqli_data_seek ($result, 0);
$datos = mysqli_fetch_array($result);

//Datos de la Base
$nombres = $datos['firstname'];
$apellido = $datos['lastname'];
$nombres_apellidos = strtoupper($datos['firstname']).' '.strtoupper($datos['lastname']);
$nota = $datos['grade'];
$fecha = $datos['fecha'];

$encabezado = 'Confiere el siguiente reconocimiento  a: ';
$tema = '  Por haber aprobado la inducción en <strong>"SEGURIDAD Y SALUD OCUPACIONAL"</strong>, por aprobar las 40 horsa de capacitación en la ciudad de: <strong>'.$lugar.'</strong>';

$tipo = $datos['auth'];

//Covierto la fecha
$fecha = substr($fecha, 0, 10);
  $numeroDia = date('d', strtotime($fecha));
  $dia = date('l', strtotime($fecha));
  $mes = date('F', strtotime($fecha));
  $anio = date('Y', strtotime($fecha));
  $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
  $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
  $nombredia = str_replace($dias_EN, $dias_ES, $dia);
  $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
  $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
  $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
  $fecha_palabras = $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
    
  if ($tipo == 'db'){
      $fecha_suma = date("d-m-Y",strtotime($fecha."+ 1 year"));
      $fecha_expira = 'Valido por un año - Fecha de expiración: '.$fecha_suma;
      $fecha_msg = '';
  }else{
      $fecha_suma = date("d-m-Y",strtotime($fecha."+ 1 month"));
      $fecha_expira = 'Valido por un mes - Fecha de expiración: '.$fecha_suma;
       $fecha_msg =  'Expira en 30 días';
  }

  $informacion_qr = 'Usuario: '.$nombres_apellidos.' - '.$fecha_expira .'  - plantas:  '.$lugar ;

  // Extend the TCPDF class to create custom Header and Footer
  class MYPDF extends TCPDF {
        //Page header
        public function Header() {
            // get the current page break margin
            $bMargin = $this->getBreakMargin();
            // get current auto-page-break mode
            $auto_page_break = $this->AutoPageBreak;
            // disable auto-page-break
            $this->SetAutoPageBreak(false, 0);       
            // restore auto-page-break status
            $this->SetAutoPageBreak($auto_page_break, $bMargin);
            // set the starting point for the page content
            $this->setPageMark();
        }
  }

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('persona');
$pdf->SetTitle('Certificado');
$pdf->SetSubject('CERTIFICADO');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

// remove default footer
$pdf->setPrintFooter(false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/spa.php')) {
    require_once(dirname(__FILE__).'/lang/spa.php');
    $pdf->setLanguageArray($l);
}
// set font
$pdf->SetFont('times', '', 48);
// add a page
$pdf->AddPage('L', 'A4');
// remove default header
$pdf->setPrintHeader(false);
// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);
$width = $pdf->getPageWidth();
$height = $pdf->getPageHeight();
// set bacground image
$img_file = K_PATH_IMAGES.'certificado.png';
$pdf->Image($img_file, 0, 0, $width, $height, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();

$pdf->SetTextColor(2,67,120);

    // set font
$pdf->SetFont('helvetica', '', 20);
$pdf->SetXY(15, 75);
$pdf->Write(0, $encabezado, '', 0, 'C', true, 0, false, false, 0);

$pdf->SetFont('helvetica', 'B', 30);
$pdf->SetXY(15, 90);
$pdf->Write(0, $nombres_apellidos, '', 0, 'C', true, 0, false, false, 0);

$pdf->SetFont('helvetica', '', 20);
$pdf->SetTextColor(2,67,120);
$pdf->SetXY(20, 115);
$tema_completo = '<table width="100%" border="0">
<tbody>
  <tr>
    <td>'.$tema.'</td>
  </tr>
</tbody>
</table>';

// output the HTML content
$pdf->writeHTML($tema_completo, true, 0, true, true);

$pdf->SetFont('helvetica', '', 18);
//$pdf->SetXY(15, 111);
$ciudad_fecha = '<table width="100%" border="0">
<tbody>
  <tr>
    <td>&nbsp;</td>
  </tr>
    <tr align="center">
    <td>'.$fecha_palabras.'</td>
	</tr>	 
</tbody>
</table>';
$pdf->writeHTML($ciudad_fecha, true, 0, true, true);
$pdf->SetFont('helvetica', '', 10);
$pdf->SetXY(30, 151);
$ciudad_fecha_exp = '<table width="100%" border="0">
<tbody>   
	 <tr align="center">
	 <td>'.$fecha_msg.'</td>
  </tr>
</tbody>
</table>';
$pdf->writeHTML($ciudad_fecha_exp, true, 0, true, true);
$pdf->SetFont('helvetica', '', 18);
// set style for barcode
$style = array(
    'border' => 0,
    'vpadding' => 'auto',
    'hpadding' => 'auto',
    'fgcolor' => array(2,67,120),
    'bgcolor' => array(255,255,255),
    'module_width' => 1, // width of a single module in points
    'module_height' => 1 // height of a single module in points
);

// QRCODE,L : QR-CODE 
$pdf->write2DBarcode($informacion_qr, 'QRCODE,L', 140, 155, 30, 30, $style, 'N');

//Close and output PDF document
$pdf->Output('CERTIFICADO'.$nombres_apellidos.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>