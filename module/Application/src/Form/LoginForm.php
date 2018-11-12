<?php
namespace Application\Form;

use Zend\InputFilter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Filter\StripTags as StripTags;
use Zend\Filter\StringTrim as StringTrim;

class LoginForm extends Form
{
	public function __construct($name = null, $options = array())
	{
		parent::__construct($name, $options);
		$this->addElements();
		$this->addInputFilter();
	}

	public function addElements()
	{
		$this->add(array(
					'name' => 'email',
					'type' => 'Zend\Form\Element\Email',
					'attributes' => array(
						'class' => 'form-control',
					    'id'    => 'email'
					),
					'options' => array(
						'label' => 'E-mail',
					),
				));

		$this->add(array(
				'name' => 'senha',
				'type' => 'Zend\Form\Element\Password',
				'attributes' => array(
				    'class' => 'form-control',
				    'id'    => 'senha'
				),
				'options' => array(
						'label' => 'Senha',
				),
		));

		$this->add(array(
				'name' => 'submit',
				'type' => 'Zend\Form\Element\Submit',
				'attributes' => array(
					'value' => 'Entrar',
					'class' => 'btn btn-warning',
				    'id' => 'login-submit',
				)
		));
	}

	public function addInputFilter()
	{
		$inputFilter = new InputFilter\InputFilter();

		$inputFilter->add(array(
			'name' => 'email',
		    'filters' => array(
	           array('name' => 'StringTrim'),
		    ),
			'required' => 'true',
			'validators' => array(
			    array(
			        'name' => 'EmailAddress',
			        'options' =>array(
			            'messages' => array(
	 			                'emailAddressInvalid' => 'Email inválido',
	 			                'emailAddressInvalidHostname' => 'O Host não é válido para o endereço de e-mail',
			                 ),
			             ),
			    ),
			),
		));

		$inputFilter->add(array(
			'name' => 'senha',
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
