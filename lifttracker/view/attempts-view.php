<?php
  require_once("../includes/header.php");
?>
    <div class="container">
      <h1>Attempts</h1>
      <hr />
<?php
  include("../includes/message.php");
?>
<?php if (count($attempts) == 0) { ?>
      <h2>No attempts yet? Add one <a href="../main/index.php?controller=attempt&action=attemptadd">here</a>.</h2>
<?php } else {?>
      <div id="chartContainer" style="height: 370px; width: 100%;"></div>
      <br />
      <div class="form-group row">
        <a class="btn btn-primary" href="../main/index.php?controller=attempt&action=attemptadd">Add Attempt</a>
      </div>
      <table id="table" class="table table-striped">
        <thead>
          <tr>
            <th scope="col"><a href="#">Lift</a></th>
            <th scope="col"><a href="#">Weight</a></th>
            <th scope="col"><a href="#">Reps</a></th>
            <th scope="col" style="text-align:center">View</th>
            <th scope="col" style="text-align:center">Edit</th>
            <th scope="col" style="text-align:center">Delete</th>
          </tr>
        </thead>
        <tbody>
  <?php foreach ($attempts as $attempt) { ?>
    <?php $liftId = $attempt->getLiftId (); ?>
          <tr>
            <td><a href="../main/index.php?controller=lift&action=liftview&liftid=<?php echo(htmlspecialchars($liftId)); ?>"><?php echo(htmlspecialchars($liftTitles["$liftId"])); ?></a></td>
            <td><?php echo(htmlspecialchars($attempt->getWeight())); ?></td>
            <td><?php echo(htmlspecialchars($attempt->getReps())); ?></td>
            <td style="text-align:center"><a href="../main/index.php?controller=attempt&action=attemptview&attemptid=<?php echo(htmlspecialchars($attempt->getId())); ?>"><img src="../images/view.png" alt="View" /></a></td>
            <td style="text-align:center"><a href="../main/index.php?controller=attempt&action=attemptedit&attemptid=<?php echo(htmlspecialchars($attempt->getId())); ?>"><img src="../images/edit.png" alt="Edit" /></a></td>
            <td style="text-align:center"><a data-toggle="confirmation" href="../main/index.php?controller=attempt&action=attemptdelete&attemptid=<?php echo(htmlspecialchars($attempt->getId())); ?>"><img src="../images/delete.png" alt="Delete" /></a></td>
          </tr>
  <?php } ?>
        </tbody>
      </table>
    </div>
    <script>
      $(document).ready(function() {
          $("#table").tablesorter();
        }
      );
    </script>
    <script>
      window.onload = function () {

      var options = {
	      animationEnabled: false,
	      theme: "light2",
	      zoomEnabled: true,
	      axisX:{
		      valueFormatString: "DD MMM"
	      },
	      axisY: {
		      title: "Projected Max",
	      },
	      toolTip:{
		      shared:true
	      },
	      legend:{
		      cursor:"pointer",
		      verticalAlign: "bottom",
		      horizontalAlign: "left",
		      dockInsidePlotArea: true,
		      itemclick: toogleDataSeries
	      },
        data: [
<?php $liftCount = 1; ?>
<?php foreach ($lifts as $lift) { ?>
    {
		        type: "line",
		        showInLegend: true,
		        name: "<?php echo(htmlspecialchars($lift->getTitle())); ?>",
		        markerType: "square",
		        xValueFormatString: "DD MMM, YYYY",
            color: "<?php echo sprintf('#%06X', mt_rand(0, 0xFFFFFF)); ?>",
		        yValueFormatString: "#,##0",
		        dataPoints: [
  <?php $attemptCount = 1; ?>
  <?php foreach ($lift->getAttempts() as $attempt) { ?>
              { x: new Date("<?php echo(htmlspecialchars($attempt->getOccurrence())); ?>"), y: <?php echo ("" . ((($attempt->getReps() + 30.0) / 31.0) * $attempt->getWeight()) . "") ?> }
    <?php if ($attemptCount < count($lift->getAttempts())) { ?>
      <?php echo "," ?>
    <?php } ?>
    <?php $attemptCount++; ?>
  <?php } ?>
		        ]
          }
  <?php if ($liftCount < count($lifts)) { ?>
    <?php echo ","; ?>
  <?php } ?>
  <?php $liftCount++; ?>
<?php } ?>
        ]
      };
      $("#chartContainer").CanvasJSChart(options);

      function toogleDataSeries(e){
	      if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		      e.dataSeries.visible = false;
	      } else{
		      e.dataSeries.visible = true;
	      }
	      e.chart.render();
      }

      }
      </script>
<?php } ?>
<?php
  require_once("../includes/footer.php");
?>

