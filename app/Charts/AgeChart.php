<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class AgeChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $data = DB::table('warga')
            ->select(
                DB::raw('CASE
                                WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 0 AND 4 THEN "0 - 4"
                                WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 5 AND 11 THEN "5 - 11"
                                WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 12 AND 24 THEN "12 - 24"
                                WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 25 AND 44 THEN "25 - 44"
                                WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 45 AND 60 THEN "45 - 60"
                                ELSE " > 60"
                            END AS `range`'),
                'jenis_kelamin',
                DB::raw('COUNT(*) AS total')
            )
            ->groupBy('range', 'jenis_kelamin')
            ->get();

        $laki_laki_data = ['0 - 4' => 0, '5 - 11' => 0, '12 - 24' => 0, '25 - 44' => 0, '45 - 60' => 0, ' > 60' => 0];
        $perempuan_data = ['0 - 4' => 0, '5 - 11' => 0, '12 - 24' => 0, '25 - 44' => 0, '45 - 60' => 0, ' > 60' => 0];

        foreach ($data as $item) {
            if ($item->jenis_kelamin == 'Laki-laki') {
                $laki_laki_data[$item->range] = $item->total;
            } else {
                $perempuan_data[$item->range] = $item->total;
            }
        }

        return $this->chart->barChart()
            ->setTitle('Persebaran Umur Warga')
            ->addData('Laki-laki', array_values($laki_laki_data))
            ->addData('Perempuan', array_values($perempuan_data))
            ->setColors(['#4ccdfe', '#ff6384'])
            ->setHeight(400)
            ->setXAxis(['0 - 4', '5 - 11', '12 - 24', '25 - 44', '45 - 60', ' > 60']);
    }
}
