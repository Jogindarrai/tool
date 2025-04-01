<?php

include(FS_ADMIN . _MODS . "/invoice2024_25/invoice2024_25.inc.php");







//182.69.11.18

//        if($_SERVER['REMOTE_ADDR']=='182.69.11.18'){

//            echo "<pre>";

//            print_r($new_invoice_no);

//            exit;

//        }

$PAGS = new Pages();







if ($RW->is_post_back()) {





    $_POST['url'] = $ADMIN->baseurl($name);







    if ($uid) {



        $_POST['updateid'] = $uid;



        $flag = $PAGS->update($_POST);

    } else {

        $flag = $PAGS->add($_POST);

    }



    // print_r($flag); exit;



    if ($flag[0] == 1 || $flag == 1) {



        $inid = $flag[1];







        //$RW->redir($ADMIN->iurl($comp.(($start)?'&start='.$start:'').(($subpage_id)?'&subpage_id='.$subpage_id:'')), true);



        if ($uid) {

          //   $RW->redir(SITE_PATH.'invoice2021_22/invoice2021_22?uid=' . $uid . (($raid) ? '&raid=' . $raid : ''), true);

           $RW->redir($ADMIN->iurl($comp . ('&mode=invoice2024_25') . ('&uid=' . $uid) . (($raid) ? '&raid=' . $raid : '')), true);

        } else {



     //         $RW->redir(SITE_PATH.'invoice2021_22/invoice2021_22?uid=' . $inid . (($raid) ? '&raid=' . $raid : ''), true);

          $RW->redir($ADMIN->iurl($comp . ('&mode=invoice2024_25') . ('&uid=' . $inid) . (($raid) ? '&raid=' . $raid : '')), true);

        }

    }

}





if (!$uid) {

    $financial_year=date('n')<=3?(date('Y')-1).'-'.date('y'):date('Y').'-'.(date('y')+1);
   // $query = $PDO->db_query("select ifnull(max(inviceno),'AGAP/Del/0000') from #_" . tblName." where inviceno like '%$financial_year%'");
    $query = $PDO->db_query("select ifnull(max(inviceno),'AGSK/24-25/0000') from #_" . tblName." where inviceno like '%AGSK/24-25/%'");

    $row = $PDO->db_fetch_array($query);

    $new_invoice_no = $row[0];

    $new_invoice_no++;

}else{

    $query = $PDO->db_query("select inviceno from #_" . tblName." where `pid` = '$uid'");

    $row = $PDO->db_fetch_array($query);

    $new_invoice_no=$row[0];

}





if ($uid) {



    $query = $PDO->db_query("select * from #_" . tblName . " where pid ='" . $uid . "' ");



    $row = $PDO->db_fetch_array($query);



    @extract($row);

    ?>



    <input type="hidden" value="<?= $modified_by ?>" name="modified_by" />

    <?php

} else if (isset($lid)) {

    $query = $PDO->db_query("select * from #_leads where pid ='" . $lid . "'");

    $leadsRow = $PDO->db_fetch_array($query);

    $customername = $leadsRow['name'];

    $customeremail = $leadsRow['email'];

    $customerno = $leadsRow['phone'];

    $addressofclient = $leadsRow['address'];

} else if (isset($raid)) {

    $query = $PDO->db_query("select * from #_associates where pid ='" . $raid . "'");

    $leadsRow = $PDO->db_fetch_array($query);

    $customername = $leadsRow['name'];

    $customeremail = $leadsRow['email'];

    $customerno = $leadsRow['phone'];

    $addressofclient = $leadsRow['address'];

}

//print_r($row);

?>

