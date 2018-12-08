<?php
/**
 * Created by PhpStorm.
 * User: gordo
 * Date: 08.12.18
 * Time: 23:16
 */

namespace App\Support\Traits;


use App\Activity;

trait RecordsActivity
{

    protected static function bootRecordsActivity()
    {
        foreach (static::getActivitiesToRecord() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }
    }

    /**
     * @return array
     */
    protected static function getActivitiesToRecord(): array
    {
        return ['created'];
    }

    /**
     * @param string $event
     * @return string
     * @throws \ReflectionException
     */
    protected function getActivityType(string $event): string
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());
        return "{$event}_{$type}";
    }

    protected function recordActivity(string $event)
    {
        $this->activity()->create([
            'user_id' => $this->user_id,
            'type'    => $this->getActivityType($event),
        ]);
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}
