<?php

class BaseController extends CI_Controller
{
    public $css;
    public $js;
    protected $viewFolder;
    protected $layoutView;

    public function __construct(){
        parent::__construct();
        $this->viewFolder = '';
        $this->layoutView = 'layouts/main';
        $this->navigationView = 'layouts/navigation';
    }

    public function addCss($css){
        $this->appendScript('css', $css);
    }

    public function addJs($js){
        $this->appendJSScript($js);
    }

    private function appendScript($stack, $element){
        if(is_string($element) && $element != '')
            $this->{$stack}[] = $element;

        elseif(is_array($element) && !empty($element))
            $this->{$stack} = array_merge($this->{$stack}, $element);
    }

    public function loadView($view, $view_data = null){

        if ( !file_exists(APPPATH . '/views/' . $this->viewFolder . $view . '.php'))
            show_404();

        if(!isset($this->url_helper))
            $this->load->helper('url');

        $data = [
            'view' => $this->viewFolder.$view,
            'navigationView' => $this->navigationView,
            'controller' => $this,
            'data' => $view_data,
            'title' => $this->getViewTitle($view, $view_data)
        ];

        $this->load->view($this->layoutView, $data);
    }

    private function appendJSScript($js)
    {
        include_once __DIR__ . '/../helpers/LayoutHelper.php';

        if(is_string($js) && $js != '')
            $this->js[] = LayoutHelper::getJsEntry($js);

        elseif(is_array($js) && !empty($js))
            $this->{$stack} = array_merge($this->{$stack}, LayoutHelper::getJsEntries($js));

    }

    private function getViewTitle($viewName, $viewData)
    {
        if(isset($viewData['title']))
            return $viewData['title'];

        include_once __DIR__ . '/../helpers/LayoutHelper.php';
        return LayoutHelper::generateTitle($viewName, $this);
    }

    protected function toRoute($route){
        if(!isset($this->url_helper))
            $this->load->helper('url');

        redirect(base_url('index.php/'.$route));
    }
}