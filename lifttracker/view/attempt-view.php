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
        <label class="col-sm-2 col-form-label">Lift</label>
        <div class="col-sm-4">
          <a href="../main/index.php?controller=lift&action=liftview&liftid=<?php echo(htmlspecialchars($liftId)); ?>"><?php echo(htmlspecialchars($liftTitle)); ?></a>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Weight</label>
        <div class="col-sm-2">
          <input class="form-control" type="text" value="<?php echo(htmlspecialchars($weight)); ?>" readonly />
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Reps</label>
        <div class="col-sm-2">
          <input class="form-control" type="text" value="<?php echo(htmlspecialchars($reps)); ?>" readonly />
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Date</label>
        <div class="col-sm-2">
          <input class="form-control" type="text" value="<?php echo(htmlspecialchars(Utils::toDisplayDate($occurrence))); ?>" readonly />
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-6">
          <form method="POST" action="<?php echo("../main/index.php?controller=attempt&action=attemptdelete"); ?>">
            <input type="hidden" name="attemptid" value="<?php echo(htmlspecialchars($attemptId)); ?>" class="form-control" />
            <button class="col-sm-2 btn btn-primary pull-left" data-toggle="confirmation" type="submit">Delete</button>
          </form>
          <form method="POST" action="<?php echo("../main/index.php?controller=attempt&action=attemptedit"); ?>">
            <input type="hidden" name="attemptid" value="<?php echo(htmlspecialchars($attemptId)); ?>" class="form-control" />
            <button class="col-sm-2 btn btn-primary pull-left" type="submit">Edit</button>
          </form>
          <form method="POST" action="<?php echo("../main/index.php?controller=attempt&action=attemptsview"); ?>">
            <button class="col-sm-2 btn btn-primary pull-left" type="submit">Attempts</button>
          </form>
        </div>
      </div>
    </div>
<?php
  require_once("../includes/footer.php");
?>

