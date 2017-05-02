<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends MY_Controller {
    /**
	 * This class construct function is to set layout and load some models
	 */
	public function __construct()
	{
		parent::__construct();
                $url = $this->uri->rsegment_array();
		$select = $url[1].'-'.$url[2];
                $this->twig->preParams = array("selected" => $select);
		$this->load->model('Contact_Model');
	}
        
         /**
         * This function manage employee
         * Output string display manage page
         */
        public function manage()
        {
            $contactModel = new Contact_Model();
            $contacts = $contactModel->getAll();
            $this->twig->display('/admin/contact/manage', array(
                'title' => '联系我们',
                'contacts' => $contacts
            )); 
            
        }
          /**
	 * This function use to delete employee,
	 * then redirect to employee directory page.
	 *
	 * GET Int id_employee The employee id.
	 */
	public function delete()
	{
            $id_contact = $this->input->getParam('id_contact',NULL);
            if(!empty($id_contact)){
                $this->db->delete(Contact_Model::model()->collection, array('id_contact' => $id_contact));
            }
            redirect('/admin/contact/manage');
	}
        
        public function view()
        {
            $id_contact = $this->input->getParam('id_contact',NULL);
            $contactModel = Contact_Model::model()->loadModel($id_contact);
            if(!isset($contactModel->id_contact) || empty($contactModel->id_contact)) {
                redirect('/admin/contact/manage');
            }
            $this->twig->display('/admin/contact/detail', array(
                'title' => '详细内容',
                'contactModel' => $contactModel
            )); 
        }
}
