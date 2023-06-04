<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MobileAppController extends AbstractController
{
    #[Route('/mobile/app', name: 'app_mobile_app')]
    public function index(): JsonResponse
    {
        return $this->json(['message' => 'Welcome to the mobile app API']);
    }

    #[Route('/mobile/app/user', name: 'app_mobile_app_user', methods: ['POST'])]
    public function addUser(Request $request,EntityManagerInterface $entityManager,UserPasswordHasherInterface $userPasswordHasher): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $name = $data['name'];
        $email = $data['email'];
        $role = $data['role'];
        $password = $data['password'];
        $image = $data['image'];
        $user = new User();
        $user->setName($name);
        $user->setEmail($email);
        $user->setRoles($role);
        $user->setPassword($userPasswordHasher->hashPassword($user,$password));
        $user->setImage($image);

        $entityManager->persist($user);
        $entityManager->flush();
    
    
        return new JsonResponse(['message' => 'User added successfully'], JsonResponse::HTTP_CREATED);
    }
    #[Route('/mobile/app/user/delete', name: 'app_mobile_app_delete_user', methods: ['POST'])]
    public function deleteUser(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $id = $data['id'];
        $user = $userRepository->getUserById($id);
        
        if (!$user) {
            return new JsonResponse(['message' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
        }
        
        $entityManager->remove($user);
        $entityManager->flush();
    
        return new JsonResponse(['message' => 'User deleted successfully'], JsonResponse::HTTP_OK);
    }
    

}
