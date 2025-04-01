<?php

//ini_set('display_errors', 1);

//ini_set('display_startup_errors', 1);

//error_reporting(E_ALL);

//

//use PHPMailer\PHPMailer\PHPMailer;

//use PHPMailer\PHPMailer\SMTP;

//use PHPMailer\PHPMailer\Exception;

//

//require __DIR__ . '/../../PHPMailer/src/Exception.php';

//require __DIR__ . '/../../PHPMailer/src/PHPMailer.php';

//require __DIR__ . '/../../PHPMailer/src/SMTP.php';

//if ($_SERVER['REMOTE_ADDR'] == '182.69.11.18') {

//    echo "hello1";

//    $mail = new PHPMailer(true);

//

//    try {

//        //Server settings

//        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output

//        $mail->isSMTP();                                            // Send using SMTP

//        $mail->Host = 'agapca.com';                    // Set the SMTP server to send through

//        $mail->SMTPAuth = true;                                   // Enable SMTP authentication

//        $mail->Username = 'support@agapca.com';                     // SMTP username

//        $mail->Password = 'support@agapca.com';                               // SMTP password

//        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted

//        $mail->Port = 465;                                    // TCP port to connect to

//        //Recipients

//        $mail->setFrom('support@agapca.com', 'Support');

//        $mail->addAddress('akhileshkarne@gmail.com', 'Akhilesh Karn');     // Add a recipient

////        $mail->addAddress('ellen@example.com');               // Name is optional

//        $mail->addReplyTo('support@agapca.com', 'Support');

////        $mail->addCC('cc@example.com');

////        $mail->addBCC('bcc@example.com');

//

//        // Attachments

////        $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments

////        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

//        // Content

//        $mail->isHTML(true);                                  // Set email format to HTML

//        $mail->Subject = 'Here is the subject';

//        $mail->Body = 'This is the HTML message body <b>in bold!</b>';

//        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

//

//        $mail->send();

//        echo 'Message has been sent';

//    } catch (Exception $e) {

//        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

//    }

//    echo 'hi';

//    exit;

//}

?>

<h2 style="text-align:center;">Please wait.........</h2>

<?php

include(FS_ADMIN . _MODS . "/invoice2024_25/invoice2024_25.inc.php");
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';



