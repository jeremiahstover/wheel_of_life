<?php
/**
 * Drunkard's Walk Diagnostic Engine
 * 
 * Binary search through layers to find break points efficiently.
 * POC - proof of concept for algorithm validation.
 */

class DiagnosticEngine
{
    private string $dataPath;
    private array $cache = [];
    private bool $verbose = true;
    
    // Threshold: below = weak, above = strong
    private const THRESHOLD = 3.5;
    
    // Dimension codes and names
    private const DIMENSIONS = [
        'A' => ['name' => 'Communion',   'category' => 'Spirit'],
        'B' => ['name' => 'Conscience',  'category' => 'Spirit'],
        'C' => ['name' => 'Holiness',    'category' => 'Spirit'],
        'D' => ['name' => 'Mind',        'category' => 'Soul'],
        'E' => ['name' => 'Will',        'category' => 'Soul'],
        'F' => ['name' => 'Emotions',    'category' => 'Soul'],
        'G' => ['name' => 'Sustenance',  'category' => 'Body'],
        'H' => ['name' => 'Capability',  'category' => 'Body'],
        'I' => ['name' => 'Wholeness',   'category' => 'Body'],
    ];
    
    // Layer names
    private const LAYERS = [
        1 => 'Order',
        2 => 'Causality',
        3 => 'Responsibility',
        4 => 'Discipline',
        5 => 'Skill',
        6 => 'Resources',
        7 => 'Fellowship',
        8 => 'Sacrifice',
    ];
    
    public function __construct(string $dataPath)
    {
        $this->dataPath = rtrim($dataPath, '/');
    }
    
    public function setVerbose(bool $verbose): void
    {
        $this->verbose = $verbose;
    }
    
    /**
     * Load a cell's questions
     */
    public function loadCell(string $dimension, int $layer): ?array
    {
        $key = "{$dimension}{$layer}";
        
        if (isset($this->cache[$key])) {
            return $this->cache[$key];
        }
        
        $file = "{$this->dataPath}/{$key}.json";
        if (!file_exists($file)) {
            $this->log("WARNING: Missing cell file: {$key}.json");
            return null;
        }
        
        $data = json_decode(file_get_contents($file), true);
        $this->cache[$key] = $data;
        return $data;
    }
    
    /**
     * Score a cell (simulated - returns random score for POC)
     * In real implementation, this would ask questions and collect answers.
     */
    public function scoreCell(string $dimension, int $layer, ?callable $answerCallback = null): float
    {
        $cell = $this->loadCell($dimension, $layer);
        if (!$cell) {
            return 0.0;
        }
        
        $answers = [];
        foreach ($cell['questions'] as $q) {
            if ($answerCallback) {
                $answer = $answerCallback($q, $dimension, $layer);
            } else {
                // Simulated: random with slight bias based on layer
                // Lower layers tend to be stronger (foundational)
                $bias = (9 - $layer) * 0.1; // 0.8 for L1, 0.1 for L8
                $answer = min(5, max(1, round(rand(20, 40) / 10 + $bias)));
            }
            $answers[] = $answer;
        }
        
        $score = array_sum($answers) / count($answers);
        
        $this->log(sprintf(
            "  %s%d (%s @ %s): %.2f %s",
            $dimension,
            $layer,
            self::DIMENSIONS[$dimension]['name'],
            self::LAYERS[$layer],
            $score,
            $score >= self::THRESHOLD ? '✓ STRONG' : '✗ WEAK'
        ));
        
        return $score;
    }
    
    /**
     * Check if a score indicates strength
     */
    public function isStrong(float $score): bool
    {
        return $score >= self::THRESHOLD;
    }
    
