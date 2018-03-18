<?php
  require_once("../includes/header.php");
?>
<?php
  include("../includes/message.php");
?>

<form class="form-signin" method="POST" action="../main/index.php?controller=default&action=loginprocess">
  <h2 class="form-signin-heading">Please sign in</h2>
  <label>Username</label>
  <input type="text" placeholder="username" required autofocus name="username" class="form-control" value="<?php echo(htmlspecialchars($username)); ?>" />
  <label >Password</label>
  <input type="password" placeholder="password" required name="password" class="form-control" value="<?php echo(htmlspecialchars($password)); ?>"/>
  <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
</form>
<form class="form-signin" method="POST" action="../main/index.php?controller=default&action=selfadd">
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
</form>
<?php
  require_once("../includes/footer.php");
?>

