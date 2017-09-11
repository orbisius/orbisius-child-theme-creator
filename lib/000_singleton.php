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
            // Some users are still using php 5.2 and new static() fails
            // So I have to turn it off for now for a few months until all upgrade to php 5.6 or 7+
            // Code doesn't reach to the version check because php's parser doesn't recognize the command
            // and fails and doesn't give php version check to take place.
            if (0&&version_compare(phpversion(), '5.3', '>=')) {
                //$instance = new static(); // leave only this line and not the hack.
            } else { // less than 5.2
                // Marius Balčytis from https://stackoverflow.com/questions/5197300/new-self-vs-new-static
                $class = get_class($this);
                $instance = new $class();
            }
        }

        return $instance;
    }
}
