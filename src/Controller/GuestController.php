<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\GuestType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GuestController extends AbstractController
{
    #[Route('/guest', name: 'app_guest')]
    public function index(UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        $userId = $user->getId();
        $user = $userRepository->getUserById($userId);

        return $this->render('guest/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/guest/edit', name: 'app_guest_edit')]
    public function edit(Request $request, UserRepository $userRepository): Response
    {
        $userId = $this->getUser()->getId();
        $user = $userRepository->getUserById($userId);
        $form = $this->createForm(GuestType::class, $user);
        $form->handleRequest($request);
        $img = $user->getImage();


        if ($form->isSubmitted() && $form->isValid()) {
            $name = $form->get('name')->getData();
            $email = $form->get('email')->getData();
            $file = $form->get('image')->getData();
            if($file)
            {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('images_directory'),
                        $fileName
                    );
                    //set img with image selected 
                    
                } catch (FileException $e){

                }
                $user->setImage($fileName);
            }
            $user->setName($name);
            $user->setEmail($email);

            // Save the updated user entity to the database
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_guest', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('guest/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
