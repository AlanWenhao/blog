<?php 
class MY_Model extends CI_Model
{
    protected static $_models;
    protected $_primaryKey;
    protected $_collection;
    protected $_collection_attributes = array();
    protected $_editable_attributes = array();
    
    /**
     * Get the instance of a model
     * @param String $className model class name
     * @return CI_Model the instance of a model
     */
	public static function model($className=__CLASS__)
	{
		if(!isset(self::$_models[$className])){
			self::$_models[$className] = new $className();
		}
		return self::$_models[$className];
	}
        
        /**
	 * Get a instance depends on the primary key
	 * @param MIX $pk primary key
	 * @param string primary name
	 * @return CI_Model the instance of a model
	 */
	public function loadModel($pk, $pkName = null)
	{
		$className = get_class($this);
		$pkName = empty($pkName)? $this->_primaryKey : $pkName;
		$query = $this->db->get_where($this->_collection, array($pkName => $pk));
		$result = $query->result(get_class($this));
		if(!empty($result)){
			return $result[0];
		}else{
			return new $className;
		}
	}
        
        /**
	 * Get the related table name
	 * @return String related table name
	 */
	public function getCollection()
	{
		return $this->_collection;
	}
        /**
	 * Update the attributes of the model
	 * @param Array $attributes attributes of the model
	 */
	public function setAttributes($attributes)
	{
		foreach($this->_editable_attributes as $attribute){
			if(isset($attributes[$attribute])){
				$this->$attribute = $attributes[$attribute];
			}
		}
	}
	
	/**
	 * get the attributes of the model
	 * @return Array $attributes attributes of the model
	 */
	public function getAttributes()
	{
		$attributes = array();
		foreach($this->_collection_attributes as $attribute){
			$attributes[$attribute] = $this->$attribute;
		}
		
		return $attributes;
	}
        
        /**
	 * Store the attributes into the database
	 * @param string $needValidate if the attributes need to validate
	 * @return Boolean if the attributes is saved successfully
	 */
	public function save($needValidate = true)
        {
            $pk = $this->_primaryKey;
            if(!empty($this->$pk)){
                $this->db->where($pk, $this->$pk);
                if(!$this->db->update($this->_collection, $this->attributes)){
                    return false;
                }
            }else{
                if(!$this->db->insert($this->_collection, $this->attributes)){
                    return false;
                }
                $this->$pk = $this->db->insert_id();
            }
                    return true;
        }
        
         /**
     * Magic method "get" of the model
     */
	public function __get($key)
	{
		$action = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
		if(method_exists($this, $action)){
			return $this->$action();
		}
		
		return parent::__get($key);
	}
	
	/**
	 * Magic method "set" of the model
	 */
	public function __set($name, $value)
	{
		$action = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $name)));
		if(method_exists($this, $action)){
			return $this->$action($value);
		}
	}
        
         /**
     * Get all instances of the model
     * @param string $start start instance	
     * @param string $limit count of instances 
     * @param string $order order
     * @return Array collection of the instances
     */
	function getAll($start = null, $limit = null, $order = 'desc')
	{
		
                $this->db->order_by('created', $order);
		$query = $this->db->get($this->_collection, $limit, $start);
		return $query->result(get_class($this));
	}
        
        public function showTime($format="D d M Y H:i:s", $time, $showTimezone=true)
	{
		if($showTimezone)
                    return date('h:i a', $time)." ".date('M d, Y', $time);
		else 
		return date($format, $time);
	}
        /**
	 * Check if the instance is empty
	 * @return Boolean if the instance is empty
	 */
	public function getIsEmptyModel()
	{
		$pkName = $this->_primaryKey;
		return empty($this->$pkName);
	}
          /**
     * 
     * get the format date
     * @return String formated date
     */
	public function getFormatTime()
	{
		$now = time();
		if(empty($this->scheduling))
		{
			$time = $now - $this->created;
		}else {
			$time = $now - $this->scheduling;
		}
		
		if($time >= (7*24*3600)){
			$date = date('M d, Y', $this->created);
		}else{
			if ($time < 60) {  
        		$date = 'Just Now';  
    		}elseif($time < 3600){
    			$min = floor($time/60);  
    			$date = ($min==1)? $min.' min ago' : $min.' mins ago';
    		}elseif($time < (3600*24)){
    			$h = floor($time/3600);  
    			$date = ($h==1)? $h.' hour ago' : $h.' hours ago';
    		}elseif($time < (3600 * 24 * 7)){
    			$d = floor($time/(3600*24)); 
    			$date = ($d==1)? $d.' day ago' : $d.' days ago';
    		}
		}
		return $date;
	}
}