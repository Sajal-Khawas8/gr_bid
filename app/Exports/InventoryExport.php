<?php

namespace App\Exports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InventoryExport implements FromCollection, WithHeadings
{

    public $data;

    public function __construct($data){
        $this->data = $data;
    }

    public function headings(): array
    {
        return ["id", "name", "description", "category", "condition", "old_months", "starting_bid", "location", "added_by", "deleted_at", "created_at", "updated_at"];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->data;
    }
}
