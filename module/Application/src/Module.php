<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Application\Model\Entity\ProdutoEntity;
use Application\Model\Entity\CategoriaEntity;
use Application\Model\Entity\ProdutoCategoriaEntity;
use Application\Model\Entity\ProdutoCaracteristicaEntity;
use Application\Model\ProdutoTable;
use Application\Model\ProdutoCategoriaTable;
use Application\Model\ProdutoCaracteristicaTable;
use Application\Model\CategoriaTable;

class Module
{
    const VERSION = '3.0.3-dev';

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
    		)
    	);
    }
}