if ($uid) {

    $query = $PDO->db_query("select * from #_" . tblName . " where pid ='" . $uid . "' ");

    $row = $PDO->db_fetch_array($query);

    @extract($row);

    $keys = explode(":", $itemservice);

    $scode = explode(":", $sac);

    $valus = explode(":", $itempriceservice);

    $adonkeys = explode(":", $itemadon);

    $adonvalus = explode(":", $itempriceadon);



    $allkeys = '';

    $saccode = '';

    $allval = '';

    $adonallkeys = '';

    $adonallval = '';

    foreach ($keys as $key) {

        $allkeys .= '<p style="padding-top:5px;"><strong>' . $key . '</strong></p>';

    };



    foreach ($scode as $ss) {

        $saccode .= '<p style="padding-top:5px;"><strong>' . $ss . '</strong></p>';

    };



    foreach ($valus as $val) {

        $allval .= $val ? '<p style="padding-top:5px;">' . $val . '/-</p>' : '<p>&nbsp;</p>';

    };

    foreach ($adonkeys as $adonkey) {

        $adonallkeys .= '<p style="padding-top:5px;"><strong>' . $adonkey . '</strong></p>';

    };



    foreach ($adonvalus as $adonval) {

        $adonallval .= $adonval ? '<p style="padding-top:5px;">' . $adonval . '/-</p>' : '<p>&nbsp;</p>';

    };

    $sertax = $strn ? "<br><strong>GST Identification Number: </strong>" . $strn : "";

    $placetosupply = $placetosupply ? "<br><strong>Place to Supply: </strong>" . $placetosupply : "";





    $html = '

<div class="invicecon">

<table border="0" cellspacing="0" cellpadding="8" width="100%"  style="border:solid #ddd 1px;">

  <tr>

    <td width="43%" valign="top"><p><strong>AGSK & CO.</strong><br />

      <strong>PAN:</strong> ' . $pan . ' <br />

      <strong>GSTIN:</strong> ' . $servicetaxno . '<br />

      <strong>Invoice No.:</strong> ' . $inviceno . ' <br />

      <strong>Dated:</strong> ' . date('l jS \of F Y', strtotime($invicedate)) . ' <br />

      <strong>Relationship Manager:</strong> ' . $rlmanager . ' </p></td>

    <td width="56%" valign="top"><p align="left"><strong>Customer Name: ' . $customername . '</strong> <br />

      <strong>Email ID: </strong>' . $customeremail . ' <br />

      <strong>Contact No.: </strong>' . $customerno . '<br />

      <strong>Address: </strong>' . $addressofclient .

            $sertax . $placetosupply . '

      </p></td>

  </tr>

</table>

</div>

<div class="invicecon" style="margin-bottom:0px;">

<table border="1" cellspacing="0" cellpadding="5" width="100%">

  <tr>

 <td width="65%" valign="top" ><p><strong>DESCRIPTION OF THE SERVICES</strong></p></td> <td width="20%" valign="top"><p><strong>SAC Code</strong></p></td>

    <td width="14%" align="right" valign="top" ><p align="right"><strong>AMOUNT</strong></p></td>

  </tr>

  <tr>

    <td width="65%" height="150" valign="middle" style="vertical-align:middle">' . $allkeys . '</td> 

    <td width="20%" height="150" valign="middle" style="vertical-align:middle">' . $saccode . '</td>

    <td width="14%" height="150" align="right" valign="middle">' . $allval . '</td>

  </tr>';

   // if($row['gstApplicable']=='yes'){

    if ($row['placetosupply'] != 'Delhi - 07') {

        $html .= '<tr>

    <td width="85%" valign="top" colspan="2"><p align="left">IGST @ 18 %</p></td>

    <td width="14%" align="right" valign="top"><p>' . $hsrtax . '/-</p></td>

  </tr>';

    } else if ($row['placetosupply'] == 'Delhi - 07') {

        $html .= '

  <tr>

    <td width="85%" valign="top" colspan="2"><p align="left">S GST @ 9%</p></td>

    <td width="14%" align="right" valign="top"><p><span id="sbtax">' . $hsbtax . '</span>/-</p></td>

  </tr>

  <tr>

    <td width="85%" valign="top" colspan="2"><p align="left">C GST @ 9%</p></td>

    <td width="14%" align="right" valign="top"><p><span id="kktax">' . $hkktax . '</span>/-</p></td>

  </tr>';

    }

   // }else{

       

   // }

    $html .= '

  <tr>

    <td width="85%" valign="top" colspan="2" ><p><strong>TOTAL:</strong></p></td>

    <td width="14%" align="right" valign="top" ><p><strong>' . $hmaintotal . '/-</strong></p></td>

  </tr>

  <tr>

    <td width="85%" height="100" valign="middle" style="vertical-align:middle" colspan="2">' . $adonallkeys . '</td>

    <td width="14%" height="100" align="right" valign="middle">' . $adonallval . '</td>

  </tr>

  <tr>

    <td width="85%" valign="top" colspan="2" ><p><strong>GROSS TOTAL:</strong> <br />

      (<strong>In Words:</strong>' . $hinwords . ')</p></td>

    <td width="14%" align="right" valign="top" ><p><strong>' . $hgrasstotal . '/-</strong></p></td>

  </tr>

</table></div>

<div class="invicecon" style="margin-top:0">

';

    if($paytobank=='icici'){

        $html.='<table border="0" cellspacing="0" cellpadding="5" width="100%"><tr><td width="80%">
        <p><strong> "A G A P & CO."</strong><br>
                <strong>STATE BANK OF INDIA</strong> (Current A/C)<br />
                 BRANCH - <strong>  COLLECTORATE BRANCH  </strong><br />
                 ACCOUNT NO. - <strong>34632779143, </strong>
                 IFSC  Code -<strong>:SBIN0006262</strong></p>
                 </td>
                 <td><img src="https://agskca.com/tool/images/agsksign.png"></td>
     </tr>
  </table>';

    }else{

        $html.='<table border="0" cellspacing="0" cellpadding="5" width="100%"><tr><td width="50%">
        <div style="text-align:left;">Kindly make payment in cash or through net banking  by NEFT/ IMPS or issue a cheque in favour of&nbsp;</div>
                <div><strong>"AGSK & CO."</strong><br>
                 <strong>ICICI  Bank</strong>(Current A/C)<br />
                  BRANCH - <strong>Tagore Park Model Town</strong><br />
                  ACCOUNT NO. - <strong>399405000597, </strong>
                  IFSC  Code -<strong>ICIC0003994</strong></div>
                  </td>
                   <td style="text-align:right;"> <img src="https://agskca.com/tool/images/agsksign.png"></td>
                  
    </tr>
  </table> ';

    }

$html.='</div>';

    if ($uid && !$sendmail) {



        if ($invoicetype == 'Tax Invoice') {



            class MYPDF extends TCPDF {



                public function Header() {

                    //$this->SetY(1);

                    $this->SetFont('helvetica', 'B', 14);

                    $this->writeHTML('<div style="text-align:right; height:60px" class="header"><span>Tax Invoice</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img style="height:60px;" src="http://agskca.com/images/logo.png" /></div>');

                }



                public function Footer() {

                    $this->SetY(-20);

                    $this->SetFont('helvetica', 'I', 8);

                    $this->writeHTML('<p><div class="footer" style="text-align:center;">137, KD Block, Pitampura, New Delhi 110034<br /><strong>Mobile:</strong>+91 9810602899 <strong>E-mail:</strong> sachin@agskca.com</div>');

                }



            }



        } else {



            class MYPDF extends TCPDF {



                public function Header() {

                    //$this->SetY(1);

                    $this->SetFont('helvetica', 'B', 14);
                    $this->writeHTML('
                          <table style="border-top: 1px solid ddd; border-left: 1px solid ddd; border-right: 1px solid ddd;background-color:#ddd"; cellspacing="0" cellpadding="13" width="100%">
                          <tr>
                            <td width="33%"><img style="height:50px;" src="http://agskca.com/images/logo.png" /></td>
                          <td width="33%" style="text-align:center"valign="center" style="padding-top:30px; text-align:center; font-size:22px; font-weight:bold;" >Invoice</td>
                          <td width="33%"></td>
                          </tr>
                          </table>
                          ');

                }



                public function Footer() {

                    $this->SetY(-20);
                   
                    $this->SetFont('helvetica', 'I', 8);

                    $this->writeHTML('<div class="footer" style="text-align:center;">137, KD Block, Pitampura, New Delhi 110034<br /><strong>Mobile:</strong>9899732503 <strong>E-mail:</strong> sachin@agskca.com</div>');

                }



            }



        }



        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {

            require_once(dirname(__FILE__) . '/lang/eng.php');

            $pdf->setLanguageArray($l);

        }



// ---------------------------------------------------------

// set font

        $pdf->SetFont('helvetica', '', 10);



// add a page

        $pdf->AddPage();

        $pdf->writeHTML($html, true, false, true, false, '');



// reset pointer to the last page

// ---------------------------------------------------------

//Close and output PDF document

        $pdf->Output(__DIR__ . '/pdf/' . $filename . '.pdf', 'F');

    }

//ob_end_clean();

    if (file_exists(__DIR__ . '/pdf/' . $filename . '.pdf')) {





//mail_attachment($filename.'.pdf', $path, $customeremail, $from_mail, $from_name, $replyto, $subject, $message);



        $sname = 'Record has been added/Update. (' . $filename . '.pdf) File generated successfully';

        $RW->sessset($sname, 's');

        ?>

        <div class="container">

            <div class="row">

                <div class="col-lg-9 mx-auto mb-4">

                    <div class="row p-none">

                        <div class="col">

                            <a class="btn btn-info btn-block" href="javascrpt:void(0)" onclick="preview()">Preview</a>

                        </div>

                        <div class="col">

                            <a class="btn btn-success  btn-block" href="<?= $ADMIN->iurl($comp . ('&mode=add&uid=' . $uid)) ?>">Modify</a>

                        </div>

                        <div class="col">

                            <a class="btn btn-warning  btn-block" href="<?= SITE_PATH_ADM . _MODS . '/invoice2024_25/pdf/' . $filename . '.pdf' ?>" download><i class="fa fa-download"></i> Download</a>

                        </div>

        <?php if (in_array('8', $accessmodulepoint)) { ?>

                            <div class="col">

                                <a class="btn btn-secondary  btn-block" href="<?= $ADMIN->iurl($comp . (($raid) ? '&raid=' . $raid : '')) ?>">Manage</a>

                            </div>

                            <div class="col">

                                <a class="btn btn-warning  btn-block" href="<?= $ADMIN->iurl($comp . ('&mode=invoice2024_25&uid=' . $uid . '&sendmail=sent')) ?>">Send Mail</a>

                            </div>

        <?php } ?>

                    </div>

                </div>

            </div>

        </div>



                        <!--<div class="preview"><a class="uibutton" href="javascrpt:void(0)" onclick="preview()">Preview</a><a class="uibutton" href="<?= $ADMIN->iurl($comp) ?>">Manage</a> <a class="uibutton" href="<?= $ADMIN->iurl($comp . ('&mode=add&uid=' . $uid)) ?>">Modify</a> <a class="uibutton" href="<?= $ADMIN->iurl($comp . ('&mode=invoice2024_25&uid=' . $uid . '&sendmail=sent')) ?>">Send Mail</a> <a class="uibutton" href="<?= $ADMIN->iurl('project' . ('&mode=add&invoiceId=' . $uid)) ?>">Genrate order</a></div>-->

        <div style="max-width:60%; margin:auto">

        <?php echo $html ?>

        </div>

        <script>

            function preview() {

                var left = ($(window).width() / 2) - (900 / 2),

                        top = ($(window).height() / 2) - (600 / 2),

                        popup = window.open("<?= SITE_PATH_ADM . _MODS . '/invoice2024_25/pdf/' . $filename . '.pdf' ?>", "popup", "width=900, height=600, top=" + top + ", left=" + left);

            }

        </script>

        <?php



        function sendmail($file, $mailto, $subject, $message, $replyto = 'support@registrationwala.com', $from_mail = 'support@registrationwala.com', $from_name = 'Monetic Corp Consultants Private Limited') {

            $cc = 'camayankgoel13@gmail.com';

            $cc2 = 'rwsagarverma.sv34@gmail.com';

            $content = file_get_contents($file);

            $content = chunk_split(base64_encode($content));

            $uids = md5(uniqid(time()));

            $name = basename($file);

// header

            $header = "From: " . $from_name . " <" . $from_mail . ">\r\n";

            $header .= "CC: " . $cc . "\r\n";

            $header .= "CC: " . $cc2 . "\r\n";

            $header .= "CC: " . $bcc . "\r\n";



            $header .= "Reply-To: " . $replyto . "\r\n";

            $header .= "MIME-Version: 1.0\r\n";

            $header .= "Content-Type: multipart/mixed; boundary=\"" . $uids . "\"\r\n\r\n";



// message & attachment

            $nmessage = "--" . $uids . "\r\n";

            $nmessage .= "Content-type:text/html; charset=iso-8859-1\r\n";

            $nmessage .= "Content-Transfer-Encoding: 7bit\r\n\r\n";

            $nmessage .= $message . "\r\n\r\n";

            $nmessage .= "--" . $uids . "\r\n";

            $nmessage .= "Content-Type: application/octet-stream; name=\"" . $name . "\"\r\n";

            $nmessage .= "Content-Transfer-Encoding: base64\r\n";

            $nmessage .= "Content-Disposition: attachment; filename=\"" . $name . "\"\r\n\r\n";

            $nmessage .= $content . "\r\n\r\n";

            $nmessage .= "--" . $uids . "--";



            if (mail($mailto, $subject, $nmessage, $header)) {

                $sucsess = 'Mail send successfully.';

                return $sucsess; // Or do something here

            } else {

                $error = 'Mail not send. Some thing went wrong please try again';

                return $error;

            }

        }



        $path = FS_ADMIN . _MODS . '/' . $comp . '/pdf/' . $filename . '.pdf';

        $subject = 'Invoice';

        $message = '<html><body><div style="max-width:700px;border: 1px solid #ccc;padding: 10px;">';

        $message .= '<h4 style="text-align:center;background: #ccc;padding: 8px;">RW Customer No.-' . $inviceno . '.</h4>';

        $message .= '<p>Hi ' . $customername . '</p>';

        $message .= '<p>Greetings! Thanks for choosing us.</p>';

        $message .= '<p>Invoice for the services availed by you is attached.</p>';

        $message .= '<h4 style="text-align:center;background: #ccc;padding: 8px;">Bill Details</h4>';



        $message .= $html;



        $message .= '<p>If you need any further assistance with your order, mail us at support@registrationwala.com</p>';

        $message .= '<p>We hope to see you soon again!</p>';

        $message .= '<h4>Registrationwala.com</h4>';

        $message .= '</div></body></html>';

        if ($sendmail) {

            $query = $PDO->db_query("update #_" . tblName . " set status=1 where pid ='" . $uid . "' ");

            $mailer = sendmail($path, $customeremail, $subject, $message);

            $sname = 'Record has been added/Update. (' . $filename . '.pdf) File generated successfully & ' . $mailer;

            $RW->sessset($sname, 's');

            $RW->redir($ADMIN->iurl($comp . (($start) ? '&start=' . $start : '') . (($subpage_id) ? '&subpage_id=' . $subpage_id : '')), true);

        }

    } else {

        $RW->sessset('File Not generated. Edit and submit again', 'e');

        $RW->redir($ADMIN->iurl($comp . ('&mode=add&uid=' . $uid)), true);

    }

}



//$RW->redir($ADMIN->iurl($comp.(($start)?'&start='.$start:'').(($subpage_id)?'&subpage_id='.$subpage_id:'')), true);

?>

<style>

    .preview {text-align: center; padding: 20px 0; margin-top: 50px;}

    .preview a {padding: 0px 15px; margin: 10px;line-height: 28px;font-size: 18px;}

</style>