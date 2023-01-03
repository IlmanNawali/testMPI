<!DOCTYPE html>
<html ng-app="">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FORM PAY</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <script src="js/javascript.js" type="text/javascript"></script>
    <script src="js/angular-1.7.5/angular.min.js" type="text/javascript"></script>
  </head>
  <body>
  <br>
  <br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <div class="container">
    <h1 style="margin:10px;">PAYMENT</h1>
    <form class="" action="#" method="post">
      <input required class="input-form laf" type="text" name="nama" value="" placeholder="Nama">
      <div style="overflow-x:auto;">
        <label>Pilih Metode Pembayaran</label>
        <table border=0 cellpadding="10">
          <tr>
            <th><input type="checkbox" name="bank" value="va_bni"><img src="img/bni.png" width="60px" height="20px"></th>
            <th><input type="checkbox" name="bank" value="va_bca"><img src="img/logo-bca.png" width="60px" height="20px"></th>
            <th><input type="checkbox" name="bank" value="va_bri"><img src="img/bri.png" width="60px" height="25px"></th>
            <th><input type="checkbox" name="bank" value="va_permata"><img src="img/permata.png" width="60px" height="30px"></th>
            <th><input type="checkbox" name="bank" value="va_danamon"><img src="img/danamon.png" width="60px" height="25px"></th>
            <th><input type="checkbox" name="bank" value="va_cimb"><img src="img/cimb.png" width="60px" height="20px"></th>
          </tr>
          <tr>
            <th></th>
            <th></th>
            <th><input type="checkbox" name="bank"  value="va_mandiri"><img src="img/mandiri.png" width="60px" height="20px"></th>
            <th><input type="checkbox" name="bank"  value="va_sahabat_sampoerna"><img src="img/sampoerna.png" width="70px" height="50px"></th>
            <th></th>
            <th></th>
          </tr>
        </table>
      </div>
      <button class="btn-form-pay" name="btn">Pay</button>
      <button class="btn-form-change" id="myBtn">Batal</button>
    </form>
  </div>
  </body>
  <?php
    $submitPressed = filter_input(INPUT_POST, 'btn');
    if (isset($submitPressed)){
    $nama = filter_input(INPUT_POST,"nama");
    $bank = filter_input(INPUT_POST,"bank");
    $harga = filter_input(INPUT_POST,"harga");
    $studio = filter_input(INPUT_POST,"studio");
    $keyProject = 'MPI-D3B994C741';
    $tokenProject = '845e958da9566c168284829d066e5446';
    $amount = "10000";
    $referenceId = 'asdqew1241231412';
    $signHash = hash_hmac('sha512', $keyProject.$referenceId, $tokenProject);
    $reqType = "oneoff";
    $callbackUrl = "https://yourcallback.com/mpay";
    $expTime = "60";
    $useCase = "single";
    $vaExpired = "60";
    $paymentCode = $bank;
    $req_data = array(
        'key' => $keyProject,
        'token' => $tokenProject,
        'referenceId' => $referenceId,
        'amount' => $amount,
        'callbackUrl' => $callbackUrl,
        'signHash' => $signHash,
        'reqType' => $reqType,
        'viewName' => $nama,
        'expTime' => $expTime,
        'useCase' => $useCase,
        'vaExpired' => $vaExpired
    );
    $data_payload = json_encode($req_data);
    
    $curl = curl_init();
    $options = array(
        CURLOPT_URL => 'https://api-prod.mitrapayment.com/api/v4/va/'.$paymentCode,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $data_payload,
        CURLOPT_POST => 1,
        CURLOPT_HTTPHEADER => array('Content-Type: application/json','Content-Length:'.strlen($data_payload))
    );

    curl_setopt_array($curl, $options);
    
    $response = curl_exec($curl);
    curl_close($curl);
    $json_result = json_decode($response, true);
    $kodeVA = $json_result['data_payment']['paymentMethod']['accountNo'];
    echo "<script>alert('Kode VA: $kodeVA');</script>";
    }

  

  ?>
</html>
