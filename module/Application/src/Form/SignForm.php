<?php
namespace Application\Form;

use Zend\InputFilter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Filter\StripTags as StripTags;
use Zend\Filter\StringTrim as StringTrim;

class SignForm extends Form
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
					    'id'    => 'email',
					    'placeholder' => 'Ex.: email@dominio.com.br'
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
				'name' => 'nome',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
				    'class' => 'form-control',
				    'id'    => 'nome'
				),
				'options' => array(
						'label' => 'Nome',
				),
		));

		$this->add(array(
				'name' => 'telefone',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
				    'class' => 'form-control',
				    'id'    => 'telefone'
				),
				'options' => array(
						'label' => 'Telefone',
				),
		));

		$this->add(array(
				'name' => 'cep',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
				    'class' => 'form-control',
				    'id'    => 'cep'
				),
				'options' => array(
						'label' => 'Cep',
				),
		));

		$this->add(array(
				'name' => 'endereco',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
				    'class' => 'form-control',
				    'id'    => 'endereco',
				    'placeholder' => 'Ex.: Rua Exemplo, 10'
				),
				'options' => array(
						'label' => 'Endereço',
				),
		));

		$this->add(array(
				'name' => 'cidade',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
				    'class' => 'form-control',
				    'id'    => 'cidade',
				    'placeholder' => 'Nome da sua cidade'
				),
				'options' => array(
						'label' => 'Cidade',
				),
		));

		$this->add(array(
				'name' => 'estado',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
					'class' => 'form-control',
					'id' => 'estado',
				),
				'options' => array(
					'label' => 'Estado',
        		    'value_options' => array(
        		    	"" => 'Selecione um Estado',
                        "AC"=>'Acre',
                        "AL"=>'Alagoas',
                        "AP"=>'Amapá',
                        "AM"=>'Amazonas',
                        "BA"=>'Bahia',
                        "CE"=>'Ceará',
                        "DF"=>'Distrito Federal',
                        "ES"=>'Espírito Santo',
                        "GO"=>'Goiás',
                        "MA"=>'Maranhão',
                        "MT"=>'Mato Grosso',
                        "MS"=>'Mato Grosso do Sul',
                        "MG"=>'Minas Gerais',
                        "PA"=>'Pará',
                        "PB"=>'Paraiba',
                        "PR"=>'Paraná',
                        "PE"=>'Pernambuco',
                        "PI"=>'Piauí',
                        "RJ"=>'Rio de Janeiro',
                        "RN"=>'Rio Grande do Norte',
                        "RS"=>'Rio Grande do Sul',
                        "RO"=>'Rondônia',
                        "RR"=>'Roraima',
                        "SC"=>'Santa Catarina',
                        "SP"=>'São Paulo',
                        "SE"=>'Sergipe',
                        "TO"=>'Tocantis',
        		    ),
			    ),
		));

		$this->add(array(
				'name' => 'submit',
				'type' => 'Zend\Form\Element\Submit',
				'attributes' => array(
					'value' => 'Cadastrar',
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

		$inputFilter->add(array(
			'name' => 'nome',
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
			'name' => 'telefone',
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
			'name' => 'cep',
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
			'name' => 'endereco',
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
			'name' => 'cidade',
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
			'name' => 'estado',
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
