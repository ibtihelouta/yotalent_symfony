<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProduitRepository;

class CartService
{
    
    private $session;
    private $produitRepository;

    public function __construct(SessionInterface $session, ProduitRepository $produitRepository)
    {
        $this->session = $session;
        $this->produitRepository = $produitRepository;
    }

   

    public function addProduct($produit)
    {
        $cart = $this->session->get('cart', []);

        if (!isset($cart[$produit->getId()])) {
            $cart[$produit->getId()] = [
                'product' => $produit
            ];
        } else {
            $cart[$produit->getId()];
        }

        $this->session->set('cart', $cart);
    }
    public function getCart(): array
    {
        $cart = $this->session->get('cart', []);
        $cartWithData = [];
        foreach ($cart as $id => $quantity) {
            $product = $this->produitRepository->find($id);
            if ($product) {
                $cartWithData[] = [
                    'product' => $product,
                    'quantity' => $quantity
                ];
            }
        }
        return $cartWithData;
    }
    public function getTotal()
    {
        $panier = $this->session->get('panier', []);
        $total = 0;

        foreach ($panier as $item) {
            $total += $item['article']->getPrix() * $item['quantite'];
        }

        return $total;
    }
    public function vider()
    {
        $this->session->remove('panier');
    }
    
    public function getPrixTotal(): float
    {
        $total = 0;
        $cart = $this->getCart();
        foreach ($cart as $item) {
            $total += $item['product']->getPrixP();
        }
        return $total;
    }
   
}
