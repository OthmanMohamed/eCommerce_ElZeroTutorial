<?php
    
    function lang($phrase){
        static $lang = array(

            //Welcome Message
            'MESSAGE' => 'Welcome',
            'ADMIN' => 'Administrator',

            //Admin Navbar
            'Admin_Home' => 'Home',
            'Categories' => 'Categories',
            'ITEMS' => 'Items',
            'MEMBERS' => 'Members',
            'STATISTICS' => 'Statistics',
            'LOGS' => 'Logs',
            'Admin_Name' => 'Othman',
            'Edit_Profile' => 'Edit Profile',
            'Settings' => 'Settings',
            'Log_Out' => 'Log_Out'
        );
        return $lang[$phrase];
    }

?>