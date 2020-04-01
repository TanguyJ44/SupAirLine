<?php

    try {
        $bdd = new PDO('mysql:host=localhost;dbname=supairline;charset=utf8', 'root', '');
    }
    catch(Exception $e) {
        die('Erreur : '.$e->getMessage());
    }

    $flight_type = 1;

    $dep = "Paris";
    $dest = "Corfou";

    if($flight_type == 1) {

        $reponse = $bdd->query("SELECT air_roads.origin_city, air_roads.destination_city, departure.departure_date, TIMEDIFF(flights.landing_time, flights.takeoff_time)
        FROM air_roads 
        INNER JOIN flights
        ON air_roads.road_number = flights.road_number
        INNER JOIN departure
        ON flights.flight_number = departure.flight_number
        WHERE air_roads.origin_city = '" . $dep . "' AND air_roads.destination_city = 'Corfou' AND CURRENT_DATE() < departure.departure_date;");

        while ($donnees = $reponse->fetch()) {

            echo("<p>" . $donnees['origin_city'] . "</p>");
            echo("<p>" . $donnees['destination_city'] . "</p>");
            echo("<p>" . $donnees['departure_date'] . "</p>");

            $date = new DateTime($donnees['TIMEDIFF(flights.landing_time, flights.takeoff_time)']);
            echo str_replace(':', 'h', date_format($date, 'H:i'));

        }

    } else if($flight_type == 2) {

    }



    $reponse->closeCursor();

?>