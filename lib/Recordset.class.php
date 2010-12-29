<?php
class Recordset implements Iterator, Countable, ArrayAccess
{
	protected $resource;
	protected $position = 0;
	protected $row;
	
	public function __construct($resource)
	{
		if (!is_resource($resource))
			throw new InvalidArgumentException('supplied argument is not a valid MySQL result resource');
			
		$this->resource = $resource;
	}
	
	public function __destruct()
	{
		mysql_free_result($this->resource);
	}
	
	public function next()
	{
		$this->position ++;
		$this->row = mysql_fetch_assoc($this->resource);
	}
	
	public function current()
	{
		return $this->row;
	}
	
	public function key()
	{
		return $this->position;
	}
	
	
	public function rewind()
	{
		$this->position = 0;
		$this->seek(0);
		$this->row = mysql_fetch_assoc($this->resource); 
	}
	
	public function valid()
	{
		return (boolean)$this->row;
	}
	
	public function count()
	{
		return  mysql_num_rows($this->resource);
	}

	public function offsetGet($offset)
	{
		if ($this->seek($offset))
		{
			$this->row = mysql_fetch_assoc($this->resource);
			return $this->row;
		}
		else
		{
			return null;
		}
	}

	public function offsetExists($offset)
	{
		$rows = mysql_num_rows($this->resource);
		if($offset >= 0  and $offset <= $rows)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function offsetSet($offset, $value)
	{
	}

	public function offsetUnset($offset)
	{
	}

	protected function seek($offset)
	{
		if ($this->offsetExists($offset) && mysql_data_seek($this->resource, $offset))
		{
			$this->row = $offset;
			return true;
		}
		else
		{
			return false;
		}
	}
}