<?php

namespace App\Extensions;

class Singleton
{
    /**
     * Returns the *Singleton* instance of this class.
     * You can send parameters to the constructor only the first time the instance is created.
     *
     * @return Singleton The *Singleton* instance.
     */
    public static function getInstance()
    {
        static $oInstance = null;
        if (null === $oInstance) {
            if (func_num_args() === 0) {
                $oInstance = new static();
            } else {
                $oReflection = new ReflectionClass(get_called_class());
                $fnConstructor = $oReflection->getConstructor();

                // Thanks PHP 5.4
                $oInstance = $oReflection->newInstanceWithoutConstructor();

                // The magic.
                $fnConstructor->setAccessible(true);
                $fnConstructor->invokeArgs($oInstance, func_get_args());
            }
        }

        return $oInstance;
    }

    /**
     * Returns the *Singleton* instance of this class.
     *
     * @return Singleton The *Singleton* instance.
     */
    public static function i()
    {
        if (func_num_args() === 0) {
            return static::getInstance();
        } else {
            return forward_static_call_array(['static', 'getInstance'], func_get_args());
        }
    }

    /**
     * Protected constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     */
    protected function __construct()
    {
    }

    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Private unserialize method to prevent unserializing of the *Singleton*
     * instance.
     *
     * @return void
     */
    private function __wakeup()
    {
    }
}