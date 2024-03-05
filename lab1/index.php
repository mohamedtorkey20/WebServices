<?php
   require_once "vendor/autoload.php";

   $cities =get_cities();

   $flage=false;

   if(isset($_POST['submit']))
   {
     $flage=true;
     $data=get_weather();

     if ($data && isset($data['main'])) {
        $name_city=$data['name'];
        $timeZone=$data['timezone'];
        $temperature = $data['main']['temp'];
        $humidity = $data['main']['humidity'];
        $description=$data['weather'][0]['description'];            
        $windSpeedMetersPerSecond = $data['wind']['speed'];
        $wind = $windSpeedMetersPerSecond * 3.6;

        $currentDateTime = new DateTime('now');
        $currentDateTime->modify("$timeZone seconds");
        $date = $currentDateTime->format("l g:i a, jS F, Y");
       $information=[$name_city,$temperature,$humidity,$description,$wind,$data];

    } 
   }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Report</title>
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.css">
    <style>
        body {
            font-family: "Poppins", Arial, sans-serif;
            font-size: 16px;
            line-height: 1.8;
            font-weight: normal;
            background: #2b3035; 
            color: gray;
        }
    </style>
</head>
<body>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mt-5 mb-5">
                    <h2 class="heading-section">Weather Report</h2>
                </div>
            </div>
            <?php if($flage){ ?>

                <div class="row">
                   <div class="col-md-12 col-lg-8 offset-3">
                   
                        <div class="row">
                            <div class="col-md-6 col-lg-9">
                                <div class="card weather-info">
                                    <div class="card-body">
                                    <h3><?= $name_city; ?> Weather Status</h1>
                                    <p><?= $formattedDateTime; ?></p>
                                        <h2><?= $description; ?></h2>
                                        <div class="weather-details">
                                            <p>Humidity: <?= $humidity; ?>%</p>
                                            <p>Temperature: <?= $temperature; ?>°C</p>
                                            <p>Wind: <?= $wind; ?> km/h</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php  }?>
            <div class="row">
                <div class="col-md-12 col-lg-8 offset-3 mt-3">
                    <div class="table-wrap">
                    <form method="post" class="table-wrap">
                        <label for="city">Choose a city:</label>
                        <select id="city" name="city">
                            <?php foreach ($cities as $city){
                            foreach($city as $id=> $name){ ?>
                                <option value="<?php echo $id; ?>"><?="IR>>".$name?></option>
                            <?php } }?>
                        </select>
                        <input type="submit" name="submit" value="Get Weather">
                    </form>
                    </div>
                </div>
            </div>
        </div>
       
   
</body>



























