<?php
  require_once("../includes/header.php");
?>
    <div class="container">
      <h1>View Lifts</h1>
      <hr />
<?php
  include("../includes/message.php");
?>
<?php if (count($lifts) == 0) { ?>
      <h2>No lifts yet? Add one <a href="../main/index.php?controller=lift&action=liftadd">here</a>.</h2>
<?php } else {?>
      <div class="form-group row">
        <a class="btn btn-primary" href="../main/index.php?controller=lift&action=liftadd">Add Lift</a>
        <a class="btn btn-primary" href="../main/index.php?controller=lift&action=liftsedit">Change Weights</a>
      </div>
      <table id="table" class="table table-striped">
        <thead>
          <tr>
            <th scope="col"><a href="#">Name</a></th>
            <th scope="col"><a href="#">Weight</a></th>
            <th scope="col" style="text-align:center">Edit</th>
            <th scope="col" style="text-align:center">Delete</th>
            <th scope="col" style="text-align:center">Add Attempt</th>
          </tr>
        </thead>
        <tbody>
  <?php foreach ($lifts as $lift) { ?>
          <tr>
            <td><a href="../main/index.php?controller=lift&action=liftview&liftid=<?php echo(htmlspecialchars($lift->getId())); ?>"><?php echo(htmlspecialchars($lift->getTitle())); ?></a></td>
            <td><?php echo(htmlspecialchars($lift->getTrainingWeight())); ?></td>
            <td style="text-align:center"><a href="../main/index.php?controller=lift&action=liftedit&liftid=<?php echo(htmlspecialchars($lift->getId())); ?>"><img src="../images/edit.png" alt="Edit" /></a></td>
            <td style="text-align:center"><a data-toggle="confirmation" href="../main/index.php?controller=lift&action=liftdelete&liftid=<?php echo(htmlspecialchars($lift->getId())); ?>"><img src="../images/delete.png" alt="Delete" /></a></td>
            <td style="text-align:center"><a href="../main/index.php?controller=attempt&action=attemptadd&liftid=<?php echo(htmlspecialchars($lift->getId())); ?>"><img src="../images/add.png" alt="Add Attempt" /></a></td>
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

