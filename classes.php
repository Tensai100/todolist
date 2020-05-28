<?php


class User
{
    function __construct($id, $username, $password, $email, $firstname, $lastname, $photo)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->photo = $photo;
    }

    function UpdateInformations($username, $email, $firstname, $lastname)
    {
        try {
            include "./connect_db.php";
            if ($username != $this->username) {
                $sql = "SELECT * FROM users WHERE username = '$username'";

                $stmt = $conn->prepare($sql);
                $stmt->execute();

                $row = $stmt->fetchAll();
                if (sizeof($row) > 0) {
                    return "$username already exist !!";
                }
            }

            $sql = "UPDATE users SET username='$username', email='$email', firstname='$firstname', lastname='$lastname' WHERE id=$this->id";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $this->username = $username;
            $this->email = $email;
            $this->firstname = $firstname;
            $this->lastname = $lastname;

            return "success";
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }

    function ChangePhoto($photo)
    {
        try {
            include "./connect_db.php";
            $sql = "UPDATE users SET photo='$photo' WHERE id=$this->id";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $this->photo = $photo;

            return "success";
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }

    function ChangePassword($old_password, $password)
    {
        try {
            include "./connect_db.php";

            if (!password_verify($old_password, $this->password)) {
                return "The old password is wrong!!";
            }


            $sql = "UPDATE users SET password='$password' WHERE id=$this->id";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $this->password = $password;

            return "success";
        } catch (PDOException $e) {
            return $sql . "<br>" . $e->getMessage();
        }
    }
}


class TodoList
{
    function __construct($id, $name, $color, $user_id, $to_db = false)
    {
        $this->id = $id;
        $this->name = $name;
        $this->color = $color;
        $this->user_id = $user_id;

        
        if($to_db){
            try {
                include "./connect_db.php";

                $sql = "INSERT INTO todolist (name, color, user_id) VALUES ('$name', '$color', '$user_id')";
                $conn->exec($sql);
    
            } catch (PDOException $e) {
                return $sql . "<br>" . $e->getMessage();
            }
        }
    }
}


class Task
{
    function __construct($id, $taskText, $done, $todoList_id)
    {
        $this->id = $id;
        $this->taskText = $taskText;
        $this->done = $done;
        $this->todoList_id = $todoList_id;
    }

    function ChangeTaskStatus()
    {
        //Change done to true/false on database
    }

    function DeleteTask()
    {
        //Delete this from database
    }

    function ChangeTaskText($taskText)
    {
        $this->taskText = $taskText;
    }
}
