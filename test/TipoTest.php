<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

include(dirname(__FILE__) . "/../Tipo.php");
include(dirname(__FILE__) . "/../TipoController.php");
final class TipoTest extends TestCase
{
    private $connection;
    private $controller;
    function __construct()
    {
        parent::__construct();
        $this->connection = new Redis();
        $this->connection->connect('127.0.0.1', 6379);
        $this->controller = new TipoController($this->connection);
        $t = new Tipo();
        $t->setId(2);
        $t->setName("Piso");
        $this->controller->save($t);
        $t = new Tipo();
        $t->setId(3);
        $t->setName("Terreno");
        $this->controller->save($t);
        $t = new Tipo();
        $t->setId(4);
        $t->setName("Chalet");
        $this->controller->save($t);
    }
    public function testSaveItem()
    {
        $t = new Tipo();
        $t->setId(1);
        $t->setName("Vivienda");
        $this->assertTrue($this->controller->save($t));
    }
    public function testGetItem()
    {
        $item = $this->controller->getById(1);
        $this->assertEquals(1, $item->getId());
    }
    public function testNoGetItem()
    {
        $item = $this->controller->getById(1);
        $this->assertNotEquals(3, $item->getId());
    }
    public function testDeleteItem()
    {
        $this->assertTrue($this->controller->remove(1));
    }
    public function testGetAll()
    {
        $items = $this->controller->getAll();
        $this->assertEquals(count($items), 3);
    }
}
