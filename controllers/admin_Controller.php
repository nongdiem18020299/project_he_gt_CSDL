<?php

class admin_Controller extends Controller {
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        // $this->view->render('admin/register');
        $this->view->render('admin/header_admin');
        $this->view->render('admin/adminThanhVien');
        $this->view->render('admin/footer_admin');
        
    }
}
