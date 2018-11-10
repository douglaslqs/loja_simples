<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\AbstractTable;

class ProdutoCategoriaTable extends AbstractTable
{
	public function __construct(TableGateway $tableGateway)
	{
		parent::__construct($tableGateway);
	}

	public function filterArrayWhere($arrParams = array())
	{
		return array(
                'produto_id' => isset($arrParams['produto_id']) ? $arrParams['produto_id'] : null,
                'categoria_nome' => isset($arrParams['categoria_nome']) ? $arrParams['categoria_nome'] : null,
            );
	}
}