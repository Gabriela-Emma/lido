<?php

namespace App\Exports;

use Illuminate\Support\Str;
use App\Models\BookmarkItem;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithProperties;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Illuminate\Contracts\Translation\HasLocalePreference;

class BookmarksCollectionExport implements FromQuery, WithHeadings, WithMapping, HasLocalePreference, WithColumnFormatting, ShouldAutoSize, WithProperties
{
    use Exportable;

    protected int $id;

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
            $row->title,
            $modelDetail->amount_received,
            $modelDetail->fund->parent->title,
            $modelDetail->fund->title,
        ];
    }

    public function headings(): array
    {
        return [
            'Title',
            'Budget',
            'Fund',
            'Challenge'
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
