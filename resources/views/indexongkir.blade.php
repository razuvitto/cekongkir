<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Raju Vitto</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link href="{{URL::to('/')}}/css/bootstrap.min.css" rel="stylesheet">
        <script src="{{URL::to('/')}}/js/JQuery.min.js"></script>
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		<!-- <link rel="stylesheet" href="assets/css/bootstrap.css"> -->
	</head>
	<body>
<?php
    $api_key = "66e5b864a02bd1c45f640483fe0cab74";
    
    function get_city($key){
        $data = [
            'status' => false,
            'result' => []
        ]; 
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.rajaongkir.com/starter/city",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "key: ".$key
          ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            $data['result'] = $err;
        } else {
            $result = json_decode($response, true);
            if ($result['rajaongkir']['status']['code'] == 200){
                $data['status'] = true;
                $data['result'] = $result['rajaongkir']['results'];
            } else {
                $data['result'] = $result['rajaongkir']['status']['description'];
            }
        }
        return $data;
    }

    function hitung_ongkir($kota_asal, $kota_tujuan, $kurir, $berat, $key){
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => "origin=".$kota_asal."&destination=".$kota_tujuan."&weight=".$berat."&courier=".$kurir,
          CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
            "key: ".$key
          ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            $data['result'] = $err;
        } else {
            $result = json_decode($response, true);
            if ($result['rajaongkir']['status']['code'] == 200){
                $data['status'] = true;
                $data['result'] = $result['rajaongkir']['results'][0];
            } else {
                $data['result'] = $result['rajaongkir']['status']['description'];
            }
        }
        return $data;
    }

    //ambil data kota
    $city = [];
    $check = get_city($api_key);
    if ($check['status']){
        $city = $check['result'];
?>        
        <form method="GET">
            Kota Asal Pengiriman<br/>
            <select name="kota_asal">
                <?php
                    foreach ($city as $item):
                        echo "<option value='".$item['city_id']."'>".$item['type']." ".$item['city_name']."</option>";
                    endforeach;
                ?>
            </select>
            <br/><br/>
            Kota Tujuan Pengiriman<br/>
            <select name="kota_tujuan">
                <?php
                    foreach ($city as $item):
                        echo "<option value='".$item['city_id']."'>".$item['type']." ".$item['city_name']."</option>";
                    endforeach;
                ?>
            </select>
            <br/><br/>
            Kurir<br/>
            <select name="kurir">
                <option value="jne">JNE</option>
                <option value="pos">POS Indonesia</option>
                <option value="tiki">TIKI</option>
            </select>
            <br/><br/>
            Berat<br/>
            <input type=text name="berat" value=500> gram
            <br/><br/>
            <button type="submit">CEK Ongkir</button>
        </form>
<?php      
        if (isset($_GET['kota_asal'])){
            $kota_asal = $_GET['kota_asal'];
            $kota_tujuan = $_GET['kota_tujuan'];
            $kurir = $_GET['kurir'];
            $berat = $_GET['berat'];
            $ongkir = hitung_ongkir($kota_asal,$kota_tujuan,$kurir,$berat,$api_key);
            echo "<pre>";
            print_r($ongkir['result']);
            $strFromArr = serialize($ongkir['result']);
            echo $strFromArr;
            echo "</pre>";
            
        }

    } else {
        echo $check['result'];
    }
?>




<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Raju Vitto</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link href="{{URL::to('/')}}/css/bootstrap.min.css" rel="stylesheet">
        <script src="{{URL::to('/')}}/js/JQuery.min.js"></script>
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
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
									//Get Data Kabupaten
									$curl = curl_init();
									curl_setopt_array($curl, array(
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
											<button class="btn btn-success" id="cek" type="submit" name="button">Cek Ongkir</button>
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
	</body>
</html>
<script type="text/javascript">

	$(document).ready(function(){
		$('#provinsi').change(function(){

			//Mengambil value dari option select provinsi kemudian parameternya dikirim menggunakan ajax
			var prov = $('#provinsi').val();

      		$.ajax({
            	type : 'GET',
           		url : 'http://localhost:81/rajaongkir/cek_kabupaten.php',
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
           		url : 'http://localhost:81/rajaongkir/cek_ongkir.php',
            	data :  {'kab_id' : kab, 'kurir' : kurir, 'asal' : asal, 'berat' : berat},
					success: function (data) {

					//jika data berhasil didapatkan, tampilkan ke dalam element div ongkir
					$("#ongkir").html(data);
				}
          	});
		});
	});
</script>







								
					
