<nav class="navbar navbar-inverse">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><?php echo lang('Admin_Home') ?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav">
        <li><a href="#"><?php echo lang('Categories') ?></a></li>
        <li><a href="#"><?php echo lang('ITEMS') ?></a></li>
        <li><a href="#"><?php echo lang('MEMBERS') ?></a></li>
        <li><a href="#"><?php echo lang('STATISTICS') ?></a></li>
        <li><a href="#"><?php echo lang('LOGS') ?></a></li>
      </ul> 
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo lang('Admin_Name') ?><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="members.php?do=Edit&userid=<?php echo $_SESSION['ID'] ?>"><?php echo lang('Edit_Profile') ?></a></li>
            <li><a href="#"><?php echo lang('Settings') ?></a></li>
            <li><a href="logout.php"><?php echo lang('Log_Out') ?></a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>