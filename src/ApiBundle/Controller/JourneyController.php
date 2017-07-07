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

        $iduser=$params['iduser'];
        $user = $em->getRepository("UserBundle:User")->find($iduser);

        $direction = $this->get('app.direction');
        $datas = $direction->getDirection($origin,$destination);
        $response = new JsonResponse(array('datas' => $datas));

        $advert = new Journey();
        $advert->setStart($origin);
        $advert->setEnd($destination);
        $advert->setToken("1111");
        $advert->setUser($user);

        $em->persist($advert);
        $em->flush();
        return  $response;
    }

    /**
     * @Route("/{iduser}")
     * @Method("GET")
     */
    public function indexAction($iduser)
    {
        $em = $this->getDoctrine()->getManager();
        $list = $em->getRepository('ApiBundle:Journey')->findBy(array(
            'user' => $iduser
        ));
        $list_user = array();
        foreach ($list as $key => $value) {
            $o = new \stdClass();
            $o->id = $value->getId();
            $o->iduser = $value->getUser()->getId();
            $o->start = $value->getStart();
            $o->end = $value->getEnd();
            $list_user[$key] = $o;
        }
        $response = new JsonResponse(array('list_user' => $list_user));
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
