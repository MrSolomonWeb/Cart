<?php
declare(strict_types=1);
namespace Cart;

abstract class Cart
{


 abstract function addToCart();
 abstract function removeToCart();
 abstract function clearCart();
 abstract function showCart();

}

class ShoppingCart  extends Cart {
public $id,$sub,$total,$mcartProduct,$getProductById;

public function __construct(Products $cartProduct){

    $this->mcartProduct=$cartProduct;

}

    public function addToCart()
    {


        if (!isset($_GET['add'])) {
            $_GET['add'] = $_GET['add'] ?? null;

        }


        if (isset($_GET['add'])) {

            $this->getProductById = $this->mcartProduct->getProductById($_GET['add']);

        if (isset($this->getProductById) && !empty($this->getProductById)){
            if ($this->getProductById->quantity != $_SESSION['cart_' . (int) $_GET['add']]) {
                $_SESSION['cart_' . (int) $_GET['add']]+='1';
               header('Location:' . 'http://cart.test/src/index.php');
               exit();
            }
    }
    }
    }

  public  function removeToCart()
    {

        if (!isset($_GET['remove'])) {
            $_GET['remove'] = $_GET['remove'] ?? null;

        }

        if (isset($_GET['remove'])) {
            echo $_SESSION['cart_' . (int) $_GET['remove']];

            $_SESSION['cart_' . (int) $_GET['remove']]--;
            header('Location:' . 'http://cart.test/src/index.php');
            exit();

        }
    }

   public function clearCart()
    {
        if (!isset($_GET['delete'])) {
            $_GET['delete'] = $_GET['delete'] ?? null;

        }

        if (isset($_GET['delete'])) {
            $_SESSION['cart_' . (int) $_GET['delete']] = '0';
            header('Location:' . 'http://cart.test/src/index.php');
            exit();
        }
    }

 public function showCart()
 {
echo '<hr>' ;
     foreach ($_SESSION as $name => $value) {
         if ($value > 0) {
             if (substr($name, 0, 5) == 'cart_') {
                 $id = substr($name, 5, strlen($name) - 5);
                 $this->getProductById = $this->mcartProduct->getProductById($id);



                     $this->sub = $this->getProductById->price * $value;
                     echo $this->getProductById->name . ' x ' . $value . ' @ ' . $this->getProductById->price . ' = &#8381; ' . number_format($this->sub, 2) . ' <a href="index.php?remove=' . $id . '"> [-] </a> <a href="index.php?add=' . $id . '"> [+] </a> <a href="index.php?delete=' . $id . '"> Очистить </a>';
                 echo '<hr>' . '<br>'  ;
             }
             $this->total += $this->sub;
         }
     }

     if ($this->total  == 0) {
         echo 'Корзина пуста';
     } else {
         echo 'Итоговая сумма: &#8381; ' . number_format($this->total , 2);

     }
 }



}