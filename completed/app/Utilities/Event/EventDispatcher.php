<?php

namespace App\Utilities\Event;

class EventDispatcher
{
    /**
     * Dispatch job(s).
     *
     * @param Job|array $events
     * @return mixed
     */
    public function dispatch($events)
    {
        if (is_array($events)) {
            return $this->multipleEvents($events);
        }

        return $this->singleEvent($events);
    }

    /**
     * Handle multiple jobs.
     *
     * @param array $events
     * @return bool
     */
    private function multipleEvents(array $events)
    {
        return array_walk($events, [$this, 'singleEvent']);
    }

    /**
     * Handle single job.
     *
     * @param Job $job
     * @return mixed
     */
    private function singleEvent(Job $job)
    {
        return $job->handle();
    }
}