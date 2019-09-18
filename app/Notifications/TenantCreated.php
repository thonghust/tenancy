<?php
namespace App\Notifications;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Password;
class TenantCreated extends Notification
{
    private $hostname;
    private $password;
    public function __construct($hostname, $password)
    {
        $this->hostname = $hostname;
        $this->password = $password;
    }
    public function via()
    {
        return ['mail'];
    }
    public function toMail($notifiable)
    {
        $token = Password::broker()->createToken($notifiable);
        $resetUrl = "http://{$this->hostname->fqdn}/password/reset/{$token}";
        $app = config('app.name');
        return (new MailMessage())
            ->subject("{$app} Xác nhận đổi mật khẩu")
            ->greeting("Xin chào, bạn vừa mới đăng ký với tên miền {$notifiable->name}.tenancy.com,")
            ->line("Chúc mừng bạn đã đăng ký sử dụng thành công {$app}!")
            ->line("Mật khẩu hệ thống cấp quyền truy cập cho trang web là {$this->password}")
            ->line('Bạn có thể đổi lại mật khẩu này bất cứ khi nào.')
            ->action('Reset lại mật khẩu', $resetUrl);
    }
}