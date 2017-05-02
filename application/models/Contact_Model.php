<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_Model extends MY_Model 
{
	    public $id_contact;
        public $name;
        public $email;
        public $title;
        public $description;
        public $created;
	
        protected $_collection = 'Contact';
        protected $_primaryKey = 'id_contact';
        protected $_collection_attributes = array('id_contact', 'name', 'email', 'title','description','created');
	    protected $_editable_attributes = array('name', 'email', 'title','description');
    
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
       
		
}