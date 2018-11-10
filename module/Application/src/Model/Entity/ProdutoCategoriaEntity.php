<?php
namespace Application\Model\Entity;

class ProdutoCategoriaEntity
{
	public $produto_id;
	public $categoria_nome;

	public function exchangeArray($data)
	{
		$this->produto_id  = isset($data['produto_id']) ? $data['produto_id'] : null;
		$this->categoria_nome  = isset($data['categoria_nome']) ? $data['categoria_nome'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}