<div class="container">

    <div class="div-tbl">

        <div class="tbl-contant">

            <div class="tbl-name">

                <h5  >Add -

                    <?= $ADMIN->compname($comp) ?>

                </h5>





                <div class="cl"></div>

                <?= $ADMIN->alert() ?>

            </div>

            <div class="section last">

                <div class="invicewarp">

                    <div class="input-group" style="width: 75%;float: left;margin-top: 43px;text-align: center;">

                        <div class="d-flex justify-content-center">

                           <!--  <div class="btn-group btn-group-toggle" data-toggle="buttons">

                                <label class="btn btn-secondary active">

                                    <input name="invoicetype" id="islcss" value="Retail Invoice" checked="checked" type="radio" data-error="Please select Invoice type">Retail Invoice  </label>

                                <label class="btn btn-secondary">

                                    <input name="invoicetype" id="islc2ss" value="Tax Invoice" type="radio" data-error="Please Please select Invoice type"> Tax Invoice</label>

                            </div> -->

                            <div class="btn-group btn-group-toggle" style="float: left; display: block; margin-top: 43px; text-align: center;">

                                <label class="btn btn-secondary">

                                Invoice

                                </label>

                                <input name="invoicetype" id="islcss" value="Invoice" checked="checked" type="hidden" data-error="Please select Invoice type" >

                            </div>

                            <div class="text-right" style="display:none">

                                <strong>GST Applicable</strong>

                                <select name="gstApplicable" id="isGSTApplicable"  class="validate[required]" onchange="showigst()" style="width:69%" >

                                    <option value="yes" selected>Yes</option>

                                    <option value="no">NO</option>



                                </select>

                            </div>



                        </div>



                    </div>



                    <div class="header" style="width: 25%; float:right;  margin-top: 10px; margin-bottom:6px; text-align:right;"> <img style="border: 1px solid #ccc; box-shadow: 0 0 3 #ccc;" width="230" src="<?= $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'] ?>/images/logo.png" /> </div>

                    <div class="invicecon">

                        <table border="1" cellspacing="0" cellpadding="0" width="100%" class="firsttable" style="border-color:#2196F3;">

                            <tr>

                                <td width="43%" valign="top">

                                    <p>

                                        <strong>AGSK & CO.</strong><br />

                                        <strong>PAN:</strong> AAPFG2830B<br />

                                        <strong>GSTN:</strong> 07AAPFG2830B3ZN<br />

                                        <strong>Invoice No.:</strong>

                                        <?php //$inviceno?$inviceno:"BI/".date('Y')."-".date('y', strtotime('+1 year'))."/23"  ?>

                                        <?= $new_invoice_no ?>

                                        <br />

                                        <strong>Dated:</strong>

                                        <?php if ($uid) { ?>

                                            <input type="text"   name="invicedate"  value="<?= $invicedate ?>" class="mb-1" readonly="readonly">



                                        <?php } else { ?>

                                                <input type="text"   name="invicedate" data-toggle="datepicker" data-target-name="invicedate" value="" class="mb-1" >

                                        <?php } ?>



                                        <br />

                                         <strong>Email:</strong> sachin@agskca.com<br />

                                         <!-- <strong>Contact Number:</strong> 9999962751<br /> -->

                                        <strong>Relationship Manager:</strong>

                                        <input type="hidden" name="pan" value="AAPFG2830B" />

                                        <input type="hidden" name="servicetaxno" value="07AAPFG2830B3ZN" />

                                        <input class="validate[required] txt medium" type="text" name="rlmanager" value="Sachin Chawla" placeholder="" />

                                    </p></td>

                                <td width="57%" valign="top" class="std">

                                    <strong>Customer Name:</strong>

                                    <div class="form-group mb-0">



                                        <span class="inputf"> </span>

                                        <input class="validate[required] txt large" type="text" name="customername" value="<?= $customername ?>" placeholder="CORMACK PHARMA (OPC) PVT.LTD" />





                                    </div>

                                    <strong>Email.ID: </strong>

                                    <div class="form-group mb-0">

                                        <span class="inputf"></span>

                                    </div>

                                    <div class="form-group mb-0">

                                        <input class="validate[required,custom[email]] txt large" type="text" name="customeremail" value="<?= $customeremail ?>" placeholder="test@gmail.com" />

                                    </div>

                                    <strong>Contact No.: </strong>

                                    <div class="form-group mb-0">

                                        <span class="inputf"></span>

                                        <input class="validate[required,custom[onlyNumber],minSize[10],maxSize[14]] txt large" type="text" name="customerno" value="<?= $customerno ?>" placeholder="9012012505" />

                                    </div>

                                    <div class="form-group mb-0">

                                        <strong>Address: </strong><span class="inputf"></span>

                                        <textarea name="addressofclient" placeholder="Address of customer" class="txt large" cols="2" rows="3"><?= $addressofclient ?></textarea>

                                    </div>



                                    <div class="form-group mb-0">





                                        <strong>GSTIN Number: </strong><span class="inputf">      </span>

                                        <input class="txt large" type="text" name="strn" value="<?= $strn ?>"  />



                                    </div>







                                    <strong>Place to Supply</strong>

                                    <span class="inputf"></span>

                                    <div class="form-group mb-0">



                                        <select name="placetosupply" id="placetosupply" class="validate[required]" onchange="showigst();" style="width:69%" >

                                            <option value="">Select...</option>

                                            <option value="Andaman and Nicobar Islands - 35" <?= ($placetosupply == 'Andaman and Nicobar Islands - 35') ? 'selected="selected"' : '' ?>>Andaman and Nicobar Islands - 35</option>

                                            <option value="Andhra Pradesh - 37" <?= ($placetosupply == 'Andhra Pradesh - 37') ? 'selected="selected"' : '' ?>>Andhra Pradesh - 37</option>

                                            <option value="Arunachal Pradesh - 12" <?= ($placetosupply == 'Arunachal Pradesh - 12') ? 'selected="selected"' : '' ?>>Arunachal Pradesh - 12</option>

                                            <option value="Assam - 18" <?= ($placetosupply == 'Assam - 18') ? 'selected="selected"' : '' ?>>Assam - 18</option>

                                            <option value="Bihar - 10" <?= ($placetosupply == 'Bihar - 10') ? 'selected="selected"' : '' ?>>Bihar - 10</option>

                                            <option value="Chandigarh - 04" <?= ($placetosupply == 'Chandigarh - 04') ? 'selected="selected"' : '' ?>>Chandigarh - 04</option>

                                            <option value="Chattisgarh - 22" <?= ($placetosupply == 'Chattisgarh - 22') ? 'selected="selected"' : '' ?>>Chattisgarh - 22</option>

                                            <option value="Dadra and Nagar Haveli - 26" <?= ($placetosupply == 'Dadra and Nagar Haveli - 26') ? 'selected="selected"' : '' ?>>Dadra and Nagar Haveli - 26</option>

                                            <option value="Daman and Diu - 25" <?= ($placetosupply == 'Daman and Diu - 25') ? 'selected="selected"' : '' ?>>Daman and Diu - 25</option>

                                            <option value="Delhi - 07" <?= ($placetosupply == 'Delhi - 07') ? 'selected="selected"' : '' ?>>Delhi - 07</option>

                                            <option value="Goa - 30" <?= ($placetosupply == 'Goa - 30') ? 'selected="selected"' : '' ?>>Goa - 30</option>

                                            <option value="Gujarat - 24" <?= ($placetosupply == 'Gujarat - 24') ? 'selected="selected"' : '' ?>>Gujarat - 24</option>

                                            <option value="Haryana - 06" <?= ($placetosupply == 'Haryana - 06') ? 'selected="selected"' : '' ?>>Haryana - 06</option>

                                            <option value="Himachal Pradesh - 02" <?= ($placetosupply == 'Himachal Pradesh - 02') ? 'selected="selected"' : '' ?>>Himachal Pradesh  - 02</option>

                                            <option value="Jammu and Kashmir - 01" <?= ($placetosupply == 'Jammu and Kashmir - 01') ? 'selected="selected"' : '' ?>>Jammu and Kashmir - 01</option>

                                            <option value="Jharkhand - 20" <?= ($placetosupply == 'Jharkhand - 20') ? 'selected="selected"' : '' ?>>Jharkhand - 20</option>

                                            <option value="Karnataka - 29" <?= ($placetosupply == 'Karnataka - 29') ? 'selected="selected"' : '' ?>>Karnataka - 29</option>

                                            <option value="Kerala - 32" <?= ($placetosupply == 'Kerala - 32') ? 'selected="selected"' : '' ?>>Kerala - 32</option>

                                            <option value="Lakshadweep Islands - 31" <?= ($placetosupply == 'Lakshadweep Islands - 31') ? 'selected="selected"' : '' ?>>Lakshadweep Islands - 31</option>

                                            <option value="Madhya Pradesh - 23" <?= ($placetosupply == 'Madhya Pradesh - 23') ? 'selected="selected"' : '' ?>>Madhya Pradesh - 23</option>

                                            <option value="Maharashtra - 27" <?= ($placetosupply == 'Maharashtra - 27') ? 'selected="selected"' : '' ?>>Maharashtra - 27</option>

                                            <option value="Manipur - 14" <?= ($placetosupply == 'Manipur - 14') ? 'selected="selected"' : '' ?>>Manipur - 14</option>

                                            <option value="Meghalaya - 17" <?= ($placetosupply == 'Meghalaya - 17') ? 'selected="selected"' : '' ?>>Meghalaya - 17</option>

                                            <option value="Mizoram - 15" <?= ($placetosupply == 'Mizoram - 15') ? 'selected="selected"' : '' ?>>Mizoram - 15</option>

                                            <option value="Nagaland - 13" <?= ($placetosupply == 'Nagaland - 13') ? 'selected="selected"' : '' ?>>Nagaland - 13</option>

                                            <option value="Odisha - 21" <?= ($placetosupply == 'Odisha - 21') ? 'selected="selected"' : '' ?>>Odisha - 21</option>

                                            <option value="Pondicherry - 34" <?= ($placetosupply == 'Pondicherry - 34') ? 'selected="selected"' : '' ?>>Pondicherry - 34</option>

                                            <option value="Punjab - 03" <?= ($placetosupply == 'Punjab - 03') ? 'selected="selected"' : '' ?>>Punjab - 03</option>

                                            <option value="Rajasthan - 08" <?= ($placetosupply == 'Rajasthan - 08') ? 'selected="selected"' : '' ?>>Rajasthan - 08</option>

                                            <option value="Sikkim - 11" <?= ($placetosupply == 'Sikkim - 11') ? 'selected="selected"' : '' ?>>Sikkim - 11</option>

                                            <option value="Tamil Nadu - 33" <?= ($placetosupply == 'Tamil Nadu - 33') ? 'selected="selected"' : '' ?>>Tamil Nadu - 33</option>

                                            <option value="Telangana - 36" <?= ($placetosupply == 'Telangana - 36') ? 'selected="selected"' : '' ?>>Telangana - 36</option>

                                            <option value="Tripura - 16" <?= ($placetosupply == 'Tripura - 16') ? 'selected="selected"' : '' ?>>Tripura - 16</option>

                                            <option value="Uttar Pradesh - 09" <?= ($placetosupply == 'Uttar Pradesh - 09') ? 'selected="selected"' : '' ?>>Uttar Pradesh - 09</option>

                                            <option value="Uttarakhand - 05" <?= ($placetosupply == 'Uttarakhand - 05') ? 'selected="selected"' : '' ?>>Uttarakhand - 05</option>

                                            <option value="West Bengal - 19" <?= ($placetosupply == 'West Bengal - 19') ? 'selected="selected"' : '' ?>>West Bengal - 19</option>

                                                      <option value="Other territory - 97" <?= ($placetosupply == 'Other territory - 97') ? 'selected="selected"' : '' ?>>Other territory - 97</option>

                                        </select>

                                    </div>













                                </td>

                            </tr>

                        </table>

                    </div>

                    <div class="invicecon">

                        <table border="1" cellspacing="0" cellpadding="0" width="100%" class="stable" style="border-color:#2196F3;">

                            <tr>

                                <td width="85%" valign="top"><p><strong>DESCRIPTION OF THE SERVICES</strong><span style="float:right;" class="btn btn-secondary btn-sm" id="addnew">



                                            Add new</span></p></td>

                                <td width="14%" align="right" valign="top"><p align="right"><strong>AMOUNT</strong></p></td>

                            </tr>

                            <tr>

                                <td width="85%" height="150" valign="top" class="additem"><?php

                                    if ($uid) {



                                        $itemv = explode(":", $itemservice);



                                        $sac_code = explode(":", $sac);



                                        $ii = 0;



                                        foreach ($itemv as $key) {

                                            ?>

                                            <p class="aditem newdata">

                                                <input onkeyup="servicelist(this)" style="width:65%" type="text" value="<?= $key ?>" name="itemservice[]" class="validate[required]" placeholder="Service Name">

                                                <input type="text" name="sac[]" value="<?= $sac_code[$ii] ?>" style="width:20%"  placeholder="Sac Code" />

                                                <a class="uibutton slm" style="color:red; float:right">X</a><span class="appendeddata"></span></p>

                                            <?php

                                            $ii++;

                                        }

                                    } else {

                                        ?>

                                        <p class="newdata">

                                            <input type="text" name="itemservice[]" value="<?= $PDO->getSingleresult("select name from #_product_manager where pid='" . $leadsRow['service'] . "'") ?>" style="width:65%" onkeyup="servicelist(this)" class="validate[required]"  placeholder="Service Name" />

                                            <input type="text" name="sac[]" style="width:20%"  value="<?= $PDO->getSingleresult("select sacCode from #_product_manager where pid='" . $leadsRow['service'] . "'") ?>" placeholder="Sac Code" />

                                            <span class="appendeddata"></span></p>

                                    <?php } ?></td>

                                <td width="14%" height="150" align="right" valign="top" class="additemprice"><?php

                                    if ($uid) {



                                        $pricev = explode(":", $itempriceservice);



                                        foreach ($pricev as $valuev) {

                                            ?>

                                            <p class="aditem">

                                                <input type="number" step="0.01" autocomplete="off" value="<?= $valuev ?>" name="itempriceservice[]" class="validate[required,custom[number]] aadpr" placeholder="4676">

                                            </p>

                                            <?php

                                        }

                                    } else {

                                        ?>

                                        <p>

                                            <input autocomplete="off" type="number" step="0.01" name="itempriceservice[]" class="validate[required,custom[number]] aadpr"  placeholder="4676" />

                                        </p>

                                    <?php } ?></td>

                            </tr>

                            <?php if ($uid) { ?>

                                <tr class="igst" style="display:<?= ($placetosupply != 'Delhi - 07' ? 'table-row' : 'none') ?>">

                                    <td width="85%" valign="top"><p align="left">IGST @ 18 %</p></td>

                                    <td width="14%" align="right" valign="top"><p><span id="srtax">

                                                <?= $hsrtax ?>

                                            </span>/-</p></td>

                                </tr>

                                <tr class="sgst" style="display:<?= ($placetosupply == 'Delhi - 07' ? 'table-row' : 'none') ?>">

                                    <td width="85%" valign="top" ><p align="left">S GST @ 9%</p></td>

                                    <td width="14%" align="right" valign="top"><p><span id="sbtax">

                                                <?= $hsbtax ?>

                                            </span>/-</p></td>

                                </tr>

                                <tr class="sgst" style="display:<?= ($placetosupply == 'Delhi - 07' ? 'table-row' : 'none') ?>">

                                    <td width="85%" valign="top"><p align="left">C GST @ 9%</p></td>

                                    <td width="14%" align="right" valign="top"><p><span id="kktax">

                                                <?= $hkktax ?>

                                            </span>/-</p></td>

                                </tr>

                            <?php } else { ?>

                                <tr class="igst">

                                    <td width="85%" valign="top"><p align="left">IGST @ 18 %</p></td>

                                    <td width="14%" align="right" valign="top"><p><span id="srtax">

                                                <?= $hsrtax ?>

                                            </span>/-</p></td>

                                </tr>

                                <tr class="sgst" style="display:none;">

                                    <td width="85%" valign="top" ><p align="left">S GST @ 9%</p></td>

                                    <td width="14%" align="right" valign="top"><p><span id="sbtax">

                                                <?= $hsbtax ?>

                                            </span>/-</p></td>

                                </tr>

                                <tr class="sgst" style="display:none;">

                                    <td width="85%" valign="top"><p align="left">C GST @ 9%</p></td>

                                    <td width="14%" align="right" valign="top"><p><span id="kktax">

                                                <?= $hkktax ?>

                                            </span>/-</p></td>

                                </tr>

                            <?php } ?>

                            <tr class="reverse-charge" style="display:none;">

                                <td width="85%" valign="top"><p align="left">Supply of Services liable to Reverse Charge</p></td>

                                <td>Yes</td>

                            </tr>

                            <tr>

                                <td width="85%" valign="top"><p><strong>TOTAL</strong> :<span style="float:right;" class="btn btn-secondary btn-sm"  id="adonaddnew">Add new</span> </p></td>

                                <td width="14%" align="right" valign="top"><p><strong><span id="maintotal">

                                                <?= $hmaintotal ?>

                                            </span>/-</strong></p></td>

                            </tr>

                            <tr>

                                <td width="85%" height="150" valign="top" class="adisadditem"><?php

                                    if ($uid && $itemadon != '') {



                                        $itemadoninv = explode(":", $itemadon);



                                        foreach ($itemadoninv as $keyi) {

                                            ?>

                                            <p class="aditem">

                                                <input value="<?= $keyi ?>" type="text" name="itemadon[]" class="validate[required]" placeholder="Service Name">

                                                <a class="uibutton slm closebtn" style=" float:right"><i class="fa fa-window-close-o"></i></a></p>

                                            <?php

                                        }

                                    } else {

                                        ?>



                                    <!-- <p class="aditem"><input type="text" name="itemadon[]" class="validate[required]"  placeholder="Service Name" /><a class="uibutton slm" style="color:red; float:right">X</a></p> -->



                                    <?php } ?></td>

                                <td width="14%" height="150" align="right" valign="top" class="adisadditemprice"><?php

                                    if ($uid && $itempriceadon != '') {



                                        $priceinv = explode(":", $itempriceadon);



                                        foreach ($priceinv as $vali) {

                                            ?>

                                            <p class="aditem">

                                                <input type="number" step="0.01" autocomplete="off" value="<?= $vali ?>" name="itempriceadon[]" class="validate[required,custom[number]]" placeholder="4676">

                                            </p>

                                            <?php

                                        }

                                    } else {

                                        ?>



                                    <!-- <p class="aditem"><input autocomplete="off" type="number" step="0.01" name="itempriceadon[]" class="validate[required,custom[number]]"  placeholder="4676" /></p> -->



                                    <?php } ?></td>

                            </tr>

                            <tr>

                                <td width="85%" valign="top"><p><strong>GROSS TOTAL</strong> : <br />

                                        (<strong>In Words:</strong> <span id="inwords">

                                            <?= $hinwords ?>

                                        </span>)</p></td>

                                <td width="14%" align="right" valign="top"><p align="center"><strong><span id="grasstotal">

                                                <?= $hgrasstotal ?>

                                            </span>/-</strong></p></td>

                            </tr>

                        </table>

                    </div>

                    <input type="hidden" id="hsrtax" name="hsrtax" value="<?= $hsrtax ?>" />

                    <input type="hidden" id="hsbtax" name="hsbtax" value="<?= $hsbtax ?>" />

                    <input type="hidden" id="hkktax" name="hkktax" value="<?= $hkktax ?>" />

                    <input type="hidden" id="hgrasstotal" name="hgrasstotal" value="<?= $hgrasstotal ?>" />

                    <input type="hidden" id="hmaintotal" name="hmaintotal" value="<?= $hmaintotal ?>" />

                    <input type="hidden" id="hinwords" name="hinwords" value="<?= $hinwords ?>" />

                    <input type="hidden" id="filename" name="filename" value="<?= 'invoice_' . time() ?>" />

                    <div class="invicecon foot">

                        <!-- <p>

                            Please Note that GST Council has defined legal services under reverse charge (In the 14th GST council meeting held on may 19 2017) and has shifted the liability to discharge GST on the legal Service from the service provider to the service recipients. Therefore, we have not charged GST herein and would request you to kindly check your liability and pay GST under reverse charge mechanism.



                        </p> -->

                        <p>Kindly make payment in cash or through net banking  by NEFT/ IMPS or issue a cheque in favour of</p>

                        <table style="width:100%">

                            <tr>

                                <td>



                                    <p><label><input type="radio" name="paytobank" value="hdfc" id="paytoindusind" checked="checked"><strong> AGSK & Co."</strong></p>

                                    <p><strong>
