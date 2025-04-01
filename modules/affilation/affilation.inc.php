<?php
class Pages extends dbc
{
	
	 public function  add($data)
	 {
		    @extract($data);
	        $query=parent::db_query("select * from #_".tblName." where name='".$name."' and email='".$email."' and phone='".$phone."'"); 
	        if($query->rowCount()==0)
	        {
			
				$data['created_on']=date('Y-m-d H:i:s');
				$data['create_by']=$_SESSION["AMD"][0];
			
				$data['shortorder']=parent::getSingleresult("select max(shortorder) as shortorder from #_".tblName." where 1=1 ")+1;
				parent::sqlquery("rs",tblName,$data);
				$insertid=$GLOBALS['dbcon']->lastInsertId();
				$POST[rwi]='AF'.$insertid;
				parent::sqlquery("rs",tblName,$POST,'pid',$insertid);
		        parent::sessset('Record has been added', 's');
				//parent::admsendmail('ajaymaurya.rw@gmail.com', 'registrationwala', 'Record added !');
	            $flag =array (1,$insertid);
		    }else {
				$row = parent::db_fetch_array($query);
				$duplicate['dp']=1;
				parent::sqlquery("rs",tblName,$duplicate,'pid',$row['pid']);
			    parent::sessset('Record has already added', 'e');
				$flag =array (1,0);
			}
			
			return $flag; 
			
	 }
	 
	 public function  update($data)
	 {
		   @extract($data);
	       $query=parent::db_query("select * from #_".tblName." where created_on ='".$created_on."' and pid!='".$updateid."' "); 
	       if($query->rowCount()==0)
	       {
				 //$data['password']=$this->password($data['password']);
		         // parent::sqlquery("rs",'admin_users',$data);
			
				 $data['modified_on']=date('Y-m-d H:i:s');
			     parent::sqlquery("rs",tblName,$data,'pid',$updateid);
		         parent::sessset('Record has been updated', 's');
				// parent::admsendmail('ajaymaurya.rw@gmail.com', 'registrationwala', 'Record updated !');
	             $flag =array (1,$updateid);
		    }else {
			    parent::sessset('Record has already added', 'e');
				$flag =array (1,0);
			}
			
			return $flag;  
		 
	 }
	 
	 public function  getdeptwiseleads($serviceids)
	 { 
			  $compRy =parent::db_query("select * from #_product_manager where status=1 and dpid IN($serviceids)"); 
	         $compRs = parent::db_fetch_all($compRy,PDO::FETCH_COLUMN);
			  $ids = implode(',',$compRs);  
			
			return $ids;  
		 
	 }
	 
	 public function  delete($updateid)
	 {
		   if(is_array($updateid))
		   {
			   $updateid=implode(',',$updateid);
		   }
		   
		  /* $delete_image=parent::getSingleresult("select image from #_".tblName." where pid='".$updateid."'");
		   if($delete_image!='')
		   {
				 @unlink(UP_FILES_FS_PATH."/pages/".$delete_image);
				 @unlink(UP_FILES_FS_PATH."/pages/900X400/".$delete_image);
		   }*/
		   
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
	 
	  public function assign($updateid,$salesecutiveid,$colname)
	 {
		
		 
		   if(is_array($updateid))
		   {
			   $updateid=str_replace("AF","",implode(',',$updateid));
		   }
		 
		   parent::db_query("update  #_".tblName." set ".$colname."='".$salesecutiveid."' where pid in ($updateid)");
		   
	 }
	 
	  public function  display($start,$pagesize,$fld,$otype,$search_data,$extra,$extra1,$extra2)
	 {
		$start = intval($start); 
	   	$columns = "select * "; 
		
		if(trim($search_data)!='')
		{
		   $wh=" and (name like '%".$search_data."%' or email like '%".$search_data."%' or phone like '%".$search_data."%'or dates like '%".$search_data."%') ";	
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