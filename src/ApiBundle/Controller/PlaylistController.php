<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiBundle\Entity\Playlist;
use ApiBundle\Entity\JourneyPlaylist;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/playlist")
 */
class PlaylistController extends Controller
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

        $idPlaylist = $params['idplaylist'];
        $title = $params['title'];

        $playlist = new Playlist();
        $playlist->setToken($idPlaylist);
        $playlist->setTitle($title);
        $playlist->setAffected(0);

        $em->persist($playlist);
        $em->flush();

        $success = false;

        if($playlist) {
          $success = true;
        }

        // $idJourney = $params['idjourney'];
        // if($idJourney) {
        //   $journey = $em->getRepository("ApiBundle:Journey")->find($idJourney);
        //   $affect = $this->affectPlaylistToJourney($playlist, $journey);
        //   if($affect) {
        //     $success = true;
        //   }
        // }

        return new JsonResponse(array('success' => $success));
    }

    /**
     * @Route("/new-playlist-to-journey")
     * @Method("POST")
     */
    public function newPlaylistToJourneyAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $params = array();
        $content = $request->getContent();
        if (!empty($content))
        {
            $params = json_decode($content,true); // 2nd param to get as array
        }

        $idplaylist=$params['idplaylist'];

        $playlist = $em->getRepository("ApiBundle:Playlist")->findOneByToken($idplaylist);

        if(!$playlist) {
          $playlist = new Playlist();
          $title = $params['title'];
          $playlist->setToken($idplaylist);
          $playlist->setTitle($title);
          $playlist->setAffected(0);

          $em->persist($playlist);
          $em->flush();
        }

        $idjourney=$params['idjourney'];
        $journey = $em->getRepository("ApiBundle:Journey")->find($idjourney);

        $success = false;

        $affect = $this->affectPlaylistToJourney($playlist, $journey);

        if($affect) {
          $success = true;
        }

        return new JsonResponse(array('success' => $success));
    }

    public function affectPlaylistToJourney($playlist, $journey)
    {
        $em = $this->getDoctrine()->getManager();

        $playlistJourney = new JourneyPlaylist();
        $playlistJourney->setJourney($journey);
        $playlistJourney->setPlaylist($playlist);
        $em->persist($playlistJourney);

        $playlist->setAffected($playlist->getAffected() + 1);

        $em->persist($playlist);
        $em->flush();
        $success = false;

        if ($playlistJourney) {
          $success = true;
        }

        return $success;
    }


    /**
     * @Route("/journey/{idjourney}")
     * @Method("GET")
     */
    public function indexAction($idjourney)
    {
        $em = $this->getDoctrine()->getManager();
        $playlists = $em->getRepository('ApiBundle:JourneyPlaylist')->findByJourney($idjourney);

        $list_playlist = array();
        foreach ($playlists as $key => $playlist) {
            $o = new \stdClass();
            $o->id = $playlist->getId();
            $o->token = $playlist->getPlaylist()->getToken();
            $o->name = $playlist->getPlaylist()->getTitle();
            $o->lecture = $playlist->getPlaylist()->getAffected();
            $list_playlist[$key] = $o;
        }
        $response = new JsonResponse(array('list_playlist' => $list_playlist));
        return $response;
    }

}
