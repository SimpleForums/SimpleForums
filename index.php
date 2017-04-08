<?php
    // ----------------------
    // SimpleFourms    v0.0.1
    // (c) SimpleForums 2017
    //  ---------------------
    $sf_version = '0.1-pre'; // Do not change, this will break the update system.
    include 'config.php';
    if ($db_host == '' && $_GET['page'] != 'install') {
        header("Location: ?page=install");
        die();
    }
    echo '
    <!DOCTYPE HTML>
    <head>
        <link rel="stylesheet" href="https://bootswatch.com/4-alpha/yeti/bootstrap.min.css">
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">-->
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
    </head>
    ';
    if (!(($_GET['page'] == 'install') || ($_GET['page'] == 'admin'))) {
    $conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);
    echo '
    <nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="?page=">SimpleForums</a>
    <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="?page=">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?page=forums">Forums</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?page=">Custom Page</a>
            </li>
        </ul>
        <ul class="navbar-nav navbar-right">
            <li class="nav-item">
                <a class="nav-link" href="?page=login">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?page=register">Register</a>
            </li>
        </ul>
    </div>
    </nav>
    <div class="container-fluid">
    <br>
    '; } else {
    echo '
    <div class="container-fluid">
    <br>
    '; }
    if ($_GET['page'] == '' || $_GET['page'] == 'home') {
        echo '<title>Home</title>
        <div class="jumbotron">
            <h1 class="display-3">SimpleForums</h1>
            <p>Welcome to our forums!</p>
            <p><a class="btn btn-primary btn-lg" href="?page=forums">View Forums</a></p>
        </div>
        <div class="row">
            <div class="col-8">
                <h2>Announcements</h2>
            </div>
            <div class="col-4">
                <h2>Social</h2>
            </div>
        </div>
        ';
    } elseif ($_GET['page'] == 'install') {
    	if ($install_lock == 'yes') {
    	    die('Trying to install when it already is?');
    	}
    	if ($_GET['id'] == '' || $_GET['id'] == '1') {
            echo '<title>Install - Welcome</title>
            <ol class="breadcrumb">
               <li class="breadcrumb-item active">Installer</li>
               <li class="breadcrumb-item">Database Configuration</li>
               <li class="breadcrumb-item">Verify Database</li>
               <li class="breadcrumb-item">Database Setup</li>
               <li class="breadcrumb-item">Finished</li>
            </ol>
            <h2>SimpleForums Installer</h2><p>Version: ' . $sf_version . '</p>
            <p>
            Welcome to SimpleForums, the simple, compact, and efficient way to manage your forums.<br><hr>
            The requirements for SimpleForums are:
            <ul>
                <li>A functional web server</li>
                <li>PHP version 5.4 and up</li>
                <li>About 4 minutes to install</li>
            </ul>
            <hr>
            If you meet all of the requirements listed, press continue to proceed the installation.
            </p>
            <a href="?page=install&id=2" class="btn btn-primary" role="button" aria-pressed="true">Continue</a>
            ';
    	} elseif ($_GET['id'] == '2') {
    	    echo '<title>Install - Database Configuration</title>
            <ol class="breadcrumb">
               <li class="breadcrumb-item">Installer</li>
               <li class="breadcrumb-item active">Database Configuration</li>
               <li class="breadcrumb-item">Verify Database</li>
               <li class="breadcrumb-item">Database Setup</li>
               <li class="breadcrumb-item">Finished</li>
            </ol>
            <h2>Configure Database</h2>
            <p>Configure the database that will contain SimpleForums.</p>
            <form action="?page=install&id=3" method="POST">
            <div class="form-group row">
                <label for="db_host_input" class="col-2 col-form-label">Database IP</label>
                <div class="col-10">
                <input required class="form-control" type="text" placeholder="127.0.0.1" value="" id="db_host_input" name="db_host_input">
                </div>
            </div>
            <div class="form-group row">
                <label for="dn_name_input" class="col-2 col-form-label">Database Name</label>
                <div class="col-10">
                <input required class="form-control" type="text" placeholder="nameless_lite" value="" id="db_name_input" name="db_name_input">
                </div>
            </div>
            <div class="form-group row">
                <label for="db_username_input" class="col-2 col-form-label">Database Username</label>
                <div class="col-10">
                <input required class="form-control" type="text" placeholder="root" value="" name="db_username_input" name="db_username_input">
                </div>
            </div>
            <div class="form-group row">
                <label for="db_password_input" class="col-2 col-form-label">Database Password</label>
                <div class="col-10">
                <input required class="form-control" type="password" placeholder="password" value="" id="db_password_input" name="db_password_input">
                </div>
            </div>
            <input value="Submit" type="submit" class="btn btn-primary" role="button" aria-pressed="true" />
            </form>
            ';
    	} elseif ($_GET['id'] == '3') {
    	    $conn = new mysqli($_POST['db_host_input'], $_POST['db_username_input'], $_POST['db_password_input'], $_POST['db_name_input']);
    	    echo '<title>Install - Verify Database</title>
             <ol class="breadcrumb">
                <li class="breadcrumb-item">Installer</li>
                <li class="breadcrumb-item">Database Configuration</li>
                <li class="breadcrumb-item active">Verify Database</li>
                <li class="breadcrumb-item">Database Setup</li>
                <li class="breadcrumb-item">Finished</li>
             </ol>
             <h2>Verify Database Connection</h2>';
             if ($conn->connect_error) {
                 echo '
                 <div class="alert alert-danger" role="alert">
                     <strong>Connection Error: </strong>' . $conn->connect_error . '
                 </div>
                 <a href="?page=install&id=2" class="btn btn-default" role="button" aria-pressed="true">Go Back</a>';
             } else {
                 file_put_contents('config.php','<?php
$db_host = "' . $_POST['db_host_input'] . '";
$db_username = "' . $_POST['db_username_input'] . '";
$db_password = "' . $_POST['db_password_input'] . '";
$db_name =  "' . $_POST['db_name_input'] . '";
$install_lock =  "no";
?>');
                 include 'config.php';
                 echo '
                 <div class="alert alert-warning" role="alert">
                     <strong>Important Note!</strong> Exiting the installer now will cause the installation of SimpleForums to be broken and inoperable.<br>
                     If you do exit, please delete the contents of the config.php file.
                 </div>
                 <div class="alert alert-success" role="alert">
                     <strong>Success!</strong> The information you supplied for the database works! Please wait while the database gets setup with the database.  You will see a continue button once this is complete.
                 </div>';
                 $sql_steps = '4';
                 $sql = "CREATE TABLE sf_posts (
p_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
p_title TEXT NOT NULL, 
p_author TEXT NOT NULL, 
p_contents TEXT NOT NULL, 
p_forumid TEXT NOT NULL, 
p_replyid TEXT NOT NULL, 
p_isreply TEXT NOT NULL, 
p_islocked TEXT NOT NULL, 
p_isnews TEXT NOT NULL, 
p_issticky TEXT NOT NULL, 
p_ishidden TEXT NOT NULL
)";
                 mysqli_query($conn, $sql);
                 echo 'Step 1 of ' . $sql_steps . ' completed.';
                 $sql = "CREATE TABLE sf_users (
u_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
u_username TEXT NOT NULL, 
u_password TEXT NOT NULL, 
u_email TEXT NOT NULL, 
u_group TEXT NOT NULL, 
u_isactive TEXT NOT NULL, 
u_isbanned TEXT NOT NULL
)";
                 mysqli_query($conn, $sql);
                 echo '<br>Step 2 of ' . $sql_steps . ' completed.';
                 $sql = "CREATE TABLE sf_forums (
f_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
f_name TEXT NOT NULL, 
f_password TEXT NOT NULL, 
f_ishidden TEXT NOT NULL
)";
                 mysqli_query($conn, $sql);
                 echo '<br>Step 3 of ' . $sql_steps . ' completed.';
                 $sql = "CREATE TABLE sf_forums (
s_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
s_name TEXT NOT NULL, 
s_contents TEXT NOT NULL
)";
                 mysqli_query($conn, $sql);
                 $conn->close();
                 echo '<br>Step 4 of ' . $sql_steps . ' completed.';
                 echo '<br>All steps are completed.  Please press the button below to setup the site preferences.<br><br>';
                 echo '<a href="?page=install&id=4" class="btn btn-primary" role="button" aria-pressed="true">Continue</a>';
                 }
        } elseif ($_GET['id'] == '4') {
            echo '<title>Install - Database Setup</title>
            <ol class="breadcrumb">
               <li class="breadcrumb-item">Installer</li>
               <li class="breadcrumb-item">Database Configuration</li>
               <li class="breadcrumb-item">Verify Database</li>
               <li class="breadcrumb-item active">Database Setup</li>
               <li class="breadcrumb-item">Finished</li>
            </ol>
            <h2>Setup SimpleForums</h2>
            <p>Configure the SimpleForums install to your likings.</p>
            <form action="?page=install&id=5" method="POST">
            <div class="form-group row">
                <label for="site_name" class="col-2 col-form-label">Site Name</label>
                <div class="col-10">
                <input required class="form-control" type="text" placeholder="SimpleForums" value="" id="site_name" name="site_name">
                </div>
            </div>
            <div class="form-group row">
                <label for="admin_user" class="col-2 col-form-label">Admin Username</label>
                <div class="col-10">
                <input required class="form-control" type="text" placeholder="Administrator" value="" id="admin_user" name="admin_user">
                </div>
            </div>
            <div class="form-group row">
                <label for="admin_password" class="col-2 col-form-label">Admin Password</label>
                <div class="col-10">
                <input required class="form-control" type="password" placeholder="password" value="" id="admin_password" name="admin_password">
                </div>
            </div>
            <input value="Submit" type="submit" class="btn btn-primary" role="button" aria-pressed="true" />
            </form>
            ';
    	} elseif ($_GET['id'] == '5') {
    	    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);
    	    // INSERT INTO `mcworldf_nameless`.`sf_users` (`u_id`, `u_username`, `u_password`, `u_email`, `u_group`, `u_isactive`, `u_isbanned`) VALUES (NULL, 'UsernameHere', 'PasswordHere', 'admin@example.com', 'Admin', 'true', 'false');
    	    $sql = "INSERT INTO `sf_users` (`u_id`, `u_username`, `u_password`, `u_email`, `u_group`, `u_isactive`, `u_isbanned`) VALUES (NULL, '" . $_POST['admin_user'] . "', '" . $_POST['admin_password'] . "', 'admin@nameless.lite', 'Admin', 'true', 'false');";
            mysqli_query($conn, $sql);
    	    file_put_contents('config.php','<?php
$db_host = "' . $db_host . '";
$db_username = "' . $db_username . '";
$db_password = "' . $db_password . '";
$db_name =  "' . $db_name . '";
$install_lock =  "yes";
?>');
    	    echo '<title>Install - Finished</title>
            <ol class="breadcrumb">
               <li class="breadcrumb-item">Installer</li>
               <li class="breadcrumb-item">Database Configuration</li>
               <li class="breadcrumb-item">Verify Database</li>
               <li class="breadcrumb-item">Database Setup</li>
               <li class="breadcrumb-item active">Finished</li>
            </ol>
            <h2>SimpleForums ' . $sf_version . '</h2>
            <p>You have finished the installation process for SimpleForums.<br>
            You can now login with the information you just chose when setting up.</p>
            <a href="?page=" class="btn btn-primary" role="button" aria-pressed="true">Go to Home</a>
            ';
    	}
    } elseif ($_GET['page'] == 'forums') {
        echo '<title>Forums</title>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="?page=">Home</a></li>
            <li class="breadcrumb-item active">Forums</li>
        </ol>
        <div class="row">
        <div class="col-8">
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th>Forums</th>
                    <th>Info</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th><a href="?page=forum&id=1">Sample Forum</a><br><small>This is a sample forum.</small></th>
                    <th>1 post</th>
                </tr>
            </tbody>
        </table>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-block">
                    <p class="card-text"><h5 class="text-center">Stats</h5>
                    Post Count: --<br>
                    Users Registered: --<br>
                    Latest Member: --<br>
                    </p>
                </div>
            </div>
        </div></div>
        ';
    } elseif ($_GET['page'] == 'forum') {
        echo '<title>Sample Forum</title>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="?page=">Home</a></li>
            <li class="breadcrumb-item"><a href="?page=forums">Forums</a></li>
            <li class="breadcrumb-item active">Sample Forum</li>
        </ol>
        
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th>Post</th>
                    <th>Info</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th><a href="?page=post&id=1">Sample Post</a> by <a href="?page=user&id=1">JohnDoe38</a></th>
                    <th>1 reply<br>4 views</th>
                    <th>Latest post by<br><a href="?page=user&id=1">I_Like_Pie</a></th>
                </tr>
            </tbody>
        </table>
        
        ';
    } elseif ($_GET['page'] == 'post') {
        echo '<title>Sample Post</title>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="?page=">Home</a></li>
            <li class="breadcrumb-item"><a href="?page=forums">Forums</a></li>
            <li class="breadcrumb-item"><a href="?page=forum&id=1">Sample Forum</a></li>
            <li class="breadcrumb-item active">Sample Post</li>
       </ol>
       <div class="row">
           <div class="col-2">
           	<div class="card">
                   <h7 class="card-header text-center">JohnDoe38</h7>
                   <div class="card-block">
                       <p class="card-text"><img src="https://s3.amazonaws.com/assets.zipsite.net/images/jayson/handyman/asset/default-blue-462x462.png" height="100%" width="100%"/></p>
                   </div>
               </div>
           </div>
           <div class="col-10">
               <div class="card">
                   <h3 class="card-header">Sample Post
                   <button type="button" class="btn btn-sm btn-danger float-right">Delete</button>
                   <button type="button" class="btn btn-sm btn-warning float-right">Lock</button>
                   <button type="button" class="btn btn-sm btn-info float-right">Edit</button>
                   <button type="button" class="btn btn-sm btn-success float-right">Reply</button>
                   </h3>
                   <div class="card-block">
                       <p class="card-text">Test post.</p>
                   </div>
                   <div class="card-footer text-muted text-xs-center">January 28, 2019 at 3:12
                   <button type="button" class="btn btn-sm btn-danger float-right">Dislike</button>
                   <button type="button" class="btn btn-sm btn-warning float-right">Neutral</button>
                   <button type="button" class="btn btn-sm btn-success float-right">Like</button>
                   </div>
               </div>
           </div>
       </div>
       <br><br>
       <div class="row">
           <div class="col-2">
           	<div class="card">
                   <h7 class="card-header text-center">I_Like_Pie</h7>
                   <div class="card-block">
                       <p class="card-text"><img src="https://s3.amazonaws.com/assets.zipsite.net/images/jayson/handyman/asset/default-blue-462x462.png" height="100%" width="100%"/></p>
                   </div>
               </div>
           </div>
           <div class="col-10">
               <div class="card">
                   <h3 class="card-header">
                   <button type="button" class="btn btn-sm btn-danger float-right">Delete</button>
                   <button type="button" class="btn btn-sm btn-info float-right">Edit</button>
                   <button type="button" class="btn btn-sm btn-success float-right">Reply</button>
                   </h3>
                   <div class="card-block">
                       <p class="card-text">Post reply.</p>
                   </div>
                   <div class="card-footer text-muted text-xs-center">January 28, 2019 at 3:15
                   <button type="button" class="btn btn-sm btn-danger float-right">Dislike</button>
                   <button type="button" class="btn btn-sm btn-warning float-right">Neutral</button>
                   <button type="button" class="btn btn-sm btn-success float-right">Like</button>
                   </div>
               </div>
           </div>
       </div>
       <br><h6 class="offset-2">Please login to reply.</h6>
        ';
    } elseif ($_GET['page'] == 'login') {
        echo '<title>Login</title>
        <div class="text-center">
        <h2>Login</h2><br>
        <form action="?page=login" method="POST">
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4">';
            if (isset($_POST['submit'])) {
            echo '<div class="alert alert-danger" role="alert">
                The username and/or password you supplied is incorrect.
            </div>';
            }
            echo '<label for="username" class="form-label">Username</label><br>
            <input required class="form-control" type="text" placeholder="Username" value="" id="username" name="username"><br>
            <label for="password" class="form-label">Password</label><br>
            <input required class="form-control" type="password" placeholder="Password" value="" id="password" name="password"><br>
            <input value="Login" name="submit" type="submit" class="btn btn-primary" role="button" aria-pressed="true" /><br><br>
            Forgot to<a href="?page=register"> register?</a>
            </div>
            <div class="col-4"></div>
        </div>
        </form>
        </div>
        ';
    } elseif ($_GET['page'] == 'register') {
        echo '<title>Register</title>
        <div class="text-center">
        <h2>Register</h2><br>
        <form action="?page=register" method="POST">
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4">';
            if (isset($_POST['submit'])) {
            echo '<div class="alert alert-danger" role="alert">
                Insert convincing error here.
            </div>';
            }
            echo '<label for="username" class="form-label">Username</label><br>
            <input required class="form-control" type="text" placeholder="Username" value="" id="username" name="username"><br>
            <label for="password" class="form-label">Password</label><br>
            <input required class="form-control" type="password" placeholder="Password" value="" id="password" name="password"><br>
            <label for="cpassword" class="form-label">Confirm Password</label><br>
            <input required class="form-control" type="password" placeholder="Confirm Password" value="" id="cpassword" name="cpassword"><br>
            <label for="email" class="form-label">Email</label><br>
            <input required class="form-control" type="text" placeholder="Email" value="" id="email" name="email"><br>
            <input value="Register" name="submit" type="submit" class="btn btn-primary" role="button" aria-pressed="true" /><br><br>
            Already registered?<a href="?page=login"> Log in.</a>
            </div>
            <div class="col-4"></div>
        </div>
        </form>
        </div>
        ';
    } elseif ($_GET['page'] == 'admin' && $_SESSION['user_type'] == 'admin') {
        echo '<title>Admin</title></head>Admin';
    } else {
        echo '<title>404</title>404';
    }
    echo '
    </div>
    ';
?>
