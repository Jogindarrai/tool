<?php 
include(FS_ADMIN._MODS."/invoice2024_25/invoice2024_25.inc.php");
$PAGS = new Pages();
if($uid)
{
    $query =$PDO->db_query("select * from #_".tblName." where pid ='".$uid."' "); 
	$row = $PDO->db_fetch_array($query);
	@extract($row);	?>
    <?php
	
}

?>
<div class="content">
<div class="div-tbl">
        <div class="title">
          <div class="fl"><img src="images/form-icon.png" alt="">Forms</div>
          <div class="cl"></div>
        </div>
        <div class="tbl-contant">
             
          <div class="tbl-name">
            <h3  >Add - <?=$ADMIN->compname($comp)?></h3>
            <!--<small>we can add user detail here</small>-->
            <div class="cl"></div>
             <?=$ADMIN->alert()?>
          </div>
           
           <div class="section last"> 
           <div class="invicewarp">
<div class="header">
<img src="<?=SITE_PATH_ADM._MODS.'/'.$comp?>/images/rwlogo.png" />
</div>

<div class="invicecon">
<table border="1" cellspacing="0" cellpadding="0" width="100%" class="firsttable">
  <tr>
    <td width="43%" valign="top"><p><strong>BLUE INKK</strong><br />
      <strong>PAN:</strong> AAVFB5292Q <br />
      <strong>Service Tax Number:</strong> 07AAVFB5292Q1ZF<br />
      <strong>Invoice No.:</strong> BI/<?=date('Y').'-'.date('y', strtotime('+1 year'));?>/805 <br />
      <strong>Dated:</strong> <?=date("l, m, Y")?><br />
      <strong>Relationship Manager:</strong><?=$rlmanager?$rlmanager:$_SESSION["AMD"][1]?></p></td>
    <td width="57%" valign="top" class="std"><p align="left"><strong>Customer Name:</strong> <span class="inputf"><?=$customername?></span> <br />
      <strong>Email.ID: </strong><span class="inputf"><?=$customeremail?></span> <br />
      <strong>Contact No.: </strong><span class="inputf"><?=$customerno?></span>
      <strong>Address: </strong><span class="inputf"><?=$addressofclient?></span>
      </p></td>
  </tr>
</table>

</div>
<div class="invicecon">
<table border="1" cellspacing="0" cellpadding="0" width="100%" class="stable">
  <tr>
    <td width="85%" valign="top"><p><strong>DESCRIPTION OF THE SERVICES</strong></p> </td>
    <td width="14%" align="right" valign="top"><p align="right"><strong>AMOUNT</strong></p></td>
  </tr>
  <tr>
    <td width="85%" height="150" valign="top" class="additem">
     <?php
	if($uid){
	$itemv=explode(":",$itemservice);
	foreach($itemv as $key){?>
	<p class="aditem newdata"><?=$key?></p>	
	<?php }
	}else{
	?>   
    <p class="aditem newdata"></p>	
    <?php } ?>
    
    </td>
    <td width="14%" height="150" align="right" valign="top" class="additemprice">
     <?php
	if($uid){
	$pricev=explode(":",$itempriceservice);
	foreach($pricev as $valuev){?>
	<p class="aditem"><?=$valuev?></p>	
	<?php }
	}else{
	?>   
   <p class="aditem"></p>	
    <?php } ?>
    </td>
  </tr>
  <tr>
    <td width="85%" valign="top"><p align="left">Service tax @ 14 %</p></td>
    <td width="14%" align="right" valign="top"><p><span id="srtax"><?=$hsrtax?></span>/-</p></td>
  </tr>
  <tr>
    <td width="85%" valign="top"><p align="left">Swach bharat cess @ .5%</p></td>
    <td width="14%" align="right" valign="top"><p><span id="sbtax"><?=$hsbtax?></span>/-</p></td>
  </tr>
  <tr>
    <td width="85%" valign="top"><p align="left">Krishi kalyan cess @ .5%</p></td>
    <td width="14%" align="right" valign="top"><p><span id="kktax"><?=$hkktax?></span>/-</p></td>
  </tr>
  <tr>
    <td width="85%" valign="top"><p><strong>TOTAL</strong> : </p></td>
    <td width="14%" align="right" valign="top"><p><strong><span id="maintotal"><?=$hmaintotal?></span>/-</strong></p></td>
  </tr>
  <tr>
    <td width="85%" height="150" valign="top" class="adisadditem">
    <?php
	if($uid){
	$itemadoninv=explode(":",$itemadon);
	foreach($itemadoninv as $keyi){?>
	<p class="aditem"><?=$keyi?></p>	
	<?php }
	}else{
	?>   
    <p></p>
    <?php } ?>
    </td>
    <td width="14%" height="150" align="right" valign="top" class="adisadditemprice">
    <?php
	if($uid){
	$priceinv=explode(":",$itempriceadon);
	foreach($priceinv as $vali){?>
	<p class="aditem"><?=$vali?></p>	
	<?php }
	}else{
	?>   
    <p></p>
    <?php } ?>
    </td>
  </tr>
  <tr>
    <td width="85%" valign="top"><p><strong>GROSS TOTAL</strong> : <br />
      (<strong>In Words:</strong> <span id="inwords"> <?=$hinwords?></span>)</p></td>
    <td width="14%" align="right" valign="top"><p align="center"><strong><span id="grasstotal"><?=$hgrasstotal?></span>/-</strong></p></td>
  </tr>
