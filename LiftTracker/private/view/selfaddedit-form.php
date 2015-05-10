<?php
    include($paths->GetHeaderIncludeFile());
?>
<?php
    if (isset($message))
    {
        include($paths->GetMessageIncludeFile());
    }
?>
<form class="form-signin" method="POST" action="<?php echo($this->GetUrl($actions->GetProcessSelfAddEditAction())); ?>">
    <input type="hidden" id="<?php echo($idIdentifier); ?>" value="<?php echo($id); ?>" />
    <label>First Name</label>
    <input type="text" name="<?php echo($firstNameIdentifier); ?>" value="<?php echo($this->GetHtmlSafeText($firstName)); ?>" class="form-control" placeholder="First Name" required autofocus />
    <label>Last Name</label>
    <input type="text" name="<?php echo($lastNameIdentifier); ?>" value="<?php echo($this->GetHtmlSafeText($lastName)); ?>" class="form-control" placeholder="Last Name" required autofocus />
    <label>Email</label>
    <input type="email" name="<?php echo($emailIdentifier); ?>" value="<?php echo($this->GetHtmlSafeText($email)); ?>" class="form-control" placeholder="Email" required autofocus />
    
    <?php if ($id == 0) { ?>
        <label>Username</label>
        <input type="text" name="<?php echo($userNameIdentifier); ?>" value="<?php echo($this->GetHtmlSafeText($userName)); ?>" class="form-control" placeholder="Username" required autofocus />
    <?php } ?>
    
    <label>Password</label>
    <input type="password" name="<?php echo($passwordIdentifier); ?>" class="form-control" placeholder="Password" <?php if ($id == 0) { echo("required"); } ?> />
    <label>Password Retype</label>
    <input type="password" name="<?php echo($passwordRetypeIdentifier); ?>" class="form-control" placeholder="Password Retype" <?php if ($id == 0) { echo("required"); } ?> />
    
    <button class="btn btn-lg btn-primary btn-block" type="submit">
        <?php if ($id == 0) { ?>
            Sign up
        <?php } else { ?>
            Update
        <?php } ?>
    </button>
</form>
<?php
    include($paths->GetFooterIncludeFile());
?>