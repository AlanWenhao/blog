<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article extends MY_Controller
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

        $this->load->model('Article_Model');
    }

    public function edit()
    {
        $id_article = $this->input->getParam('id_article', null);
        $articleModel = Article_Model::model()->loadModel($id_article);
        $postData = $this->input->getParam("article");
        if (!empty($postData)) {
            $articleModel->attributes = $postData;
            $articleModel->save();
            redirect("/admin/article/manage");
        }
        $this->twig->display('admin/article/edit', array(
            'title' => '文章',
            'articleModel' => $articleModel
        ));
    }
    public function manage()
    {
        $articles = Article_Model::model()->getAllArticles();
        $this->twig->display('admin/article/manage', array(
            'title' => '管理文章',
            'articles' => $articles
        ));
    }
    public function delete()
    {
        $id_article = $this->input->getParam('id_article', null);
        $this->db->delete("Article", array('id_article' => $id_article));
        redirect("/admin/article/manage");
    }
}