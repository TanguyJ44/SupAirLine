<?php

    $type = $_GET["type"];
    $from = $_GET["from"];
    $to = $_GET["to"];
    $start = $_GET["start_date"];
    $back = $_GET["back_date"];
    $pers = $_GET["pers"];

    try {
        $bdd = new PDO('mysql:host=localhost;dbname=supairline;charset=utf8', 'root', '');
    }
    catch(Exception $e) {
        die('Erreur : '.$e->getMessage());
    }

    $flight_type = $type;
    $flight_find = false;

    if($flight_type == 1) {

        $reponse = $bdd->query("SELECT air_roads.origin_city, air_roads.destination_city, departure.departure_date, TIMEDIFF(flights.landing_time, flights.takeoff_time)
        FROM air_roads 
        INNER JOIN flights
        ON air_roads.road_number = flights.road_number
        INNER JOIN departure
        ON flights.flight_number = departure.flight_number
        INNER JOIN airplane
        ON flights.airplane_id = airplane.airplane_id
        WHERE air_roads.origin_city = '" . $from . "' AND air_roads.destination_city = '" . $to . "' AND '" . $start . "' < departure.departure_date AND " . $pers . " <= airplane.capacity - departure.place_occupied;");

        while ($donnees = $reponse->fetch()) {
            $date = new DateTime($donnees['TIMEDIFF(flights.landing_time, flights.takeoff_time)']);

            echo("<div class='flight-section'>
                <div class='flight-from'>
                    <i class='fas fa-plane-departure' id='flight-icon'></i>
                    <p class='flight-name'>" . $donnees['origin_city'] . "</p>
                    <p class='flight-date'>" . $donnees['departure_date'] . "</p>
                </div>
                <div class='flight-to'>
                    <i class='fas fa-plane-arrival' id='flight-icon'></i>
                    <p class='flight-name'>" . $donnees['destination_city'] . "</p>
                    <p class='flight-date'>" . $donnees['departure_date'] . "</p>
                </div>
                <div class='flight-time'>
                    <i class='fas fa-clock' id='flight-icon'></i>
                    <p class='flight-houres'>" . str_replace(':', 'h', date_format($date, 'H:i')) . "</p>
                </div>
                <div class='flight-select'>
                    <div class='flight-select-btn'>
                        <p class='flight-select-txt' id='1234'>Réserver</p>
                    </div>
                </div>
            </div>");

            $flight_find = true;

        }

        if($flight_find == false) {
            echo("<p class='empty-flight'>Aucun vol n'a été trouvé !</p>");
        }

    } else if($flight_type == 2) {

        $reponse = $bdd->query("SELECT air_roads.origin_city, air_roads.destination_city, departure.departure_date, TIMEDIFF(flights.landing_time, flights.takeoff_time)
        FROM air_roads 
        INNER JOIN flights
        ON air_roads.road_number = flights.road_number
        INNER JOIN departure
        ON flights.flight_number = departure.flight_number
        INNER JOIN airplane
        ON flights.airplane_id = airplane.airplane_id
        WHERE air_roads.origin_city = '" . $from . "' AND air_roads.destination_city = '" . $to . "' AND '" . $start . "' < departure.departure_date AND " . $pers . " <= airplane.capacity - departure.place_occupied;");

        $reponse2 = $bdd->query("SELECT departure.departure_date
        FROM air_roads 
        INNER JOIN flights
        ON air_roads.road_number = flights.road_number
        INNER JOIN departure
        ON flights.flight_number = departure.flight_number
        WHERE air_roads.origin_city = '" . $to . "' AND air_roads.destination_city = '" . $from . "';");


        while ($donnees = $reponse->fetch()) {
            while ($donnees2 = $reponse2->fetch()) {

                $date = new DateTime($donnees['TIMEDIFF(flights.landing_time, flights.takeoff_time)']);

                echo("<div class='flight-section'>
                    <div class='flight-from'>
                        <i class='fas fa-plane-departure' id='flight-icon'></i>
                        <p class='flight-name'>" . $donnees['origin_city'] . "</p>
                        <p class='flight-date'>" . $donnees['departure_date'] . "</p>
                        <p class='flight-date' style='font-size: 16px;'>Retour: " . $donnees2['departure_date'] . "</p>
                    </div>
                    <div class='flight-to'>
                        <i class='fas fa-plane-arrival' id='flight-icon'></i>
                        <p class='flight-name'>" . $donnees['destination_city'] . "</p>
                        <p class='flight-date'>" . $donnees['departure_date'] . "</p>
                        <p class='flight-date' style='font-size: 16px;'>Retour: " . $donnees2['departure_date'] . "</p>
                    </div>
                    <div class='flight-time'>
                        <i class='fas fa-clock' id='flight-icon'></i>
                        <p class='flight-houres'>" . str_replace(':', 'h', date_format($date, 'H:i')) . "</p>
                    </div>
                    <div class='flight-select'>
                        <div class='flight-select-btn'>
                            <p class='flight-select-txt' id='1234'>Réserver</p>
                        </div>
                    </div>
                </div>");

                $flight_find = true;

            }
        }

        if($flight_find == false) {
            echo("<p class='empty-flight'>Aucun vol n'a été trouvé !</p>");
        }

    }

    $reponse->closeCursor();

?>