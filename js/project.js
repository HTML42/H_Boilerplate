//window.google_api_key = 'AIzaSyCODRRomsGGHILSvb4H6khYF0tC79b4n1Y';
var Xtreme_startup_calls = Xtreme_startup_calls || [];
Xtreme_startup_calls.push(function () {
    //
    list_length();
    //
    $('#navi_toggler').click(function () {
        $('#navigation ul').toggleClass('active');
    });
    //
    //###GDPR related Scripts
    window.gx = new GDPRX('de');
    //gx.add_script(GX_predefined.analytics('UA-121676401-1', null, 'de'));
    /*gx.add_script(GX_predefined.maps(window.google_api_key, ['places'], function () {
        on_maps_start();
    }, 'de'));*/
    gx.startup();
});