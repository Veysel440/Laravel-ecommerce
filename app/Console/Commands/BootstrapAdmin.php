<?php

namespace App\Console\Commands;


use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class BootstrapAdmin extends Command
{
    protected $signature = 'app:bootstrap-admin
        {--email= : Admin e-posta}
        {--password= : Admin şifresi}
        {--name=Admin : İsim}
        {--verify : E-postayı doğrulanmış yap}';

    protected $description = 'İlk admin kullanıcı ve roller/izinler için bootstrap';

    public function handle(): int
    {
        $this->callSilent('db:seed', ['--class'=>'Database\\Seeders\\RolesAndPermissionsSeeder']);

        $email = $this->option('email') ?: env('ADMIN_EMAIL','admin@example.com');
        $pass  = $this->option('password') ?: env('ADMIN_PASSWORD', Str::random(16));
        $name  = $this->option('name') ?: 'Admin';

        $user = User::firstOrCreate(['email'=>$email], ['name'=>$name,'password'=>bcrypt($pass)]);
        if ($this->option('verify')) $user->forceFill(['email_verified_at'=>now()])->save();

        $user->syncRoles(['admin']);

        $this->info("Admin hazır: {$user->email}");
        $this->info("Şifre: {$pass}");
        return self::SUCCESS;
    }
}
