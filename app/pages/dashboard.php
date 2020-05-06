<?php
require("header.php");

$month = date('m');
$year = date('Y');



?>

<body>

<div id="arrow">
    <i class="fas fa-arrow-circle-left fa-3x" id="prev"></i>
    <i class="fas fa-arrow-circle-right fa-3x" id="next"></i>
</div>
<button id="linkToday" class="btn btn-success">Aujourd'hui</button>
<div id="content">
</div>

<script type="text/javascript">

    jQuery(function($){

        var month = <?php echo $month; ?>;
        var year = <?php echo $year; ?>;

        $(document).ready(function(){

            $("#content").load("calendar.php?month="+month+"&year="+year+"");

        });

        $("#prev").click(function(){

            month--;

            if (month < 1) {
                year--;
                month = 12;
            }

            $("#content").load("calendar.php?month="+month+"&year="+year+"");

        });

        $("#next").click(function(){

            month++;

            if (month > 12) {
                year++;
                month = 1;
            }

            $("#content").load("calendar.php?month="+month+"&year="+year+"");

        });

        $("#linkToday").click(function(){
            var month = <?php echo $month; ?>;
            var year = <?php echo $year; ?>;
            $("#content").load("calendar.php?month="+month+"&year="+year+"");

        });

    });

</script>
</body>
</html>
