<?php
namespace Application\Model\Entity;

class ClienteEntity
{
	public $email;
	public $password;
	public $name;
	public $telefone;
	public $cep;
	public $endereco;
	public $cidade;
	public $estado;

	public function exchangeArray($data)
	{
		$this->email    = isset($data['email']) ? $data['email']       : null;
		$this->password = isset($data['password']) ? $data['password'] : null;
		$this->name     = isset($data['name']) ? $data['name']         : null;
		$this->telefone = isset($data['telefone']) ? $data['telefone'] : null;
		$this->cep     	= isset($data['cep']) ? $data['cep']           : null;
		$this->endereco = isset($data['endereco']) ? $data['endereco'] : null;
		$this->cidade 	= isset($data['cidade']) ? $data['cidade']     : null;
		$this->estado	= isset($data['estado']) ? $data['estado']     : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}