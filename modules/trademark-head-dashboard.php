<?php if(isset($_POST['stask'])){
	
	           $_POST['senderid']=$_SESSION["AMD"][0];
				 $PDO->sqlquery("rs",'task',$_POST);
				$ADMIN->sessset('Task has been assigned', 's');
				$RW->redir(SITE_PATH, true);
				 }	
				  if(($_SESSION["AMD"][3]==1 || $_SESSION["AMD"][3]==6)){
		$adminaccess='&department=5';
		 } 
				  ?>
<section class="ptb50 sectionbg">
  <div class="container">
  <?=$ADMIN->alert();?>
  <div class="row">
      <div class="col-sm-12 mb-3 text-center">
        <a href="<?=$ADMIN->iurl('leads').$adminaccess?>" class="btn btn-info">Manage My order</a>
        <a href="<?=$ADMIN->iurl('invoice')?>" class="btn btn-secondary">Manage My Invoice</a>

      </div>
      </div>
    <div class="row">
      <?php    $compRy =$PDO->db_query("select * from #_product_manager where status=1 and dpid=5"); 
	         $compRs = $PDO->db_fetch_all($compRy,PDO::FETCH_COLUMN);
			  $serviceids = implode(',',$compRs);
			 ?>
    <div class="col">
        <div class="info-box"> <span class="info-box-icon bg-green"><i class="ion ion-ios-gear-outline"></i></span>
          <div class="info-box-content ">
           <a href="<?=$ADMIN->iurl('leads')?>&work_process=17<?=$adminaccess?>">
           <span class="info-box-number"><?=$PDO->getSingleresult("select count(*) from #_leads where service IN($serviceids) and payment=1 and processStatus=17");?></span> <span class="info-box-text">New</span></a> </div>
          <!-- /.info-box-content --> 
        </div>
        <!-- /.info-box --> 
      </div>
      <div class="col">
        <div class="info-box"> <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
          <div class="info-box-content ">
           <a href="<?=$ADMIN->iurl('leads')?>&work_process=9<?=$adminaccess?>">
           <span class="info-box-number"><?=$PDO->getSingleresult("select count(*) from #_leads where service IN($serviceids) and payment=1 and processStatus=9");?></span> <span class="info-box-text">Basic Info</span></a> </div>
          <!-- /.info-box-content --> 
        </div>
        <!-- /.info-box --> 
      </div>
      <!-- /.col -->
      <div class="col">
        <div class="info-box"> <span class="info-box-icon bg-red"> </span>
          <div class="info-box-content">
           <a href="<?=$ADMIN->iurl('leads')?>&work_process=10<?=$adminaccess?>">
           <span class="info-box-number"><?=$PDO->getSingleresult("select count(*) from #_leads where service IN($serviceids) and payment=1 and processStatus=10");?></span> <span class="info-box-text">Application Drafted</span> </a></div>
          <!-- /.info-box-content --> 
        </div>
        <!-- /.info-box --> 
      </div>
      <!-- /.col --> 
      
      <!-- fix for small devices only -->
      <div class="clearfix visible-sm-block"></div>
      <div class="col">
        <div class="info-box"> <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
          <div class="info-box-content">
           <a href="<?=$ADMIN->iurl('leads')?>&work_process=11<?=$adminaccess?>">
           <span class="info-box-number"><?=$PDO->getSingleresult("select count(*) from #_leads where service IN($serviceids) and payment=1 and processStatus=11");?></span> <span class="info-box-text">Approval on Draft</span></a> </div>
          <!-- /.info-box-content --> 
        </div>
        <!-- /.info-box --> 
      </div>
      <!-- /.col -->
      <div class="col">
        <div class="info-box"> <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
          <div class="info-box-content"> 
           <a href="<?=$ADMIN->iurl('leads')?>&work_process=12<?=$adminaccess?>">
          <span class="info-box-number"><?=$PDO->getSingleresult("select count(*) from #_leads where service IN($serviceids) and payment=1 and processStatus=12");?></span> <span class="info-box-text">Application Submitted</span> </a></div>
          <!-- /.info-box-content --> 
        </div>
        <!-- /.info-box --> 
      </div>
      <!-- /.col --> 
    </div>
  </div>
