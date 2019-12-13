<?php
  require_once("../includes/header.php");
?>
    <div class="container">
      <h1>View Plan</h1>
      <hr />
<?php
  include("../includes/message.php");
?>
      <div class="form-group row">
        <label class="col-sm-1 col-form-label">Title:</label>
        <span class="col-sm-2"><?php echo(htmlspecialchars($title)); ?></span>
      </div>
      <div class="form-group row">
        <a class="btn btn-primary" href="../main/index.php?controller=plan&action=planedit&planid=<?php echo(htmlspecialchars($planId)); ?>">Edit Plan</a>
        <a class="btn btn-primary" data-toggle="confirmation" href="../main/index.php?controller=plan&action=plandelete&planid=<?php echo(htmlspecialchars($planId)); ?>">Delete Plan</a>
      </div>
    </div>
<?php
  require_once("../includes/footer.php");
?>

