<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            if (!isset($dCharset)) { $dCharset = "UTF-8"; }
            if (!isset($dDescription)) { $dDescription = "A sports pool."; }
            if (!isset($dTags) || !is_array($dTags)) { $dTags = array("sports", "pool"); }
            if (!isset($dAuthor)) { $dAuthor = "Wesley Garey"; }
            if (!isset($dTitle)) { $dTitle = "The Sports Pool"; }

            $tags = "";
            foreach ($dTags as $tag)
            {
                $tags .= $tag . " ";
            }
        ?>

        <meta charset='<?php echo($dCharset); ?>' />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name='description' content='<?php echo($dDescription); ?>' />
        <meta name='keywords' content='<?php echo($tags); ?>' />
        <meta name='author' content='<?php echo($dAuthor); ?>' />

        <title><?php echo($dTitle); ?></title>

        <link rel='shortcut icon' href='<?php echo($paths->GetIconFile()); ?>' />

        <link rel='stylesheet' href='<?php echo($paths->GetCssFile()); ?>' />
        <link rel='stylesheet' href='<?php echo($paths->GetBootStrapCssFile()); ?>' />
        
        <script type='text/javascript' src='<?php echo($paths->GetJQueryFile()); ?>'></script>
        <script type='text/javascript' src='<?php echo($paths->GetJSFile()); ?>'></script>
        <script type='text/javascript' src='<?php echo($paths->GetJQueryTableSorterFile()); ?>'></script>
        <script type='text/javascript' src='<?php echo($paths->GetJQueryValidateFile()); ?>'></script>
        <script type='text/javascript' src='<?php echo($paths->GetBootstrapJSFile()); ?>'></script>
    </head>
    <body>
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
                <a class="navbar-brand" href="#">The Sports Pool</a>
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
                    <?php if (!$this->IsUserLoggedIn()) { ?>
                        <li><a href="<?php echo($this->GetUrl($this->GetActions()->GetLoginAction())); ?>">Login/Sign-up</a></li>
                    <?php } else { ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo($this->GetHtmlSafeText($this->GetUser()->GetUsername())); ?><span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo($this->GetUrl($this->GetActions()->GetSelfViewAction())); ?>">Profile</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo($this->GetUrl($this->GetActions()->GetLogoutAction())); ?>">Logout</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
              </div><!--/.nav-collapse -->
            </div>
          </nav>
          <div class="container">
                