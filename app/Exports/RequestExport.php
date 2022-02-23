<?php

namespace App\Exports;

use App\Models\UserRequest;
use Maatwebsite\Excel\Concerns\FromCollection;

class RequestExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return UserRequest::all();
        // $guest = UserRequest::all();
        // return view('exports.user_requests',get_defined_vars());
    }
}
