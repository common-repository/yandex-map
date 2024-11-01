var coords;
jQuery(document).ready(function ($) {
    coords = $('#htgfrdfgvrfe').text();
    coords = coords.split(',').filter(x => x.trim().length && !isNaN(x)).map(Number);
    // console.log('gfds', coords);
    if (coords && coords[0])
        ymaps.ready(init);


});


function init() {
    var myMap = new ymaps.Map("bgvvgcvfrcr", {
        center: coords, // Uglich
        zoom: 14
    }, {
        balloonMaxWidth: 200,
        searchControlProvider: 'yandex#search'
    }), sourcePoint;
    sourcePoint = new ymaps.Placemark(coords, {iconContent: ""}, {preset: 'islands#greenStretchyIcon'});

    myMap.geoObjects.add(sourcePoint);


}