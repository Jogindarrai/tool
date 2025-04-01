<?php
if($_SESSION["AMD"][3]!=1){
	//$BSC->redir(SITE_PATH_ADM);
	}

class AdminUsers extends dbc

{

	

	 public function  add($data)

	 {

		    @extract($data);

	        $query=parent::db_query("select * from pms_admin_users where email ='".$email."' "); 

	        if($query->rowCount()==0)

	        {

				$data['password']=$this->password($data['password']);

				$data['created_on']=@date('Y-m-d H:i:s');

				$data['create_by']=$_SESSION["AMD"][0];

				$data['shortorder']=parent::getSingleresult("select max(shortorder) as shortorder from pms_admin_users where 1=1 ")+1;

				parent::sqlquerywithprefix("rs",'pms_admin_users',$data);

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

	       $query=parent::db_query("select * from pms_admin_users where email ='".$email."' and user_id!='".$updateid."' "); 

	       if($query->rowCount()==0)

	       {
			 /*  if($data['password']==''){
				   
		   $pass=parent::getSingleResult("select password from pms_admin_users where user_id ='".$updateid."'");
				  $data['password']=$pass;  
				   } else{

				 $data['password']=$this->password($data['password']);
				   }*/
		         // parent::sqlquerywithprefix("rs",'pms_admin_users',$data);

				 $data['modified_on']=@date('Y-m-d H:i:s');

			     parent::sqlquerywithprefix("rs",'pms_admin_users',$data,'user_id',$updateid);

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

		   

		    parent::db_query("delete from pms_admin_users where user_id in ($updateid)");

		   

		   

	 }

	 

	 public function status($updateid,$status)

	 {

		   if(is_array($updateid))

		   {

			   $updateid=implode(',',$updateid);

		   }

		   

		   parent::db_query("update  pms_admin_users set status='".$status."' where user_id in ($updateid)");

		   

	 }

	 

	  

	 

	 public function  display($start,$pagesize,$fld,$otype,$search_data)

	 {

		$start = intval($start); 

	   	$columns = "select * "; 

		

		if(trim($search_data)!='')

		{

		   $wh=" and (name like '%".$search_data."%' or email like '%".$search_data."%' or user_type like '%".$search_data."%') ";	

		}

		

		$sql = " from pms_admin_users where 1 ".$zone.$mtype.$extra.$extra1.$extra2.$wh;

		$order_by == '' ? $order_by = (($ord)?'orders':(($fld)?$fld:'shortorder')) : true;

        $order_by2 == '' ? $order_by2 = (($otype)?$otype:'DESC') : true;

		$sql_count = "select count(*) ".$sql; 

		$sql .= "order by $order_by $order_by2 ";

		$sql .= "limit $start, $pagesize ";

		$sql = $columns.$sql;

		$result = parent::db_query($sql);

		$reccnt = parent::db_scalar($sql_count);

		return array($result,$reccnt);

	 }

	  

	 

	 public function password($password)

	 {

	        $password=md5($password); 

		    $password=base64_encode($password); 	

		    return $password;

	 }

}
?>