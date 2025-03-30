<?php

namespace App\Imports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Elab\Exptsample;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

//live import from excel
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;

//Traits
use App\Traits\Base;

class ExptsamplesImport implements ToCollection, WithHeadingRow
{
    use Base;

    public function collection(Collection $rows)
    {
        /*
        Validator::make($rows->toArray(), [
             '*.sample_code' => 'required',
             '*.description' => 'required',
             '*.type' => 'required',
             '*.species' => 'required',
             '*.bulk_code' => 'required',
             '*.source' => 'required',
             '*.source_ref' => 'required',
             '*.sample_remark' => 'required',
             '*.tags' => 'required',
             '*.repository_id' => 'required',
             '*.compartment_id' => 'required',
             '*.holder_id' => 'required',
             '*.box_id' => 'required',
         ])->validate();
        */

        $userCode = $this->generateCode(5);
        $bulkCode = $this->generateCode(7);
        $seriesCode = $this->generateCode(6);

        foreach($rows as $row)
        {
            if($row['user_code'] == null)
            {
                $row['user_code'] = $userCode;
            }

            if($row['bulk_code'] == null)
            {
                $row['bulk_code'] = $bulkCode;
            }

            if($row['series_code'] == null)
            {
                $row['series_code'] = $seriesCode;
            }

            $sampleCode = $this->generateCode(6);
            Exptsample::create([
                'sample_code'    => $this->generateCode(6),
                'description'    => $row['description'],
                'type'           => $row['type'], 
                'species'        => $row['species'],
                'user_code'      => $row['user_code'],
                'bulk_code'      => $row['bulk_code'],
                'series_code'    => $row['series_code'],
                'source'         => $row['source'],
                'source_ref'     => $row['source_ref'],
                'posted_by'      => Auth::user()->id,
                'posted_name'    => Auth::user()->name,
                'posted_date'    => date('Y-m-d'),
                'sample_remark'  => $row['sample_remark'],
                'tags'           => $row['tags'],
                'repository_id'  => $row['repository_id'],
                'compartment_id' => $row['compartment_id'],
                'holder_id'      => $row['holder_id'],
                'box_id'         => $row['box_id'],
                'isCurated'      => 'yes'
            ]);
        }
    }
}
