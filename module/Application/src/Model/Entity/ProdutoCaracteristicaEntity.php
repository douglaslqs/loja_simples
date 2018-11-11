<?php
namespace Application\Model\Entity;

class ProdutoCaracteristicaEntity
{
	public $produto_id;
	public $caracteristica_nome;
	public $valor;

	public function exchangeArray($data)
	{
		$this->produto_id  = isset($data['produto_id']) ? $data['produto_id'] : null;
		$this->caracteristica_nome  = isset($data['caracteristica_nome']) ? $data['caracteristica_nome'] : null;
		$this->valor  = isset($data['valor']) ? $data['valor'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}