var my_google_map;
var my_google_geo;

function googlemap_init( id_name, addr_name ) {
  var latlng = new google.maps.LatLng(41, 133);
  var opts = {
        zoom: 18, /*拡大比率*/
        center: latlng, /*表示枠内の中心点*/
        mapTypeId: google.maps.MapTypeId.ROADMAP,/*表示タイプの指定*/
        center: latlng, /*表示枠内の中心点*/
        mapTypeControl: false,/*マップタイプ・コントローラの制御*/
        scaleControl: false,/*地図のスケールコントローラの表示*/
        streetViewControl: true,/*ストリートビューの表示*/
        scrollwheel: false/*ホイール操作でのズーム値の変更*/
  };
  my_google_map = new google.maps.Map(document.getElementById(id_name), opts);

  my_google_geo = new google.maps.Geocoder();
  var req = {
    address: addr_name ,
  };
  my_google_geo.geocode(req, geoResultCallback);
}


function geoResultCallback(result, status) {
  if (status != google.maps.GeocoderStatus.OK) {
    alert(status);
    return;
  }
  var latlng = result[0].geometry.location;
  my_google_map.setCenter(latlng);
  var marker = new google.maps.Marker({position:latlng, map:my_google_map, title:latlng.toString(), draggable:true});
  google.maps.event.addListener(marker, 'dragend', function(event){
    marker.setTitle(event.latLng.toString());
  });
}