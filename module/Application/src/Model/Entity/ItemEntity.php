<?php
namespace Application\Model\Entity;

class ItemEntity
{
	public $pedido_id;
	public $produto_id;

	public function exchangeArray($data)
	{
		$this->pedido_id    = isset($data['pedido_id']) ? $data['pedido_id']       : null;
		$this->produto_id = isset($data['produto_id']) ? $data['produto_id'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}