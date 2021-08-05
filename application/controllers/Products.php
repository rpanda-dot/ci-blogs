<?php
class Products extends CI_Controller
{
    public function add_cart()
    {
        $this->load->library('cart');

        $data = array(
            'id'      => 'sku_123ABC',
            'qty'     => 1,
            'price'   => 39.95,
            'name'    => 'T-Shirt',
            'options' => array('Size' => 'L', 'Color' => 'Red')
        );

        $this->cart->insert($data);
        echo 'done';
    }
    public function show_cart()
    {
        $this->load->library('cart');
        echo '<pre>';
        print_r($this->cart->contents());
        echo '</pre>';
    }
    public function list_cart()
    {
        $this->load->helper('form');

        $this->load->library('cart');
        $this->load->view('products/listing');
    }
}
