<?php
  ob_start();
  session_start();
  require_once 'dbconnect.php';
  

?><!DOCTYPE html>
<h5 style="text-align:center"><strong>Pemanfaatan Google Maps API</strong><br>
Tim : <br>
1. Rizka Fitriani Hadi (16.01.63.0003)<br>
2. Agnes Oka Rosalin (16.01.63.0020)<br>
3. Rezky Febriani (16.01.63.0022)</br>
4. Andi Dwi Susilo (16.01.63.0012)</h5>
<hr>
<html>
    <head>
        <head>
<title>API Google Maps</title>
<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--bootstrap-->
	<link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!--javascript-->
	<script src="assets/jquery/jquery-3.1.1.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<!-- Custom JS -->
	<script src="assets/custom.js"></script>

    <title>Wisata Jawa Tengah</title>   
    </head>
    <body class="fixed-left">
        <!-- Modal Start -->
      
	<!-- Begin page -->
    <!-- Right Sidebar End -->  	
		<!-- Start right content -->
				<div class="row">
				
					<div class="col-md-12">
						<div class="widget">
							<div class="widget-header">
								<h2><strong>Wisata</strong> Jawa Tengah</h2>
								<div class="additional-btn">
									<a href="#" class="hidden reload"><i class="icon-ccw-1"></i></a>
									<a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
									<a href="#" class="widget-close"><i class="icon-cancel-3"></i></a>
								</div>
							</div>
							<div class="widget-content">
							<br>					
								<div class="table-responsive">
									<form class='form-horizontal' role='form'>
									<table id="datatables-1" class="table table-striped table-bordered" cellspacing="0" width="100%">
									        <thead>
									            <tr>
									                <th>No</th>
									                <th>Nama Objek</th>
									                <th>Alamat</th>
									                <th>Kota</th>
									                <th>Kecamatan</th>
									                <th>Latitude</th>
									                <th>Longitude</th>
                                                   
                                                   
									            </tr>
									        </thead>
									 
									        
									 
									        <tbody>

                                             <?php 

include "koneksi.php";



 $sql = "SELECT * FROM wisata "; 

 



  $result = mysqli_query($conn, $sql);



    // output data of each row

  $x = 1;

    while($row = mysqli_fetch_assoc($result)) {

        $id = $row["id"];

        $nama = $row["nama_wisata"];

    

       ?>
<?php 
$address = urlencode($nama);

$request = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=" . $address . "&sensor=false");
$json = json_decode($request, true);



$data = array();
 foreach($json['results']['0']['address_components'] as $element){
     $data[implode(' ',$element['types']) ] = $element['long_name'];
 }
 //print_r($data);

 $lat = $json['results'][0]['geometry']['location']['lat'];
$long = $json['results'][0]['geometry']['location']['lng'];
 $kota = $data['administrative_area_level_2 political'];
 $kec = $data['administrative_area_level_3 political'];

?>
<tr>
<td>
	<?php echo $x; ?>
</td>
<td>
	<?php echo $nama; ?>
</td>
<td>
	<?php echo $json['results'][0]['formatted_address']; ?>
</td>
<td>
	<?php echo $kota; ?>
</td>
<td>
	<?php echo $kec; ?>
</td>
<td>
	<?php echo $lat; ?>
</td>
<td>
	<?php echo $long; ?>
</td>
</tr>
<?php $x++; } ?>
									          
									        </tbody>
									    </table>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>



				  	<div class="row">
				
					<div class="col-md-12">
						<div class="widget">
							<div class="widget-header">
								<h2><strong>PETA WISATA</strong></h2>
								<div class="additional-btn">
									<a href="#" class="hidden reload"><i class="icon-ccw-1"></i></a>
									<a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
									<a href="#" class="widget-close"><i class="icon-cancel-3"></i></a>
								</div>
							</div>
							<div class="widget-content">

