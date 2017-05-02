<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Model extends MY_Model 
{
	    public $id;
        public $username;
        public $email;
        public $password;
	
	protected $_collection = 'User';
	protected $_primaryKey = 'id';
        protected $_collection_attributes = array('id', 'username', 'email', 'password');
	protected $_editable_attributes = array('username', 'password');
    
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

        /**
         * Get user by email
         * @param type $email 
         * @return type user model
         */
        public function getUserByName($email = null)
        {
            $result = null;
            
            if($email != null){
                $sql = "SELECT * FROM User WHERE username  = ? LIMIT 1";
                $query = $this->db->query($sql, array($email));
                $result = $query->result(__CLASS__);
                if($result){
                    $result = $result[0];
                }
            }
            
            return $result;
        }
        
        public static function doLogin($loginData = null)
        {
            $result = false;
            if(isset($loginData['name'])){
                $targetUser = new User_Model();
                $targetUser = $targetUser->getUserByName($loginData['name']);
                if($targetUser->checkPassword($loginData['password'])){
                    $targetUser->setLoginData($targetUser);
                    $result = true;
                }
            }
            return $result;
        }
        
        public static function logout()
        {
            $result = true;
            $user = new User_Model();
            $user->doLogout();
            
            return $result;
            
        }        
        
        public function doLogout()
        {
            $this->session->unset_userdata('isLogin');
            $this->session->unset_userdata('accseeAuthInfo');
        }

        public function checkPassword($targetPassword)
        {
            $res = false;
            if($this->password != '' && $this->password == md5($targetPassword)){
                $res = true;
            }
            return $res;
        }
        
        public function setLoginData($targetUser)
        {
            $this->session->set_userdata('isLogin', true);
            $this->session->set_userdata('accseeAuthInfo', serialize($targetUser));
        }

        public function getTable()
        {
            return $this->_collection;
        }
		
}