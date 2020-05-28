<?php
session_start();
include_once "./connect_db.php";
include_once "./classes.php";

if (isset($_GET['username']) && isset($_GET['firstname']) && isset($_GET['lastname']) && isset($_GET['email']) && isset($_GET['password'])) {

    $username = $_GET['username'];
    $firstname = $_GET['firstname'];
    $lastname = $_GET['lastname'];
    $email = $_GET['email'];
    $password = password_hash($_GET['password'], PASSWORD_DEFAULT);

    try {
        $sql = "SELECT * FROM users WHERE username = '$username'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $row = $stmt->fetchAll();
        if (sizeof($row) > 0) {
            echo "$username already exist !!";
        } else {
            $sql = "INSERT INTO users (username, firstname, lastname, email, password) VALUES ('$username', '$firstname', '$lastname', '$email', '$password')";
            $conn->exec($sql);

            $_SESSION["user"] = new User($row[0]['id'], $row[0]['username'], $row[0]['password'], $row[0]['email'], $row[0]['firstname'], $row[0]['lastname'], $row[0]['photo']);
            echo "success";
        }
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
} else {
    echo "Login error !!";
}
