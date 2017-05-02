<?php
class MY_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Twig');
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->model('User_Model');
        $allActions = array(
            'adminhome-index',
            'contact-manage',
            'article-edit',
            'article-manage',
            'photo-edit',
            'photo-manage'
        );
        $allActionMethod = array(
        );
        $thisClass = $this->router->class;
        $thisMethod = $this->router->method;
        $myAction = strtolower($thisClass . '-' . $thisMethod);
        if(in_array($myAction, $allActions)){
                $accseeAuthInfo = $this->session->accseeAuthInfo;
                $isLogin = $this->session->isLogin;
                //if(isset($this->session->isLogin) && $this->session->isLogin == true){
                if($isLogin == true){

                }else{
                    $rightUrl = uri_string();
                    $this->session->set_userdata('lastUrl', $rightUrl);
                     redirect('admin/adminHome/login/');
                }
        }
        
    }
    
    /**
	 * This function output the result from an ajax request.
	 * 
	 * @param Array/String $msg the message will be outputted
	 * @param Boolean $byJson if the message will be transformed to json format
	 *
	 * Output Json/String the result from an ajax request.
	 */
	protected function _returnAjax($msg = '', $byJson = true)
	{
		if($byJson){
			$msg = json_encode($msg);
		}
		echo $msg;
		$this->_end();
	}
    
	/**
	 * Exit the program.
	 *
	 * @param Integer $status the exit status code
	 * @param Boolean $exit if it will exit the program
	 */
	protected function _end($status=0, $exit=true)
	{
		if($exit)
			exit($status);
	}
}