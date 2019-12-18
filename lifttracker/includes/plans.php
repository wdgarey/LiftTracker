      <h1>Plans</h1>
      <hr />
<?php if (count($plans) == 0) { ?>
      <h2>No plans yet? Add one <a href="../main/index.php?controller=plan&action=planadd">here</a>.</h2>
<?php } else {?>
      <div class="form-group row">
        <a class="btn btn-primary" href="../main/index.php?controller=plan&action=planadd">Add Plan</a>
      </div>
      <table id="plan-table" class="table table-striped">
        <thead>
          <tr>
            <th scope="col"><a href="#">Title</a></th>
            <th scope="col" style="text-align:center">View</th>
            <th scope="col" style="text-align:center">Edit</th>
            <th scope="col" style="text-align:center">Delete</th>
          </tr>
        </thead>
        <tbody>
  <?php foreach ($plans as $plan) { ?>
          <tr>
            <td><a href="../main/index.php?controller=plan&action=planview&planid=<?php echo(htmlspecialchars($plan->getId())); ?>"><?php echo(htmlspecialchars($plan->getTitle())); ?></a></td>
            <td style="text-align:center"><a href="../main/index.php?controller=plan&action=planview&planid=<?php echo(htmlspecialchars($plan->getId())); ?>"><img src="../images/view.png" alt="View" /></a></td>
            <td style="text-align:center"><a href="../main/index.php?controller=plan&action=planedit&planid=<?php echo(htmlspecialchars($plan->getId())); ?>"><img src="../images/edit.png" alt="Edit" /></a></td>
            <td style="text-align:center"><a data-toggle="confirmation" href="../main/index.php?controller=plan&action=plandelete&planid=<?php echo(htmlspecialchars($plan->getId())); ?>"><img src="../images/delete.png" alt="Delete" /></a></td>
          </tr>
  <?php } ?>
        </tbody>
      </table>
    <script>
      $(document).ready(function() {
          $("#plan-table").tablesorter();
        }
      );
    </script>
<?php } ?>

