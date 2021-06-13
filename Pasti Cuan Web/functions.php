<?php

$conn = mysqli_connect("localhost", "root", "", "pasticuan");

function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function getStock($stock_symbol) {
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://alpha-vantage.p.rapidapi.com/query?function=GLOBAL_QUOTE&symbol=" . $stock_symbol,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "x-rapidapi-host: alpha-vantage.p.rapidapi.com",
            "x-rapidapi-key: 5a3404f7a8mshd2cbc50db1c391ap1c24efjsneb9a82cb216d"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        var_dump($response);
    }

    return $data;
}



function registrasi($data) {
    global $conn;

    $username = strtolower(stripslashes( $data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $cpassword = mysqli_real_escape_string($conn, $data["cpassword"]);
    
    // cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM users WHERE UserID = '$username'");

    if(mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('username already exist');
            </script>";
        return false;
    }

    // cek password
    if($password !== $cpassword) {
        echo "<script>
                alert('Confirmatin password invalid!');
            </script>";
        return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);
    // var_dump($password); die;

    // tambahkan userbaru ke database
    mysqli_query($conn, "INSERT INTO users VALUES('', '$username', '$password')");

    // untuk return 1 jika berhasil dan return 0 jika gagal
    return mysqli_affected_rows($conn);

    // return true;
}



?>