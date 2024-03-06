<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Weather
 *
 * @author webre
 */
class Weather implements Weather_Interface
{

    //put your code here
    private $url;

    public function __construct()
    {
        $this->url = __CITIES_FILE;

    }

    public function get_cities()
    {
        $citiesArray = json_decode(file_get_contents($this->url));
        return $citiesArray;
    }
    public function get_cities_country($country)
    {
        $cities = $this->get_cities();
        $country_cities = [];
        foreach ($cities as $city) {
            if ($city->country == $country) {
                array_push($country_cities, $city);
            }
        }
        return $country_cities;
    }

    public function get_weather($cityId)
    {
        $query = str_replace('{{cityid}}', $cityId, __WEATHER_URL);
        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => $query,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            )
        );

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response);
        return $response;

    }

    public function get_current_time()
    {

    }

}
