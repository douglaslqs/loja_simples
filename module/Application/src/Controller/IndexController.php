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
    private $objLoginForm;

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

    public function carrinhoAction()
    {
        $arrProduto = $this->objSession->offsetGet('carrinho');
        $arrParamsView = array('produtos'=>$arrProduto,'form'=>$this->objLoginForm);
        return new ViewModel($arrParamsView);
    }

    public function addCarrinhoAction()
    {
        $objRequest = $this->getRequest();
        $arrParams = $objRequest->getQuery()->toArray();
        $intId = !empty($arrParams['id']) ? (int)$arrParams['id'] : 0;
        $arrProduto = $this->objTableProduto->fetchRow(array('id' => $intId));

        $arrSessCarrinho = $this->objSession->offsetGet('carrinho');
        if (isset($arrSessCarrinho) && !empty($arrSessCarrinho)) {
            if (isset($arrSessCarrinho[$arrProduto['id']]) && $arrSessCarrinho[$arrProduto['id']] > 1) {
                $arrSessCarrinho[$arrProduto['id']]['quantidade'] += 1;
            } else {
                $arrSessCarrinho[$arrProduto['id']] = $arrProduto;
                $arrSessCarrinho[$arrProduto['id']]['quantidade'] = 1;
            }
        } else {
            $arrSessCarrinho[$arrProduto['id']] = $arrProduto;
            $arrSessCarrinho[$arrProduto['id']]['quantidade'] = 1;
        }
        $this->objSession->offsetSet('carrinho', $arrSessCarrinho);
       // var_dump($this->objSession->offsetGet('carrinho'));exit;

        return $this->redirect()->toUrl('carrinho');
    }

    public function removeCarrinhoAction()
    {
        $objRequest = $this->getRequest();
        $arrParams = $objRequest->getQuery()->toArray();
        $intId = !empty($arrParams['id']) ? (int)$arrParams['id'] : 0;
        $arrProduto = $this->objTableProduto->fetchRow(array('id' => $intId));

        $arrSessCarrinho = $this->objSession->offsetGet('carrinho');
        if (isset($arrSessCarrinho) && !empty($arrSessCarrinho)) {
            if (isset($arrSessCarrinho[$arrProduto['id']])) {
                if ($arrSessCarrinho[$arrProduto['id']]['quantidade'] <= 1) {
                    unset($arrSessCarrinho[$arrProduto['id']]);
                } else {
                    $arrSessCarrinho[$arrProduto['id']]['quantidade'] -= 1;
                }
            }
        }
        $this->objSession->offsetSet('carrinho', $arrSessCarrinho);
        return $this->redirect()->toUrl('carrinho');
    }

    public function cadastroAction()
    {
        $arrReturn['status'] = false;
        $objRequest = $this->getRequest();
        if ($objRequest->isPost()) {
            $arrParams = $objRequest->getPost()->toArray();
            $this->objLoginForm->setData($arrParams);
            if ($this->objLoginForm->isValid()) {
                //Salvar dados no banco
            } else {
                $arrReturn['message'] = 'Dados não validados! '.var_dump($this->objLoginForm->getInputFilter()->getMessages(), true);
            }
        } else {
            $arrReturn['message'] = 'Metodo de envio inesperádo! Esperando POST';
        }
        echo json_encode($arrReturn);exit;
    }

    public function setFormLogin($objForm)
    {
        $this->objLoginForm = $objForm;
    }

}
