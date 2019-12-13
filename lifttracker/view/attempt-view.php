<?php
  require_once("../includes/header.php");
?>
    <div class="container">
      <h1>View Attempt</h1>
      <hr />
<?php
  include("../includes/message.php");
?>
      <div class="form-group row">
        <label class="col-sm-1 col-form-label">Lift:</label>
        <div class="col-sm-2">
          <a href="../main/index.php?controller=lift&action=liftview&liftid=<?php echo(htmlspecialchars($liftId)); ?>"><?php echo(htmlspecialchars($liftTitle)); ?></a>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-1 col-form-label">Weight:</label>
        <span class="col-sm-2"><?php echo(htmlspecialchars($weight)); ?></span>
      </div>
      <div class="form-group row">
        <label class="col-sm-1 col-form-label">Reps:</label>
        <span class="col-sm-2"><?php echo(htmlspecialchars($reps)); ?></span>
      </div>
      <div class="form-group row">
        <label class="col-sm-1 col-form-label">Date:</label>
        <span class="col-sm-2"><?php echo(htmlspecialchars(Utils::toDisplayDate($occurrence))); ?></span>
      </div>
      <div class="form-group row">
        <a class="btn btn-primary" href="../main/index.php?controller=attempt&action=attemptedit&attemptid=<?php echo(htmlspecialchars($attemptId)); ?>">Edit Attempt</a>
        <a class="btn btn-primary" data-toggle="confirmation" href="../main/index.php?controller=attempt&action=attemptdelete&attemptid=<?php echo(htmlspecialchars($attemptId)); ?>">Delete Attempt</a>
      </div>
    </div>
<?php
  require_once("../includes/footer.php");
?>

