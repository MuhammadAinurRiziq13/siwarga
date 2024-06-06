<?php

namespace App\Services;

class Topsis
{
    // Deklarasi properti
    private $alternatives; // Daftar alternatif
    private $criteria; // Daftar kriteria
    private $weights; // Bobot dari setiap kriteria
    private $decisionMatrix; // Matriks keputusan (alternatif x kriteria)
    private $normalizedMatrix; // Matriks keputusan yang sudah dinormalisasi
    private $weightedNormalizedMatrix; // Matriks keputusan yang sudah dinormalisasi dan dibobotkan
    private $idealPositive; // Nilai ideal terbaik untuk setiap kriteria
    private $idealNegative; // Nilai ideal terburuk untuk setiap kriteria
    private $distances; // Jarak dari alternatif ke solusi ideal
    private $scores; // Skor dari alternatif
    private $criteriaType; // Tipe kriteria: 'benefit' atau 'cost'
    private $steps; // Langkah-langkah dalam algoritma TOPSIS

    // Konstruktor
    public function __construct($alternatives, $criteria, $weights, $decisionMatrix, $criteriaType)
    {
        $this->alternatives = $alternatives;
        $this->criteria = $criteria;
        $this->weights = $weights;
        $this->decisionMatrix = $decisionMatrix;
        $this->criteriaType = $criteriaType; // 'benefit' atau 'cost'
        $this->steps = []; // Inisialisasi array langkah-langkah
    }

    // Dapatkan langkah-langkah
    public function getSteps()
    {
        return $this->steps;
    }

    // Tambahkan langkah ke array langkah-langkah
    private function addStep($stepName, $stepData)
    {
        $this->steps[$stepName] = $stepData;
    }

    // Langkah 1: Normalisasi matriks keputusan
    public function normalizeMatrix()
    {
        $this->normalizedMatrix = [];
        foreach ($this->criteria as $j => $criterion) {
            $sum = 0;
            foreach ($this->decisionMatrix as $i => $values) {
                $sum += pow($values[$j], 2);
            }
            $sqrtSum = sqrt($sum);
            foreach ($this->decisionMatrix as $i => $values) {
                $this->normalizedMatrix[$i][$j] = $values[$j] / $sqrtSum;
            }
        }
        $this->addStep('normalizedMatrix', $this->normalizedMatrix); // Simpan matriks yang dinormalisasi dalam langkah-langkah
        $this->addStep('decisionMatrix', $this->decisionMatrix); // Simpan matriks keputusan asli dalam langkah-langkah
    }

    // Langkah 2: Beri bobot pada matriks yang sudah dinormalisasi
    public function weightNormalizedMatrix()
    {
        $this->weightedNormalizedMatrix = [];
        foreach ($this->normalizedMatrix as $i => $values) {
            foreach ($values as $j => $value) {
                $this->weightedNormalizedMatrix[$i][$j] = $value * $this->weights[$j];
            }
        }
        $this->addStep('weightedNormalizedMatrix', $this->weightedNormalizedMatrix); // Simpan matriks yang sudah dinormalisasi dan dibobotkan dalam langkah-langkah
    }

    // Langkah 3: Tentukan solusi ideal
    public function determineIdealSolutions()
    {
        $this->idealPositive = [];
        $this->idealNegative = [];
        foreach ($this->criteria as $j => $criterion) {
            $column = array_column($this->weightedNormalizedMatrix, $j);
            if ($this->criteriaType[$j] == 'benefit') {
                $this->idealPositive[$j] = max($column);
                $this->idealNegative[$j] = min($column);
            } else {
                $this->idealPositive[$j] = min($column);
                $this->idealNegative[$j] = max($column);
            }
        }
        $this->addStep('idealSolutions', ['positive' => $this->idealPositive, 'negative' => $this->idealNegative]); // Simpan solusi ideal dalam langkah-langkah
    }

    // Langkah 4: Hitung jarak
    public function calculateDistances()
    {
        $this->distances = ['positive' => [], 'negative' => []];
        foreach ($this->weightedNormalizedMatrix as $i => $values) {
            $sumPositive = 0;
            $sumNegative = 0;
            foreach ($values as $j => $value) {
                $sumPositive += pow($value - $this->idealPositive[$j], 2);
                $sumNegative += pow($value - $this->idealNegative[$j], 2);
            }
            $this->distances['positive'][$i] = sqrt($sumPositive);
            $this->distances['negative'][$i] = sqrt($sumNegative);
        }
        $this->addStep('distances', $this->distances); // Simpan jarak dalam langkah-langkah
    }

    // Langkah 5: Hitung skor
    public function calculateScores()
    {
        $this->scores = [];
        foreach ($this->distances['positive'] as $i => $distancePositive) {
            $this->scores[$i] = $this->distances['negative'][$i] / ($distancePositive + $this->distances['negative'][$i]);
        }
        $this->addStep('scores', $this->scores); // Simpan skor dalam langkah-langkah
    }

    // Dapatkan peringkat
    public function getRankings()
    {
        arsort($this->scores); // Urutkan skor secara menurun
        $rankings = [];
        foreach ($this->scores as $i => $score) {
            $rankings[] = [
                'alternative' => $this->alternatives[$i],
                'score' => $score
            ];
        }
        return $rankings; // Kembalikan alternatif yang sudah diperingkat
    }

    // Jalankan metode TOPSIS
    public function run()
    {
        $this->normalizeMatrix(); // Langkah 1: Normalisasi matriks
        $this->weightNormalizedMatrix(); // Langkah 2: Beri bobot pada matriks yang sudah dinormalisasi
        $this->determineIdealSolutions(); // Langkah 3: Tentukan solusi ideal
        $this->calculateDistances(); // Langkah 4: Hitung jarak
        $this->calculateScores(); // Langkah 5: Hitung skor
        return $this->getRankings(); // Dapatkan peringkat alternatif
    }
}
