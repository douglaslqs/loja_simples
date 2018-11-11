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
    private $objTableProdCateg;
    private $objTableProdCarac;
    private $objSession;

	public function __construct($objTblProd, $objTblCateg, $objTblProdCateg, $objTblProdCarac, $objSession)
	{
		$this->objTableProduto = $objTblProd;
        $this->objTableProdCarac = $objTblProdCarac;
		$this->objTableCategoria = $objTblCateg;
        $this->objTableProdCateg = $objTblProdCateg;
        $this->objSession = $objSession;
	}

    public function indexAction()
    {
    	$arrProdutos = $this->objTableProduto->fetch(array(), 10);
    	$arrCategoria = $this->objTableCategoria->fetch();
    	$arrParamsView = array('produtos'=>$arrProdutos, 'categorias'=>$arrCategoria);
        return new ViewModel($arrParamsView);
    }

    public function detalheAction()
    {
    	$objRequest = $this->getRequest();
    	$arrParams = $objRequest->getQuery()->toArray();
    	$intId = !empty($arrParams['id']) ? (int)$arrParams['id'] : 0;
    	$arrProduto = $this->objTableProduto->fetchRow(array('id' => $intId));
        $arrProdCarac = $this->objTableProdCarac->fetch(array('produto_id' => $intId));
        //var_dump($arrProdCarac);exit;
    	$arrParamsView = array('produtos'=>$arrProduto, 'caracteristica'=>$arrProdCarac);
        return new ViewModel($arrParamsView);
    }

    public function buscaAction()
    {
    	$objRequest = $this->getRequest();
    	$arrParams = $objRequest->getPost()->toArray();
        $arrProdutos = array();

        if (isset($arrParams['pesq-nome']) && !empty($arrParams['pesq-nome'])) {
            $arrProdutos = $this->objTableProduto->fetch(array('nome'=>$arrParams['pesq-nome']));

        } else if (isset($arrParams['pesq-categoria']) && !empty($arrParams['pesq-categoria'])) {
            $arrIdProd = $this->objTableProdCateg->fetch(array('categoria_nome'=>$arrParams['pesq-categoria']));
            foreach ($arrIdProd as $key => $value) {
                $arrProduto = $this->objTableProduto->fetchRow(array('id'=>$value['produto_id']));
                $arrProdutos[] = $arrProduto;
            }
        }
        $arrCategoria = $this->objTableCategoria->fetch();
        $arrParamsView = array('produtos'=>$arrProdutos, 'categorias'=>$arrCategoria);

        $objView = new ViewModel($arrParamsView);
        $objView->setTemplate('application/index/index');
        return $objView;
    }

    public function addCarrinhoAction()
    {
        $objRequest = $this->getRequest();
        $arrParams = $objRequest->getQuery()->toArray();
        $intId = !empty($arrParams['id']) ? (int)$arrParams['id'] : 0;
        $arrProduto = $this->objTableProduto->fetchRow(array('id' => $intId));

        var_dump($this->objSession);exit;


        $arrParamsView = array('produtos'=>$arrProduto);
        return new ViewModel($arrParamsView);
    }

}
