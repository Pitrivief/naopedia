<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Observation;
use App\Entity\User;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;


class AdminController extends BaseAdminController
{
  public function checkAction()
     {
       // controllers extending the base AdminController get access to the
       // following variables:
       //   $this->request, stores the current request
       //   $this->em, stores the Entity Manager for this Doctrine entity

       $id = $this->request->query->get('id');
       $observation = $this->em->getRepository(Observation::Class)->find($id);

       return $this->render("checkObservation.html.twig", array(
          'observation' => $observation ));
      }

      /**
       * @Route("/admin/valid{observationId}", name="valid")
       */
      public function observationAction($observationId)
      {
         $em = $this->getDoctrine()->getManager();
         $observation = $em->getRepository(Observation::Class)->find($observationId);

         $observation->setValid(True);
         $em->persist($observation);
         $em->flush();
          return $this->redirectToRoute('admin');
      }

      /**
       * @Route("/admin/refuse{observationId}", name="refuse")
       */
      public function RefuseAction($observationId, Request $request)
      {
        $refuseMessage = $request->request->get('refuseMessage');
        $em = $this->getDoctrine()->getManager();
        $observation = $em->getRepository(Observation::Class)->find($observationId);

        $observation->setRefuseMessage($refuseMessage);
        $em->persist($observation);
        $em->flush();

          return $this->redirectToRoute('admin');
      }

      /**
       * @Route("/admin/changeRole{userId}", name="changeRole")
       * @Security("has_role('ROLE_ADMIN')")
       */
      public function changeRoleAction($userId, Request $request)
      {

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($userId);


        $roles= $request->request->get('ROLE');
        $user->setRoles($roles);

        $em->persist($user);
        $em->flush();

          return $this->redirectToRoute('homepage');
      }

      /**
       * @Route("/admin/checkProfil{id}", name="checkProfil")
       * @Security("has_role('ROLE_ADMIN')")
       */
      public function checkProfilAction()
      {
         $id = $this->request->query->get('id');
         $user = $this->em->getRepository(User::Class)->find($id);

        return $this->redirectToRoute("userpage", array('username' => $user->getUsername()));
      }

}