<?php
    include($paths->GetHeaderIncludeFile());
?>
<?php
    if (isset($message))
    {
        include($paths->GetMessageIncludeFile());
    }
?>

<form class="form-signin" method="POST" action="<?php echo($this->GetUrl($actions->GetProcessLoginAction())); ?>">
    <h2 class="form-signin-heading">Please sign in</h2>
    <input type="hidden" name="<?php echo($requestedPageIdentifier); ?>" value="<?php echo($requestedPage); ?>" />
    <label >Username</label>
    <input type="text" placeholder="Username" required autofocus name="<?php echo($userNameIdentifier); ?>" class="form-control" value="<?php echo($this->GetHtmlSafeText($userName)); ?>" />
    <label >Password</label>
    <input type="password" placeholder="Password" required name="<?php echo($passwordIdentifier); ?>" class="form-control" value="<?php echo($this->GetHtmlSafeText($password)); ?>"/>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
</form>

<form class="form-signin" method="POST" action="<?php echo($this->GetUrl($actions->GetSelfAddAction())); ?>">
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
</form>
<?php
    include($paths->GetFooterIncludeFile());
?>