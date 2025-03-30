<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Elab\Reagents;

class ReagentsTable extends DataTableComponent
{
    protected $model = Reagents::class;

    public function configure(): void
    {
        $this->setPrimaryKey('reagent_id');
    }

    public function columns(): array
    {
        return [
            Column::make('Actions')
            ->label(function ($row, Column $column) {
                //  $delete = '<button class="btn btn-warning p-2 rounded m-1" wire:click="delete(' . $row->id . ')">Trash</button>';
                    $edit = '<button class="btn btn-info p-1 rounded m-1" wire:click="selectedReagendId(' . $row->reagent_id . ')">Select</button>';
                    return $edit;
                }
            )->html(),
            Column::make("Reagent id", "reagent_id")
                ->sortable(),
            Column::make("Name", "name")
                ->sortable(),
            Column::make("Description", "description")
                ->sortable(),
            Column::make("Nick name", "nick_name")
                ->sortable(),
            Column::make("Madeby id", "madeby_id")
                ->sortable(),
            Column::make("Date made", "date_made")
                ->sortable(),
            Column::make("Reagent code", "reagent_code")
                ->sortable(),
            Column::make("Ingradients", "ingradients")
                ->sortable(),
            Column::make("Quantity made", "quantity_made")
                ->sortable(),
            Column::make("Unit id", "unit_id")
                ->sortable(),
            Column::make("Quantity left", "quantity_left")
                ->sortable(),
            Column::make("Expiry date", "expiry_date")
                ->sortable(),
            Column::make("Storage container id", "storage_container_id")
                ->sortable(),
            Column::make("Shelf rack id", "shelf_rack_id")
                ->sortable(),
            Column::make("Box sack id", "box_sack_id")
                ->sortable(),
            Column::make("Location code", "location_code")
                ->sortable(),
            Column::make("Open restricted", "open_restricted")
                ->sortable(),
            Column::make("Notes", "notes")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
