

$(function() {
    
    let map = L.map('map').setView([33.8387, -9.2215], 4);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    let icon = L.icon({
        iconUrl: '../img/icon.png',
        iconSize: [35, 35],
        iconAnchor: [18, 94],
        popupAnchor: [-3, -76],
        shadowSize: [68, 95],
        shadowAnchor: [22, 94]
    });

    $.get(`../php/sismologia.php`, function(data) {
        
        data.forEach(({location, link, date, time, magnitude, lat, long}) => {

            L.marker([lat, long],{icon: icon}).addTo(map)
                .bindPopup(`<p>${date} ${time} <br> <a href="${link}" target="_blank">${location}</a> (magnitud ${magnitude})</p>`)
                .openPopup();
        });
        

    });


})
