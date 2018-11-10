<?php

/**
*
*/
namespace Application\Controller\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Application\Model\ProdutoTable;
use Application\Model\CategoriaTable;

class IndexFactory implements FactoryInterface
{

	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
	    $tableProd = $container->get(ProdutoTable::class);
	    $tableCateg = $container->get(CategoriaTable::class);
	    $controller = new $requestedName($tableProd, $tableCateg);
	    //$controller->setForm(new ProdutoForm());
	    return $controller;
	}
}