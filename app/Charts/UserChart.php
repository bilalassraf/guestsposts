<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Models\UserRequest;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Chartisan\PHP\Chartisan;

class UserChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $total = UserRequest::all()->count();
        $approved = UserRequest::where('status','approved')->count() /$total * 100;
        $pending = UserRequest::where('status','pending')->count() /$total * 100;
        $rejected = UserRequest::where('status','rejected')->count() /$total * 100;
        $deleted = UserRequest::where('status','deleted')->count() /$total * 100;
        return Chartisan::build()
            ->labels(['Approved', 'Rejected', 'Pending','Deleted'])
            ->dataset('Sample', [$approved,$rejected,$pending,$deleted,100]);
            // ->dataset('Sample 2', [ 0,0,0,0,]);
    }
}
