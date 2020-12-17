<?php 
/*
 * @Author Kumar Vibhanshu <vibhanshumonty@gmail.com>
 * @Package Courier Charge Tracker via Google map matrix js
 * visit: https://vibhanshumonty.github.io/Distance-Calculate/
 */


//Fetch Form Data
if(isset($_POST['Estimate'])){
    $collarcity = $_POST['city'];
    $collection_date = $_POST['collection_date'];
    $collection_time = $_POST['collection_time'];
    $from = $_POST['from'];
    $to = $_POST['to'];
    $package_weight = $_POST['package_weight'];
    $package_num = $_POST['package_num'];
    $package_content = $_POST['package_content'];
    $service_level = $_POST['service_level'];
    $insurance = $_POST['insurance'];
    $customer_name = $_POST['customer_name'];
    $customer_email = $_POST['customer_email'];
    $customer_phone = $_POST['customer_phone'];


    // get diatance calculation for pickup address to delivery address
    function getDistance($addressFrom, $addressTo, $unit = ''){
        // Google API key
        $apiKey = 'AIzaSyBnNfxEnrUv-5K57KJ22rfA1mhKnpIi3Yg';
        
        // Change address format
        $formattedAddrFrom    = str_replace(' ', '+', $addressFrom);
        $formattedAddrTo     = str_replace(' ', '+', $addressTo);
        
        // Geocoding API request with start address
        $geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false&key='.$apiKey);
        $outputFrom = json_decode($geocodeFrom);
        if(!empty($outputFrom->error_message)){
            return $outputFrom->error_message;
        }
        
        // Geocoding API request with end address
        $geocodeTo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrTo.'&sensor=false&key='.$apiKey);
        $outputTo = json_decode($geocodeTo);
        if(!empty($outputTo->error_message)){
            return $outputTo->error_message;
        }
        
        // Get latitude and longitude from the geodata
        $latitudeFrom    = $outputFrom->results[0]->geometry->location->lat;
        $longitudeFrom    = $outputFrom->results[0]->geometry->location->lng;
        $latitudeTo        = $outputTo->results[0]->geometry->location->lat;
        $longitudeTo    = $outputTo->results[0]->geometry->location->lng;
        
        // Calculate distance between latitude and longitude
        $theta    = $longitudeFrom - $longitudeTo;
        $dist    = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
        $dist    = acos($dist);
        $dist    = rad2deg($dist);
        $miles    = $dist * 60 * 1.1515;
        
        // Convert unit and return distance
        $unit = strtoupper($unit);
        if($unit == "K"){
            return round($miles * 1.609344, 2).' km';
        }elseif($unit == "M"){
            return round($miles * 1609.344, 2).' meters';
        }else{
            return round($miles, 2).' miles';
        }
    }
    // get diatance calculation for collar office to pickup address
    function getDistancecollar($addressFrom, $addresscollar, $unit = ''){
        // Google API key
        $apiKey = 'AIzaSyBnNfxEnrUv-5K57KJ22rfA1mhKnpIi3Yg';
        
        // Change address format
        $formattedAddrcollar    = str_replace(' ', '+', $addresscollar);
        $formattedAddrFrom    = str_replace(' ', '+', $addressFrom);
        

        // Geocoding API request with start address
        $geocodecollar = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrcollar.'&sensor=false&key='.$apiKey);
        $outputcollar = json_decode($geocodecollar);
        if(!empty($outputcollar->error_message)){
            return $outputcollar->error_message;
        }


        // Geocoding API request with start address
        $geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false&key='.$apiKey);
        $outputFrom = json_decode($geocodeFrom);
        if(!empty($outputFrom->error_message)){
            return $outputFrom->error_message;
        }
        
        // Get latitude and longitude from the geodata
        $latitudecollar    = $outputcollar->results[0]->geometry->location->lat;
        $longitudecollar    = $outputcollar->results[0]->geometry->location->lng;
        $latitudeFrom    = $outputFrom->results[0]->geometry->location->lat;
        $longitudeFrom    = $outputFrom->results[0]->geometry->location->lng;
        
          // Calculate distance between latitude and longitude
        $thetacollar    = $longitudecollar - $longitudeFrom;
        $distcollar    = sin(deg2rad($latitudecollar)) * sin(deg2rad($latitudeFrom)) +  cos(deg2rad($latitudecollar)) * cos(deg2rad($latitudeFrom)) * cos(deg2rad($thetacollar));
        $distcollar    = acos($distcollar);
        $distcollar    = rad2deg($distcollar);
        $milescollar    = $distcollar * 60 * 1.1515;
        // Convert unit and return distance
        $unit = strtoupper($unit);
        if($unit == "K"){
            return round($milescollar * 1.609344, 2).' km';
        }elseif($unit == "M"){
            return round($milescollar * 1609.344, 2).' meters';
        }else{
            return round($milescollar, 2).' miles';
        }

    }

    $addresscollar = 'Reno';
    $addressFrom = $from;
    $addressTo   = $to;

    // Get distance collar city to pickup address
    $distancecollar = (int)getDistancecollar($addresscollar, $addressFrom, "");
  
