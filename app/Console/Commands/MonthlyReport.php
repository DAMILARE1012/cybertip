<?php

namespace App\Console\Commands;

use App\Report;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class MonthlyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Respectively send an exclusive report to everyone monthly via email.';

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
        $message = "This is an automatically generated monthly report. Kindly take note of the following information";
         
        $usersReport = Report::where('frequency', 'monthly')->get();
        foreach ($usersReport as $user) {
            Mail::raw($message, function ($mail) use ($user) {
                $mail->from('dammy4did@gmail.com');
                $mail->to($user->email)
                    ->subject('CyberTip Monthly Report');
            });
        }
        $this->info('Successfully sent monthly report to everyone.');
    }
}
