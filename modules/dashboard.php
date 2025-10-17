<?php

//include('lib/config.inc.php');

// include("cuts/meta.inc.php"); ?>

<body>
<?php //include("cuts/header.inc.php");

//include("cuts/breadcrumb.inc.php");



//include("lib/modules.php");



if(($_SESSION["AMD"][3]==2 && $_SESSION["AMD"][5]==4) || $_GET['dept']=='inc'){
include 'inc-head-dashboard.php';
}
elseif($_SESSION["AMD"][3]==4 && $_SESSION["AMD"][5]==4){
include 'inc-executive-dashboard.php';
}
elseif(($_SESSION["AMD"][3]==2 && $_SESSION["AMD"][5]==6) || $_GET['dept']=='tax'){
include 'taxation-head-dashboard.php';
}
elseif($_SESSION["AMD"][3]==4 && $_SESSION["AMD"][5]==6){
include 'taxation-executive-dashboard.php';
}
elseif(($_SESSION["AMD"][3]==2 && $_SESSION["AMD"][5]==5) || $_GET['dept']=='trademark'){
include 'trademark-head-dashboard.php';
}
elseif($_SESSION["AMD"][3]==4 && $_SESSION["AMD"][5]==5){
include 'trademark-executive-dashboard.php';
}
else{
 ?>
<section class="mtb50">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 center-block text-center">
      <?php  if(in_array($_SESSION["AMD"][3],array("1", "6"))){?>
      <a href="<?=SITE_PATH_ADM.'index.php?comp='?>leads&department=2"  class="btn btn-secondary mbt15">Manage Lead</a>
      <?php } else { ?>
        <a href="<?=SITE_PATH_ADM.'index.php?comp='?>leads"  class="btn btn-secondary mbt15">Manage Lead</a>
        <?php } ?>
       <a href="<?=SITE_PATH_ADM.'index.php?comp='?>invoice"  class="btn btn-success mbt15">Manage Invoice</a>
      <!--  <a href="<?=SITE_PATH_ADM.'index.php?comp='?>project" class="btn btn-info mbt15">Manage order</a> -->
        <a href="<?=SITE_PATH_ADM.'index.php?comp='?>sales_report" class="btn btn-danger mbt15">Sales report</a> </div>

    </div>
    <div class="row bold">
      <div class="col-lg-6 ">
        <div class="card  align-items-stretch w-100 minheight ">
          <!--<div class="row">
            <div class="col-5">
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="date form-control datetimepicker-input pl-2 pr-2"  placeholder="from"/>
                  <div class="input-group-append">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-5">
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="date form-control datetimepicker-input pl-2 pr-2"  placeholder="to"/>
                  <div class="input-group-append">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-2">
              <button class="btn  btn-success">Go</button>
            </div>
          </div>-->
          <div class="row">
            <div class="col-sm-6">
              <div class="card-title">
                <h2 >Daily Lead Addition</h2>
              </div>
            </div>
            <!--<div class="col-sm-6 ">
              <select class="pull-right">
                <option>Daily</option>
                <option>Week</option>
                <option>Monthly</option>
              </select>
            </div>-->
          </div>
          <?php

		  $wrchart="where 1";
		  $folups="where 1";

if($_SESSION["AMD"][3]=='5'){

 $extra = " and create_by='".$_SESSION["AMD"][0]."' or salesecutiveid='".$_SESSION["AMD"][0]."'";
 $adminqry="and user_id='".$_SESSION["AMD"][0]."'";

 $wrchart="where salesecutiveid='".$_SESSION["AMD"][0]."'";
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





				$leadarr=array( "name" => date('jS \ M y', strtotime($date)),"y" =>$PDO->getSingleresult("select count(*) from #_leads ".$wrchart." and date(created_on)='".$date."' "),"drilldown" =>date('jS \ M y', strtotime($date)));
				array_push($leadsarr,$leadarr);
                $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));

	$a++;}
		   ?>
          <div id="DailyLead" style="height: 100%"></div>
          <script type="text/javascript">
