<?php

namespace App\Jobs;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    private $id, $body, $phone, $date_at, $time_at;
    public function __construct($id, $body, $phone, $date_at, $time_at)
    {
        $this->id = $id;
        $this->body = $body;
        $this->phone = $phone;
        $this->date_at = $date_at;
        $this->time_at = $time_at;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $redis = Redis::connection();
        $list = [];
        if ($redis->get('list'))
            $list = json_decode($redis->get('list'), true);

        $arr = [
            'api_key' => '1584.66CBFA022A3618B699303AB9D82861E2',
            'sender_id' => '1',
            'send_type' => '2',
            'sms_content' => $this->body,
            'numbers' => $this->phone,
            'send_time' => date('Y-m-d H:i:s', strtotime($this->date_at . ' ' . $this->time_at)),
            'unique' => '1'
        ];
        $appointment = Appointment::findOrFail($this->id);

        $request = Http::get('https://kuwait.uigtc.com/capi/sms/send_sms?' . http_build_query($arr));

        $result = $request->json();
        if (isset($result['error']))
            $appointment->status = 'FAILED';
        else
            $appointment->status = 'COMPLETED';
        $appointment->save();
        $status = $appointment->status;
        
        $list[] = [
            'app_id' => $this->id,
            'status' => $status
        ];

        $redis->set(
            'list',
            json_encode($list)
        );

        return true;
    }
}
