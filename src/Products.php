<?php
declare(strict_types=1);

namespace Cart;


use Exception;
use PDO;
use PDOException;


final class Products implements CartProduct
{

    private static $instance = null;
    private $db, $products, $cartprod, $quantity, $singproduct;

    private function __construct()
    {
        try {
            $this->db = new PDO('mysql:host=127.0.0.1;dbname=cart', 'root', '');

        } catch (PDOException $e) {
            die('Сайт не работает.');
        }
    }

    public static function instanceDb(): ?Products
    {

        if (self::$instance === null) {
            self::$instance = new Products();
        }
        return self::$instance;
    }

    public function __wakeup()
    {
        throw new Exception("Cannot unserialize a singleton.");
    }

    public function getProductById($id)
    {
        $this->quantity = $this->db->prepare("SELECT * FROM products WHERE id  = :pr_id");

        $this->quantity->execute([
            'pr_id' => (int)$id,
        ]);


        $this->singproduct = $this->quantity->fetch(PDO::FETCH_OBJ);


        return $this->singproduct;


    }

    public function getProducts()
    {

        $this->products = $this->db->query("
	SELECT id, name, price, description FROM products WHERE quantity > 0 ORDER BY id DESC
");


        $this->cartprod = $this->products->fetchAll(PDO::FETCH_OBJ);

        ob_start();
        foreach ($this->cartprod as $good):
            ?>
            <div class="good">
                <h4><?php echo $good->name; ?></h4>
                <p><?php echo $good->description; ?></p>
                <p><?php echo $good->price; ?></p>

                <p><a href="index.php?add=<?php echo $good->id; ?>">Добавить в корзину</a></p>

            </div>
        <?php endforeach;
        $this->cartprod = ob_get_contents();
        ob_end_clean();

        return $this->cartprod;
    }

    private function __clone()
    {
    }


}