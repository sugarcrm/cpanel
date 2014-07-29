<?php  namespace Stevemo\Cpanel\Events; 

use App;

/**
 * inspired by Laracasts DispatchableTrait
 * Class EventableTrait
 * @package Stevemo\Cpanel\Events
 */
trait EventableTrait {

    /**
     * Dispatch the event
     *
     * @param  $event
     * @return mixed
     */
    public function dispatchEvent($event)
    {
        $this->getDispatcher()->dispatch($event);
    }

    /**
     * Get the event dispatcher.
     *
     * @return \Stevemo\Cpanel\Events\EventDispatcher
     */
    public function getDispatcher()
    {
        return App::make('Stevemo\Cpanel\Events\EventDispatcher');
    }

} 