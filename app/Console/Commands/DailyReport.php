<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class DailyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Respectively send an exclusive report to everyone daily via email.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
         
        $users = User::where('companyName', 'CyberTip Nigeria Limited')->get();
        foreach ($users as $user) {
            Mail::raw("This is an automatically generated Daily Report", function ($mail) use ($user) {
                $mail->from('dammy4did@gmail.com');
                $mail->to($user->email)
                    ->subject('CyberTip Daily Report');
            });
        }
         
        $this->info('Successfully sent daily report to everyone.');
    }
    
}
