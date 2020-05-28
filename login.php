<?php

session_start();

include_once "./classes.php";
include_once "./connect_db.php";
if (isset($_GET['username']) && isset($_GET['password'])) {
    $username = $_GET['username'];
    $password = $_GET['password'];

    try {

        $sql = "SELECT * FROM users WHERE username = '$username'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $row = $stmt->fetchAll();
        if (sizeof($row) > 0 && password_verify($password, $row[0]['password'])) {
            $_SESSION["user"] = new User($row[0]['id'], $row[0]['username'], $row[0]['password'], $row[0]['email'], $row[0]['firstname'], $row[0]['lastname'], $row[0]['photo']);


            $user_id = $_SESSION["user"]->id;
            $sql = "SELECT * FROM todolist WHERE user_id = '$user_id'";

            $stmt = $conn->prepare($sql);
            $stmt->execute();


            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $rows = $stmt->fetchAll();

            $_SESSION['todolist_array'] = [];
            foreach ($rows as $row) {
                $_SESSION['todolist_array'][] = new TodoList($row['id'], $row['name'], $row['color'], $row['user_id']);
            }

            $_SESSION['actived_todolist'] = -1;

            echo "success";
        } else {
            echo "User doesn't exist!!";
        }
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
} else {
    echo "Login error !!";
}
