<?php

namespace Opnuc\OpnucOrktrack\Events;

class OrktrackDownloadEvent {

    protected $record;

    function __construct($record)
    {
        $this->record = $record;
    }

}