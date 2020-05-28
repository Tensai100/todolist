<?php

session_start();

if (!isset($_POST['todolist_id']))
    exit();

try {
    include_once "./connect_db.php";

    $todolist_id = $_POST['todolist_id'];
    $_SESSION['actived_todolist'] = $todolist_id;
    $sql = "SELECT * FROM tasks WHERE todolist_id = '$todolist_id'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();


    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $stmt->fetchAll();

    foreach ($rows as $row) :
?>

        <li>
            <div class="form-check">
                <label onclick="changeTaskStatus(<?php echo $row['id'] . ', ' . $row['done'] ?>, <?php echo $todolist_id ?>)" class="form-check-label">
                    <input class="checkbox" type="checkbox" <?php if ($row['done'] == 1) echo "checked" ; ?>>

                    <?php echo $row['taskText']; ?>

                    <i class="input-helper"></i>
                </label>
            </div>
            <i class="remove d-flex">
                <img onclick="renameTaskText(<?php echo $row['id'] ?>, '<?php echo $row['taskText']; ?>', this)" src="./img/edit.png">
                <img onclick="deleteTask(<?php echo $row['id'] ?>)" src="./img/delete.png">
            </i>
        </li>

<?php
    endforeach;
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
