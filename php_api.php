<?php
// open weather map's API key
// ironically they make us sign up but never verify it...
$apiKey = "857ece57fb77df319fd51e90704a0a1c";

// base url is the basis for *ALL* API calls
$baseUrl = "http://api.openweathermap.org/data/2.5/weather";

// input to the API
if(empty($_GET["city"]) === false)
{
    $query = htmlspecialchars($_GET["city"]);
    $query = trim($query);
    $query = urlencode($query);
    $query = "?q=$query";
}
if(empty($_GET["latitude"]) === false && empty($_GET["longitude"]) === false)
{
    // covert the coordinates
    $latitude = trim($_GET["latitude"]);
    $latitude = floatval($latitude);
    $longitude = trim($_GET["longitude"]);
    $longitude = floatval($longitude);
    $query = "?lat=$latitude&lon=$longitude";
}


//defeat malicious $ incompeent user
if(empty($query) === true)
{
    throw(new RuntimeException("Invalid city detected"));
    exit;
}

// final URL to get data from
$urlGlue = "$baseUrl$query";

// fetch the raw JSON data
$jsonData = file_get_contents($urlGlue);
if($jsonData === false)
{
    throw(new RuntimeException("Unable to download weather data"));
}

// convert the JSON data into a big associative array
$weatherData = json_decode($jsonData, true);

// now do "useful Stuff with the data...
// ...as a test var dump it!
/* echo"<pre>";
var_dump($weatherData);
echo"</pre>"; */

// as a preprocessing step, format the date
$dateTime = new DateTime();
$dateTime->setTimestamp($weatherData["dt"]);
$formattedDate = $dateTime->format("Y-m-d H:i:s");

$tempConvert = floatval($weatherData["main"]["temp"]);
$NewTemp = (($tempConvert * 9/5) - 459.67);


// echo select fields from the array (cut superfluous data)
echo "<p>" . $NewTemp  . " F<br />"
           . $weatherData["main"]["pressure"] . "hPa<br />"
           . $formattedDate                   . "</p>";




?>