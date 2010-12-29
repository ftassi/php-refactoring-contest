<?php
require_once dirname(__FILE__).'/../../lib/ContactForm.class.php';

class ContactFormTest extends PHPUnit_Framework_TestCase
{
	public function testValidateForm()
	{
		$isValid = true;
		$request = array(
			'id'	=>	1,
			'firstname'	=>	'Francesco',
			'lastname'	=>	'Tassi',
			'phone'			=>	'3471213321',
			'mobile'		=>	'3471213312',
		);
		
		$mandatoryField = array(
			'firstname', 'lastname'
		);
		
		$form = new ContactForm();
		$form->bind($request);
		$form->setValidators($mandatoryField);
		$form->isValid();
		
		$this->assertEquals($isValid, $form->isValid());
		$this->assertType('boolean', $form->isValid());
	}
	
	public function testArrayAccessImplementation()
	{
		$request = array(
			'firstname'	=>	'Francesco',
			'lastname'	=>	'Tassi',
		);
		
		$form = new ContactForm();
		$form->bind($request);
		$form->isValid();
		
		$this->assertEquals('Francesco', $form['firstname']);
		$this->assertEquals('Tassi', $form['lastname']);
	}
}