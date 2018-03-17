<?php
  require_once("../model/default-controller.php");
  require_once("../includes/header.php");
?>

<?php if (DefaultController::getInstance()->isLoggedIn()) { ?>
      <h1>Edit Profile</h1>
<?php } else { ?>
      <h1>Create Account</h1>
<?php } ?>
      <form class="form-signin" method="POST" action="<?php echo("../main/index.php?controller=default&action=signupprocess"); ?>">
<?php if (!DefaultController::getInstance()->isLoggedIn()) { ?>
        <label>Username</label>
        <input type="text" name="username" value="<?php echo(htmlspecialchars($userName)); ?>" class="form-control" placeholder="Username" required autofocus />
<?php } ?>
        <label>First Name</label>
        <input type="text" name="firstname" value="<?php echo(htmlspecialchars($firstName)); ?>" class="form-control" placeholder="First" required autofocus />
        <label>Last Name</label>
        <input type="text" name="lastname" value="<?php echo(htmlspecialchars($lastName)); ?>" class="form-control" placeholder="Last" required autofocus />
        <label>Height (in inches)</label>
        <input type="number" name="height" value="<?php if (isset($height)) { echo(htmlspecialchars($height)); } ?>" class="form-control" placeholder="72" required autofocus />
        <label>Weight (in pounds)</label>
        <input type="number" name="weight" value="<?php if (isset ($weight)) { echo(htmlspecialchars($weight)); } ?>" class="form-control" placeholder="180" required autofocus />
        <label>Email</label>
        <input type="email" name="email" value="<?php echo(htmlspecialchars($email)); ?>" class="form-control" placeholder="Email" required autofocus />
        <label>Password</label>
        <input type="password" name="password" class="form-control" placeholder="Password" <?php if (!DefaultController::getInstance()->isLoggedIn()) { echo("required"); } ?> />
        <label>Password Retype</label>
        <input type="password" name="passwordretype" class="form-control" placeholder="Password Retype" <?php if (!DefaultController::getInstance()->isLoggedIn()) { echo("required"); } ?> />
        <button class="btn btn-lg btn-primary btn-block" type="submit">
<?php if (DefaultController::getInstance()->isLoggedIn()) { ?>
          Update
<?php } else { ?>
          Sign up
<?php } ?>
        </button>
      </form>
<?php
  require_once("../includes/footer.php");
?>
