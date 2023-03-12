<?php

namespace App\Exports;

use App\Models\Proposal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProposalExport implements FromQuery, WithHeadings
{
    use Exportable;

    protected $id;

    public function __construct(protected $proposals)
    {
        
    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Proposal::query()->whereKey($this->proposals);
    }

    public function map($proposal): array
    {
        return [
            $proposal->id,
            $proposal->user_id,
            $proposal->fund_id,
            $proposal->title,
            $proposal->slug,
            $proposal->website,
            $proposal->excerpt,
            $proposal->amount_requested,
            $proposal->definition_of_success,
            $proposal->status,
            $proposal->meta_data,
            $proposal->funded_at,
            $proposal->deleted_at,
            $proposal->created_at,
            $proposal->updated_at,
            $proposal->yes_votes_count,
            $proposal->no_votes_count,
            $proposal->comment_prompt,
            $proposal->social_excerpt,
            $proposal->team_id,
            $proposal->ideascale_link,
            $proposal->type,
            $proposal->meta_title,
            $proposal->problem,
            $proposal->solution,
            $proposal->experience,
            $proposal->content,
            $proposal->amount_received,
            $proposal->funding_status,
            $proposal->funding_updated_at,
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'user_id',
            'fund_id',
            'title',
            'slug',
            'website',
            'excerpt',
            'amount_requested',
            'definition_of_success',
            'status',
            'meta_data',
            'funded_at',
            'deleted_at',
            'created_at',
            'updated_at',
            'yes_votes_count',
            'no_votes_count',
            'comment_prompt',
            'social_excerpt',
            'team_id',
            'ideascale_link',
            'type',
            'meta_title',
            'problem',
            'solution',
            'experience',
            'content',
            'amount_received',
            'funding_status',
            'funding_updated_at',
        ];
    }
}
