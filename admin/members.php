<?php

/*
    ============================================================================
    == Members Manage Page
    == You can Add | Edit | Delete members from here
    ============================================================================
    */

session_start();
$pageTitle = 'Members';

if (isset($_SESSION['userName'])) {
    include "init.php";
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    if ($do == "Manage") { //Manage members page

        $query = '';
        if (isset($_GET['page']) && $_GET['page'] = 'pending') {
            $query = 'AND RegStatus = 0';
        }

        //Select all users except admins (userid=1 for admin)
        $stmt = $db->prepare("SELECT * FROM users WHERE GroupID != 1 $query");
        $stmt->execute();
        $rows = $stmt->fetchAll(); ?>
        <h1 class='text-center'>Manage Members</h1>
        <div class='container'>
            <div class='table-responsive'>
                <table class='main-table text-center table table-bordered'>
                    <tr>
                        <td>#ID</td>
                        <td>UserName</td>
                        <td>Email</td>
                        <td>Full Name</td>
                        <td>Register Date</td>
                        <td>Control</td>
                    </tr>
                    <?php
                    foreach ($rows as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['UserID'] . "</td>";
                        echo "<td>" . $row['UserName'] . "</td>";
                        echo "<td>" . $row['Email'] . "</td>";
                        echo "<td>" . $row['FullName'] . "</td>";
                        echo "<td>" . $row['Date'] . "</td>";
                        echo "<td>
                                        <a href='members.php?do=Edit&userid=" . $row['UserID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                        <a href='members.php?do=Delete&userid=" . $row['UserID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
                        if ($row['RegStatus'] == 0) {
                            echo   "<a href='members.php?do=Activate&userid=" . $row['UserID'] . "' class='btn btn-info activate'><i class='fa fa-edit'></i> Activate</a>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    } ?>
                </table>
            </div>
            <a href="members.php?do=Add" class='btn btn-primary'><i class='fa fa-plus'></i> New Member</a>
        </div>

    <?php
    } elseif ($do == "Add") { //Add members page
    ?>
        <h1 class='text-center'>Add New Member</h1>
        <div class='container'>
            <form class='form-horizontal' action="?do=Insert" method="POST">
                <!-- Start Username Field -->
                <div class='form-group form-group-lg'>
                    <label class='col-sm-2 control-label'>UserName</label>
                    <div class='col-sm-10 col-md-6'>
                        <input type='text' name='username' class='form-control' autocomplete='off' required='required' placeholder="User Name to Login" />
                    </div>
                </div>
                <!-- End Username Field -->
                <!-- Start Password Field -->
                <div class='form-group form-group-lg'>
                    <label class='col-sm-2 control-label'>Password</label>
                    <div class='col-sm-10 col-md-6'>
                        <input type='password' name='password' class='form-control password' autocomplete='new-password' required='required' placeholder="Choose new password" />
                        <i class="show-pass fa fa-eye fa-2x"></i>
                    </div>
                </div>
                <!-- End Password Field -->
                <!-- Start Email Field -->
                <div class='form-group form-group-lg'>
                    <label class='col-sm-2 control-label'>Email</label>
                    <div class='col-sm-10 col-md-6'>
                        <input type='email' name='email' class='form-control' required='required' placeholder="Enter valid email" />
                    </div>
                </div>
                <!-- End Email Field -->
                <!-- Start Full name Field -->
                <div class='form-group form-group-lg'>
                    <label class='col-sm-2 control-label'>Full Name</label>
                    <div class='col-sm-10 col-md-6'>
                        <input type='text' name='full' class='form-control' required='required' placeholder="Full Name shown in profile" />
                    </div>
                </div>
                <!-- End Full name Field -->
                <!-- Start Submit Field -->
                <div class='form-group form-group-lg'>
                    <div class='col-sm-offset-2 col-sm-10 col-md-6'>
                        <input type='submit' value='Add Member' class='btn btn-primary btn-lg' />
                    </div>
                </div>
                <!-- End Submit Field -->
            </form>
        </div> <?php

            } elseif ($do == "Insert") { //Insert Page
                ?>
        <h1 class='text-center'>Insert Member</h1>
        <div class='container'>
            <?php

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    //get variables from the form
                    $user   = $_POST['username'];
                    $pass   = $_POST['password'];
                    $email  = $_POST['email'];
                    $name   = $_POST['full'];
                    $hashPass = sha1($pass);

                    //Validate the form
                    $formErrors = array();
                    if (empty($user)) {
                        $formErrors[] = 'User Name Can\'t be <strong>empty</strong>';
                    }
                    if (strlen($user) < 4) {
                        $formErrors[] = 'User Name Can\'t be less than <strong>4 characters</strong>';
                    }
                    if (strlen($user) > 20) {
                        $formErrors[] = 'User Name Can\'t be more than <strong>20 characters</strong>';
                    }
                    if (empty($pass)) {
                        $formErrors[] =  'Password Can\'t be <strong>empty</strong>';
                    }
                    if (empty($name)) {
                        $formErrors[] =  'Full Name Can\'t be <strong>empty</strong>';
                    }
                    if (empty($email)) {
                        $formErrors[] =  'Email Can\'t be <strong>empty</strong>';
                    }

                    foreach ($formErrors as $error) {
                        echo "<div class='alert alert-danger'>" . $error . "</div>";
                    }

                    //Insert new user into the database, after checking there is no errors
                    if (empty($formErrors)) {

                        //check if username exists in database
                        $check = checkItem("UserName", "users", $user);
                        if ($check == 1) {
                            redirectHome("<div class='alert alert-danger'>Sorry username already exists</div>", 'back', 5);
                        } else {
                            //RegStatus one because the member will be directly registered if added by the admin (like confirmation status)
                            $stmt = $db->prepare("INSERT INTO users(UserName, Password, Email, FullName, RegStatus, Date) 
                            VALUES(:newuser, :newpass, :newemail, :newfull, 1, now())");
                            $stmt->execute(array(
                                'newuser' => $user,
                                'newpass' => $hashPass,
                                'newemail' => $email,
                                'newfull' => $name
                            ));
                            //Echo success message
                            $msg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Updated</div>";
                            redirectHome($msg, 'back', 5);
                        }
                    }
                } else {
                    $errorMsg = "<div class = 'alert alert-danger'>You can't browse this page directly</div>";
                    redirectHome($errorMsg, 'back');
                }

                echo "</div>";
            } elseif ($do == "Edit") {

                //check if get request user id is number and get its numeric value
                $userid =  (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) : 0;

                //select data from database using the userid
                $stmt = $db->prepare("SELECT * FROM users WHERE UserID=? LIMIT 1");
                $stmt->execute(array($userid)); //execute query
                $row = $stmt->fetch(); //fetch data
                $count = $stmt->rowCount();

                //show the form if the id exists in the database
                if ($count > 0) {
            ?>
                <h1 class='text-center'>Edit Member</h1>
                <div class='container'>
                    <form class='form-horizontal' action="?do=Update" method="POST">
                        <!-- hidden input to pass the user id with the form -->
                        <input type='hidden' name='userid' value='<?php echo $userid ?>'>
                        <!-- Start Username Field -->
                        <div class='form-group form-group-lg'>
                            <label class='col-sm-2 control-label'>UserName</label>
                            <div class='col-sm-10 col-md-6'>
                                <input type='text' name='username' class='form-control' value='<?php echo $row['UserName'] ?>' autocomplete='off' required='required' />
                            </div>
                        </div>
                        <!-- End Username Field -->
                        <!-- Start Password Field -->
                        <div class='form-group form-group-lg'>
                            <label class='col-sm-2 control-label'>Password</label>
                            <div class='col-sm-10 col-md-6'>
                                <input type='hidden' name='oldpassword' value='<?php echo $row['Password'] ?>' />
                                <input type='password' name='newpassword' class='form-control password' autocomplete='new-password' placeholder="Leave blank if you dont want to update" />
                                <i class="show-pass fa fa-eye fa-2x"></i>
                            </div>
                        </div>
                        <!-- End Password Field -->
                        <!-- Start Email Field -->
                        <div class='form-group form-group-lg'>
                            <label class='col-sm-2 control-label'>Email</label>
                            <div class='col-sm-10 col-md-6'>
                                <input type='email' name='email' class='form-control' value='<?php echo $row['Email'] ?>' required='required' />
                            </div>
                        </div>
                        <!-- End Email Field -->
                        <!-- Start Full name Field -->
                        <div class='form-group form-group-lg'>
                            <label class='col-sm-2 control-label'>Full Name</label>
                            <div class='col-sm-10 col-md-6'>
                                <input type='text' name='full' class='form-control' value='<?php echo $row['FullName'] ?>' required='required' />
                            </div>
                        </div>
                        <!-- End Full name Field -->
                        <!-- Start Submit Field -->
                        <div class='form-group form-group-lg'>
                            <div class='col-sm-offset-2 col-sm-10 col-md-6'>
                                <input type='submit' value='Save' class='btn btn-primary btn-lg' />
                            </div>
                        </div>
                        <!-- End Submit Field -->
                    </form>
                </div> <?php

                        //if there is no such id, show error msg
                    } else {
                        $errorMsg = "<div class='alert alert-danger'>No user found with id $userid</div>";
                        redirectHome($errorMsg, 6);
                    }
                } elseif ($do == "Update") {  //Update page

                        ?>
            <h1 class='text-center'>Update Member</h1>
            <div class='container'>
                <?php

                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                        //get variables from the form
                        $id     = $_POST['userid'];
                        $user   = $_POST['username'];
                        $email  = $_POST['email'];
                        $name   = $_POST['full'];

                        //Password Update
                        $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

                        //Validate the form
                        $formErrors = array();
                        if (empty($user)) {
                            $formErrors[] = 'User Name Can\'t be <strong>empty</strong>';
                        }
                        if (strlen($user) < 4) {
                            $formErrors[] = 'User Name Can\'t be less than <strong>4 characters</strong>';
                        }
                        if (strlen($user) > 20) {
                            $formErrors[] = 'User Name Can\'t be more than <strong>20 characters</strong>';
                        }
                        if (empty($name)) {
                            $formErrors[] =  'Full Name Can\'t be <strong>empty</strong>';
                        }
                        if (empty($email)) {
                            $formErrors[] =  'Email Can\'t be <strong>empty</strong>';
                        }

                        foreach ($formErrors as $error) {
                            echo "<div class='alert alert-danger'>" . $error . "</div>";
                        }

                        //Update the database with the new values, after checking there is no errors
                        if (empty($formErrors)) {
                            $stmt = $db->prepare("UPDATE users SET Username=?, Email=?, FullName=?, Password=? WHERE UserID=?");
                            $stmt->execute(array($user, $email, $name, $pass, $id));

                            //Echo success message
                            $msg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Updated </div>";
                            redirectHome($msg, 'back');
                        }
                    } else {
                        $errorMsg = "<div class='alert alert-danger'>You can't browse this page directly</div>";
                        redirectHome($errorMsg);
                    }

                    echo "</div>";
                } elseif ($do == 'Delete') { //Delete Members Page

                ?>
                <h1 class='text-center'>Delete Member</h1>
                <div class='container'>
                    <?php

                    //check if get request user id is number and get its numeric value
                    $userid =  (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) : 0;

                    //select data from database using the userid
                    $stmt = $db->prepare("SELECT * FROM users WHERE UserID=? LIMIT 1");
                    $check = checkItem('UserID', 'users', $userid);

                    //check if there already exists user with this id
                    if ($check > 0) {
                        $stmt = $db->prepare("DELETE FROM users WHERE UserID = :userid");
                        $stmt->bindParam(":userid", $userid);
                        $stmt->execute();

                        $msg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Deleted</div>";
                        redirectHome($msg, 'back');
                    } else {
                        $errorMsg = "<div class='alert alert-danger'>No user found with id $userid</div>";
                        redirectHome($errorMsg, 'back');
                    }

                    echo "</div>";
                } elseif ($do == 'Activate') { //Delete Members Page


                    ?>
                    <h1 class='text-center'>Delete Member</h1>
                    <div class='container'>
                <?php
                    //check if get request user id is number and get its numeric value
                    $userid =  (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) : 0;

                    //select data from database using the userid
                    $stmt = $db->prepare("SELECT * FROM users WHERE UserID=? LIMIT 1");
                    $check = checkItem('UserID', 'users', $userid);

                    //check if there already exists user with this id
                    if ($check > 0) {
                        $stmt = $db->prepare("UPDATE users SET RegStatus=1 WHERE UserID = $userid");
                        // $stmt->bindParam(":userid", $userid);
                        $stmt->execute();

                        $msg = "<div class='alert alert-success'>" . $stmt->rowCount() . " User activated </div>";
                        redirectHome($msg, 'back');
                    } else {
                        $errorMsg = "<div class='alert alert-success'>No user found with id $userid</div>";
                        redirectHome($errorMsg, 'back');
                    }

                    echo "</div>";
                }

                include $tpl . "footer.php";
            } else {
                echo 'You are not authorised to view this page';
                header('Location: index.php');
                exit();
            }
