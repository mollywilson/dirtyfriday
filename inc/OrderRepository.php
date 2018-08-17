<?php

class OrderRepository
{
    /** @var mysqli */
    private $conn;

    public function __construct()
    {
        $servername = "localhost";
        $userName = "root";
        $password = "";
        $dbname = "dirty_friday_fks";

        //create connection
        $this->conn = mysqli_connect($servername, $userName, $password, $dbname);
        mysqli_select_db($this->conn,$dbname);

        // Check connection
        if ($this->conn->connect_error) {
            throw new \Exception("Connection failed: " . $this->conn->connect_error);
        }
    }

    /**
     * @param Date|null $date
     * @return array
     */
    public function getOrders($date = null)
    {
        $orderQuery = $this->conn->query(sprintf("SELECT food_order.order_id, users.name, food_order.user_id FROM food_order INNER JOIN users ON users.id = food_order.user_id WHERE food_order.date = CURDATE()"));
        $ordersResults = array_map(function ($order) {
            $itemsQuery = $this->conn->query(sprintf("SELECT item FROM food_items WHERE order_id = %s", $order['order_id']));
            $order['items'] = array_map(function ($item) {
                return $item['item'];
            }, $itemsQuery->fetch_all(MYSQLI_ASSOC));
            return $order;
        }, $orderQuery->fetch_all(MYSQLI_ASSOC));

        return $ordersResults;
    }
}