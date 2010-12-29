<?php
class DatabaseConnection
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

	public function __destruct()
	{
		mysql_close(self::$dbResource);
	}
}