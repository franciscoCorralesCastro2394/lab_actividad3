<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Publicacion extends REST_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->database();
                $db2 = $this->load->database('default', TRUE);
        }

        public function getPublicaciones_get()
        {
            $criterio = $this->uri->segment(4);
            $respuesta = [];
            if(!empty($criterio)){
                $this->db->select('p.*,u.usuario');
                $this->db->from('post p');
                $this->db->join('usuarios u', 'p.idUsuario = u.id AND p.estado = 1');
                $this->db->like('textoPost', $criterio);
                $this->db->order_by('fecha','desc');
                $data = $this->db->get()->result_array();
            }else{
                $this->db->select('p.*,u.usuario');
                $this->db->from('post p');
                $this->db->join('usuarios u', 'p.idUsuario = u.id AND p.estado = 1');
                $this->db->order_by('fecha','asc');
                $data = $this->db->get()->result_array();
            }
            //Se carga nombre del usuario a cada post 
            foreach ($data as $row) 
            {
                $this->db->select('c.*,u.usuario');
                $this->db->from('comentarios c');
                $this->db->join('usuarios u', 'c.idUsuario = u.id AND c.estado = 1',);
                $this->db->where('idPost',$row['idPost']);
                $this->db->order_by('fecha','asc');
                $row['comments'] = $this->db->get()->result_array();
                $respuesta[] = $row;
            }
            
            
            if(!$data)
                $data = 'No hay registros con este ID.';

            $this->response($respuesta, REST_Controller::HTTP_OK);
        }

        public function insertPublicacion_post()
        {
            $data = $this->input->post();

            if($this->db->insert('post', $data))
                $this->response('Item creado con éxito.', REST_Controller::HTTP_OK); 
        }

        public function updatePublicacion_put()
        {
            $id = $this->put('postId');
            $data = $this->put();

            if($this->db->update('post', $data, array('idPost'=>$id)))
                $this->response('Item actualizado con éxito.', REST_Controller::HTTP_OK);
        }

        public function deletePublicacion_get()
        {
            $id = $this->uri->segment(4);

            $this->db->where('idPost',$id);
            $this->db->update('post',array('estado' => 0));

         
            $this->response('Item eliminado con éxito.', REST_Controller::HTTP_OK);
        }

        public function insertComentario_post(){

             $data = $this->input->post();
            if($this->db->insert('comentarios', $data))
                $this->response('Item creado con éxito.', REST_Controller::HTTP_OK); 

        }

          public function deleteComentario_get()
        {
            $id = $this->uri->segment(4);

            $this->db->where('idComentario',$id);
            $this->db->update('comentarios',array('estado' => 0));

         
            $this->response('Item eliminado con éxito.', REST_Controller::HTTP_OK);
        }
}
