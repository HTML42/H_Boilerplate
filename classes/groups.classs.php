<?php

class Groups {

    const AVAILABLE = array('active', 'admin');
    const NAMES = array(
        'active' => 'Aktiv',
        'admin' => 'Administrator',
    );

    public static function name($group) {
        if (is_string($group)) {
            $group = array('name' => $group);
        }
        if (!is_array($group)) {
            $group = array();
        }
        if (!isset($group['name'])) {
            $group['name'] = 'Unknown';
        }
        $name = strtolower($group['name']);
        //
        if (isset(Groups::NAMES[$name])) {
            return Groups::NAMES[$name];
        } else {
            return ucfirst($name);
        }
    }

}
