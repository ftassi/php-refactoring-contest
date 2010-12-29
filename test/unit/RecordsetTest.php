<?php
require_once 'PHPUnit/Extensions/Database/TestCase.php';
require_once 'PHPUnit/Extensions/Database/DataSet/CsvDataSet.php';
require_once dirname(__FILE__).'/../../lib/Recordset.class.php';

class RecordsetTest extends PHPUnit_Extensions_Database_TestCase
{
	protected function getConnection()
	{
		$pdo = new PDO('mysql:host=localhost;dbname=contacts_test', 'root', 'root');
		return $this->createDefaultDBConnection($pdo, 'contacts_test');
	}
	
	protected function getDataSet()
	{
		$dataSet = new PHPUnit_Extensions_Database_DataSet_CsvDataSet();
		$dataSet->addTable('contacts', dirname(__FILE__). '/../fixtures/contacts.csv');
		return $dataSet;	
	}
	
	public function testIterator()
	{
		$expectContacts = array(
			array(
				'id'				=>	1,
				'firstname'	=>	'Jacopo',
				'lastname'	=>	'Romei',
				'phone'			=>	'0543123543',
				'mobile'		=>	'34012345',
			),
			array(
				'id'				=>	2,
				'firstname'	=>	'Francesco',
				'lastname'	=>	'Trucchia',
				'phone'			=>	'12345',
				'mobile'		=>	'234 12345',
			)
		);
		
		$link = mysql_connect("localhost", "root", "root");
		mysql_select_db('contacts_test', $link); 
		$query = 'SELECT * from contacts';
		
		$contactCollection = new Recordset(mysql_query($query));
		$this->assertFalse($contactCollection->valid());
		
		$contactCollection->next();
		$this->assertTrue($contactCollection->valid());
		$this->assertEquals($expectContacts[0], $contactCollection->current());
		
		$contactCollection->next();
		$this->assertTrue($contactCollection->valid());
		$this->assertEquals($expectContacts[1], $contactCollection->current());
		
		$contactCollection->next();
		$this->assertFalse($contactCollection->valid());
		
		$contactCollection->rewind();
		$this->assertTrue($contactCollection->valid());
		$this->assertEquals($expectContacts[0], $contactCollection->current());
	}
	
	public function testCountable()
	{
		$link = mysql_connect("localhost", "root", "root");
		mysql_select_db('contacts_test', $link); 
		$query = 'SELECT * from contacts';
		
		$contactCollection = new Recordset(mysql_query($query));
		
		$this->assertEquals(2, count($contactCollection));
	}
	
	public function testArrayInterface()
	{
		$link = mysql_connect("localhost", "root", "root");
		mysql_select_db('contacts_test', $link); 
		$query = 'SELECT * from contacts';
		
		$contactCollection = new Recordset(mysql_query($query));
		
		$this->assertEquals('Jacopo', $contactCollection[0]['firstname']);
		$this->assertEquals('Francesco', $contactCollection[1]['firstname']);
		$this->assertNull($contactCollection[3]);
		$this->assertFalse($contactCollection->offsetExists(3));
		$this->assertTrue($contactCollection->offsetExists(1));
		
	}

	/**
	 * @expectedException InvalidArgumentException 
	 */
	public function testValidResource()
	{
		$contactCollection = new Recordset('fakeResource');
	}
}