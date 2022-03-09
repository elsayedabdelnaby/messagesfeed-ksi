async function getData(url = '') {
    const response = await fetch(url, {
        method: 'GET',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json'
        },
        redirect: 'follow',
        referrerPolicy: 'no-referrer'
    });
    return response.json(); // parses JSON response into native JavaScript objects
}

function hideSpinner() {
    document.getElementById('spinner')
        .style.display = 'none';
}

getData('get_locations.php')
    .then(data => {
        hideSpinner();
        initMap(data);
    });

function initMap(data) {
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 1,
        center: {
            lat: 30.033333,
            lng: 31.233334
        }
    });
    var icons = {
        "Neutrual": {
            "icon": "fa-solid fa-face-meh-blank",
            "color": "#0000FF"
        },
        "Positive": {
            "icon": "fa-solid fa-face-smile-hearts",
            "color": "#00FF00"
        },
        "Negative": {
            "icon": "fa-solid fa-face-worried",
            "color": "#FF0000"
        }
    };
    data.forEach(message => {
        const text_message = message["message"]["message"];
        const sentiment = message["message"]["sentiment"];

        Object.entries(message["locations"]).forEach(location => {
            addMarker({
                map: map,
                lat: location[1]["lat"],
                lng: location[1]["lng"],
                color: icons[sentiment].color,
                icon: icons[sentiment].icon,
                label: sentiment,
                title: text_message
            });
        });
    });
}

function addMarker(data) {
    new Marker({
        map: data.map,
        position: new google.maps.LatLng(data.lat, data.lng),
        icon: {
            path: MAP_PIN,
            fillColor: data.color,
            fillOpacity: 1,
            strokeColor: '',
            strokeWeight: 0
        },
        map_icon_label: '<i class="' + data.icon + '"></i>',
        label: data.label,
        title: data.title
    });
}

google.maps.event.addDomListener(window, 'load', getData);