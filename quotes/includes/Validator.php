<?php
    class Validator{
    	
    	public function isEmpty($val)
		{
			if($val === '' || trim((string)$val) === '' || empty($val) || $val == null)
				return true;
			else
				return false;
		}
		
		public function minLength($val,$min)
		{
			if(strlen(trim($val)) >= $min && is_string($val))
				return true;
			else
				return false;
		}
		
		public function maxLength($val,$max)
		{
			if(strlen(trim($val)) <= $max && is_string($val))
				return true;
			else
				return false;
		}
		
		public function isEmail($val)
		{
			$pattern='/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/';
			if (preg_match($pattern, $val) && strlen($val)<=254 && is_string($val))
				return true;
			else
				return false;
		}
		
		public function isUrl($val)
		{
			$pattern='/^{schemes}:\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)/i';
			$validSchemes=array('http','https');
			if(strpos($val,'://')===false)
				$val = 'http://'.$val;
			$pattern=str_replace('{schemes}','('.implode('|',$validSchemes).')',$pattern);
			if(preg_match($pattern,$val))
				return true;
			else
				return false;
		}
		
		public function isDate($val,$format="m/d/y")
		{
			if(preg_match("/-/",$format))
			{
				$fmt = explode("-", $format);
				$date = explode("-", $val);
			}
			elseif(preg_match("/\//",$format))
			{
				$fmt = explode("/", $format);
				$date = explode("/", $val);
			}
			
			for ($i=0; $i < count($fmt); $i++) { 
				$date[$fmt[$i]] = $date[$i];
			}
			
			if(checkdate($date['m'],$date['d'],$date['y']))
				return true;
			else
				return false;
			
		}
		
		public function isTime($val)
		{
			$pattern = '/^([01]\d|2[0-3])(:[0-5]\d){0,2}$/';
			if(preg_match($pattern, $val))
				return true;
			else
				$pattern = '/^((0?[1-9]|1[012])(:[0-5]\d){0,2}(\ [AP]M))$/i';
				return preg_match($pattern, $val);
		}

		public function isNumber($val)
		{
			if(is_numeric($val))
				return true;
			else
				return false;
		}
		
		public function isPhoneNumber($val)
		{
			$pattern = '/^(?:\+?1[-. ]?)?\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/';
			if(preg_match($pattern, $val))
				return true;
			else
				return false;
		}
		
		public function minValue($val,$min)
		{
			if($val >= $min)
				return true;
			else
				return false;
		}
		
		public function maxValue($val,$max)
		{
			if($val <= $max)
				return true;
			else
				return false;
		}
		
		public function minWords($val,$min)
		{
			$val = trim($val);
			$words = explode(' ', $val);
			$len = count($words);
			if($this->minValue($len,$min))
				return true;
			return false;
		}
		
		public function maxWords($val,$max)
		{
			$val = trim($val);
			$words = explode(' ', $val);
			$len = count($words);
			if($this->maxValue($len,$max))
				return true;
			return false;
		}
		
		public function isCreditCard($val)
		{
			if (preg_match('/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6011[0-9]{12}|3(?:0[0-5]|[68][0-9])[0-9]{11}|3[47][0-9]{13})$/', $val))
			    return true;
			else
			    return false;
		}
		
    }
?>