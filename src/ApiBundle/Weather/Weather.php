<?php
namespace ApiBundle\Weather;

use GuzzleHttp\Client;
use JMS\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;

class Weather
{
    private $weatherClient;
    private $serializer;
    private $apiKey;
    public function __construct(Client $weatherClient, Serializer $serializer, $apiKey)
    {
        $this->weatherClient = $weatherClient;
        $this->serializer = $serializer;
        $this->apiKey = $apiKey;
    }
    public function getMeteo($lat,$lon)
    {
        $uri = '/data/2.5/forecast?lat='.$lat.'&lon='.$lon.'&lang=fr&units=metric&APPID='.$this->apiKey;
        try {
        $response = $this->weatherClient->get($uri);
        } catch (\Exception $e) {
          return ['error' => 'Les informations ne sont pas disponibles pour le moment.'];
        }
        $data = $this->serializer->deserialize($response->getBody()->getContents(), 'array', 'json');
        return $data;
    }
}
