<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
	<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>Raju Vitto</title>
		<script src="{{URL::to('/')}}/js/jq.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<link href="{{URL::to('/')}}/css/bootstrap.min.css" rel="stylesheet">
		<script src="{{URL::to('/')}}/js/JQuery.min.js"></script>
		
		<!-- <link rel="stylesheet" href="assets/css/bootstrap.css"> -->
	</head>
	<body>
		<br>
		<div class="container">
			<img src="http://researchcase-ppm.com/wp-content/uploads/2012/03/LOGO-JNE.png" style="width:100px" alt="logo">
			<br><br><br>
			<div class="row">
				<div class="col-md-4">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h3 class="panel-title">Cek Ongkos Kirim</h3>
						</div>
						<div class="panel-body">
								<div>
									<?php
									$curl = curl_init();
									curl_setopt_array($curl, array(
									//Get Data Kabupaten
										CURLOPT_URL => "http://api.rajaongkir.com/starter/city",
										CURLOPT_RETURNTRANSFER => true,
										CURLOPT_ENCODING => "",
										CURLOPT_MAXREDIRS => 10,
										CURLOPT_TIMEOUT => 30,
										CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
										CURLOPT_CUSTOMREQUEST => "GET",
										CURLOPT_HTTPHEADER => array(
											"key:66e5b864a02bd1c45f640483fe0cab74"
										),
									));

									$response = curl_exec($curl);
									$err = curl_error($curl);

									curl_close($curl);
									echo "
									<div class= \"form-group\">
									<label for=\"asal\">Kota/Kabupaten Asal </label>
									<select class=\"form-control\" name='asal' id='asal'>";
									echo "<option>Pilih Kota Asal</option>";
									$data = json_decode($response, true);
									for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
										echo "<option value='".$data['rajaongkir']['results'][$i]['city_id']."'>".$data['rajaongkir']['results'][$i]['city_name']."</option>";
									}
									echo "</select>
									</div>";
									//Get Data Kabupaten
									//-----------------------------------------------------------------------------

									//Get Data Provinsi
									$curl = curl_init();

									curl_setopt_array($curl, array(
										CURLOPT_URL => "http://api.rajaongkir.com/starter/province",
										CURLOPT_RETURNTRANSFER => true,
										CURLOPT_ENCODING => "",
										CURLOPT_MAXREDIRS => 10,
										CURLOPT_TIMEOUT => 30,
										CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
										CURLOPT_CUSTOMREQUEST => "GET",
										CURLOPT_HTTPHEADER => array(
										"key:66e5b864a02bd1c45f640483fe0cab74"
										),
										));

										$response = curl_exec($curl);
										$err = curl_error($curl);

										echo "
										<div class= \"form-group\">
											<label for=\"provinsi\">Provinsi Tujuan </label>
											<select class=\"form-control\" name='provinsi' id='provinsi'>";
												echo "<option>Pilih Provinsi Tujuan</option>";
												$data = json_decode($response, true);
												for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
													echo "<option value='".$data['rajaongkir']['results'][$i]['province_id']."'>".$data['rajaongkir']['results'][$i]['province']."</option>";
												}
												echo "</select>
											</div>";
											//Get Data Provinsi
											?>

											<div class="form-group">
												<label for="kabupaten">Kota/Kabupaten Tujuan</label><br>
												<select class="form-control" id="kabupaten" name="kabupaten"></select>
											</div>
											<div class="form-group">
												<label for="kurir">Kurir</label><br>
												<select class="form-control" id="kurir" name="kurir">
													<option value="jne">JNE</option>
													<option value="tiki">TIKI</option>
													<option value="pos">POS INDONESIA</option>
												</select>
											</div>
											<div class="form-group">
												<label for="berat">Berat (gram)</label><br>
												<input class="form-control" id="berat" type="text" name="berat" value="500" />
											</div>
											<button class="btn btn-success" id="cek" type="submit" name="button">Cek Ongkos Kirim</button>
										</div>
								</div>
							</div>
						</div>
						<div class="col-md-8">
							<div class="panel panel-success">
								<div class="panel-heading">
									<h3 class="panel-title">Hasil</h3>
								</div>
								<div class="panel-body">
									<ol>
										<div id="ongkir"></div>
									</div>
								</ol>
							</div>
						</div>
			</div>
			<footer>
				<div class="row">
					<div class="col-md-4">
						<p class="text-center">Copyright © 2018 <a href="#">Raju Vitto</a></p>
					</div>
				</div>

			</footer>
			</div>
		</div>
		<script src="{{URL::to('/')}}/js/JQuery.min.js"></script>
	</body>
</html>
<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
	$(document).ready(function(){
		$('#provinsi').change(function(){

			//Mengambil value dari option select provinsi kemudian parameternya dikirim menggunakan ajax
			var prov = $('#provinsi').val();

      		$.ajax({
            	type : 'GET',
           		url : 'http://localhost:8000/cek_kabupaten',
            	data :  'prov_id=' + prov,
					success: function (data) {

					//jika data berhasil didapatkan, tampilkan ke dalam option select kabupaten
					$("#kabupaten").html(data);
				}
          	});
		});

		$("#cek").click(function(){
			//Mengambil value dari option select provinsi asal, kabupaten, kurir, berat kemudian parameternya dikirim menggunakan ajax
			var asal = $('#asal').val();
			var kab = $('#kabupaten').val();
			var kurir = $('#kurir').val();
			var berat = $('#berat').val();

      		$.ajax({
            	type : 'POST',
           		url : 'http://localhost:8000/cek_ongkir',
            	data :  {'kab_id' : kab, 'kurir' : kurir, 'asal' : asal, 'berat' : berat},
					success: function (data) {

					//jika data berhasil didapatkan, tampilkan ke dalam element div ongkir
					$("#ongkir").html(data);
				}
          	});
		});
	});
</script>

<script>
$('#chosen_a').change(function(){
     //get the selected option's data-id value using jquery `.data()`
      var criteria_rate =  $(':selected',this).data('id'); 
     //populate the rate.
    $('.criteria_rate').val(criteria_rate);
});</script>

   <input id="title" name="criteria_rate" size="30" type="text" class="criteria_rate span2" value=""  readonly="readonly" />

 <select name="criteria_title" id="chosen_a" data-placeholder="Select Category" class="chzn_z span3 dropDownId chzn-done" style="display: none;">
        <option value=""></option>
        <option value="1" data-id="10">a</option>
        <option value="2" data-id="20">b</option>
        <option value="3" data-id="30">c</option>
        <option value="4" data-id="40">d</option>
        <option value="5" data-id="50">e</option>
   </select>
