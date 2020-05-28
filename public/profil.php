<?php
include_once "../classes.php";
// Start the session
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ./index.php");
    exit();
}



$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="./css/style.css">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>

    <title>Profil || <?php echo $user->username ?></title>
</head>

<body>


    <div class="container">
        <div class="row">
            <div class="span12">
                <div class="col" id="loginModal">
                    <div class="modal-header">
                        <button onclick="todolist_page()" type="button" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div id="alert" role="alert"></div>
                        <h3 class="badge"><?php echo $user->username ?></h3>
                    </div>
                    <div class="modal-body">
                        <div class="well">
                            <div class="infos">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#infos" data-toggle="tab">Profil informations</a></li>
                                    <li><a href="#pwd" data-toggle="tab">Change the password</a></li>
                                </ul>
                                <div id="myTabContent" class="tab-content">
                                    <div class="tab-pane active in" id="infos">
                                        <form>
                                            <label>Username</label>
                                            <input type="text" name="username" id="username" value="<?php echo $user->username ?>" class="input-xlarge">
                                            <label>First Name</label>
                                            <input type="text" name="firstname" id="firstname" value="<?php echo $user->firstname ?>" class="input-xlarge">
                                            <label>Last Name</label>
                                            <input type="text" name="lastname" id="lastname" value="<?php echo $user->lastname ?>" class="input-xlarge">
                                            <label>Email</label>
                                            <input type="text" name="email" id="email" value="<?php echo $user->email ?>" class="input-xlarge">

                                            <div>
                                                <button type="button" onclick="updateInfos()" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="pwd">
                                        <form>
                                            <label>Old password</label>
                                            <input type="password" name="old_password" id="old_password" value="" class="input-xlarge">
                                            <label>Password</label>
                                            <input type="password" name="password" id="password" value="" class="input-xlarge">
                                            <label>Confirm password</label>
                                            <input type="password" name="password2" id="password2" value="" class="input-xlarge">

                                            <div>
                                                <button type="button" onclick="changePassword()" class="btn btn-primary">Change</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="photo">
                                <div class="img"><img id="avatar" src="./img/<?php echo (strlen($user->photo) > 1) ? $user->photo : "avatar.png" ?>" height="200px" width="200px;" /></div>
                                <div class="button">
                                    <span onclick="changePhoto('ChangePhoto')"><input type="file" id="photo" accept="image/png, image/jpeg" hidden><img src="./img/change.png" /></span>
                                    <span onclick="changePhoto('Delete')"><img src="./img/delete.png" /></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer d-flex justify-content-around align-content-end bg-primary">&copy; 2020 BOUFARA Mustapha</footer>


    <script>
        function todolist_page() {
            window.location.href = "./todolist.php";
        }





        // Profil informations
        function updateInfos() {
            let username = document.getElementById('username').value;
            let firstname = document.getElementById('firstname').value;
            let lastname = document.getElementById('lastname').value;
            let email = document.getElementById('email').value;

            if (username.length > 0 && firstname.length > 0 && lastname.length > 0 && email.length > 0) {

                let xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = XMLHttpRequest_callback;
                xmlhttp.open('POST', `../requests_to_server.php`, true);

                let formData = new FormData();
                formData.append('req', 'updateInfos');
                formData.append('username', username);
                formData.append('firstname', firstname);
                formData.append('lastname', lastname);
                formData.append('email', email);

                xmlhttp.send(formData);

            } else {
                document.getElementById("alert").textContent = "All informations are required !!";
                document.getElementById("alert").setAttribute('class', 'alert alert-danger');
            }

        }


        //Password
        function changePassword() {

            let old_password = document.getElementById("old_password").value;
            let password = document.getElementById("password").value;
            let password2 = document.getElementById("password2").value;

            if (old_password.length > 0 && password.length > 0 && password2.length > 0) {

                if (password !== password2) {
                    document.getElementById("alert").textContent = "Password don't match !!";
                    document.getElementById("alert").setAttribute('class', 'alert alert-danger');
                    return;
                }

                let xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = XMLHttpRequest_callback;
                xmlhttp.open('POST', `../requests_to_server.php`, true);

                let formData = new FormData();
                formData.append('req', 'ChangePassword');
                formData.append('old_password', old_password);
                formData.append('password', password);

                xmlhttp.send(formData);

            } else {
                document.getElementById("alert").textContent = "All informations are required !!";
                document.getElementById("alert").setAttribute('class', 'alert alert-danger');
            }
        }


        // Photo 
        function changePhoto(req) {

            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = XMLHttpRequest_callback;
            xmlhttp.open('POST', `../requests_to_server.php`, true);
            let formData = new FormData();
            formData.append('req', req);

            if (req === 'ChangePhoto') {
                let photoInput = document.getElementById('photo');
                photoInput.addEventListener("change", () => {
                    formData.append('photo', photoInput.files[0], photoInput.value);
                    xmlhttp.send(formData);
                });
                photoInput.click();

            } else
                xmlhttp.send(formData);

        }

        //XMLHttpRequest function call
        function XMLHttpRequest_callback() {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    if (this.responseText == "success") {

                        document.getElementById("alert").textContent = "Updated successfully";
                        document.getElementById("alert").setAttribute('class', 'alert alert-success');

                        window.location.reload();
                    } else {
                        document.getElementById("alert").textContent = "Alert: " + this.responseText;
                        document.getElementById("alert").setAttribute('class', 'alert alert-danger');
                    }
                }
            }
        }
    </script>

</body>

</html>