// $int = (int) filter_var($string, FILTER_SANITIZE_NUMBER_INT);  

    // Get distance pickup to delivery address
    $distance = (int)getDistance($addressFrom, $addressTo, "");



    // Total distance
    $total_distance = (($distance) + ($distancecollar)) ;


    // Basefair cost, ditance per mile/km cost, mileage cost/credit
    $basePrice;
    $distancecost;
    $mileage_credit;
    if ($collarcity === 'Reno') {
        if($service_level === 'Same Day'){
            $basePrice = "18";
            $distancecost = $total_distance * "1.20";
            $mileage_credit = "8" * "1.20";
        }else if($service_level === 'Rush'){
            $basePrice = "25";
            $distancecost = $total_distance * "1.75";
            $mileage_credit = "8" * "1.75";
        }else if($service_level === 'Next Day'){
            $basePrice = "15";
            $distancecost = $total_distance * "1";
            $mileage_credit = "8" * "1";
        }else if($service_level === 'Schedule'){
            $basePrice = "Contact Us";
            $distancecost = "Contact Us";
            $mileage_credit = "0";
        }  
    }else if ($collarcity === 'Palm Springs') {
        if($service_level === 'Same Day'){
            $basePrice = "20";
            $distancecost = $total_distance * "1.20";
            $mileage_credit = "8" * "1.20";
            }
        else if($service_level === 'Rush'){
            $basePrice = "30";
            $distancecost = $total_distance * "1.75";
            $mileage_credit = "8" * "1.75";
        }else if($service_level === 'Next Day'){
            $basePrice = "17";
            $distancecost = $total_distance * "1";
            $mileage_credit = "8" * "1";
        }else if($service_level === 'Schedule'){
            $basePrice = "Contact Us";
            $distancecost = "Contact Us";
            $mileage_credit = "0";
        } 
    }else if ($collarcity === 'San Luisobispo') {
        if($service_level === 'Same Day'){
            $basePrice = "20";
            $distancecost = $total_distance * "1.20";
            $mileage_credit = "8" * "1.20";
        }else if($service_level === 'Rush'){
            $basePrice = "35";
            $distancecost = $total_distance * "1.75";
            $mileage_credit = "8" * "1.75";
        }else if($service_level === 'Next Day'){
            $basePrice = "16";
            $distancecost = $total_distance * "1";
            $mileage_credit = "8" * "1";
        }else if($service_level === 'Schedule'){
            $basePrice = "Contact Us";
            $distancecost = "Contact Us";
            $mileage_credit = "0";
        } 
    } else if ($collarcity === 'Fresno') {
        if($service_level === 'Same Day'){
            $basePrice = "20";
            $distancecost = $total_distance * "1.20";
            $mileage_credit = "8" * "1.20";
        }else if($service_level === 'Rush'){
            $basePrice = "30";
            $distancecost = $total_distance * "1.75";
            $mileage_credit = "8" * "1.75";                   
        }else if($service_level === 'Next Day'){
            $basePrice = "16";
            $distancecost = $total_distance * "1";
            $mileage_credit = "8" * "1";
        }else if($service_level === 'Schedule'){
            $basePrice = "Contact Us";
            $distancecost = "Contact Us";
            $mileage_credit = "0";
        } 
    }else if ($collarcity === 'Grand Junction') {
        if($service_level === 'Same Day'){
            $basePrice = "20";
            $distancecost = $total_distance * "1.20";
            $mileage_credit = "8" * "1.20";
        }else if($service_level === 'Rush'){
            $basePrice = "35";
            $distancecost = $total_distance * "1.75";
            $mileage_credit = "8" * "1.75";
        }else if($service_level === 'Next Day'){
            $basePrice = "16";
            $distancecost = $total_distance * "1";
            $mileage_credit = "8" * "1";
        }else if($service_level === 'Schedule'){
            $basePrice = "Contact Us";
            $distancecost = "Contact Us";
            $mileage_credit = "0";
        } 
    }else if ($collarcity === 'Aspen') {
        if($service_level === 'Same Day'){
            $basePrice = "20";
            $distancecost = $total_distance * "1.20";
            $mileage_credit = "8" * "1.20";                   
        }else if($service_level === 'Rush'){
            $basePrice = "40";
            $distancecost = $total_distance * "1.75";
            $mileage_credit = "8" * "1.75";
        }else if($service_level === 'Next Day'){
            $basePrice = "20";
            $distancecost = $total_distance * "1";
            $mileage_credit = "8" * "1";
        }else if($service_level === 'Schedule'){
            $basePrice = "Contact Us";
            $distancecost = "Contact Us";
            $mileage_credit = "0";
        } 
    }

    //Additional cost day based
    $dateString = $collection_date;
    $day = date('l', strtotime($dateString));
    if($day === "Sunday" || $day === "Saturday"){
        $day_cost = "10";
    }else{
        $day_cost = "0";
    }

    //Additional cost time based
    $time_hrs = strtotime($collection_time);
    $hours = date('H', $time_hrs);
    if ($hours > "7" && $hours < "18") {
        $time_cost = "0";
    } else {
        $time_cost = "20";
    }

    //Package Weight cost
    $weight_cost;
    if($package_weight<="20"){
        $weight_cost = "0";
        }else{
            $weight_cost = ($package_weight * "0.25") - "5";
        }
            

    //Package Quantity Extra cost
    $package_extra_cost;
    if($package_num<="2"){
        $package_extra_cost = "0";
        }else{
            $package_extra_cost = $package_num * "10" - "20";
        }

    //Insurance cost
    $insurance_cost;
    if($insurance === "$0 to $200"){
        $insurance_cost = "0";
        }else if($insurance ==="$201 to $400"){
            $insurance_cost = "5";
        }else if($insurance === "$401 to $800"){
            $insurance_cost = "10";
        }else if($insurance === "$801 to $1500"){
            $insurance_cost = "20";
        }else if($insurance === "$1501 to $3000"){
            $insurance_cost = "30";
        }
    
    // Total fair
    $total_fair = (int)$basePrice + $time_cost + $day_cost + $weight_cost + $package_extra_cost + (int)$distancecost;

    // Sub total fair
    $sub_total = $total_fair + $insurance_cost ;

    // Grand total fair
    $grand_total = $total_fair + $insurance_cost - $mileage_credit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Arvo:400,700" rel="stylesheet">
   
    <title>Courier Charge Calculator</title>
      
