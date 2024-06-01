<?php

namespace App\Services;

class Topsis
{
    private $alternatives;
    private $criteria;
    private $weights;
    private $decisionMatrix;
    private $normalizedMatrix;
    private $weightedNormalizedMatrix;
    private $idealBest;
    private $idealWorst;
    private $distances;
    private $scores;
    private $criteriaType;
    private $steps;

    public function __construct($alternatives, $criteria, $weights, $decisionMatrix, $criteriaType)
    {
        $this->alternatives = $alternatives;
        $this->criteria = $criteria;
        $this->weights = $weights;
        $this->decisionMatrix = $decisionMatrix;
        $this->criteriaType = $criteriaType; // 'benefit' or 'cost'
        $this->steps = [];
    }

    public function getSteps()
    {
        return $this->steps;
    }

    private function addStep($stepName, $stepData)
    {
        $this->steps[$stepName] = $stepData;
    }

    // Modifikasi fungsi normalizeMatrix()
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
        $this->addStep('normalizedMatrix', $this->normalizedMatrix);
        $this->addStep('decisionMatrix', $this->decisionMatrix);
    }

    // Modifikasi fungsi weightNormalizedMatrix()
    public function weightNormalizedMatrix()
    {
        $this->weightedNormalizedMatrix = [];
        foreach ($this->normalizedMatrix as $i => $values) {
            foreach ($values as $j => $value) {
                $this->weightedNormalizedMatrix[$i][$j] = $value * $this->weights[$j];
            }
        }
        $this->addStep('weightedNormalizedMatrix', $this->weightedNormalizedMatrix);
    }

    // Modifikasi fungsi determineIdealSolutions()
    public function determineIdealSolutions()
    {
        $this->idealBest = [];
        $this->idealWorst = [];
        foreach ($this->criteria as $j => $criterion) {
            $column = array_column($this->weightedNormalizedMatrix, $j);
            if ($this->criteriaType[$j] == 'benefit') {
                $this->idealBest[$j] = max($column);
                $this->idealWorst[$j] = min($column);
            } else {
                $this->idealBest[$j] = min($column);
                $this->idealWorst[$j] = max($column);
            }
        }
        $this->addStep('idealSolutions', ['best' => $this->idealBest, 'worst' => $this->idealWorst]);
    }

    // Modifikasi fungsi calculateDistances()
    public function calculateDistances()
    {
        $this->distances = ['best' => [], 'worst' => []];
        foreach ($this->weightedNormalizedMatrix as $i => $values) {
            $sumBest = 0;
            $sumWorst = 0;
            foreach ($values as $j => $value) {
                $sumBest += pow($value - $this->idealBest[$j], 2);
                $sumWorst += pow($value - $this->idealWorst[$j], 2);
            }
            $this->distances['best'][$i] = sqrt($sumBest);
            $this->distances['worst'][$i] = sqrt($sumWorst);
        }
        $this->addStep('distances', $this->distances);
    }

    // Modifikasi fungsi calculateScores()
    public function calculateScores()
    {
        $this->scores = [];
        foreach ($this->distances['best'] as $i => $distanceBest) {
            $this->scores[$i] = $this->distances['worst'][$i] / ($distanceBest + $this->distances['worst'][$i]);
        }
        $this->addStep('scores', $this->scores);
    }

    // Fungsi getRankings() tidak perlu dimodifikasi karena tidak ada langkah tambahan
    public function getRankings()
    {
        arsort($this->scores);
        $rankings = [];
        foreach ($this->scores as $i => $score) {
            $rankings[] = [
                'alternative' => $this->alternatives[$i],
                'score' => $score
            ];
        }
        return $rankings;
    }
    // Modifikasi fungsi run()
    public function run()
    {
        $this->normalizeMatrix();
        $this->weightNormalizedMatrix();
        $this->determineIdealSolutions();
        $this->calculateDistances();
        $this->calculateScores();
        return $this->getRankings();
    }
}


// public function run() {
//     $this->normalizeMatrix();
//     $this->weightNormalizedMatrix();
//     $this->determineIdealSolutions();
//     $this->calculateDistances();
//     $this->calculateScores();
//     return $this->getRankings();
// }
// }
