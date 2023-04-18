<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tugas Semantik</title>
    <!-- Load Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Informasi Negara</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="allcountry.php">All Country</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container">
        <h1>All Country</h1>
        <?php
        function fetchAllCountryData()
        {
            // Set the API endpoint URL
            $url = "https://restcountries.com/v2/alpha/all";

            // Initialize a cURL session
            $curl = curl_init($url);

            // Set the cURL options
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

            // Execute the cURL request and fetch the response
            $response = curl_exec($curl);

            // Check if any error occurred
            if ($error = curl_error($curl)) {
                return "cURL Error: " . $error;
            } else {
                // Parse the JSON response into an array
                $data = json_decode($response, true);

                // Return the data as an array
                return $data;
            }

            // Close the cURL session
            curl_close($curl);
        }

        // Fetch all country data
        $countries = fetchAllCountryData();
        ?>
        <div class="col-md-6 col-md-offset-3">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Number</th>
                        <th scope="col">ID Country</th>
                        <th scope="col">Name Country</th>
                        <th scope="col">Capital</th>
                        <th scope="col">Population</th>
                        <th scope="col">Flags</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($countries as $key => $country) { ?>
                        <tr>
                            <th scope="row"><?php echo $key + 1 ?></th>
                            <td><?php echo $country['alpha2Code'] ?></td>
                            <td><?php echo $country['name'] ?></td>
                            <td><?php echo $country['capital'] ?></td>
                            <td><?php echo $country['population'] ?></td>
                            <td><img src="<?php echo $country['flag'] ?>" width="50" height="30" alt=""></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>





    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
    <footer class="bg-dark text-light">
        <div class="container py-3">
            <div class="row">
                <div class="col-md-4">
                    <h3>About Country</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean quis lorem nulla. Proin mattis eros sed est ultricies, a luctus mauris sagittis.</p>
                </div>
                <div class="col-md-4">
                    <h3>Quick Links</h3>
                    <ul class="list-unstyled">
                        <li><a href="#">Tourist Information</a></li>
                        <li><a href="#">Local Attractions</a></li>
                        <li><a href="#">Weather Forecast</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h3>Contact Us</h3>
                    <address>
                        <strong>Country Tourism Office</strong><br>
                        123 Main Street<br>
                        City, Country<br>
                        <abbr title="Phone">P:</abbr> (123) 456-7890
                    </address>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; 2023 Country Tourism Office</p>
                </div>
                <div class="col-md-6 text-end">
                    <ul class="list-inline">
                        <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
                        <li class="list-inline-item"><a href="#">Terms of Use</a></li>
                        <li class="list-inline-item"><a href="#">Sitemap</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <style>
        /* Internal CSS styles here */
        footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #333;
            color: #fff;
            text-align: center;
        }
    </style>
</body>

</html>