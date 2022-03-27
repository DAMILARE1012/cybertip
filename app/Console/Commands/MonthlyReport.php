<?php

namespace App\Console\Commands;

use App\Report;
use App\ThreatIntel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use PDF;

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
        $threatIntels = ThreatIntel::where('source', 'Twitter')->get();
         
        $users = Report::where('frequency', 'monthly')->get();
        foreach ($users as $user) {
            $monthly_report = PDF::loadView('reports.daily_report', ['threatIntels' => $threatIntels]);
                $pdf = $monthly_report->output();
                $data = [
                    'details' => 'This email is to notify you of the threat intel related to your company. Kindly take note of the following information',
                    'manager_name' => "User"
                ];
            Mail::send('reports.email_body', $data, function ($message) use ($user, $pdf) {
                $message->from('dammy4did@gmail.com', 'CyberTip Admin Office');
                $message->to($user->email);
                $message->subject('CyberTip Monthly Report');
                $message->attachData($pdf, 'cybertip_monthly_report.pdf', [
                    'mime' => 'application/pdf',
                ]);
            });
            
        }
        $this->info('Successfully sent monthly report to everyone.');
    }
}
