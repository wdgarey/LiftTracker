<?php
  require_once("../includes/header.php");
?>
    <div class="container">
<?php if (isset($weekId)) { ?>
      <h1>Edit Week</h1>
      <hr />
<?php } else { ?>
      <h1>Add Week</h1>
      <hr />
<?php } ?>
<?php
  include("../includes/message.php");
?>
      <form method="POST" action="<?php echo("../main/index.php?controller=week&action=weekprocessaddedit"); ?>">
<?php if (isset($weekId)) { ?>
        <input type="hidden" name="weekid" value="<?php echo(htmlspecialchars($weekId)); ?>" class="form-control" />
<?php } ?>
        <input type="hidden" name="planid" value="<?php echo(htmlspecialchars($planId)); ?>" class="form-control" />
        <div class="form-group row">
          <label class="col-sm-1 col-form-label">Title:</label>
          <div class="col-sm-2">
            <input type="text" name="title" value="<?php echo(htmlspecialchars($title)); ?>" class="form-control" placeholder="Title of week" required autofocus />
          </div>
        </div>
        <div class="form-group row">
          <button class="col-sm-1 btn btn-primary" type="submit">
<?php if (isset($weekId)) { ?>
            Update
<?php } else { ?>
            Add 
<?php } ?>
          </button>
        </div>
      </form>
    </div>
<?php
  require_once("../includes/footer.php");
?>

