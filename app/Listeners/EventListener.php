<?php
/**
 * Created by IntelliJ IDEA.
 * User: LHC
 * Date: 2020/9/18
 * Time: 17:23
 */

namespace App\Listeners;


use App\Events\ExampleEvent;

class EventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ExampleEvent  $event
     * @return void
     */
    public function handle(ExampleEvent $event)
    {
        var_dump($event);
        //
    }
}