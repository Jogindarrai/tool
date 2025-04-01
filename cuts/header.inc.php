<?php $userRow=$PDO->getResult("select * from pms_admin_users where user_id='".$_SESSION['AMD'][0]."'");
$accessmodulepoint=explode(':', $userRow['accessmodule']);
 ?>
<header class="header">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-3"> <a href="<?=SITE_PATH?>" class="navbar-brand "><img src="<?=SITE_PATH?>images/logo.png" alt="Logo" /></a> </div>
      <div class="col-12 col-md-9 d-flex">
        <div class="navbar navbar-expand-md  topnavbar  ml-auto">

          <!--      <button class="navbar-toggler ml-auto mt-2 collapsed" type="button" data-toggle="collapse" data-target="#top" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
-->
          <div class="" id="top">
            <ul class="navbar-nav float-md-right flex-row">
              <li>
              <?php
if (!isset($mode)) {
    $mode = ''; // Default value
}
if ($mode != 'add' && $mode != 'edit') {
?>
    <form class="form-inline my-2 my-lg-0" method="post">
        <div class="input-group margin-bottom-sm">
            <input class="form-control" type="text" placeholder="search" name="search_data">
            <button type="submit" class="input-group-addon"><i class="fa fa-search"></i></button>
        </div>
    </form>
<?php } ?>

              </li>
              <li class="nav-item dropdown notification"> <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-bell"></i> <span class="badge">
                <?=$PDO->getSingleresult("select count(*) from #_task where dstatus='0' and reciverid='".$_SESSION["AMD"][0]."'");?>
                </span> </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown"> <a class="dropdown-item" href="#" onclick="readmsg();">You have
                  <?=$PDO->getSingleresult("select count(*) from #_task where dstatus='0' and reciverid='".$_SESSION["AMD"][0]."'");?>
                  new messages </a> </div>
              </li>
              <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php
  $image= $PDO->getsingleresult("select image from pms_admin_users where user_id='".$_SESSION["AMD"][0]."'");
    if($image==''){
				  $src=SITE_PATH.'images/user.jpg';

				  } else {

					   $src=SITE_PATH.'uploaded_files/userimg/'.$image; }; ?>
                <img src="<?=$src?>" alt="<?=$_SESSION["AMD"][1]?>" class="profile-pic" /> <span class="d-none d-md-inline">
                <?=$_SESSION["AMD"][1]?>
                <small>
                <?=$ADMIN->user_type($_SESSION["AMD"][3])?>
                </small></span> </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown"> <a class="dropdown-item" href="<?=$ADMIN->iurl('admin_users')?>&mode=my-profile">My Profile</a>

                  <a class="dropdown-item" href="<?=SITE_PATH_ADM?>logout.php">Logout</a> </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
