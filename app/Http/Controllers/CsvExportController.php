<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CsvExportController extends Controller
{
     public function exportExcelView()
    {
        return view('pages/guest/all-web-request');
    }

    public function exportExcel()
    {
       
        $name = 'userrequest.csv';
        $headers = [
            'Content-Disposition' => 'attachment; filename='. $name,
        ];
        $colom = \Illuminate\Support\Facades\Schema::getColumnListing("userrequest");
        $temp_colom = array_flip($colom);
        unset($temp_colom['id']);
        $colom = array_flip($temp_colom);
        return response()->stream(function() use($colom){
            $file = fopen('php://output', 'w+');
            fputcsv($file, $colom);
            $data = \App\Models\UserRequest::cursor();
            
            foreach ($data as $key => $value) {
                $data = $value->toArray();
                
                unset($data['id']);

                fputcsv($file, $data);
            }
            $blanks = array("\t","\t","\t","\t");
            fputcsv($file, $blanks);
            $blanks = array("\t","\t","\t","\t");
            fputcsv($file, $blanks);
            $blanks = array("\t","\t","\t","\t");
            fputcsv($file, $blanks);

            fclose($file);
        }, 200, $headers);        
    }
}
