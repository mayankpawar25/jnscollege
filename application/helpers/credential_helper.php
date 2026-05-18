<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('ensure_credential_tokens_table')) {
    function ensure_credential_tokens_table()
    {
        $CI =& get_instance();
        $CI->load->database();

        if (!$CI->db->table_exists('whatsapp_credential_tokens')) {
            $sql = "CREATE TABLE IF NOT EXISTS `whatsapp_credential_tokens` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `token` VARCHAR(128) NOT NULL,
                `user_id` INT(11) NOT NULL,
                `role` VARCHAR(20) NOT NULL,
                `student_id` INT(11) DEFAULT NULL,
                `purpose` VARCHAR(20) NOT NULL DEFAULT 'view',
                `created_at` DATETIME NOT NULL,
                `expires_at` DATETIME NOT NULL,
                `accessed_at` DATETIME DEFAULT NULL,
                `consumed_at` DATETIME DEFAULT NULL,
                `access_count` INT(11) NOT NULL DEFAULT 0,
                PRIMARY KEY (`id`),
                UNIQUE KEY `token` (`token`),
                KEY `user_id` (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            $CI->db->query($sql);
            return;
        }

        if (!$CI->db->field_exists('purpose', 'whatsapp_credential_tokens')) {
            $CI->db->query("ALTER TABLE `whatsapp_credential_tokens` ADD COLUMN `purpose` VARCHAR(20) NOT NULL DEFAULT 'view' AFTER `student_id`");
        }
        if (!$CI->db->field_exists('consumed_at', 'whatsapp_credential_tokens')) {
            $CI->db->query("ALTER TABLE `whatsapp_credential_tokens` ADD COLUMN `consumed_at` DATETIME DEFAULT NULL AFTER `accessed_at`");
        }
    }
}

if (!function_exists('create_credential_setup_url')) {
    function create_credential_setup_url($user_id, $role, $student_id = null)
    {
        $CI =& get_instance();
        $CI->load->database();
        $CI->load->helper('url');

        ensure_credential_tokens_table();

        if (function_exists('random_bytes')) {
            $token = bin2hex(random_bytes(24));
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $token = bin2hex(openssl_random_pseudo_bytes(24));
        } else {
            $token = md5(uniqid((string) mt_rand(), true)) . md5(uniqid((string) mt_rand(), true));
        }

        $CI->db->insert('whatsapp_credential_tokens', array(
            'token'        => $token,
            'user_id'      => $user_id,
            'role'         => $role,
            'student_id'   => $student_id,
            'purpose'      => 'setup',
            'created_at'   => date('Y-m-d H:i:s'),
            'expires_at'   => date('Y-m-d H:i:s', strtotime('+48 hours')),
            'access_count' => 0,
        ));

        return site_url('credentials/setup/' . $token);
    }
}
