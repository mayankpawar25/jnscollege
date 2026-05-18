<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Credentials extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('setting_model');
    }

    public function view($token = null)
    {
        $token = trim((string) $token);

        if ($token === '' || !preg_match('/^[a-f0-9]{32,128}$/i', $token)) {
            $this->_renderError('The link is invalid.');
            return;
        }

        if (!$this->db->table_exists('whatsapp_credential_tokens')) {
            $this->_renderError('The link is invalid or has expired.');
            return;
        }

        $row = $this->db->get_where('whatsapp_credential_tokens', array('token' => $token))->row_array();

        if (empty($row)) {
            $this->_renderError('The link is invalid or has expired.');
            return;
        }

        if (!empty($row['expires_at']) && strtotime($row['expires_at']) < time()) {
            $this->_renderError('This link has expired. Please contact the school office to request a new one.');
            return;
        }

        $user = $this->db->get_where('users', array('id' => $row['user_id']))->row_array();

        if (empty($user)) {
            $this->_renderError('We could not find the account for this link.');
            return;
        }

        $this->db->where('id', $row['id'])->update('whatsapp_credential_tokens', array(
            'accessed_at'  => date('Y-m-d H:i:s'),
            'access_count' => (int) $row['access_count'] + 1,
        ));

        $school    = $this->setting_model->getSchoolDetail();
        $role      = $row['role'];
        $login_url = site_url('site/userlogin');

        $heading = ($role === 'parent')
            ? 'Parent Portal Login'
            : 'Student Portal Login';

        $data = array(
            'school'    => $school,
            'username'  => $user['username'],
            'password'  => $user['password'],
            'role'      => $role,
            'login_url' => $login_url,
            'heading'   => $heading,
        );

        $this->load->view('credentials/show', $data);
    }

    public function setup($token = null)
    {
        $token = trim((string) $token);

        if ($token === '' || !preg_match('/^[a-f0-9]{32,128}$/i', $token)) {
            $this->_renderError('The link is invalid.');
            return;
        }

        if (!$this->db->table_exists('whatsapp_credential_tokens')) {
            $this->_renderError('The link is invalid or has expired.');
            return;
        }

        $row = $this->db->get_where('whatsapp_credential_tokens', array('token' => $token))->row_array();

        if (empty($row) || (isset($row['purpose']) && $row['purpose'] !== 'setup')) {
            $this->_renderError('The link is invalid or has expired.');
            return;
        }

        if (!empty($row['consumed_at'])) {
            $this->_renderError('This link has already been used. Please contact the school office if you need a new one.');
            return;
        }

        if (!empty($row['expires_at']) && strtotime($row['expires_at']) < time()) {
            $this->_renderError('This link has expired. Please contact the school office to request a new one.');
            return;
        }

        $user = $this->db->get_where('users', array('id' => $row['user_id']))->row_array();

        if (empty($user)) {
            $this->_renderError('We could not find the account for this link.');
            return;
        }

        $school    = $this->setting_model->getSchoolDetail();
        $role      = $row['role'];
        $login_url = site_url('site/userlogin');
        $heading   = ($role === 'parent') ? 'Set Parent Portal Password' : 'Set Student Portal Password';

        $errors  = array();
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = (string) $this->input->post('password', true);
            $confirm  = (string) $this->input->post('password_confirm', true);

            if (strlen($password) < 8) {
                $errors[] = 'Password must be at least 8 characters long.';
            }
            if ($password !== $confirm) {
                $errors[] = 'Passwords do not match.';
            }

            if (empty($errors)) {
                $this->db->where('id', $user['id'])->update('users', array('password' => $password));
                $this->db->where('id', $row['id'])->update('whatsapp_credential_tokens', array(
                    'consumed_at'  => date('Y-m-d H:i:s'),
                    'accessed_at'  => date('Y-m-d H:i:s'),
                    'access_count' => (int) $row['access_count'] + 1,
                ));
                $success = true;
            }
        } else {
            $this->db->where('id', $row['id'])->update('whatsapp_credential_tokens', array(
                'accessed_at'  => date('Y-m-d H:i:s'),
                'access_count' => (int) $row['access_count'] + 1,
            ));
        }

        $data = array(
            'school'    => $school,
            'username'  => $user['username'],
            'role'      => $role,
            'login_url' => $login_url,
            'heading'   => $heading,
            'errors'    => $errors,
            'success'   => $success,
        );

        $this->load->view('credentials/setup', $data);
    }

    private function _renderError($message)
    {
        $school = $this->setting_model->getSchoolDetail();
        $this->load->view('credentials/error', array(
            'school'  => $school,
            'message' => $message,
        ));
    }
}
