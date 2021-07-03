<?php
$provinsi_id = $_GET['prov_id'];
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://pro.rajaongkir.com/api/subdistrict?city=$provinsi_id",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "key:7b843ff1354c1b7fe1655236ba1faa05"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    //echo $response;
}

$data = json_decode($response, true);
for ($i = 0; $i < count($data['rajaongkir']['results']); $i++) {
    echo "<option value='" . $data['rajaongkir']['results'][$i]['subdistrict_id'] . "'>" . $data['rajaongkir']['results'][$i]['subdistrict_name'] . "</option>";
}
?>