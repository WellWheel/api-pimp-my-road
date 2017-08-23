<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

class RegistrationController extends Controller
{
    /**
     * @Route("/register")
     * @Method("POST")
     */
    public function registerAction(Request $request)
    {
        $userManager = $this->get('fos_user.user_manager');
        $em = $this->getDoctrine()->getManager();
        $data = $request->request->all();

        // Do a check for existing user with userManager->findByUsername
        $user = $em->getRepository("UserBundle:User")->findOneByUsername($data['username']);


        if(!$user) {
            $user = $userManager->createUser();

            $user->setUsername($data['username']);
            $user->addRole('ROLE_TRAVELLER');
            $user->setPlainPassword($data['password']);
            $user->setEmail($data['email']);
            $user->setEnabled(true);

            $userManager->updateUser($user);
            return $this->generateToken($user, 201);
        }

        return new JsonResponse(array(
            'success' => false
        ));
    }
    protected function generateToken($user, $statusCode = 200)
    {
        // Generate the token
        $token = $this->get('lexik_jwt_authentication.jwt_manager')->create($user);

        $response = array(
            'token' => $token,
            'user'  => $user // Assuming $user is serialized, else you can call getters manually
        );

        return new JsonResponse($response, $statusCode); // Return a 201 Created with the JWT.
    }
}