</head>
<body>
    <div class="section">
        <div class="container">
            <div class="row">
                        <div class="col-xl-7 col-lg-7">
                            <div class="card shadow mb-4">
                                
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 mb-2">
                                            <div class="card">
                                              <div class="card-body">Blue Collar City <br/><?php echo $collarcity;?></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 mb-2">
                                            <div class="card">
                                              <div class="card-body">Collection Date & Time<br/><?php echo $collection_date;?>&nbsp;<?php echo $collection_time;?></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 mb-2">
                                            <div class="card">
                                              <div class="card-body">From<br/><?php echo $from;?></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 mb-2">
                                            <div class="card">
                                              <div class="card-body">To<br/><?php echo $to;?></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 mb-2">
                                            <div class="card">
                                              <div class="card-body">Weight of Packages<br/><?php echo $package_weight;?></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 mb-2">
                                            <div class="card">
                                              <div class="card-body">No. of Packages<br/><?php echo $package_num;?></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 mb-2">
                                            <div class="card">
                                              <div class="card-body">Package Content<br/><?php echo $package_content;?></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 mb-2">
                                            <div class="card">
                                              <div class="card-body">Service Level<br/><?php echo $service_level;?></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 mb-2">
                                            <div class="card">
                                              <div class="card-body">Value of goods for insurance<br/><?php echo $insurance;?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 mb-2">
                                            <div class="card">
                                              <div class="card-body">Name<br/><?php echo $customer_name;?></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 mb-2">
                                            <div class="card">
                                              <div class="card-body">Email<br/><?php echo $customer_email;?></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 mb-2">
                                            <div class="card">
                                              <div class="card-body">Phone<br/><?php echo $customer_phone;?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-5 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Result</h6>
                                    
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <table class="table">
                                        
                                        <tbody>
                                          <tr>
                                            <td>Base Cost</td>
                                            <td>
                                                <?php if($service_level === "Schedule"){
                                                    echo "Contact Us";
                                                    }else{
                                                        echo "$", $basePrice;
                                                    }
                                                ?>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>Additional Fee<br>(Time Based)</td>
                                            <td><?php echo "$",$time_cost;?></td>
                                          </tr>
                                          <tr>
                                            <td>Additional Fee<br>(Day Based)</td>
                                            <td><?php echo "$",$day_cost;?></td>
                                          </tr>
                                          <tr>
                                            <td>Weight Cost</td>
                                            <td><?php echo "$",$weight_cost;?></td>
                                          </tr>
                                          <tr>
                                            <td>Package extra cost</td>
                                            <td><?php echo "$",$package_extra_cost;?></td>
                                          </tr>
                                          <tr>
                                            <td>Distance Office to Shipper</td>
                                            <td><?php echo $distancecollar," Miles";?></td>
                                          </tr>
                                          <tr>
                                            <td>+ Distance Shipper to Consignee</td>
                                            <td><?php echo $distance," Miles";?></td>
                                          </tr>
                                          
                                          <tr>
                                            <td>= Total Distance</td>
                                            <td><?php echo $total_distance," Miles";?></td>
                                          </tr>
                                          <tr>
                                            <tr>
                                            <td>Distance Cost</td>
                                            <td>
                                                <?php if($service_level === "Schedule"){
                                                    echo "Contact Us";
                                                    }else{
                                                        echo "$", $distancecost;
                                                    }
                                                ?>
                                                
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>Total </td>
                                            <td><?php echo "$",$total_fair;?></td>
                                          </tr>
                                          <tr>
                                            <td>Insurance Cost</td>
                                            <td><?php echo "$",$insurance_cost;?></td>
                                          </tr>
                                            <td>Sub Total</td>
                                            <td><?php echo "$",$sub_total;?></td>
                                          </tr>
                                          <tr>
                                            <td>Mileage Credit</td>
                                            <td><?php echo "$",$mileage_credit;?></td>
                                          </tr>
                                          <tr>
                                            <td>Grand Total</td>
                                            <td><?php echo "$",$grand_total;?></td>
                                          </tr>
                                          
                                        </tbody><th><input type="submit" name="Request" value="Request" class="btn btn-primary"></th>

                                      </table>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   
</body>

</html>