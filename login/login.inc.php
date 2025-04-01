<?php



class LoginUser extends dbc

{

	

	 public function  login($data)

	 {

		    @extract($data);

			//echo $data['password'];

			$password=$this->password($data['password']);

			

			if(str_replace('www.','',$_SERVER['HTTP_HOST']) =='formalfunky.com')

			{

			  $ww =" and live_user='1' ";	

			}

			

			$query=parent::db_query("select * from pms_admin_users where email ='".$email."' and password ='".$password."' and status='1' ".$ww); 

			//echo mysql_num_rows($query);

			//exit;

			if($query->rowCount()==1)

	        {

				$row = parent::db_fetch_array($query);

				$_SESSION["AMD"][0] =$row['user_id'];

				$_SESSION["AMD"][1] =$row['name'];

				$_SESSION["AMD"][2] =$row['email'];
                 $_SESSION["AMD"][4] =$row['mobile'];
				$_SESSION["AMD"][3] =$row['user_type'];
				$_SESSION["AMD"][5] =$row['dpid'];

				$flag =1;

				$mail_array = array(

				 'to' => 'cagauravbansal1@gmail.com',

				 'from_name' => 'Monetic Corp Consultants Private Limited',

				 'from' => 'support@registrationwala.com',

				 'subject' => 'PMS Login after office time.',

				 'message' => $row['name'].' has log in at '.date('l jS \of F Y h:i:s A'),

				 'cc' => 'vikram@registrationwala.com',

				 //'bcc' => 'ajaymaurya.rw@gmail.com',

				 );

				if((date("Hi") > 1000 && date("Hi") < 1830 ) || date("l")=='Sunday'){

				//Working hours code here

				}else{

					$this->send_mail($mail_array);

					}

				

				

		    }else {

			    parent::sessset('Email and password is incorrect.', 'e');

				$flag =0;

			}

			

			return $flag; 

	 }

	 

	 public function password($password)

	 {

	        $password=md5($password); 

		    $password=base64_encode($password); 	

		    return $password;

	 }

	 

	 public function send_mail($mailer_arr){

		 $mailer_arr = array_merge( array( 'to'=>'', 'from_name'=>'', 'from'=>'', 'subject'=>'', 'message'=>'', 'cc'=>'', 'bcc'=>'', 'file_name'=>'', 'file_path'=>'' ), $mailer_arr );

		 $EmailTo = strip_tags($mailer_arr['to']);

		 $EmailFrom = strip_tags($mailer_arr['from']);

		 $EmailFromNmae = strip_tags($mailer_arr['from_name']);

		 $EmailSubject = $mailer_arr['subject'];

		 $EmailMessage = stripslashes($mailer_arr['message']);

		 $EmailCc = strip_tags($mailer_arr['cc']);

		 $EmailBcc = strip_tags($mailer_arr['bcc']);

		 $filepath = $mailer_arr['file_path'];

		 $filename = $mailer_arr['file_name'] ? $mailer_arr['file_name'] : end(explode("/",$filepath));

		 $eol = PHP_EOL;

		 $headers = "";

		 if( !empty($EmailFromNmae) ){

		 if( !empty($EmailFrom) )

		 $headers  .= "From: ".$EmailFromNmae.'<'.$EmailFrom.'>'.$eol; 

		 }else{

		 if( !empty($EmailFrom) )

		 $headers  .= "From: ".$EmailFrom.$eol; 

		 }

		 if( !empty($EmailFrom) )

		 $headers .= "Reply-To: ". $EmailFrom .$eol;

		 if( !empty($EmailCc) )

		 $headers .= "CC: ".$EmailCc.$eol;

		 if( !empty($EmailBcc) )

		 $headers .= "BCC: ".$EmailBcc.$eol;

		 $headers .= "MIME-Version: 1.0".$eol; 

		 if( !isset( $mailer_arr['file_path'] ) || $mailer_arr['file_path'] == '' ){ 

		 $headers .= "Content-type: text/html".$eol;

		 if(mail($EmailTo, $EmailSubject, $EmailMessage, $headers)) 

		 return true;

						else 

						return false;

		 

		 }

		 $attachment = chunk_split( base64_encode(file_get_contents($filepath)) );

		 $separator = md5(time());  

		 $headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";

		 $body = "";

		 $body .= "--".$separator.$eol;

		 $body .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;

		 $body .= "Content-Transfer-Encoding: 7bit".$eol.$eol;//optional defaults to 7bit

		 $body .= $EmailMessage.$eol;

		 // attachment

		 $body .= "--".$separator.$eol;

		 $body .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol; 

		 $body .= "Content-Transfer-Encoding: base64".$eol;

		 $body .= "Content-Disposition: attachment".$eol.$eol;

		 $body .= $attachment.$eol;

		 $body .= "--".$separator."--";

		 // send message

		 if (mail($EmailTo, $EmailSubject, $body, $headers)) {

		 return true;

		 }

		 else {

		 return false;

		 }

}

}

?>