<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tugas Semantik</title>
    <!-- Load Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.min.js"></script>
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
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="allcountry.php">All Country</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container">
        <h1>Find Country</h1>
        <?php
        function fetchAndSaveCountryData($alphaCode)
        {
            // Set the API endpoint URL
            $url = "https://restcountries.com/v2/alpha/" . $alphaCode;

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
                // Create a SimpleXMLElement object
                $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><country></country>');

                if (!isset($data['name'])) {
                    // Set the country name, capital, and population as child elements of the root element
                    $xml->addChild('name', "");
                    $xml->addChild('capital', "");
                    $xml->addChild('population', "");



                    // Save the XML file
                    $xml->asXML('country.xml');

                    // Return an array containing the name, capital, and population of the country
                    return array(
                        'name' => "-",
                        'capital' => "-",
                        'population' => "-"
                    );
                } else {
                    // Set the country name, capital, and population as child elements of the root element
                    $xml->addChild('name', $data['name']);
                    $xml->addChild('capital', $data['capital']);
                    $xml->addChild('population', $data['population']);



                    // Save the XML file
                    $xml->asXML('country.xml');

                    // Return an array containing the name, capital, and population of the country
                    return array(
                        'name' => $data['name'],
                        'capital' => $data['capital'],
                        'population' => $data['population']
                    );
                }
            }

            // Close the cURL session
            curl_close($curl);
        }



        // Check if the form has been submitted
        if (isset($_POST['submit'])) {
            // Get the value of the name input field

            $name = $_POST['IDCountry'];
            // Call the fetchAndSaveCountryData function with the user input as the parameter and store the result in a variable
            $countryData = fetchAndSaveCountryData($name);

            // Display the country data on the page
            echo "<h3>Name: " . $countryData['name'] . "</h3>";
            echo "<h3>Capital: " . $countryData['capital'] . "</h3>";
            echo "<h3>Population: " . $countryData['population'] . "</h3>";

            // Display an alert message to indicate that the data has been saved
            echo "<script>alert('The data has been saved to country.xml');</script>";
        } else if (isset($_POST['reset'])) {
            // Call the fetchAndSaveCountryData function and store the result in a variable
            $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><country></country>');

            // Set the country name, capital, and population as child elements of the root element
            $xml->addChild('name', "");
            $xml->addChild('capital', "");
            $xml->addChild('population', "");

            // Save the XML file
            $xml->asXML('country.xml');

            // Return an array containing the name, capital, and population of the country
            array(
                'name' => "",
                'capital' => "",
                'population' => ""
            );
            echo "<script>alert('The data has been cleared from country.xml');</script>";
        } else if (isset($_POST['showxml'])) {
            echo '<script type="text/javascript">';
            echo 'window.onload = function() {';
            echo '    $("#myModal").modal("show");';
            echo '}';
            echo '</script>';
        }

        ?>
        <div class="col-md-6 col-md-offset-3">
            <form method="post">
                <div class="form-group">
                    <label for="IDCountry">ID Country</label>
                    <input type="text" class="form-control" id="IDCountry" name="IDCountry" maxlength="2">
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                <button type="submit" name="reset" class="btn btn-danger">Reset</button>
                <button type="submit" name="showxml" class="btn btn-secondary">Show XML</button>
            </form>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    </div>
                    <div class="modal-body">
                        <?php
                        $xml_file = 'country.xml';
                        $xml_contents = file_get_contents($xml_file);
                        echo htmlentities($xml_contents);
                        ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
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