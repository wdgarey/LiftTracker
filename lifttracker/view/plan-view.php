<?php
  require_once("../includes/header.php");
?>
    <div class="container">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h1><?php echo(htmlspecialchars($title)); ?></h1>
          <a href="../main/index.php?controller=plan&action=planedit&planid=<?php echo(htmlspecialchars($planId)); ?>">Edit</a>
          | <a data-toggle="confirmation" href="../main/index.php?controller=plan&action=plandelete&planid=<?php echo(htmlspecialchars($planId)); ?>">Delete</a>
<?php if (count($weeks) > 0) { ?>
          | <a href="../main/index.php?controller=week&action=weekadd&planid=<?php echo(htmlspecialchars($planId)); ?>">Add Week</a>
<?php }?>
        </div>
        <div class="panel-body">
<?php
  include("../includes/message.php");
?>
<?php if (count($weeks) == 0) { ?>
          <h3>No weeks yet? Add one <a href="../main/index.php?controller=week&action=weekadd&planid=<?php echo(htmlspecialchars($planId)); ?>">here</a>.</h3>
<?php } else {?>
          <div class="panel panel-default">
  <?php foreach ($weeks as $week) { ?>
            <div class="panel-heading">
              <h3><a href="#week<?php echo(htmlspecialchars($week->getId())); ?>" data-toggle="collapse"><?php echo(htmlspecialchars($week->getTitle())); ?></a></h3>
              <a href="../main/index.php?controller=week&action=weekedit&weekid=<?php echo(htmlspecialchars($week->getId())); ?>">Edit</a>
              | <a data-toggle="confirmation" href="../main/index.php?controller=week&action=weekdelete&weekid=<?php echo(htmlspecialchars($week->getId())); ?>">Delete</a>
    <?php if (count($week->getDays()) > 0) { ?>
              | <a href="../main/index.php?controller=day&action=dayadd&weekid=<?php echo(htmlspecialchars($week->getId())); ?>">Add Day</a>
    <?php }?>
            </div>
            <div id="week<?php echo(htmlspecialchars($week->getId())); ?>" class="panel-body collapse">
    <?php if (count($week->getDays()) == 0) { ?>
            <h3>No days yet? Add one <a href="../main/index.php?controller=day&action=dayadd&weekid=<?php echo(htmlspecialchars($week->getId())); ?>">here</a>.</h3>
    <?php } else {?>
              <div class="row">
      <?php foreach ($week->getDays() as $day) { ?>
                <div class="col-md-4">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h5><a href="#day<?php echo(htmlspecialchars($day->getId())); ?>" data-toggle="collapse"><?php echo(htmlspecialchars($day->getTitle())); ?></a></h5>
                      <a href="../main/index.php?controller=day&action=dayedit&dayid=<?php echo(htmlspecialchars($day->getId())); ?>">Edit</a>
                      | <a data-toggle="confirmation" href="../main/index.php?controller=day&action=daydelete&dayid=<?php echo(htmlspecialchars($day->getId())); ?>">Delete</a>
        <?php if (count($day->getExercises()) > 0) { ?>
                      | <a href="../main/index.php?controller=exercise&action=exerciseadd&dayid=<?php echo(htmlspecialchars($day->getId())); ?>">Add Exercise</a>
        <?php } ?>
                    </div>
                    <div id="day<?php echo(htmlspecialchars($day->getId())); ?>" class="panel-body collapse">
        <?php if (count($day->getExercises()) == 0) { ?>
                      No Exercises yet? Add one <a href="../main/index.php?controller=exercise&action=exerciseadd&dayid=<?php echo(htmlspecialchars($day->getId())); ?>">here</a>.
          <?php } else {?>
            <?php foreach ($day->getExercises() as $exercise) { ?>
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          <?php echo(htmlspecialchars($exercise->getTitle())); ?>
                          <a href="../main/index.php?controller=exercise&action=exerciseedit&exerciseid=<?php echo(htmlspecialchars($exercise->getId())); ?>">Edit</a>
                          | <a data-toggle="confirmation" href="../main/index.php?controller=exercise&action=exercisedelete&exerciseid=<?php echo(htmlspecialchars($exercise->getId())); ?>">Delete</a>
              <?php if (count($exercise->getSets()) > 0) { ?>
                          | <a href="../main/index.php?controller=set&action=setadd&exerciseid=<?php echo(htmlspecialchars($exercise->getId())); ?>">Add Set</a>
              <?php } ?>
                        </div>
                        <div class="panel-body">
              <?php if ($exercise->hasLift()) { ?>
                <a href="../main/index.php?controller=lift&action=liftview&liftid=<?php echo(htmlspecialchars($exercise->getLift()->getId())); ?>">
                  <?php echo(htmlspecialchars($exercise->getLift()->getTitle())); ?>
                </a>
                (<?php echo(htmlspecialchars($exercise->getLift()->getTrainingWeight())); ?>)
              <?php } ?>
              <?php if (count($exercise->getSets()) == 0) { ?>
                          No sets yet? Add one <a href="../main/index.php?controller=set&action=setadd&exerciseid=<?php echo(htmlspecialchars($exercise->getId())); ?>">here</a>.
              <?php } else {?>
                        <ul>
                <?php foreach ($exercise->getSets() as $set) { ?>
                          <li>
                  <?php if ($exercise->hasLift()) { ?>
                            <?php echo(htmlspecialchars($set->getReps())); ?> reps of
                            <?php echo(htmlspecialchars($set->getPercent() * $exercise->getLift()->getTrainingWeight())); ?>
                            (<?php echo(htmlspecialchars($set->getPercent() * 100.0)); ?>%)
                            <a href="../main/index.php?controller=set&action=setedit&setid=<?php echo(htmlspecialchars($set->getId())); ?>">Edit</a>
                            | <a data-toggle="confirmation" href="../main/index.php?controller=set&action=setdelete&setid=<?php echo(htmlspecialchars($set->getId())); ?>">Delete</a>
                  <?php } else {?>
                            <?php echo(htmlspecialchars($set->getReps())); ?> reps at
                            <?php echo(htmlspecialchars($set->getPercent() * 100.0)); ?>%
                            <a href="../main/index.php?controller=set&action=setedit&setid=<?php echo(htmlspecialchars($set->getId())); ?>">Edit</a>
                            | <a data-toggle="confirmation" href="../main/index.php?controller=set&action=setdelete&setid=<?php echo(htmlspecialchars($set->getId())); ?>">Delete</a>
                  <?php } ?>
                          </li>
                <?php } ?>
                        </ul>
              <?php } ?>
                        </div>
                      </div>
            <?php } ?>
          <?php } ?>
                    </div>
                  </div>
                </div>
      <?php } ?>
              </div>
    <?php } ?>
            </div>
  <?php } ?>
          </div>
<?php } ?>
        </div>
      </div>
    </div>
<?php
  require_once("../includes/footer.php");
?>

