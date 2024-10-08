<?php

namespace App\Classe;

use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{
    public function __construct(private RequestStack $requestStack){}

    /*
     * fonction permettant l'ajout d'un produit dans le panier
     * */
    public function add($product)
    {
        //appeler la session de symfony
        $cart = $this->getCart();

        //ajouter une quantité +1 a mon produit
        if(isset($cart[$product->getId()])) {
            $cart[$product->getId()]['quantity']++;
        } else {
        $cart[$product->getId()] = [
            "object" => $product,
            "quantity" => 1
        ];
        }
        // Creer ma session Cart
        $this->requestStack->getSession()->set('cart', $cart);
    }

    /*
     * fonction permettant de diminuer la quantité d'un produit dans le panier
     * */
    public function decrease($id)
    {
        $cart = $this->getCart();
        if(($cart[$id]['quantity'] > 1)) {
            $cart[$id]['quantity']--;
        } else {
            unset($cart[$id]);
        }
        $this->requestStack->getSession()->set('cart', $cart);
    }
    /*
     * fonction permettant de retourner la quantité total de produit dans le panier
     * */
    public function fullQuantity()
    {
        $cart = $this->getCart();
        $quantity = 0;

        if(!isset($cart)) {
            return $quantity;
        }

        foreach ($cart as $product) {
            $quantity += $product['quantity'];
        }
        return $quantity;
    }
    /*
     * fonction permettant de retourner le prix total du panier
     * */
    public function getTotalWt()
    {
        $cart = $this->getCart();
        $price = 0;

        if(!isset($cart)) {
            return $price;
        }

        foreach ($cart as $product) {
            $price += $product['object']->getPricewt() * $product['quantity'];

        }
        return $price;
    }

    /*
     * fonction permettant de supprimer un produit du panier
     * */
    public function removeProduct($id)
    {
        $cart = $this->getCart();
        if(isset($cart[$id])) {
            unset($cart[$id]);
        }

        $this->requestStack->getSession()->set('cart', $cart);
    }

    /*
     * fonction permettant de vider le panier
     * */
    public function remove()
    {
        return $this->requestStack->getSession()->remove('cart');
    }

    /*
     * fonction permettant de retourner le panier
     * */
    public function getCart()
    {
        return $this->requestStack->getSession()->get('cart');
    }
}