<?php
namespace Application\Model\Entity;

class CategoriaEntity
{
	public $nome;

	public function exchangeArray($data)
	{

		$this->nome  = isset($data['nome']) ? $data['nome']         : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}