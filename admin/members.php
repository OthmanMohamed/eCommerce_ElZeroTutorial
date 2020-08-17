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

        if ($do == "Manage"){

        } elseif ($do == "Edit"){
            
            //check if get request user id is number and get its numeric value
            $userid =  (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) : 0;
            
            //select data from database using the userid
            $stmt = $db->prepare("SELECT * FROM users WHERE UserID=? LIMIT 1");
            $stmt->execute(array($userid)); //execute query
            $row = $stmt->fetch(); //fetch data
            $count = $stmt->rowCount();

            //show the form if the id exists in the database   
            if($count>0){
                ?>
                <h1 class='text-center'>Edit Member</h1>
                <div class='container'>
                    <form class='form-horizontal'>
                        <!-- Start Username Field -->
                        <div class='form-group form-group-lg'>
                            <label class='col-sm-2 control-label'>UserName</label>
                            <div class='col-sm-10 col-md-6'>
                                <input type='text' name='username' class='form-control' value=<?php echo $row['UserName']?> autocomplete='off' />
                            </div>
                        </div>
                        <!-- End Username Field -->
                        <!-- Start Password Field -->
                        <div class='form-group form-group-lg'>
                            <label class='col-sm-2 control-label'>Password</label>
                            <div class='col-sm-10 col-md-6'>
                                <input type='password' name='password' class='form-control' autocomplete='new-password' />
                            </div>
                        </div>
                        <!-- End Password Field -->
                        <!-- Start Email Field -->
                        <div class='form-group form-group-lg'>
                            <label class='col-sm-2 control-label'>Email</label>
                            <div class='col-sm-10 col-md-6'>
                                <input type='email' name='email' class='form-control' value=<?php echo $row['Email']?>/>
                            </div>
                        </div>
                        <!-- End Email Field -->
                        <!-- Start Full name Field -->
                        <div class='form-group form-group-lg'>
                            <label class='col-sm-2 control-label'>Full Name</label>
                            <div class='col-sm-10 col-md-6'>
                                <input type='text' name='full' class='form-control' value=<?php echo $row['FullName']?>/>
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
                echo 'There is no such id';
            }
            }

        include $tpl."footer.php";

    } else {  

        echo 'You are not authorised to view this page';
        header('Location: index.php');
        exit();

    }