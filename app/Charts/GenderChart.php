<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class GenderChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\DonutChart
    {
        $data = DB::table('warga')
            ->select(
                DB::raw('COUNT(*) AS total'),
                'jenis_kelamin'
            )
            ->groupBy('jenis_kelamin')
            ->get();

        $laki_laki_total = 0;
        $perempuan_total = 0;

        foreach ($data as $item) {
            if ($item->jenis_kelamin == 'Laki-laki') {
                $laki_laki_total = $item->total;
            } else {
                $perempuan_total = $item->total;
            }
        }

        return $this->chart->donutChart()
            ->setTitle('Perbandingan Jenis Kelamin Warga')
            ->addData([$laki_laki_total, $perempuan_total])
            ->setHeight(200)
            ->setLabels(['Laki-laki', 'Perempuan']);
    }
}
