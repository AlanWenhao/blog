<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminHome extends MY_Controller {
        
    
    public function __construct()
	{
		parent::__construct();
	}
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
        $this->twig->display('admin/adminHome/index', array(
            'title' => '首页',
        ));
	}
        
    public function login()
    {
        // 判断是否已经登录了
        $isLogin = $this->session->isLogin;
        if($isLogin){
            redirect('admin/AdminHome/index/');
        }

        $this->twig->display('admin/adminHome/login', array('title' => 'login'));
    }
        
    public function doLogin()
    {
        $loginData = $this->input->post('login');
        $logResult = User_Model::doLogin($loginData);

        if($logResult){
            if($this->session->lastUrl != ''){
                redirect($this->session->lastUrl);
                exit;
            }else{
                redirect('admin/AdminHome/index/');
                exit;
            }
        }
        redirect('admin/AdminHome/login/');
    }
        
    public function logout()
    {
        $res = User_Model::logout();
        if($res){
            redirect('admin/AdminHome/login/');
        }
        show_error('there is something wrong');

    }
        
        /**
	 * This function get input time's week begin time stamp And end time stamp.
	 *
	 * @param String $dateTime a time stamp.
	 *
	 * @return array week start date and end date.
	 */
	public function getWeekStartEnd($dateTime)
	{
		$today = date('w', $dateTime);
		$startDay = date('Y-m-d',$dateTime-$today*24*3600);
		$endDay = date('Y-m-d',$dateTime+(6-$today)*24*3600);
		return array('startDay' => $startDay, 'endDay' => $endDay);
	}
        
        /**
	 * This function return site weekly view stats.
	 *
	 * 
	 * GET String time, Use to get view stats data. 
	 *
	 * @return String returns the ajax encoded variable of tpl.
	 */
	public function getWeeklyViews()
	{
            $time = $this->input->getParam('time', null);
            $sessionModel = new Session_Model();
            $day = $this->getWeekStartEnd($time);
            $perDay = strtotime($day['startDay'])-3600*24;
            $nextDay = strtotime($day['endDay'])+3600*24;
            $weeklyViews = $sessionModel->getWeeklyViews($day['startDay'], $day['endDay']);
            $weekViews = $this->twig->render('admin/adminHome/weeklyViews', array(
                'weeklyViews' => $weeklyViews,
                'startDay' => $day['startDay'],
                'endDay' => $day['endDay'],
                'perDay' => $perDay,
                'nextDay' => $nextDay,
                'year' => date('Y')
            ));    
            
            $this->_returnAjax($weekViews,FALSE);
	}
        
       /**
	 * This function return  weekly average online time stats.
	 *
	 * 
	 * GET String time, Use to get view average time stats data.
	 *
	 * @return String returns the ajax encoded variable of tpl.
	 */
	public function getWeeklyAverage()
	{

		$time = $this->input->getParam('time', null);
		$sessionModel = new Session_Model();
		$day = $this->getWeekStartEnd($time);
		$perDay = strtotime($day['startDay'])-3600*24;
		$nextDay = strtotime($day['endDay'])+3600*24;
		$weeklyAverage = $sessionModel->getWeeklyAverage($day['startDay'], $day['endDay']);
		$tpl = $this->twig->render('admin/adminHome/weeklyAverage', array(
			'weeklyAverage' => $weeklyAverage,
			'startDay' => $day['startDay'],
			'endDay' => $day['endDay'],
			'perDay' => $perDay,
			'nextDay' => $nextDay,
			'year' => date('Y')
		));
		
		$this->_returnAjax($tpl,FALSE);
	}
        
        /**
	 * This function return site montyly view stats.
	 *
	 * 
	 * GET String year, Use to get view stats data.
	 *
	 * @return String returns the ajax encoded variable of tpl.
	 */
	public function getMonthlyViews()
	{
            $year = $this->input->getParam('year', null);
            $sessionModel = new Session_Model();
            $monthlyViews = $sessionModel->getMonthlyViews($year);
            
            $tpl = $this->twig->render('admin/adminHome/monthlyViews', array(
                    'monthlyViews' => $monthlyViews,
                    'year' => $year,
                    'perYear' => $year-1,
                    'nextYear' => $year+1,
                    'now' => time()
            ));

            $this->_returnAjax($tpl,FALSE);
	}
        
        /**
	 * This function return site Monthly average online time stats.
	 *
	 * GET String time, Use to get view average time stats data.
	 *
	 * @return String returns the ajax encoded variable of tpl.
	 */
	public function getMonthlyAverage()
	{
            $year = $this->input->getParam('year', null);
            $sessionModel = new Session_Model();
            $monthlyAverage = $sessionModel->getMonthlyAverage($year);
            $tpl = $this->twig->render('admin/adminHome/monthlyAverage', array(
                    'monthlyAverage' => $monthlyAverage,
                    'year' => $year,
                    'perYear' => $year-1,
                    'nextYear' => $year+1,
                    'now' => time()
            ));

            $this->_returnAjax($tpl,FALSE);
	}
}
