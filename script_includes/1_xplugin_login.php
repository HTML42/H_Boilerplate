<?php

include PROJECT_ROOT . 'plugins/login/kickstart.php';

Xlogin::$config['db']['system'] = 'xjsondb';

#Start Database
$XLDB = new Xlogin_DB();

#Create Current User
$GLOBALS['me'] = $me = User::load(X_LOGIN_ID);

Xlogin::$config['signup']['callback'] = function($userid) {
    $User = User::load($userid);
    @Emails::create('confirmation', $User);
};
Xlogin::$config['confirmation']['callback'] = function($userid) {
    $group_active = Xjsondb::select('user_groups', array(
                'user_id' => $userid,
                'name' => 'active'
    ));
    if (empty($group_active)) {
        Xjsondb::insert('user_groups', array(
            'user_id' => $userid,
            'name' => 'active',
        ));
    }
};
//##Texts
Xlogin::$config['confirmation']['response_success'] = 'E-Mail erfolgreich bestätigt.';
Xlogin::$config['confirmation']['response_error'] = 'E-Mail-Bestätigung fehlgeschlagen.';
Xlogin::$config['confirmation']['redirect_text'] = 'Sie werden weitergeleitet in 5 Sekunden...';
//##CSS-Classes
#Xlogin::$config['login']['form_css_class'] = 'standard_form';
#Xlogin::$config['signup']['form_css_class'] = 'standard_form';

function admincheck() {
    if (!$GLOBALS['me']->groups('admin')) {
        Utilities::redirect('../en/index.html');
    }
}

function login_check_for_pages() {
    if (!X_LOGIN || X_LOGIN_ID <= 0) {
        Utilities::redirect('index.html');
    }
}