</section>
<section class="mtb50">
  <div class="container ">
    <div class="row">
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
$leadarr2=array( "name" => date('jS \ M y', strtotime($date2)),"y" =>$PDO->getSingleresult("select count(*) from #_leads where service IN($serviceids) and date(paymentDate)='".$date2."'"),"drilldown" =>date('jS \ M y', strtotime($date2)));
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
        data:<?=json_encode($leadsarr2)?> 
    }],

});
 </script> 
        </div>
        <!-- /# card --> 
      </div>
        <?php 
		   $sourcery =$PDO->db_query("select * from #_product_manager where status=1 and dpid=5"); 

		   $sourceearr=array();

	       while($sourceRs = $PDO->db_fetch_array($sourcery)){

				if($sourcery->rowCount()==$ii){

				$comm='';

				}     
 
		 $scnt2=$PDO->getSingleresult("select count(*) from #_leads where service='".$sourceRs['pid']."' and payment=1");

		 if($scnt2!=''){

	  $sodarr=array("name" =>$scnt2.' '.$sourceRs['name'],"y" =>$scnt2, "cnt"=>$scnt2);

				array_push($sourceearr,$sodarr);
				

		   }}
		   ?>
  
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
    </div>
  </div>
</section>

<section class="mtb50">
  <div class="container">
    <div class="row">
      <div class="col   d-flex">
        <div class="card align-items-stretch w-100">
          <div class="card-title">
            <h2> My Task
            <a href="javascript:void(0)" class="pull-right btn btn-sm btn-rounded btn-success " title="Add New Task" data-toggle="modal" data-target="#add-new-task">Add Task</a>
            
            </h2>
          </div>
          <hr class="m-0 p-0">
          <div class="card-body"> 
            
            <!-- ============================================================== --> 
            <!-- To do list widgets --> 
            <!-- ============================================================== -->
            <div class="to-do-widget m-t-20"> 
              <!-- .modal for add task -->
              <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Add Task</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                    </div>
                    <div class="modal-body">
                      <form>
                      
                      
                      
                      
                      <div class="form-group">
                  <div class='input-group date' id='datetimepicker1'>
                      <input type='text' class="form-control" />
                      <span class="input-group-addon">
                          <span class="fa fa-calendar"></span>
                      </span>
                  </div>
              </div>
                      
                      <script>$(function () {
  $('#datetimepicker1').datetimepicker();
});</script>
                      
                      
                      
                      
                      
                      
                      
                        <div class="form-group">
                          <label>Task name</label>
                          <input type="text" class="form-control" placeholder="Enter Task Name">
                        </div>
                        <div class="form-group">
                          <label>Assign to</label>
                          <select class="custom-select form-control pull-right">
                            <option selected="">Sachin</option>
                            <option value="1">Sehwag</option>
                            <option value="2">Pritam</option>
                            <option value="3">Alia</option>
                            <option value="4">Varun</option>
                          </select>
                        </div>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-success" data-dismiss="modal">Submit</button>
                    </div>
                  </div>
                  <!-- /.modal-content --> 
                </div>
                <!-- /.modal-dialog --> 
              </div>
              <!-- /.modal -->
              <div class="w-100 filter-none">
                              <table id="example3" class="table table-striped table-bordered  " style="width:100%">
                                <thead>
                                  <tr>
                                    <th>Sl No </th>
                                    <th>Name of the work</th>
                                    <th>Allocated by</th>
                                    <th>Deadline </th>
                                    <th>Reply </th>
                                    <th>Action </th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
								 $nn=1;
								 
								
             $task_query = $PDO->db_query("select * from #_task where reciverid='".$_SESSION["AMD"][0]."' and status=0 order by pid DESC");
				while($task_rows = $PDO->db_fetch_array($task_query)){
					if($task_rows['dstatus']==0 && $task_rows['senderid']!=$_SESSION["AMD"][0] && $task_rows['rstatus']!=''){
						 $css='style="font-weight: bold"';
						}
					 ?>
                                  <tr>
                                    <td <?=$css?>><?=$nn?></td>
                                    <td <?=$css?>><?=$task_rows['name']?></td>
                                    <td <?=$css?>><?=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$task_rows['senderid']."'");?></td>
                                    <td <?=$css?>><?=$task_rows['deadLine']?></td>
                                    <td <?=$css?>><?=$task_rows['comments']?></td>
                                    <th><a href="javascript:void(0)" onclick="reply('<?=$task_rows['pid']?>');"> <?=($task_rows['reciverid']==$_SESSION["AMD"][0] && $task_rows['status']!=1)?'<i class="fa fa-reply"></i>':'<i class="fa fa-eye"></i>'?></a> </th>
                                  </tr>
                                    
                                  <?php $nn++;} ?>
                              </table>
                              <script>
   $(document).ready(function() {
    $('#example3').DataTable( {
        "lengthMenu": [[8,10, 25, 50, -1], [8,10, 25, 50, "All"]]
    } );
} );
   </script> 
                            </div>
                              <form name="ar" action="#" method="post" enctype="multipart/form-data">                 <!-- Reply   Modal -->
                      <div class="modal fade" id="allreply">
                      
                       </div>   
                       </form>
            </div>
          </div>
        </div>
      </div>
      <div class="col ">
        <div class="card text-white bg-info   w-100">
          <div class="">
            <h2 class="text-center"><?=$PDO->getSingleresult("select count(*) from #_leads where service IN($serviceids) and payment=1 and deid=0");?> </h2>
          </div>
          <a class="card-footer text-white clearfix small z-1 text-center " href="<?=$ADMIN->iurl('leads').$adminaccess?>&work_process=17"> <span>New Ticket for allocation</span> </a> </div>
        
        <!-- /# card --> 
      </div>
    </div>
  </div>
