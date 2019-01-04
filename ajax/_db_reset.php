<?php

include '_ajax_kickstart.php';

Utilities::rm_dir(PROJECT_ROOT . '_xjsondb');
Xjsondb::initiate();

usleep(1000);

//
$user_id = Xjsondb::insert('users', array(
            'username' => "testuser",
            'password' => Xlogin::password(1234),
            'email' => 'dev-testuser_boilerplate@power-of-m.de',
            'email_validated' => true,
        ));
usleep(1000);
Xjsondb::insert('user_groups', array(
    'user_id' => $user_id,
    'name' => 'active',
));
usleep(1000);
