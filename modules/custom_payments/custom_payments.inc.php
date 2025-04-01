<?php
class Pages extends dbc
{
	
	 public function  add($data)
	 {
		    @extract($data);
	        $query=parent::db_query("select * from #_".tblName." where pid ='".$pid."' "); 
	        if($query->rowCount()==0)
	        {
				$tdquery=parent::db_query("select * from #_traveller_details where email ='".$email."' "); 
				if($tdquery->rowCount()>0){
					$row=parent::db_fetch_array($tdquery);
					 $data['user_id']=$row['pid'];
					}else{
						$data['password']='TR@'.rand(100, 999);
						$data['user_id'] = parent::sqlquery("rs","traveller_details",$data);
						
						}
			
				$data['created_on']=date('Y-m-d H:i:s');
				$data['create_by']=$_SESSION["AMD"][0];
				$data['shortorder']=parent::getSingleresult("select max(shortorder) as shortorder from #_".tblName." where 1=1 ")+1;
				$customeorderid=parent::sqlquery("rs",tblName,$data);
				
				
			if($_FILES['attachment'][name]){
		$data['attachment'] = $RW->uploadFile3($path,$_FILES['attachment']['name'],'attachment',strtolower($data['subject']));
	}

		//$post=$data;
		
				$mailbody='
<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td><table  border="0"  style="max-width:560px; width:100%; margin: 0 auto; border:#cdd1d2 solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:14px;  " cellpadding="0" cellspacing="0">
        <tr>
          <td style="border-bottom:#cdd1d2 solid 1px; padding:15px 15px;"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="100%" align="left"> <table width="50%" cellpadding="0" align="left" cellspacing="0" style="width:50%; min-width:200px">
              <tr>
                <td><a href="https://www.toursrepublic.com/"><img src="https://www.toursrepublic.com/pms/images/logo.png" width="180px"  alt="" style=" max-width:100%;" /></a></td>
              </tr>
            </table>
            <table width="50%" cellpadding="0"  cellspacing="0" style="width:50%; min-width:200px">
        <tr>
          <td><table  border="0"  style="min-width:100px;" align="right">
              <tr>
                <td><a href="https://www.facebook.com/toursrepublics/"  target="_blank"><img src="https://www.toursrepublic.com/images/emailer/socialmedia/facebook.png" width="24"/></a></td>
                <td><a href="https://twitter.com/toursrepublic" target="_blank"><img src="https://www.toursrepublic.com/images/emailer/socialmedia/twitter.png" width="24"/></a></td>
                <td><a href="https://www.linkedin.com/company/toursrepublic/" target="_blank"><img src="https://www.toursrepublic.com/images/emailer/socialmedia/linkdin.png" width="24"/></a></td>
                <td><a href="https://plus.google.com/u/0/107859376220020955121" target="_blank"><img src="https://www.toursrepublic.com/images/emailer/socialmedia/gplus.png" width="24"/></a></td>
                <td><a href="https://in.pinterest.com/toursrepublic/" target="_blank"><img src="https://www.toursrepublic.com/images/emailer/socialmedia/pint.png" width="24"/></a></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</td>
</tr>
<tr>
  <td style="padding:15px; border-bottom:#cdd1d2 solid 1px;"><p style="font-weight:700;">Hello <span style="color:#81b537;">'.$name.'</span> </p>
    <p style="font-weight:600;"> Thanks for your Business. </p>
    <p> We are glad that you have choose <strong>'.$servicename.'</strong>. You are requested to make payment of <strong>'.$amount.'</strong> </p>
    <table width="100%" border="0" cellspacing="0" cellpadding="10" style="text-align:center; font-weight:800; margin-top:30px;">
      <tr>
        <th bgcolor="#ebebeb" style="border-right:solid #f4f4f4 1px;"">Service Name</th>
            <th bgcolor="#ebebeb"> Amount(In AED)</th>
      </tr>
      <tr>
        <td bgcolor="#81b537" style="color:#FFF; border-right:solid #bcd895 1px;"">'.$servicename.'</td>
        <td bgcolor="#81b537"  style="color:#FFF; ">'.$amount.'</td>
      </tr>
    </table>
    <p style="background-color:#81b537; color:#FFF; padding:10px; border-radius:7px;  margin:20px auto; text-align:center; width:120px;"><a href="https://www.toursrepublic.com/pay-now/'.parent::encrypt_decrypt('encrypt',$customeorderid).'" style="color:#FFF; font-weight:700; text-decoration:none;">Pay Now</a> </p>
    
    </td>
</tr>


<tr>
  <td style="padding:15px; font-size:14px; font-weight:bold;">For Any Guidance Feel Free to Reach us</td>
</tr>
<tr>
  <td style="background-color:#54880c; color:#FFF; padding:15px; font-size:12px;">
  
  <table width="30%" border="0" align="left" style="min-width:150px;">
  <tr>
    <td valign="middle"> <img src="https://www.toursrepublic.com/images/emailer/india.jpg" height="10" /></td>
    <td valign="middle">+91-8882-312-312</td>
  </tr>
</table>
<table width="40%" border="0" align="left" style="min-width:150px;">
  <tr>
   <td valign="middle"><img src="https://www.toursrepublic.com/images/emailer/mail.png"  height="10"/></td>
    <td valign="middle"> <a href="mailto:support@toursrepublic.com" style="color:#FFF; text-decoration:none;">support@toursrepublic.com</a></td>
  </tr>
</table>
<table width="30%" border="0" align="left" style="min-width:150px;">
  <tr>
     <td valign="middle"><img src="https://www.toursrepublic.com/images/emailer/UAE.jpg"  height="10"/></td>
     <td valign="middle">+971-551-860-490</td>
  </tr>
</table>
  
  
  
  </td>
</tr>

</table>
</td>
</tr>
</table>
';
if($_FILES['attachment'][name]){
$mail_arry=array(
			'to'=>$data['email'],
			'from_name'=>(($fname)?$fname:parent::getSingleresult("select company from #_setting where `pid`='1'")),
			'from'=>(($femail)?$femail:parent::getSingleresult("select email from #_setting where `pid`='1'")),
			'subject'=>$subject,
			'message'=>$mailbody,
			'file_name'=>$data['attachment'],
			'file_path'=>$path.'/'.$data['attachment']
			);
}else{
	
	/*$mail_arry=array(
			'to'=>$data['email'],
			'from_name'=>(($fname)?$fname:parent::getSingleresult("select company from #_setting where `pid`='1'")),
			'from'=>(($femail)?$femail:parent::getSingleresult("select email from #_setting where `pid`='1'")),
			'cc'=>'vikram@registrationwala.com',
			'subject'=>$subject,
			'message'=>$mailbody
			);*/
	
 $to=$data['email'];
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: ToursRepublic <support@toursrepublic.com>' . "\r\n";
		
		//$headers .= 'Reply-To:support@toursrepublic.com,vikram@registrationwala.com,mayank@registrationwala.com,cagauravbansal1@gmail.com' ."\r\n";
	   // $headers .= 'Cc: support@registrationwala.com,vikram@registrationwala.com,mayank@registrationwala.com,cagauravbansal1@gmail.com'. "\r\n";
		$subject=$subject;
		$mails=mail($to, $subject, $mailbody, $headers, '-fsupport@registrationwala.com');
}
			
		        parent::sessset('Record has been added', 's');
	            $flag =1;
		    }else {
			    parent::sessset('Record has already added', 'e');
				$flag =0;
			}
			
			return $flag; 
	 }
	 
