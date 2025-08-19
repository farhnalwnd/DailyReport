<?php

namespace App\Jobs;

use App\Exports\ReportExport;
use App\Mail\DailyReportMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class DailyReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $user;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data, User $user)
    {
        $this->data = $data;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //nama file dan path penyimpanan
        $fileName = 'inventory_stock_report_' . now()->format('Y-m-d') . '.xlsx';
        $filePath = 'exports/' . $fileName;

        //Buat dan simpan file Excel
        Excel::store(new ReportExport($this->data), $filePath, 'local');

        Mail::to($this->user->email)->send(new DailyReportMail($filePath, $this->user));

        //Hapus file setelah dikirim
        Storage::disk('local')->delete($filePath);
    }
}
