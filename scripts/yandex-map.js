var coords, cityname, sourcePoint;
jQuery(document).ready(function ($) {
    var theyandexid = '#billing_city_field';
    if (idehweb_yandexmap && idehweb_yandexmap.yandexidfiled) {
        theyandexid = '#' + idehweb_yandexmap.yandexidfiled;
    }
    console.log('theyandexid', theyandexid);
    $(theyandexid).append("<button type='button' id='kjhftyuil'>Показать на карте</button>");
    $(theyandexid).append("<div class='kjytyui'><div class='dfgfd'></div> <div style='' id='bgvvgcvfrcr'></div>" +
        "<button type='button' id='kjhgfbn'>подтвердить</button>" +
        "</div> ");
    ymaps.ready(init);

    $('body').on('click', '#kjhftyuil', function (e) {
        e.preventDefault();

        $('.kjytyui').css('display', 'block');
    });
    $('body').on('click', '#kjhgfbn', function (e) {
        e.preventDefault();
        $('.kjytyui').css('display', 'none');
        // $('.kjytyui').empty();

        $('#billing_yandex_location').val(coords);
        $('#'+idehweb_yandexmap.yandex_billing_city).val(cityname);
        console.log('coords isL ', coords);
    });
    $('body').on('click', '.dfgfd', function (e) {
        e.preventDefault();
        // $('.kjytyui').empty();
        $('.kjytyui').css('display', 'none');

    });
});


function init() {
    var myMap = new ymaps.Map("bgvvgcvfrcr", {
        center: [41.322295, 69.242820], // Tashkent
        zoom: 14
    }, {
        balloonMaxWidth: 200,
        searchControlProvider: 'yandex#search'
    }), sourcePoint;
    // sourcePoint = new ymaps.Placemark([ 35.68663800531445,51.362227133339374], {iconContent: idehweb_yandexmap.IamHere}, {preset: 'islands#greenStretchyIcon'});
    coords = myMap.getCenter();
    // myMap.geoObjects.add(sourcePoint);
    // sourcePoint = new ymaps.Placemark(coords, {iconContent: idehweb_yandexmap.IamHere}, {preset: 'islands#greenStretchyIcon'});
    //
    // myMap.geoObjects.add(sourcePoint);

    /**
     * Processing events that occur when the user
     * left-clicks anywhere on the map.
     * When such an event occurs, we open the balloon.
     */
    myMap.events.add('actionend', function (e) {
        // console.log('gfds')
        clearSourcePoint();
        coords = myMap.getCenter();
        sourcePoint = new ymaps.Placemark(coords, {iconContent: idehweb_yandexmap.IamHere}, {preset: 'islands#greenStretchyIcon'});
        // myMap.geoObjects.add(sourcePoint);
        getAddress(sourcePoint, coords);

    });
    // myMap.events.add('click', function (e) {
    //     clearSourcePoint();
    //     // console.log('e',e);
    //     coords = e.get('coords');
    //     sourcePoint = new ymaps.Placemark(coords, {iconContent: idehweb_yandexmap.IamHere}, {preset: 'islands#greenStretchyIcon'});
    //
    //     myMap.geoObjects.add(sourcePoint);
    //     getAddress(sourcePoint, coords);
    //     console.log('coords', coords);
    //
    // });

    function clearSourcePoint(keepSearchResult) {
        // if (!keepSearchResult) {
        //     searchControl.hideResult();
        // }

        if (sourcePoint) {
            myMap.geoObjects.remove(sourcePoint);
            sourcePoint = null;
        }
    }

    function getAddress(sourcePoint, coords) {
        coords = myMap.getCenter();
        sourcePoint = new ymaps.Placemark(coords, {iconContent: idehweb_yandexmap.IamHere}, {preset: 'islands#greenStretchyIcon'});

        sourcePoint.properties.set('iconContent', 'searching...');
        ymaps.geocode(coords).then(function (res) {
            var firstGeoObject = res.geoObjects.get(0);
            cityname = [firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(), firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()].filter(Boolean).join(', ');
            console.log('firstGeoObject.getAddressLine()', cityname);
            sourcePoint.properties
                .set({
                    // Forming a string with the object's data.
                    iconContent: cityname,
                    // Specifying a string with the address of the object as the balloon content.
                    balloonContent: firstGeoObject.getAddressLine()
                });
        });
    }
}