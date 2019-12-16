<?php
  require_once("../includes/header.php");
?>
    <div class="container">
<?php if (isset($exerciseId)) { ?>
      <h1>Edit Exercise</h1>
      <hr />
<?php } else { ?>
      <h1>Add Exercise</h1>
      <hr />
<?php } ?>
<?php
  include("../includes/message.php");
?>
      <form method="POST" action="<?php echo("../main/index.php?controller=exercise&action=exerciseprocessaddedit"); ?>">
<?php if (isset($exerciseId)) { ?>
        <input type="hidden" name="exerciseid" value="<?php echo(htmlspecialchars($exerciseId)); ?>" class="form-control" />
<?php } ?>
        <input type="hidden" name="dayid" value="<?php echo(htmlspecialchars($dayId)); ?>" class="form-control" />
        <div class="form-group row">
          <label class="col-sm-1 col-form-label">Title:</label>
          <div class="col-sm-2">
            <input type="text" name="title" value="<?php echo(htmlspecialchars($title)); ?>" class="form-control" placeholder="Title of exercise" required autofocus />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label">Lift:</label>
          <div class="col-sm-2">
            <select class="form-control" name="liftid" autofocus>
              <option></option>
<?php foreach ($lifts as $lift) { ?>
              <option value="<?php echo(htmlspecialchars($lift->getId())); ?>"<?php if ($liftId == $lift->getId()) { echo(" selected"); } ?>><?php echo(htmlspecialchars($lift->getTitle())); ?></option>
<?php } ?>
            </select>
          </div>
        </div>

        <div class="form-group row">
          <button class="col-sm-1 btn btn-primary" type="submit">
<?php if (isset($exerciseId)) { ?>
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

