<?php

namespace App\Utilities\Event;

interface Job
{
    /**
     * Handle the job.
     *
     * @return mixed
     */
    public function handle();
}