<?php  namespace Stevemo\Cpanel\Events;

use Illuminate\Events\Dispatcher;
use Illuminate\Log\Writer;

/**
 * inspired by Laracasts EventDispatcher
 * Class EventableTrait
 * @package Stevemo\Cpanel\Events
 */
class EventDispatcher {

    /**
     * @var Dispatcher
     */
    protected $event;

    /**
     * @var Writer
     */
    protected $log;

    /**
     * @param Dispatcher $event
     * @param Writer $log
     */
    function __construct(Dispatcher $event, Writer $log)
    {
        $this->event = $event;
        $this->log = $log;
    }


    /**
     * Dispatch the event
     *
     * @param $event
     */
    public function dispatch($event)
    {
        $eventName = $this->getEventName($event);

        $this->event->fire($eventName, $event);

        $this->log->info("{$eventName} was fired.");

    }

    /**
     * Grab the fired event name
     *
     * @param $event
     * @return mixed
     */
    protected function getEventName($event)
    {
        return str_replace('\\', '.', get_class($event));
    }

}