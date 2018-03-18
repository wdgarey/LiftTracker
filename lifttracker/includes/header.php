<!DOCTYPE html>
<html lang="en">
  <head>
    <?php
      require_once("../model/default-controller.php");

      if (!isset($dCharset)) { $dCharset = "UTF-8"; }
      if (!isset($dDescription)) { $dDescription = "A web app used for lifting."; }
      if (!isset($dTags) || !is_array($dTags)) { $dTags = array("lift", "tracker", "lifttracker"); }
      if (!isset($dAuthor)) { $dAuthor = "Wesley Garey"; }
      if (!isset($dTitle)) { $dTitle = "Lift Tracker"; }

      $tags = "";
      foreach ($dTags as $tag) {
        $tags .= $tag . " ";
      }
    ?>
    <meta charset="<?php echo($dCharset); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="<?php echo($dDescription); ?>" />
    <meta name="keywords" content="<?php echo($tags); ?>" />
    <meta name="author" content="<?php echo($dAuthor); ?>" />

    <title><?php echo($dTitle); ?></title>

    <link rel="shortcut icon" href="../images/Ah_icon.ico" />

    <link rel="stylesheet" href="../css/stylesheet.css" />
    <link rel="stylesheet" href="../css/bootstrap.css" />
        
    <script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="../js/javascript.js"></script>
    <script type="text/javascript" src="../js/jquery.tablesorter.js"></script>
    <script type="text/javascript" src="../js/jquery.validate.js"></script>
    <script type="text/javascript" src="../js/bootstrap.js"></script>
  </head>
  <body>
    <?php if (DefaultController::getInstance()->isLoggedIn ()) { ?>
    <div class="navbar-space"> </div>
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Lift Tracker</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo(htmlspecialchars(DefaultController::getInstance()->getUser()->getFirstName())); ?><span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="../main/index.php?controller=default&action=selfedit">Profile</a></li>
                <li class="divider"></li>
                <li><a href="../main/index.php?controller=default&action=logout">Logout</a></li>
              </ul>
            </li>
            <li><a href="../main/index.php?controller=default&action=logout">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <?php } ?>
    <div class="container">
<!-- Begin content here -->             
