<?php
require_once 'shippypro-flights.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <!-- BULMA -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.css">

    <title>Flight-scanner</title>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar has-background-primary-dark is-size-7 is-uppercase has-text-weight-semibold mb-4" role="navigation" aria-label="main navigation">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item has-text-white" href="#">
                    <h1>Flight Scanner</h1>
                </a>
            </div>
        </div>
    </nav>
    </div>
    
    <!-- FORM DI RICERCA -->
    <div class="container is-max-desktop mt-3">
        <form>
            <div class="columns">
                <div class="column">
                    <div class="select is-rounded is-fullwidth">
                        <select name="my_code_departure">
                            <option value="">Departure</option>
                            <?php foreach ($airports as $airport){

                                $selected = isset($_GET['my_code_departure']) && $_GET['my_code_departure'] === $airport['code'] ? 'selected' : '';
                                echo '<option value="' . $airport['code'] . '" ' . $selected . '>' . $airport['name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="column">
                    <div class="select is-rounded is-fullwidth">
                        <select name="my_code_arrival">
                            <option value="">Arrival</option>
                            <?php foreach ($airports as $airport){
                                $selected = isset($_GET['my_code_arrival']) && $_GET['my_code_arrival'] === $airport['code'] ? 'selected' : '';
                                echo '<option value="' . $airport['code'] . '"' . $selected . '>' . $airport['name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="column">
                    <div class="select is-rounded is-fullwidth">
                        <select name="my_direct_only">
                            <option value="true">Non-stop</option>
                            <option value="false" <?php echo isset($_GET['my_direct_only']) && $_GET['my_direct_only'] === 'false' ? 'selected' : '' ?>>One-stop</option>
                        </select>
                    </div>
                </div>
                <div class="column">
                    <button class="button has-background-primary-dark has-text-white is-rounded is-fullwidth">Search</button>
                </div>
            </div>
        </form>
    </div>



    <section class="hero is-light is-bold has-text-centered mt-4">
        <div class="hero-body">
            <div class="container">
                <span class="icon is-large has-text-primary-dark">
                    <i class="fas fa-plane-departure fa-2x"></i>
                </span>
                <h1 class="title">
                    Search for your flight!
                </h1>

                
                <?php
                // controlli input
                if (isset($_GET['my_code_departure']) && 
                    isset($_GET['my_code_arrival']) && 
                    isset($_GET['my_direct_only']) &&
                    $_GET['my_code_departure'] !== '' &&
                    $_GET['my_code_arrival'] !== '' &&
                    $_GET['my_direct_only'] !== ''){

                    // config. di ricerca
                    $conf = [
                        'my_code_departure' => $_GET['my_code_departure'],
                        'my_code_arrival' => $_GET['my_code_arrival'],
                        'my_direct_only' => $_GET['my_direct_only'] === 'true',
                    ];

                    $results = get_cheapest_flight($flights, $conf);
                    
                ?> 

                <!-- RISULTATI RICERCA -->
                <div class="columns is-mobile my-6">
                    <div class="column is-half is-offset-one-quarter">
                        <div class="card">
                            <div class="card-content">
                                <div class="columns">
                                    <div class="column is-flex is-flex-direction-column is-justify-content-center is-align-items-center">
                                        <div class="icon has-text-primary-dark mb-2">
                                            <i class="fas fa-plane-departure"></i>
                                        </div>
                                        <h1><?php echo $_GET['my_code_departure']?></h1>
                                    </div>
                                    <div class="column is-half is-flex is-flex-direction-column is-justify-content-center is-align-items-center has-text-centered">
                                        <h2>Best price for your claim</h2>

                                        <?php if ($results['direct_price'] !== null && $conf['my_direct_only']) : ?>
                                        <div> 
                                            <div class="is-size-3"><?php echo $results['direct_price']?> €</div>
                                            <div class="has-text-grey is-size-7 is-uppercase has-text-weight-semibold">direct</div>
                                        </div>
                                        <?php endif ?>
                                        
                                        <?php if ($results['stopover_price'] !== null && !$conf['my_direct_only']) : ?>
                                        <div>
                                            <div class="is-size-3"><?php echo $results['stopover_price']?> €</div>
                                            <div class="has-text-grey is-size-7 is-uppercase has-text-weight-semibold">stopover in <?php echo $results['itinerary'][0]['code_arrival']?></div>
                                        </div>
                                        <?php endif ?>


                                        <?php if ($results['stopover_price'] === null && $results['direct_price'] !== null && !$conf['my_direct_only']) : ?>
                                        <div>
                                            no matching flights with stopovers! <span class="icon has-text-primary-dark"><i class="far fa-grin-beam-sweat"></i></span>
                                        </div>
                                        <?php endif ?>


                                        <?php if ($results['direct_price'] === null && $results['stopover_price'] === null) :?>
                                            <div>OOPS <span class="icon has-text-primary-dark"><i class="far fa-grin-beam-sweat"></i></span> no matching flights!</div>
                                        <?php endif ?>
                                    </div>
                                    <div class="column is-flex is-flex-direction-column is-justify-content-center is-align-items-center">
                                        <div class="icon has-text-primary-dark mb-2">
                                            <i class="fas fa-plane-arrival mb-2"></i>
                                        </div>
                                        <h1><?php echo $_GET['my_code_arrival']?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
</body>
</html>