	 public function  update($data)
	 {
		   @extract($data);
	       $query=parent::db_query("select * from #_".tblName." where  pid ='".$pid."' and pid='".$updateid."' "); 
	       if($query->rowCount()==0)
	       {
				 //$data['password']=$this->password($data['password']);
		         // parent::sqlquery("rs",'admin_users',$data);
				 $data['modified_on']=date('Y-m-d H:i:s');
			     parent::sqlquery("rs",tblName,$data,'pid',$updateid);
		         parent::sessset('Record has been updated', 's');
	             $flag =1;
		    }else {
			    parent::sessset('Record has already added', 'e');
				$flag =0;
			}
			
			return $flag;  
		 
	 }
	 
	 public function  delete($updateid)
	 {
		   if(is_array($updateid))
		   {
			   $updateid=implode(',',$updateid);
		   }
		   
		 
		    parent::db_query("delete from #_".tblName." where pid in ($updateid)");
		   
		   
	 }
	 
	 public function status($updateid,$status)
	 {
		   if(is_array($updateid))
		   {
			   $updateid=implode(',',$updateid);
		   }
		   
		   parent::db_query("update  #_".tblName." set status='".$status."' where pid in ($updateid)");
		   
	 }
	 
	  
	 
	 public function  display($start,$pagesize,$fld,$otype,$search_data,$zone,$mtype,$extra,$extra1,$extra2)
	 {
		$start = intval($start); 
	   	$columns = "select * "; 
		
		if(trim($search_data)!='')
		{
		   $wh=" and (name like '%".$search_data."%' or email like '%".$search_data."%' or phone like '%".$search_data."%' or servicename like '%".$search_data."%' or amount like '%".$search_data."%') ";	
		}
		
		$sql = " from #_".tblName." where 1 ".$zone.$mtype.$extra.$extra1.$extra2.$wh;
		$order_by == '' ? $order_by = (($ord)?'orders':(($fld)?$fld:'pid')) : true;
        $order_by2 == '' ? $order_by2 = (($otype)?$otype:'DESC') : true;
		$sql_count = "select count(*) ".$sql; 
		$sql .= "order by $order_by $order_by2 ";
		$sql .= "limit $start, $pagesize ";
		$sql = $columns.$sql;
		$result = parent::db_query($sql);
		$reccnt = parent::db_scalar($sql_count);
		return array($result,$reccnt);
	 }
	  
	 
	
}
?>