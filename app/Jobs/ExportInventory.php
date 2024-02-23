<?php

namespace App\Jobs;

use App\Exports\InventoryExport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ExportInventory implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries=3;
    private $inventory, $name;
    /**
     * Create a new job instance.
     */
    public function __construct($inventory, $name)
    {
        $this->inventory = $inventory;
        $this->name = $name;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Excel::download(new InventoryExport($this->inventory), "items-in-" . $this->name .".xlsx");
        return;
    }
}
