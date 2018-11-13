<?php
namespace Application\Model\Entity;

class EnderecoEntregaEntity
{
	public $endereco;
	public $cliente_email;
	public $cep;
	public $cidade;
	public $estado;

	public function exchangeArray($data)
	{
		$this->endereco  = isset($data['endereco']) ? $data['endereco'] : null;
		$this->cliente_email  = isset($data['cliente_email']) ? $data['cliente_email'] : null;
		$this->cep  = isset($data['cep']) ? $data['cep'] : null;
		$this->cidade  = isset($data['cidade']) ? $data['cidade'] : null;
		$this->estado  = isset($data['estado']) ? $data['estado'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}