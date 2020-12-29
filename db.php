<?php

// creo l'array degli aeroporti

$airports = [
    [
        "id" => 1,
        "name" => "Malpensa",
        "code" => "MXP",
        "lat" => 45.63059997558594,
        "lang" => 8.72811031341553

    ],

    [
        "id" => 2,
        "name" => "Leonardo da Vinci",
        "code" => "FCO",
        "lat" => 41.80450057983398,
        "lang" => 12.25080013275146
    ],

    [
        "id" => 3,
        "name" => "Punta Raisi",
        "code" => "PMO",
        "lat" => 38.17599868774414,
        "lang" => 13.09099960327148
    ],

    [
        "id" => 4,
        "name" => "Amerigo Vespucci",
        "code" => "FLR",
        "lat" => 43.81000137329102,
        "lang" => 11.20510005950928
    ]
];

// creo l'array dei voli

$flights = [
    [
        "code_departure" => "PMO",
        "code_arrival" => "MXP",
        "price" => 280.00
    ],

    [
        "code_departure" => "PMO",
        "code_arrival" => "MXP",
        "price" => 250.00
    ],

    [
        "code_departure" => "PMO",
        "code_arrival" => "FCO",
        "price" => 130.00
    ],

    [
        "code_departure" => "FCO",
        "code_arrival" => "MXP",
        "price" => 90.00
    ],

    [
        "code_departure" => "PMO",
        "code_arrival" => "FLR",
        "price" => 150.00
    ],

    [
        "code_departure" => "FLR",
        "code_arrival" => "MXP",
        "price" => 30.00
    ],
];