@extends('admin_master')
@section('active')
Thống Kê
@endsection
@section('dashboard_active')
active
@endsection
@section('content')
  <h3 style="text-align: center; "> Thống kê </h3> 
<!DOCTYPE html>
<html>
<head>
	 <script src="{{ asset('public/chart/Chart.min.js') }}"></script>       
    <link rel="icon" href="http://www.thuthuatweb.net/wp-content/themes/HostingSite/favicon.ico" type="image/x-ico"/>
</head>
<body>   
<!-- Thống kê số lượng gói thầu theo lĩnh vực -->
 <div align="center" style="margin:20px;">
 	 <canvas id="bieudo" width="500" height="200" style="display: block;"></canvas>
 	 <span style="text-align: center; color: red;	"  > <strong> Biểu đồ thống kê gói thầu theo lĩnh vực </strong></span>
 </div>

<!-- Thống kê số lượng người đăng ký theo thời gian -->
 <div align="center">
 	 <canvas id="buyers" width="500" height="200" style="display: block;" ></canvas>
 	 <span style="text-align: center; color: red;	"  > <strong> Biểu đồ thống kê số lượng người đăng ký theo tháng </strong></span>
 </div>

<!-- line chart canvas element -->

       <div> <canvas  id="buyers" width="500" height="200" ></canvas>  </br>
       			<strong> <span> Từ khóa</span> </strong>
       </div>

        <!-- pie chart canvas element -->
        <canvas id="countries" width="500" height="200"></canvas>
        <!-- bar chart canvas element -->
        <canvas id="income" width="500" height="200"></canvas>

         
           <canvas id="bieudotron" width="500" height="200"></canvas>  
 
    
</body>
</html>

	<?php $mang = array();
	  $tukhoa = array();
	 
	  $data = DB::table('keywords')->get();
	
	  foreach ($data as $value) {
	  	  array_push($tukhoa, $value->keyword);
	  }
	   for ($i = 0 ; $i <count($tukhoa) ; $i++)
	  {
	  	array_push($mang, $i);

	  }

	
	// Thống kê số lượng gói thầu
	
	  $data_linhvuc =  DB::table('category')->get();
	 $tenlinhvuc = array();
	 $count_linhvuc =array();
	 foreach ($data_linhvuc as $key => $value) {
	 	 array_push($tenlinhvuc, $value->cate_name);
	 	 $lv = App\Packages::where ('cate_id',$value->cate_id)->count();
	 	 array_push($count_linhvuc,$lv);
	 	}
	 	$dulieu = json_encode($count_linhvuc);
	 	echo $dulieu;
	?>
    
<script>

// Biểu đồ tròn


var data = {
    datasets: [{
        data: <?php echo $dulieu; ?> ,
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
        ],
         borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
        label: 'Biểu đồ thống kê các gói thầu theo lĩnh vực' // for legend
    }],
    labels: 
          <?php echo json_encode($tenlinhvuc); ?> 
    
};
 

	// get bar chart canvas
	var bieudo = document.getElementById("bieudo").getContext("2d");
	
	// draw bar chart
	new Chart(bieudo).Bar(data);


	// Thống kê số lượng người đăng ký 
	var buyerData = {
		labels :  [<?php for ($i=1;$i<=12;$i++) echo $i.","?>] ,
		datasets : [
		{
				fillColor : "rgba(172,194,132,0.4)",
				strokeColor : "#ACC26D",
				pointColor : "#fff",
				pointStrokeColor : "#9DB86D",
				data :[3,5,9,10,15,20],
			}
		]
	}
	
	// get line chart canvas
	var buyers = document.getElementById('buyers').getContext('2d');

	// draw line chart
	new Chart(buyers).Line(buyerData);
	

	// Biểu đồ tròn 
    // For a pie chart


	var data_bieudotron = {
    labels:  <?php echo json_encode($tenlinhvuc); ?> ,
    datasets: [
        {
            data:  [999,545,5454,323,313,44],
            backgroundColor: [
                "#FF6384",
                "#FF6384",
                "#FF6384",
                "#FF6384",
                "#36A2EB",
                "#FFCE56"
            ],
            hoverBackgroundColor: [
                "#FF6384",
                "#FF6384",
                "#FF6384",
                "#FF6384",
                "#36A2EB",
                "#FFCE56"
            ]
        }]
};

// get line chart canvas
	 var bieudotron = document.getElementById('bieudotron').getContext('2d');
	// draw line chart
	new Chart(bieudotron).Line(data_bieudotron);

	
</script>
@endsection