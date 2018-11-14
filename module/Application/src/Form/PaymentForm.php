<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter;

class PaymentForm extends Form
{
	public function __construct()
	{
		parent::__construct('cliente');
		$this->setAttribute('method', 'post');
		$this->addElements();
		$this->addInputFilter();
	}

	public function addElements()
	{
		$this->add(array(
				'name' => 'numero',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'form-control',
						'id' => 'txt-numero'
				),
				'options' => array(
						'label' => 'Número do cartão',
				),
		));

		$this->add(array(
				'name' => 'cvv',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'form-control',
						'id' => 'txt-cvv'
				),
				'options' => array(
						'label' => 'Código de segurança',
				),
		));

		$this->add(array(
				'name' => 'data',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'form-control',
						'id' => 'txt-data',
						'placeholder' => 'dd/mm/yyyy'
				),
				'options' => array(
						'label' => 'Data de Vencimento',
				),
		));

		$this->add(array(
				'name' => 'submit',
				'type' => 'Zend\Form\Element\Submit',
				'attributes' => array(
					'value' => 'Efetuar Pagamento',
					'class' => 'btn btn-warning',
				    'id' => 'login-submit',
				)
		));
	}

	public function addInputFilter()
	{
	    $inputFilter = new InputFilter\InputFilter();

	    $inputFilter->add(array(
			'name' => 'numero',
			'required' => 'true',
	        'filters' => array(
	           array('name' => 'StringTrim'),
	         ),
			'validators' => array(
				array(
					'name' => 'notEmpty',
					'options' => array(
 						'messages' => array(\Zend\Validator\NotEmpty::IS_EMPTY => 'Não pode ser vazio.'),
				   ),
				),
			),
		));

		$inputFilter->add(array(
			'name' => 'cvv',
			'required' => 'true',
	        'filters' => array(
	           array('name' => 'StringTrim'),
	         ),
			'validators' => array(
				array(
					'name' => 'notEmpty',
					'options' => array(
 						'messages' => array(\Zend\Validator\NotEmpty::IS_EMPTY => 'Não pode ser vazio.'),
				   ),
				),
			),
		));

		$inputFilter->add(array(
			'name' => 'data',
			'required' => 'true',
	        'filters' => array(
	           array('name' => 'StringTrim'),
	         ),
			'validators' => array(
				array(
					'name' => 'notEmpty',
					'options' => array(
 						'messages' => array(\Zend\Validator\NotEmpty::IS_EMPTY => 'Não pode ser vazio.'),
				   ),
				),
			),
		));

	    $this->setInputFilter($inputFilter);
	}

}