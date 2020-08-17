<?php
    
    function lang($phrase){
        static $lang = array(

            // Welcome Message
            'MESSAGE' => 'اهلا',
            'ADMIN' => 'بالمدير',

            //Admin Navbar
            'Admin_Home' => 'الرئيسية',
            'Categories' => 'الأقسام',
            'ITEMS' => 'العناصر',
            'MEMBERS' => 'الأعضاء',
            'STATISTICS' => 'احصائيات',
            'LOGS' => 'السجل',
            'Admin_Name' => 'عثمان',
            'Edit_Profile' => 'تعديل الحساب',
            'Settings' => 'الاعدادات',
            'Log_Out' => 'تسجيل الخروج'
        );
        return $lang[$phrase];
    }

?>