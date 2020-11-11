<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    public function __construct($data)
    {
        sort($data);
        $data = collect([[
            '問題',
            '答對率',
            '答錯率',
        ]])->merge($data);

        $this->data = collect($data);
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->data;
    }
}
