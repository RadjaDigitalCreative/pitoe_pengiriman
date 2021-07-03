<?php

$asal = $_POST['dari'];
$id_kabupaten = $_POST['kab_id'];
$kurir = $_POST['kurir'];
$hasil = $_POST['hasil'];
$berat = $_POST['weight'];


$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://pro.rajaongkir.com/api/cost",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "origin=" . $asal . "&originType=city&destination=" . $id_kabupaten . "&destinationType=subdistrict&weight=" . $berat . "&courier=" . $kurir . "",
    CURLOPT_HTTPHEADER => array(
        "content-type: application/x-www-form-urlencoded",
        "key:7b843ff1354c1b7fe1655236ba1faa05"
    ),
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
if ($err) {
    echo "cURL Error #:" . $err;
} else {
    $data = json_decode($response, true);
}
?>
<?php
for ($k = 0; $k < count($data['rajaongkir']['results']); $k++) {
?>
<hr>
<div title="<?php echo strtoupper($data['rajaongkir']['results'][$k]['name']);?>" style="padding:15px">
    <table class="table" >
        <tr>
            <th>Jenis Layanan</th>
            <th>ETD</th>
            <th>Tarif</th>
            <th>Pilih</th>
        </tr>
        <?php

        for ($l = 0; $l < count($data['rajaongkir']['results'][$k]['costs']); $l++) {
        ?>
        <tr>
            <td>
                <div><?php echo $data['rajaongkir']['results'][$k]['costs'][$l]['service'];?></div>
                <div><?php echo $data['rajaongkir']['results'][$k]['costs'][$l]['description'];?></div>
            </td>
            <td align="center">&nbsp;<?php echo $data['rajaongkir']['results'][$k]['costs'][$l]['cost'][0]['etd'];?>
            </td>
            <td align="right"><?php echo number_format($data['rajaongkir']['results'][$k]['costs'][$l]['cost'][0]['value']);?></td>
            <td>

                <div class="radio">
                    <label><input type="radio"
                                  tarif="<?php echo $data['rajaongkir']['results'][$k]['costs'][$l]['cost'][0]['value']; ?>"
                                  name="pilih_ongkir" class="pilih_ongkir"></label>
                </div>
            </td>
        </tr>
        <?php
        }
        ?>
    </table>
</div>
<?php
}echo $id_kabupaten;
?>
<script type="text/javascript">
    $('.pilih_ongkir').on('click', function () {

        var tarif = parseInt($(this).attr("tarif"));
        var hasil2  = "<?php echo $hasil; ?>";
        var hasil3 = parseInt(tarif) + parseInt(hasil2);

        var	number_string = hasil3.toString(),
            split	= number_string.split(','),
            sisa 	= split[0].length % 3,
            rupiah 	= split[0].substr(0, sisa),
            ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

        $('#ongkir').text(tarif);
        $('#ongkir2').text('Rp ' + rupiah);
        document.getElementById("ongkir3").value = hasil3;

    });
    console.log('.pilih_ongkir');

    function format_rupiah(nominal) {
        var reverse = nominal.toString().split('').reverse().join(''),
            ribuan = reverse.match(/\d{1,3}/g);
        return ribuan = ribuan.join('.').split('').reverse().join('');
    }
</script>
