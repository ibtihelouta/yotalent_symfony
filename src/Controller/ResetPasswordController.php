<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ResetPasswordType;
use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
class ResetPasswordController extends AbstractController
{
    #[Route('/reset-password', name: 'reset_password')]
    public function resetPassword(Request $request, EntityManagerInterface $entityManager)
    {
        
        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $email = $data->getEmail();
            $user = $entityManager->getRepository(User::class)->getUserByEmail($email);
            
            if ($user) {
                // Generate and save the reset code
                $resetCode = $this->generateResetCode();
                $user->setResetCode($resetCode);
                $entityManager->flush();

                // Send the reset code to the user's email (you need to implement this)
                //create a html template for the email
                $html = '
                <html>
                    <body>
                        <p>Hi user,</p>
                        <p>Someone has requested a link to change your password. You can do this through the link below.</p>
                        <p><a href="http://localhost:8000/verify-reset-code/'.$resetCode.'">Change my password</a></p>
                        <p>If you didn\'t request this, please ignore this email.</p>
                        <p>Your password won\'t change until you access the link above and create a new one.</p>
                    </body>
                </html>
                ';


                $entityManager->getRepository(User::class)->sendEmail($email,$html);
                return $this->redirectToRoute('app_login');
            }
        }

        return $this->render('resetpassword/reset_password.html.twig', [
            'formReset' => $form->createView(),
        ]);
    }

    #[Route('/verify-reset-code/{resetCode}', name: 'verify_reset_code')]
    public function verifyResetCode(Request $request, $resetCode, EntityManagerInterface $entityManager ,UserPasswordHasherInterface $userPasswordHasher)
    {
        // Find the user by the reset code
        $user = $entityManager->getRepository(User::class)->getUserByResetCode(['resetCode' => $resetCode]);
        if (!$user) {
            // Handle invalid or expired reset code
            return $this->redirectToRoute('reset_password');
        }

        // If the reset code is valid, render the password reset form
        $form = $this->createForm(ChangePasswordType::class);
        $form->handleRequest($request);
        $data = $form->getData();


        if ($form->isSubmitted() && $form->isValid()) {
            if($data->getPassword() != $data->getConfirmPassword()){
                $this->addFlash('error', 'Password and confirm password does not match');
                return $this->redirectToRoute('verify_reset_code', ['resetCode' => $resetCode]);
            }
            // Update the user's password
            $hashedPassword = $userPasswordHasher->hashPassword($user, $data->getPassword());
            $user->setPassword($hashedPassword);
            $user->setResetCode(null);
            $entityManager->flush();

            // Redirect or render a success message
            return $this->redirectToRoute('app_login');
        }

        return $this->render('resetpassword/verify_reset_code.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function generateResetCode()
    {
        // Generate a unique reset code (you can customize the logic)
        return uniqid();
    }
}
