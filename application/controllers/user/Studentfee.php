<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
include(FCPATH . 'payment/AES128_php.php');
class Studentfee extends Student_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('smsgateway');
    }

    public function index()
    {
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'studentfee/index');
        $data['title']     = 'student fee';
        $class             = $this->class_model->get();
        $data['classlist'] = $class;
        $this->load->view('layout/student/header', $data);
        $this->load->view('studentfee/studentfeeSearch', $data);
        $this->load->view('layout/student/footer', $data);
    }

    public function pdf()
    {
        $this->load->helper('pdf_helper');
    }

    public function search()
    {
        $data['title']     = 'Student Search';
        $class             = $this->class_model->get();
        $data['classlist'] = $class;
        if ($this->input->server('REQUEST_METHOD') == "GET") {
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/studentfeeSearch', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $class       = $this->input->post('class_id');
            $section     = $this->input->post('section_id');
            $search      = $this->input->post('search');
            $search_text = $this->input->post('search_text');
            if (isset($search)) {
                if ($search == 'search_filter') {
                    $resultlist         = $this->student_model->searchByClassSection($class, $section);
                    $data['resultlist'] = $resultlist;
                } else if ($search == 'search_full') {
                    $resultlist         = $this->student_model->searchFullText($search_text);
                    $data['resultlist'] = $resultlist;
                }
            }
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/studentfeeSearch', $data);
            $this->load->view('layout/footer', $data);
        }
    }

    public function feesearch()
    {
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'studentfee/feesearch');
        $data['title']           = 'student fee';
        $class                   = $this->class_model->get();
        $data['classlist']       = $class;
        $feecategory             = $this->feecategory_model->get();
        $data['feecategorylist'] = $feecategory;
        $this->form_validation->set_rules('feecategory_id', 'Fee Category', 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/student/header', $data);
            $this->load->view('user/studentfee/studentSearchFee', $data);
            $this->load->view('layout/student/footer', $data);
        } else {
            $data['student_due_fee'] = array();
            $feecategory_id          = $this->input->post('feecategory_id');
            $feetype_id              = $this->input->post('feetype_id');
            $class_id                = $this->input->post('class_id');
            $section_id              = $this->input->post('section_id');
            $student_due_fee         = $this->studentfee_model->getDueStudentFees($feetype_id, $class_id, $section_id);
            $data['student_due_fee'] = $student_due_fee;
            $this->load->view('layout/student/header', $data);
            $this->load->view('user/studentfee/studentSearchFee', $data);
            $this->load->view('layout/student/footer', $data);
        }
    }

    public function reportbyname()
    {
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'studentfee/reportbyname');
        $data['title']     = 'student fee';
        $data['title']     = 'student fee';
        $class             = $this->class_model->get();
        $data['classlist'] = $class;
        if ($this->input->server('REQUEST_METHOD') == "GET") {
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/reportByName', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean');
            $this->form_validation->set_rules('class_id', 'Class', 'trim|required|xss_clean');
            $this->form_validation->set_rules('student_id', 'Student', 'trim|required|xss_clean');
            if ($this->form_validation->run() == false) {
                $this->load->view('layout/header', $data);
                $this->load->view('studentfee/reportByName', $data);
                $this->load->view('layout/footer', $data);
            } else {
                $data['student_due_fee'] = array();
                $class_id                = $this->input->post('class_id');
                $section_id              = $this->input->post('section_id');
                $student_id              = $this->input->post('student_id');
                $student_due_fee         = $this->studentfee_model->getDueFeeBystudent($class_id, $section_id, $student_id);
                $data['student']         = $this->student_model->getRecentRecord($student_id);
                $data['student_due_fee'] = $student_due_fee;
                $data['class_id']        = $class_id;
                $data['section_id']      = $section_id;
                $data['student_id']      = $student_id;
                $this->load->view('layout/header', $data);
                $this->load->view('studentfee/reportByName', $data);
                $this->load->view('layout/footer', $data);
            }
        }
    }

    public function reportbyclass()
    {
        $data['title']     = 'student fee';
        $data['title']     = 'student fee';
        $class             = $this->class_model->get();
        $data['classlist'] = $class;
        if ($this->input->server('REQUEST_METHOD') == "GET") {
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/reportByClass', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $student_fees_array      = array();
            $class_id                = $this->input->post('class_id');
            $section_id              = $this->input->post('section_id');
            $student_result          = $this->student_model->searchByClassSection($class_id, $section_id);
            $data['student_due_fee'] = array();
            if (!empty($student_result)) {
                foreach ($student_result as $key => $student) {
                    $student_array                      = array();
                    $student_array['student_detail']    = $student;
                    $student_session_id                 = $student['student_session_id'];
                    $student_id                         = $student['id'];
                    $student_due_fee                    = $this->studentfee_model->getDueFeeBystudentSection($class_id, $section_id, $student_session_id);
                    $student_array['fee_detail']        = $student_due_fee;
                    $student_fees_array[$student['id']] = $student_array;
                }
            }
            $data['class_id']           = $class_id;
            $data['section_id']         = $section_id;
            $data['student_fees_array'] = $student_fees_array;
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/reportByClass', $data);
            $this->load->view('layout/footer', $data);
        }
    }

    public function view($id)
    {
        $data['title']      = 'studentfee List';
        $studentfee         = $this->studentfee_model->get($id);
        $data['studentfee'] = $studentfee;
        $this->load->view('layout/header', $data);
        $this->load->view('studentfee/studentfeeShow', $data);
        $this->load->view('layout/footer', $data);
    }

    public function deleteFee()
    {
        $id = $this->input->post('feeid');
        $this->studentfee_model->remove($id);
        $array = array('status' => 'success', 'result' => 'success');
        echo json_encode($array);
    }

    public function addfee($id)
    {
        $data['title']           = 'Student Detail';
        $student                 = $this->student_model->get($id);
        $data['student']         = $student;
        $student_due_fee         = $this->studentfee_model->getDueFeeBystudent($student['class_id'], $student['section_id'], $id);
        $data['student_due_fee'] = $student_due_fee;
        $transport_fee           = $this->studenttransportfee_model->getTransportFeeByStudent($student['student_session_id']);
        $data['transport_fee']   = $transport_fee;
        $this->load->view('layout/header', $data);
        $this->load->view('studentfee/studentAddfee', $data);
        $this->load->view('layout/footer', $data);
    }

    public function deleteTransportFee()
    {
        $id = $this->input->post('feeid');
        $this->studenttransportfee_model->remove($id);
        $array = array('status' => 'success', 'result' => 'success');
        echo json_encode($array);
    }

    public function delete($id)
    {
        $data['title'] = 'studentfee List';
        $this->studentfee_model->remove($id);
        redirect('studentfee/index');
    }

    public function create()
    {
        $data['title'] = 'Add studentfee';
        $this->form_validation->set_rules('category', 'Category', 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/studentfeeCreate', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'category' => $this->input->post('category'),
            );
            $this->studentfee_model->add($data);
            $this->session->set_flashdata('msg', '<div studentfee="alert alert-success text-center">Employee details added to Database!!!</div>');
            redirect('studentfee/index');
        }
    }

    public function edit($id)
    {
        $data['title']      = 'Edit studentfee';
        $data['id']         = $id;
        $studentfee         = $this->studentfee_model->get($id);
        $data['studentfee'] = $studentfee;
        $this->form_validation->set_rules('category', 'category', 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/studentfeeEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'id'       => $id,
                'category' => $this->input->post('category'),
            );
            $this->studentfee_model->add($data);
            $this->session->set_flashdata('msg', '<div studentfee="alert alert-success text-center">Employee details added to Database!!!</div>');
            redirect('studentfee/index');
        }
    }

    public function add_Ajaxfee()
    {
        $this->form_validation->set_rules('fee_master_id', 'Fee Master', 'required|trim|xss_clean');
        $this->form_validation->set_rules('student_session_id', 'Student', 'required|trim|xss_clean');
        $this->form_validation->set_rules('amount', 'Amount', 'required|trim|xss_clean');
        $this->form_validation->set_rules('amount_discount', 'Discount', 'required|trim|xss_clean');
        $this->form_validation->set_rules('amount_fine', 'Fine', 'required|trim|xss_clean');
        if ($this->form_validation->run() == false) {
            $data = array(
                'amount'             => form_error('amount'),
                'fee_master_id'      => form_error('fee_master_id'),
                'student_session_id' => form_error('student_session_id'),
                'amount_discount'    => form_error('amount_discount'),
                'amount_fine'        => form_error('amount_fine'),
            );
            $array = array('status' => 'fail', 'error' => $data);
            echo json_encode($array);
        } else {
            $data = array(
                'amount'             => $this->input->post('amount'),
                'date'               => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'student_session_id' => $this->input->post('student_session_id'),
                'amount_discount'    => $this->input->post('amount_discount'),
                'amount_fine'        => $this->input->post('amount_fine'),
                'description'        => $this->input->post('description'),
                'feemaster_id'       => $this->input->post('fee_master_id'),
            );
            $inserted_id = $this->studentfee_model->add($data);
            $result      = $this->smsgateway->StudentAddFeesMSG($inserted_id);
            $array       = array('status' => 'success', 'error' => '');
            echo json_encode($array);
        }
    }

    public function add_AjaxTransportfee()
    {
        $this->form_validation->set_rules('student_session_id', 'Student', 'required|trim|xss_clean');
        $this->form_validation->set_rules('amount', 'Amount', 'required|trim|xss_clean');
        $this->form_validation->set_rules('amount_fine', 'Fine', 'required|trim|xss_clean');
        if ($this->form_validation->run() == false) {
            $data = array(
                'transport_amount'             => form_error('amount'),
                'transport_student_session_id' => form_error('student_session_id'),
                'transport_amount_discount'    => form_error('amount_discount'),
                'transport_amount_fine'        => form_error('amount_fine'),
            );
            $array = array('status' => 'fail', 'error' => $data);
            echo json_encode($array);
        } else {
            $data = array(
                'amount'             => $this->input->post('amount'),
                'date'               => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'student_session_id' => $this->input->post('student_session_id'),
                'amount_discount'    => "",
                'amount_fine'        => $this->input->post('amount_fine'),
                'description'        => $this->input->post('description'),
            );
            $inserted_id = $this->studenttransportfee_model->add($data);
            $array       = array('status' => 'success', 'error' => '');
            echo json_encode($array);
        }
    }

    public function printFeesByName()
    {
        $data                = array('payment' => "0");
        $data['receipt_no']  = $this->admin_model->addReceipt($data);
        $record              = $this->input->post('data');
        $student_session_id  = $this->input->post('student_session_id');
        $setting_result      = $this->setting_model->get();
        $data['settinglist'] = $setting_result;
        $student             = $this->studentsession_model->searchStudentsBySession($student_session_id);
        $data['student']     = $student;
        $record_array        = json_decode($record);
        $trans_array         = array();
        $fees_array          = array();
        foreach ($record_array as $key => $value) {
            $category = $value->category;
            $row_id   = $value->row_id;
            if ($category == "fees") {
                $fees_array[] = "'" . $row_id . "'";
            } else if ($category == "transport") {
                $trans_array[] = "'" . $row_id . "'";
            }
        }
        $monthly_record_array   = array();
        $transport_record_array = array();
        if (!empty($fees_array)) {
            $ids                  = implode(',', $fees_array);
            $monthly_record_array = $this->studentfee_model->getStudentFeesArray($student_session_id, $ids);
        }
        if (!empty($trans_array)) {
            $ids                    = implode(',', $trans_array);
            $transport_record_array = $this->studenttransportfee_model->getTransportFeeByIDs($ids);
        }
        $data['monthly_record']   = $monthly_record_array;
        $data['transport_record'] = $transport_record_array;
        $this->load->view('print/printFeesByName', $data);
    }

    public function searchpayment()
    {
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'studentfee/searchpayment');
        $data['title'] = 'Search With Payment ID';
        if ($this->input->server('REQUEST_METHOD') == "POST") {
            $search = $this->input->post('search');
            if ($search == "search_filter") {
                $data['exp_title']   = 'Transaction';
                $paymentid           = $this->input->post('paymentid');
                $expenseList         = $this->studenttransportfee_model->getfeeByID($paymentid);
                $feeList             = $this->studentfee_model->getFeeByInvoice($paymentid);
                $data['expenseList'] = $expenseList;
                $data['feeList']     = $feeList;
            }
            $this->load->view('layout/student/header', $data);
            $this->load->view('user/studentfee/searchpayment', $data);
            $this->load->view('layout/student/footer', $data);
        } else {
            $this->load->view('layout/student/header', $data);
            $this->load->view('user/studentfee/searchpayment', $data);
            $this->load->view('layout/student/footer', $data);
        }
    }

    public function transaction_success()
    {   
        $data = array();
        try {
            if ($_REQUEST['encData'])
            {
                $aes = new AESEncDec();

                $key = "pWhMnIEMc4q6hKdiE99GGY4GK5";
                $encData = $aes->decrypt($_REQUEST['encData'],$key);
                // echo $encData;
                // die();
                $response = explode('|',$encData);
                
                if(count($response) > 0) {
                    // echo '<pre>';
                    // print_r($response);
                    // echo '</pre>';
                    $student_id = explode('_',$response[0])[1];
                    $other_arr = array();
                    if(isset($response[6]) && !empty($response[6])) {
                        $others = explode(',',$response[6]);
                        if(count($others) > 0 ) {
                            for ($i=0; $i < count($others); $i++) { 
                                $key_value = explode('-',$others[$i]);
                                $other_arr[$key_value[0]] = $key_value[1];
                            }
                        }
                    }
                    // echo '<pre>';
                    // print_r($other_arr);
                    // echo '</pre>';
                    // die;
                    $data = [
                        'order_id'          => $response[0],
                        'transaction_id'          => $response[1],
                        'student_id'        => $student_id,
                        'transaction_status'=> $response[2],
                        'transaction_amount'=> $response[3],
                        'currency'=> $response[4],
                        'payment_method'    => $response[5],
                        'fee_groups_feetype_id'          => $other_arr['fee_groups_feetype_id'],
                        'bank_reference_id' => $response[9],
                        'transaction_date_time'     => $response[10],
                        'marchant_id'  => $response[13],
                    ];
                    if($response[2] == 'SUCCESS') {
                        // update  student_fees_deposite table for fee_groups_feetype_id 
                    } else if($response[2] == 'PENDING') {
                        
                    } else if($response[2] == 'FAIL') {
                        
                    }
                }
                $this->db->insert('student_transactions', $data);
            }
            $this->load->view('layout/student/header', $data);
            $this->load->view('payment/transaction_success', $data);
            $this->load->view('layout/student/footer', $data);
        } catch (\Throwable $th) {
            die('exception catched'.$th);
        }
    }
    public function transaction_failure()
    {
        $data = array();
        $this->load->view('layout/student/header', $data);
        $this->load->view('payment/transaction_failure', $data);
        $this->load->view('layout/student/footer', $data);
    }

    public function doubleVerification()
	{
	    //$this->sbiDoubleVerification();
	    
	   // Fetch records where transaction_status = 'PENDING'
        $query = $this->db->get_where('student_transactions', ['transaction_status' => 'PENDING']);
        $results = $query->result(); // Fetch multiple rows as objects

        // Loop through the records
        foreach ($results as $row) {
            echo "Transaction ID: " . $row->id . " - Status: " . $row->transaction_status . "<br>";
        

            $merchant_order_no=$row->order_id; // merchant order no
            $merchantid=$row->marchant_id;  //merchant id
            $amount=$row->transaction_amount; // Transaction posting Amount 
            $url="https://test.sbiepay.sbi/payagg/statusQuery/getStatusQuery";
            $queryRequest="|$merchantid|$merchant_order_no|$amount"; 

            $queryRequest33=http_build_query(array('queryRequest' => $queryRequest,'aggregatorId'=>'SBIEPAY','merchantId'=>$merchantid));
            
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false); 
            curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,1);
            curl_setopt($ch, CURLOPT_SSLVERSION, 6);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $queryRequest33);
            $response = curl_exec ($ch);			
            if (curl_errno($ch)) {
                echo $error_msg = curl_error($ch);
            }				
            curl_close ($ch);
            echo $response;
            $response = explode('|',$response);
                
            if(count($response) > 0 && $response[2] == 'SUCCESS') {
                $this->db->where('id', $row->id);
                $this->db->update('student_transactions', ['transaction_status' => 'SUCCESS']);
            }
        }
	}


}
