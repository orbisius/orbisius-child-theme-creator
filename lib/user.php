<?php

class orbisius_child_theme_creator_user extends orbisius_child_theme_creator_singleton {
    private $api_meta_key = 'octc_api_key';
    
    /**
     * 
     * @param str/opt $key
     * @return str
     */
    public function api_key($key = '') {
        $user_id = wp_get_current_user_id();
        
        if (!empty($key)) {
            $api_key = update_user_meta($user_id, $this->api_meta_key, $key);
        }

        $api_key = get_user_meta($user_id, $this->api_meta_key, true);

        return $api_key;
    }
}
