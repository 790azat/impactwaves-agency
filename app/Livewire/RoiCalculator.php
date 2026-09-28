<?php

namespace App\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Component;

class RoiCalculator extends Component
{
    public int $budget = 20000;

    public float $cpc = 1.2;

    public float $conversionRate = 2.5;

    public int $orderValue = 90;

    public int $uplift = 30;

    public function updated(): void
    {
        $this->budget = max(1000, min(500000, $this->budget));
        $this->cpc = max(0.1, min(10, $this->cpc));
        $this->conversionRate = max(0.3, min(15, $this->conversionRate));
        $this->orderValue = max(5, min(2000, $this->orderValue));
        $this->uplift = max(0, min(100, $this->uplift));
    }

    #[Computed]
    public function current(): array
    {
        return $this->scenario($this->conversionRate);
    }

    #[Computed]
    public function optimized(): array
    {
        return $this->scenario($this->conversionRate * (1 + $this->uplift / 100));
    }

    private function scenario(float $rate): array
    {
        $clicks = $this->budget / $this->cpc;
        $conversions = $clicks * $rate / 100;
        $revenue = $conversions * $this->orderValue;

        return [
            'clicks' => $clicks,
            'conversions' => $conversions,
            'revenue' => $revenue,
            'roas' => $this->budget > 0 ? $revenue / $this->budget : 0,
            'cpa' => $conversions > 0 ? $this->budget / $conversions : 0,
            'profit' => $revenue - $this->budget,
        ];
    }

    public static function money(float $value): string
    {
        $sign = $value < 0 ? '-' : '';
        $value = abs($value);

        return match (true) {
            $value >= 1_000_000 => $sign.'$'.number_format($value / 1_000_000, 2).'M',
            $value >= 10_000 => $sign.'$'.number_format($value / 1000, 1).'k',
            default => $sign.'$'.number_format($value, 0),
        };
    }

    public function render()
    {
        return view('livewire.roi-calculator');
    }
}
