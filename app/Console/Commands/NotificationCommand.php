<?php

namespace App\Console\Commands;

use App\Jobs\SendSmsJob;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Console\Command;

class NotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notification Cron Job';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $next = Carbon::now()->addHour()->format('H');
        $appointments = Appointment::whereDate('date_at', Carbon::now())
            ->whereBetween('time_at', [$next . ':00', $next . ':59'])
            ->where('status', 'PENDING')
            ->get();

        $appointments->map(function ($appointment) {
            SendSmsJob::dispatch($appointment->id, $appointment->body, $appointment->phone, $appointment->date_at, $appointment->time_at);
        });
    }
}
