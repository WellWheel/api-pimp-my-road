<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiBundle\Entity\Journey;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/meteo")
 */
class MeteoController extends Controller
{

    /**
     * @Route("/")
     * @Method("POST")
     */
    public function indexAction(Request $request)
    {
        $params = array();
        $content = $request->getContent();
        if (!empty($content))
        {
            $params = json_decode($content,true); // 2nd param to get as array
        }
        $lat=$params['lat'];
        $lon=$params['lon'];
        $direction = $this->get('app.weather');
        $datas = $direction->getMeteo($lat,$lon);
        $response = new JsonResponse(array('datas' => $datas));

        return  $response;
    }
}
