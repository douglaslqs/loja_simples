<?php
namespace Application\Model\Entity;

class ProdutoEntity
{
	public $id;
	public $nome;
	public $descricao;
	public $imagem;
	public $preco;
	public $caracteristica;

	public function exchangeArray($data)
	{
		$this->id    = isset($data['id']) ? $data['id']       : null;
		$this->nome = isset($data['nome']) ? $data['nome'] : null;
		$this->descricao     = isset($data['descricao']) ? $data['descricao']         : null;
		$this->imagem = isset($data['imagem']) ? $data['imagem'] : null;
		$this->preco     	= isset($data['preco']) ? $data['preco']           : null;
		$this->caracteristica = isset($data['caracteristica']) ? $data['caracteristica'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}