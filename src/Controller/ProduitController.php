<?php

namespace App\Controller;

use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\ProduitType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Gregwar\CaptchaBundle\CaptchaBuilderInterface;



class ProduitController extends AbstractController
{
    #[Route('/produit', name: 'app_produit')]
    public function index(ProduitRepository $repo,Request $request,PaginatorInterface $paginator): Response
    {
        $produits = $repo->findAll();
        $produits = $paginator->paginate(
            $produits,
            $request->query->getInt('page', 1),
            4// items per page
        );
        return $this->render('produit/index.html.twig', [
            'produits' => $produits,
        ]);
    }
    #[Route('/produit/index2', name: 'app_produit2')]
    public function list(ProduitRepository $repo,Request $request,PaginatorInterface $paginator): Response
    {
        $produits = $repo->findAll();
        $produits = $paginator->paginate(
            $produits,
            $request->query->getInt('page', 1),
            3// items per page
        );
        return $this->render('produit/index2.html.twig', [
            'produits' => $produits,
        ]);
    }
   
    #[Route('/produit/add', name: 'add_produit')]
    public function add(ManagerRegistry $doctrine,Request $request,SluggerInterface $slugger): Response
    {
        
        $em = $doctrine->getManager();
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {

             /** @var UploadedFile $brochureFile */
             $brochureFile = $form->get('imgP')->getData();

             // this condition is needed because the 'brochure' field is not required
             // so the PDF file must be processed only when a file is uploaded
             if ($brochureFile) {
                 $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                 // this is needed to safely include the file name as part of the URL
                 $safeFilename = $slugger->slug($originalFilename);
                 $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();
 
                 // Move the file to the directory where brochures are stored
                 try {
                     $brochureFile->move(
                         $this->getParameter('produit_directory'),
                         $newFilename
                     );
                 } catch (FileException $e) {
                     // ... handle exception if something happens during file upload
                 }
 
                 // updates the 'brochureFilename' property to store the PDF file name
                 // instead of its contents
                 $produit->setImgP($newFilename);
             }

            $em->persist($produit);
            $em->flush();

           
            return $this->redirectToRoute('add_produit');
        }
        return $this->renderForm('produit/add.html.twig', [
            'form' => $form,
        ]);}
      
        #[Route('/produit/remove/{id}', name: 'remove_produit')]
        public function remove(ManagerRegistry $doctrine,$id): Response
        {
            $em = $doctrine->getManager();
            $produit = $doctrine->getRepository(Produit::class)->find($id);
            
                $em->remove($produit);
                $em->flush();
                return $this->redirectToRoute('app_produit');
            
        }
        #[Route('produit/update/{id}', name: 'produit_update')]
        public function update(ManagerRegistry $doctrine,$id,Request $req): Response {
            $em = $doctrine->getManager();
            $produit = $doctrine->getRepository(Produit::class)->find($id);
            $form = $this->createForm(ProduitType::class,$produit);
            $form->handleRequest($req);
            if($form->isSubmitted()){
                $em->persist($produit);
                $em->flush();
                return $this->redirectToRoute('app_produit');
            }
            return $this->renderForm('produit/add.html.twig',['form'=>$form]);
    
        }

        #[Route('/produit/byid/{id}', name: 'app_produit_show')]
        public function getbyid(ProduitRepository $produitrepositery, $id ): Response
        {
            $detailsproduit = $produitrepositery -> find($id);
            return $this->render('produit/index.html.twig', [
              'details' => $detailsproduit  ,
              
            ]);
    }
    #[Route('/produit/rech', name: 'app_produit_search')]
    public function search(Request $request ,EntityManagerInterface $entityManager , PaginatorInterface $paginator )
        {
            $searchTerm = $request->query->get('q');
            $queryBuilder = $entityManager->createQueryBuilder();
            $queryBuilder
                ->select('p')
                ->from(Produit::class, 'p')
                ->where('p.idP LIKE :searchTerm')
                ->orWhere('p.nomP LIKE :searchTerm')
                ->orWhere('p.descriptionP LIKE :searchTerm')
                ->orWhere('p.prixP LIKE :searchTerm')
                ->setParameter('searchTerm', '%' . $searchTerm . '%');
    
            $produit = $queryBuilder->getQuery()->getResult();
            $pagination = $paginator->paginate(
              $produit,
              $request->query->getInt('page', 1),
              3
          );
    
            return $this->render('produit/index2.html.twig', [
                'produits' => $pagination,
                'searchTerm' => $searchTerm
            ]);
        }


        #[Route('/produit/rech1', name: 'app_produit_search1')]
    public function search1(Request $request ,EntityManagerInterface $entityManager , PaginatorInterface $paginator )
        {
            $searchTerm = $request->query->get('q');
            $queryBuilder = $entityManager->createQueryBuilder();
            $queryBuilder
                ->select('p')
                ->from(Produit::class, 'p')
                ->where('p.idP LIKE :searchTerm')
                ->orWhere('p.nomP LIKE :searchTerm')
                ->orWhere('p.descriptionP LIKE :searchTerm')
                ->orWhere('p.prixP LIKE :searchTerm')
                ->setParameter('searchTerm', '%' . $searchTerm . '%');
    
            $produit = $queryBuilder->getQuery()->getResult();
            $pagination = $paginator->paginate(
              $produit,
              $request->query->getInt('page', 1),
              3
          );
    
            return $this->render('produit/index.html.twig', [
                'produits' => $pagination,
                'searchTerm' => $searchTerm
            ]);
        }
    
        

       
        
        

}


        



    

