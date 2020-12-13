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
            

            //Blue Collar City Base
            var basePrice;
            var city = document.getElementById('city').selectedIndex;
            if (city === 'Reno') {
                basePrice = 275;
                console.log(basePrice);
            } else if (city === 'Palm Springs') {
                basePrice = 325;
                console.log(basePrice);
            } else if (city === 'San Luisobispo') {
                basePrice = 450;
                console.log(basePrice);
            } else if (city === 'Fresno') {
                basePrice = 650;
                console.log(basePrice);
            }else if (city === 'Grand Junction') {
                basePrice = 650;
                console.log(basePrice);
            }else if (city === 'Aspen') {
                basePrice = 650;
                console.log(basePrice);
            }

            var distance = result.routes[0].legs[0].distance;
            var total_fair = distance*10;
            $(".info").html("<div class='alert alert-success row'><strong>Blue Collar city</strong>  " + document.getElementById('city').value+
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
                ".<br/><strong>Driving distance:</strong>  " + distance.text + 
                ".<br/><strong>Base Cost:</strong>  " + basePrice.text + 
                "</div>");

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