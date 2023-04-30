<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

class ReportUnit extends Notification
{
    use Queueable, Notifiable;

    public $unit_id;
    public $auther_id;
    protected $reported_user;
    public function __construct($unit_id, $auther_id, $reported_user)
    {
        $this->unit_id = $unit_id;
        $this->auther_id = $auther_id;
        $this->reported_user = $reported_user;
    }
    public function via( $notifiable): array
    {
        return ['database'];
    }
    public function toArray(object $notifiable): array
    {
        return [
            'unit_id' => $this->unit_id,
            'auther_id' => $this->auther_id,
            'reported_user' => $this->reported_user,
        ];
    }


}
