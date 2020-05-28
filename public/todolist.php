<?php
include_once "../classes.php";
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ./index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">



    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="./css/todolist.css">

    <title>TodoList</title>
</head>

<body>

    <?php include_once "./header.php" ?>


    <div class="container">
        <div id="alert" role="alert"></div>


        <!-- ADD TODOLIST -->
        <div class="add-items d-flex">
            <input type="text" id="todolist" class="form-control todo-list-input" placeholder="What do you need to do today?">
            <button onclick="addTodoList()" class="add btn btn-primary font-weight-bold todo-list-add-btn">Add</button>
        </div>


        <div class="row">
            <div class="col-md-4">
                <div class="list-group" id="list-tab" role="tablist">

                    <!-- nav of todolists -->


                </div>
            </div>
            <div class="col-md-8">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" role="tabpanel">
                        <div class="card">
                            <div class="row">
                                <div class="col-lg-12">

                                    <div class="card-header" id="headingOne">
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination d-flex flex-wrap justify-content-around">
                                                <li onclick="changeColor('primary')"><button class="btn btn-primary"></button></li>
                                                <li onclick="changeColor('success')"><button class="btn btn-success"></button></li>
                                                <li onclick="changeColor('secondary')"><button class="btn btn-secondary"></button></li>
                                                <li onclick="changeColor('danger')"><button class="btn btn-danger"></button></li>
                                                <li onclick="changeColor('warning')"><button class="btn btn-warning"></button></li>
                                                <li onclick="changeColor('info')"><button class="btn btn-info"></button></li>
                                            </ul>
                                        </nav>

                                        <div class="input-group mb-3">
                                            <input type="text" id="todolistName" class="form-control" placeholder="Change your todolist name ?" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                            <div class="input-group-append">
                                                <button onclick="updateName()" class="btn btn-primary" type="button">Apply</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <h4 class="card-title">Todo list tasks</h4>
                                        <div class="input-group mb-3">
                                            <input type="text" id="taskText" class="form-control" placeholder="New task" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                            <div class="input-group-append">
                                                <button onclick="addTask()" class="btn btn-primary" type="button">Add</button>
                                            </div>
                                        </div>
                                        <div class="container-fluid">
                                            <div class="list-wrapper">
                                                <ul id="tasks" class="d-flex flex-column todo-list">

                                                    <!-- Tasks list -->

                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <div class="input-group-append d-flex justify-content-end">
                                            <button onclick="deleteTodoList()" class="btn btn-danger" type="button">Delete this TodoList</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer d-flex justify-content-around align-content-end">&copy; 2020 BOUFARA Mustapha</footer>













    <script>
        let selected_js_todolist_id;

        reloadTodoList_nav();

        function reloadTodoList_nav() {

            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4) {
                    if (this.status == 200) {
                        document.getElementById("list-tab").innerHTML = this.responseText;
                    }
                }
            }

            xmlhttp.open('POST', `../todolist_nav.php`, true);
            xmlhttp.send();

        }

        function addTodoList() {
            let todolist = document.getElementById("todolist").value;

            if (todolist.length > 0) {

                let xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = XMLHttpRequest_callback;
                xmlhttp.open('POST', `../requests_to_server.php`, false);

                let formData = new FormData();
                formData.append('req', 'AddTodoList');
                formData.append('todolist', todolist);

                xmlhttp.send(formData);

                document.getElementById("todolist").value = "";

                reloadTodoList_nav();
            }
        }

        function todolist_show(todolist_id) {

            selected_js_todolist_id = todolist_id;

            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4) {
                    if (this.status == 200) {
                        document.getElementById("tasks").innerHTML = this.responseText;
                    }
                }
            }

            xmlhttp.open('POST', `../task.php`, true);

            let formData = new FormData();
            formData.append('todolist_id', todolist_id);

            xmlhttp.send(formData);

        }

        function changeColor(color) {

            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = XMLHttpRequest_callback;
            xmlhttp.open('POST', `../requests_to_server.php`, false);

            let formData = new FormData();
            formData.append('req', 'ChangeColor');
            formData.append('color', color);

            xmlhttp.send(formData);

            reloadTodoList_nav();
        }

        function deleteTodoList() {

            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = XMLHttpRequest_callback;
            xmlhttp.open('POST', `../requests_to_server.php`, false);

            let formData = new FormData();
            formData.append('req', 'DeleteTodoList');

            xmlhttp.send(formData);

            reloadTodoList_nav();

        }

        function updateName() {

            let todolistName = document.getElementById("todolistName").value;

            if (todolistName.length > 0) {
                let xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = XMLHttpRequest_callback;
                xmlhttp.open('POST', `../requests_to_server.php`, false);

                let formData = new FormData();
                formData.append('req', 'UpdateName');
                formData.append('name', todolistName);

                xmlhttp.send(formData);

                reloadTodoList_nav();

            }
        }

        // Tasks
        function addTask() {

            let taskText = document.getElementById("taskText").value;

            if (taskText.length > 0) {
                let xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = XMLHttpRequest_callback;
                xmlhttp.open('POST', `../requests_to_server.php`, false);

                let formData = new FormData();
                formData.append('req', 'AddTask');
                formData.append('taskText', taskText);

                xmlhttp.send(formData);

                todolist_show(selected_js_todolist_id);

                document.getElementById("taskText").value = "";
            }
        }

        function deleteTask(id) {

            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = XMLHttpRequest_callback;
            xmlhttp.open('POST', `../requests_to_server.php`, false);

            let formData = new FormData();
            formData.append('req', 'DeleteTask');
            formData.append('id', id);

            xmlhttp.send(formData);

            todolist_show(selected_js_todolist_id);

        }

        function changeTaskStatus(id, done) {

            done = !done;
            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = XMLHttpRequest_callback;
            xmlhttp.open('POST', `../requests_to_server.php`, false);

            let formData = new FormData();
            formData.append('req', 'ChangeTaskStatus');
            formData.append('id', id);
            formData.append('done', done);

            xmlhttp.send(formData);

            todolist_show(selected_js_todolist_id);

        }

        function renameTaskText(id, taskname, elm) {

            let li = elm.parentNode.parentNode;

            li.innerHTML = `<div class="input-group">
                                <input type="text" id="taskname${id}" class="form-control" placeholder="Rename your task" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button onclick="changeTaskText(${id})" class="btn btn-success" type="button">Apply</button>
                                    <button onclick="todolist_show(selected_js_todolist_id)" class="btn btn-danger" type="button">Cancel</button>
                                </div>
                            </div>`;

            document.getElementById(`taskname${id}`).value = taskname;

        }

        function changeTaskText(id) {

            let taskname = document.getElementById(`taskname${id}`).value;

            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = XMLHttpRequest_callback;
            xmlhttp.open('POST', `../requests_to_server.php`, false);

            let formData = new FormData();
            formData.append('req', 'ChangeTaskText');
            formData.append('id', id);
            formData.append('taskname', taskname);

            xmlhttp.send(formData);

            todolist_show(selected_js_todolist_id);

        }


        //XMLHttpRequest function call
        function XMLHttpRequest_callback() {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    if (this.responseText != "success") {
                        document.getElementById("alert").textContent = "Alert: " + this.responseText;
                        document.getElementById("alert").setAttribute('class', 'alert alert-danger');
                    }
                }
            }
        }
    </script>
</body>

</html>