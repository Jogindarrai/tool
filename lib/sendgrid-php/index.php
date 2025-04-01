<?php
//require 'vendor/autoload.php'; // If you're using Composer (recommended)
// Comment out the above line if not using Composer
// Comment out the above line if not using Composer
 require("sendgrid-php.php");
// If not using Composer, uncomment the above line and
// download sendgrid-php.zip from the latest release here,
// replacing <PATH TO> with the path to the sendgrid-php.php file,
// which is included in the download:
// https://github.com/sendgrid/sendgrid-php/releases
$email = new \SendGrid\Mail\Mail();
$email->setFrom("support@registrationwala.com", "registrationwala");
$email->setSubject("Sending with SendGrid is Fun");
$email->addTo("shivgupta.rw@gmail.com", "Shiv");
$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
$email->addContent(
    "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
);
$file_encoded = base64_encode(file_get_contents('SalesReprt20181031.xls'));
$email->addAttachment(
    $file_encoded,
    "application/text",
    "SalesReprt20181031.xls",
    "attachment"
);

$apiKey = '';
$sendgrid = new \SendGrid($apiKey);
try {
    $response = $sendgrid->send($email);
   print $response->statusCode() . "\n";
    print_r(response);
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: '. $e->getMessage() ."\n";
}
?>