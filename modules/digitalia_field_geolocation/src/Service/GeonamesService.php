<?php

namespace Drupal\digitalia_field_geolocation\Service;

class GeonamesService {

  public function getLocationData($url) {
    $username = 'digitalia_muni_arts';
    $geonames_id = explode('/', trim(parse_url($url, PHP_URL_PATH), '/'))[0];
    $api_url = 'http://api.geonames.org/get?geonameId=' . $geonames_id . '&username=' . $username;

    $xml = file_get_contents($api_url);

    if ($xml === false) {
      \Drupal::logger('digitalia_field_geolocation')->error('Failed to fetch data from GeoNames API for URL: @url', ['@url' => $url]);
      return [];
    }
    
    $simplexml = simplexml_load_string($xml);

    $location_data = [
      'country' => (string) $simplexml->countryName,
      'adm1' => (string) $simplexml->adminName1,
      'adm2' => (string) $simplexml->adminName2,
      'adm3' => (string) $simplexml->adminName3,
      'adm4' => (string) $simplexml->adminName4,
      'adm5' => (string) $simplexml->adminName5,
      'lat' => (string) $simplexml->lat,
      'long' => (string) $simplexml->lng,
    ];

    return $location_data;
  }
}