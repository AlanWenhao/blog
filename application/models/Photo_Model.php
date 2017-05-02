<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Photo_Model extends MY_Model
{
	    public $id_photo;
        public $title;
        public $description;
        public $media;
        public $created;
	
        protected $_collection = 'Photo';
        protected $_primaryKey = 'id_photo';
        protected $_collection_attributes = array('id_photo', 'title', 'description','media', 'created');
	    protected $_editable_attributes = array( 'title','description', 'media');
    
        /**
	 * Get an object of this class
	 * 
	 * @param string $className
         * @return User_Model
	*/
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function getAllPhotos($start =null, $limit=null)
	{
		$this->db->order_by("created", "desc");
        if (empty($start) && empty($limit)) {
            $query = $this->db->get($this->_collection);
        } else {
            $query = $this->db->get($this->_collection, $limit, ($start-1)*6);
        }
    
        return $query->result_array();
	}
}