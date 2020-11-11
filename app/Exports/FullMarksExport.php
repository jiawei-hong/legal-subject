<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class FullMarksExport implements FromCollection
{
    public function __construct($data){
        $data = collect([[
            '班級名稱',
            '學生學號',
            '學生姓名'
        ]])->merge($data);

        $this->data = $data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->data;
    }
}
