<?php

namespace App\DTOs;

class WebMotorsDTO
{
    public $id;
    public $marca;
    public $modelo;
    public $ano;
    public $versao;
    public $cor;
    public $km;
    public $combustivel;
    public $cambio;
    public $portas;
    public $preco;
    public $date;
    public $opcionais;

    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->marca = $data['marca'];
        $this->modelo = $data['modelo'];
        $this->ano = $data['ano'];
        $this->versao = $data['versao'];
        $this->cor = $data['cor'];
        $this->km = $data['km'];
        $this->combustivel = $data['combustivel'];
        $this->cambio = $data['cambio'];
        $this->portas = $data['portas'];
        $this->preco = $data['preco'];
        $this->date = $data['date'];
        $this->opcionais = $data['opcionais'];
    }

    public static function fromArray(array $data): WebMotorsDTO
    {
        return new self($data);
    }

    public static function fromCollection(array $collection): array
    {
        return array_map(function ($item) {
            return self::fromArray($item);
        }, $collection);
    }
}
