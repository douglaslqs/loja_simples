<?php
namespace Application\Model\Entity;

class PedidoEntity
{
	public $cliente_email;
	public $id;

	public function exchangeArray($data)
	{
		$this->cliente_email    = isset($data['cliente_email']) ? $data['cliente_email']       : null;
		$this->id = isset($data['id']) ? $data['id'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}