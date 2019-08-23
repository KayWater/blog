<?php
namespace App\Utilities;

class AMaps
{
    /**
     * 通过真实地址获取对应经纬度
     * @param $address
     * @param $city
     * @param $state
     * @param $zip
     * @return mixed
     */
    public static function geocodeAddress($address, $city, $state)
    {
        $address = urlencode($state . $city . $address);

        $apikey = config('services.amap.ws_api_key');

        $url = 'https://restapi.amap.com/v3/geocode/geo?address=';
        $url .= $address . '&key=' . $apikey;

        $client = new Client();

        $geocodeResponse = $client->get($url)->getBody();
        $geocodeData = json_decode($geocodeResponse);

        $coordinates['lat'] = null;
        $coordinates['lng'] = null;

        if ( !empty($geocodeData) && $geocodeData->status 
            && isset($geocodeData->geocodes) && isset($geocodeData->geocodes[0])) {
                list($latitude, $longitude) = explode(',', $geocodeData->geocodes[0]->location);
                $coordinates['lat'] = $latitude;
                $coordinates['lng'] = $longitude;
        }

        return $coordinates;
    }
}