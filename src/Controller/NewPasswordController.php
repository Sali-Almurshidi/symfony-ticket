<?php

namespace App\Controller;


use App\Form\NewPasswordTypeForm;

use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Symfony\Component\HttpFoundation\Request;

class NewPasswordController extends AbstractController
{
    /**
     * @Route("/new/password", name="new_password")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return RedirectResponse|Response
     */
    public function newPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {

        $user = new User();

        $form = $this->createForm(NewPasswordTypeForm::class, $user);
        $form->handleRequest($request);
        $userEmail = $form->get('password')->getData();

        if ($form->isSubmitted()) {

            // find email in DB
            $userSelected = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $userEmail]);
            if ($userSelected) {
                // encode password
                $user->setPassword($passwordEncoder->encodePassword($user, $userEmail));

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('app_login');

            }
        }
        return $this->render('new_password/newPassword.html.twig', [
            'newPasswordForm' => $form->createView(),
        ]);


    }

}
