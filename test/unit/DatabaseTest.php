<?php
require_once 'PHPUnit/Extensions/Database/TestCase.php';
require_once 'PHPUnit/Extensions/Database/DataSet/CsvDataSet.php';
require_once dirname(__FILE__).'/../../lib/Database.class.php';
require_once dirname(__FILE__).'/../../lib/Recordset.class.php';

class DatabaseTest extends PHPUnit_Extensions_Database_TestCase
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

	public function testSimpleQuery()
	{
		$sql = 'SELECT * from contacts';
		$db = $this->getDbConnection();
		$result = $db->query($sql);
			
		$this->assertEquals(2, count($result));
		$this->assertThat($result, $this->isInstanceOf('Recordset'));
	}
	
	public function testQueryWithParameter()
	{
		$expectedRecord = array(
			'id'				=>	1,
			'firstname'	=>	'Jacopo',
			'lastname'	=>	'Romei',
			'phone'			=>	'0543123543',
			'mobile'		=>	'34012345'
		);
		$db = $this->getDbConnection();
		
		$result = $db->query("SELECT * from contacts where firstname = '%s'", 'Jacopo');
		$result->next();
		$record = $result->current();
		
		$this->assertEquals(1, count($result));
		$this->assertThat($result, $this->isInstanceOf('Recordset'));
		$this->assertThat($record, $this->isType('array'));
		$this->assertEquals($expectedRecord, $record);
		
		$expectedRecord = array(
			'id'				=>	2,
			'firstname'	=>	'Francesco',
			'lastname'	=>	'Trucchia',
			'phone'			=>	'12345',
			'mobile'		=>	'234 12345'
		);
		
		$result = $db->query("SELECT * from contacts where firstname = '%s' and id = %d", 'Francesco', 2);
		$result->next();
		$record = $result->current();
		
		$this->assertEquals(1, count($result));
		$this->assertThat($result, $this->isInstanceOf('Recordset'));
		$this->assertThat($record, $this->isType('array'));
		$this->assertEquals($expectedRecord, $record);
		
	}

	/**
	 * @expectedException Exception
	 */
	public function testInvalidQuery()
	{
		$sql = 'invalid query';
		$db =$this->getDbConnection();
		$db->query($sql);
	}

	/**
	 * @expectedException BadMethodCallException
	 */
	public function testQueryInvalidArgumentsCount()
	{
		$sql = "SELECT * from contacts where id = %d";
		$db = $this->getDbConnection();
		$db->query($sql);
	}
	
	/**
	 * @expectedException BadMethodCallException
	 */
	public function testQueryNullArgument()
	{
		$sql = "SELECT * from contacts where id = %d";
		$db = $this->getDbConnection();
		$db->query($sql, null);
	}

	public function testExecute()
	{
		$db = $this->getDbConnection();
		
		$sql = "UPDATE contacts set firstname = '%s'";
		$result = $db->execute($sql, 'Marco');
		$this->assertThat($result, $this->isType('integer'));
		$this->assertEquals(2, $result);
		
		$sql = "UPDATE contacts set firstname = '%s' where id = %d";
		$result = $db->execute($sql, 'Paolo', 1);
		$this->assertThat($result, $this->isType('integer'));
		$this->assertEquals(1, $result);
		
		$sql = "INSERT INTO contacts (firstname, lastname, phone, mobile) VALUES ('%s', '%s', '%s', '%s')";
		$result = $db->execute($sql, 'Francesco', 'Tassi', '223344', '1122334');
		$this->assertThat($result, $this->isType('integer'));
		$this->assertEquals(1, $result);

		$sql = 'DELETE from contacts where id = %d';
		$result = $db->execute($sql, 3);
		$this->assertThat($result, $this->isType('integer'));
		$this->assertEquals(1, $result);
	}
	
	protected function getDbConnection()
	{
		$db = new Database('localhost', 'root', 'root', 'contacts_test');
		$db->connect();
		return $db;
	}

}