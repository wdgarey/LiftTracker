<?php
  require_once("../includes/header.php");
?>
    <div class="container">
      <h1>Lift</h1>
      <hr />
<?php
  include("../includes/message.php");
?>
      <div class="form-group row">
        <label class="col-sm-2">Name:</label>
        <span class="col-sm-2"><?php echo(htmlspecialchars($title)); ?></span>
      </div>
      <div class="form-group row">
        <label class="col-sm-2">Training Weight:</label>
        <span class="col-sm-2"><?php echo(htmlspecialchars($trainingWeight)); ?></span>
      </div>
      <div class="form-group row">
        <a class="btn btn-primary" href="../main/index.php?controller=lift&action=liftedit&liftid=<?php echo(htmlspecialchars($liftId)); ?>">Edit Lift</a>
        <a class="btn btn-primary" data-toggle="confirmation" href="../main/index.php?controller=lift&action=liftdelete&liftid=<?php echo(htmlspecialchars($liftId)); ?>">Delete Lift</a>
      </div>
<?php if (count($attempts) == 0) { ?>
      <h2>No attempts yet? Add one <a href="../main/index.php?controller=attempt&action=attemptadd&liftid=<?php echo(htmlspecialchars($liftId)); ?>">here</a>.</h2>
<?php } else {?>
      <h2>Attempts</h2>
      <hr />
      <div class="form-group row">
        <a class="btn btn-primary" href="../main/index.php?controller=attempt&action=attemptadd&liftid=<?php echo(htmlspecialchars($liftId)); ?>">Add Attempt</a>
      </div>
      <table id="table" class="table table-striped">
        <thead>
          <tr>
            <th scope="col"><a href="#">Weight</a></th>
            <th scope="col"><a href="#">Reps</a></th>
            <th scope="col"><a href="#">Occurrence</a></th>
            <th scope="col" style="text-align:center">View</th>
            <th scope="col" style="text-align:center">Edit</th>
            <th scope="col" style="text-align:center">Delete</th>
          </tr>
        </thead>
        <tbody>
  <?php foreach ($attempts as $attempt) { ?>
    <?php $liftId = $attempt->getLiftId (); ?>
          <tr>
            <td><?php echo(htmlspecialchars($attempt->getWeight())); ?></td>
            <td><?php echo(htmlspecialchars($attempt->getReps())); ?></td>
            <td><?php echo(htmlspecialchars(Utils::toDisplayDate($attempt->getOccurrence()))); ?></td>
            <td style="text-align:center"><a href="../main/index.php?controller=attempt&action=attemptview&attemptid=<?php echo(htmlspecialchars($attempt->getId())); ?>"><img src="../images/view.png" alt="View" /></a></td>
            <td style="text-align:center"><a href="../main/index.php?controller=attempt&action=attemptedit&attemptid=<?php echo(htmlspecialchars($attempt->getId())); ?>"><img src="../images/edit.png" alt="Edit" /></a></td>
            <td style="text-align:center"><a data-toggle="confirmation" href="../main/index.php?controller=attempt&action=attemptdelete&attemptid=<?php echo(htmlspecialchars($attempt->getId())); ?>"><img src="../images/delete.png" alt="Delete" /></a></td>
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