ICICI  Bank </strong> (Current A/C)<br />

                                        BRANCH - <strong>
Tagore Park Model Town </strong><br />

                                        ACCOUNT NO. - <strong>399405000597, </strong>IFSC  Code -<strong>ICIC0003994 </strong></label></p>

                                </td>

                                <td>
                                      <!--
                                      <p><label><input type="radio" name="paytobank" value="icici" id="paytoicici"><strong> A G A P & Co."</strong><br>

                                            <strong>STATE BANK OF INDIA</strong> (Current A/C)<br />

                                            BRANCH - <strong>  COLLECTORATE BRANCH </strong><br />

                                            ACCOUNT NO. - <strong>34632779143, </strong>IFSC  Code -<strong>:SBIN0006262</strong></label>
                                            </p>
                                            -->
                                </td>

                            </tr>

                        </table>







                    </div>

                    <div class="cl"></div>

                    <p><strong style="font-size:12px;">This is computer generated receipt no signature required.</strong></p>

                    <div class="footer1"> 137, KD Block, Pitampura, New Delhi 110034<br />

                        <strong>Mobile:</strong>+91 9810602899

                        <strong>E-mail:</strong> sachin@agskca.com </div>

                </div>

            </div>

            <div class="section last">

                <div class="sectioninner">

                    <div class="d-flex justify-content-center mt-2 mb-4">





                        <input type="hidden" name="inviceno" value="<?= $new_invoice_no ?>" />

                        <input type="hidden" name="user_type" value="1" />

                        <input type="hidden" name="lid" value="<?= $lid ?>" />

                        <input type="hidden" name="raid" value="<?= $raid ?>" />

                        <input type="submit" class="uibutton loading btn btn-primary mr-1"  value="Submit" >

                        <input type="button" class="uibutton  special btn btn-primary "  value="Clear form" onclick="location.reload();">

                    </div>



                </div>

            </div>

        </div>

    </div>

