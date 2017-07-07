<?php

namespace ApiBundle\Direction;

use GuzzleHttp\Client;
use JMS\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;

class Direction
{
    private $directionClient;
    private $serializer;
    private $apiKey;

    public function __construct(Client $directionClient, Serializer $serializer, string $apiKey)
    {
        $this->directionClient = $directionClient;
        $this->serializer = $serializer;
        $this->apiKey = $apiKey;
    }

    public function getDirection($origin,$destination)
    {
        $uri = '/maps/api/directions/json?language=fr&origin='.$origin.'&destination='.$destination.'4&key='.$this->apiKey;
        $response = $this->directionClient->get($uri);

        $data = $this->serializer->deserialize($response->getBody()->getContents(), 'array', 'json');
        foreach ($data as $key => $value) {
              if (isset($value[0]["geocoder_status"])){
                if($value[0]["geocoder_status"] == 'OK'){
                  return $data;
                }
                else{
                  $data = new Response(json_encode(array('error' => 'true')));
$data->headers->set('Content-Type', 'application/json');

return $data;
                }
              }
        }


        // return [
        //     'city' => $data['name'],
        //     'description' => $data['weather'][0]['main']
        // ];
    }
}
