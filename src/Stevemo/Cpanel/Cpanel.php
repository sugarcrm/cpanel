<?php  namespace Stevemo\Cpanel;

use Illuminate\Support\Facades\Facade;

class Cpanel extends Facade {

    /**
     * Get the binding in the IoC container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'cpanel';
    }
}