<?php

namespace App\Exports;

use App\Models\BookmarkItem;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class BookmarksCollectionExport implements FromQuery, WithHeadings, WithMapping, HasLocalePreference, WithColumnFormatting, ShouldAutoSize, WithProperties
{
    use Exportable;

    public function __construct(
        protected $bookmarkedItems,
        protected string $locale
    ) {
    }

    public function query(): Builder
    {
        return BookmarkItem::query()->whereKey($this->bookmarkedItems);
    }

    public function map($row): array
    {
        $modelResource = 'App\\Http\\Resources\\'.Str::studly(Str::singular(class_basename($row->model))).'Resource';
        $modelDetail = new $modelResource($row->model);

        return [
            $modelDetail->title,
            $modelDetail->fund->parent->title,
            $modelDetail->fund->title,
            $modelDetail->amount_requested,
            $modelDetail->amount_received,
            $modelDetail->funding_status,
            $modelDetail->status,
            $modelDetail->yes_votes_count,
            $modelDetail->no_votes_count,
            $modelDetail->team?->name,
            $modelDetail->ideascale_link,
            $modelDetail->problem,
            $modelDetail->solution,
            $modelDetail->experience,
            $modelDetail->definition_of_success,
        ];
    }

    public function headings(): array
    {
        return [
            'Proposal Title',
            'Fund',
            'Challenge',
            'amount_requested',
            'amount_received',
            'funding_status',
            'project_status',
            'yes_votes',
            'no_votes',
            'team',
            'ideascale_link',
            'problem',
            'solution',
            'experience',
            'definition_of_success',
            'ideascale_link',
        ];
    }

    public function preferredLocale(): ?string
    {
        return $this->locale;
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_CURRENCY_USD_INTEGER,
            'E' => NumberFormat::FORMAT_CURRENCY_USD_INTEGER,
            'H' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'I' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];

    }

    public function properties(): array
    {
        return [
            'title' => 'Catalyst Explorer Bookmarked Proposals',
            'subject' => 'Bookmarked Proposals',
            'category' => 'Catalyst Explorer',
            'description' => 'LIDO Nation Catalyst Explorer Bookmarked Proposals Export',
        ];
    }
}
