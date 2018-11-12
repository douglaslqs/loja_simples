<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\AbstractTable;

class ItemTable extends AbstractTable
{
	public function __construct(TableGateway $tableGateway)
	{
		parent::__construct($tableGateway);
	}

	public function filterArrayWhere($arrParams = array())
	{
		return array(
                'pedido_id' => isset($arrParams['pedido_id']) ? $arrParams['pedido_id'] : null,
                //'produto_id' => isset($arrParams['produto_id']) ? $arrParams['produto_id'] : null,
            );
	}
}