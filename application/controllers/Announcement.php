<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Announcement extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Announcement_model');
    } 

    /*
     * Listing of announcement
     */
    function index()
    {
        $data['announcement'] = $this->Announcement_model->get_all_announcement();
        
        $data['_view'] = 'announcement/index';
        $this->load->view('layouts/main',$data);
    }

    /*
     * Adding a new announcement
     */
    function add()
    {   
        if(isset($_POST) && count($_POST) > 0)     
        {   
            $params = array(
				'title' => $this->input->post('title'),
				'subject' => $this->input->post('subject'),
				'createdBy' => $this->input->post('createdBy'),
				'date' => $this->input->post('date'),
				'body' => $this->input->post('body'),
            );
            
            $announcement_id = $this->Announcement_model->add_announcement($params);
            redirect('announcement/index');
        }
        else
        {            
            $data['_view'] = 'announcement/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    /*
     * Editing a announcement
     */
    function edit($uid)
    {   
        // check if the announcement exists before trying to edit it
        $data['announcement'] = $this->Announcement_model->get_announcement($uid);
        
        if(isset($data['announcement']['uid']))
        {
            if(isset($_POST) && count($_POST) > 0)     
            {   
                $params = array(
					'title' => $this->input->post('title'),
					'subject' => $this->input->post('subject'),
					'createdBy' => $this->input->post('createdBy'),
					'date' => $this->input->post('date'),
					'body' => $this->input->post('body'),
                );

                $this->Announcement_model->update_announcement($uid,$params);            
                redirect('announcement/index');
            }
            else
            {
                $data['_view'] = 'announcement/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The announcement you are trying to edit does not exist.');
    } 

    /*
     * Deleting announcement
     */
    function remove($uid)
    {
        $announcement = $this->Announcement_model->get_announcement($uid);

        // check if the announcement exists before trying to delete it
        if(isset($announcement['uid']))
        {
            $this->Announcement_model->delete_announcement($uid);
            redirect('announcement/index');
        }
        else
            show_error('The announcement you are trying to delete does not exist.');
    }
    
}
