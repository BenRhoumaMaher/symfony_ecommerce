<?php

/**
 * SendWeeklyProductEmailSchedule
 *
 * Provides the schedule for sending weekly product emails.
 *
 * @category Scheduler
 * @package  App\Scheduler
 * @author   Maher Ben Rhouma <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/scheduler.html
 */

namespace App\Scheduler;

use App\Message\SendWeeklyProductEmailMessage;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;
use Symfony\Contracts\Cache\CacheInterface;

/**
 * SendWeeklyProductEmailSchedule
 *
 * Provides the schedule for sending weekly product emails.
 *
 * @category Scheduler
 * @package  App\Scheduler
 * @author   Maher Ben Rhouma <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/scheduler.html
 */

#[AsSchedule('mailscheduler')]
final class SendWeeklyProductEmailSchedule implements ScheduleProviderInterface
{
    /**
     * Constructor
     *
     * @param CacheInterface $cache The cache service used to store
     *                              the state of the schedule.
     */
    public function __construct(
        private CacheInterface $cache,
    ) {
    }

    /**
     * Returns the schedule for sending weekly product emails.
     *
     * This method configures the scheduling of the
     * `SendWeeklyProductEmailMessage` message to be sent every 1 week.
     *
     * @return Schedule The configured schedule for the message.
     */
    public function getSchedule(): Schedule
    {
        return (new Schedule())
            ->add(
                RecurringMessage::every(
                    '1 week',
                    new SendWeeklyProductEmailMessage()
                ),
            )
            ->stateful(
                $this->cache
            );
    }
}
