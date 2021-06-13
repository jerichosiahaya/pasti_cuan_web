<?php

$conn = mysqli_connect("localhost", "root", "", "pasticuan");

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function registrasi($data)
{
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $cpassword = mysqli_real_escape_string($conn, $data["cpassword"]);

    // cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM users WHERE UserID = '$username'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('username already exist');
            </script>";
        return false;
    }

    // cek password
    if ($password !== $cpassword) {
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
