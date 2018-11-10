<?php

/**
*
*/
namespace Application\Controller\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Application\Model\ProdutoTable;

class IndexFactory implements FactoryInterface
{

	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
	    $table = $container->get(ProdutoTable::class);
	    $controller = new $requestedName($table);
	    //$controller->setForm(new ProdutoForm());
	    return $controller;
	}
}