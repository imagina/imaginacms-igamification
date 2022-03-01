<?php

namespace Modules\Igamification\Events;

class ActivityIsIncompleted
{
    
    public $params;
    public $systemNameActivity;

    public function __construct($systemNameActivity,$params = null)
    {
        $this->systemNameActivity = $systemNameActivity;
        $this->params = $params;
    }

}