Highcharts.chart('DailyLead', {
	colors: ['#c61d23', '#00293c', '#00293c', '#00293c', '#00293c','#ff0066', '#eeaaee', '#55BF3B', '#DF5353', '#7798BF', '#aaeeee'],
	 chart: {  backgroundColor: '#fafafa',type: 'column'},
	  credits: {
      enabled: false },
    title: { text: ''},
    subtitle: {text: ''},
    xAxis: {type: 'category'},
    yAxis: {title: { text: 'Daily Lead Addition'}
    },

    legend: {

        enabled: false

    },
    plotOptions: {
        series: {
            borderWidth: 0,

            dataLabels: {

                enabled: true,

               // format: '{point.y:.1f}'
            } } },
    tooltip: {
        //headerFormat: '<span style="font-size:11px">{series.name}</span><br>',

       // pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
    },

    series: [{name: 'Leads',colorByPoint: false,data: <?=json_encode($leadsarr)?> }],
});

 </script>
        </div>

        <!-- /# card -->

      </div>
      <div class="col-lg-6">
        <div class="card  align-items-stretch w-100 ">
          <div class="row justify-content-end">
            <div class="col-6">
              <div class="form-group">
                <div class="input-group">
                  <input type="text" onChange="getfunnel(this.value)" name="fdate" class="date form-control datetimepicker-input pl-2 pr-2"  placeholder="Select Date"/>
                  <div class="input-group-append">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>
            </div>

          </div>
           <script>
            function getfunnel(dates){
	data= {'funneldate':dates}
$.ajax({
    type: "POST",
    url: "<?=SITE_PATH_ADM?>modules/leadsAjax.php",
    data: data,
    success: function(data) {
	$('#Funnel').html(data);
		},
    error: function() {
        alert('error handing here');

    }
});
	return false;}
            </script>
          <div class="card-title">
            <h2 class="text-center"> Overall Lead Funnel</h2>
          </div>
          <div class="card-body">
            <?php

		  $comm=',';

		  $ii=1;

		   $lSry =$PDO->db_query("select * from #_lead_stage where status=1 order by shortorder ASC");



	       while($lSRs = $PDO->db_fetch_array($lSry)){

			if($lSry->rowCount()==$ii){

				$comm='';

				}

	 $cnt= $PDO->getSingleresult("select count(*) from #_leads ".$wrchart."  and status='".$lSRs['pid']."'");



	   $stages .= '['.'\''.$lSRs['name'].'\','.$cnt.']'.$comm;

		  $ii++;

		   }



		   ?>
            <div id="Funnel" style="height: 100%"></div>
            <script>

			Highcharts.chart('Funnel', {



   colors: ['#28a745', '#1e406d', '#d1b655', '#454545', '#aaeeee',

      '#ff0066', '#eeaaee', '#55BF3B', '#DF5353', '#7798BF', '#aaeeee'],



    chart: {

				        backgroundColor: '#fafafa',



        type: 'funnel'

    },

	   credits: {

      enabled: false

  },







    title: {

        text: ''

    },

    plotOptions: {

        series: {

            dataLabels: {

                enabled: true,

                format: '<b>{point.name}</b> ({point.y:,.0f})',

                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',

                softConnector: true

            },

            center: ['40%', '50%'],

            neckWidth: '30%',

            neckHeight: '25%',

            width: '70%'

        }

    },

    legend: {

        enabled: false

    },

    series: [{

        name: 'Registrationwala',

        data: [<?=$stages?>]

    }]

});

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
          <!--<div class="row">
            <div class="col-5">
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="date form-control datetimepicker-input pl-2 pr-2"  placeholder="from"/>
                  <div class="input-group-append">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-5">
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="date form-control datetimepicker-input pl-2 pr-2"  placeholder="to"/>
                  <div class="input-group-append">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-2">
              <button class="btn  btn-success">Go</button>
            </div>
          </div>-->
          <div class="row">
            <div class="col-sm-6">
              <div class="card-title">
                <h2>Source Type</h2>
              </div>
            </div>
            <!--<div class="col-sm-6 ">
              <select class="pull-right">
                <option>Daily</option>
                <option>Week</option>
                <option>Monthly</option><?=$leaveRow['comments']?>
              </select>
            </div>-->
            <?php

		   $sourcery =$PDO->db_query("select * from #_lead_source where status=1");

		   $sourceearr=array();

	       while($sourceRs = $PDO->db_fetch_array($sourcery)){



		 $scnt2=$PDO->getSingleresult("select count(*) from #_leads  ".$wrchart." and source='".$sourceRs['pid']."'");

		 if($scnt2!=''){

	  $sodarr=array("name" =>$sourceRs['name'].'<br>'.$scnt2,"y" =>$scnt2, "cnt"=>$scnt2);

				array_push($sourceearr,$sodarr);

		   }}



		   ?>
            <div id="Sourcetype" style="min-height:500px"></div>
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