<!-- Main Nav -->
<section class="mainnav">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <nav class="navbar navbar-expand-lg ">
          <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav nav-fill w-100 align-items-start">
            <?php if($_SESSION["AMD"][3]==1 || $_SESSION["AMD"][3]==6){ ?>
             <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" href="#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dashboard </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
               <a class="dropdown-item" href="<?=SITE_PATH?>">Sales Dashboard </a>
               <a class="dropdown-item" href="<?=SITE_PATH?>index.php?dept=inc">Incorporation Dashboard</a>
                <a class="dropdown-item" href="<?=SITE_PATH?>index.php?dept=tax">Taxation Dashboard</a>
                 <a class="dropdown-item" href="<?=SITE_PATH?>index.php?dept=trademark">Trademark Dashboard</a>


               </div>
              </li>
            <?php }else { ?>
             <li class="nav-item active"> <a class="nav-link" href="<?=SITE_PATH?>">Dashboard <span class="sr-only">(current)</span></a> </li>

          <?php
		  }
		   if(in_array('3',$accessmodulepoint)){?>

               <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Proposals Manager </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
               <a class="dropdown-item" href="<?=$ADMIN->iurl('proposal_history')?>&mode=add">Proposal Utlitity</a>
               <a class="dropdown-item" href="<?=$ADMIN->iurl('proposal_history')?>">Proposal History</a>
              </li>
              <?php }if(in_array('4',$accessmodulepoint)){

				  if(in_array($_SESSION["AMD"][3],array("1", "6"))){?>
					 <li class="nav-item"> <a class="nav-link" href="<?=$ADMIN->iurl('leads')?>&department=2">My Leads</a> </li>
					  <?php }else { ?>
				 <?php  ?>
               <li class="nav-item"> <a class="nav-link" href="<?=$ADMIN->iurl('leads')?>">My Leads</a> </li>
             <?php } } if(in_array('5',$accessmodulepoint)){?>

              <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Invoice Manager </a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php if($_SESSION["AMD"][3]==1 || $_SESSION["AMD"][3]==6) {?>


                                      <a class="dropdown-item" href="<?=SITE_PATH.'index.php?comp=invoice2023_24'?>">Invoice 2023-24</a>
                                      <a class="dropdown-item" href="<?=SITE_PATH.'index.php?comp=invoice2024_25'?>">Invoice 2024-25</a>


                <?php } ?>


                   </div>
              </li>
              <!--<li class="nav-item"> <a class="nav-link" href="<?=$ADMIN->iurl('invoice')?>">Invoice Manager</a> </li>-->
              <?php } if(in_array('6',$accessmodulepoint)){?>
              <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Masters </a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php if($_SESSION["AMD"][3]==1 || $_SESSION["AMD"][3]==6) {?>
                <a class="dropdown-item" href="<?=$ADMIN->iurl('affilation')?>">Affiliate History</a>
                <a class="dropdown-item" href="<?=$ADMIN->iurl('product_manager')?>">Product Manager</a>
                <a class="dropdown-item" href="<?=$ADMIN->iurl('lead_source')?>">Lead Source</a>
                <a class="dropdown-item" href="<?=$ADMIN->iurl('activites_group')?>">Activites Group</a>
                <a class="dropdown-item" href="<?=$ADMIN->iurl('activites_score')?>">Activites Score</a>
                <a class="dropdown-item" href="<?=$ADMIN->iurl('lead_stage')?>">Lead Stage</a>
                <a class="dropdown-item" href="<?=$ADMIN->iurl('cost_manager')?>">Cost Manager</a>
                <a class="dropdown-item" href="<?=$ADMIN->iurl('department')?>">Department Manager</a>
                <a class="dropdown-item" href="<?=$ADMIN->iurl('work_process')?>">Work Process Manager</a>
                  <a class="dropdown-item" href="<?=$ADMIN->iurl('admin_users')?>">Users Manager</a>
                    <a class="dropdown-item" href="<?=$ADMIN->iurl('service_manager')?>">Associate Service Manager</a>
                <?php } ?>


                   </div>
              </li>
              <?php } ?>

              <?php if($_SESSION["AMD"][3]==1 || $_SESSION["AMD"][3]==3 || $_SESSION["AMD"][3]==6){ ?>
              <li class="nav-item"> <a class="nav-link" href="<?=$ADMIN->iurl('custom_payments')?>">Payment Links</a></li>
               <?php } ?>
                  <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">CRMS </a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                 <a class="dropdown-item" href="<?=$ADMIN->iurl('crms')?>&mode=dashboad">Dashboad</a>
                        <a class="dropdown-item" href="<?=$ADMIN->iurl('crms')?>">CRMS Master</a>
                   </div>
              </li>
                <?php if($_SESSION["AMD"][3]==1 || $_SESSION["AMD"][3]==6){ ?>
				 <li class="nav-item"> <a class="nav-link" href="<?=$ADMIN->iurl('associates')?>">Associates</a></li>
				<?php } ?>
            </ul>
          </div>
        </nav>
      </div>
    </div>
  </div>
</section>
<script>
function readmsg(){
	data= {'readmsg':'readmsg'}
$.ajax({
    type: "POST",
    url: "<?=SITE_PATH_ADM?>modules/leadsAjax.php",
    data: data,
    success: function(data) {
	window.location.href = "<?=$ADMIN->iurl('admin_users')?>&mode=my-profile";
	//$('#allreply').html(data);
	//$('#allreply').modal('show');
		},
    error: function() {
        alert('error handing here');

    }
});
	return false;}
</script>
