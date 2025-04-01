<body>
<section class="mtb50">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 center-block text-center">
      <a href="<?=SITE_PATH_ADM.'index.php?comp='?>crms"  class="btn btn-secondary mbt15">Manage CRMS</a></div>
    </div>
   <div class="row bold">
      <div class="col-lg-6 ">
        <div class="card  align-items-stretch w-100 minheight "> 
          <div class="row">
            <div class="col-sm-6">
              <div class="card-title">
                <h2 >Daily Lead Addition</h2>
              </div>
            </div>
          </div>
          <?php 
		  $wrchart="where 1";

		  $folups="where 1";
if($_SESSION["AMD"][3]=='5'){

 $extra = " and create_by='".$_SESSION["AMD"][0]."'"; 

 $adminqry="and user_id='".$_SESSION["AMD"][0]."'";



 $wrchart="where create_by='".$_SESSION["AMD"][0]."'";

  $folups="where sentBy='".$_SESSION["AMD"][0]."'";
}

            $comma=',';
			$date = date('Y-m-d', strtotime('-6 days'));
			$end_date = date('Y-m-d');
			$leadsarr=array();
			$followtotal='';
			$datearry='';
			$startuparena='';
			$selfcall='';
			$a=1;

	while (strtotime($date) <= strtotime($end_date)) {
		if($a==7){$comma='';}
		$dcount=$PDO->getSingleresult("select count(*) from #_crms ".$wrchart." and date(created_on)='".$date."' ");
		
				$leadarr=array( "name" => date('jS \ M y', strtotime($date)),"y" =>$dcount,"drilldown" =>date('jS \ M y', strtotime($date)));
				array_push($leadsarr,$leadarr);
                $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
	$a++;}
		   ?>
          <div id="DailyLead" style="height: 100%"></div>
          <script type="text/javascript">
Highcharts.chart('DailyLead', {colors: ['#00293c', '#00293c', '#00293c', '#00293c', '#00293c','#ff0066', '#eeaaee', '#55BF3B', '#DF5353', '#7798BF', '#aaeeee'],chart: {  backgroundColor: '#fafafa',type: 'column'},credits: {enabled: false },title: { text: ''},subtitle: {text: ''},xAxis: {type: 'category'},yAxis: {title: { text: 'Daily Lead Addition'}},legend: {enabled: false},plotOptions: {series: {borderWidth: 0,dataLabels: {enabled: true, // format: '{point.y:.1f}'
} } },tooltip: { //headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
       // pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
	   },series: [{name: 'Leads',colorByPoint: false,data: <?=json_encode($leadsarr)?> }],});
 </script> 
        </div>
        
     
        
      </div>
   <div class="col-lg-6">
        <div class="card"> 
          <div class="row">
            <div class="col-sm-6">
              <div class="card-title">
                <h2>Financial Year Wise</h2>
              </div>
            </div>
            <?php 
		   $fyarr =array('2014-15','2015-16','2016-17','2017-18','2018-19','2019-20'); 
		   $sourceearr=array();
	       foreach($fyarr as $fyres){
		 $scnt2=$PDO->getSingleresult("select count(*) from #_crms  where  find_in_set('".$fyres."', Replace(fy, ':', ','))");
		 if($scnt2!=''){
	  $sodarr=array("name" =>$fyres.'<br>'.$scnt2,"y" =>$scnt2, "cnt"=>$scnt2);
				array_push($sourceearr,$sodarr);
		   }}
		   ?>
            <div id="Sourcetype" style="min-height:500px"></div>
            <script type="text/javascript">
var pieColors = (function () {var colors = [],base = Highcharts.getOptions().colors[0],i;for (i = 0; i < 10; i += 1) {colors.push(Highcharts.Color(base).brighten((i - 3) / 7).get());}return colors;}());

