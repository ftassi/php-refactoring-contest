<?php
error_reporting(E_ALL); ini_set('display_errors',1);
require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

class NoRegressionTest extends PHPUnit_Extensions_SeleniumTestCase
{
	protected function setUp()
	{
		$this->setBrowser("*chrome");
		$this->setBrowserUrl("http://refactoring.localhost/");
		$sqlFixtures = dirname(__FILE__) . '/../../../data/contacts.sql';
		exec('mysql -u root -proot contacts < '. $sqlFixtures);
	}

	public function testList()
	{
		$this->open("http://refactoring.localhost/index.php");
		$this->assertTitle('Contacts Book');
		$this->assertEquals("Romei", $this->getTable("//div[@id='content']/table.1.0"));
		$this->assertEquals("Jacopo", $this->getTable("//div[@id='content']/table.1.1"));
		$this->assertEquals("0543123543", $this->getTable("//div[@id='content']/table.1.2"));
		$this->assertEquals("34012345", $this->getTable("//div[@id='content']/table.1.3"));
		$this->assertEquals("[X]", $this->getTable("//div[@id='content']/table.1.4"));
		$this->assertEquals("Trucchia", $this->getTable("//div[@id='content']/table.2.0"));
		$this->assertEquals("Francesco", $this->getTable("//div[@id='content']/table.2.1"));
		$this->assertEquals("12345", $this->getTable("//div[@id='content']/table.2.2"));
		$this->assertEquals("234 12345", $this->getTable("//div[@id='content']/table.2.3"));
		$this->assertEquals("[X]", $this->getTable("//div[@id='content']/table.2.4"));
	}

	public function testEditRow()
	{
		$this->open("http://refactoring.localhost/index.php");
		$this->click("link=Romei");
		$this->waitForPageToLoad("30000");
		$this->type("firstname", "Jacopo_new1");
		$this->type("lastname", "Romei_new2");
		$this->type("phone", "0543123543_new4");
		$this->type("mobile", "34012345_new5");
		$this->click("//input[@value='Save']");
		$this->waitForPageToLoad("30000");
		$this->assertEquals("Romei_new2", $this->getTable("//div[@id='content']/table.1.0"));
		$this->assertEquals("Jacopo_new1", $this->getTable("//div[@id='content']/table.1.1"));
		$this->assertEquals("0543123543_new4", $this->getTable("//div[@id='content']/table.1.2"));
		$this->assertEquals("34012345_new5", $this->getTable("//div[@id='content']/table.1.3"));
		$this->assertEquals("[X]", $this->getTable("//div[@id='content']/table.1.4"));
	}

	public function testDeleteRow()
	{
		$this->open("http://refactoring.localhost/index.php");
		$this->click("link=X");
		$this->assertTrue((bool)preg_match('/^Are you sure[\s\S]$/',$this->getConfirmation()));
		$this->assertEquals(2, $this->getXpathCount("//div[@id='content']/table/tbody/tr"));

		$this->assertEquals("Trucchia", $this->getTable("//div[@id='content']/table.1.0"));
		$this->assertEquals("Francesco", $this->getTable("//div[@id='content']/table.1.1"));
		$this->assertEquals("12345", $this->getTable("//div[@id='content']/table.1.2"));
		$this->assertEquals("234 12345", $this->getTable("//div[@id='content']/table.1.3"));
		$this->assertEquals("[X]", $this->getTable("//div[@id='content']/table.1.4"));
	}

	public function testCreateNew()
	{
		$this->open("http://refactoring.localhost/index.php");
		$this->click("link=New contact");
		$this->waitForPageToLoad("30000");
		$this->type("firstname", "Francesco");
		$this->type("lastname", "Tassi");
		$this->type("phone", "3471213312");
		$this->type("mobile", "0713471213312");
		$this->click("//input[@value='Save']");
		$this->waitForPageToLoad("30000");

		//Verifico il contenuto di tutte le righe per verificare l'ordinamento
		$this->assertEquals("Romei", $this->getTable("//div[@id='content']/table.1.0"));
		$this->assertEquals("Jacopo", $this->getTable("//div[@id='content']/table.1.1"));
		$this->assertEquals("0543123543", $this->getTable("//div[@id='content']/table.1.2"));
		$this->assertEquals("34012345", $this->getTable("//div[@id='content']/table.1.3"));
		$this->assertEquals("[X]", $this->getTable("//div[@id='content']/table.1.4"));

		$this->assertEquals("Tassi", $this->getTable("//div[@id='content']/table.2.0"));
		$this->assertEquals("Francesco", $this->getTable("//div[@id='content']/table.2.1"));
		$this->assertEquals("3471213312", $this->getTable("//div[@id='content']/table.2.2"));
		$this->assertEquals("0713471213312", $this->getTable("//div[@id='content']/table.2.3"));
		$this->assertEquals("[X]", $this->getTable("//div[@id='content']/table.2.4"));

		$this->assertEquals("Trucchia", $this->getTable("//div[@id='content']/table.3.0"));
		$this->assertEquals("Francesco", $this->getTable("//div[@id='content']/table.3.1"));
		$this->assertEquals("12345", $this->getTable("//div[@id='content']/table.3.2"));
		$this->assertEquals("234 12345", $this->getTable("//div[@id='content']/table.3.3"));
		$this->assertEquals("[X]", $this->getTable("//div[@id='content']/table.3.4"));
	}

	public function testValidationRules()
	{
		$this->open("/index.php");
		$this->click("link=New contact");
		$this->waitForPageToLoad("30000");
		$this->click("//input[@value='Save']");
		$this->waitForPageToLoad("30000");
		$this->assertEquals("The firstname field is mandatory", $this->getText("//div[@id='content']/form/ul/li[1]"));
		$this->assertEquals("The lastname field is mandatory", $this->getText("//div[@id='content']/form/ul/li[2]"));
		$this->assertEquals("The phone field is mandatory", $this->getText("//div[@id='content']/form/ul/li[3]"));
	}
	
	public function testFatalErrors()
	{
		$this->open("/edit.php");
		$this->assertEquals('Some error occured!!', $this->getText('//body'));
		$this->open("/remove.php");
		$this->assertEquals('Some error occured!!', $this->getText('//body'));
	}

}
