<?php

namespace App\Events;

class ExampleEvent extends Event
{
    public $data;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
        //
    }
}
