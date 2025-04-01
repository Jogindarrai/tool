 <div class="admin-bar">
    <div class="logout"> <a href="<?=SITE_PATH_ADM?>logout.php">Logout</a> </div>
    <ul class="nav admin-settings" id="nav">
      <li > <a href="" class="st"  ><img src="images/admin.png"   class="gear" alt="" width="18" height="18" /></a>
        <ul>
          <li> <a href="<?=$ADMIN->iurl('admin_users')?>&mode=update">My Profile</a> </li>
         <!-- <li> <a href="">Administrator settings</a> </li>
          <li> <a href="">User Settings</a> </li>-->
        </ul>
      </li>
    </ul>
    <div class="welcome"> Welcome to <span><?=$_SESSION["AMD"][1]?></span></div>
    <div class="pro-thumb"> </div>
  </div>
  
  
  <div class="aside">
  <ul class="nav2">
     <li> <a href="<?=SITE_PATH_ADM?>">HOME</a> </li>
    
     <li> <a class="<?=$comp=='project'&& $mode!='completed'?'active':''?>" href="<?=$ADMIN->iurl('project')?>">OPEN ORDER</a> </li> 
       <li> <a class="<?=$mode=='completed'?'active':''?>" href="<?=$ADMIN->iurl('project')?>&mode=completed">CLOSE ORDER</a> </li>  
     <?php if($_SESSION["AMD"][3]=='1' || $_SESSION["AMD"][3]=='6' || $_SESSION["AMD"][3]=='7') {?>
      <li> <a class="<?=$mode=='senoirmanagertasks'?'active':''?>" href="<?=$ADMIN->iurl('project')?>&mode=senoirmanagertasks">YOUR TASKS</a> </li> 
     
      <li> <a class="<?=$comp=='admin_users'?'active':''?>" href="<?=$ADMIN->iurl('admin_users')?>">USERS MANAGER</a> </li>
     
    <?php } ?>
    <li> <a class="<?=$comp=='proposals'?'active':''?>" href="<?=$ADMIN->iurl('proposals')?>">PROPOSALS MANAGER</a> </li>
     <?php if($_SESSION["AMD"][3]!='4') {?>
    <li> <a class="<?=$comp=='leads'?'active':''?>" href="<?=$ADMIN->iurl('leads&mode=dashboard')?>">LEADS MANAGER</a> </li>
      <?php } if($_SESSION["AMD"][3]!='5'){?><li> <a class="<?=$comp=='affilation'?'active':''?>" href="<?=$ADMIN->iurl('affilation')?>">AFFILIATE MANAGER</a> </li><?php } ?>
     <li><a href="javascript:void(0)">UTILITI MANAGER</a>
     
     <div class="ul-arrow"><ul>
        <li> <a class="<?=$comp=='invoice'?'active':''?>" href="<?=$ADMIN->iurl('invoice')?>">INVOICE MANAGER</a> </li>
         <?php
		if($_SESSION["AMD"][3]=='1' || $_SESSION["AMD"][3]=='6' || $_SESSION["AMD"][3]=='7' || $_SESSION["AMD"][3]=='3'){?>
       <!-- <li> <a class="<?=$comp=='sms'?'active':''?>" href="<?=$ADMIN->iurl('sms')?>">SMS MANAGER</a> </li>-->
       
        <li> <a class="<?=$comp=='emails'?'active':''?>" href="<?=$ADMIN->iurl('emails')?>">EMAILS MANAGER</a> </li>
       
        <?php } ?>
        <?php
		if($_SESSION["AMD"][3]=='6' || $_SESSION["AMD"][3]=='1' || $_SESSION["AMD"][3]=='7' || $_SESSION["AMD"][0]=='28'){?>
        <li> <a class="<?=$comp=='tmapplide'?'active':''?>" href="<?=$ADMIN->iurl('tmapplide')?>">TM APPLIED</a> </li>
        <li> <a class="<?=$comp=='tmapplidecustom'?'active':''?>" href="<?=$ADMIN->iurl('tmapplidecustom')?>">TM APPLIED BY</a> </li>
        <?php } ?>
        </ul></div></li>
        
          <li><a href="javascript:void(0)">CRMS MANAGER</a>
     
     <div class="ul-arrow"><ul>
       
         <li> <a class="<?=$comp=='compliance'?'active':''?>" href="<?=$ADMIN->iurl('compliance')?>">COMPLIANCE MANAGER</a> </li> 
          <?php
		if($_SESSION["AMD"][3]=='1'){?>
         <li> <a class="<?=$comp=='compliance'?'active':''?>" href="<?=$ADMIN->iurl('taxtation_compliance')?>">TAX CRMS</a> </li> 
           <?php } ?>
        </ul></div></li>
        
     <!-- <li> <a href="<?=$ADMIN->iurl('clients')?>">CLIENTS MANAGER</a> </li>-->
 <span class="cl"></span>   
  </ul>
</div>

<div class="main inner-main">
  
   <style>
   .ul-arrow li{text-transform:uppercase;}
   .cl{clear:both; display:block;}
   </style> 