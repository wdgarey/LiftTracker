<?php
  require_once("../includes/header.php");
?>
    <div class="container">
      <h1>Change Weights</h1>
      <hr />
<?php
  include("../includes/message.php");
?>
<?php if (count($lifts) == 0) { ?>
      <h2>No lifts yet? Add one <a href="../main/index.php?controller=lift&action=liftadd">here</a>.</h2>
<?php } else {?>
      <form method="POST" action="<?php echo("../main/index.php?controller=lift&action=liftsprocessedit"); ?>">
        <table id="table" class="table table-striped">
          <thead>
            <tr>
              <th scope="col"><a href="#">Name</a></th>
              <th scope="col"><a href="#">Weight</a></th>
            </tr>
          </thead>
          <tbody>
  <?php foreach ($lifts as $lift) { ?>
            <tr>
              <td><input type="checkbox" name="lift<?php echo(htmlspecialchars($lift->getId())); ?>"> <a href="../main/index.php?controller=lift&action=liftview&liftid=<?php echo(htmlspecialchars($lift->getId())); ?>"><?php echo(htmlspecialchars($lift->getTitle())); ?></a></input></td>
              <td><?php echo(htmlspecialchars($lift->getTrainingWeight())); ?></td>
            </tr>
  <?php } ?>
          </tbody>
        </table>
        <div class="input-group col-md-3">
          <div class="input-group-btn">
            <input class="btn btn-primary" type="submit" name="add" value="Add" />
            <input class="btn btn-primary" type="submit" name="subtract" value="Subtract" />
            <input class="btn btn-primary" type="submit" name="multiply" value="Multiply" />
          </div>
          <input type="number" class="form-control" placeholder="5" name="val" step="any" min="0" max="100" />
        </div>
      </form>
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

