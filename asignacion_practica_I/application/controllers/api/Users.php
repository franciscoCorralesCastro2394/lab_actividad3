<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Users extends REST_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->database();
        }

        public function getUsers_get()
        {
            $id = $this->uri->segment(4);

            if(!empty($id)){
                $data = $this->db->get_where('usuarios', ['id' => $id])->row_array();
            }else{
                $data = $this->db->get('usuarios')->result();
            }

            if(!$data)
                $data = 'No hay registros con este ID.';

            $this->response($data, REST_Controller::HTTP_OK);
        }

        public function insertUsers_post()
        {
            $data = $this->input->post();

            if($this->db->insert('usuarios', $data))
                $this->response('Item creado con éxito.', REST_Controller::HTTP_OK); 
        }

        public function updateUsers_put()
        {
            $id = $this->put('usuarios');
            $data = $this->put();

            if($this->db->update('usuarios', $data, array('id'=>$id)))
                $this->response('Item actualizado con éxito.', REST_Controller::HTTP_OK);
        }

        public function deleteUsers_get()
        {
            $id = $this->uri->segment(4);

            if($this->db->delete('usuarios', array('id'=>$id)))
                $this->response('Item eliminado con éxito.', REST_Controller::HTTP_OK);
        }


         public function postLoginSeguro_post()
        {
            $user = $this->input->post("user");
            $pass = $this->input->post("pass");

 
            if(!empty($user)){
                $array  = array('usuario' => $user, 'pass' => $pass);
                $data = $this->db->get_where('usuarios',$array)->row_array();
            }

            $this->response($data, REST_Controller::HTTP_OK);
        }
}