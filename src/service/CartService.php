<?php

namespace App\service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService{
    

    protected $session;
    protected $productRepository;

    public function __construct(SessionInterface $session, ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
        $this->session = $session;
    }

    public function add($id)
    {
        
    }

    public function remove($id)
    {
        
    }

    public function getTotal()
    {
        
    }

    public function getFullCart()
    {
        
    }
}