<div id="map" style="width: 100%; height: 450px;"></div>

  <script type="text/javascript">
    var locations = [
     <?php 

include "koneksi.php";



 $sql2 = "SELECT * FROM wisata "; 

 



  $result2 = mysqli_query($conn, $sql2);



    // output data of each row

  $x2 = 1;

    while($row = mysqli_fetch_assoc($result2)) {

        $id = $row["id"];

        $nama = $row["nama_wisata"];

    

       ?>
<?php 
$address = urlencode($nama);

$request = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=" . $address . "&sensor=false");
$json = json_decode($request, true);



$data = array();
 foreach($json['results']['0']['address_components'] as $element){
     $data[ implode(' ',$element['types']) ] = $element['long_name'];
 }
 //print_r($data);

 $lat = $json['results'][0]['geometry']['location']['lat'];
$long = $json['results'][0]['geometry']['location']['lng'];
 $kota = $data['administrative_area_level_2 political'];
 $kec = $data['administrative_area_level_3 political'];
 $alamat = $json['results'][0]['formatted_address'];

?>

      ['<?php echo $nama; ?>', <?php echo $lat; ?>, <?php echo $long; ?>, '<?php echo $id; ?>', '<?php echo $alamat; ?>'],
      <?php $x2++; } ?>
     
    ];

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 8,
      center: new google.maps.LatLng(-7.017230353978647,110.41534428019077),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });



 




     google.maps.event.addListener(marker, 'click', (function(marker, i) {
       return function() {
          infowindow = new google.maps.InfoWindow({
                                content: locations[i][0]+'<br/>'+locations[i][4]+'<br/>'
                            });
          infowindow.open(map, marker);
        }
     })(marker, i));
    }
  </script>
							</div>
							</div>
							</div>
							</div>
<form action="" method="post">
<input id="pac-input" class="controls" type="text" placeholder="Cari Lokasi..." style="position: absolute; width: 200%; height: 50px">
			
<!--email-->
<script src=https://maps.googleapis.com/maps/api/js?key=AIzaSyDvnP6-IQADuP461VqlXqYjdm6sWlkhVWs&sensor=true></script>
<style>
    html, body {
          height: 100%;
          margin: 0;
          padding: 0;
      }
      #map-canvas {
          height: 70%;
          width: 100%;
      }

</style>



<div id="map" style="width: 100%; height: 450px;"></div>

  <script type="text/javascript">
    var locations = [
     <?php 

include "koneksi.php";



 $sql2 = "SELECT * FROM wisata "; 

 



  $result2 = mysqli_query($conn, $sql2);



    // output data of each row

  $x2 = 1;

    while($row = mysqli_fetch_assoc($result2)) {

        $id = $row["id"];

        $nama = $row["nama_wisata"];

    

       ?>
<?php 
$address = urlencode($nama);

$request = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=" . $address . "&sensor=false");
$json = json_decode($request, true);



$data = array();
 foreach($json['results']['0']['address_components'] as $element){
     $data[ implode(' ',$element['types']) ] = $element['long_name'];
 }
 //print_r($data);

 $lat = $json['results'][0]['geometry']['location']['lat'];
$long = $json['results'][0]['geometry']['location']['lng'];
 $kota = $data['administrative_area_level_2 political'];
 $kec = $data['administrative_area_level_3 political'];
 $alamat = $json['results'][0]['formatted_address'];

?>

      ['<?php echo $nama; ?>', <?php echo $lat; ?>, <?php echo $long; ?>, '<?php echo $id; ?>', '<?php echo $alamat; ?>'],
      <?php $x2++; } ?>
     
    ];

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 8,
      center: new google.maps.LatLng(-7.017230353978647,110.41534428019077),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });



 




     google.maps.event.addListener(marker, 'click', (function(marker, i) {
       return function() {
          infowindow = new google.maps.InfoWindow({
                                content: locations[i][0]+'<br/>'+locations[i][4]+'<br/>'
                            });
          infowindow.open(map, marker);
        }
     })(marker, i));
    }
  </script>			
				            <!-- Footer Start -->
        
            <!-- Footer End -->			
            </div>
			<!-- ============================================================== -->
			<!-- End content here -->
			<!-- ============================================================== -->

        </div>
		<!-- End right content -->

	</div>
	<!-- End of page -->
		<!-- the overlay modal element -->
	<div class="md-overlay"></div>
	<!-- End of eoverlay modal -->
	<script>
		var resizefunc = [];
	</script>
	

	</body>
</html>
 <?php ob_end_flush(); ?> 