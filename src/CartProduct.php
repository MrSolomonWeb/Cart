<?php
namespace Cart;
interface CartProduct
{
public function getProductById($id);
public function getProducts();

}