    /**
     * Find break point for a single dimension using drunkard's walk
     * Returns: ['floor' => int, 'break' => int|null, 'scores' => array]
     */
    public function findBreakPoint(string $dimension, ?callable $answerCallback = null): array
    {
        $this->log("\n=== Dimension {$dimension}: " . self::DIMENSIONS[$dimension]['name'] . " ===");
        
        $scores = [];
        
        // Step 1: Probe L3 and L6
        $this->log("\nPhase 1: Initial probes (L3, L6)");
        $scores[3] = $this->scoreCell($dimension, 3, $answerCallback);
        $scores[6] = $this->scoreCell($dimension, 6, $answerCallback);
        
        $s3 = $this->isStrong($scores[3]);
        $s6 = $this->isStrong($scores[6]);
        
        // Step 2: Determine search direction
        if ($s3 && $s6) {
            // Both strong - check upper layers
            $this->log("\nPhase 2: Both strong → probe upper (L7, L8)");
            $scores[7] = $this->scoreCell($dimension, 7, $answerCallback);
            $scores[8] = $this->scoreCell($dimension, 8, $answerCallback);
            
            // Find first weak from top
            for ($l = 8; $l >= 7; $l--) {
                if (!$this->isStrong($scores[$l])) {
                    return $this->confirmBreak($dimension, $l, $scores, $answerCallback);
                }
            }
            // All strong - no break point
            return ['floor' => 8, 'break' => null, 'scores' => $scores, 'message' => 'Solid through L8'];
            
        } elseif (!$s3 && !$s6) {
            // Both weak - check lower layers
            $this->log("\nPhase 2: Both weak → probe lower (L1, L2)");
            $scores[1] = $this->scoreCell($dimension, 1, $answerCallback);
            $scores[2] = $this->scoreCell($dimension, 2, $answerCallback);
            
            // Find floor (first strong from bottom)
            for ($l = 1; $l <= 2; $l++) {
                if ($this->isStrong($scores[$l])) {
                    return $this->confirmBreak($dimension, $l + 1, $scores, $answerCallback);
                }
            }
            // Even L1 is weak - fundamental crisis
            return ['floor' => 0, 'break' => 1, 'scores' => $scores, 'message' => 'Foundation crisis - L1 weak'];
            
        } elseif ($s3 && !$s6) {
            // Break is between 3 and 6 - probe middle
            $this->log("\nPhase 2: L3 strong, L6 weak → probe middle (L4, L5)");
            $scores[4] = $this->scoreCell($dimension, 4, $answerCallback);
            $scores[5] = $this->scoreCell($dimension, 5, $answerCallback);
            
            // Find exact break point
            if ($this->isStrong($scores[4]) && $this->isStrong($scores[5])) {
                return ['floor' => 5, 'break' => 6, 'scores' => $scores, 'message' => 'Break at L6 (Resources)'];
            } elseif ($this->isStrong($scores[4])) {
                return ['floor' => 4, 'break' => 5, 'scores' => $scores, 'message' => 'Break at L5 (Skill)'];
            } else {
                return ['floor' => 3, 'break' => 4, 'scores' => $scores, 'message' => 'Break at L4 (Discipline)'];
            }
            
        } else {
            // L3 weak, L6 strong - anomaly (upper stronger than foundation)
            $this->log("\nPhase 2: ANOMALY - L3 weak but L6 strong. Investigating...");
            $scores[1] = $this->scoreCell($dimension, 1, $answerCallback);
            $scores[2] = $this->scoreCell($dimension, 2, $answerCallback);
            $scores[4] = $this->scoreCell($dimension, 4, $answerCallback);
            $scores[5] = $this->scoreCell($dimension, 5, $answerCallback);
            
            // Find the actual floor
            for ($l = 1; $l <= 5; $l++) {
                if (!isset($scores[$l])) continue;
                if ($this->isStrong($scores[$l])) {
                    // Found strength - next weak above is the break
                    for ($b = $l + 1; $b <= 8; $b++) {
                        if (!isset($scores[$b])) {
                            $scores[$b] = $this->scoreCell($dimension, $b, $answerCallback);
                        }
                        if (!$this->isStrong($scores[$b])) {
                            return ['floor' => $l, 'break' => $b, 'scores' => $scores, 'message' => "Anomaly resolved: break at L{$b}"];
                        }
                    }
                }
            }
            
            return ['floor' => 0, 'break' => 1, 'scores' => $scores, 'message' => 'Anomaly: inconsistent pattern'];
        }
    }
    
    /**
     * Confirm break point by checking adjacent layers if needed
     */
    private function confirmBreak(string $dimension, int $suspectedBreak, array &$scores, ?callable $answerCallback): array
    {
        $floor = $suspectedBreak - 1;
        
        // Ensure we have the floor score
        if (!isset($scores[$floor]) && $floor >= 1) {
            $this->log("\nPhase 3: Confirming floor at L{$floor}");
            $scores[$floor] = $this->scoreCell($dimension, $floor, $answerCallback);
        }
        
        // Verify floor is actually strong
        if ($floor >= 1 && !$this->isStrong($scores[$floor])) {
            // Floor isn't solid - go deeper
            $this->log("  Floor L{$floor} not solid, searching deeper...");
            for ($l = $floor - 1; $l >= 1; $l--) {
                $scores[$l] = $this->scoreCell($dimension, $l, $answerCallback);
                if ($this->isStrong($scores[$l])) {
                    return [
                        'floor' => $l,
                        'break' => $l + 1,
                        'scores' => $scores,
                        'message' => "Break at L" . ($l + 1) . " (" . self::LAYERS[$l + 1] . ")"
                    ];
                }
            }
            return ['floor' => 0, 'break' => 1, 'scores' => $scores, 'message' => 'Foundation crisis'];
        }
        
        return [
            'floor' => $floor,
            'break' => $suspectedBreak,
            'scores' => $scores,
            'message' => "Break at L{$suspectedBreak} (" . self::LAYERS[$suspectedBreak] . ")"
        ];
    }
    
    /**
     * Run full diagnostic across all dimensions
     */
    public function runFullDiagnostic(?callable $answerCallback = null): array
    {
        $results = [];
        $questionCount = 0;
        
        foreach (array_keys(self::DIMENSIONS) as $dim) {
            $result = $this->findBreakPoint($dim, $answerCallback);
            $results[$dim] = $result;
            $questionCount += count($result['scores']) * 5; // 5 questions per cell
        }
        
        return [
            'dimensions' => $results,
            'questions_asked' => $questionCount,
            'summary' => $this->summarize($results),
        ];
    }
    
    /**
     * Summarize results
     */
    private function summarize(array $results): array
    {
        $breaks = [];
        $solid = [];
        
        foreach ($results as $dim => $result) {
            if ($result['break'] === null) {
                $solid[] = $dim;
            } else {
                $breaks[$result['break']][] = $dim;
            }
        }
        
        // Find most common break layer
        $primaryBreak = null;
        $maxCount = 0;
        foreach ($breaks as $layer => $dims) {
            if (count($dims) > $maxCount) {
                $maxCount = count($dims);
                $primaryBreak = $layer;
            }
        }
        
        return [
            'solid_dimensions' => $solid,
            'breaks_by_layer' => $breaks,
            'primary_break_layer' => $primaryBreak,
            'primary_break_name' => $primaryBreak ? self::LAYERS[$primaryBreak] : null,
        ];
    }
    
    private function log(string $message): void
    {
        if ($this->verbose) {
            echo $message . "\n";
        }
    }
    
    /**
     * Get dimension info
     */
    public static function getDimensions(): array
    {
        return self::DIMENSIONS;
    }
    
    /**
     * Get layer info
     */
    public static function getLayers(): array
    {
        return self::LAYERS;
    }
}
