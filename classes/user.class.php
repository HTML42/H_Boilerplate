<?php

class User {

    public $id;
    public $username;
    public $email;
    public $email_validated = null;
    public $hash = null;
    public static $INSTANCE_CACHE = array();
    public $CACHE = array('groups' => null);

    public function __construct($userid = 0) {
        if (!is_numeric($userid)) {
            $userid = 0;
        }
        if ($userid > 0) {
            $user_data = Xjsondb::select_first('users', $userid);
        } else {
            $user_data = array();
        }
        $this->fill_data($user_data);
    }

    public function fill_data($data = array()) {
        $data = (array) $data;
        $this->id = (isset($data['id']) && is_numeric($data['id']) ? intval($data['id']) : 0);
        $this->username = (isset($data['username']) && strval($data['username']) ? $data['username'] : 'Unknown');
        $this->email = (isset($data['email']) && strval($data['email']) ? $data['email'] : 'no@email.com');
        $this->email_validated = (isset($data['email_validated']) && boolval($data['email_validated']) ? $data['email_validated'] : false);
        $this->hash = (isset($data['hash']) && strval($data['hash']) ? $data['hash'] : strtoupper(md5($this->id . '||' . $this->email)));
    }

    public static function load($userid) {
        if (is_numeric($userid)) {
            if (!isset(self::$INSTANCE_CACHE[$userid])) {
                self::$INSTANCE_CACHE[$userid] = new self($userid);
            }
            return self::$INSTANCE_CACHE[$userid];
        } else {
            return new self();
        }
    }

    public function output() {
        $output = array(
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'email_validated' => $this->email_validated,
        );
        return $output;
    }

    public function email_confirmation() {
        $email_response = Emails::create('confirmation', $this->email, $this);
        return $email_response;
    }

    public static function get_id_by_username($username) {
        $userid = 0;
        $user_match = Xjsondb::select_first('users', array('username' => $username));
        if ($user_match && is_array($user_match) && !empty($user_match) && isset($user_match['id']) && $user_match['id'] > 0) {
            $userid = $user_match['id'];
        } else {
            foreach (Xjsondb::select('users') as $user) {
                if (strtolower($user['username']) == strtolower($username)) {
                    $userid = $user['id'];
                    break;
                }
            }
        }
        return $userid;
    }

    public static function get_by_username($username) {
        return self::load(self::get_id_by_username($username));
    }

    public function is_me() {
        global $Xme;
        return $this->id == $Xme->id;
    }

    public function groups($check = null) {
        if (is_string($check) || is_numeric($check)) {
            foreach ($this->groups() as $group) {
                if ($group['name'] == $check || $group['id'] == $check) {
                    return true;
                }
            }
            return false;
        } else {
            if (is_array($this->CACHE['groups'])) {
                return $this->CACHE['groups'];
            }
            $groups = Xjsondb::select('user_groups', array('user_id' => $this->id));
            return $this->CACHE['groups'] = $groups;
        }
    }

    public static function find_id_in_object($object) {
        if (is_numeric($object)) {
            return intval($object);
        } else if (is_array($object)) {
            if (isset($object['id'])) {
                return intval($object['id']);
            } else if (isset($object[0])) {
                return self::find_id_in_object($object[0]);
            } else if (isset($object[1])) {
                return self::find_id_in_object($object[1]);
            }
        }
        return null;
    }

}
