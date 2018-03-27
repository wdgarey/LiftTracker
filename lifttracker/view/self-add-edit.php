<?php
  require_once("../model/default-controller.php");
  require_once("../includes/header.php");
?>

<?php if (DefaultController::getInstance()->isLoggedIn()) { ?>
      <h1>Edit Profile</h1>
      <hr />
<?php } else { ?>
      <h1>Create Account</h1>
      <hr />
<?php } ?>
<?php
  include("../includes/message.php");
?>
      <form method="POST" action="<?php echo("../main/index.php?controller=default&action=selfprocessaddedit"); ?>">
<?php if (!DefaultController::getInstance()->isLoggedIn()) { ?>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Username</label>
          <div class="col-sm-4">
            <input type="text" name="username" value="<?php echo(htmlspecialchars($username)); ?>" class="form-control" placeholder="Username" required autofocus />
          </div>
        </div>
<?php } ?>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">First Name</label>
          <div class="col-sm-4">
            <input type="text" name="firstname" value="<?php echo(htmlspecialchars($firstName)); ?>" class="form-control" placeholder="First" required autofocus />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Last Name</label>
          <div class="col-sm-4">
            <input type="text" name="lastname" value="<?php echo(htmlspecialchars($lastName)); ?>" class="form-control" placeholder="Last" required autofocus />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Height (in inches)</label>
          <div class="col-sm-2">
            <input type="number" name="height" value="<?php if (isset($height)) { echo(htmlspecialchars($height)); } ?>" class="form-control" placeholder="72" required autofocus />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Weight (in pounds)</label>
          <div class="col-sm-2">
            <input type="number" name="weight" value="<?php if (isset ($weight)) { echo(htmlspecialchars($weight)); } ?>" class="form-control" placeholder="180" required autofocus />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Email</label>
          <div class="col-sm-4">
            <input type="email" name="email" value="<?php echo(htmlspecialchars($email)); ?>" class="form-control" placeholder="Email" required autofocus />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Password</label>
          <div class="col-sm-4">
            <input type="password" name="password" class="form-control" placeholder="Password" <?php if (!DefaultController::getInstance()->isLoggedIn()) { echo("required"); } ?> />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Password Retype</label>
          <div class="col-sm-4">
            <input type="password" name="passwordretype" class="form-control" placeholder="Password Retype" <?php if (!DefaultController::getInstance()->isLoggedIn()) { echo("required"); } ?> />
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-6">
            <button class="col-sm-2 btn btn-primary pull-right" type="submit">
<?php if (DefaultController::getInstance()->isLoggedIn()) { ?>
              Update
<?php } else { ?>
              Sign up
<?php } ?>
            </button>
          </div>
        </div>
      </form>
<?php
  require_once("../includes/footer.php");
?>
