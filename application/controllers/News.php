<?php
class News extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('New_model');
        $this->load->helper('url_helper');
    }
    public function index()
    {
        $data['news'] = $this->New_model->get_news();
        $data['title'] = 'News archive';
        // log_message('info','first error reported');
        // show_404($page = '', $log_error = TRUE);
        // show_error('Hello world', 403, $heading = 'Custom error testing by RP');
        $this->output->cache(2);


        $this->load->view('templates/header', $data);
        $this->load->view('news/index', $data);
        $this->load->view('templates/footer', $data);
    }
    public function view($slug = NULL)
    {
        $data['news_item'] = $this->New_model->get_news($slug);
        if (empty($data['news_item'])) {
            show_404();
        }
        $data['title'] = $data['news_item']['title'];

        $this->load->view('templates/header', $data);
        $this->load->view('news/view', $data);
        $this->load->view('templates/footer', $data);
    }
    public function create()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = 'Create a news item';

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('text', 'Text', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('news/create');
            $this->load->view('templates/footer', $data);
        } else {
            $this->New_model->set_news();
            $this->load->view('news/success');
        }
    }
}
