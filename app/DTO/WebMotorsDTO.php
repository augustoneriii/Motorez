<?php
namespace App\DTO;

class WebMotorsDTO
{
    public $id;
    public $marca;
    public $modelo;
    public $ano;
    public $combustivel;
    public $km;
    public $preco;
    public $origem;

    public function __construct($id = null, $marca = null, $modelo = null, $ano = null, $combustivel = null, $km = null, $preco = null, $origem = null)
    {
        $this->id = $id;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->ano = $ano;
        $this->combustivel = $combustivel;
        $this->km = $km;
        $this->preco = $preco;
        $this->origem = $origem;
    }

    public static function fromArray(array $data)
    {
        return new self(
            $data['id'] ?? null,
            $data['marca'] ?? null,
            $data['modelo'] ?? null,
            $data['ano'] ?? null,
            $data['combustivel'] ?? null,
            $data['km'] ?? null,
            $data['preco'] ?? null,
            $data['origem'] ?? null
        );
    }
}
