<?php

class orbisius_child_theme_creator_user extends orbisius_child_theme_creator_singleton {
    private $api_meta_key = '_orb_ctc_cloud_api_key';
    private $meta_cloud_email = '_orb_ctc_cloud_email';

    /**
     * 
     * @param str/opt $key
     * @return str
     */
    public function api_key($key = null) {
        static $api_key = null;
        
        if (!is_null($api_key) && is_null($key)) { // get
            return $api_key;
        }
        
        $user_id = $this->get_user_id();
        
        if (!empty($key)) {
            $up_status = update_user_meta($user_id, $this->api_meta_key, $key);
            $api_key = get_user_meta($user_id, $this->api_meta_key, true);
        } elseif (!is_null($key)) { // empty string so delete
            delete_user_meta($user_id, $this->api_meta_key);
            $api_key = null;
        } else {
            $api_key = get_user_meta($user_id, $this->api_meta_key, true);
        }

        return $api_key;
    }
    
    /**
     * 
     * @param str/opt $key
     * @return str
     */
    public function email($key = null) {
        static $api_key = null;
        
        if (!is_null($api_key) && is_null($key)) { // get
            return $api_key;
        }
        
        $user_id = $this->get_user_id();
        
        if (!empty($key)) {
            $up_status = update_user_meta($user_id, $this->meta_cloud_email, $key);
            $api_key = get_user_meta($user_id, $this->meta_cloud_email, true);
        } elseif (!is_null($key)) { // empty string so delete
            delete_user_meta($user_id, $this->meta_cloud_email);
            $api_key = null;
        } else {
            $api_key = get_user_meta($user_id, $this->meta_cloud_email, true);
        }

        return $api_key;
    }
    
    /**
     * 
     * @param str/opt $key
     * @return str
     */
    public function get_user_id() {
        $user_id = get_current_user_id();
        return $user_id;
    }
}
