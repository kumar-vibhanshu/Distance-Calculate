/*
 * @Author Kumar Vibhanshu <vibhanshumonty@gmail.com>
 * @Package Courier Charge Tracker via Google map matrix js
 * visit: https://vibhanshumonty.github.io/Distance-Calculate/
 */



var directionsDisplay, directionsService;
var map;
var london = {
    lat: 51.5,
    lng: -0.1
}
var submitBtn = $(".btn");

function initialize() {

    var mapOptions = {
        center: london,
        zoom: 8,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    directionsService = new google.maps.DirectionsService();
    directionsDisplay = new google.maps.DirectionsRenderer();
    map = new google.maps.Map(document.getElementById('map'), mapOptions);
    directionsDisplay.setMap(map);

    var from = document.getElementById("from");
    var to = document.getElementById("to");
    var options = {
        types: ['(cities)']
    }
    var autocomplete1 = new google.maps.places.Autocomplete(from, options);
    var autocomplete2 = new google.maps.places.Autocomplete(to, options);
}


submitBtn.on('click', function () {
    calcRoute();

})


function calcRoute() {
    var request = {
        origin: document.getElementById('from').value,
        destination: document.getElementById('to').value,
        // travelMode: google.maps.TravelMode.DRIVING,TRANSIT
        travelMode: google.maps.TravelMode.TRANSIT,
        unitSystem: google.maps.UnitSystem.METRIC
    }

    directionsService.route(request, function (result, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            
            var distance = result.routes[0].legs[0].distance;
            var distancemiles = (distance.text.replace(/\D/g,'')) * "0.62";//miles upto two decimal place

            //Base price (Collar city / Service Level)
            var basePrice;
            var distancecost;
            var mileage_credit;
            var city = document.getElementById('city').value;
            var service_level = document.getElementById('service_level').value;
            if (city === 'Reno') {
                if(service_level === 'Same Day'){
                    basePrice = "18";
                    console.log(basePrice);
                    distancecost = distancemiles * "1.20";
                    mileage_credit = "8" * "1.20";
                    console.log(mileage_credit);
                }else if(service_level === 'Rush'){
                    basePrice = "25";
                    console.log(basePrice);
                    distancecost = distancemiles * "1.75";
                    mileage_credit = "8" * "1.75";
                    console.log(mileage_credit);
                }else if(service_level === 'Next Day'){
                    basePrice = "15";
                    console.log(basePrice);
                    distancecost = distancemiles * "1";
                    mileage_credit = "8" * "1";
                    console.log(mileage_credit);
                } 
            } else if (city === 'Palm Springs') {
                if(service_level === 'Same Day'){
                    basePrice = "20";
                    console.log(basePrice);
                    distancecost = distancemiles * "1.20";
                    mileage_credit = "8" * "1.20";
                    console.log(mileage_credit);
                }else if(service_level === 'Rush'){
                    basePrice = "30";
                    console.log(basePrice);
                    distancecost = distancemiles * "1.75";
                    mileage_credit = "8" * "1.75";
                    console.log(mileage_credit);
                }else if(service_level === 'Next Day'){
                    basePrice = "17";
                    console.log(basePrice);
                    distancecost = distancemiles * "1";
                    mileage_credit = "8" * "1";
                    console.log(mileage_credit);
                }
            } else if (city === 'San Luisobispo') {
                if(service_level === 'Same Day'){
                    basePrice = "20";
                    console.log(basePrice);
                    distancecost = distancemiles * "1.20";
                    mileage_credit = "8" * "1.20";
                    console.log(mileage_credit);
                }else if(service_level === 'Rush'){
                    basePrice = "35";
                    console.log(basePrice);
                    distancecost = distancemiles * "1.75";
                    mileage_credit = "8" * "1.75";
                    console.log(mileage_credit);
                }else if(service_level === 'Next Day'){
                    basePrice = "16";
                    console.log(basePrice);
                    distancecost = distancemiles * "1";
                    mileage_credit = "8" * "1";
                    console.log(mileage_credit);
                }
            } else if (city === 'Fresno') {
                if(service_level === 'Same Day'){
                    basePrice = "20";
                    console.log(basePrice);
                    distancecost = distancemiles * "1.20";
                    mileage_credit = "8" * "1.20";
                    console.log(mileage_credit);
                }else if(service_level === 'Rush'){
                    basePrice = "30";
                    console.log(basePrice);
                    distancecost = distancemiles * "1.75";
                    mileage_credit = "8" * "1.75";
                    console.log(mileage_credit);
                }else if(service_level === 'Next Day'){
                    basePrice = "16";
                    console.log(basePrice);
                    distancecost = distancemiles * "1";
                    mileage_credit = "8" * "1";
                    console.log(mileage_credit);
                }
            }else if (city === 'Grand Junction') {
                if(service_level === 'Same Day'){
                    basePrice = "20";
                    console.log(basePrice);
                    distancecost = distancemiles * "1.20";
                    mileage_credit = "8" * "1.20";
                    console.log(mileage_credit);
                }else if(service_level === 'Rush'){
                    basePrice = "35";
                    console.log(basePrice);
                    distancecost = distancemiles * "1.75";
                    mileage_credit = "8" * "1.75";
                    console.log(mileage_credit);
                }else if(service_level === 'Next Day'){
                    basePrice = "16";
                    console.log(basePrice);
                    distancecost = distancemiles * "1";
                    mileage_credit = "8" * "1";
                    console.log(mileage_credit);
                }
            }else if (city === 'Aspen') {
                if(service_level === 'Same Day'){
                    basePrice = "20";
                    console.log(basePrice);
                    distancecost = distancemiles * "1.20";
                    mileage_credit = "8" * "1.20";
                    console.log(mileage_credit);
                }else if(service_level === 'Rush'){
                    basePrice = "40";
                    console.log(basePrice);
                    distancecost = distancemiles * "1.75";
                    mileage_credit = "8" * "1.75";
                    console.log(mileage_credit);
                }else if(service_level === 'Next Day'){
                    basePrice = "20";
                    console.log(basePrice);
                    distancecost = distancemiles * "1";
                    mileage_credit = "8" * "1";
                    console.log(mileage_credit);
                }
            };

            //Additional cost day based
            const week_of_day_arr = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            var dateString = document.getElementById('collection_date').value;
            var day = week_of_day_arr[new Date(dateString).getDay()];
            if(day === "Sunday" || day === "Saturday"){
                day_cost = "10";
                
            }else{
                day_cost = "0";
                
            };


            //Additional cost Time based
            var inputEle = document.getElementById('collection_time');
            var timeSplit = inputEle.value.split(':'),
                hours,
                minutes,
                meridian,cost;
              hours = timeSplit[0];
              minutes = timeSplit[1];
              if (hours > 7 && hours < 18) {
                time_cost = "0";
              } else {
                time_cost = "20";
              }

            
            //Weight cost
            var weight_cost;
            var package_weight = document.getElementById('package_weight').value;
            
            if(package_weight<="20"){
                weight_cost = "0";
                console.log(weight_cost);
            }else{
                weight_cost = package_weight * "0.25" - "5";
                console.log(weight_cost);
            };

            //Package Extra cost
            var package_extra_cost;
            var package_num = document.getElementById('package_num').value;
            
            if(package_num<="2"){
                package_extra_cost = "0";
                console.log(package_extra_cost);
            }else{
                package_extra_cost = package_num * "10" - "20";
                console.log(package_extra_cost);
            };

            //Insurance cost
            var insurance_cost;
            var insurance = document.getElementById('insurance').value;
            
            if(insurance === "$0 to $200"){
                insurance_cost = "0";
                console.log(insurance_cost);
            }else if(insurance === "$201 to $400"){
                insurance_cost = "5";
                console.log(insurance_cost);
            }else if(insurance === "$401 to $800"){
                insurance_cost = "10";
                console.log(insurance_cost);
            }else if(insurance === "$801 to $1500"){
                insurance_cost = "20";
                console.log(insurance_cost);
            }else if(insurance === "$1501 to $3000"){
                insurance_cost = "30";
                console.log(insurance_cost);
            };

            var total_fair = ((basePrice*"1") + (day_cost*"1") + (time_cost*"1") + (weight_cost*"1") + (package_extra_cost*"1") + (distancecost*"1"));
            console.log(total_fair);

            var subtotal = ((basePrice*"1") + (day_cost*"1") + (time_cost*"1") + (weight_cost*"1") + (package_extra_cost*"1") + (distancecost*"1") + (insurance_cost*"1"));
            console.log(subtotal);

            var grand_total = ((basePrice*"1") + (day_cost*"1") + (time_cost*"1") + (weight_cost*"1") + (package_extra_cost*"1") + (distancecost*"1") + (insurance_cost*"1") - (mileage_credit*"1"));
            console.log(grand_total);

            $(".info").html("<div class='alert alert-success row'><div class='col-lg-7'><strong>Blue Collar city</strong>  " + document.getElementById('city').value+
                ".<br/><strong>Collection Date & Time</strong>  "+ document.getElementById('collection_date').value +"&nbsp;" + document.getElementById('collection_time').value + 
                ".<br/><strong>From:</strong>  "+ document.getElementById('from').value + 
                ".<br/><strong>To:</strong>  " + document.getElementById('to').value + 
                ".<br/><strong>Weight of package:</strong>  "+ document.getElementById('package_weight').value + 
                ".<br/><strong>No. of package:</strong>  "+ document.getElementById('package_num').value + 
                ".<br/><strong>Package Content</strong>  " + document.getElementById('package_content').value +
                ".<br/><strong>Service Level:</strong>  "+ document.getElementById('service_level').value + 
                ".<br/><strong>Value of goods for insurance:</strong>  "+ document.getElementById('insurance').value + 
                ".<br/><strong>Name</strong>  " + document.getElementById('customer_name').value + 
                ".<br/><strong>Email</strong>  " + document.getElementById('customer_email').value + 
                ".<br/><strong>phone</strong>  " + document.getElementById('customer_phone').value + 
                
                
                "</div><div class='col-lg-5'><h3>Result</h3><br/><strong>Base Cost:</strong>  $" + basePrice +
                ".<br/><strong>Additional Cost (Time Based):</strong>  $" + time_cost + 
                ".<br/><strong>Additional Cost (Day Based):</strong>  $" + day_cost + 
                ".<br/><strong>Weight Cost:</strong>  $" + weight_cost + 
                ".<br/><strong>Package Extra Cost:</strong>  $" + package_extra_cost + 

                ".<br/><br/><strong>Distance:</strong>  " + distancemiles + 
                "miles.<br/><strong>Distance Cost:</strong>  $" + distancecost + 


                ".<br><br/><strong>Total:</strong>  $" + total_fair + 
                ".<br/><strong>Insurance Cost:</strong>  $" + insurance_cost + 
                ".<br/><strong>Sub Total:</strong>  $" + subtotal + 
                ".<br/><strong>Mileage Credit:</strong>  $" + mileage_credit + 
                ".<br/><strong>Grand Total:</strong>  $" + grand_total + 
                "</div></div>");
            $(".container").hide();
            $(".info").show();
            directionsDisplay.setDirections(result);
        } else {
            directionsDisplay.setDirections({
                routes: []
            });
            map.setCenter(london);
            $(".info").html("<div class='alert alert-warning'><strong>Could not retrieve driving distance.</strong></div>");
        }


    });   
}