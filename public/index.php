<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="./css/style.css">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>

    <title>TodoList</title>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="span12">
                <div class="" id="loginModal">
                    <div class="modal-header">
                        <div id="alert" role="alert"></div>
                        <h3>Have an Account?</h3>
                    </div>
                    <div class="modal-body">
                        <div class="well">
                            <div class="infos">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#login" data-toggle="tab"><b>Login</b></a></li>
                                    <li><a href="#create" data-toggle="tab"><b>Create Account</b></a></li>
                                </ul>
                                <div id="myTabContent" class="tab-content">
                                    <div class="tab-pane active in" id="login">
                                        <form>
                                            <div id="legend">
                                                <legend class="">Login</legend>
                                            </div>

                                            <label>Username</label>
                                            <input type="text" name="username" id="username" value="" class="input-xlarge">
                                            <label>Password</label>
                                            <input type="password" name="password" id="password" value="" class="input-xlarge">

                                            <div>
                                                <button type="button" onclick="login()" class="btn btn-success">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="create">
                                        <form>
                                            <div id="legend">
                                                <legend class="">Create Account</legend>
                                            </div>

                                            <label>Username</label>
                                            <input type="text" name="username" id="r_username" value="" class="input-xlarge">
                                            <label>First Name</label>
                                            <input type="text" name="firstname" id="r_firstname" value="" class="input-xlarge">
                                            <label>Last Name</label>
                                            <input type="text" name="lastname" id="r_lastname" value="" class="input-xlarge">
                                            <label>Email</label>
                                            <input type="text" name="email" id="r_email" value="" class="input-xlarge">
                                            <label>Password</label>
                                            <input type="password" name="password" id="r_password" value="" class="input-xlarge">
                                            <label>Confirm password</label>
                                            <input type="password" name="password2" id="r_password2" value="" class="input-xlarge">

                                            <div>
                                                <button type="button" onclick="register()" class="btn btn-primary">Create Account</button>
                                            </div>
                                        </form>
                                    </div>
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
        function login() {
            let username = document.getElementById("username").value;
            let password = document.getElementById("password").value;

            if (username.length > 0 && password.length > 0) {

                let xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("alert").textContent = this.responseText;
                        if (this.responseText === "success") {
                            document.getElementById("alert").setAttribute('class', 'alert alert-success');
                            window.location.href = "./todolist.php";
                        } else {
                            document.getElementById("alert").setAttribute('class', 'alert alert-danger');
                        }
                    }
                }

                xmlhttp.open("GET", `../login.php?username=${username}&password=${password}`, true);
                xmlhttp.send();

            } else {
                document.getElementById("alert").textContent = "The username or the password are missing !!";
                document.getElementById("alert").setAttribute('class', 'alert alert-danger');
            }
        }

        function register() {
            let username = document.getElementById("r_username").value;
            let firstname = document.getElementById("r_firstname").value;
            let lastname = document.getElementById("r_lastname").value;
            let email = document.getElementById("r_email").value;
            let password = document.getElementById("r_password").value;
            let password2 = document.getElementById("r_password2").value;

            if (username.length > 0 && firstname.length > 0 && lastname.length > 0 && email.length > 0 && password.length > 0) {

                if (password !== password2) {
                    document.getElementById("alert").textContent = "Password don't match !!";
                    document.getElementById("alert").setAttribute('class', 'alert alert-danger');
                    return;
                }

                let xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("alert").textContent = this.responseText;
                        if (this.responseText === "success") {
                            document.getElementById("alert").setAttribute('class', 'alert alert-success');
                            window.location.href = "./profil.php";
                        } else {
                            document.getElementById("alert").setAttribute('class', 'alert alert-danger');
                        }
                    }
                }

                xmlhttp.open("GET", `../register.php?username=${username}&firstname=${firstname}&lastname=${lastname}&email=${email}&password=${password}`, true);
                xmlhttp.send();

            } else {
                document.getElementById("alert").textContent = "All informations are required !!";
                document.getElementById("alert").setAttribute('class', 'alert alert-danger');
            }
        }
    </script>

</body>

</html>