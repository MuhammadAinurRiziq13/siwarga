<?php

namespace App\Charts;

use App\Models\FamilyModel;
use App\Models\PoorFamilyModel;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class PoorChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\DonutChart
    {
        $praSejahtera = PoorFamilyModel::count();
        $sejahtera = FamilyModel::count() - $praSejahtera;

        return $this->chart->donutChart()
            ->setTitle('Presentase Warga Pra-Sejahtera')
            ->addData([$sejahtera, $praSejahtera])
            ->setColors(['#4ccdfe', '#ff6384'])
            ->setHeight(200)
            ->setLabels(['Sejahtera', 'Pra-Sejahtera']);
    }
}
