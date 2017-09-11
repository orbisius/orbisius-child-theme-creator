<?php

/**
 * Allows sub classes to have a convenient get_instance method.
 */
class orbisius_child_theme_creator_singleton {

    /**
     * Singleton pattern i.e. we have only one instance of this obj
     *
     * @staticvar type $instance
     * @return \cls
     */
    public static function get_instance() {
        static $instance = null;

        // This will make the calling class to be instantiated.
        // no need each sub class to define this method.
        if (is_null($instance)) {
            // We do a late static binding. i.e. the instance is the subclass of this one.
            $instance = new static(); // leave only this line and not the hack.
        }

        return $instance;
    }
}
