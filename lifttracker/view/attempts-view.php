<?php
  require_once("../includes/header.php");
?>
    <div class="container">
      <h1>Progress</h1>
      <hr />
<?php
  include("../includes/message.php");
?>
<?php if (count($attempts) == 0) { ?>
      <h2>No attempts yet? Add one <a href="../main/index.php?controller=attempt&action=attemptadd">here</a>.</h2>
<?php } else {?>
      <div id="chartContainer" style="height: 370px; width: 100%;"></div>
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

