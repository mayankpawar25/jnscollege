<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('whatsapp_format_phone')) {
    function whatsapp_format_phone($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', (string) $phone);
        if (strlen($phone) == 10) {
            $phone = '91' . $phone;
        }
        return $phone;
    }
}

if (!function_exists('whatsapp_get_meta_credentials')) {
    function whatsapp_get_meta_credentials()
    {
        $CI =& get_instance();
        $CI->load->model('setting_model');
        $setting = $CI->setting_model->getSetting();

        return array(
            'access_token'    => isset($setting->whatsapp_access_token) ? $setting->whatsapp_access_token : '',
            'phone_number_id' => isset($setting->whatsapp_phone_id) ? $setting->whatsapp_phone_id : '',
        );
    }
}

if (!function_exists('whatsapp_send_credential_setup')) {
    function whatsapp_send_credential_setup($role, $phone, $display_name, $setup_url, $access_token = null, $phone_number_id = null)
    {
        if ($access_token === null || $phone_number_id === null) {
            $creds = whatsapp_get_meta_credentials();
            $access_token    = $creds['access_token'];
            $phone_number_id = $creds['phone_number_id'];
        }

        if (empty($access_token) || empty($phone_number_id)) {
            return array('status' => false, 'error' => 'WhatsApp credentials not configured');
        }
        if (empty($phone)) {
            return array('status' => false, 'error' => 'Missing phone number');
        }

        $phone        = whatsapp_format_phone($phone);
        $template_name = ($role === 'parent') ? 'parent_details' : 'child_details';
        $display_name  = $display_name !== '' ? $display_name : (($role === 'parent') ? 'Parent' : 'Student');

        $url = "https://graph.facebook.com/v18.0/{$phone_number_id}/messages";

        $data = array(
            'messaging_product' => 'whatsapp',
            'to'   => $phone,
            'type' => 'template',
            'template' => array(
                'name'     => $template_name,
                'language' => array('code' => 'en'),
                'components' => array(
                    array(
                        'type' => 'body',
                        'parameters' => array(
                            array('type' => 'text', 'text' => $display_name),
                            array('type' => 'text', 'text' => $setup_url),
                        ),
                    ),
                ),
            ),
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $access_token,
        ));

        $response   = curl_exec($ch);
        $http_code  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        curl_close($ch);

        if ($http_code == 200) {
            return array('status' => true);
        }

        $error_msg = 'WhatsApp API error: HTTP ' . $http_code;
        if (!empty($curl_error)) {
            $error_msg .= ' - ' . $curl_error;
        }
        if (!empty($response)) {
            $error_msg .= ' - ' . $response;
        }
        return array('status' => false, 'error' => $error_msg);
    }
}
