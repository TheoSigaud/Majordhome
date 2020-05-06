<?php
function calendar($month, $year)
{

    require('functions.php');

    if ($month < 10){
        $month = '0'.$month;
    }


    $connect = connectDb();

    $data = $connect->query("SELECT dateIntervention FROM souscription_service WHERE statutReservation = 0");

    $rows = $data->fetchAll(PDO::FETCH_ASSOC);


    $dayToday = date('d');
    $monthToday = date('m');
    $yearToday = date('Y');

	$nombre_de_jour = cal_days_in_month(CAL_GREGORIAN, $month, $year);

	echo "<table id='tableCalendar'>";

	echo "<tr><th class='thCalendar'>Lundi</th><th class='thCalendar'>Mardi</th><th class='thCalendar'>Mercredi</th><th class='thCalendar'>Jeudi</th><th class='thCalendar'>Vendredi</th><th class='thCalendar'>Samedi</th><th class='thCalendar'>Dimanche</th></tr>";

	for ($i=1; $i <= $nombre_de_jour ; $i++)
	{ 
	    $date = ($year.'-'.$month.'-'.$i);


		$jour = cal_to_jd(CAL_GREGORIAN, $month, $i, $year);
		$jour_semaine = JDDayOfWeek($jour);

		if ($i == $nombre_de_jour)
		{
		
			if ($jour_semaine == 1)
			{
				echo "<tr>";
			}

            $count = 0;


            foreach ($rows as $row) {
                $dateExplode = explode(' ',$row['dateIntervention']);
                if($date == $dateExplode[0]){
                    $count++;
                }
            }


			if ($i == $dayToday && $month == $monthToday && $year == $yearToday && $count == 0){
                echo "<td class='case' id='today' onclick=\"location.href='attribution.php?date=".$year."-".$month."-".$i."'\"><p class='numberCalendar'>" . $i . "</p></td></tr>";
            }else if ($i == $dayToday && $month == $monthToday && $year == $yearToday && $count != 0){
                echo "<td class='case' id='today' onclick=\"location.href='attribution.php?date=".$year."-".$month."-".$i."'\"><span class='badge badge-primary'>".$count."</span><p class='numberCalendar'>".$i."</p></td></tr>";
            }else if ($count != 0){
                echo "<td class='case' onclick=\"location.href='attribution.php?date=".$year."-".$month."-".$i."'\"><span class='badge badge-primary'>".$count."</span><p class='numberCalendar'>".$i."</p></td></tr>";
            }else{
                echo "<td class='case' onclick=\"location.href='attribution.php?date=".$year."-".$month."-".$i."'\"><p class='numberCalendar'>" . $i . "</p></td></tr>";
            }

		}elseif ($i == 1)
		{
		
			echo "<tr>";

			if ($jour_semaine == 0) 
			{
				$jour_semaine = 7;
			}

			for ($k=1; $k != $jour_semaine ; $k++)
			{ 
				echo "<td></td>";
			}

            $count = 0;

            foreach ($rows as $row) {
                $dateExplode = explode(' ',$row['dateIntervention']);
                if($date == $dateExplode[0]){
                    $count++;
                }
            }


            if ($i == $dayToday && $month == $monthToday && $year == $yearToday && $count == 0){
                echo "<td class='case' id='today' onclick=\"location.href='attribution.php?date=".$year."-".$month."-".$i."'\"><p class='numberCalendar'>" . $i . "</p></td>";
            }else if ($i == $dayToday && $month == $monthToday && $year == $yearToday && $count != 0){
                echo "<td class='case' id='today' onclick=\"location.href='attribution.php?date=".$year."-".$month."-".$i."'\"><span class='badge badge-primary'>".$count."</span><p class='numberCalendar'>".$i."</p></td>";
            }else if ($count != 0){
                echo "<td class='case' onclick=\"location.href='attribution.php?date=".$year."-".$month."-".$i."'\"><span class='badge badge-primary'>".$count."</span><p class='numberCalendar'>".$i."</p></td>";
            }else{
                echo "<td class='case' onclick=\"location.href='attribution.php?date=".$year."-".$month."-".$i."'\"><p class='numberCalendar'>" . $i . "</p></td>";
            }


			if ($jour_semaine == 7)
			{
				echo "</tr>";
			}

		}else
		{

			if ($jour_semaine == 1)
			{
				echo "<tr>";
			}

            $count = 0;

            foreach ($rows as $row) {
                $dateExplode = explode(' ',$row['dateIntervention']);
                if($date == $dateExplode[0]){
                    $count++;
                }
            }


            if ($i == $dayToday && $month == $monthToday && $year == $yearToday && $count == 0){
                echo "<td class='case' id='today' onclick=\"location.href='attribution.php?date=".$year."-".$month."-".$i."'\"><p class='numberCalendar'>" . $i . "</p></td>";
            }else if ($i == $dayToday && $month == $monthToday && $year == $yearToday && $count != 0){
                echo "<td class='case' id='today' onclick=\"location.href='attribution.php?date=".$year."-".$month."-".$i."'\"><span class='badge badge-primary'>".$count."</span><p class='numberCalendar'>".$i."</p></td>";
            }else if ($count != 0){
                echo "<td class='case' onclick=\"location.href='attribution.php?date=".$year."-".$month."-".$i."'\"><span class='badge badge-primary'>".$count."</span><p class='numberCalendar'>".$i."</p></td>";
            }else{
                echo "<td class='case' onclick=\"location.href='attribution.php?date=".$year."-".$month."-".$i."'\"><p class='numberCalendar'>" . $i . "</p></td>";
            }


			if ($jour_semaine == 0) {
				echo "</tr>";
			}

		}

	}

	echo "</table>";

}


function month($p) {

	$z = $p-1;

	$table = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");

	return $table[$z];

}

?>
