<?php

class orbisius_child_theme_creator_user {
    private $api_meta_key = '_orb_ctc_cloud_api_key';
    private $meta_cloud_plan = '_orb_ctc_cloud_plan';
    private $meta_cloud_email = '_orb_ctc_cloud_email';

    /**
     * Singleton pattern i.e. we have only one instance of this obj
     *
     * @staticvar type $instance
     * @return static
     */
    public static function get_instance() {
        static $instance = null;

        // This will make the calling class to be instantiated.
        // no need each sub class to define this method.
        if (is_null($instance)) {
            // We do a late static binding. i.e. the instance is the subclass of this one.
            $instance = new self(); // leave only this line and not the hack.
        }

        return $instance;
    }
    
    /**
     * 
     * @param string $key
     * @return mixed
     */
    public function api_key($key = null) {
        static $val = null;

        if (!is_null($val) && is_null($key)) { // get
            return $val;
        }
        
        $user_id = $this->get_user_id();
        
        if (!empty($key)) {
            $up_status = update_user_meta($user_id, $this->api_meta_key, $key);
            $val = get_user_meta($user_id, $this->api_meta_key, true);
        } elseif (!is_null($key)) { // empty string so delete
            delete_user_meta($user_id, $this->api_meta_key);
            $val = null;
        } else {
            $val = get_user_meta($user_id, $this->api_meta_key, true);
        }

        return $val;
    }
    
    /**
     * 
     * @param mixed $data
     * @return mixed
     */
    public function plan($data = null) {
        static $val = null;
        
        if (!is_null($val) && is_null($data)) { // get
            return $val;
        }
        
        $user_id = $this->get_user_id();
        
        if (!empty($data)) {
            $up_status = update_user_meta($user_id, $this->meta_cloud_plan, $data);
            $val = get_user_meta($user_id, $this->meta_cloud_plan, true);
        } elseif (!is_null($data)) { // empty string so delete
            delete_user_meta($user_id, $this->meta_cloud_plan);
            $val = null;
        } else {
            $val = get_user_meta($user_id, $this->meta_cloud_plan, true);
        }

        return $val;
    }
    
    /**
     * 
     * @param string $key
     * @return string
     */
    public function email($key = null) {
        static $val = null;
        
        if (!is_null($val) && is_null($key)) { // get
            return $val;
        }
        
        $user_id = $this->get_user_id();
        
        if (!empty($key)) {
            $up_status = update_user_meta($user_id, $this->meta_cloud_email, $key);
            $val = get_user_meta($user_id, $this->meta_cloud_email, true);
        } elseif (!is_null($key)) { // empty string so delete
            delete_user_meta($user_id, $this->meta_cloud_email);
            $val = null;
        } else {
            $val = get_user_meta($user_id, $this->meta_cloud_email, true);
        }

        return $val;
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

    /**
     * Clears some plan related info so it's fresh for next time.
     */
    public function clear_account_data() {
        $this->plan('');
        $this->email('');
        $this->api_key('');
    }

    /**
     * Checks if user has sufficient permissions to manage child themes
     * Requires either edit_themes or install_themes capability
     *
     * @param int|string|WP_User $user
     * @return bool
     */
    public function has_access($user = null)
    {
        if (empty($user)) {
            $user = wp_get_current_user();
        } elseif (is_numeric($user)) {
            $user = get_user_by('id', $user);
        } elseif (is_string($user)) {
            if (strpos($user, '@') !== false) {
                $user = get_user_by('email', $user);
            } else {
                $user = get_user_by('login', $user);
            }
        }

        if (empty($user)) {
            return false;
        }

        // Allow filtering of required capabilities
        $required_caps = apply_filters('orbisius_child_theme_creator_filter_required_caps', [
            'edit_themes',
            'install_themes',
        ]);

        foreach ($required_caps as $cap) {
            if (user_can($user, $cap)) {
                return true;
            }
        }

        return false;
    }

}
