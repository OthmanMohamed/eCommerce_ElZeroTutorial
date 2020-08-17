<?php 
    session_start();

    $noNavbar = ''; //Setting this variable to prevent including the navbar in the index page

    if(isset($_SESSION['userName'])){
        header('Location: dashboard.php'); //Redirect to dashboard
    }

    include "init.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$username = $_POST['user'];
		$password = $_POST['pass'];
        $hashedPass = sha1($password);

        //Check if user exists in database  
        $stmt = $db->prepare("SELECT UserName, Password FROM users WHERE Username=? AND Password=? AND GroupID=1");
        $stmt->execute(array($username, $hashedPass));
        $count = $stmt->rowCount();

        //if count>0 this means the user is found in database
        if($count>0){
            $_SESSION['userName'] = $username; //Register Session Name
            header('Location: dashboard.php'); //Redirect to dashboard
            exit();
        }
    }
?>

<!-- Login Form -->
<form class='login' action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <h4 class='text-center'>Admin Login</h4>
    <input class='form-control' type='text' name='user' placeholder='Username' autocomplete='off'/>
    <input class='form-control' type='password' name='pass' placeholder='Password' autocomplete='new-password'/>
    <input class='btn btn-primary btn-block' type='submit' value='Login'/>
</form>
<!-- End Login Form -->

<?php 
    include $tpl."footer.php";
?>