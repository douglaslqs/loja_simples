<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
	private $objTableProduto;
	private $objTableCategoria;

	public function __construct($objTableProduto, $objTableCategoria)
	{
		$this->objTableProduto = $objTableProduto;
		$this->objTableCategoria = $objTableCategoria;
	}

    public function indexAction()
    {
    	$arrProdutos = $this->objTableProduto->fetch(array(), 10);
    	$arrCategoria = $this->objTableCategoria->fetch();
    	$arrParams = array('produtos'=>$arrProdutos, 'categorias'=>$arrCategoria);
        return new ViewModel($arrParams);
    }

    public function detalheAction()
    {
    	$objRequest = $this->getRequest();
    	$arrParams = $objRequest->getQuery()->toArray();
    	$intId = !empty($arrParams['id']) ? (int)$arrParams['id'] : 0;
    	$arrProduto = $this->objTableProduto->fetchRow(array('id' => $intId));
    	$arrParams = array('produtos'=>$arrProduto);
        return new ViewModel($arrParams);
    }

    public function buscaAction()
    {
    	$objRequest = $this->getRequest();
    	$arrParams = $objRequest->getPost()->toArray();


    }

}
