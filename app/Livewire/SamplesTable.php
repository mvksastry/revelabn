<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Elab\Exptsample;

class SamplesTable extends DataTableComponent
{
    protected $model = Exptsample::class;

    public function configure(): void
    {
        $this->setPrimaryKey('exptsample_id');
    }

    public function columns(): array
    {
        return [
            Column::make('Actions')
            ->label(function ($row, Column $column) {
                //  $delete = '<button class="btn btn-warning p-2 rounded m-1" wire:click="delete(' . $row->id . ')">Trash</button>';
                    $edit = '<button class="btn btn-info p-1 rounded m-1" wire:click="selectedSampleId(' .$row->exptsample_id. ')">Select</button>';
                    return $edit;
                }
            )->html(),
            Column::make("Exptsample id", "exptsample_id")
                ->sortable(),
            Column::make("Exptsample id", "exptsample_id")
                ->sortable(),
            Column::make("Sample code", "sample_code")
                ->sortable(),
            Column::make("Description", "description")
                ->sortable(),
            Column::make("Type", "type")
                ->sortable(),
            Column::make("Species", "species")
                ->sortable(),
            Column::make("User code", "user_code")
                ->sortable(),
            Column::make("Bulk code", "bulk_code")
                ->sortable(),
            Column::make("Series code", "series_code")
                ->sortable(),
            Column::make("Source", "source")
                ->sortable(),
            Column::make("Source ref", "source_ref")
                ->sortable(),
            Column::make("Posted by", "posted_by")
                ->sortable(),
            Column::make("Posted name", "posted_name")
                ->sortable(),
            Column::make("Posted date", "posted_date")
                ->sortable(),
            Column::make("Sample remark", "sample_remark")
                ->sortable(),
            Column::make("Tags", "tags")
                ->sortable(),
            Column::make("Repository id", "repository_id")
                ->sortable(),
            Column::make("Compartment id", "compartment_id")
                ->sortable(),
            Column::make("Holder id", "holder_id")
                ->sortable(),
            Column::make("Box id", "box_id")
                ->sortable(),
            Column::make("IsCurated", "isCurated")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
