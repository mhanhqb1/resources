<?php
session_start();
error_reporting(0);
ob_start();
$err = '';
if(isset($_POST['submit'])){
    $email = $pass = '';
    if($_POST['txtEmail'] != ''){
        $email = $_POST['txtEmail'];
    }else{
        $err[] = 'Please enter email !';
    }
    if($_POST['txtPass'] != ''){
        $pass = $_POST['txtPass'];
    }else{
        $err[] = 'Please enter password !';
    }
    if($email && $pass){
        // require_once "../library/Database.php";
        // $user = new USER;
        // $admin = $user->checkAdminLogin($email,$pass);
        if($email == 'tuanhoang' && $pass == 'hhoangddinhttuan' ){
            $_SESSION['level'] = '2';
            $_SESSION['admin_name'] = 'Hoang Tuan';
            $_SESSION['user_id'] = '1';
            header('location: index.php');
            exit();
        }else{
            $err[] = 'Invalid email or password.';
        }
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Khóa Học Lập Trình Laravel Framework 5.x Tại Khoa Phạm">
    <meta name="author" content="Vu Quoc Tuan">

    <title>Admin - DynamicShipping</title>

    <!-- Bootstrap Core CSS -->
    <link href="templates/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="templates/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="templates/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="templates/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <?php if($err): ?>
                   <div class="clearfix"></div>
                    <?php foreach ($err as $value): ?>
                        <div class="alert alert-danger">
                            <?php echo $value; ?>
                        </div>
                    <?php endforeach; ?>

                <?php endif;?>
                    <div class="panel-body">
                        <form role="form" action="login.php" method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="txtEmail" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="txtPass" type="password" value="">
                                </div>
                                <button type="submit" name="submit" class="btn btn-lg btn-success btn-block">Login</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="templates/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="templates/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="templates/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="templates/dist/js/sb-admin-2.js"></script>

</body>

</html>
