<!-- <h2 style="text-align:center;">Please wait.........</h2> -->


<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include FS_ADMIN . _MODS . "/invoice2024_25/invoice2024_25.inc.php";
require_once dirname(__FILE__) . "/tcpdf/tcpdf.php";

$uid = isset($_GET['uid']) ? intval($_GET['uid']) : 0;

if ($uid) {
    $query = $PDO->db_query("select * from #_" . tblName . " where pid ='" . $uid . "' ");
    $row = $PDO->db_fetch_array($query);
if (is_array($row)) {
    extract($row);
} else {
    $row = []; // ensure variable set rahe
}
    // Prepare invoice data
    $keys = explode(":", $itemservice);
    $scode = explode(":", $sac);
    $valus = explode(":", $itempriceservice);
$adonkeys = explode(":", $itemadon ?? '');
$adonvalus = explode(":", $itempriceadon ?? '');

    $allkeys = "";
    $saccode = "";
    $allval = "";
    $adonallkeys = "";
    $adonallval = "";

    foreach ($keys as $key) { $allkeys .= '<p style="padding-top:5px;"><strong>' . $key . "</strong></p>"; }
    foreach ($scode as $ss) { $saccode .= '<p style="padding-top:5px;"><strong>' . $ss . "</strong></p>"; }
    foreach ($valus as $val) { $allval .= $val ? '<p style="padding-top:5px;">' . $val . "/-</p>" : "<p>&nbsp;</p>"; }
    foreach ($adonkeys as $adonkey) { $adonallkeys .= '<p style="padding-top:5px;"><strong>' . $adonkey . "</strong></p>"; }
    foreach ($adonvalus as $adonval) { $adonallval .= $adonval ? '<p style="padding-top:5px;">' . $adonval . "/-</p>" : "<p>&nbsp;</p>"; }

    $sertax = $strn ? "<br><strong>GST Identification Number: </strong>" . $strn : "";
    $placetosupply = $placetosupply ? "<br><strong>Place to Supply: </strong>" . $placetosupply : "";

    // Build HTML for PDF
    $html = '<div class="invicecon"><table border="0" cellspacing="0" cellpadding="8" width="100%" style="border:solid #ddd 1px;">';
    $html .= '<tr><td width="43%" valign="top"><p><strong>AGSK & CO.</strong><br />';
    $html .= '<strong>PAN:</strong> ' . $pan . '<br />';
    $html .= '<strong>GSTIN:</strong> ' . $servicetaxno . '<br />';
    $html .= '<strong>Invoice No.:</strong> ' . $inviceno . '<br />';
    $html .= '<strong>Dated:</strong> ' . date("l jS \of F Y", strtotime($invicedate)) . '<br />';
    $html .= '<strong>Relationship Manager:</strong> ' . $rlmanager . '</p></td>';
    $html .= '<td width="56%" valign="top"><p align="left"><strong>Customer Name: ' . $customername . '</strong><br />';
    $html .= '<strong>Email ID: </strong>' . $customeremail . '<br />';
    $html .= '<strong>Contact No.: </strong>' . $customerno . '<br />';
    $html .= '<strong>Address: </strong>' . $addressofclient . $sertax . $placetosupply . '</p></td></tr></table></div>';

    // Service items table
    $html .= '<div class="invicecon" style="margin-bottom:0px;"><table border="1" cellspacing="0" cellpadding="5" width="100%">';
    $html .= '<tr><td width="65%"><strong>DESCRIPTION OF THE SERVICES</strong></td><td width="20%"><strong>SAC Code</strong></td><td width="14%" align="right"><strong>AMOUNT</strong></td></tr>';
    $html .= '<tr><td width="65%" height="150">' . $allkeys . '</td><td width="20%" height="150">' . $saccode . '</td><td width="14%" height="150" align="right">' . $allval . '</td></tr>';

    if ($row["placetosupply"] != "Delhi - 07") {
        $html .= '<tr><td width="85%" colspan="2">IGST @ 18 %</td><td width="14%" align="right">' . $hsrtax . '/-</td></tr>';
    } else {
        $html .= '<tr><td width="85%" colspan="2">S GST @ 9%</td><td width="14%" align="right">' . $hsbtax . '/-</td></tr>';
        $html .= '<tr><td width="85%" colspan="2">C GST @ 9%</td><td width="14%" align="right">' . $hkktax . '/-</td></tr>';
    }

    $html .= '<tr><td width="85%" colspan="2"><strong>TOTAL:</strong></td><td width="14%" align="right"><strong>' . $hmaintotal . '/-</strong></td></tr>';
    $html .= '<tr><td width="85%" height="100">' . $adonallkeys . '</td><td width="14%" height="100" align="right">' . $adonallval . '</td></tr>';
    $html .= '<tr><td width="85%" colspan="2"><strong>GROSS TOTAL:</strong><br>(<strong>In Words:</strong>' . $hinwords . ')</td><td width="14%" align="right"><strong>' . $hgrasstotal . '/-</strong></td></tr>';
    $html .= '</table></div>';

    // PDF generation class
    class MYPDF extends TCPDF {
        public function Header() {
            $this->SetFont("helvetica", "B", 14);
            $this->writeHTML('<div style="text-align:right; height:60px"><span>Invoice</span> <img style="height:60px;" src="http://agskca.com/images/logo.png" /></div>');
        }
        public function Footer() {
            $this->SetY(-20);
            $this->SetFont("helvetica", "I", 8);
            $this->writeHTML('<div style="text-align:center;">137, KD Block, Pitampura, New Delhi 110034<br /><strong>Mobile:</strong>9899732503 <strong>E-mail:</strong> sachin@agskca.com</div>');
        }
    }

    // Generate PDF
    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, "UTF-8", false);
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    $pdf->SetFont("helvetica", "", 10);
    $pdf->AddPage();
    $pdf->writeHTML($html, true, false, true, false, "");

    $pdf_path = __DIR__ . "/pdf/" . $filename . ".pdf";
    $pdf->Output($pdf_path, "F");

$sname = 'Record has been added/updated. PDF file generated successfully: '.$filename.'.pdf';
$RW->sessset($sname,'s');
$RW->redir($ADMIN->iurl($comp), true); // redirect to listing page


    // echo '<h2 style="text-align:center;">PDF Generated Successfully</h2>';
    // echo '<div style="text-align:center; margin-top:20px;">
    //         <a href="' . SITE_PATH_ADM . _MODS . "/invoice2024_25/pdf/" . $filename . '.pdf" download class="btn btn-success">Download PDF</a>
    //       </div>';
}
?>
