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
        travelMode: google.maps.TravelMode.DRIVING,
        unitSystem: google.maps.UnitSystem.METRIC
    }
    directionsService.route(request, function (result, status) {
        if (status == google.maps.DirectionsStatus.OK) {

            $(".info").html("<div class='alert alert-success'><strong>package_content</strong>  " + document.getElementById('package_content').value+
                ".<br/><strong>From:</strong>  "+ document.getElementById('from').value + 
                ".<br/><strong>To:</strong>  " + document.getElementById('to').value + 
                ".<br/><strong>package_content</strong>  " + document.getElementById('package_content').value +

                ".<br/><strong>package_content</strong>  " + document.getElementById('package_content').value + 
                ".<br/><strong>Driving distance:</strong>  " + result.routes[0].legs[0].distance.text + 
                ".<br/><strong>Duration:</strong>  " + result.routes[0].legs[0].duration.text + 
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