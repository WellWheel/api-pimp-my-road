<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiBundle\Entity\Journey;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/journey")
 */
class JourneyController extends Controller
{
    /**
     * @Route("/create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $params = array();
        $content = $request->getContent();

        if (!empty($content))
        {
            $params = json_decode($content,true); // 2nd param to get as array
        }
        $em = $this->getDoctrine()->getManager();

        $origin=$params['origin'];
        $destination=$params['destination'];

        $direction = $this->get('app.direction');
        $datas = $direction->getDirection($origin,$destination);

        $advert = new Journey();
        $advert->setStart($origin);
        $advert->setEnd($destination);
        $advert->setToken("1111");
        $advert->setUser($this->getUser());

        $em->persist($advert);
        $em->flush();
        $response = new JsonResponse(array('datas' => $datas, 'idJourney' => $advert->getId()));
        return  $response;
    }
    /**
     * @Route("/show/{idJourney}")
     * @Method("GET")
     */
    public function showAction(Request $request, $idJourney)
    {
        $params = array();
        $content = $request->getContent();

        if (!empty($content))
        {
            $params = json_decode($content,true); // 2nd param to get as array
        }
        $em = $this->getDoctrine()->getManager();

        $journey = $em->getRepository("ApiBundle:Journey")->find($idJourney);

        $direction = $this->get('app.direction');
        $datas = $direction->getDirection($journey->getStart(),$journey->getEnd());
        $info = array();
        $info['start'] = $journey->getStart();
        $info['end'] = $journey->getEnd();

        $jp = $em->getRepository("ApiBundle:JourneyPlaylist")->findOneByJourney($idJourney);

        if(!$jp) {
            $playlist = "No Playlist";
        } else {
            $playlist = $jp->getPlaylist()->getToken();
        }


        $response = new JsonResponse(array('datas' => $datas, 'info' => $info, 'playlist' => $playlist ));

        return  $response;
    }

    /**
     * @Route("/list")
     * @Method("GET")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $iduser = $this->getUser()->getId();
        $list = $em->getRepository('ApiBundle:Journey')->findBy(array(
            'user' => $iduser
        ));
        $listjourney = array();
        foreach ($list as $key => $value) {
            $o = new \stdClass();
            $o->id = $value->getId();
            $o->iduser = $value->getUser()->getId();
            $o->start = $value->getStart();
            $o->end = $value->getEnd();
            $listjourney[$key] = $o;
        }
        $response = new JsonResponse(array('list_journey' => $listjourney));
        return $response;
    }

    /**
     * @Route("/show/{idjourney}")
     * @Method("GET")
     */
    public function indexAction($idjourney)
    {
        $em = $this->getDoctrine()->getManager();
        $journey = $em->getRepository('ApiBundle:Journey')->find($idjourney);
        $o = new \stdClass();
        $o->id = $journey->getId();
        $o->iduser = $journey->getUser()->getId();
        $o->start = $journey->getStart();
        $o->end = $journey->getEnd();
        $response = new JsonResponse(array('journey' => $o));
        return $response;
    }

    /**
     * @Route("/delete/{id}")
     * @Method("DELETE")
     */
    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();
        $journey = $em->getRepository('ApiBundle:Journey')->find($id);
        $sucess = false;
        if ($journey){
            $em->remove($journey);
            $em->flush();
            $sucess = true;
        }
        $response = new JsonResponse(array('success' => $sucess));
        return $response;
    }

    /**
     * @Route("/update/{idJourney}")
     * @Method("POST")
     */
    public function updateAction($idJourney,Request $request){
        $params = array();
        $content = $request->getContent();
        if (!empty($content))
        {
            $params = json_decode($content,true); // 2nd param to get as array
        }
        $sucess = false;
        $em = $this->getDoctrine()->getManager();
        $journey = $em->getRepository('ApiBundle:Journey')->find($idJourney);
        if ($journey) {
            if(isset($params['origin'])) {
                $journey->setStart($params['origin']);
            }
            if(isset($params['end'])) {
                $journey->setStart($params['end']);
            }

            $em->persist($journey);
            $em->flush();
            $sucess = true;
        }
        $response = new JsonResponse(array('success' => $sucess));
        return $response;
    }
}
