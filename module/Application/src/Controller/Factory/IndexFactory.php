<?php

/**
*
*/
namespace Application\Controller\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Application\Model\ProdutoTable;
use Application\Model\CategoriaTable;
use Application\Model\ProdutoCategoriaTable;
use Application\Model\ProdutoCaracteristicaTable;
use Zend\Session\SessionManager;
use Zend\Session\Container;

class IndexFactory implements FactoryInterface
{

	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
	    $tableProd = $container->get(ProdutoTable::class);
	    $tableCateg = $container->get(CategoriaTable::class);
	    $tableProdCateg = $container->get(ProdutoCategoriaTable::class);
	    $tableProdCarac = $container->get(ProdutoCaracteristicaTable::class);
	    $objSessionManager = $container->get(SessionManager::class);
	    $objSession = new Container('user', $objSessionManager);
	    $controller = new $requestedName($tableProd, $tableCateg, $tableProdCateg, $tableProdCarac, $objSession);
	    //$controller->setForm(new ProdutoForm());
	    return $controller;
	}
}