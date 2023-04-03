<!DOCTYPE html>
<html>

<head>
    <title>Tugas Web Semantik</title>
</head>

<body>
    <h1>Informasi Negara</h1>
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

        // Close the cURL session
        curl_close($curl);
    }

    // Check if the form has been submitted
    if (isset($_POST['submit'])) {
        // Call the fetchAndSaveCountryData function and store the result in a variable
        $countryData = fetchAndSaveCountryData('al');

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
        return array(
            'name' => "",
            'capital' => "",
            'population' => ""
        );
        echo "<script>alert('The data has been saved to country.xml');</script>";
    }
    ?>
    <form method="post">
        <input type="submit" name="submit" value="Fetch and Save Data">
        <input type="submit" name="clear" value="Clear Data">
    </form>
</body>

</html>