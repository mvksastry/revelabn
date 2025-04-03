<?php

namespace App\Livewire\Elab\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Elab\Labfile;

class LabfilesTable extends DataTableComponent
{
    protected $model = Labfile::class;

    public function configure(): void
    {
        $this->setPrimaryKey('labfile_id');
    }

    public function columns(): array
    {
        return [
            Column::make('Actions')
            ->label(
                function ($row, Column $column) {
                //  $delete = '<button class="btn btn-warning p-2 rounded m-1" wire:click="delete(' . $row->id . ')">Trash</button>';
                    $edit = '<button class="btn btn-info p-1 rounded m-1" wire:click="selectedFileId(' . $row->labfile_id . ')">Select</button>';
                    return $edit;
                }
            )->html(),
            Column::make("Labfile id", "labfile_id")
                ->sortable(),
            Column::make("Uuid", "uuid")
                ->sortable(),
            Column::make("Category", "category")
                ->sortable(),
            Column::make("Sub category", "sub_category")
                ->sortable(),
            Column::make("Resproject id", "resproject_id")
                ->sortable(),
            Column::make("Iaecproject id", "iaecproject_id")
                ->sortable(),
            Column::make("Experiment id", "experiment_id")
                ->sortable(),
            Column::make("Notebook id", "notebook_id")
                ->sortable(),
            Column::make("File type", "file_type")
                ->sortable(),
            Column::make("File name", "file_name")
                ->sortable(),
            Column::make("User id", "user_id")
                ->sortable(),
            Column::make("User name", "user_name")
                ->sortable(),
            Column::make("Date submitted", "date_submitted")
                ->sortable(),
            Column::make("File path", "file_path")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
