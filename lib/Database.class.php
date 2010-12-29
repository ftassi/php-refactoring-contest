<?php
class Database
{
	protected static $dbResource = null;

	protected $host;
	protected $username;
	protected $password;
	protected $database;

	public function __construct($host, $username, $password, $database)
	{
		$this->host = $host;
		$this->username = $username;
		$this->password = $password;
		$this->database = $database;
	}

	public function connect()
	{
		if (is_null(self::$dbResource))
		{
			self::$dbResource = mysql_connect($this->host, $this->username, $this->password);
			if (!self::$dbResource)
			{
				throw new Exception('Unable to connect to DB');
			}

			$db = mysql_select_db($this->database);
			if (!$db)
			{
				throw new Exception(sprintf('Unable to connect to %s database', $this->database));
			}
		}

		return self::$dbResource;
	}

	public function query()
	{
		$args = func_get_args();
		$sql = call_user_func(array($this, 'hydrateQuery'), $args);
		$rs = mysql_query($sql);
		
		try
		{
		  return new Recordset($rs);
		}
		catch(InvalidArgumentException $e)
		{
		  throw new Exception (mysql_error());
		}
	}
	
	public function execute()
	{
		$args = func_get_args();
		$sql = call_user_func(array($this, 'hydrateQuery'), $args);
		$result = mysql_query($sql);
		if ($result === true)
		{
			return mysql_affected_rows();
		}
		else
		{
			throw new Exception(mysql_error());
		}
	}
	
	public function __destruct()
	{
		if (!is_null(self::$dbResource))
		{
			mysql_close(self::$dbResource);
			self::$dbResource = null;			
		}
	}
	
	protected function hydrateQuery($args)
	{
		$sql = call_user_func_array('sprintf', $args);
		return $sql;
	}
	
	protected function escapeQueryParameters($queryParts)
	{
		$parameters = array();
		$sql = array_shift($queryParts);
		
		foreach ($queryParts as $parameterCount => $parameterValue)
		{
			$parameters[$parameterCount] = mysql_real_escape_string($parameterValue);
		}
		$queryParts = array_merge(array($sql), $parameters);
		return $queryParts;
	}
}