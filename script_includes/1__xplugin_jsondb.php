<?php

include PROJECT_ROOT . 'plugins/jsondb/kickstart.php';

Xjsondb::$config_tables = array(
    'users' => array(
        'username' => '',
        'password' => '',
        'hash' => function($data) {
            $email = (isset($data['email']) ? $data['email'] : 'no-email');
            return strtoupper(md5($data['id'] . '||' . $email));
        },
        'email' => '',
        'email_validated' => null,
    ),
    'user_groups' => array('user_id' => '', 'name' => ''),
);
Xjsondb::$config_connections = array(
    'users' => array(
        'groups' => array('id' => array('user_groups', 'user_id')),
    ),
);

Xjsondb::startup();

