<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\DepositsVsWithdrawals7Days;
use App\Filament\Widgets\DepositsByHourToday;
use App\Filament\Widgets\NewUsers14Days;
use App\Filament\Widgets\TopDepositorsThisMonth;
use App\Livewire\WalletOverview;
use Illuminate\Support\HtmlString;
use App\Filament\Widgets\HouseProfitOverview;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class DashboardAdmin extends \Filament\Pages\Dashboard
{
    use HasFiltersForm, HasFiltersAction;

    /**
     * Subtítulo do painel
     */
    public function getSubheading(): string|\Illuminate\Contracts\Support\Htmlable|null
    {
        return "Bem-vindo(a) de volta, Admin! Seu painel está pronto para você.";
    }

    /**
     * Filtros do painel (fica no drawer de filtros do Filament)
     */
    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('RECRIADO POR JC_SCRIPTS')
                    ->description(new HtmlString('
                        <div style="font-weight: 600; display: flex; align-items: center; flex-wrap: wrap; gap: 10px;">
                            PARTICIPE DO MEU GRUPO DO TELEGRAM E ADQUIRA SISTEMAS PROFISSIONAIS!
                            <a class="dark:text-white"
                               style="font-size: 14px; font-weight: 600; min-width: 127px; display: inline-flex; background-color: #00b91e; padding: 10px; border-radius: 11px; justify-content: center;"
                               href="https://t.me/jcts99" target="_blank">📱 TELEGRAM</a>
                            <a class="dark:text-white"
                               style="font-size: 14px; font-weight: 600; min-width: 127px; display: inline-flex; background-color: #25D366; padding: 10px; border-radius: 11px; justify-content: center;"
                               href="https://wa.me/+5545999057184" target="_blank">💬 WHATSAPP</a>
                        </div>
                        <div style="margin-top: 10px; font-size: 13px; color: #666;">
                            🎰 Raspadinhas • 🎲 Cassinos • 💳 Gateways • 🛒 E-commerce e muito mais!
                        </div>
                    ')),
                Section::make('Filtros do painel')
                    ->schema([
                        DatePicker::make('startDate')->label('Data Inicial'),
                        DatePicker::make('endDate')->label('Data Final'),
                    ])
                    ->columns(2),
            ]);
    }

    /**
     * Ação de Filtro no header (abre o drawer com o mesmo form acima)
     */
    protected function getHeaderActions(): array
    {
        return [
            FilterAction::make()
                ->label('Filtro')
                ->form([
                    DatePicker::make('startDate')->label('Data Inicial'),
                    DatePicker::make('endDate')->label('Data Final'),
                ]),
        ];
    }

    /**
     * Widgets exibidos nesta dashboard
     */
    public function getWidgets(): array
    {
        return [
            // Seu componente Livewire existente
            WalletOverview::class,
            HouseProfitOverview::class,
            
            // KPIs e gráficos
            StatsOverview::class,
            DepositsVsWithdrawals7Days::class,
            DepositsByHourToday::class,
            NewUsers14Days::class,
            TopDepositorsThisMonth::class,
        ];
    }
}