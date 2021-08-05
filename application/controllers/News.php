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
        $this->benchmark->mark('code_start');

        // Some code happens here


        $data['news'] = $this->New_model->get_news();
        $data['title'] = 'News archive';
        // log_message('info','first error reported');
        // show_404($page = '', $log_error = TRUE);
        // show_error('Hello world', 403, $heading = 'Custom error testing by RP');
        // $this->output->cache(2);
        $this->output->enable_profiler(TRUE);



        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

        if (!$foo = $this->cache->get('foo')) {
            echo 'Saving to the cache!<br />';
            $foo = 'foobarbaz!';

            // Save into the cache for 5 minutes
            $this->cache->save('foo', $foo, 300);
        }

        echo $foo;
        var_dump($this->cache->get_metadata('foo'));








        $this->load->view('templates/header', $data);
        $this->load->view('news/index', $data);
        $this->load->view('templates/footer', $data);
        $this->benchmark->mark('code_end');
        echo $this->benchmark->elapsed_time('code_start', 'code_end');
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
    public function calendar($year = 2021, $month = 11)
    {

        $prefs = array(
            'start_day'    => 'saturday',
            'month_type'   => 'long',
            'show_next_prev'  => TRUE,
            'day_type'     => 'short'
        );
        $prefs['template'] = '

        {table_open}<table border="0" cellpadding="0" cellspacing="0">{/table_open}

        {heading_row_start}<tr>{/heading_row_start}

        {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
        {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
        {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

        {heading_row_end}</tr>{/heading_row_end}

        {week_row_start}<tr>{/week_row_start}
        {week_day_cell}<td>{week_day}</td>{/week_day_cell}
        {week_row_end}</tr>{/week_row_end}

        {cal_row_start}<tr>{/cal_row_start}
        {cal_cell_start}<td>{/cal_cell_start}
        {cal_cell_start_today}<td>{/cal_cell_start_today}
        {cal_cell_start_other}<td class="other-month">{/cal_cell_start_other}

        {cal_cell_content}<a href="{content}">{day}</a>{/cal_cell_content}
        {cal_cell_content_today}<div class="highlight"><a href="{content}">{day}</a></div>{/cal_cell_content_today}

        {cal_cell_no_content}{day}{/cal_cell_no_content}
        {cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}

        {cal_cell_blank}&nbsp;{/cal_cell_blank}

        {cal_cell_other}{day}{/cal_cel_other}

        {cal_cell_end}</td>{/cal_cell_end}
        {cal_cell_end_today}</td>{/cal_cell_end_today}
        {cal_cell_end_other}</td>{/cal_cell_end_other}
        {cal_row_end}</tr>{/cal_row_end}

        {table_close}</table>{/table_close}
';
$prefs['template'] = array(
    'table_open'           => '<table class="calendar">',
    'cal_cell_start'       => '<td class="day">',
    'cal_cell_start_today' => '<td class="today">'
);
        $data = array(
            3  => 'http://localhost/ci-blogs/news/calendar/2006/06',
            7  => 'http://localhost/ci-blogs/news/calendar/2008/06',
            13 => 'http://localhost/ci-blogs/news/calendar/2009/06',
            26 => 'http://localhost/ci-blogs/news/calendar/2010/06'
        );
        $this->load->library('calendar', $prefs);
        echo $this->calendar->generate($year, $month, $data);
    }
}
