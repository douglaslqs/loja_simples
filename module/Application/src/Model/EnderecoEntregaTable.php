<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\AbstractTable;

class EnderecoEntregaTable extends AbstractTable
{
	public function __construct(TableGateway $tableGateway)
	{
		parent::__construct($tableGateway);
	}

	public function filterArrayWhere($arrParams = array())
	{
		return array(
                'endereco' => isset($arrParams['endereco']) ? $arrParams['endereco'] : null,
                'cliente_email' => isset($arrParams['cliente_email']) ? $arrParams['cliente_email'] : null,
            );
	}
}