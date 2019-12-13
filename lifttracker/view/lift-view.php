<?php
  require_once("../includes/header.php");
?>
    <div class="container">
      <h1>View Lift</h1>
      <hr />
<?php
  include("../includes/message.php");
?>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Name</label>
        <div class="col-sm-4">
          <input class="form-control" type="text" value="<?php echo(htmlspecialchars($title)); ?>" readonly />
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Training Weight</label>
        <div class="col-sm-2">
          <input class="form-control" type="text" value="<?php echo(htmlspecialchars($trainingWeight)); ?>" readonly />
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-6">
          <form method="POST" action="<?php echo("../main/index.php?controller=lift&action=liftdelete"); ?>">
            <input type="hidden" name="liftid" value="<?php echo(htmlspecialchars($liftId)); ?>" class="form-control" />
            <button class="col-sm-2 btn btn-primary pull-left" data-toggle="confirmation" type="submit">Delete</button>
          </form>
          <form method="POST" action="<?php echo("../main/index.php?controller=lift&action=liftedit"); ?>">
            <input type="hidden" name="liftid" value="<?php echo(htmlspecialchars($liftId)); ?>" class="form-control" />
            <button class="col-sm-2 btn btn-primary pull-left" type="submit">Edit</button>
          </form>
          <form method="POST" action="<?php echo("../main/index.php?controller=lift&action=liftadd"); ?>">
            <button class="col-sm-2 btn btn-primary pull-left" type="submit">Add New</button>
          </form>
          <form method="POST" action="<?php echo("../main/index.php?controller=lift&action=liftsview"); ?>">
            <button class="col-sm-2 btn btn-primary pull-left" type="submit">Lifts</button>
          </form>
        </div>
      </div>
<?php if (count($attempts) == 0) { ?>
      <h2>No attempts yet? Add one <a href="../main/index.php?controller=attempt&action=attemptadd&liftid=<?php echo(htmlspecialchars($liftId)); ?>">here</a>.</h2>
<?php } else {?>
      <h2>Attempts</h2>
      <hr />
      <div class="form-group row">
        <div class="col-sm-6">
          <form method="POST" action="<?php echo("../main/index.php?controller=attempt&action=attemptadd&liftid=" . htmlspecialchars($liftId)); ?>">
            <button class="col-sm-2 btn btn-primary" type="submit">Add Attempt</button>
          </form>
        </div>
      </div>
      <table id="table" class="table table-striped">
        <thead>
          <tr>
            <th scope="col"><a href="#">Weight</a></th>
            <th scope="col"><a href="#">Reps</a></th>
            <th scope="col"><a href="#">Occurrence</a></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
  <?php foreach ($attempts as $attempt) { ?>
    <?php $liftId = $attempt->getLiftId (); ?>
          <tr>
            <td><?php echo(htmlspecialchars($attempt->getWeight())); ?></td>
            <td><?php echo(htmlspecialchars($attempt->getReps())); ?></td>
            <td><?php echo(htmlspecialchars(Utils::toDisplayDate($attempt->getOccurrence()))); ?></td>
            <td><a href="../main/index.php?controller=attempt&action=attemptview&attemptid=<?php echo(htmlspecialchars($attempt->getId())); ?>"><img src="../images/view.png" alt="View" /></a></td>
            <td><a href="../main/index.php?controller=attempt&action=attemptedit&attemptid=<?php echo(htmlspecialchars($attempt->getId())); ?>"><img src="../images/edit.png" alt="Edit" /></a></td>
            <td><a data-toggle="confirmation" href="../main/index.php?controller=attempt&action=attemptdelete&attemptid=<?php echo(htmlspecialchars($attempt->getId())); ?>"><img src="../images/delete.png" alt="Delete" /></a></td>
          </tr>
  <?php } ?>
        </tbody>
      </table>
<?php } ?>
    </div>
    <script>
      $(document).ready(function() {
          $("#table").tablesorter();
        }
      );
    </script>
<?php
  require_once("../includes/footer.php");
?>

