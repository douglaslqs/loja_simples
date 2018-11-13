<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Application\Model\Entity\ProdutoEntity;
use Application\Model\Entity\CategoriaEntity;
use Application\Model\Entity\ProdutoCategoriaEntity;
use Application\Model\Entity\ProdutoCaracteristicaEntity;
use Application\Model\ProdutoTable;
use Application\Model\PedidoTable;
use Application\Model\ItemTable;
use Application\Model\ClienteTable;
use Application\Model\Entity\ClienteEntity;
use Application\Model\Entity\ItemEntity;
use Application\Model\Entity\PedidoEntity;
use Application\Model\ProdutoCategoriaTable;
use Application\Model\ProdutoCaracteristicaTable;
use Application\Model\CategoriaTable;
use Zend\Session\SessionManager;
use Zend\Session\Container;

class Module
{
    const VERSION = '3.0.3-dev';

    public function onBootstrap(MvcEvent $e)
    {
        $application = $e->getApplication();
        $em = $application->getEventManager();
        $em->attach(\Zend\Mvc\MvcEvent::EVENT_RENDER, array($this, 'onRender'));
    }

    public function onRender(MvcEvent $e)
    {
        $objTableCategoria = $e->getApplication()->getServiceManager()->get('Application\Model\CategoriaTable');
        $objSession = $e->getApplication()->getServiceManager()->get('Application\Model\CategoriaTable');
        $objSessionManager = $e->getApplication()->getServiceManager()->get(SessionManager::class);
        $objSession = new Container('user', $objSessionManager);
        $arrCategoria = $objTableCategoria->fetch();
        $e->getViewModel()->categorias = $arrCategoria;
        $arrDataUser = $objSession->offsetGet('dataUser');
        $e->getViewModel()->nome = $arrDataUser['nome'];
    }

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
    	return array(
    		'factories' => array(
				'Application\Model\ProdutoTable' =>  function($sm) {
    				$tableGateway = $sm->get('ProdutoTableGateway');
    				return new ProdutoTable($tableGateway);
    			},
    			'ProdutoTableGateway' => function ($sm) {
    				$dbAdapter = $sm->get('loja-adapter');
    				$resultSetPrototype = new ResultSet();
    				$resultSetPrototype->setArrayObjectPrototype(new ProdutoEntity());
    				return new TableGateway('produto', $dbAdapter, null, $resultSetPrototype);
    			},
                'Application\Model\CategoriaTable' =>  function($sm) {
                    $tableGateway = $sm->get('CategoriaTableGateway');
                    return new CategoriaTable($tableGateway);
                },
                'CategoriaTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('loja-adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new CategoriaEntity());
                    return new TableGateway('categoria', $dbAdapter, null, $resultSetPrototype);
                },
                'Application\Model\ProdutoCategoriaTable' =>  function($sm) {
                    $tableGateway = $sm->get('ProdutoCategoriaTableGateway');
                    return new ProdutoCategoriaTable($tableGateway);
                },
                'ProdutoCategoriaTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('loja-adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new ProdutoCategoriaEntity());
                    return new TableGateway('produto_categoria', $dbAdapter, null, $resultSetPrototype);
                },
                'Application\Model\ProdutoCaracteristicaTable' =>  function($sm) {
                    $tableGateway = $sm->get('ProdutoCaracteristicaTableGateway');
                    return new ProdutoCaracteristicaTable($tableGateway);
                },
                'ProdutoCaracteristicaTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('loja-adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new ProdutoCaracteristicaEntity());
                    return new TableGateway('produto_caracteristica', $dbAdapter, null, $resultSetPrototype);
                },
                'Application\Model\ClienteTable' =>  function($sm) {
                    $tableGateway = $sm->get('ClienteTableGateway');
                    return new ClienteTable($tableGateway);
                },
                'ClienteTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('loja-adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new ClienteEntity());
                    return new TableGateway('cliente', $dbAdapter, null, $resultSetPrototype);
                },
                'Application\Model\PedidoTable' =>  function($sm) {
                    $tableGateway = $sm->get('PedidoTableGateway');
                    return new PedidoTable($tableGateway);
                },
                'PedidoTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('loja-adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new PedidoEntity());
                    return new TableGateway('pedido', $dbAdapter, null, $resultSetPrototype);
                },
                'Application\Model\ItemTable' =>  function($sm) {
                    $tableGateway = $sm->get('ItemTableGateway');
                    return new ItemTable($tableGateway);
                },
                'ItemTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('loja-adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new ItemEntity());
                    return new TableGateway('item_pedido', $dbAdapter, null, $resultSetPrototype);
                },
    		)
    	);
    }
}
