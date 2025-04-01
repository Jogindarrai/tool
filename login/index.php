<?php
///echo "SITE_FS_PATH: " . SITE_FS_PATH;
include('../lib/config.inc.php');
include('../login/login.inc.php');



//print_r($_POST);


if (!empty($_SESSION["AMD"][0])) {
  $RW->redir(SITE_PATH_ADM . "index.php");
  exit;
}






$LOGU = new LoginUser();



if($RW->is_post_back())

{
$otpquery =$PDO->db_query("select * from pms_admin_users where email ='".$_POST['email']."' and status='1'");
$otprow = $PDO->db_fetch_array($otpquery);
//print_r($otprow); exit;
if($otprow['forotp']=='1' && !$_POST['otp']){


		$digits = 6;
		$otp= str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
		$to = '91'.$otprow['mobile'];
		$_SESSION["OTP"]=$otp;
		$msg ='Hello '.$otprow['name'].'! One time password for login into ERP is '.$otp.' Please use the otp to complete your login';
	 	//$url = 'http://www.smsgatewaycenter.com/library/send_sms_2.php?UserName=regwala&Password=8gVhgnek&Type=Bulk&To='.urlencode($to).'&Mask=RGWALA&Message='.urlencode($msg);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://control.msg91.com/api/sendotp.php?template=&otp_length=6&authkey=229297A3RSNnx95b6179ba&message=".$msg."&sender=RGWALA&mobile=".$to."&otp=".$otp."&otp_expiry=&email=".$otprow['email']."",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "",
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);


$ADMIN->sessset('Please enter OTP, Send in your Registered Mobile', 's');
					}else if(isset($_POST['otp']) && $otprow['forotp']=='1' && $_POST['otp']==$_SESSION["OTP"]){

$flag = $LOGU->login($_POST);
		$stlogintime=$otprow['logintime']?$otprow['logintime'].',"'.time().'"':'"'.time().'"';
		$PDO->db_query("UPDATE pms_admin_users SET logintime='".$stlogintime."' where user_id ='".$otprow['user_id']."'");

$RW->redir(SITE_PATH_ADM."index.php");


				}

        else if($_POST['otp']!='' && $_SESSION["OTP"]!=$_POST['otp'] && $otprow['forotp']=='1'){
$ADMIN->sessset('Incorrect OTP! Please Re-Login', 'e');
$RW->redir(SITE_PATH_ADM."index.php");
						}

            else{

$flag = $LOGU->login($_POST);
		$stlogintime=$otprow['logintime']?$otprow['logintime'].',"'.time().'"':'"'.time().'"';
		$PDO->db_query("UPDATE pms_admin_users SET logintime='".$stlogintime."' where user_id ='".$otprow['user_id']."'");

$RW->redir(SITE_PATH_ADM."index.php");

						}




}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<link rel="shortcut icon" href="http://agapca.com/tool/images/favicon.ico">
<title>AGAP & Co</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.20.1/moment.min.js"></script>
<link href="../css/style.css" rel="stylesheet">

<script src="https://rawgit.com/tempusdominus/bootstrap-4/master/build/js/tempusdominus-bootstrap-4.js"></script>
<link rel="stylesheet" href="https://rawgit.com/tempusdominus/bootstrap-4/master/build/css/tempusdominus-bootstrap-4.css" />
<script src="<?=SITE_PATH?>js/highcharts.js"></script>
<script src="<?=SITE_PATH?>js/exporting.js"></script>
<script src="https://code.highcharts.com/modules/funnel.js"></script>



<!--ckeditor-->
<script src="<?=SITE_PATH?>ckeditor/ckeditor.js"></script>
<script src="<?=SITE_PATH?>ckeditor/samples/js/sample.js"></script>
 <script src='https://fullcalendar.io/releases/fullcalendar/3.9.0/fullcalendar.min.js'></script>
<link rel='stylesheet prefetch' href='https://fullcalendar.io/releases/fullcalendar/3.9.0/fullcalendar.min.css'>



</head>
<body class="my-login-page">
<section class="mtb50">
  <div class="container ">
    <div class="row justify-content-center">
      <div class="col-12 col-md-4">
        <div class="my-login-page">
          <div class="brand center-block text-center mb-3"> <img src="../images/logo.png"> </div>
          <div class="card fat">
            <div class="card-body">
            <?=$ADMIN->alert()?>
              <h4 class="card-title">Login</h4>
              <form method="POST">
                <div class="form-group">
                  <label for="email">E-Mail Address</label>
                  <input id="email" type="email" class="form-control" name="email"
value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required autofocus>
                </div>
                <div class="form-group">
                  <label for="password">Password </label>
                  <div style="position:relative">
                  <input id="password" type="password" class="form-control" name="password"
value="<?= isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '' ?>" required data-eye="">
                  </div>
                </div>
                <?php if(isset($otprow) && is_array($otprow) && isset($otprow['forotp']) && $otprow['forotp'] == '1') { ?>
    <div class="form-group">
        <label for="OTP">OTP</label>
        <div style="position:relative">
            <input id="OTP" type="text" class="form-control" name="otp" required data-eye="">
        </div>
    </div>
<?php } ?>

                <div class="form-group">
                  <label>
                    <input type="checkbox" name="remember">
                    Remember Me </label>
                  <a href="#" class="pull-right"> Forgot Password? </a> </div>
                <div class="form-group no-margin">
                  <button type="submit" class="btn btn-primary btn-block"> Login </button>
                </div>
                <!--
								<div class="margin-top20 text-center">
									Don't have an account? <a href="#">Create One</a>
							</div>-->
              </form>
            </div>
          </div>
          <div class="text-center"> <small>Copyright © 2023 AGSK & Co, All Rights Reserved </small> </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</section>

<!-- footer -->

</body>
</html>