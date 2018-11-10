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

	public function __construct($objTableProduto)
	{
		$this->objTableProduto = $objTableProduto;
	}

    public function indexAction()
    {
    	$arrProdutos = $this->objTableProduto->fetch(array(), 10);
    	$arrParams = array('produtos'=>$arrProdutos);
        return new ViewModel();
    }

}
