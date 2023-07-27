<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        div {
            margin: 10px 0;
        }
    </style>

</head>

<body>
    <center>
        <h1>Temperature API with lat and long</h1>
        <form action="index.php" method="post">
            <div>
                <label for="lat">Enter Latitude</label>
                <input type="number" name="lat" id="lat">
            </div>
            <div>
                <label for="long">Enter Longitude</label>
                <input type="number" name="long" id="long">
            </div>
            <div>
                <button type="submit">Get info</button>
            </div>
        </form>

        <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $apiUrl = 'http://localhost/temperature_rest/api.php';

            $data = array(
                'lat' => $_POST['lat'],
                'long' => $_POST['long']
            );

            $enc_data = json_encode($data);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

            $response = curl_exec($ch);
            curl_close($ch);

            $result = json_decode($response, true);
            echo 'Latitude : ' . $result['latitude'] . '<br>';
            echo 'longitude : ' . $result['longitude'] . '<br>';
            echo 'timezone : ' . $result['timezone'] . '<br>';
            echo 'elevation : ' . $result['elevation'] . '<br>';

            for ($i = 0; $i <= 150; $i++) {
                echo $result["hourly"]["time"][$i] . ' : ' . $result["hourly"]["temperature_2m"][$i] . '<br>';
            }
        }

        ?>


    </center>
</body>

</html>