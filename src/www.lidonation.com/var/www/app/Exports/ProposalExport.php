<?php

namespace App\Exports;

use App\Models\Proposal;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ProposalExport implements FromQuery, WithHeadings, WithMapping, HasLocalePreference, WithColumnFormatting, ShouldAutoSize, WithProperties
{
    use Exportable;

    protected int $id;

    public function __construct(
        protected $proposals,
        protected string $locale
    ){}

    /**
    * @return Builder
     */
    public function query(): Builder
    {
        return Proposal::query()->whereKey($this->proposals);
    }

    public function map($row): array
    {
        return [
            $row->title,
            $row->amount_requested,
            $row->amount_received,
            $row->funding_status,
            $row->status,
            $row->yes_votes_count,
            $row->no_votes_count,
            $row->fund?->title,
            $row->team?->name,
            $row->ideascale_link,
            $row->problem,
            $row->solution,
            $row->experience,
            $row->definition_of_success
        ];
    }

    public function headings(): array
    {
        return [
            'title',
            'amount_requested',
            'amount_received',
            'funding_status',
            'project_status',
            'yes_votes',
            'no_votes',
            'fund',
            'team',
            'ideascale_link',
            'problem',
            'solution',
            'experience',
            'definition_of_success',
            'ideascale_link'
        ];
    }

    public function preferredLocale(): ?string
    {
        return $this->locale;
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_CURRENCY_USD_INTEGER,
            'C' => NumberFormat::FORMAT_CURRENCY_USD_INTEGER,
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function properties(): array
    {
        return [
            'title'        => 'Catalyst Explorer Proposals',
            'subject'        => 'Proposals',
            'category'        => 'Catalyst Explorer',
            'description'        => 'LIDO Nation Catalyst Explorer Proposals Export',
        ];
    }
}