</table>
</div>

<div class="invicecon foot">
    
    <p> Please Note that GST Council has defined legal services under reverse charge (In the 14th GST council meeting held on may 19 2017) and has shifted the liability to discharge GST on the legal Service from the service provider to the service recipients. Therefore, we have not charged GST herein and would request you to kindly check your liability and pay GST under reverse charge mechanism. </p>
<p>Kindly make payment in cash or through net banking  by NEFT/ IMPS or issue a cheque in favour of</p>
<p><strong>"MONETIC CORP CONSULTANTS  PRIVATE LIMITED"</strong></p>
<p><strong>INDUSIND BANK</strong> (Current A/C)<br />
  BRANCH - <strong>E-Mall  Sector-7, ROHINI</strong><strong> </strong><br />
  ACCOUNT NO. - <strong>200999976410, </strong>IFSC  Code -<strong>INDB0000145</strong></p>
</div>
<div class="cl"></div>
<p><strong style="font-size:12px;">This is computer generated receipt no signature required.</strong></p>
<div class="footer">

    169, THIRD FLOOR, KAPIL VIHAR,
PITAMPURA, DELHI-110034<br />
   <strong>Mobile:</strong>+91-8882-580-580 <strong>E-mail:</strong> support@registrationwala.com
</div>
</div>
           
           </div>
            
        </div>
      </div>
      
</div>
<style>
*{margin:0; padding:0;}
.invicewarp{width:960px; margin:auto; padding:0 30px 30px; border:1px solid #ccc;}
.header{text-align:right; margin-bottom:15px;}
.header img{max-height:80px;}
.invicecon{margin-bottom:30px;}
.invicecon table tr td{padding:5px;}
.invicecon table tr td p{line-height:20px;}
.invicecon.foot p{margin-bottom:12px;}
.footer{font-size:10px; text-align:right;}
table.firsttable tr td.std strong { width: 30%; display: block; float: left;}
table.firsttable tr td.std .inputf {width: 70%; display: block; float: left;}
.stable tr td:nth-child(even) p{text-align:right;}
.invicecon table.stable tr td input{background-position: 5px 5px;    width: 85%;border: solid 1px #DDD; outline: 0; line-height: 28px; height: 28px; padding: 0px 7px 0px 7px; -moz-box-shadow: 1px 1px 2px #f5f5f5; -webkit-box-shadow: 1px 1px 2px whiteSmoke; box-shadow: 1px 1px 2px whiteSmoke; -webkit-transition: all 0.4s ease 0s; -moz-transition: all 0.4s ease 0s; -o-transition: all 0.4s ease 0s; transition: all 0.4s ease 0s;}
input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button {-webkit-appearance: none;  -moz-appearance: none; appearance: none;margin: 0; }
.slm{height:19px; margin:0;}
p.aditem.newdata{position:relative;}
p.aditem.newdata .appendeddata {position: absolute;width: 87%;left: 0; top: 100%; z-index: 2; background: #fff; max-height:150px; overflow-y:auto;}
span.appendeddata ul{border:1px solid #ccc;}
span.appendeddata ul li {border-bottom: 1px solid #ccc;line-height: 25px; padding: 0 15px;cursor: pointer;}
</style>
<script>
		jQuery(document).ready(function(){
			// binds form submission and fields to the validation engine
			jQuery("#formID").validationEngine({promptPosition: 'inline'});
			/*$("#formID").bind("jqv.form.result", function(event, errorFound) {
	  if(errorFound) alert("There is a problem with your form");
    })*/
		});
</script>
