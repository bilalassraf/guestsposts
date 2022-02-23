namespace App\Exports;
use App\Models\Bulk;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BulkExport implements FromQuery,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */  
    // use Exportable;

    public function headings(): array
    {
        return [
            'user_id'    ,
            'web_name'   ,
            'Coordinator'  ,
            'price',
            'category',
            'company_price',
            'domain_authority',
            'span_score',
            'domain_rating',
            'organic_trafic_ahrefs',
            'organic_trafic_sem', 
            'trust_flow',
            'citation_flow',
            'email_webmaster',
            'web_description',
            'special_note',
            'status',
            'createdAt',
            'updatedAt',
        ];
    }
    public function query()
    {
        return Bulk::query();
        /*you can use condition in query to get required result
         return Bulk::query()->whereRaw('id > 5');*/
    }
    public function map($bulk): array
    {
        return [
            

            $bulk->user_id,
            $bulk->web_name,
            $bulk->Coordinator,
            $bulk->price,
            $bulk->category,
            $bulk->company_price,
            $bulk->domain_authority,
            $bulk->span_score,
            $bulk->domain_rating,
            $bulk->organic_trafic_ahrefs,
            $bulk->organic_trafic_sem, 
            $bulk->trust_flow,
            $bulk->citation_flow,
            $bulk->email_webmaster,
            $bulk->web_description,
            $bulk->special_note,
            $bulk->status,
            Date::dateTimeToExcel($bulk->created_at),
            Date::dateTimeToExcel($bulk->updated_at),
        ];
    }

}