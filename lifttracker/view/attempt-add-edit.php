<?php
  require_once("../includes/header.php");
?>
    <div class="container">
<?php if (isset($attemptId)) { ?>
      <h1>Edit Lift</h1>
      <hr />
<?php } else { ?>
      <h1>Add Lift</h1>
      <hr />
<?php } ?>
<?php
  include("../includes/message.php");
?>
      <form method="POST" action="<?php echo("../main/index.php?controller=attempt&action=attemptprocessaddedit"); ?>">
<?php if (isset($attemptId)) { ?>
        <input type="hidden" name="attemptid" value="<?php echo(htmlspecialchars($attemptId)); ?>" class="form-control" />
<?php } ?>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Lift</label>
          <div class="col-sm-4">
            <select class="form-control" name="liftid" required autofocus>
<?php foreach ($lifts as $lift) { ?>
              <option value="<?php echo(htmlspecialchars($lift->getId())); ?>"<?php if ($liftId == $lift->getId()) { echo(" selected"); } ?>><?php echo(htmlspecialchars($lift->getTitle())); ?></option>
<?php } ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Date</label>
          <div class="col-sm-2">
            <input type="date" name="occurrence" value="<?php echo(htmlspecialchars($occurrence)); ?>" class="form-control" placeholder="Date of attempt" required autofocus />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Weight</label>
          <div class="col-sm-2">
            <input type="number" name="weight" value="<?php echo(htmlspecialchars($weight)); ?>" class="form-control" placeholder="135" required autofocus />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Reps</label>
          <div class="col-sm-2">
            <input type="number" name="reps" value="<?php echo(htmlspecialchars($reps)); ?>" class="form-control" placeholder="5" required autofocus />
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-6">
            <button class="col-sm-2 btn btn-primary pull-right" type="submit">
<?php if (isset($attemptId)) { ?>
              Update
<?php } else { ?>
              Add 
<?php } ?>
            </button>
          </div>
        </div>
      </form>
    </div>
<?php
  require_once("../includes/footer.php");
?>