</div>

<style>



    *{margin:0; padding:0;}



    .invicewarp{/*width:960px;*/ margin:auto; padding:0 30px 30px; border:1px solid #ccc;}

    .invicewarp strong{font-family:"OpenSans-Semibold";}

    .invicecon{margin-bottom:30px; line-height:22px;}



    .invicecon table tr td{padding:5px;}



    .invicecon table tr td p{line-height:20px;}



    .invicecon.foot p{margin-bottom:12px;}



    .footer1{font-size:12px; text-align:right;}



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



    .btn-group-pms label{width:auto; float:none; display:inline-block; padding:5px 20px; margin:0; font-size:16px;}



    .igst{display:none;}

    table.firsttable tr td.std .inputf {

        width: 70%;

        display: block;

        float: left;

    }

    .large{  width: 69%; margin-bottom:4px; max-width: 69%;}



</style>

<script>



    jQuery(document).ready(function () {



        // binds form submission and fields to the validation engine



        jQuery("#formID").validationEngine({promptPosition: 'inline'});



        /*$("#formID").bind("jqv.form.result", function(event, errorFound) {



         if(errorFound) alert("There is a problem with your form");



         })*/



    });







    /*$.validator.methods.validateDate = function( value, element ) {



     return this.optional( element ) || /\b\d{4}[\/-]\d{1,2}[\/-]\b\d{1,2} (0\d|1[01]):[0-5]\d:[0-5]\d$\b/.test( value );



     }*/



    function ValidateDate(dtValue)



    {



        var dtRegex = new RegExp(/\b\d{4}[\/-]\d{1,2}[\/-]\b\d{1,2} (0\d|1[01]):[0-5]\d:[0-5]\d$\b/);



        return dtRegex.test(dtValue);



    }



</script>

<script>



    $(document).ready(function (e) {



        $('#addnew').on('click', function () {



            var addtm = 'onkeyup="servicelist(this)"';



            additems('additem', 'additemprice', 'service', addtm);



        })



        $('#adonaddnew').on('click', function () {



            var addtm = '';



            additems('adisadditem', 'adisadditemprice', 'adon', addtm);



        })



        $('.additem').on('click', '.aditem a', function () {



            removebox($(this), 'additemprice')







        })



        $('.adisadditem').on('click', '.aditem a', function () {



            removebox($(this), 'adisadditemprice')







        })



        $('.additemprice').on('keyup', 'p input', function () {



            calculation()



        });



        $('.adisadditemprice').on('keyup', 'p input', function () {



            calculation()



        });







    });















    function removebox(a, b) {



        var indx = a.parent().index();



        $('.' + b).children('.aditem').eq(indx).remove();



        a.parent().remove();



        calculation();



    }

    ;



    function additems(a, b, c, d) {



        $('.' + a).append('<p class="aditem newdata"><input type="text" style="width:65%" name="item' + c + '[]" ' + d + ' class="validate[required]" placeholder="Service Name" /> <input type="text" name="sac[]" style="width:20%"  placeholder="Sac Code" /><a class="uibutton slm" style="color:red; float:right; font-size:1.5rem;" ><i class="fa fa-window-close"></i></a><span class="appendeddata"></span></p>');







        $('.' + b).append('<p class="aditem"><input autocomplete="off" type="number" step="0.01" name="itemprice' + c + '[]" class="validate[required,custom[number]] aadpr"  placeholder="4676" /></p>');







    }

    ;



    function calculation() {



        var total = 0



        var total2 = 0



        $('.additemprice').find('p input').each(function (index, element) {



            if (element.value > 0) {



                total += parseFloat(element.value);



            }



        });



        $('.adisadditemprice').find('p input').each(function (index, element) {



            if (element.value > 0) {



                total2 += parseFloat(element.value);



            }



        });



        $('#srtax').text(taxes(total, 18).toFixed(2));



        $('#sbtax').text(taxes(total, 9).toFixed(2));



        $('#kktax').text(taxes(total, 9).toFixed(2));



        var grt = $('#isGSTApplicable').val() == 'yes' ? (total + taxes(total, 18)) : total;



//console.log(grt);



        $('#maintotal').text(Math.round(grt));



        $('#inwords').text(inWords(Math.round(grt + total2)));

        if ($('#isGSTApplicable').val() == 'yes') {

            $('#hsrtax').val(taxes(total, 18).toFixed(2));



            $('#hsbtax').val(taxes(total, 9).toFixed(2));



            $('#hkktax').val(taxes(total, 9).toFixed(2));

        }

        $('#hgrasstotal').val(Math.round(grt + total2));



        $('#hmaintotal').val(Math.round(grt));



        $('#hinwords ').val(inWords(Math.round(grt + total2)));



        $('#grasstotal').text(Math.round(grt + total2));



    }



    function taxes(a, b) {



        return a * b / 100



    }







    var a = ['', 'one ', 'two ', 'three ', 'four ', 'five ', 'six ', 'seven ', 'eight ', 'nine ', 'ten ', 'eleven ', 'twelve ', 'thirteen ', 'fourteen ', 'fifteen ', 'sixteen ', 'seventeen ', 'eighteen ', 'nineteen '];



    var b = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];



    function inWords(num) {



        if ((num = num.toString()).length > 9)

            return num;



        n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);



        if (!n)

            return;



        var str = '';



        str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';



        str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';



        str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';



        str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';



        str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';



        return 'Rupees ' + str;



    }



    function servicelist(el) {



        $.ajax({



            url: '<?= SITE_PATH_ADM . _MODS . '/invoice/' ?>ajax_refresh.php',



            type: 'POST',



            data: {'keyword': el.value, 'created_on': '<?= $created_on ?>'},



            success: function (data) {



                var parent = el.parentNode



                var node = parent.querySelector('.appendeddata');



                node.innerHTML = data;



            }



        });



    }



    function set_item(a, b, c, d) {



        var prnt = a.parentNode.parentNode.parentNode;



        var ntdt = prnt.getElementsByTagName('input')[0];



        var as = prnt.getElementsByTagName('input')[1];



        as.value = c;



        ntdt.value = b;

        //console.log(d);

        //$('.aadpr').val(d);



        var rmd = a.parentNode.parentNode;



        //rmd.style.display="none";



        rmd.removeChild(rmd.lastChild);



        rmd.previousSibling.value = '44';



        console.log(rmd);



        //prnt.removeChild(rmd);



    }



    jQuery(document).on("click", function (e) {



        var $clicked = jQuery(e.target);



        if (!$clicked.hasClass("appendeddata")) {



            jQuery(".appendeddata ul").remove();



        }



    });



    function showigst() {

        var val = $('#placetosupply').val();

        console.log(val);

        $('.reverse-charge').hide();

        $('.sgst').hide();

        $('.igst').hide();

        if ($('#isGSTApplicable').val() == 'yes') {

            if (val != '') {

                if (val == 'Delhi - 07') {

                    $('.sgst').show();

                } else {

                    $('.igst').show();

                }

            }

        } else {

            $('.reverse-charge').show();

        }

        //$('.'+show).show();



        //$('.'+hide).hide();



    }







    $(function () {



        $('#datetimepicker').datetimepicker({



            format: 'yyyy-mm-dd hh:ii:ss',



            autoclose: true,



            endDate: '+0d',



        });



    });



</script>



<!--Date and time picker-->

<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>

<script src='js/timepicker.js'></script>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css">

<script >$('.time').timepicker({

        controlType: 'select',

        timeFormat: 'hh:mm tt'

    });

</script>

<script>

    $('[data-toggle=datepicker]').each(function () {

        var target = $(this).data('target-name');

        var t = $('input[name=' + target + ']');

        t.datepicker({

            dateFormat: 'yy-mm-dd',

            changeMonth: true,

            changeYear: true,

            maxDate: new Date(),

            //  yearRange: "2005:2015"

            yearRange: "-100:+0", // last hundred years

        }).datepicker("setDate", new Date());

        $(this).on("click", function () {

            t.datepicker("show");

        });

    });

</script>