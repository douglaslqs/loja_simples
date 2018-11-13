<?php

/**
*
*/
namespace Application\Controller\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Application\Model\ProdutoTable;
use Application\Model\PedidoTable;
use Application\Model\ItemTable;
use Application\Model\CategoriaTable;
use Application\Model\ProdutoCategoriaTable;
use Application\Model\ClienteTable;
use Application\Model\ProdutoCaracteristicaTable;
use Application\Model\EnderecoEntregaTable;
use Application\Form\LoginForm;
use Application\Form\SignForm;
use Application\Form\PaymentForm;
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
	    $tableCli = $container->get(ClienteTable::class);
	    $tablePed = $container->get(PedidoTable::class);
	    $tableItem = $container->get(ItemTable::class);
	    $tableEndEnt = $container->get(EnderecoEntregaTable::class);
	    $objSessionManager = $container->get(SessionManager::class);
	    $objSession = new Container('user', $objSessionManager);
	    $controller = new $requestedName($tableProd,$tableCateg,$tableProdCateg,$tableProdCarac,$tableCli,$tablePed,$tableItem,$tableEndEnt,$objSession);
	    $controller->setFormLogin(new LoginForm());
	    $controller->setFormSign(new SignForm());
	    $controller->setFormPayment(new PaymentForm());
	    return $controller;
	}
}