</section>
<div class="modal fade" id="add-new-task">
                  <div class="modal-dialog modal-md">
                    <form name="pp" method="post" action="#" enctype="multipart/form-data">
                      <div class="modal-content"> 
                        
                        <!-- Modal Header -->
                        <div class="modal-header">
                          <h4 class="modal-title m-0 p-0">Add New Task</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        
                        <!-- Modal body -->
                        <div class="modal-body">
                          <div class="">
                            <div class="row">
                              <div class="col-12 col-md-12">
                                <div class="form-group">
                                  <label>Name</label>
                                  <input type="text" name="name" class="validate[required] form-control " value=""/>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-12 col-md-12">
                                <div class="form-group">
                                  <label for="">Deadline</label>
                                  <div class="input-group">
                                    <input type="text" class="validate[required] form-control"  name="deadLine" >
                                    <div class="input-group-append">
                                      <button type="button" class="input-group-text cursor-pointer" data-toggle="datepicker" data-target-name="deadLine" ><i class="fa fa-calendar"></i></button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-12 col-md-12">
                                <div class="form-group">
                                  <label for="">Assign to</label>
                                  <select class="validate[required] form-control" name="reciverid">
                                    <option>--Select One--</option>
                                    <?php
             $sexecutive_query = $PDO->db_query("select * from pms_admin_users where  status='1'");
				while($sexecutive_rows = $PDO->db_fetch_array($sexecutive_query)){ ?>
                                    <option value="<?=$sexecutive_rows['user_id']?>" <?=($sexecutive_rows['user_id']==$salesecutiveid)?'selected="selected"':''?>  >
                                    <?=$sexecutive_rows['name']?>
                                    </option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-12 col-md-12">
                                <div class="form-group">
                                  <label for="">Description</label>
                                  <textarea class="form-control" name="comments"> </textarea>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" name="stask" class="btn btn-primary">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
<script>
 $('[data-toggle=datepicker]').each(function() {
  var target = $(this).data('target-name');
  var t = $('input[name=' + target + ']');
  t.datepicker({
    dateFormat: 'dd-mm-yy',
	changeMonth: true,
    changeYear: true ,
	  //  yearRange: "2005:2015"
	  yearRange: "-100:+0", // last hundred years
  });
  $(this).on("click", function() {
    t.datepicker("show");
  });
});
function reply(taskid){
	data= {'taskid':taskid}
$.ajax({
    type: "POST",
    url: "<?=SITE_PATH_ADM?>modules/leadsAjax.php",
    data: data,
    success: function(data) {
	console.log(data);	
	$('#allreply').html(data);
	$('#allreply').modal('show');
		},
    error: function() {
        alert('error handing here');

    }
});
	return false;}
</script>