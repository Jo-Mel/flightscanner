<?php
require_once 'db.php';



function get_cheapest_flight($data, $config) {

    $departure =[];
    $arrival =[];

    // ciclo l'array dei voli per trovare il volo con il prezzo più basso

    $price = null;

    foreach ($data as $flight){
        if ($flight['code_departure'] === $config['my_code_departure']  && $flight['code_arrival'] !== $config['my_code_arrival']){
            $departure[] = $flight;
            
        }

        if ($flight['code_departure'] !== $config['my_code_departure']  && $flight['code_arrival'] === $config['my_code_arrival']){
            $arrival[] = $flight;
        }

        if ($flight['code_departure'] !== $config['my_code_departure']  || $flight['code_arrival'] !== $config['my_code_arrival']){
            continue;
        }

        if ($flight['price'] < $price || $price === null){
            $price = $flight['price'];
        } 

    }

    $price_stopover = null;
    $itinerary = [];

    // ciclo per trovare la coincidenza più economica
    foreach($departure as $dep) {
        
        foreach($arrival as $arr) {
            if($dep['code_arrival'] !== $arr['code_departure']){
                continue;
            }

            $actual_price = $dep['price'] + $arr['price'];

            // found actual cheapest solution
            if($actual_price < $price_stopover || $price_stopover === null) {
                $price_stopover = $actual_price;
                $itinerary = [$dep, $arr];
            }
        }

    } 

    return [
        'direct_price' => $price,
        'stopover_price' => $price_stopover,
        'itinerary' => $itinerary,
    ];
}


