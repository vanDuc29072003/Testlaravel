<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class eventYeuCauSuaChua implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;
    public function __construct($TenNhanVien)
    {
        $this->message = "{$TenNhanVien} đã tạo 1 yêu cầu sửa chữa";
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-quanly'),
        ];
    }
    public function broadcastWith() {
        return [
            'message' => $this->message
        ];
    }
    public function broadcastAs(){
        return 'eventYeuCauSuaChua';
    }
}
