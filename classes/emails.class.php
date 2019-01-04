<?php

//Email-Class
class Emails {

    const EMAIL_TITLE = 'Manager42';
    const APP_NAME = 'Manager42';
    const SENDER = 'noreply@manager42.de';

    public static $BASEURL = BASEURL;
    public static $data = array();
    public static $config = array(
        'confirmation' => null
    );

    /**
     * 
     * @param string $type | confirmation
     * @param array $data
     */
    public static function create($type = 'confirmation', $data = array()) {
        global $Xme;
        if (isset(Emails::$config[$type])) {
            $url_request = base64_encode(json_encode(array(
                'id' => $data->id,
                'hash' => $data->hash
            )));
            Emails::$data = (array) $data + array(
                'confirm_url' => Emails::$BASEURL . Emails::$config[$type]['confirm_page'] . '?request=' . $url_request,
            );
            $File_email_content = File::instance(Emails::$config[$type]['content_file']);
            if ($File_email_content->exists) {
                Emails::$config[$type]['content'] = trim($File_email_content->get_content());
            }
            Emails::$data = null;
            //
            if (is_string(Emails::$config[$type]['content']) && !empty(Emails::$config[$type]['content'])) {
                $Email = new Email();
                $Email->from = $Email->reply = Emails::SENDER;
                $Email->subject = Emails::$config[$type]['subject'];
                $Email->content(Emails::$config[$type]['content'])
                        ->to($data->email)
                        ->type('html')
                        ->send();
            }
        }
    }

}

//Emails-Configurations
Emails::$config['confirmation'] = array(
    'subject' => 'Bestätigungs-Email - ' . Emails::APP_NAME,
    'content_file' => PROJECT_ROOT . 'emails/confirmation.php',
    'content' => null,
    'sender' => Emails::SENDER,
    'confirm_page' => 'email_confirmation.html',
);


//Correct BASEURL
if (strstr(Emails::$BASEURL, 'plugins/login/')) {
    Emails::$BASEURL = @reset(explode('plugins/login/', Emails::$BASEURL));
}
