<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProduitRepository;
use App\Entity\Produit;
use App\Service\CartService;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Null_;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(CartService $cartService): Response
    {
        $cart = $cartService->getCart();
        $total = $cartService->getPrixTotal();
        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
            'total' => $total
        ]);
    }
    #[Route('/add/{id}', name:'cart_add')]
    public function addProduct(Request $request, CartService $cartService, EntityManagerInterface $entityManager)
{
    $productId = $request->request->get('product_id');

    if ($productId) {
        $product = $entityManager->getRepository(Produit::class)->find($productId);
        $cartService->addProduct($product, 1);
    }

    return $this->redirectToRoute('app_produit2');
    }

    

   #[Route('/remove/{id}', name:'cart_remove')]
   public function removeFromCart($id, SessionInterface $session)
{
    $cart = $session->get('cart', []);
    if (isset($cart[$id])) {
        unset($cart[$id]);
        $session->set('cart', $cart);
    }
    return $this->redirectToRoute('app_cart');
}

    #[Route('/delete', name:'cart_delete')]

    public function deleteAll(SessionInterface $session)
    {
        $session->remove("panier");

        return $this->redirectToRoute("app_cart");
    }
}
