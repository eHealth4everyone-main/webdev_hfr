<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class sendDeleteFacilityEmailtoDhisTeam extends Notification
{
    use Queueable;

 
    public function __construct()
    {
        //
    }

   
    public function via($notifiable)
    {
        return ['mail'];
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Facility Deleted')
            ->greeting('Hello,')
            ->line('Facility ('. $this->name .') have been deleted in HFR. The facility is located in '.$this->state. ' state, '.$this->lga. ' LGA, and '.$this->ward. ' ward.')
            ->line('Please visit DHIS2 exchange logs in HFR for more details.')
            ->line('Kindly take appropriate actions at your end!');
    }

 
}
