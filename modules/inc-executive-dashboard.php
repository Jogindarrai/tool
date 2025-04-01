
<section class="mtb50">
  <div class="container ">
    
    <div class="row">
      <div class="col-sm-12 mb-3 text-center">
        <a href="<?=$ADMIN->iurl('leads')?>" class="btn btn-info">Manage My order</a>
        <a href="<?=$ADMIN->iurl('invoice')?>" class="btn btn-secondary">Manage My Invoice</a>

      </div>
      </div>
   <?php 
		   $sourcery =$PDO->db_query("select * from #_product_manager where status=1 and dpid=4"); 

		   $sourceearr=array();

	       while($sourceRs = $PDO->db_fetch_array($sourcery)){

				if($sourcery->rowCount()==$ii){

				$comm='';

				}     
 
		 $scnt2=$PDO->getSingleresult("select count(*) from #_leads where service='".$sourceRs['pid']."' and deid='".$_SESSION["AMD"][0]."' and deid='".$_SESSION["AMD"][0]."' and payment=1");

		 if($scnt2!=''){

	  $sodarr=array("name" =>$scnt2.' '.$sourceRs['name'],"y" =>$scnt2, "cnt"=>$scnt2);

				array_push($sourceearr,$sodarr);
				

		   }}

		  

		   ?>
  
    <div class="row">
      <div class="col-6 d-flex">
        <div class="card  align-items-stretch w-100">
        
          <div id="ServiceType"></div>
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
Highcharts.chart('ServiceType', {
	colors: ['#b81a01', '#1e406d', '#b99000', '#454545', '#34a853',
      '#ea4335', '#0000ff', '#ff0000', '#9900cc', '#099346', '#aaeeee'],
	
	
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
        name: 'Brands',
        colorByPoint: true,
        data:<?=json_encode($sourceearr)?>
		/*data: [{
            name: '5 Annual Compliance',
            y: 30
        }, {
            name: '6 LLP',
            y: 50,
            sliced: true,
            selected: true
        }, {
            name: '4 OPC',
            y: 20
        }, {
            name: '2 Private Ltd',
            y: 20
        

        
        }]*/
    }]
});


	

    
 </script> 
        </div>
        <!-- /# card --> 
      </div>
      
      <div class="col-6 d-flex ">
        <div class="card  align-items-stretch w-100">
        
         <?php 

		  $comm=',';

		  $ii=1;

		   $lSry =$PDO->db_query("select * from #_work_process where status=1 and deptId=4"); 

		   

	       while($lSRs = $PDO->db_fetch_array($lSry)){

			if($lSry->rowCount()==$ii){

				$comm='';

				}   

	 $cnt= $PDO->getSingleresult("select count(*) from #_leads where processStatus='".$lSRs['pid']."' and deid='".$_SESSION["AMD"][0]."' and payment=1");
	   $stages .= '['.'\''.$lSRs['name'].'\','.$cnt.']'.$comm;
		  $ii++;
		   }
		   ?>
          <div class="card-title">
            <h2 > My company Funnel</h2>
          </div>
          <div class="card-body">
            <div id="Funnel" style="height: 100%"></div>
            <script>	Highcharts.chart('Funnel', {
						
   colors: ['#b81a01', '#1e406d', '#b99000', '#454545', '#aaeeee',
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
<section class="ptb50 sectionbg">
  <div class="container">
    <div class="row ">
    
    <div class="col-sm-2  d-flex"><h2 class="line-height align-self-center">Company Formation </h2></div>
    
    <div class="col-sm-10">
    <?php    $compRy =$PDO->db_query("select * from #_product_manager where status=1 and dpid IN('4','7')"); 
	         $compRs = $PDO->db_fetch_all($compRy,PDO::FETCH_COLUMN);
			 $compRsAll=$compRs;
			 $complinaceArray=array(59,60,61,62,63,64,65,66,67,68,69);
			$compRs= array_diff($compRs,$complinaceArray);
			$complinaceArray=" 59,60,61,62,63,64,65,66,67,68,69";
			  $serviceids = implode(',',$compRs);
			  $compRsAll = implode(',',$compRsAll);
			
			 ?>
    
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-info ">
            <div class="">
              <h2 class="text-center"><?=$PDO->getSingleresult("select count(*) from #_leads where service IN($serviceids) and payment=1 and deid='".$_SESSION["AMD"][0]."' and processStatus=0");?> </h2>
            </div>
            <a class="card-footer align-self-center text-center text-white clearfix small z-1" href="#">
              <span >New Company</span>
           
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-secondary">
          <div class="">
              
              <h2 class="text-center"><?=$PDO->getSingleresult("select count(*) from #_leads where service IN($serviceids) and payment=1 and deid='".$_SESSION["AMD"][0]."' and processStatus IN('1','2')");?> </h2>
            </div>
            <a class="card-footer text-white align-self-center text-center clearfix small z-1" href="#">
              <span >Document Process</span>
           
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-success ">
           <div class="">
              
              <h2 class="text-center"><?=$PDO->getSingleresult("select count(*) from #_leads where service IN($serviceids) and payment=1 and deid='".$_SESSION["AMD"][0]."' and processStatus IN('3','4','5','6','7')");?> </h2>
            </div>
            <a class="card-footer text-white align-self-center text-center  clearfix small z-1" href="#">
              <span > Company  Upload</span>
           
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-dark ">
       <div class="">
              
              <h2 class="text-center"><?=$PDO->getSingleresult("select count(*) from #_leads where service IN($serviceids) and payment=1 and deid='".$_SESSION["AMD"][0]."' and processStatus=8");?> </h2>
            </div>
            <a class="card-footer text-white align-self-center text-center clearfix small z-1" href="#">
              <span> Company  Done</span>
           
            </a>
          </div>
        </div>
      </div>
    
    </div>
    
    
    
    
    </div>
    <hr>
    <div class="row">
    
    <div class="col-sm-2  d-flex"><h2 class="line-height align-self-center ">Annual Compliance

 </h2></div>
    
    <div class="col-sm-10">
    
    
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-info ">
            <div class="">
              <h2 class="text-center"><?=$PDO->getSingleresult("select count(*) from #_leads where service IN($complinaceArray) and payment=1  and deid='".$_SESSION["AMD"][0]."' and processStatus=0");?> </h2>
            </div>
            <a class="card-footer text-white clearfix align-self-center text-center small z-1" href="#">
              <span >New Company</span>
           
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-secondary ">
          <div class="">
              
              <h2 class="text-center"><?=$PDO->getSingleresult("select count(*) from #_leads where service IN($complinaceArray) and deid='".$_SESSION["AMD"][0]."' and payment=1 and processStatus IN('1','2')");?> </h2>
            </div>
            <a class="card-footer align-self-center text-center text-white clearfix small z-1" href="#">
              <span >Document Process</span>
           
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-success">
           <div class="">
              
              <h2 class="text-center"><?=$PDO->getSingleresult("select count(*) from #_leads where service IN($complinaceArray) and payment=1 and deid='".$_SESSION["AMD"][0]."' and processStatus IN('3','4','5','6','7')");?> </h2>
            </div>
            <a class="card-footer align-self-center text-center text-white clearfix small z-1" href="#">
              <span> Company  Upload</span>
           
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-dark ">
       <div class="">
              
              <h2 class="text-center"><?=$PDO->getSingleresult("select count(*) from #_leads where service IN($complinaceArray) and payment=1 and deid='".$_SESSION["AMD"][0]."' and processStatus=8");?> </h2>
            </div>
            <a class="card-footer text-white align-self-center text-center clearfix small z-1" href="#">
              <span > Company  Done</span>
           
            </a>
          </div>
        </div>
      </div>
    
    </div>
    </div>
    </div>
    </section>
<section class="mtb50">
  <div class="container">
    <div class="row bold">
      
    
      
      <div class="col-12 d-flex">
        <div class="card  w-100  align-items-stretch">
          <div class="panel panel-info">
            <div class="panel-body">
              <div class="row">
                <div class="col-sm-6">
                  <p class="product-name"><strong>My Total Company</strong></p>
                </div>
                <div class="col-sm-6">
                  <p class="pull-right"><strong><?=$PDO->getSingleresult("select count(*) from #_leads where service IN($serviceids) and deid='".$_SESSION["AMD"][0]."' and payment=1");?></strong></p>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <p class="product-name"><strong>My Annual Compliance</strong></p>
                </div>
                <div class="col-sm-6">
                  <p class="pull-right"><strong><?=$PDO->getSingleresult("select count(*) from #_leads where service IN($complinaceArray) and deid='".$_SESSION["AMD"][0]."' and payment=1");?></strong></p>
                </div>
              </div>
         
              
              <hr>
            </div>
            <div class="panel-footer">
              <div class="row pull-right">
                <div class="col-sm-12">
                  <h4 >Total <strong><?=$PDO->getSingleresult("select count(*) from #_leads where service IN($serviceids) and deid='".$_SESSION["AMD"][0]."' and payment=1")+$PDO->getSingleresult("select count(*) from #_leads where service IN($complinaceArray) and deid='".$_SESSION["AMD"][0]."' and payment=1")?></strong></h4>
                </div>
              </div>
            </div>
          </div>
          <a href="<?=$ADMIN->iurl('leads')?>" class="btn btn-secondary mt-3 ml-auto">Manage My  Order</a>
        </div>
        <!-- /# card --> 
      </div>
      
      
      
      
      
    </div>
  </div>
  </div>
  <!-- /# row -->
  </div>
  </div>
</section>
<section class="ptb50 sectionbg">
  <div class="container ">
  
  
  
  <div class="row bold">
      <div class="col-lg-6">
        <div class="card d-flex align-items-stretch">
          <div class="row">
            <div class="col-sm-6">
              <div class="card-title">
                <h2>Order of 5 days</h2>
              </div>
            </div>
            
          </div>
          <?php  $comma2=',';
			$date2 = date('Y-m-d', strtotime('-4 days'));

			$end_date2 = date('Y-m-d');

			$leadsarr2=array();
			
			$a2=1;

	while (strtotime($date2) <= strtotime($end_date2)) {

		if($a2==5){$comma2='';}

		

 // echo "select count(*) from #_leads where service IN($compRsAll) and date(paymentDate)='".$date2."'"; exit;           

$leadarr2=array( "name" => date('jS \ M y', strtotime($date2)),"y" =>$PDO->getSingleresult("select count(*) from #_leads where service IN($compRsAll) and deid='".$_SESSION["AMD"][0]."' and date(paymentDate)='".$date2."'"),"drilldown" =>date('jS \ M y', strtotime($date2)));
				array_push($leadsarr2,$leadarr2);
                $date2 = date ("Y-m-d", strtotime("+1 day", strtotime($date2)));

	$a++;}
		   ?>
          
          <div id="DailyLead" style="height: 100%"></div>
          <script type="text/javascript">

Highcharts.chart('DailyLead', {
	colors: ['#00293c', '#55BF3B', '#DF5353', '#7798BF', '#aaeeee',
      '#ff0066', '#eeaaee', '#55BF3B', '#DF5353', '#7798BF', '#aaeeee'],
	
	
	 chart: {
		 		        backgroundColor: '#fafafa',

        type: 'column'
    },
	  credits: {
      enabled: false
  },
	
    title: {
        text: ''
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Order of 5 days'
        }

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
            }
        }
    },

    tooltip: {
       
      //  pointFormat: '<span style="color:{point.color}"><b>{point.name}</b></span><br/>'
    },

    series: [{
        name: 'Order',
        colorByPoint: true,
        data:<?=json_encode($leadsarr2)?> /*[{
            name: '22 Mar',
            y: 100,
            drilldown: '22 Mar'
        }, {
            name: '23 Mar',
            y: 50,
            drilldown: '23 Mar'
        }, {
            name: '24 Mar',
            y: 70,
            drilldown: '24 Mar'
        },  {
            name: '25 March',
            y: 50,
            drilldown: '25 Mar'
        }, {
            name: '26 Mar',
            y: 60,
            drilldown: null
        }]*/
    }],

});
	
	
	
	
	
	
	



  
 </script> 
        </div>
        <!-- /# card --> 
      </div>
      <!-- /# column -->
      <div class="col-lg-6">
        <div class="card">
          <div class="card-title">
            <h2 >Escalation matrix</h2>
          </div>
          <div class="card-body ">
          
       <ol class="m-0 p-0">
       
       <li>----------------------</li>
       <li>----------------------</li>
       <li>----------------------</li>
       
       <li>----------------------</li>
       <li>----------------------</li>
       <li>----------------------</li>       
       <li>----------------------</li>
       <li>----------------------</li>
       <li>----------------------</li>
              
       <li>----------------------</li>
       <li>----------------------</li>
       <li>----------------------</li>       
       <li>----------------------</li>
       <li>----------------------</li>
       <li>----------------------</li>
              
 

       </ol>
           
          </div>
        </div>
      </div>
    </div>
  
  
  

  </div>
</section>

