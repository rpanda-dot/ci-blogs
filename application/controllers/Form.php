<?php
class Form extends CI_Controller
{
    // public function __construct()
    // {
    // }
    public function index()
    {
        $this->load->helper(['form', 'url']);
        $this->load->library('form_validation');


        // $this->form_validation->set_rules('username', 'Username', 'required');
        // $this->form_validation->set_rules('password', 'Password', 'required', ['required' => 'You must provide a %s']);
        // $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');
        // $this->form_validation->set_rules('email', 'Email', 'required');

        //Setting the rules in array 

        $config = [
            [
                'field' => 'username',
                'label' => 'Username',
                // 'rules' => 'required|min_length[5]|max_length[12]|is_unique[users.username]',
                'rules' => 'callback_username_check',
                'errors' => [
                    'required' => 'You hav not provided %s',
                    'is_unique' => 'This %s already exists'
                ]
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => 'You must provide a %s'
                ]
            ],
            [
                'field' => 'passconf',
                'label' => 'Password Confirmation',
                'rules' => 'required|matches[password]'
            ],
            [
                'field' => 'email',
                'label' => 'Email Address',
                'rules' => 'required|valid_email|is_unique[users.email]'
            ]
        ];
        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == false) {
            $this->load->view('forms/myform');
        } else {
            $this->load->view('forms/formsuccess');
        }
    }
    public function username_check($str)
    {
        if ($str == 'test') {
            $this->form_validation->set_message('username_check', 'The {field} field can not be the word "test"');
            return false;
        }
        return true;
    }
}
