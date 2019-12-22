<?php
  require_once("../includes/header.php");
?>
    <div class="container">
<?php if (isset($setId)) { ?>
      <h1>Edit Set</h1>
      <hr />
<?php } else { ?>
      <h1>Add Set</h1>
      <hr />
<?php } ?>
<?php
  include("../includes/message.php");
?>
      <form method="POST" action="<?php echo("../main/index.php?controller=set&action=setprocessaddedit"); ?>">
<?php if (isset($setId)) { ?>
        <input type="hidden" name="setid" value="<?php echo(htmlspecialchars($setId)); ?>" class="form-control" />
<?php } ?>
        <input type="hidden" name="exerciseid" value="<?php echo(htmlspecialchars($exerciseId)); ?>" class="form-control" />
        <div class="form-group row">
          <label class="col-sm-1 col-form-label">Title:</label>
          <div class="col-sm-2">
            <input type="text" name="title" value="<?php echo(htmlspecialchars($title)); ?>" class="form-control" placeholder="Title of set" required autofocus />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label">Percentage:</label>
          <div class="col-sm-2">
            <input type="number" name="percent" value="<?php echo(htmlspecialchars($percent)); ?>" class="form-control" placeholder="50" min="0" max="200" step="any" required autofocus />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label">Reps:</label>
          <div class="col-sm-2">
            <input type="number" name="reps" value="<?php echo(htmlspecialchars($reps)); ?>" class="form-control" placeholder="5" required autofocus />
          </div>
        </div>
        <div class="form-group row">
          <button class="btn btn-primary" type="submit">
<?php if (isset($setId)) { ?>
            Update
<?php } else { ?>
            Add 
<?php } ?>
          </button>
<?php if (isset($planId)) { ?>
          <a class="btn btn-primary" href="../main/index.php?controller=plan&action=planview&planid=<?php echo(htmlspecialchars($planId)); ?>">View Plan</a>
<?php } ?>
        </div>
      </form>
    </div>
<?php
  require_once("../includes/footer.php");
?>

