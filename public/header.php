<ul class="nav nav-pills d-flex align-content-center justify-content-between container">
        <li class="nav-item ">
            <h1><span class="badge badge-dark">TodoList</span></h1>
        </li>
        <li class="nav-item dropleft">
            <div class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <span class="badge"><img src="./img/<?php echo $_SESSION['user']->photo ?>" alt="" srcset=""></span>
            </div>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="./profil.php">Edit account</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="../loginout.php">Login out</a>
            </div>
        </li>
    </ul>