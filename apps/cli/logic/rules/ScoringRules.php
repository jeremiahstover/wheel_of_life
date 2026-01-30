<?php
declare(strict_types=1);

/**
 * Logic Rules - Scoring calculations and interpretation
 */

class ScoringRules {
    /**
     * Calculate dimension score from question answers
     * Formula: (sum / 5) * 2 = score on 1-10 scale
     */
    public static function calculateDimensionScore(array $answers): float {
        if (empty($answers)) {
            return 0.0;
        }
        
        $sum = array_sum($answers);
        $count = count($answers);
        
        return round(($sum / $count) * 2, 1);
    }

    /**
     * Interpret a score into a level
     */
    public static function interpretScore(float $score): array {
        if ($score <= 2) {
            return [
                'level' => 'Crisis',
                'description' => 'Immediate attention required',
                'color' => 'red',
            ];
        } elseif ($score <= 4) {
            return [
                'level' => 'Below Baseline',
                'description' => 'Needs focused work',
                'color' => 'orange',
            ];
        } elseif ($score <= 6) {
            return [
                'level' => 'Maintaining',
                'description' => 'Functional but not growing',
                'color' => 'yellow',
            ];
        } elseif ($score <= 8) {
            return [
                'level' => 'Target Zone',
                'description' => 'Disciplines established',
                'color' => 'green',
            ];
        } else {
            return [
                'level' => 'Exceptional',
                'description' => 'Approaching mastery',
                'color' => 'blue',
            ];
        }
    }

    /**
     * Determine if a dimension needs remediation
     */
    public static function needsRemediation(float $score): bool {
        return $score < 5;
    }

    /**
     * Rank dimensions by priority (lowest scores first)
     */
    public static function rankByPriority(array $dimensionScores): array {
        asort($dimensionScores);
        return $dimensionScores;
    }

    /**
     * Identify crisis areas (score <= 4)
     */
    public static function findCrisisAreas(array $dimensionScores): array {
        return array_filter($dimensionScores, fn($score) => $score <= 4);
    }

    /**
     * Identify strength areas (score >= 7)
     */
    public static function findStrengthAreas(array $dimensionScores): array {
        return array_filter($dimensionScores, fn($score) => $score >= 7);
    }

    /**
     * Calculate overall average
     */
    public static function calculateOverallAverage(array $dimensionScores): float {
        if (empty($dimensionScores)) {
            return 0.0;
        }
        return round(array_sum($dimensionScores) / count($dimensionScores), 1);
    }

    /**
     * Compare two results and show change
     */
    public static function compareResults(QuizResult $current, QuizResult $previous): array {
        $changes = [];
        
        foreach ($current->dimensionScores as $dimId => $score) {
            $prevScore = $previous->dimensionScores[$dimId] ?? $score;
            $delta = round($score - $prevScore, 1);
            
            $changes[$dimId] = [
                'current' => $score,
                'previous' => $prevScore,
                'delta' => $delta,
                'direction' => $delta > 0 ? 'improved' : ($delta < 0 ? 'declined' : 'unchanged'),
            ];
        }
        
        return $changes;
    }
}
