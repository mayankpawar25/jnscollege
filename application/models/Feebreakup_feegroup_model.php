<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Feebreakup_feegroup_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
    }

    public function get($id = null)
    {
        $this->db->select()->from('fee_breakup_fee_group');
        if ($id != null) {
            $this->db->where('id', $id);
        } else {
            $this->db->order_by('id');
        }
        $query = $this->db->get();
        $result = $query->result();

        foreach ($result as $key => $value) {
            $value->breakup = $this->breakup_master_model->get($value->feebreakup_id);
            $value->group = $this->feegroup_model->get($value->feegroup_id);
            $value->group['type'] = $this->feegrouptype_model->getfeeTypeByGroup($value->feegroup_id);
        }

        return $result;
        // if ($id != null) {
        //     return $query->row_array();
        // } else {
        //     return $query->result_array();
        // }
    }

    public function getByGroupId($id = null)
    {
        $this->db->select()->from('fee_breakup_fee_group');
        if ($id != null) {
            $this->db->where('feegroup_id', $id);
        } else {
            $this->db->order_by('id');
        }
        $query = $this->db->get();
        $result = $query->result();

        foreach ($result as $key => $value) {
            $value->breakup = $this->breakup_master_model->get($value->feebreakup_id);
            $value->group = $this->feegroup_model->get($value->feegroup_id);
            $value->group['type'] = $this->feegrouptype_model->getfeeTypeByGroup($value->feegroup_id);
        }

        return $result;
        // if ($id != null) {
        //     return $query->row_array();
        // } else {
        //     return $query->result_array();
        // }
    }

    public function getByGroupIdReport($id = null)
    {
        $this->datatables
            ->select('*')
            ->from('fee_breakup_fee_group');
        if ($id != null) {
            $this->datatables->where('feegroup_id', $id);
        } else {
            $this->datatables->order_by('id');
        }

        // $this->datatables
        //     ->select('fee_breakup_fee_group.*, 
        //             feebreakups_master.name as feebreakup_name, 
        //             fee_groups.*, 
        //             feetype.type as feetype_type, 
        //             feetype.code as feetype_code')
        //     ->from('fee_breakup_fee_group')
        //     ->join('feebreakups_master', 'fee_breakup_fee_group.feebreakup_id = feebreakups_master.id', 'left')
        //     ->join('fee_groups', 'fee_breakup_fee_group.feegroup_id = fee_groups.id', 'left')
        //     ->join('fee_groups_feetype', 'fee_breakup_fee_group.feegroup_id = fee_groups_feetype.fee_groups_id', 'left')
        //     ->join('feetype', 'fee_groups_feetype.feetype_id = feetype.id', 'left');

        if ($id != null) {
            $this->datatables->where('fee_breakup_fee_group.feegroup_id', $id);
        } else {
            $this->datatables->order_by('fee_breakup_fee_group.id');
        }
        
        $this->datatables->sort('fee_breakup_fee_group.id', 'asc');
        return $this->datatables->generate('json');
    }

    /**
     * This function will delete the record based on the id
     * @param $id
     */
    public function remove($id)
    {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        $this->db->where('id', $id);
        $this->db->delete('fee_breakup_fee_group');
        $message   = DELETE_RECORD_CONSTANT . " On  fee group id " . $id;
        $action    = "Delete";
        $record_id = $id;
        $this->log($message, $record_id, $action);
        //======================Code End==============================
        $this->db->trans_complete(); # Completing transaction
        /* Optional */
        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return false;
        } else {
            //return $return_value;
        }
    }

    /**
     * This function will take the post data passed from the controller
     * If id is present, then it will do an update
     * else an insert. One function doing both add and edit.
     * @param $data
     */
    public function add($data)
    {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('fee_breakup_fee_group', $data);
            $message   = UPDATE_RECORD_CONSTANT . " On  fee group id " . $data['id'];
            $action    = "Update";
            $record_id = $id = $data['id'];
            $this->log($message, $record_id, $action);
        } else {
            $this->db->insert('fee_breakup_fee_group', $data);
            $id        = $this->db->insert_id();
            $message   = INSERT_RECORD_CONSTANT . " On  fee group id " . $id;
            $action    = "Insert";
            $record_id = $id;
            $this->log($message, $record_id, $action);

        }

        //======================Code End==============================

        $this->db->trans_complete(); # Completing transaction
        /* Optional */

        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return false;
        } else {
            return $id;
        }
    }

    public function check_exists($str)
    {
        $name = $this->security->xss_clean($str);
        $id   = $this->input->post('id');
        if (!isset($id)) {
            $id = 0;
        }

        if ($this->check_data_exists($name, $id)) {
            $this->form_validation->set_message('check_exists', 'Record already exists');
            return false;
        } else {
            return true;
        }
    }

    public function check_data_exists($name, $id)
    {
        $this->db->where('name', $name);
        $this->db->where('id !=', $id);
        $query = $this->db->get('fee_breakup_fee_group');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function checkGroupExistsByName($name)
    {
        $this->db->where('name', $name);
        $query = $this->db->get('fee_breakup_fee_group');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

}