Highcharts.chart('Sourcetype', {colors: ['#4285f4', '#0000ff', '#ea4335', '#ea4335', '#099346','#0f1b2f', '#0000ff', '#ff0000', '#9900cc', '#099346', '#aaeeee','#00000','#918887','#749442','#996666','#37b54a'],

chart: {backgroundColor: '#fafafa',plotBorderWidth: null,plotShadow: false,type: 'pie'},credits: {enabled: false},title: {text: ''},tooltip: {pointFormat: '{series.name}: <b>{point.cnt}</b>'}, plotOptions: { pie: { allowPointSelect: true,size: '50%',cursor: 'pointer',dataLabels: {enabled: true,style: {color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black' }}}},
    series: [{name: 'Total',colorByPoint: true,data:<?=json_encode($sourceearr)?>}]});
 </script> 
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="mtb50">
  <div class="container">
    <div class="row">
      
      <div class="col-lg-6">
        <div class="card">
          <?php 
		   $audatas='';
			$totalled =$PDO->getSingleresult("select count(*) from #_crms ".$wrchart." and taxexe!=0");
			$auQuery =$PDO->db_query("select taxexe, count(*) as count from #_crms ".$wrchart." and taxexe!=0  group by taxexe");
		   while($aurow=$PDO->db_fetch_array($auQuery, PDO::FETCH_GROUP)){
			$auname=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$aurow['taxexe']."'");
			$audatas.='{"name": "'.$auname.'<br>'.$aurow['count'].'", "y": '.$aurow['count'].'},';
		   }?>
          <div id="taxexe" style="min-height:500px"></div>
           

<script type="text/javascript">var pieColors = (function () {var colors = [],base = Highcharts.getOptions().colors[0],i;for (i = 0; i < 10; i += 1) {colors.push(Highcharts.Color(base).brighten((i - 3) / 7).get());}return colors;}());Highcharts.chart('taxexe', {colors: ['#81b537', '#ea4335', '#FFA500', '#0f1b2f', '#34a853', '#ea4335', '#0000ff', '#ff0000', '#9900cc', '#099346', '#aaeeee'],chart: {type: 'pie'},credits: {enabled: false},legend: {align: 'left',layout: 'vertical',verticalAlign: 'top',labelFormatter: function () {return this.name +' '+ this.y;},x: 0,y: 0,},title: {text: 'Taxation Executive wise (Total <?=$totalled?>)'},subtitle: {//  text: 'Lead Allocation by Salesecutive'
		  },plotOptions: {pie: {allowPointSelect: true,size: '50%',cursor: 'pointer',dataLabels: {enabled: true,style: {color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'}}}},"series": [{"name": "Total","colorByPoint": true,"data": [<?=$audatas?>]}]});</script>
        </div><!-- /# card --> </div>
        
        <div class="col-lg-6">
        <div class="card">
          <?php 
		   $audatas='';
			$totalled =$PDO->getSingleresult("select count(*) from #_crms ".$wrchart."  and incexe!=0");
			$auQuery =$PDO->db_query("select DISTINCT MONTH(created_on) as months from #_crms ".$wrchart."");
		   while($aurow=$PDO->db_fetch_array($auQuery, PDO::FETCH_GROUP)){
			$auname=$PDO->getSingleresult("select count(*) from #_crms ".$wrchart."  and MONTH(created_on)='".$aurow['months']."'");
			$audatas.='{"name": "'.date('F',strtotime($aurow['months'])).'<br>'.$auname.'", "y": '.$auname.'},';
		   }?>
          <div id="monthwise" style="min-height:500px"></div>
          <script type="text/javascript">var pieColors = (function () {var colors = [],base = Highcharts.getOptions().colors[0],i;for (i = 0; i < 10; i += 1) {colors.push(Highcharts.Color(base).brighten((i - 3) / 7).get());}return colors;}());Highcharts.chart('monthwise', {colors: ['#81b537', '#ea4335', '#FFA500', '#0f1b2f', '#34a853', '#ea4335', '#0000ff', '#ff0000', '#9900cc', '#099346', '#aaeeee'],chart: {type: 'pie'},credits: {enabled: false},legend: {align: 'left',layout: 'vertical',verticalAlign: 'top',labelFormatter: function () {return this.name +' '+ this.y;},x: 0,y: 0,},title: {text: 'Month wise (Total <?=$totalled?>)'},subtitle: {//  text: 'Lead Allocation by Salesecutive'
		  },plotOptions: {pie: {allowPointSelect: true,size: '50%',cursor: 'pointer',dataLabels: {enabled: true,style: {color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'}}}},"series": [{"name": "Total","colorByPoint": true,"data": [<?=$audatas?>]}]});</script> </div><!-- /# card --> </div>
        </div></div><!-- /# row --></div>
  </div>
</section>
<section class="mtb50">
  <div class="container">
    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <?php 

		   $audatas='';
			$totalled =$PDO->getSingleresult("select count(*) from #_crms ".$wrchart." ");

			$auQuery =$PDO->db_query("select create_by, count(*) as count from #_crms ".$wrchart."  group by create_by");

			

		   while($aurow=$PDO->db_fetch_array($auQuery, PDO::FETCH_GROUP)){

			   if($aurow['create_by']==0){

				$auname='Not assigned';   

			   }else{

			$auname=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$aurow['create_by']."'");

			   }

			$audatas.='{"name": "'.$auname.'<br>'.$aurow['count'].'", "y": '.$aurow['count'].'},';

		   }

		   ?>
          <div id="seusers" style="min-height:500px"></div>
          <script type="text/javascript">





   // Make monochrome colors

var pieColors = (function () {

    var colors = [],

        base = Highcharts.getOptions().colors[0],

        i;



    for (i = 0; i < 10; i += 1) {

        // Start out with a darkened base color (negative brighten), and end

        // up with a much brighter color

        colors.push(Highcharts.Color(base).brighten((i - 3) / 7).get());

    }

    return colors;

}());



// Build the chart

Highcharts.chart('seusers', {

colors: ['#81b537', '#ea4335', '#FFA500', '#0f1b2f', '#34a853', '#ea4335', '#0000ff', '#ff0000', '#9900cc', '#099346', '#aaeeee'],



chart: {

        type: 'pie'

    },

credits: {

	enabled: false

  },

 legend: {

    align: 'left',

    layout: 'vertical',

    verticalAlign: 'top',

	labelFormatter: function () {

            return this.name +' '+ this.y;

        },

    x: 0,

    y: 0,

},

title: {

        text: 'Sales Person wise (Total <?=$totalled?>)'

    },

    subtitle: {

      //  text: 'Lead Allocation by Salesecutive'

    },

    plotOptions: {

        pie: {

            allowPointSelect: true,

			 size: '50%',

                       // innerSize: '60%',

            cursor: 'pointer',

            dataLabels: {

                enabled: true,

               // format: '<b>{point.name}</b>: {point.percentage:.f} ',

                style: {

                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'

                }

            }

        }

    },

    "series": [

        {

            "name": "Total",

            "colorByPoint": true,

            "data": [

                <?=$audatas?>

            ]

        }

    ]

});



    

 </script> 
        </div>
        
        <!-- /# card --> 
        
      </div>
      <div class="col-lg-6">
        <div class="card">
          <?php 
		   $audatas='';
			$totalled =$PDO->getSingleresult("select count(*) from #_crms ".$wrchart."  and incexe!=0");
			$auQuery =$PDO->db_query("select incexe, count(*) as count from #_crms ".$wrchart." and incexe!=0  group by incexe");
		   while($aurow=$PDO->db_fetch_array($auQuery, PDO::FETCH_GROUP)){
			$auname=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$aurow['incexe']."'");
			$audatas.='{"name": "'.$auname.'<br>'.$aurow['count'].'", "y": '.$aurow['count'].'},';
		   }?>
          <div id="incexe" style="min-height:500px"></div>
          <script type="text/javascript">var pieColors = (function () {var colors = [],base = Highcharts.getOptions().colors[0],i;for (i = 0; i < 10; i += 1) {colors.push(Highcharts.Color(base).brighten((i - 3) / 7).get());}return colors;}());Highcharts.chart('incexe', {colors: ['#81b537', '#ea4335', '#FFA500', '#0f1b2f', '#34a853', '#ea4335', '#0000ff', '#ff0000', '#9900cc', '#099346', '#aaeeee'],chart: {type: 'pie'},credits: {enabled: false},legend: {align: 'left',layout: 'vertical',verticalAlign: 'top',labelFormatter: function () {return this.name +' '+ this.y;},x: 0,y: 0,},title: {text: 'Incorporation Executive wise (Total <?=$totalled?>)'},subtitle: {//  text: 'Lead Allocation by Salesecutive'
		  },plotOptions: {pie: {allowPointSelect: true,size: '50%',cursor: 'pointer',dataLabels: {enabled: true,style: {color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'}}}},"series": [{"name": "Total","colorByPoint": true,"data": [<?=$audatas?>]}]});</script> </div><!-- /# card --> </div></div></div><!-- /# row --></div></div></section>
          

<section class="mtb50">
  <div class="container ">
    <div class="row">
      <div class="col-lg-12  followup">
        <div class="card">
          <div class="card-title">
            <h2> Payment Pending </h2>
          </div>
          <div class="table-responsive">
            <table id="paymentPending" class="table table-striped table-bordered" style="width:100%">
              <thead>
                <tr>
                  <th>Sl. No.</th>
                  <th>Name of Executive</th>
                  <th>No Of Tickets </th>
                  <th>Amount</th>
                  
                  <!--<th>Status</th>--> 
                  
                </tr>
              </thead>
              <tbody>
                <?php

			

				

				 $pendingry =$PDO->db_query("select * from pms_admin_users where status=1 and user_type=5 ".$adminqry.""); 

				$sk=1;

	       while($pendingRs = $PDO->db_fetch_array($pendingry)){

			 $ssamount=$PDO->getSingleresult("select sum(quotation) from #_crms where create_by='".$pendingRs['user_id']."'");

		$rrrAmount=$PDO->getSingleresult("select sum(qAmount) from #_paymentdetails_crms where sentBy='".$pendingRs['user_id']."' "); 

		if(($ssamount-$rrrAmount)!=0){

			    ?>
                <tr>
                  <td><?=$sk?></td>
                  <td><a href="#" data-toggle="modal" data-target="#paymentpending<?=$pendingRs['user_id']?>">
                    <?=$pendingRs['name']?>
                    </a> 
                    
                    <!-- The Modal -->
                    
                    <div class="modal fade" id="paymentpending<?=$pendingRs['user_id']?>">
                      <div class="modal-dialog" style="max-width:80%; width:80%">
                        <div class="modal-content w-100 table-responsive"> 
                          
                          <!-- Modal Header -->
                          
                          <div class="modal-header">
                            <h4 class="modal-title">Payment Pending</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>
                          
                          <!-- Modal body -->
                          
                          <div class="modal-body table-responsive">
                            <table class="table table-bordered table-responsive-xs table-responsive-sm  table-striped custom-table">
                              <thead>
                                <tr>
                                  <th>Sl No</th>
                                  <th>Client Name </th>
                                  <th>Company Name</th>
                                  <th>Ticket no</th>
                                  <th>Total</th>
                                  <th>Recived</th>
                                  <th>Pending</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php $payleadsry =$PDO->db_query("select * from #_crms where create_by='".$pendingRs['user_id']."'"); 

							  $cc=1;

							  $total_price = 0;

							   $r_price = 0;

							   $noofinvoice = 0;

	       while($leadspayRs = $PDO->db_fetch_array($payleadsry)){

			 

			 $invoiamount=$PDO->getSingleresult("select sum(quotation) from #_crms where create_by='".$pendingRs['user_id']."' and pid='".$leadspayRs['pid']."'");

		$recieAmount=$PDO->getSingleresult("select sum(qAmount) from #_paymentdetails_crms where sentBy='".$pendingRs['user_id']."' and lid='".$leadspayRs['pid']."'");

		

			 if( $invoiamount>$recieAmount) { 

			 $total_price += $invoiamount; 

		   $r_price += $recieAmount; 

			$noofinvoice += 1; 

			    ?>
                                <tr>
                                  <td><?=$cc?></td>
                                  <td><?=$leadspayRs['name']?></td>
                                  <td><?=$leadspayRs['cname']?></td>
                                  <td><?=$leadspayRs['rwi']?></td>
                                  <td>Rs
                                    <?=$invoiamount?></td>
                                  <td>Rs
                                    <?=$recieAmount?></td>
                                  <td>Rs
                                    <?=(int)$invoiamount - (int)$recieAmount?></td>
                                </tr>
                                <?php $cc++;}} ?>
                              </tbody>
                            </table>
                          </div>
                          
                          <!-- Modal footer -->
                          
                          <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div></td>
                  <td><?=$noofinvoice?></td>
                  <td>Rs
                    <?=(int)$total_price - (int)$r_price?></td>
                </tr>
                <?php $sk++;}} ?>
              </tbody>
              
              <!--     <tfoot>



            <tr>



               <th>#</th>



                <th>Sale Executive</th>



                <th>RW Ticket</th>



                <th>Customer Name</th>



                <th>Customer Phone</th>



                <th>Date/Time</th>



                <th>Action</th>



            </tr>



        </tfoot>-->
              
            </table>
            <script>



	$(document).ready(function() {



    $('#paymentPending').DataTable();



} );



	</script> 
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php //include('cuts/footer.inc.php');  ?>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> 
<script src='js/timepicker.js'></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="css/timepicker.css">
<script >

$('#profitdates').datepicker( {maxDate: 0,dateFormat: 'yy-mm-dd',

  onSelect: function(dateText) {

    console.log("Selected date: " + dateText + "; input's current value: " + this.value);

	

	

	data= {'profitdates':this.value}

$.ajax({

    type: "POST",

    url: "<?=SITE_PATH_ADM?>modules/leadsAjax.php",

    data: data,

    success: function(data) {

	console.log(data);	

	$('#profitdaywise').html(data);

		},

    error: function() {

        alert('error handing here');



    }

});

	return false;

  }

});



$('.time').timepicker({

	controlType: 'select',

	timeFormat: 'hh:mm tt'

});



$('.date').datepicker( {maxDate: 0,dateFormat: 'yy-mm-dd'});



function validate4msg(){



	var phone=$('#phone4msg').val();

	var msg=$('#dis4msg').val();



	if(mobileNumber(phone) && checkmsg(msg)){



		var status = 'phone='+phone+'&msg='+msg;



		console.log(status);



		$.post("<?=SITE_PATH_ADM?>modules/leads/sendsms.php", status, function(result) {



               if(result==1){



				   $('#success4msg').show();



				   $('#phone4msg').val("");



				   $('#dis4msg').val("");



				   }else{



				   $('#error4msg').show()   



				   }



            });



       



		}



		checkmsg(msg);



	}



function mobileNumber(Number){



     var IndNum = /^[0]?[789]\d{9}$/;



     if(IndNum.test(Number)){



		 $('#phone4msg').parents('.form-group').removeClass('has-error').addClass('has-success')



        return true;



    }



    else{



		$('#phone4msg').parents('.form-group').addClass('has-feedback has-error')



		return 'failure';



    }



}







function checkmsg(msg)



  {



    if(msg == "") {



     $('#dis4msg').parents('.form-group').addClass('has-feedback has-error')



      return false;



    }



    var re = /^[a-zA-Z0-9~@&#$!"\/;',%^*^\n()_+=[\]{}|\\,.?: -]{10,}$/;



	



    if(!re.test(msg)) {



      $('#dis4msg').parents('.form-group').addClass('has-feedback has-error')



	  $('#dis4msg').parents('.form-group').children('.has-feedback.has-error .help-block').text('it should be minimum 10 character and not contain special characters');



      return false;



    }



	$('#dis4msg').parents('.form-group').removeClass('has-error').addClass('has-success')



    return true;



  }



</script>
<style>

.bgddd{background-color:#ddd;padding-top:3rem; padding-bottom:3rem;}

.ui-datepicker{z-index:9999999 !important;}



</style>
</body>
</html>