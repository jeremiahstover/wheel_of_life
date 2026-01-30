<?php
declare(strict_types=1);

/**
 * Presentation - CLI output formatting
 */

class CliPresenter {
    private const WIDTH = 78;

    public static function clear(): void {
        if (PHP_OS_FAMILY === 'Windows') {
            system('cls');
        } else {
            system('clear');
        }
    }

    public static function header(string $text): void {
        echo "\n" . str_repeat('=', self::WIDTH) . "\n";
        echo self::center($text) . "\n";
        echo str_repeat('=', self::WIDTH) . "\n\n";
    }

    public static function subheader(string $text): void {
        echo "\n" . str_repeat('-', self::WIDTH) . "\n";
        echo "  " . $text . "\n";
        echo str_repeat('-', self::WIDTH) . "\n";
    }

    public static function center(string $text): string {
        $padding = (int) ((self::WIDTH - strlen($text)) / 2);
        return str_repeat(' ', max(0, $padding)) . $text;
    }

    public static function wrap(string $text, int $indent = 0): void {
        $prefix = str_repeat(' ', $indent);
        $words = explode(' ', $text);
        $line = $prefix;

        foreach ($words as $word) {
            if (strlen($line) + strlen($word) + 1 > self::WIDTH) {
                echo $line . "\n";
                $line = $prefix . $word;
            } else {
                $line .= ($line === $prefix ? '' : ' ') . $word;
            }
        }
        if ($line !== $prefix) {
            echo $line . "\n";
        }
    }

    public static function scripture(string $text, string $reference): void {
        echo "\n";
        self::wrap("\"" . $text . "\"", 4);
        echo str_repeat(' ', 4) . "— " . $reference . "\n";
    }

    public static function scoreBar(float $score, int $width = 40): string {
        $filled = (int) round(($score / 10) * $width);
        $empty = $width - $filled;
        
        $color = match(true) {
            $score <= 2 => "\033[31m",  // red
            $score <= 4 => "\033[33m",  // yellow
            $score <= 6 => "\033[93m",  // bright yellow
            $score <= 8 => "\033[32m",  // green
            default => "\033[36m",       // cyan
        };
        $reset = "\033[0m";

        return $color . str_repeat('█', $filled) . $reset . 
               str_repeat('░', $empty) . 
               sprintf(" %.1f/10", $score);
    }

    public static function prompt(string $message): string {
        echo $message;
        return trim(fgets(STDIN) ?: '');
    }

    public static function promptInt(string $message, int $min, int $max): int {
        while (true) {
            $input = self::prompt($message);
            
            if (is_numeric($input)) {
                $value = (int) $input;
                if ($value >= $min && $value <= $max) {
                    return $value;
                }
            }
            echo "  Please enter a number between {$min} and {$max}.\n";
        }
    }

    public static function showResponseScale(array $scale): void {
        echo "\n  Response Scale:\n";
        foreach ($scale as $num => $info) {
            echo "    [{$num}] {$info['label']} ({$info['range']})\n";
        }
        echo "\n";
    }

    public static function showQuestion(int $num, int $total, Question $question): void {
        echo "\n  Question {$num} of {$total}:\n";
        self::wrap($question->text, 2);
        echo "\n";
    }

    public static function showDimensionHeader(Dimension $dimension, int $qStart): void {
        self::subheader("{$dimension->category}: {$dimension->name}");
        self::wrap($dimension->description, 2);
        self::scripture($dimension->scriptureText, $dimension->scriptureRef);
        echo "\n";
    }

    public static function showSummary(array $summary): void {
        self::header("ASSESSMENT RESULTS");
        
        echo "  Date: {$summary['timestamp']}\n";
        echo "  Overall Score: " . self::scoreBar($summary['overall_average']) . "\n";
        echo "  Level: {$summary['overall_interpretation']['level']} - {$summary['overall_interpretation']['description']}\n";

        // Group by category
        $byCategory = [];
        foreach ($summary['dimensions'] as $dim) {
            $byCategory[$dim['category']][] = $dim;
        }

        foreach ($byCategory as $category => $dimensions) {
            self::subheader($category);
            foreach ($dimensions as $dim) {
                echo "  {$dim['name']}: " . self::scoreBar($dim['score']) . "\n";
                echo "    {$dim['level']} - {$dim['description']}\n\n";
            }
        }

        // Crisis areas
        if (!empty($summary['crisis_areas'])) {
            self::subheader("⚠ CRISIS AREAS (Need Immediate Attention)");
            foreach ($summary['crisis_areas'] as $area) {
                echo "  • {$area['dimension']->name} ({$area['score']}/10)\n";
            }
        }

        // Strength areas
        if (!empty($summary['strength_areas'])) {
            self::subheader("✓ STRENGTH AREAS");
            foreach ($summary['strength_areas'] as $area) {
                echo "  • {$area['dimension']->name} ({$area['score']}/10)\n";
            }
        }

        // Comparison
        if ($summary['comparison']) {
            self::subheader("📊 COMPARISON TO PREVIOUS");
            foreach ($summary['comparison'] as $dimId => $change) {
                $arrow = match($change['direction']) {
                    'improved' => '↑',
                    'declined' => '↓',
                    default => '→',
                };
                $delta = $change['delta'] > 0 ? "+{$change['delta']}" : "{$change['delta']}";
                echo "  Dimension {$dimId}: {$change['previous']} → {$change['current']} ({$arrow} {$delta})\n";
            }
        }
    }

    public static function showRecommendations(array $recommendations): void {
        self::header("NEXT STEPS & RECOMMENDATIONS");

        foreach ($recommendations as $rec) {
            echo "\n  #{$rec['priority']} FOCUS: {$rec['dimension']} ({$rec['category']})\n";
            echo "  Current: {$rec['current_score']}/10 ({$rec['level']})\n\n";
            
            echo "  Advice:\n";
            self::wrap($rec['advice'], 4);
            
            if (!empty($rec['scripture']['text'])) {
                self::scripture($rec['scripture']['text'], $rec['scripture']['reference']);
            }

            echo "\n  Anchor Scripture:\n";
            self::scripture($rec['anchor_scripture']['text'], $rec['anchor_scripture']['reference']);
            
            echo str_repeat('-', self::WIDTH) . "\n";
        }

        echo "\n  The Remediation Principle:\n";
        self::wrap("If Discipline is weak, shore up Responsibility. Go down the layers until you find solid ground: Discipline ← Responsibility ← Causality ← Order", 4);
        echo "\n";
    }

    public static function showNextSteps(array $steps): void {
        self::subheader("STANDARD NEXT STEPS");
        foreach ($steps as $i => $step) {
            echo "  " . ($i + 1) . ". {$step}\n";
        }
    }
}
