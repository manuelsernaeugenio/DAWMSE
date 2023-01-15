<?php
class Tipo implements JsonSerializable
{
    protected $name;
    protected $id;
    function __construct()
    {
    }
    function loadfromJSON(string $json)
    {
        $tempo = json_decode($json, true);
        $this->id = $tempo["id"];
        $this->name = $tempo["name"];
    }
    function getName(): string
    {
        return $this->name;
    }
    function getId(): int
    {
        return $this->id;
    }
    function setName(string $name)
    {
        $this->name = $name;
    }
    function setId(int $id)
    {
        $this->id = $id;
    }
    public function  jsonSerialize()
    {
        return
            [
                'id'   => $this->getId(),
                'name' => $this->getName()
            ];
    }
}
