<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

include(dirname(__FILE__) . "/../Provincia.php");
include(dirname(__FILE__) . "/../Localidad.php");
include(dirname(__FILE__) . "/../ProvinciaController.php");
final class ProvinciaTest extends TestCase
{
    private $connection;
    private $controller;
    function __construct()
    {
        parent::__construct();
        $this->connection = new Redis();
        $this->connection->connect('127.0.0.1', 6379);
        $this->controller = new ProvinciaController($this->connection);

        $item = new Provincia();
        $item->setId(1);
        $item->setName("Alicante");
        $item->setAcive(true);
        $localidad = new Localidad();
        $localidad->setId(1);
        $localidad->setName("Rojales");
        $item->addLocalidad($localidad);


        $localidad = new Localidad();
        $localidad->setId(2);
        $localidad->setName("Almoradi");
        $item->addLocalidad($localidad);


        $localidad = new Localidad();
        $localidad->setId(3);
        $localidad->setName("Torrevieja");
        $item->addLocalidad($localidad);

        $this->controller->save($item);
        $item = new Provincia();
        $item->setId(2);
        $item->setName("Murcia");
        $item->setAcive(true);

        $localidad = new Localidad();
        $localidad->setId(4);
        $localidad->setName("Totana");
        $item->addLocalidad($localidad);

        $localidad = new Localidad();
        $localidad->setId(5);
        $localidad->setName("San Javier");
        $item->addLocalidad($localidad);

        $localidad = new Localidad();
        $localidad->setId(6);
        $localidad->setName("Cartagena");
        $item->addLocalidad($localidad);
        $this->controller->save($item);

        $item = new Provincia();
        $item->setId(3);
        $item->setName("Albacete");
        $item->setAcive(true);

        $localidad = new Localidad();
        $localidad->setId(1);
        $localidad->setName("Almansa");

        $item->addLocalidad($localidad);

        $localidad = new Localidad();
        $localidad->setId(1);
        $localidad->setName("La Roda");
        $item->addLocalidad($localidad);

        $this->controller->save($item);
    }

    public function testSaveItem()
    {
        $t = new Provincia();
        $t->setId(5);
        $t->setName("Baleares");
        $this->assertTrue($this->controller->save($t));
    }
    public function testGetItem()
    {
        $item = $this->controller->getById(1);
        $this->assertEquals(1, $item->getId());
    }
    public function testNoGetItem()
    {
        $item = $this->controller->getById(5);

        $this->assertNotEquals(3, $item->getId());
    }
    public function testDeleteItem()
    {
        $this->assertTrue($this->controller->remove(5));
    }
    public function testGetAll()
    {
        $items = $this->controller->getAll();

        $this->assertEquals(count($items), 3);
    }
    public function testGetAllLocalidades()
    {
        $items = $this->controller->getAllLocalidades();
        $this->assertEquals(count($items), 7);
    }
    public function testAddLocalidadtoProvincia()
    {

        $localidad = new Localidad();
        $localidad->setId(10);
        $localidad->setName("Orihuela");
        $item = $this->controller->getById(1);
        $item->addLocalidad($localidad);
        $this->controller->save($item);
        $this->assertEquals(count($item->getLocalidades()), 4);
    }
    public function testFindLocalidad()
    {
        $items = $this->controller->findLocalidad("Rojales");
        $this->assertEquals(count($items), 1);
    }
}
