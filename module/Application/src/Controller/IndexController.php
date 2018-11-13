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
    private $objTableCliente;
    private $objSession;
    private $objLoginForm;
    private $objSignForm;
    private $objPaymentForm;
    private $objTablePedido;
    private $objTableItem;
    private $objTableEndEnt;

	public function __construct($objTblProd,$objTblCateg,$objTblProdCateg,$objTblProdCarac,$objTblCli,$objTblPed,$objTblItem,$objTblEndEnt,$objSession)
	{
		$this->objTableProduto = $objTblProd;
        $this->objTableProdCarac = $objTblProdCarac;
		$this->objTableCategoria = $objTblCateg;
        $this->objTableProdCateg = $objTblProdCateg;
        $this->objTableCliente = $objTblCli;
        $this->objTablePedido = $objTblPed;
        $this->objTableItem = $objTblItem;
        $this->objTableEndEnt = $objTblEndEnt;
        $this->objSession = $objSession;
	}

    public function indexAction()
    {
    	$arrProdutos = $this->objTableProduto->fetch(array(), 10);
    	$arrParamsView = array('produtos'=>$arrProdutos);
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
        $arrParams = empty($arrParams) ? $objRequest->getQuery()->toArray() : $arrParams;
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
        $objRequest = $this->getRequest();
        $objSignForm = !empty($this->params('formSign')) ? $this->params('formSign') : $this->objSignForm;
        $objLoginForm = !empty($this->params('formLogin')) ? $this->params('formLogin') : $this->objLoginForm;
        $arrParams = !empty($this->params('arrParams')) ? $this->params('arrParams') : $objRequest->getQuery()->toArray();
        $arrProduto = $this->objSession->offsetGet('carrinho');
        $arrDataUser = $this->objSession->offsetGet('dataUser');
        $arrParamsView = array('produtos'=>$arrProduto,'formLogin'=>$objLoginForm,'formSign'=>$objSignForm,'formPayment'=>$this->objPaymentForm,'arrParams'=>$arrParams,'dataUser'=>$arrDataUser);
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

    public function loginAction()
    {
        $arrReturn['origin'] = 'login';
        $strAncora = "#lk-login";
        $objRequest = $this->getRequest();
        if ($objRequest->isPost()) {
            $arrParams = $objRequest->getPost()->toArray();
            $this->objLoginForm->setData($arrParams);
            if ($this->objLoginForm->isValid()) {
                try {
                    $arrDataUser = $this->objTableCliente->fetchRow(array('email'=>$arrParams['email']));
                    if (isset($arrDataUser['senha'])) {
                        if ($arrDataUser['senha'] === $arrDataUser['senha']) {
                            $this->objSession->offsetSet('dataUser', $arrDataUser);
                            $strAncora = '#lk-payment';
                        } else {
                            $arrReturn['error'] = array('senha ou e-mail' => array('inválido'));
                            $arrReturn['message'] = 'Dados não validados!';
                        }
                    }
                } catch (Exception $e) {

                }
                $this->objSession->offsetSet('dataUser', $arrDataUser);
            } else {
                $arrReturn['error'] = $this->objLoginForm->getInputFilter()->getMessages();
                $arrReturn['message'] = 'Dados não validados!';
            }
        } else {
            $arrReturn['message'] = 'Metodo de envio inesperádo! Esperando POST';
        }
        return $this->forward()->dispatch('Application\Controller\IndexController', [
            'action' => 'carrinho',
            'formLogin' => $this->objLoginForm,
            'arrParams' => $arrReturn,
        ]);
    }

    public function cadastroAction()
    {
        $arrReturn['origin'] = 'cadastro';
        $strAncora = "#lk-cadastro";
        $objRequest = $this->getRequest();
        if ($objRequest->isPost()) {
            $arrParams = $objRequest->getPost()->toArray();
            $this->objSignForm->setData($arrParams);
            if ($this->objSignForm->isValid()) {
                try {
                    $objClient = $this->objTableCliente->fetchRow(array('email'=>$arrParams['email']));
                    if (empty($objClient)) {
                        unset($arrParams['submit']);
                        $this->objTableCliente->insert($arrParams);
                        $this->objSession->offsetSet('dataUser', $arrParams);
                        $strAncora = '#lk-payment';
                    } else {
                        $arrReturn['message'] = 'Dados não validados!';
                        $arrReturn['error'] = array('email' => array('E-mail já cadastrado! Tente um e-mail diferente'));
                    }
                } catch (Exception $e) {
                    $arrReturn['message'] = 'ERRO AO TENTAR CADASTRAR SUAS INFORMAÇÕES!';
                    $arrReturn['error'] = array('ERRO: '=> array($e->getMessage()));
                }
            } else {
                $arrReturn['error'] = $this->objSignForm->getInputFilter()->getMessages();
                $arrReturn['message'] = 'Dados não validados!';
            }
        } else {
            $arrReturn['message'] = 'Metodo de envio inesperádo! Esperando POST';
        }
        return $this->forward()->dispatch('Application\Controller\IndexController', [
            'action' => 'carrinho',
            'formSign' => $this->objSignForm,
            'arrParams' => $arrReturn,
        ]);
    }

    public function pagamentoAction()
    {
        $arrReturn['origin'] = 'payment';
        $objRequest = $this->getRequest();
        if ($objRequest->isPost()) {
            $arrParams = $objRequest->getPost()->toArray();
            $this->objPaymentForm->setData($arrParams);
            if ($this->objPaymentForm->isValid()) {
                try {
                    $arrDataUser = $this->objSession->offsetGet('dataUser');
                    $intIdPedido = $this->objTablePedido->insert(array('cliente_email'=>$arrDataUser['email']));
                    foreach ($this->objSession->carrinho as $key => $value) {
                        $this->objTableItem->insert(array('produto_id'=>$value['id'],'pedido_id'=> $intIdPedido, 'qtd'=>$value['quantidade']));
                    }
                    if (isset($arrParams['cep'])) {
                        $arrInsert['cep'] = $arrParams['cep'];
                        $arrInsert['endereco'] = $arrParams['endereco'];
                        $arrInsert['cidade'] = $arrParams['cidade'];
                        $arrInsert['estado'] = $arrParams['estado'];
                        $arrInsert['cliente_email'] = $arrDataUser['email'];
                        $arrInsert['pedido_id'] = $intIdPedido;
                        $this->objTableEndEnt->insert($arrInsert);
                    }
                    $this->objSession->offsetSet('carrinho', array());
                    return $this->redirect()->toUrl('pedido-confirma?id='.$intIdPedido);
                } catch (Exception $e) {
                    $arrReturn['message'] = 'ERRO AO TENTAR EFETUAR O PAGAMENTO!';
                    $arrReturn['error'] = array('ERRO: '=> array($e->getMessage()));
                }
            } else {
                $arrReturn['error'] = $this->objPaymentForm->getInputFilter()->getMessages();
                $arrReturn['message'] = 'Dados não validados!';
            }
        } else {
            $arrReturn['message'] = 'Metodo de envio inesperádo! Esperando POST';
        }
        return $this->redirect()->toUrl('carrinho?'.http_build_query($arrReturn)."#lk-payment");
    }

    public function pedidosAction()
    {
        $arrDataUser = $this->objSession->offsetGet('dataUser');
        $arrPedidos = $this->objTablePedido->fetch(array('cliente_email'=>$arrDataUser['email']));

        if (!empty($arrPedidos) && !empty($arrDataUser['email'])) {
            $arrItems = array();
            foreach ($arrPedidos as $key => $value) {
                $arrItem = $this->objTableItem->fetch(array('pedido_id'=>$value['id']));
                $arrEndEnt = $this->objTableEndEnt->fetch(array('pedido_id'=>$value['id']));
                foreach ($arrItem as $key => $v) {
                    $arrProduto = $this->objTableProduto->fetchRow(array('id' => $v['produto_id']));
                    $arrProduto['qtd'] = $v['qtd'];
                    $arrItems[$value['id']][] = $arrProduto;
                }
            }
            $arrPedidos['itens'] = $arrItems;
            $arrPedidos['endereco_entrega'][$value['id']] = $arrEndEnt;
        } else {
            $arrPedidos = array();
        }
        $arrParamsView = array('pedidos'=>$arrPedidos,'dataUser'=>$arrDataUser);
        return new ViewModel($arrParamsView);
    }

    public function pedidoConfirmaAction()
    {
        $objRequest = $this->getRequest();
        $arrParams = $objRequest->getQuery()->toArray();
        $intId = !empty($arrParams['id']) ? (int)$arrParams['id'] : 0;

        $arrDataUser = $this->objSession->offsetGet('dataUser');
        $arrPedidos = $this->objTablePedido->fetch(array('id'=>$intId));
        if (!empty($arrPedidos) && !empty($arrDataUser['email'])) {
            $arrItems = array();
            foreach ($arrPedidos as $key => $value) {
                $arrItem = $this->objTableItem->fetch(array('pedido_id'=>$value['id']));
                $arrEndEnt = $this->objTableEndEnt->fetch(array('pedido_id'=>$value['id']));
                foreach ($arrItem as $key => $v) {
                    $arrProduto = $this->objTableProduto->fetchRow(array('id' => $v['produto_id']));
                    $arrProduto['qtd'] = $v['qtd'];
                    $arrItems[$value['id']][] = $arrProduto;
                }
            }
            $arrPedidos['itens'] = $arrItems;
            $arrPedidos['endereco_entrega'][$intId] = $arrEndEnt;
        } else {
            $arrPedidos = array();
        }
        $arrParamsView = array('pedidos'=>$arrPedidos,'dataUser'=>$arrDataUser);
        return new ViewModel($arrParamsView);
    }

    public function sairAction()
    {
        $this->objSession->getManager()->getStorage()->clear();
        $this->redirect()->toUrl('/');
    }

    public function setFormLogin($objForm)
    {
        $this->objLoginForm = $objForm;
    }

    public function setFormSign($objForm)
    {
        $this->objSignForm = $objForm;
    }

    public function setFormPayment($objForm)
    {
        $this->objPaymentForm = $objForm;
    }

}
