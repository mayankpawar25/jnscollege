<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Feebreakups extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->sch_setting_detail = $this->setting_model->getSetting();
        $this->load->model(array('breakup_master_model', 'feebreakup_feegroup_model'));
    }

    public function index()
    {

        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'admin/feemaster');
		
        $data['title']        = $this->lang->line('fees_breakup_list');
        $feegroup             = $this->feegroup_model->get();
        $data['feegroupList'] = $feegroup;

        $feegroup_result       = $this->feesessiongroup_model->getFeesByGroup(null,0);
        $data['feemasterList'] = $feegroup_result;

        if($this->input->post('fee_groups_id')) {
            $feebreakups_feegroup = $this->feebreakup_feegroup_model->getByGroupId($this->input->post('fee_groups_id'));
            $data['feebreakups_feegroup'] = $feebreakups_feegroup;
            $data['fee_groups_id'] = $this->input->post('fee_groups_id');
        }

        $data['breakups'] =  $this->breakup_master_model->get();

        $this->form_validation->set_rules('fee_breakup_id', $this->lang->line('fee_type'), 'required');
        $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'required|numeric');

        $this->form_validation->set_rules(
            'fee_groups_id', $this->lang->line('fee_group'), array(
                'required',
                array('check_exists', array($this->feesessiongroup_model, 'valid_check_exists')),
            )
        );

        if ($this->form_validation->run() == false) {

        } else {
            
            if($this->input->post('fine_amount')){
                $fine_amount    =   convertCurrencyFormatToBaseAmount($this->input->post('fine_amount'));
            }else{
                $fine_amount    = '';
            }
            
            $insert_array = array(
                'feegroup_id'     => $this->input->post('fee_groups_id'),
                'session_id'      => $this->setting_model->getCurrentSession(),
                'feebreakup_id'   => $this->input->post('fee_breakup_id'),
                'amount'          => convertCurrencyFormatToBaseAmount($this->input->post('amount'))
            );
            
            $feegroup_result = $this->feebreakup_feegroup_model->add($insert_array);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('success_message') . '</div>');
            redirect('admin/feebreakups/index');
        }

        $this->load->view('layout/header', $data);
        $this->load->view('admin/feebreakups/feebreakupList', $data);
        $this->load->view('layout/footer', $data);
    }

    public function delete($id)
    {
        if (!$this->rbac->hasPrivilege('fees_master', 'can_delete')) {
            access_denied();
        }
        $data['title'] = $this->lang->line('fees_master_list');
        $this->feebreakup_feegroup_model->remove($id);
        redirect('admin/feebreakups/index');
    }

    public function edit($id)
    {
        if (!$this->rbac->hasPrivilege('fees_master', 'can_edit')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'admin/feemaster');
        $data['id']            = $id;
        $feegroup_type         = $this->feebreakup_feegroup_model->get($id);
        // echo "<pre>";
        // print_r($feegroup_type);
        // die;
        $data['feegroup_type'] = $feegroup_type;
        $feegroup              = $this->feegroup_model->get();
        $data['feegroupList']  = $feegroup;
        $feetype               = $this->feetype_model->get();
        $data['feetypeList']   = $feetype;
        $feegroup_result       = $this->feesessiongroup_model->getFeesByGroup(null,0);
        $data['feemasterList'] = $feegroup_result;
        $data['breakups'] =  $this->breakup_master_model->get();

        $feebreakups_feegroup = $this->feebreakup_feegroup_model->getByGroupId($feegroup_type[0]->feegroup_id);
        $data['feebreakups_feegroup'] = $feebreakups_feegroup;

        $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'required|numeric');
        $this->form_validation->set_rules(
            'fee_groups_id', $this->lang->line('fee_group'), array(
                'required',
                array('check_exists', array($this->feesessiongroup_model, 'valid_check_exists')),
            )
        );
        
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/feebreakups/feebreakupEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            
            if($this->input->post('fine_amount')){
                $fine_amount    =   convertCurrencyFormatToBaseAmount($this->input->post('fine_amount'));
            }else{
                $fine_amount    = '';
            }
            
            $insert_array = array(
                'id'              => $this->input->post('id'),
                'feegroup_id'     => $this->input->post('fee_groups_id'),
                'session_id'      => $this->setting_model->getCurrentSession(),
                'feebreakup_id'   => $this->input->post('fee_breakup_id'),
                'amount'          => convertCurrencyFormatToBaseAmount($this->input->post('amount'))
            );

            $feegroup_result = $this->feebreakup_feegroup_model->add($insert_array);

            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('update_message') . '</div>');
            redirect('admin/feebreakups/index');
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