Highcharts.chart('Sourcetype', {

	colors: ['#4285f4', '#0000ff', '#ea4335', '#ea4335', '#099346',

      '#0f1b2f', '#0000ff', '#ff0000', '#9900cc', '#099346', '#aaeeee','#00000','#918887','#749442','#996666','#37b54a'],





chart: {

		 		        backgroundColor: '#fafafa',

        plotBorderWidth: null,

        plotShadow: false,

        type: 'pie'

    },



			   credits: {

      enabled: false

  },



    title: {

        text: ''

    },

   tooltip: {

        pointFormat: '{series.name}: <b>{point.cnt}</b>'

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

    series: [{

        name: 'Total',

        colorByPoint: true,

		data:<?=json_encode($sourceearr)?>



    }]

});

 </script>
          </div>

          <!-- /# card -->

        </div>
      </div>
      <div class="col-lg-6">
        <div class="card">
          <?php
		   $audatas='';
			$totalled =$PDO->getSingleresult("select count(*) from #_leads ".$wrchart." " );
			$auQuery =$PDO->db_query("select cityID, count(*) as count from #_leads ".$wrchart."  and cityID!=0 group by cityID");

		   while($aurow=$PDO->db_fetch_array($auQuery, PDO::FETCH_GROUP)){
			   if($aurow['count']>1){
			   if($aurow['cityID']==0){
				$auname='N/A';
			   }else{
			$auname=$PDO->getSingleresult("select name from #_india_cities where pid='".$aurow['cityID']."' ");
			   }
			$audatas.='{"name": "'.$auname.'", "y": '.$aurow['count'].'},';
		   }}
		   ?>

          <div id="india_citiesmana" style="min-height:500px"></div>
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
Highcharts.chart('india_citiesmana', {
colors: ['#4285f4', '#ea4335', '#FFA500', '#0f1b2f', '#34a853', '#ea4335', '#0000ff', '#ff0000', '#9900cc', '#099346', '#aaeeee'],

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
        text: 'City wise Lead'
    },
    subtitle: {
       // text: 'Lead Allocation by Salesecutive'
    },
    plotOptions: {
        series: {
            dataLabels: {
                enabled: true,
                format: '{point.name}: {point.y}'
            },
			showInLegend: true,

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

    </div>
  </div>

  <!-- /# row -->

  </div>
  </div>
</section>
<section class="mtb50">
  <div class="container">
    <div class="row">
    <div class="col-lg-6">
        <div class="card">
          <?php
		   /*$spQuery =$PDO->db_query("select spid, count(*) as count from #_leads where 1 group by spid");
		   while($sprow=$PDO->db_fetch_array($spQuery, PDO::FETCH_GROUP)){
			   $PDO->getSingleresult("select count(*) from #_leads ".$wrchart." and status='".$lSRs['pid']."'");
			$data='{"name": "Chrome", "y": 62.74},';
		   } */
		   $audatas='';
		    //$auQuery =$PDO->db_query("select au.name as sename,  count(*) as count from #_leads as ld JOIN pms_admin_users as au ON au.user_id=ld.salesecutiveid group by ld.salesecutiveid");
			$totalled =$PDO->getSingleresult("select count(*) from #_leads ".$wrchart." ");
			$auQuery =$PDO->db_query("select salesecutiveid, count(*) as count from #_leads ".$wrchart."  group by salesecutiveid");

		   while($aurow=$PDO->db_fetch_array($auQuery, PDO::FETCH_GROUP)){
			   if($aurow['salesecutiveid']==0){
				$auname='Not assigned';
			   }else{
			$auname=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$aurow['salesecutiveid']."'");
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
        text: 'Lead Allocation (Total <?=$totalled?>)'
    },
    subtitle: {
        text: 'Lead Allocation by Salesecutive'
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
      <div class="row justify-content-end">

            <div class="col-6">
              <div class="form-group">
                <div class="input-group">
                  <input type="text" name="paiddate" onChange="paidVSorg(this.value)" class="date form-control datetimepicker-input pl-2 pr-2"  placeholder="Date"/>
                  <div class="input-group-append">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
           <script>
            function paidVSorg(dates){
	data= {'pdate':dates}
$.ajax({
    type: "POST",
    url: "<?=SITE_PATH_ADM?>modules/leadsAjax.php",
    data: data,
    success: function(data) {
	$('#countrymana').html(data);
		},
    error: function() {
        alert('error handing here');

    }
});
	return false;}
            </script>
        <div class="card">
          <?php

			$paid=$PDO->getSingleresult("select count(*) from #_leads ".$wrchart." and DATE(created_on)='".date('Y-m-d')."' and source IN (select pid from #_lead_source where ltype='Paid') ");

			$organic=$PDO->getSingleresult("select count(*) from #_leads ".$wrchart." and DATE(created_on)='".date('Y-m-d')."' and source IN (select pid from #_lead_source where ltype='Organic') ");
		 $audatas='{"name": "Paid", "y": '.$paid.'},{"name": "Organic", "y": '.$organic.'}';
		   ?>

          <div id="countrymana" style="min-height:500px"></div>
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
Highcharts.chart('countrymana', {
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
        text: 'Paid v/s Organic'
    },
    subtitle: {
       // text: 'Lead Allocation by Salesecutive'
    },
    plotOptions: {
        series: {
            dataLabels: {
                enabled: true,
                format: '{point.name}: {point.y}'
            },
			showInLegend: true,

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

    </div>
  </div>

  <!-- /# row -->

  </div>
  </div>
</section>
<?php if($_SESSION["AMD"][3]!='5'){ ?>
<section class="mtb50">
  <div class="container">
    <div class="row">
    <div class="col-lg-6">
        <div class="card  align-items-stretch w-100">
          <div class="card-title">
            <h2>Total Team sales</h2>
          </div>
          <div class="">
            <table class="table table-bordered table-responsive-xs table-responsive-sm  table-striped custom-table">
              <thead>
                <tr>
                  <th>Date</th>
                <!--  <th>Received</th>
                  <th>Pending</th>-->
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
              <?php


			   $comma=',';
			$date2 = date('Y-m-d', strtotime('-8 days'));
			$end_date2 = date('Y-m-d');


			$a1=1;
	while (strtotime($date2) <= strtotime($end_date2)) {
$salesAmiount=$PDO->getSingleresult("select sum(serviceprice) from #_crequirement where DATE(created_on)='".$date2."'");

		$paidAmount=$PDO->getSingleresult("select sum(qAmount) from #_paymentdetails where dates='".$date2."' and dates>'2018-09-12'");
		if($salesAmiount>0){
			 ?>
	<tr>
                  <td><?=date('jS \ M y', strtotime($date2))?></td>

                 <!-- <td>Rs <?=$paidAmount==''?'0':$paidAmount;?></td>
                  <td>Rs <?=(int)$salesAmiount - (int)$paidAmount?></td>-->
                   <td>Rs <?=$salesAmiount==''?'0':$salesAmiount;?></td>
                </tr>
	<?php } $date2 = date ("Y-m-d", strtotime("+1 day", strtotime($date2))); } ?>


              </tbody>
            </table>
          </div>
        </div>
        <!-- /# card -->
      </div>

      <div class="col-lg-6">
        <div class="card  align-items-stretch w-100">
          <div class="row">
            <div class="col-sm-6">
              <div class="card-title">
                <h2>Team sales date wise</h2>
              </div>
            </div>
             <script>
            function getdatewisesale(dates){
	data= {'dates':dates}
$.ajax({
    type: "POST",
    url: "<?=SITE_PATH_ADM?>modules/leadsAjax.php",
    data: data,
    success: function(data) {
	$('#saledatewise').html(data);
		},
    error: function() {
        alert('error handing here');

    }
});
	return false;}
            </script>
            <div class="col-sm-6 mb5">
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="date form-control datetimepicker-input pl-2 pr-2" onChange="getdatewisesale(this.value)"  placeholder="Select Date"/>
                  <div class="input-group-append">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>
            </div>
          </div>


            <table class="table table-bordered table-responsive-xs table-responsive-sm  table-striped custom-table" id="saledatewise">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Total</th>
                 <!-- <th>Received</th>
                  <th>Pending</th>-->
                </tr>
              </thead>
              <tbody>
                 <?php
				 $date2 = date('Y-m-d');
				 $checkAmiount=$PDO->getSingleresult("select sum(serviceprice) from #_crequirement where DATE(created_on)='".$date2."'");
				 if($checkAmiount>0){

				 $totalAmount=0;

			$payry =$PDO->db_query("select * from pms_admin_users where status=1 and user_type=5");
	       while($payRs = $PDO->db_fetch_array($payry)){
		$salesAmiount=$PDO->getSingleresult("select sum(serviceprice) from #_crequirement where DATE(created_on)='".$date2."' and create_by='".$payRs['user_id']."'");
if($salesAmiount!=0){
$totalAmount +=$salesAmiount;

$stateDQuery=$PDO->db_query("select lid from #_crequirement where DATE(created_on)='".$date2."' and create_by='".$payRs['user_id']."'");
//print_r($pids);
 $stateDResult=$PDO->db_fetch_all($stateDQuery,PDO::FETCH_COLUMN);
if (!empty($stateDResult)) {
 $drIds = implode(',',$stateDResult);
 $staeRy="  pid IN ($drIds)";
}  else {
	$staeRy="   pid IN (0)";
}

 $pids['lid'];
		 ?>
	<tr>
                  <td>
				  <a href="#" data-toggle="modal" data-target="#salesr<?=$payRs['user_id']?>"><?=$payRs['name']?></a>

                  <div class="modal fade" id="salesr<?=$payRs['user_id']?>">
                      <div class="modal-dialog" style="max-width:80%; width:80%">
                        <div class="modal-content w-100 table-responsive">

                          <!-- Modal Header -->

                          <div class="modal-header">
                            <h4 class="modal-title">Sales Detail</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>

                          <!-- Modal body -->

                          <div class="modal-body table-responsive">
                            <table class="table table-bordered table-responsive-xs table-responsive-sm  table-striped custom-table">
                              <thead>
                                <tr>
                                  <th>Sl No</th>
                                  <th>Client Name </th>
                                  <th>Service</th>
                                  <th>Ticket no</th>
                                  <th>Total</th>
                                  <th>Recived</th>
                                  <th>Pending</th>
                                </tr>
                              </thead>
                              <tbody>
                              <?php $payleadsry =$PDO->db_query("select * from #_leads where  $staeRy");
							  $cc=1;
							  $total_price = 0;
							   $r_price = 0;
							   $noofinvoice = 0;
	       while($leadspayRs = $PDO->db_fetch_array($payleadsry)){

			 $invoiamount=$PDO->getSingleresult("select sum(serviceprice) from #_crequirement where create_by='".$payRs['user_id']."' and DATE(created_on)='".$date2."' and lid='".$leadspayRs['pid']."'");
		$recieAmount=$PDO->getSingleresult("select sum(qAmount) from #_paymentdetails where sentBy='".$payRs['user_id']."' and DATE(created_on)='".$date2."' and lid='".$leadspayRs['pid']."'");


			 $total_price += $invoiamount;
		   $r_price += $recieAmount;
			$noofinvoice += 1;
			    ?>
                                <tr>
                                  <td><?=$cc?> </td>
                                  <td><?=$leadspayRs['name']?></td>
                                   <td><?=$PDO->getSingleresult("select name from #_product_manager where pid='".$leadspayRs['service']."'")?></td>
                                  <td><?=$leadspayRs['rwi']?></td>
                                  <td>Rs <?=$invoiamount?></td>
                                  <td>Rs <?=$recieAmount?></td>
                                  <td>Rs <?=(int)$invoiamount - (int)$recieAmount?></td>
                                </tr>
                               <?php $cc++;} ?>
                              </tbody>
                            </table>
                          </div>

                          <!-- Modal footer -->

                          <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>

				  </td>
                  <td>Rs <?=$salesAmiount==''?'0':$salesAmiount;?></td>

                </tr>
	<?php }	} ?>



                <tr class="text-bold">
                  <td></td>
                 <td>Rs <?=$totalAmount==''?'0':$totalAmount;?></td>
                </tr>
                <?php } else {?>
				  <tr class="text-bold text-center">
                  <td colspan="2">No Record Found!</td>
                </tr>

					<?php } ?>
              </tbody>
            </table>

        </div>
        <!-- /# card -->
      </div>

    </div>
  </div>

  <!-- /# row -->

  </div>
  </div>
</section>
<?php } ?>
<section class="mtb50">
  <div class="container ">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12  col-lg-12">
        <div class="table-responsive">
          <div class="card-title">
            <h2> Todays Follow Ups </h2>
          </div>
          <div class="">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Sale Executive</th>
                  <th>TR Ticket</th>
                  <th>Customer Name</th>
                  <th>Customer Phone</th>
                  <th>Date/Time</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php

				 $date2 = date('Y-m-d');

				 $jj=1;

			$payry =$PDO->db_query("select * from #_pms_activity ".$folups." and status=2 and dates='".$date2."' and fstatus=0");

	       while($payRs = $PDO->db_fetch_array($payry)){

		 ?>
                <tr>
                  <td><?=$jj?></td>
                  <td><?=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$payRs['sentBy']."'");?></td>
                  <td><?=$PDO->getSingleresult("select rwi from #_leads where pid='".$payRs['lid']."'");?>
                  <td><?=$PDO->getSingleresult("select name from #_leads where pid='".$payRs['lid']."'");?></td>
                  <td><?=$PDO->getSingleresult("select phone from #_leads where pid='".$payRs['lid']."'");?></td>
                  <td><?=date('jS \ M y', strtotime($payRs['dates']))?>
                    <?=date('h:i', strtotime($payRs['times']))?></td>
                  <td><a href="<?=SITE_PATH_ADM.'index.php?comp=leads&mode=edit&followup='.$payRs['pid'].'&uid='.$PDO->getSingleresult("select pid from #_leads where pid='".$payRs['lid']."'")?>"  data-toggle="tooltip" title=""><i class="fa fa-edit"></i></a></td>
                </tr>
                <?php  $jj++;}

	 ?>
              </tbody>
            </table>
            <script>

	$(document).ready(function() {

    $('#example').DataTable({
    "bLengthChange": false,
    "bFilter": true,
    "bInfo": false,
    "bAutoWidth": false,
  "language": {
    "search": "Search"
  }
});

$('#example_filter label').before('<label class="ml-4">Search by Date<input type="text" class="form-control form-control-sm" placeholder="" id="followdate"></label>');
$('#followdate').datepicker( {dateFormat: 'yy-mm-dd',
  onSelect: function(dateText) {
    console.log("Selected date: " + dateText + "; input's current value: " + this.value);


	data= {'followdate':this.value}
$.ajax({
    type: "POST",
    url: "<?=SITE_PATH_ADM?>modules/leadsAjax.php",
    data: data,
    success: function(data) {
	console.log(data);
	$('#example').html(data);
		},
    error: function() {
        alert('error handing here');

    }
});
	return false;
  }
});


} );


	</script>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php if($_SESSION["AMD"][3]=='5'){ ?>

<section class="mtb50">
  <div class="container ">
    <div class="row">
      <!-- /# column -->
      <div class="col-sm-12">
        <div class="card">
          <div class="row mbt15">
            <div class="col-sm-8">
              <div class="card-title">
                <h2 class="">My Package wise sale for</h2>
              </div>
            </div>
            <div class="col-sm-4">
<div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control date pl-2 pr-2"  placeholder="Date" onChange="pkgsale(this.value)"/>
                  <div class="input-group-append">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>

 <script>

            function pkgsale(dates){
	data= {'saledate':dates}
$.ajax({
    type: "POST",
    url: "<?=SITE_PATH_ADM?>modules/leadsAjax.php",
    data: data,
    success: function(data) {
	$('#salescontent').html(data);
		},
    error: function() {
        alert('error handing here');

    }
});
	return false;}
            </script>

              </div>
          </div>


            <table class="table table-bordered table-responsive-xs table-responsive-sm  table-striped custom-table">
              <thead>
                <tr>
                  <th>Sl No</th>
                  <th>Package Name</th>
                  <th>Total</th>
                <!--  <th>Received</th>
                  <th>Pending</th>-->
                  <th>No of Package</th>
                </tr>
              </thead>
              <tbody id="salescontent">

                 <?php
		   $sry =$PDO->db_query("select * from #_product_manager where status=1");
		   $num=1;
	       while($sRs = $PDO->db_fetch_array($sry)){

		 $scnt2=$PDO->getSingleresult("select count(*) from #_leads  where service='".$sRs['pid']."' and salesecutiveid='".$_SESSION["AMD"][0]."' and DATE(created_on)>'2018-09-12'");
	 $sequotion=$PDO->getSingleresult("select sum(serviceprice) from #_crequirement where  create_by='".$_SESSION["AMD"][0]."' and serviceid='".$sRs['pid']."' and DATE(created_on)>'2018-09-12'");
		$serecievedAmount=$PDO->getSingleresult("select sum(qAmount) from #_paymentdetails where sentBy='".$_SESSION["AMD"][0]."' and serviceid='".$sRs['pid']."' and dates>'2018-09-12'");
		 if($scnt2!='' && $sequotion!=''){
				?>
				<tr>
                  <td><?=$num?> </td>
                  <td><?=$sRs['name']?></td>
                   <td>Rs <?=$sequotion==''?'0':$sequotion;?></td>
                <!--  <td>Rs <?=$serecievedAmount==''?'0':$serecievedAmount;?></td>
                  <td>Rs <?=(int)$sequotion - (int)$serecievedAmount?></td>-->
                  <td><?=$scnt2?></td>
                </tr>

				<?php
		  $num++; }}

		   ?>

              </tbody>
            </table>

        </div>
      </div>
    </div>
  </div>
</section>
<section class="mtb50">
  <div class="container ">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12  col-lg-12">
        <div class="table-responsive">
          <div class="card-title">
            <h2> Payment Pending </h2>
          </div>
          <table id="example2" class="table-bordered  table table-striped">
              <thead>
                <tr>
                  <th>Sl No</th>
                  <th>Client Name </th>
                  <th>Ticket no</th>
                  <th>Total</th>
                  <th>Recived</th>
                  <th>Pending</th>

                </tr>
              </thead>
              <tbody>
                <?php $payleadsry =$PDO->db_query("select * from #_leads where salesecutiveid='".$_SESSION["AMD"][0]."'");
							  $ccc=1;
	       while($leadspayRs = $PDO->db_fetch_array($payleadsry)){

			    $invoiamount1=$PDO->getSingleresult("select sum(serviceprice) from #_crequirement where create_by='".$_SESSION["AMD"][0]."' and lid='".$leadspayRs['pid']."'");
		$recieAmount1=$PDO->getSingleresult("select sum(qAmount) from #_paymentdetails where sentBy='".$_SESSION["AMD"][0]."' and lid='".$leadspayRs['pid']."'");
			 if( $invoiamount1>$recieAmount1) {
			    ?>
                <tr>
                    <td><?=$ccc?> </td>
                    <td><?=$leadspayRs['name']?></td>
                    <td><?=$leadspayRs['rwi']?></td>
                    <td>Rs <?=$invoiamount1?></td>
                    <td>Rs <?=$recieAmount1?></td>
                    <td>Rs <?=(int)$invoiamount1 - (int)$recieAmount1?></td>

                </tr>
                <?php $ccc++;}} ?>
              </tbody>
            </table>

            <script>

	$(document).ready(function() {

    $('#example2').DataTable({

    "bLengthChange": false,
    "bFilter": true,
    "bInfo": false,
    "bAutoWidth": false,
  "language": {
    "search": "Search"
  }
});

} );

	</script>

        </div>
      </div>
    </div>
  </div>
</section>
<section class="mtb50">
  <div class="container ">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="row">
            <div class="col-sm-12">
              <div class="card-title">
                <h2 class="text-right">Sales Report Month Wise</h2>
              </div>
            </div>
          </div>
            <table class="table table-bordered table-responsive-xs table-responsive-sm mt15  table-striped custom-table" id="monthwisesale2">
              <thead>
                <tr>

	<?php
	for ($i = 6; $i >= 0; $i--) {
		 $months=date("M-y", strtotime( date( 'Y-m-01' )." -$i months"));
		$datam=date('m-Y',strtotime($months));
		$Period = explode('-',$datam);

			    $salesAmiount=$PDO->getSingleresult("select sum(serviceprice) from #_crequirement where YEAR(created_on)='".$Period[1]."' and MONTH(created_on)='".$Period[0]."' and create_by='".$_SESSION["AMD"][0]."'");

			   $saleamount .=' <td> Rs '.($salesAmiount==''?'0':$salesAmiount).'</td>';

			   $totalquotion += $salesAmiount;
	 ?>
                  <th><?=date('F Y',strtotime($months))?></th>
                  <?php } ?>
                </tr>
              </thead>
              <tbody>
                <tr>
                <?=$saleamount?>
                </tr>
                <tr class="total-td">
                  <td colspan="5">&nbsp;</td>
                  <td class="text-right">Total</td>
                  <td>Rs  <?=$totalquotion?></td>
                </tr>
              </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
</section>
<?php


} else { ?>

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
			 $ssamount=$PDO->getSingleresult("select sum(serviceprice) from #_crequirement where create_by='".$pendingRs['user_id']."'");
		$rrrAmount=$PDO->getSingleresult("select sum(qAmount) from #_paymentdetails where sentBy='".$pendingRs['user_id']."' ");
		if(($ssamount-$rrrAmount)!=0){
			    ?>
                <tr>
                  <td><?=$sk?></td>
                  <td><a href="#" data-toggle="modal" data-target="#paymentpending<?=$pendingRs['user_id']?>"><?=$pendingRs['name']?></a>

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
                                  <th>Service</th>
                                  <th>Ticket no</th>
                                  <th>Total</th>
                                  <th>Recived</th>
                                  <th>Pending</th>
                                </tr>
                              </thead>
                              <tbody>
                              <?php $payleadsry =$PDO->db_query("select * from #_leads where salesecutiveid='".$pendingRs['user_id']."'");
							  $cc=1;
							  $total_price = 0;
							   $r_price = 0;
							   $noofinvoice = 0;
	       while($leadspayRs = $PDO->db_fetch_array($payleadsry)){

			 $invoiamount=$PDO->getSingleresult("select sum(serviceprice) from #_crequirement where create_by='".$pendingRs['user_id']."' and lid='".$leadspayRs['pid']."'");
		$recieAmount=$PDO->getSingleresult("select sum(qAmount) from #_paymentdetails where sentBy='".$pendingRs['user_id']."' and lid='".$leadspayRs['pid']."'");

			 if( $invoiamount>$recieAmount) {
			 $total_price += $invoiamount;
		   $r_price += $recieAmount;
			$noofinvoice += 1;
			    ?>
                                <tr>
                                  <td><?=$cc?> </td>
                                  <td><?=$leadspayRs['name']?></td>
                                   <td><?=$PDO->getSingleresult("select name from #_product_manager where pid='".$leadspayRs['service']."'")?></td>
                                  <td><?=$leadspayRs['rwi']?></td>
                                  <td>Rs <?=$invoiamount?></td>
                                  <td>Rs <?=$recieAmount?></td>
                                  <td>Rs <?=(int)$invoiamount - (int)$recieAmount?></td>
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
                  <td> <?=$noofinvoice?> </td>
                  <td>Rs  <?=(int)$total_price - (int)$r_price?></td>

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


<section class="mtb50">
  <div class="container ">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="row">
            <div class="col-sm-9">
              <div class="card-title">
                <h2 class="text-right">Sales report for month</h2>
              </div>
            </div>
            <script>
            function getmonthwisesale(months){
	data= {'months':months}
$.ajax({
    type: "POST",
    url: "<?=SITE_PATH_ADM?>modules/leadsAjax.php",
    data: data,
    success: function(data) {
	$('#monthwisesale').html(data);
		},
    error: function() {
        alert('error handing here');

    }
});
	return false;}
            </script>
            <div class="col-sm-3">
              <select class="form-control" onChange="getmonthwisesale(this.value);">
              <?php for ($i = 0; $i <= 12; $i++) {

				  $months=date("M-y", strtotime( date( 'Y-m-01' )." -$i months"));
	?>
	 <option value="<?=date('m-Y',strtotime($months))?>"><?=$months?></option>
	<?php
} ?>

              </select>
            </div>
          </div>
            <table class="table table-bordered table-responsive-xs table-responsive-sm mt15  table-striped custom-table" id="monthwisesale">
              <thead>
                <tr>
                <?php $monthilyry =$PDO->db_query("select * from pms_admin_users where status=1 and user_type=5 ".$adminqry."");
	       while($monthRs = $PDO->db_fetch_array($monthilyry)){

			    $quotion=$PDO->getSingleresult("select sum(serviceprice) from #_crequirement where YEAR(created_on)='".date('Y')."' and MONTH(created_on)='".date('m')."' and create_by='".$monthRs['user_id']."'");

			   $saleamount .=' <td> Rs '.($quotion==''?'0':$quotion).'</td>';

			   $totalquotion += $quotion;
	 ?>
                  <th><?=$monthRs['name']?></th>
                  <?php } ?>
                </tr>
              </thead>
              <tbody>
                <tr>
                <?=$saleamount?>
                </tr>
                <tr class="total-td">
                  <td colspan="<?=$monthilyry->rowCount()-2?>">&nbsp;</td>
                  <td class="text-right">Total</td>
                  <td>Rs  <?=$totalquotion?></td>
                </tr>
              </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="mt-5">
  <div class="container ">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="row">
            <div class="col-sm-9">
              <div class="card-title">
                <h2 class="text-right">Profit Statement Day wise</h2>
              </div>
            </div>

            <div class="col-sm-3">

                <div class="input-group">
                  <input type="text" class="form-control datetimepicker-input pl-2 pr-2" id="profitdates"  placeholder="Select Date"/>
                  <div class="input-group-append">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>

                </div>
              </div>
            </div>
          </div>
            <table class="table table-bordered table-responsive-xs table-responsive-sm mt15  table-striped custom-table" id="profitdaywise">
              <thead>
                <tr>
                <?php $monthilyry =$PDO->db_query("select * from pms_admin_users where status=1 and user_type=5 ".$adminqry."");
	       while($monthRs = $PDO->db_fetch_array($monthilyry)){
			   $quotion1=$PDO->getSingleresult("select sum(qAmount) from #_paymentdetails where YEAR(dates)='".date('Y')."' and MONTH(dates)='".date('m')."' and sentBy='".$monthRs['user_id']."'");
			   $saleamount2 .=' <td> Rs '.($quotion1==''?'0':$quotion1).'</td>';
			   $totalquotion2 += $quotion1;
	 ?>
                  <th><?=$monthRs['name']?></th>
                  <?php } ?>
                </tr>
              </thead>
              <tbody>
                <tr>
                <?=$saleamount2?>
                </tr>
                <tr class="total-td">
                  <td colspan="<?=$monthilyry->rowCount()-2?>">&nbsp;</td>
                  <td class="text-right">Total</td>
                  <td>Rs  <?=$totalquotion2?></td>
                </tr>
              </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
</section>
<?php } }?>
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