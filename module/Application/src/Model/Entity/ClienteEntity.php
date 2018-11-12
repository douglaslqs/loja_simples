<?php
namespace Application\Model\Entity;

class ClienteEntity
{
	public $email;
	public $senha;
	public $nome;
	public $telefone;
	public $cep;
	public $endereco;
	public $cidade;
	public $estado;

	public function exchangeArray($data)
	{
		$this->email    = isset($data['email']) ? $data['email']       : null;
		$this->senha = isset($data['senha']) ? $data['senha'] : null;
		$this->nome     = isset($data['nome']) ? $data['nome']         : null;
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