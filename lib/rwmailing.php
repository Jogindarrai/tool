<?php

/*

# @package BSC CMS



# Copy right code 

# The base configurations of the BSC CMS.

# This file has the following configurations: MySQL settings, Table Prefix,

# by visiting {config.inc.php} Codex page. You can get the MySQL settings from your web host.



# MySQL settings - You can get this info from your web host

# The name of the database for BSC CMS

# Developer by Ajay Maurya

# eMail: ajaymaurya.it@gmail.com


*/



class Rwmail extends dbc 
{
	
		public function rwamadd($subject, $message, $fname='', $femail=''){
			
			$recipients_query = $this->db_query("select * from pms_admin_users where user_type='1' and status='1'");
			$recipients = array();
				while($recipients_rows = $this->db_fetch_array($recipients_query)){
					$recipients[] = $recipients_rows['email'];
					 }
		$to=implode(',', $recipients);
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.(($fname)?$fname:$this->getSingleresult("select company from #_setting where `pid`='1'")).' <'.(($femail)?$femail:$this->getSingleresult("select email from #_setting where `pid`='1'")).'>' . "\r\n";
		$body = '
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Registrationwala</title>
    </head>
    <body>
        <p>Here are the birthdays upcoming in August!</p>
        <table>
            <tr>
                <th>Person</th><th>Day</th><th>Month</th><th>Year</th>
            </tr>
            <tr>
                <td>Joe</td><td>3rd</td><td>August</td><td>1970</td>
            </tr>
            <tr>
                <td>Sally</td><td>17th</td><td>August</td><td>1973</td>
            </tr>
        </table>
    </body>
</html>
';
		@mail($to, $subject, $body, $headers);
	}
	
	}




?>