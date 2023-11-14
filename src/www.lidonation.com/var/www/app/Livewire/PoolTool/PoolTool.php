<?php

//
//namespace App\Livewire\PoolTool;
//
//use App\Models\Cardano\PoolUpdate;
//use App\Repositories\PoolRepository;
//use App\View\Components\PublicLayout;
//use Illuminate\Contracts\Foundation\Application;
//use Illuminate\Contracts\View\Factory;
//use Illuminate\Contracts\View\View;
//use Mediconesystems\LivewireDatatables\Column;
//use Mediconesystems\LivewireDatatables\DateColumn;
//use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
//use Mediconesystems\LivewireDatatables\NumberColumn;
//
//class PoolTool extends LivewireDatatable
//{
//    public $model = PoolUpdate::class;
//
//    //    public $searchable = ['title'];
//    public $beforeTableSlot = 'livewire.pool-tool.filters';
//
//    public $beforePageSlot = 'livewire.pool-tool.header';
//
//    //    public $activeSelectFilters = ['fund'];
//    public $perPage = 50;
//
//    public function builder()
//    {
//        return app(PoolRepository::class)->active();
//    }
//
//    public function columns(): array
//    {
//        return [
//            //            NumberColumn::name('id')
//            //                ->label('ID')
//            //                ->filterable()
//            //                ->linkTo('user', 6),
//
//            NumberColumn::name('hash.view')
//                ->label('Hash'),
//
//            Column::name('pledge')
//                ->view('livewire.pool-tool.pledge'),
//
//            Column::name('margin')
//                ->view('livewire.pool-tool.margin'),
//
//            Column::name('meta.url')
//                ->label('url')
//                ->view('livewire.pool-tool.website'),
//
//            //            Column::name('fund')->filterable(['Fund 1', 'Fund 2'])->hide(),
//            //
//            //            NumberColumn::name('amount_requested')
//            //                ->sortBy('amount_requested')
//            //                ->label('Requested')
//            //                ->view('livewire.catalyst.proposal.requested'),
//            //
//            //            DateColumn::name('created_at')
//            //                ->label('created'),
//            //
//            //            Column::name('status'),
//
//            //
//            //            NumberColumn::name('pledge')
//            //                ->label('Pledge'),
//
//            //
//            //            NumberColumn::name('weapons.id:group_concat')
//            //                ->filterable()
//            //                ->label('Weapon Concat'),
//            //
//            //            NumberColumn::name('weapons.id:max')
//            //                ->filterable()
//            //                ->label('Weapon Max'),
//        ];
//    }
//
//    public function render(): Factory|View|Application
//    {
//        $view = parent::render((new PublicLayout())->data());
//        $view->layout('layouts.public');
//
//        return $view;
//    }
//}
