<?php 

if($_SESSION["AMD"][3]=='5'){
 $extra = " and create_by='".$_SESSION["AMD"][0]."' or salesecutiveid='".$_SESSION["AMD"][0]."'";  
}
if($SalesExecutive){
 $extra = " and salesecutiveid='".$SalesExecutive."'"; 
	}
if($status){
 $extra = " and status='".$status."'"; 
	}

if($status && $SalesExecutive){
 $extra = " and status='".$status."' and salesecutiveid='".$SalesExecutive."'"; 
	}





$start = intval($start);

$pagesize = intval($pagesize)==0?(($_SESSION["totpaging"])?$_SESSION["totpaging"]:DEF_PAGE_SIZE):$pagesize;

list($result,$reccnt) = $PAGS->display($start,$pagesize,$fld,$otype,$search_data,$zone,$mtype,$extra,$extra1,$extra2);



?>

<div class="content">

<div class="div-tbl">

        <div class="title">

          <div class="fl"><img src="images/latest-icon.png" alt="">invoice Manager</div>

          

          <div class="cl"></div>

        </div>

        <div class="tbl-contant">

        <?=$ADMIN->alert()?>


          <div class="tbl-name">

          
            <div class="cl"></div>

          </div>

          <div id="ordrz">

          <table width="100%" class="data-tbl"   cellpadding="0" cellspacing="0">

            <tr class="tbl-head">

             
             <td width="60%"> <a href="<?=$ADMIN->iurl($comp)?>&fld=inviceno<?=(($otype=='asc')?"&otype=desc":'&otype=asc')?>" <?=(($fld=='inviceno')?'class="selectedTab"':'')?>><span <?=(($otype=='asc')?'class="des"':'class="asc"')?>>Invoice No.</span></a></td>
             
             
             
             
             
             
             
             <td width="20%" class="action-td">Download</td>
 			 <td width="20%" class="action-td">Action</td>
            </tr>
          </table>
          <ul>
            <?php if($reccnt)
			      { 
			        $nums = (($start)?$start+1:1); 
				    while ($line = $PDO->db_fetch_array($result))
				    {
					    @extract($line);
						$css =($css=='odd')?'even':'odd';
			?>

            <li id="recordsArray_<?=$pid?>">
<?php if($status=='0'){ 
 $newclass='newp';
}else { $newclass=''; } ?>
      <style>
     .newp{background: rgb(162, 212, 162) !important;}
     </style>
              <table width="100%" class="data-tbl"   cellpadding="0" cellspacing="0">

             <tr class="<?=$css?> <?=$newclass?>">

                
                <td width="60%"><?=$inviceno?></td>
                
                
                
                
                
                
                
                <td  width="20%"><a href="<?=SITE_PATH_ADM._MODS.'/download.php?files='.SITE_PATH_ADM._MODS.'/'.$comp.'/pdf/'.$filename.'.pdf'?>">Download</a></td>
                <td width="20%">
                <?php
                if($_SESSION["AMD"][3]=='5' || $_SESSION["AMD"][3]=='2'){
                ?>
                <?=$ADMIN->action3($comp, $pid)?>
                <?php }else if($_SESSION["AMD"][3]=='1' || $_SESSION["AMD"][3]=='6' || $_SESSION["AMD"][3]=='7' || $_SESSION["AMD"][3]=='3'){
                echo $ADMIN->action($comp, $pid);	
                }else{
				echo $ADMIN->viewmode($comp, $pid);	
					}?>
                </td> 
                </tr>

            </table>

            </li>

            <?php $nums++; } ?>
           <?php  }else { echo '<div align="center" class="norecord">No Record Found</div>'; } ?>

           

           </ul>

           </div>

           <div class="hr2"></div>

           <?php include("cuts/paging.inc.php");?>

          

        </div>

      </div>

      

</div>

<script language="javascript">

jQuery(document).ready(function(){ 

	jQuery(function() {

		jQuery("#ordrz ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {

			var order = jQuery(this).sortable("serialize") + '&tbl=<?=tblName?>&field=pid'; 

			 $.post("<?=SITE_PATH_ADM?>modules/orders.php", order, function(theResponse){ }); 															

		}								  

		});

	});

});	

</script>
<style>
.trns{background: transparent;}
.hwlh{border: none; height:25px;}
</style>