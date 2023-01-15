<?php
class ProvinciaController
{
    private $connection;
    public static $KEY = "opcion";
    function __construct($connection)
    {
        $this->connection = $connection;
    }
    //guardar item, cierto si se ha podido insertar
    function save(Provincia $item): bool
    {
        $this->connection->hset(OpcionController::$KEY, $item->getId(), json_encode($item));
        $tempo = $this->connection->hget(OpcionController::$KEY, $item->getId());
        if ($tempo != null)
            return true;
        else
            return false;
    }
    //borra el elemento
    function remove(int $id): bool
    {
        $tempo = $this->connection->hdel(OpcionController::$KEY, $id);
        if ($tempo != null)
            return
                true;
        else
            return false;
    }

    function getAll(): ?array
    {
        $items = null;

        $elements = $this->connection->hgetAll(OpcionController::$KEY);
        if ($elements != null) {
            $items = array();
            foreach ($elements as $json_text) {
                $tempo = new Opcion();
                $tempo->loadfromJSON($json_text);
                array_push($items, $tempo);
            }
        }
        return $items;
    }
    function getById(int $id): ?Opcion
    {
        $item = null;
        $json_text = $this->connection->hget(OpcionController::$KEY, $id);
        if ($json_text != null) {
            $item = new Opcion();
            $item->loadfromJSON($json_text);
        }
        return $item;
    }
}
