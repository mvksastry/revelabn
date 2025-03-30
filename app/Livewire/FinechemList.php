<?php

namespace App\Livewire;

//use Livewire\Component;
use App\Models\Elab\Products;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class FinechemList extends DataTableComponent
{
    protected $model = Products::class;

    public function configure(): void
    {
        $this->setPrimaryKey('product_id');
    }

    public function columns(): array
    {
        return [
            Column::make('PMC', 'pack_mark_code')
                ->sortable(),
            Column::make('Name / Nick name', 'name')
                ->sortable(),
            Column::make('Date Entered', 'date_entered')
                ->sortable(),
        ];
    }
}
