<?php
//============================================================+
// File name   : example_003.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 003 for TCPDF class
//               Custom Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Custom Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf.php');
require_once('tcpdf_config_alt.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

	//Page header
	public function Header() {
		// Logo
		//$image_file = K_PATH_IMAGES.'logo_example.jpg';
		//$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->SetFont('helvetica', 'B', 20);
		// Title
		//$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$this->writeHTML('<h1 style="text-align: center; color: #aaa; text-decoration: underline;"><span class="editable2" data-title="cpmpenyname">APPOINTMENT LETTER</span></h1><hr>', true, 0, true, true);
		//<h1 style="text-align: center; color: #aaa; text-decoration: underline;"><span class="editable2" data-title="cpmpenyname">XYZ PRIVATE LIMITED</span></h1>
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-25);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->lastPage();
		$this->writeHTML('<p style="text-align: center;">CIN: <span class="editable2">................................</span></p>
<p style="text-align: center;">Reg Office:<span class="addrs">123, Delhi-123456</span></p>
<p style="text-align: center;">Email: <span class="editable2">................................</span></p>', true, 0, true, true);
$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
//$pdf->SetCreator(PDF_CREATOR);
//$pdf->SetAuthor('Nicola Asuni');
//$pdf->SetTitle('TCPDF Example 003');
//$pdf->SetSubject('TCPDF Tutorial');
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', 'BI', 12);

// add a page
$pdf->AddPage();

$html = '<div class="pagecntnt">
<div id="latercontent">
<p>Date: <span class="dates">XXXX</span></p>
<p><span class="select2" data-title="mra">Mr</span>. <span class="editable2" data-title="nameA">(Name of Candidate)</span></p>
<br>
<p>Dear <span class="mra">Ms</span>. <span class="nameA">(xxxxxxx)</span></p>
<p>With reference to your application and subsequent interview with us, we are pleased to appoint you as <span class="editable2">(Designation)</span> in our organization on the following terms and conditions.</p>
<p>Date of Joining: You have joined us on <span class="dates">(XXXXXXXX)</span>.</p>
<p><strong>Salary:</strong> Your Monthly Total Employment Cost to the company would be Rs.<span class="editable2" data-title="rupis" data-next="rsinword">__________</span> <span class="rsinword">(_____________________ only)</span>.</p>
<p><strong>Place/Transfer:</strong> Your present place of work will be at <span class="editable2">(New Delhi)</span>, but during the course of the service, you shall be liable to be posted / transferred anywhere to serve any of the Companys Projects or any other establishment in India or outside, at the sole discretion of the Management.</p>
<p><strong>Probation/Confirmation:</strong> You will be on a Probation period for the <span class="editable2">(mention period)</span>.</p>
<p>During the probation period your services can be terminated by serving <span class="editable2">(no. of days)</span> days’ prior notice on either side and without any reasons whatsoever. If your services are found satisfactory during the probation period, you will be confirmed with the company in written after<span class="editable2"> Two Months</span> in the present position, and thereafter your services can be terminated on one month’s prior notice on either side.</p>
<p><strong>Leave:</strong> You will be eligible to the benefits of the Company’s Leave Rules on your confirmation in the Company’s Service for one Leave every month.</p>
<p>During the period of your employment with the Company, you will devote full time to the work of the Company. Further, you will not take up any other employment or assignment or any office, honorary or for any consideration, in cash or in kind or otherwise, without the prior written permission of the Company.</p>
<p>1. You will not (except in the normal course of the Companys business) publish any article or statement, deliver any lecture or broadcast or make any communication to the press, including magazine publication relating to the Companys products or to any matter with which the Company may be concerned, unless you have previously applied to and obtained the written permission from the Company.</p>
<p>2. You will be required to maintain utmost secrecy in respect of Project documents, commercial offer, design documents, Project cost &amp; Estimation, Technology, Software packages license, Company’s polices, Company’s patterns &amp; Trade Mark and Company’s Human assets profile.</p>
<p>3. You will be required to comply with all such rules and regulations as the Company may frame from time to time.</p>
<p>4. Any of our technical or other important information which might come into your possession during the continuance of your service with us shall not be disclosed, divulged or made public by you even thereafter.</p>
<p>5. If at any time in our opinion, which is final in this matter you are found non- performer or guilty of fraud, dishonest, disobedience, disorderly behavior, negligence, indiscipline, absence from duty without permission or any other conduct considered by us deterrent to our interest or of violation of one or more terms of this letter, your services may be terminated without notice and on account of reason of any of the acts or omission the company shall be entitled to recover the damages from you.</p>
<p>6. You will not accept any present, commission or any sort of gratification in cash or kind from any person, party or firm or Company having dealing with the company and if you are offered any, you should immediately report the same to the Management.</p>
<p>7. This appointment letter is being issued to you on the basis of the information and particulars furnished by you in your application (including bio-data), at the time of your interview and subsequent discussions. If it transpires that you have made a false statement (or have not disclosed a material fact) resulting in your being offered this appointment, the Management may take such action as it deems fit in its sole discretion, including termination of your employment.</p>
<p>8. You will be responsible for safekeeping and return in good condition and order of all Company property, which may be in your use, custody or charge.</p>
<p>Please sign and return to the undersigned the duplicate copy of this letter signifying your acceptance.</p>
<p>We welcome you to the <span class="editable2" data-title="cmpname">________________________ Private Limited</span> and look forward to a fruitful collaboration.</p>
<p>With best wishes</p>
<p>For <span class="cmpname"> ________________________PRIVATE LIMITED</span></p>
<br> <br>
<p>Name:<span class="editable2"> ___________</span></p>
<p>Designation: <span class="editable2">CEO, Director</span></p>
</div></div>';

// set core font
$pdf->SetFont('helvetica', '', 10);

// output the HTML content
$pdf->writeHTML($html, true, 0, true, true);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output(dirname(__FILE__).'/pdf.pdf', 'F');

//============================================================+
// END OF FILE
//============================================================+
