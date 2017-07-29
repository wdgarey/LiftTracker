<?php
    include($paths->GetHeaderIncludeFile());
?>
<?php
    if (isset($message))
    {
        include($paths->GetMessageIncludeFile());
    }
?>
<form class="form-signin" method="POST" action="<?php echo($this->GetUrl($actions->GetSelfEditAction())); ?>">
    <input type="hidden" id="<?php echo($idIdentifier); ?>" value="<?php echo($id); ?>" />
    <label>First Name</label>
    <input type="text" value="<?php echo($this->GetHtmlSafeText($firstName)); ?>" class="form-control" disabled/>
    <label>Last Name</label>
    <input type="text" value="<?php echo($this->GetHtmlSafeText($lastName)); ?>" class="form-control" disabled />
    <label>Email</label>
    <input type="email" value="<?php echo($this->GetHtmlSafeText($email)); ?>" class="form-control" disabled />
    <label>Username</label>
    <input type="text" value="<?php echo($this->GetHtmlSafeText($userName)); ?>" class="form-control" disabled />
    
    <button class="btn btn-lg btn-primary btn-block" type="submit">Edit</button>
</form>
<?php
    include($paths->GetFooterIncludeFile());
?>