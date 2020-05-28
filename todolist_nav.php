<?php
include_once "./classes.php";
include_once "./connect_db.php";
session_start();

try {

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

} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}



foreach ($_SESSION['todolist_array'] as $todolist) : ?>

    <a class="list-group-item list-group-item-action <?php if (isset($_SESSION['actived_todolist']) && $_SESSION['actived_todolist'] == $todolist->id) echo "active" ?>"  onclick="todolist_show(<?php echo $todolist->id ?>)" data-toggle="list" href="#" role="tab" >
        <span class="border border-dark badge  <?php echo "badge-$todolist->color" ?>">></span>
        <?php echo $todolist->name ?>
    </a>

<?php endforeach ?>