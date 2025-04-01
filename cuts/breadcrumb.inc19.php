<?php
switch ($comp)
{
	    case $comp:
					if($comp)
					{
						if(is_dir(FS_ADMIN._MODS."/".$comp) === true)
						{
							if($mode=="my-profile" or $mode=="website-settings"){
								$breadcrumb = (($mode=="my-profile")?'My Profile':'Website Setting');
						    
							}
							else if($mode=="rates"){
								
								$breadcrumb =str_replace('manager','Rates',$comp);		
						
							}
							
							else if($comp=="admin_users"){
								
								$breadcrumb ='Users Manager';		
						
							}	else if($comp=="affilation"){
								
								$breadcrumb ='Affiliate History';		
						
							}
							else if($comp=="proposal_history" && $mode=="add"){
								
								$breadcrumb ='Send Proposal';		
						
							}
							
							else if($comp=="taxtation_compliance"){
								
								$breadcrumb ='TAX CRMS';		
						
							}
							 else if($comp=="project"){
								
								$breadcrumb ='Order';		
						
							} else if($comp=="categorys"){
								
								$breadcrumb ='Materials';
								 
						    } else{
								$breadcrumb = $ADMIN->breadcrumb($comp);
							}
						} else{
							$breadcrumb = "Under Construction!";
							$notbc =true;
						}
					} else {
						 $breadcrumb = "Dashboard";	
					}
					break;					
	default:
		     $breadcrumb = "Dashboard";
}
if($mode!='dashboard'){
?>
<section class="pt-4 brdbg pb-4">
  <div class="container ">
          <div class="row">
            <div class="col">
              <div class="card-title">
                <h2><?=ucfirst(str_replace('_', ' ',$breadcrumb))?> </h2>
              </div>
            </div>
            <div class="col text-right">
              <h4> 
        <?php if($mode!='add' && $mode!='edit' && $mode!='website-settings' && $mode!='view' && $comp!='orders' && $comp!='subscribes' && $breadcrumb!= "Dashboard" && $mode!="my-profile" && $mode!='add' && $mode!='edit' && $mode!='rates' && $comp!='custom_payments') { ?>
                 <?php if($comp=='invoice'){?>
           <a href="<?=SITE_PATH.'invoice/add'.(($subpage_id)?'&subpage_id='.$subpage_id:'').(($source)?'&source='.$source:'').(($complianceId)?'&complianceId='.$complianceId:'').(($other_id)?'&other_id='.$other_id:'')?><?=$catid?'&catid='.$catid:''?><?=($die_id)?'&die_id='.$die_id:''?>" class="btn btn-info" title="Add New" id="add"><i class="fa fa-plus"></i></a>
          <!-- <a href="<?=$ADMIN->iurl($comp,'add'.(($subpage_id)?'&subpage_id='.$subpage_id:'').(($source)?'&source='.$source:'').(($complianceId)?'&complianceId='.$complianceId:'').(($other_id)?'&other_id='.$other_id:''))?><?=$catid?'&catid='.$catid:''?><?=($die_id)?'&die_id='.$die_id:''?>" class="btn btn-info" title="Add New" id="add"><i class="fa fa-plus"></i></a>-->
                 <?php }else{?>
           <a href="<?=$ADMIN->iurl($comp,'add'.(($subpage_id)?'&subpage_id='.$subpage_id:'').(($source)?'&source='.$source:'').(($complianceId)?'&complianceId='.$complianceId:'').(($other_id)?'&other_id='.$other_id:''))?><?=$catid?'&catid='.$catid:''?><?=($die_id)?'&die_id='.$die_id:''?>" class="btn btn-info" title="Add New" id="add"><i class="fa fa-plus"></i></a>
                 <?php }?>
       
   
     <?php  if($breadcrumb!= "Dashboard" && $comp!='custom_payments' && $mode!='rates' && $comp!='proposal_history' && $comp!='leads') {  ?>   
      
     
    
        <a href="javascript:void(0);" onclick="javascript:submitions('Delete');" title="Delete" class="btn btn-info"><i class="fa fa-trash"></i></a>
       <?php  if( $comp=='category' && $subpage_id>0) {  ?>  
       <a href="<?=$ADMIN->iurl($comp)?>" title="Back" class="btn btn-info"><i class="fa fa-arrow-left"></i></a>
       
       <?php } ?>
       <a href="javascript:void(0);" onclick="javascript:submitions('Active');" title="Active" class="btn btn-info"><i class="fa fa-toggle-on"></i></a>
        <a href="javascript:void(0);" onclick="javascript:submitions('Inactive');" title="Inactive" class="btn btn-info"><i class="fa fa-ban"></i></a>
        
        <?php } } else if($mode!='website-settings'  && $comp!='orders' && $comp!='subscribes' && $breadcrumb!= "Dashboard" && $mode!='rates' && $comp!='proposal_history' && $comp!='invoice'  && $comp!='custom_payments')  {?>
        
             <a href="<?=$ADMIN->iurl($comp.(($subpage_id)?'&subpage_id='.$subpage_id:'').(($source)?'&source='.$source:'').(($oStatus)?'&mode='.$oStatus:'').(($complianceId)?'&complianceId='.$complianceId:'').(($other_id)?'&other_id='.$other_id:''))?>" title="Cancel" class="btn btn-info"><i class="fa fa-times"></i></a>
           
             <a href="<?=$ADMIN->iurl($comp.(($subpage_id)?'&subpage_id='.$subpage_id:'').(($source)?'&source='.$source:'').(($oStatus)?'&mode='.$oStatus:'').(($complianceId)?'&complianceId='.$complianceId:'').(($other_id)?'&other_id='.$other_id:''))?>" title="Back" class="btn btn-info"><i class="fa fa-arrow-left"></i></a>
         <?php } ?>
      
  </h4>
            </div>
          </div>
          <div class="row"><div class="col"><?=$ADMIN->alert();?></div></div>
          </div>
 </section>
            <?php } ?>