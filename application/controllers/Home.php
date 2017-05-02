<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("Article_Model");
        $this->load->model("Photo_Model");
    }

	public function index()
	{
        $this->twig->display('home/index', array(

        ));

	}
    public function blog()
    {
        $start = $this->input->get("page");
        $allCount = count(Article_Model::model()->getAllFrontArticles());
        if ($allCount%6 == 0) {
            $pages = $allCount/6;
        } else {
            $pages = floor($allCount/6) + 1;
        }

        if (empty($start)) {
            $start = 1;
        }
        $limit = 6;
        $pre = 1;
        $next = 1;

        $pre = $start - 1;
    
        $next = $start + 1;

        $html = '<nav class="text-center" aria-label="...">';
        $html .= '<ul class="pagination">';
        if ($pre <= 0) {
            $html .=  '<li class="disabled"><a  aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
        } else{
            $html .=  '<li class=""><a href="/blog?page='.$pre.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
        }
        
        $html .= '<li class="active"><a> '. $start .' / '. $pages .'<span class="sr-only">(current)</span></a></li>';
        if ($allCount/6 <= $start) {
            $html .= ' <li class="disabled"><a aria-label="Previous"><span aria-hidden="true">&raquo;</span></a></li>';
        } else {
            $html .= ' <li class=""><a href="/blog?page='.$next.'" aria-label="Previous"><span aria-hidden="true">&raquo;</span></a></li>';
        }
        
        $html .= '</ul></nav>';
        // <nav class="text-center" aria-label="...">
        //     <ul class="pagination">
        //        '<li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>'
        //       <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
        //       <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&raquo;</span></a></li>
        //     </ul>
        // </nav>
        $articles = Article_Model::model()->getAllFrontArticles($start, $limit);
        // foreach ($articles as $key=> $val) {
        //     $articles[$key]["mainTitle"] = mb_substr(strip_tags($val['description']), 0, 200,'utf-8');
        // }
        $this->twig->display('home/blog', array(
            "articles" => $articles,
            "html" => $html
        ));

    }
    public function blogDetail($id_blog)
    {
        $article = Article_Model::model()->loadModel($id_blog);
        if(empty($article->id_article)) {
            redirect('/');
        }
        $this->twig->display('home/blogDetail', array(
            "article" => $article
        ));
    }
    public function photo()
    {
        $start = $this->input->get("page");
        $allCount = count(Photo_Model::model()->getAllPhotos());
        if ($allCount%6 == 0) {
            $pages = $allCount/6;
        } else {
            $pages = floor($allCount/6) + 1;
        }
        
        if (empty($start)) {
            $start = 1;
        }
        $limit = 6;
        $pre = 1;
        $next = 1;

        $pre = $start - 1;
    
        $next = $start + 1;

        $html = '<nav class="text-center" aria-label="...">';
        $html .= '<ul class="pagination">';
        if ($pre <= 0) {
            $html .=  '<li class="disabled"><a  aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
        } else{
            $html .=  '<li class=""><a href="/photo?page='.$pre.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
        }
        
        $html .= '<li class="active"><a>'. $start .' / '. $pages .'<span class="sr-only">(current)</span></a></li>';
        if ($allCount/6 <= $start) {
            $html .= ' <li class="disabled"><a aria-label="Previous"><span aria-hidden="true">&raquo;</span></a></li>';
        } else {
            $html .= ' <li class=""><a href="/photo?page='.$next.'" aria-label="Previous"><span aria-hidden="true">&raquo;</span></a></li>';
        }
        
        $html .= '</ul></nav>';

        $photos = Photo_Model::model()->getAllPhotos($start, $limit);
        $this->twig->display('home/photo', array(
            "photos" => $photos,
            "html" => $html
        ));
    }
    public function course()
    {
        $this->twig->display('home/course', array(
        ));
    }
    public function contact()
    {
        $data = $this->input->getPost("contact");
        if(!empty($data)) {
            $this->load->model("Contact_Model");
            $contact = new Contact_Model();
            $contact->attributes = $data;
            $contact->created = time();
            $contact->save();
            return $this->_returnAjax(array(
                "result" => true
            ));
        }
        return $this->_returnAjax(array(
            "result" => false
        ));
    }
}
