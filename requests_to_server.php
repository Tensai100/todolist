<?php
include_once "./classes.php";
include_once "./connect_db.php";
session_start();


if (!isset($_POST['req']))
    exit();

$todolist_id = $_SESSION['actived_todolist'];

if ($_POST['req'] === 'updateInfos') {
    echo $_SESSION['user']->UpdateInformations($_POST['username'], $_POST['email'], $_POST['firstname'], $_POST['lastname']);
} else if ($_POST['req'] === 'ChangePassword') {
    echo $_SESSION['user']->ChangePassword($_POST['old_password'], password_hash($_POST['password'], PASSWORD_DEFAULT));
} else if ($_POST['req'] === 'ChangePhoto') {

    $file = $_FILES["photo"];

    // Check if image file is a actual image or fake image
    if (getimagesize($file["tmp_name"])) {

        // Check file size
        if ($file["size"] <= 1000000) {

            // Allow certain file formats
            $imageFileType = strtolower(pathinfo(basename($file["name"]), PATHINFO_EXTENSION));
            if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {

                $target_file = "./public/img/" . $_SESSION['user']->id . "." . $imageFileType;

                // if everything is ok, try to upload file
                if (move_uploaded_file($file["tmp_name"], $target_file)) {

                    echo $_SESSION['user']->ChangePhoto(basename($target_file));
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            }
        } else {
            echo "Sorry, your file is too large.";
        }
    } else {
        echo "File is not an image.";
    }
} else if ($_POST['req'] === 'Delete') {
    //Remove file
    unlink("./public/img/" . $_SESSION['user']->photo);
    echo $_SESSION['user']->ChangePhoto('');
}



// TodoList
else if ($_POST['req'] === 'AddTodoList') {

    if (isset($_POST['todolist'])) {

        $name = $_POST['todolist'];
        $user_id = $_SESSION["user"]->id;

        $todolist = new TodoList(null, $name, 'dark', $user_id, true);

        echo "success";
    }
}

// Change color
else if ($_POST['req'] === 'ChangeColor') {

    try {
        
        $color = $_POST['color'];
        $sql = "UPDATE todolist SET color='$color' WHERE id = '$todolist_id'";

        $conn->exec($sql);

        echo "success";
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}

// DeleteTodoList
else if ($_POST['req'] === 'DeleteTodoList') {

    try {

        $sql = "DELETE FROM todolist WHERE id = '$todolist_id'";

        $conn->exec($sql);

        echo "success";
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}

//  Update name
else if ($_POST['req'] === 'UpdateName') {

    try {

        $name = $_POST['name'];
        $sql = "UPDATE todolist SET name='$name' WHERE id = $todolist_id";

        $conn->exec($sql);

        echo "success";
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}

//  ADD Tasks
else if ($_POST['req'] === 'AddTask') {

    try {

        $taskText = $_POST['taskText'];

        $sql = "INSERT INTO tasks (taskText, done, todolist_id) VALUES ('$taskText', 0, '$todolist_id')";
        $conn->exec($sql);

        echo "success";
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
} 

// DeleteTask
else if ($_POST['req'] === 'DeleteTask') {

    try {

        $id = $_POST['id'];

        $sql = "DELETE FROM tasks WHERE id = '$id'";
        $conn->exec($sql);

        echo "success";
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
} 


// ChangeTaskStatus
else if ($_POST['req'] === 'ChangeTaskStatus') {

    try {

        $id = $_POST['id'];
        $done = $_POST['done'];

        $sql = "UPDATE tasks SET done=$done WHERE id = '$id'";

        $conn->exec($sql);

        echo "success";
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
} 


// ChangeTaskText
else if ($_POST['req'] === 'ChangeTaskText') {

    try {

        $id = $_POST['id'];
        $taskText = $_POST['taskname'];

        $sql = "UPDATE tasks SET taskText='$taskText' WHERE id = '$id'";

        $conn->exec($sql);

        echo "success";
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}
