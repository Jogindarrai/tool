<?php
/*
# @package BSC CMS
# Copy right code 
# The base configurations of the BSC CMS.
# mana  cart product add update and delete
# Developer by jugal kishore kiroriwal

*/

class ShopCart extends dbc
{
	
	 public function  add($data)
	 {
		    @extract($data);
					
			
	        $query=parent::db_query("select * from #_".tblName." where offer_name ='".$offer_name."' "); 
	        if($query->rowCount()==0)
	        {
				$data['created_on']=date('Y-m-d H:i:s');
				$data['create_by']=$_SESSION["AMD"][0];
				//$data['shortorder']=parent::getSingleresult("select max(shortorder) as shortorder from #_".tblName." ")+1;
				$offer_id = parent::sqlquery("rs",tblName,$data);
				for($i=0;$i < count($product_select); $i++)
			    {
			      parent::sqlquery("rs",'offers_products',array('offer_id'=>$offer_id,'product_id'=>$product_select[$i]));  	
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
	       $query=parent::db_query("select * from #_".tblName." where offer_name ='".$name."' and pid!='".$updateid."' "); 
	       if($query->rowCount()==0)
	       {
				 //$data['password']=$this->password($data['password']);
		         // parent::sqlquery("rs",'brands',$data);
				 $data['modified_on']=date('Y-m-d H:i:s');
			     parent::sqlquery("rs",tblName,$data,'pid',$updateid);
				 for($i=0;$i < count($product_select); $i++)
			     {
					 
					 
					   $query=parent::db_query("select * from #_offers_products where offer_id ='".$updateid."' and product_id='".$product_select[$i]."' "); 
	                   if($query->rowCount()==0)
	                   {
						   parent::sqlquery("rs",'offers_products',array('offer_id'=>$updateid,'product_id'=>$product_select[$i]));  	   
					   }					 	
			     }
				
				 $prd_str =implode(',',$product_select);
						
				 parent::db_query("delete from #_offers_products where offer_id ='".$updateid."' and product_id not in (".$prd_str.") "); 
				 
				 
		         parent::sessset('Record has been updated', 's');
				 
	             $flag =1;
		    }else {
			    parent::sessset('Record has already added!', 'e');
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
	 
	  
	 
	 public function  display($start,$pagesize,$fld,$otype,$search_data)
	 {
		$start = intval($start); 
	   	$columns = "select * "; 
		
		if(trim($search_data)!='')
		{
		   $wh=" and (name like '%".$search_data."%' ) ";	
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