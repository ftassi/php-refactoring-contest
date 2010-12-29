<?php
class ContactForm implements ArrayAccess
{
	protected $values;
	protected $mandatory = array();
	protected $errors = array();
	
	public function bind($values)
	{
		$this->values = $values;
	}
	
	public function setValidators($mandatory)
	{
		$this->mandatory = $mandatory;
	}
	
	public function isValid()
	{
		return $this->validate() == 0 ? true: false;
	}
	
	public function getValues()
	{
		return $this->values;
	}
	
	public function getErrors()
	{
		return $this->errors;
	}
	
	public function offsetExists($offset)
	{
		return in_array($offset, $this->values);
	}
	
	public function offsetGet($offset)
	{
		return $this->values[$offset];
	}
	
	public function offsetSet($offset, $value)
	{
		$this->values[$offset] = $value;
	}
	
	public function offsetUnset($offset)
	{
		unset($this->values[$offset]);
	}
	
	protected function validate()
	{
		$this->errors = array();
		foreach ($this->mandatory as $field)
		{
			if($this->values[$field] == '')
			{
				$this->errors[$field] = 'The ' . $field . ' field is mandatory';
			}
		}

		return count($this->errors);
	}
}
