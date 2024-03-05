<?php
require("autoload.php");
ini_set('memory_limit', '-1');
$weather = new Weather();
$egyptian_cities = $weather->get_cities_country("EG");
$cityObject;
if (isset($_POST["submit"])) {
    // var_dump($_POST["selectedCity"]);
    foreach ($egyptian_cities as $city) {
        if ($_POST["selectedCity"] == $city->name) {
            $cityObject = $city;
        }
    }
}
$cityId = isset($cityObject) ? $cityObject->id : "361058";
$city_weather_data = $weather->get_weather($cityId);
$time_zone_offset = $city_weather_data->timezone;
$current_time = time() + $time_zone_offset;
$formatted_time = date('Y-m-d H:i:s', $current_time);
$day_name = date('l', $current_time);
$time_ampm = date('h:i A', $current_time);
$date_formatted = date('jS F Y', $current_time);
$time_zone_offset = $city_weather_data->timezone;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Api</title>
</head>
<body>
    <h1>
        <?php
        echo $_POST["selectedCity"] ? $_POST["selectedCity"] : "Alexandria";
        ?>
        Weather Status
    </h1>
    <p>
        <span>
            <?php
            echo "$day_name $time_ampm";
            ?>
        </span>
    </p>
    <p>
        <span>
            <?php
            echo "$date_formatted";
            ?>
        </span>
    </p>
    <p>
        <span>
            <?php
            echo $city_weather_data->weather[0]->description;
            ?>
        </span>
    </p>
    <p>
        <span>
            <?php
            echo "Temperature: " . $city_weather_data->main->temp_max . "&#8451;" . " " . $city_weather_data->main->temp_min . "&#8451;";
            ?>
        </span>
    </p>
    <p>
        <span>
            <?php
            echo "Humidity: " . $city_weather_data->main->humidity . "%";
            ?>
        </span>
    </p>
    <p>
        <span>
            <?php
            echo "Wind: " . number_format($city_weather_data->wind->speed * 10000 / 3600, 1) . " km/h";
            ?>
        </span>
    </p>


    <form method="post">
        <select name="selectedCity" id="">
            <?php
            foreach ($egyptian_cities as $city) {
                echo "<option value='$city->name'>$city->name</option>";
            }
            ?>

        </select>
        <button name="submit" type="submit">Get Weather</button>
    </form>
</body>
</html>