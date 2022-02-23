<?php

namespace App\Imports;

use App\Models\UserRequest;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\withHeadingRow;

class UserRequestImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new UserRequest([
            'user_id' => $row[1],
            'web_name' => $row[2],
            'Coordinator' => $row[3],
            'price' => $row[4],
            'category' => $row[5],
            'company_price' => $row[6],
            'domain_authority' => $row[7],
            'span_score' => $row[8],
            'domain_rating' => $row[9],
            'organic_trafic_ahrefs' => $row[10],
            'organic_trafic_sem' => $row[11],
            'trust_flow' => $row[12],
            'citation_flow' => $row[13],
            'email_webmaster' => $row[14],
            'web_description' => $row[15],
            'special_note' => $row[16],
            'status' => $row[17],
        ]);
    }
}
