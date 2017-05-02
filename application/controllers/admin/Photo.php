<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Photo extends MY_Controller
{

    /**
     *
     * class construct function to set layout and load some models
     */
    public function __construct()
    {
        parent::__construct();

        $url = $this->uri->rsegment_array();
        $select = $url[1] . '-' . $url[2];
        $this->twig->preParams = array("selected" => $select);
        $this->load->model('Photo_Model');
    }

    public function edit()
    {
        $id_photo = $this->input->getParam('id_photo', null);
        $photoModel = Photo_Model::model()->loadModel($id_photo);
        $postData = $this->input->getParam("title");
        if (!empty($postData)) {
            $config['upload_path']      = './public/uploads/';
            $config['allowed_types']    = 'gif|jpg|png';
            $config['max_size']     = 1000000;
            $config['max_width']        = 5024;
            $config['max_height']       = 5024;
            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('media'))
            {
                $photoModel->title = $this->input->getParam('title');
                $photoModel->description = $this->input->getParam('description');
                $photoModel->save();
            }
            else
            {
                $data = $this->upload->data();
                $photoModel->title = $this->input->getParam('title');
                $photoModel->description = $this->input->getParam('description');
                $photoModel->media = $data['file_name'];
                if (empty($photoModel->created)) {
                    $photoModel->created = time();
                }
                $photoModel->save();
            }
            redirect("/admin/photo/manage");
        }
        $this->twig->display('admin/photo/edit', array(
            'title' => '摄影添加',
            'photoModel' => $photoModel
        ));
    }
    public function manage()
    {
        $photos = Photo_Model::model()->getAll();
        $this->twig->display('admin/photo/manage', array(
            'title' => '管理文章',
            'photos' => $photos
        ));
    }
    public function delete()
    {
        $id_photo = $this->input->getParam('id_photo', null);
        $this->db->delete("Photo", array('id_photo' => $id_photo));
        redirect("/admin/photo/manage");
    }
}