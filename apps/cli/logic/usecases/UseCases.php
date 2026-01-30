<?php
declare(strict_types=1);

/**
 * Logic Use Cases - Quiz runner and report generator
 */

class QuizRunner {
    private Assessment $assessment;
    private QuizResult $result;

    public function __construct(Assessment $assessment) {
        $this->assessment = $assessment;
        $this->result = new QuizResult();
    }

    public function getAssessment(): Assessment {
        return $this->assessment;
    }

    public function getTotalQuestions(): int {
        $count = 0;
        foreach ($this->assessment->dimensions as $dim) {
            $count += count($dim->questions);
        }
        return $count;
    }

    public function recordAnswer(string $questionId, int $answer): void {
        if ($answer < 1 || $answer > 5) {
            throw new InvalidArgumentException("Answer must be 1-5, got: {$answer}");
        }
        $this->result->answers[$questionId] = $answer;
    }

    public function calculateResults(): QuizResult {
        foreach ($this->assessment->dimensions as $dimension) {
            $answers = [];
            foreach ($dimension->questions as $question) {
                if (isset($this->result->answers[$question->id])) {
                    $answers[] = $this->result->answers[$question->id];
                }
            }
            
            $score = ScoringRules::calculateDimensionScore($answers);
            $dimension->score = $score;
            $this->result->dimensionScores[$dimension->id] = $score;
        }

        $this->result->overallAverage = ScoringRules::calculateOverallAverage(
            $this->result->dimensionScores
        );

        return $this->result;
    }
}

class ReportGenerator {
    private Assessment $assessment;
    private QuizResult $result;
    private ?QuizResult $previousResult;

    public function __construct(Assessment $assessment, QuizResult $result, ?QuizResult $previousResult = null) {
        $this->assessment = $assessment;
        $this->result = $result;
        $this->previousResult = $previousResult;
    }

    public function generateSummary(): array {
        $summary = [
            'title' => $this->assessment->title,
            'timestamp' => $this->result->timestamp,
            'overall_average' => $this->result->overallAverage,
            'overall_interpretation' => ScoringRules::interpretScore($this->result->overallAverage),
            'dimensions' => [],
            'crisis_areas' => [],
            'strength_areas' => [],
            'comparison' => null,
        ];

        foreach ($this->assessment->dimensions as $dimension) {
            $score = $this->result->dimensionScores[$dimension->id] ?? 0;
            $interp = ScoringRules::interpretScore($score);
            
            $summary['dimensions'][] = [
                'id' => $dimension->id,
                'name' => $dimension->name,
                'category' => $dimension->category,
                'score' => $score,
                'level' => $interp['level'],
                'description' => $interp['description'],
            ];

            if ($score <= 4) {
                $summary['crisis_areas'][] = [
                    'dimension' => $dimension,
                    'score' => $score,
                ];
            }
            if ($score >= 7) {
                $summary['strength_areas'][] = [
                    'dimension' => $dimension,
                    'score' => $score,
                ];
            }
        }

        if ($this->previousResult) {
            $summary['comparison'] = ScoringRules::compareResults($this->result, $this->previousResult);
        }

        return $summary;
    }

    public function generateRecommendations(): array {
        $recommendations = [];
        $prioritized = ScoringRules::rankByPriority($this->result->dimensionScores);

        $focusCount = 0;
        foreach ($prioritized as $dimId => $score) {
            if ($focusCount >= 3) break; // Focus on top 3 lowest

            $dimension = $this->findDimension($dimId);
            if (!$dimension) continue;

            $interp = ScoringRules::interpretScore($score);
            
            $recommendations[] = [
                'priority' => $focusCount + 1,
                'dimension' => $dimension->name,
                'category' => $dimension->category,
                'current_score' => $score,
                'level' => $interp['level'],
                'advice' => $dimension->remediation->advice,
                'scripture' => [
                    'text' => $dimension->remediation->scriptureText,
                    'reference' => $dimension->remediation->scriptureRef,
                ],
                'anchor_scripture' => [
                    'text' => $dimension->scriptureText,
                    'reference' => $dimension->scriptureRef,
                ],
            ];
            
            $focusCount++;
        }

        return $recommendations;
    }

    private function findDimension(int $id): ?Dimension {
        foreach ($this->assessment->dimensions as $dim) {
            if ($dim->id === $id) {
                return $dim;
            }
        }
        return null;
    }
}
