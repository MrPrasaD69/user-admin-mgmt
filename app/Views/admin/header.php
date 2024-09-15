<?php

use App\Models\UserModel;

$model_user = new UserModel;

if (!empty($_SESSION['user_id'])) {
    $user_data = $model_user->where('user_id="' . $_SESSION['user_id'] . '"')->first();
} else {
    $user_data = array();
}

$module_name_arr = explode('/',$_SERVER['REQUEST_URI']);
$controller = (!empty($module_name_arr[2]) ? $module_name_arr[2] : '');
$action = (!empty($module_name_arr[3]) ? $module_name_arr[3] : '');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://malsup.github.io/jquery.form.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.5/css/dataTables.dataTables.min.css" />
    <script src="//cdn.datatables.net/2.1.5/js/dataTables.min.js"></script>

    <link rel="stylesheet" href="<?php echo base_url(); ?>public/assets/bootstrap/css/bootstrap.min.css">


    <!-- Bootstrap JavaScript Bundle (includes Popper.js for Bootstrap 5) -->
    <script src="<?php echo base_url(); ?>public/assets/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php echo (!empty($action) && $action=='dashboard' ? 'active' : ''); ?>" aria-current="page" href="<?php echo base_url(); ?>admin/dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (!empty($action) && $action=='userList' ? 'active' : ''); ?>" href="<?php echo base_url(); ?>admin/userList">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (!empty($action) && $action=='listSong' ? 'active' : ''); ?>" href="<?php echo base_url(); ?>admin/listSong">Song Master</a>
                    </li>

                </ul>
                <ul>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo base_url(); ?>public/assets/media/placeholder.png" height="80" width="80" alt="Profile Icon" />
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>admin/logout">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="content">

    </div>