<?php

namespace Cart;
use PDO;
use PDOException;
trait GetProducts
{
    private $db, $products, $cartprod, $quantity, $singproduct;
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
}