<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article_Model extends MY_Model
{
	    public $id_article;
        public $title;
        public $abstract;
        public $type;
        public $description;
        public $post;
        public $author;
        public $created;
	
        protected $_collection = 'Article';
        protected $_primaryKey = 'id_article';
        protected $_collection_attributes = array('id_article', 'title','abstract', 'type', 'description','post','author','created');
	    protected $_editable_attributes = array( 'title', 'type','abstract', 'description','post','author');
    
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
    public function getAllArticles()
    {
        $this->db->order_by("post",'desc');
        $query = $this->db->get($this->_collection);
        return $query->result_array();
    }
    public function getAllFrontArticles($start = null, $limit = null)
    {
        $today = date("Y-m-d", time());
        $this->db->where("post <=",$today);
        $this->db->order_by("post",'desc');
        if (empty($start) && empty($limit)) {
            $query = $this->db->get($this->_collection);
        } else {
            $query = $this->db->get($this->_collection, $limit, ($start-1)*6);
        }
    
        return $query->result_array();
    }
}