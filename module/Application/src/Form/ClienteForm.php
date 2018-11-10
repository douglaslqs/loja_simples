<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter;

class ClienteForm extends Form
{
	public function __construct()
	{
		parent::__construct('cliente');
		$this->setAttribute('method', 'post');
		$this->addElements();
	}

	public function addElements()
	{
		$this->add(array(
				'name' => 'nome',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'class' => 'form-control',
						'id' => 'txt-nome'
				),
				'options' => array(
						'label' => 'Nome',
				),
		));

		$this->add(array(
				'name' => 'submit',
				'type' => 'Zend\Form\Element\Submit'
		));
	}

	public function addInputFilter()
	{
	    $inputFilter = new InputFilter\InputFilter();

	    $inputFilter->add(array(
	        'name' => 'email',
	        'required' => true,
	        'validators' => array(
	            array(
	                'name' => 'notEmpty',
	                'options' => array(
	                    'messages' => array(
	                        'isEmpty' => 'The field not is empty'
	                    ),
	                ),
	                'name' => 'StringLength',
	                 'options' => array(
	                     'min' => 3,
	                     'max' => 64,
	                     'messages' => array(
	                         'stringLengthTooShort' => 'Minimun 3 chacacteres not reached',
	                         'stringLengthTooLong' => 'Maximun 64 chacacteres ultrapassed',
	                     ),
	                ),
	                'name' => 'EmailAddress',
	               /* 'options' => array(
	                     'messages' => array(
	                         //'emailAddressInvalidFormat' => 'The input is not a valid email address. Use the basic format local-part@hostname',
	                         //'emailAddressInvalidHostname' => 'The host name not is valid'
	                     ),
	                ),*/
	            ),
	        ),
	    ));

	    $inputFilter->add(array(
	        'name' => 'type',
	        'required' => $required,
	        'continue_if_empty' => true,//not empty
	        'validators' => array(
	            array(
	                'name' => 'StringLength',
	                 'options' => array(
	                     'min' => 2,
	                     'max' => 2,
	                     'messages' => array(
	                         'stringLengthTooShort' => 'Minimun 2 chacacteres not reached',
	                         'stringLengthTooLong' => 'Maximun 2 chacacteres ultrapassed',
	                     ),
	                ),
	                'name' => 'InArray',
                     'options' => array(
                        'haystack' => array('PJ','PF'),
                        'messages' => array(
                            'notInArray' => "Types acepts 'PF' or 'PJ'"
                        ),
                    ),
	            ),
	        ),
	    ));

	    $inputFilter->add(array(
	        'name' => 'password',
	        'required' => true,
	        'continue_if_empty' => true,//not empty
	        'validators' => array(
	            array(
	                'name' => 'StringLength',
	                 'options' => array(
	                     'min' => 6,
	                     'max' => 20,
	                     'messages' => array(
	                         'stringLengthTooShort' => 'Minimun 6 chacacteres not reached',
	                         'stringLengthTooLong' => 'Maximun 20 chacacteres ultrapassed',
	                     ),
	                ),
	            ),
	        ),
	    ));

	    $inputFilter->add(array(
	        'name' => 'name',
	        'required' => true,
	        'continue_if_empty' => true,//not empty
	        'validators' => array(
	            array(
	                'name' => 'StringLength',
	                 'options' => array(
	                     'min' => 3,
	                     'max' => 128,
	                     'messages' => array(
	                         'stringLengthTooShort' => 'Minimun 3 chacacteres not reached',
	                         'stringLengthTooLong' => 'Maximun 128 chacacteres ultrapassed',
	                     ),
	                ),
	            ),
	        ),
	    ));

	    $inputFilter->add(array(
	        'name' => 'telefone',
	        'required' => true,
	        'continue_if_empty' => true,//not empty
	        'validators' => array(
	            array(
	                'name' => 'StringLength',
	                 'options' => array(
	                     'min' => 10,
	                     'max' => 15,
	                     'messages' => array(
	                         'stringLengthTooShort' => 'Minimun 10 chacacteres not reached',
	                         'stringLengthTooLong' => 'Maximun 15 chacacteres ultrapassed',
	                     ),
	                ),
	            ),
	        ),
	    ));
	    $this->setInputFilter($inputFilter);
	}

}