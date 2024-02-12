<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Breakupmaster extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->sch_setting_detail = $this->setting_model->getSetting();
        $this->load->model(array('breakup_master_model'));
    }

    public function index()
    {

        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'admin/feemaster');
		
        $data['title'] = $this->lang->line('breakup_list');
        $data['breakups'] = $this->breakup_master_model->get();
        
        $this->form_validation->set_rules('breakup_name', $this->lang->line('breakup_name'), 'required');
       
        if ($this->form_validation->run() == false) {

        } else {
            
            $insert_array = array(
                'name'   => $this->input->post('breakup_name'),
            );

            $feegroup_result = $this->breakup_master_model->add($insert_array);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('success_message') . '</div>');
            redirect('admin/breakupmaster/index');
        }

        $this->load->view('layout/header', $data);
        $this->load->view('admin/breakupMaster/breakupMaster', $data);
        $this->load->view('layout/footer', $data);
    }

    public function delete($id)
    {
        if (!$this->rbac->hasPrivilege('fees_master', 'can_delete')) {
            access_denied();
        }
        $data['title'] = $this->lang->line('fees_master_list');
        $this->breakup_master_model->remove($id);
        redirect('admin/breakupmaster/index');
    }
    
    public function edit($id)
    {
        if (!$this->rbac->hasPrivilege('fees_master', 'can_edit')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'admin/feemaster');
        $data['id']            = $id;
        $breakup_data         = $this->breakup_master_model->get($id);
        $data['breakup_data'] = $breakup_data;
        $data['breakups'] = $this->breakup_master_model->get();
        
        $this->form_validation->set_rules('breakup_name', $this->lang->line('breakup_name'), 'required');
        
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/breakupMaster/breakupMasterEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            
            $insert_array = array(
                'id'              => $this->input->post('id'),
                'name'      => $this->input->post('breakup_name')
            );

            $breakup_result = $this->breakup_master_model->add($insert_array);

            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('update_message') . '</div>');
            redirect('admin/breakupmaster/index');
        }
    }

    public function assign($id)
    {
        if (!$this->rbac->hasPrivilege('fees_group_assign', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'admin/feemaster');
        $data['id']              = $id;
        $data['title']           = $this->lang->line('student_fees');
        $class                   = $this->class_model->get();
        $data['classlist']       = $class;
        $feegroup_result         = $this->feesessiongroup_model->getFeesByGroup($id);
        $data['feegroupList']    = $feegroup_result;
        $data['adm_auto_insert'] = $this->sch_setting_detail->adm_auto_insert;
        $data['sch_setting']     = $this->sch_setting_detail;
        $genderList            = $this->customlib->getGender();
        $data['genderList']    = $genderList;
        $RTEstatusList         = $this->customlib->getRteStatus();
        $data['RTEstatusList'] = $RTEstatusList;

        $category             = $this->category_model->get();
        $data['categorylist'] = $category;

        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            $data['category_id'] = $this->input->post('category_id');
            $data['gender']      = $this->input->post('gender');
            $data['rte_status']  = $this->input->post('rte');
            $data['class_id']    = $this->input->post('class_id');
            $data['section_id']  = $this->input->post('section_id');

            $resultlist         = $this->studentfeemaster_model->searchAssignFeeByClassSection($data['class_id'], $data['section_id'], $id, $data['category_id'], $data['gender'], $data['rte_status']);
            $data['resultlist'] = $resultlist;
        }

        $this->load->view('layout/header', $data);
        $this->load->view('admin/feemaster/assign', $data);
        $this->load->view('layout/footer', $data);
    }

}
