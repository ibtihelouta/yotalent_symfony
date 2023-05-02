<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Commande;
use App\Entity\Produit;
use App\Service\CartService;
use Symfony\Component\Mime\Part\DataPart;
use Gregwar\CaptchaBundle\Validator\Constraints\Captcha as CaptchaAssert;
use App\Form\CommandeType;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Doctrine\ORM\EntityManagerInterface;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use App\Repository\CommandeRepository;
use PHPUnit\TextUI\Command;
use App\Validator\CaptchaAssert\CaptchaValidator;
use App\Captcha\Captcha;



use Symfony\Component\Validator\Validator\ValidatorInterface;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
    public function index(CommandeRepository $repo): Response
    {
        $commandes = $repo->findAll();
        return $this->render('commande/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }
    #[Route('/commande/c', name: 'app_commande1')]
    public function index1(CommandeRepository $repo): Response
    {
        $commandes = $repo->findAll();
        return $this->render('commande/show.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    #[Route('/commande/add', name: 'add_commande')]
    public function create(Request $request, CartService $cartService, \Swift_Mailer $mailer,ValidatorInterface $validator): Response
    {
        $commande = new Commande();
        $commande->setPrixTotal($cartService->getPrixTotal());
        $form = $this->createForm(CommandeType::class, $commande,['action' => $this->generateUrl('add_commande'),
        'method' => 'POST',
        'label' => 'Valider',]);
        

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           
         

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commande);

           


// Create the email message
$message = (new \Swift_Message('Yotalent Store'))
    ->setFrom('hamza.bourguiga@esprit.tn')
    ->setTo($commande->getAdresse())
    ->setBody(
        '<html>'.
        '  <head></head>'.
        '  <body>'.
        '    <h1>Salut Mr/Mme '.$commande->getPrenomClient().' '.$commande->getNomClient().',</h1>'.
        '    <h2>YolTalent Store vous informe que votre commande sera confirmée lors du paiement.</h2>'.
        '    <h1>Prix Total : '.$commande->getPrixTotal().'DT'.'</h1>'.
        
        '  </body>'.
        '</html>',
        'text/html'
    );

          
                $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
                ->setUsername('hamza.bourguiga@esprit.tn')
                ->setPassword('FuckUPeople');
            
            // Create the mailer using the transport
            $mailer = new Swift_Mailer($transport);
            
            // Send the message
            $result = $mailer->send($message);
            
            if ($result) {
                echo 'Message sent successfully!';
            } else {
                echo 'An error occurred while sending the message.';
            };
    $entityManager->flush();


            // Supprimer le panier de la session
            $cartService->vider();

            return $this->redirectToRoute('app_commande1');
            
            


        }

        return $this->render('commande/add.html.twig', [
            'form' => $form->createView(),
            'total' => $commande->getPrixTotal()
        ]);
    }
    #[Route('/commande/{id}/delete', name:'commande_delete')]
 
    public function remove(ManagerRegistry $doctrine,$id): Response
    {
        $em = $doctrine->getManager();
        $commande = $doctrine->getRepository(Commande::class)->find($id);
        
            $em->remove($commande);
            $em->flush();
            return $this->redirectToRoute('app_commande');
        
    }
#[Route('/commande/{id}/edit', name:'commande_edit')]

public function editCommande(Request $request, int $id): Response
{
    $em = $this->getDoctrine()->getManager();
    $commande = $em->getRepository(Commande::class)->find($id);

    if (!$commande) {
        throw $this->createNotFoundException('La commande n\'existe pas');
    }

    $form = $this->createForm(CommandeType::class, $commande, [
        'action' => $this->generateUrl('edit_commande', ['id' => $id]),
        'method' => 'POST',
    ]);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->flush();

        return $this->redirectToRoute('app_commande', ['id' => $id]);
    }

    return $this->render('commande/add.html.twig', [
        'form' => $form->createView(),
    ]);
}




}


