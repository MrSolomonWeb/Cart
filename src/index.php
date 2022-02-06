<?php
declare(strict_types=1);
session_start();
require __DIR__ . './../vendor/autoload.php';
use Cart\Products;
use Cart\ShoppingCart;


$d = Products::instanceDb();

echo $d->getProducts();
$z = new ShoppingCart($d);
echo $z->showCart();
echo $z->addToCart();
echo $z->removeToCart();
echo $z->clearCart();

