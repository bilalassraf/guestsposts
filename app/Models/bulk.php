<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Bulk extends Model
{
    use HasFactory;
    protected $guarded = [];
    
}
class BulkImport implements ToModel,WithHeadingRow
{
public function model(array $row)
    {
         return new Bulk([
            'user_id'     => $row['user_id'],
            'web_name'    => $row['web_name'],
            'Coordinator'    => $row['Coordinator'],
            'price'    => $row['price'],
            'category'    => $row['category'],
            'company_price'    => $row['company_price'],
            'domain_authority'    => $row['domain_authority'],
            'span_score'    => $row['span_score'],
            'domain_rating'    => $row['domain_rating'],
            'organic_trafic_ahrefs'    => $row['organic_trafic_ahrefs'],
            'organic_trafic_sem'    => $row['organic_trafic_sem'], 
            'trust_flow'     => $row['trust_flow'],
            'citation_flow'    => $row['citation_flow'],
            'email_webmaster'     => $row['email_webmaster'],
            'web_description'    => $row['web_description'],
            'special_note'     => $row['special_note'],
            'status'    => $row['status'],
        ]);
    }
}