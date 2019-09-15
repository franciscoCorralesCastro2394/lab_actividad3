<?php
class News extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('news_model');
                $this->load->helper('url_helper');
                $this->load->library('session');
        }

        public function index()
        {
                $data['news'] = $this->news_model->get_news();

                $data['title'] = 'Noticias';

                $this->load->view('templates/header', $data);
                $this->load->view('news/index', $data);
                $this->load->view('templates/footer');
        }

        public function view($id = NULL)
        {
                $data['news_item'] = $this->news_model->get_news($id);

                if (empty($data['news_item']))
                {
                        show_404();
                }

                $data['title'] = $data['news_item']['title'];

                $this->load->view('templates/header', $data);
                $this->load->view('news/view', $data);
                $this->load->view('templates/footer');
        }

        public function create()
        {
            $this->load->helper('form');
            $this->load->library('form_validation');

            $data['title'] = 'Crear nueva Noticia';

            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('text', 'Text', 'required');

            if ($this->form_validation->run() === FALSE)
            {
                $this->load->view('templates/header', $data);
                $this->load->view('news/create');
                $this->load->view('templates/footer');

            }
            else
            {
                $this->news_model->set_news();
                $this->session->set_flashdata('msg', 'Noticia agregada correctamente');
                redirect("news");
            }
        }

        public function edit($id = NULL)
        {
            $this->load->helper('form');
            $this->load->library('form_validation');

            $data['title'] = 'Editar Noticia';
            $data['news_item'] = $this->news_model->get_news($id);

            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('text', 'Text', 'required');

            if ($this->form_validation->run() === FALSE)
            {
                $this->load->view('templates/header', $data);
                $this->load->view('news/edit', $data);
                $this->load->view('templates/footer');

            }
            else
            {
                $this->news_model->edit_news($id);
                 $this->session->set_flashdata('msg', 'Noticia actualizada correctamente');
                redirect("news");
            }
        }

        public function delete($id = FALSE)
        {
            $this->news_model->delete_news($id);
             $this->session->set_flashdata('msg', 'Noticia eliminada correctamente');
            redirect("news");
        }
}