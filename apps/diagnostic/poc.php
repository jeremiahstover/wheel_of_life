#!/usr/bin/env php
<?php
/**
 * Diagnostic Engine POC Runner
 * 
 * Usage:
 *   php poc.php                    # Run full diagnostic (simulated answers)
 *   php poc.php --dim=E            # Run single dimension
 *   php poc.php --interactive      # Interactive mode (you answer)
 *   php poc.php --scenario=crisis  # Run with preset scenario
 */

require_once __DIR__ . '/engine.php';

$dataPath = __DIR__ . '/../../data/questions';

// Parse arguments
$options = getopt('', ['dim:', 'interactive', 'scenario:', 'quiet', 'help']);

if (isset($options['help'])) {
    echo <<<HELP
Drunkard's Walk Diagnostic Engine - POC

Usage: php poc.php [options]

Options:
  --dim=X          Run single dimension (A-I)
  --interactive    Answer questions interactively
  --scenario=NAME  Use preset scenario (crisis, solid, mixed, discipline)
  --quiet          Suppress verbose output
  --help           Show this help

Scenarios:
  crisis     - Everything weak (foundation broken)
  solid      - Everything strong (no break points)
  mixed      - Varies by dimension
  discipline - Break at Layer 4 across most dimensions

HELP;
    exit(0);
}

// Scenario presets (returns score for given dimension/layer)
$scenarios = [
    'crisis' => fn($dim, $layer) => 2.0 + (rand(0, 10) / 10), // All weak
    'solid' => fn($dim, $layer) => 4.0 + (rand(0, 10) / 10),  // All strong
    'mixed' => function($dim, $layer) {
        // Spirit strong through L6, Soul breaks at L5, Body breaks at L4
        $category = DiagnosticEngine::getDimensions()[$dim]['category'];
        $threshold = match($category) {
            'Spirit' => 7,
            'Soul' => 5,
            'Body' => 4,
        };
        return $layer < $threshold ? 4.2 : 2.5;
    },
    'discipline' => function($dim, $layer) {
        // Most break at Layer 4 (Discipline)
        // L1-3 strong, L4+ weak
        return $layer <= 3 ? 4.0 + (rand(0, 5) / 10) : 2.5 + (rand(0, 5) / 10);
    },
];

// Create engine
$engine = new DiagnosticEngine($dataPath);

if (isset($options['quiet'])) {
    $engine->setVerbose(false);
}

// Build answer callback based on mode
$answerCallback = null;

if (isset($options['interactive'])) {
    // Interactive mode - ask user for answers
    $answerCallback = function($question, $dim, $layer) {
        echo "\n" . str_repeat('-', 60) . "\n";
        echo "Cell: {$dim}{$layer}\n";
        echo "Question: {$question['text']}\n\n";
        
        foreach ($question['answers'] as $num => $text) {
            echo "  [{$num}] {$text}\n";
        }
        
        echo "\nYour answer (1-5): ";
        $answer = (int) trim(fgets(STDIN));
        return max(1, min(5, $answer));
    };
} elseif (isset($options['scenario'])) {
    $scenarioName = $options['scenario'];
    if (!isset($scenarios[$scenarioName])) {
        echo "Unknown scenario: {$scenarioName}\n";
        echo "Available: " . implode(', ', array_keys($scenarios)) . "\n";
        exit(1);
    }
    
    // Scenario mode - predetermined scores
    $scenarioFn = $scenarios[$scenarioName];
    $answerCallback = function($question, $dim, $layer) use ($scenarioFn) {
        // Convert desired cell score to individual answer
        $targetScore = $scenarioFn($dim, $layer);
        // Add small variance per question
        $answer = round($targetScore + (rand(-5, 5) / 10));
        return max(1, min(5, $answer));
    };
    
    echo "Running scenario: {$scenarioName}\n";
}

// Run diagnostic
echo "\n" . str_repeat('=', 60) . "\n";
echo "DRUNKARD'S WALK DIAGNOSTIC ENGINE - POC\n";
echo str_repeat('=', 60) . "\n";

if (isset($options['dim'])) {
    // Single dimension
    $dim = strtoupper($options['dim']);
    if (!array_key_exists($dim, DiagnosticEngine::getDimensions())) {
        echo "Invalid dimension: {$dim}\n";
        echo "Valid: A, B, C, D, E, F, G, H, I\n";
        exit(1);
    }
    
    $result = $engine->findBreakPoint($dim, $answerCallback);
    
    echo "\n" . str_repeat('-', 40) . "\n";
    echo "RESULT FOR DIMENSION {$dim}\n";
    echo str_repeat('-', 40) . "\n";
    echo "Floor:   Layer " . ($result['floor'] ?: 'NONE') . "\n";
    echo "Break:   Layer " . ($result['break'] ?: 'NONE') . "\n";
    echo "Message: {$result['message']}\n";
    echo "Cells probed: " . count($result['scores']) . " (" . (count($result['scores']) * 5) . " questions)\n";
    
} else {
    // Full diagnostic
    $results = $engine->runFullDiagnostic($answerCallback);
    
    echo "\n" . str_repeat('=', 60) . "\n";
    echo "DIAGNOSTIC SUMMARY\n";
    echo str_repeat('=', 60) . "\n";
    
    echo "\nQuestions asked: {$results['questions_asked']} (vs 360 for full assessment)\n";
    echo "Efficiency: " . round((1 - $results['questions_asked'] / 360) * 100) . "% reduction\n";
    
    echo "\n--- Break Points by Dimension ---\n";
    foreach ($results['dimensions'] as $dim => $result) {
        $info = DiagnosticEngine::getDimensions()[$dim];
        $breakLabel = $result['break'] 
            ? "L{$result['break']} (" . DiagnosticEngine::getLayers()[$result['break']] . ")"
            : "SOLID";
        printf("  %s %-12s [%s]: %s\n", 
            $dim, 
            $info['name'], 
            $info['category'],
            $breakLabel
        );
    }
    
    echo "\n--- Pattern Analysis ---\n";
    $summary = $results['summary'];
    
    if (!empty($summary['solid_dimensions'])) {
        echo "Solid (no break): " . implode(', ', $summary['solid_dimensions']) . "\n";
    }
    
    if (!empty($summary['breaks_by_layer'])) {
        echo "Breaks by layer:\n";
        ksort($summary['breaks_by_layer']);
        foreach ($summary['breaks_by_layer'] as $layer => $dims) {
            $layerName = DiagnosticEngine::getLayers()[$layer];
            echo "  L{$layer} ({$layerName}): " . implode(', ', $dims) . "\n";
        }
    }
    
    if ($summary['primary_break_layer']) {
        echo "\nPRIMARY FOCUS: Layer {$summary['primary_break_layer']} ({$summary['primary_break_name']})\n";
        echo "This layer has the most break points across dimensions.\n";
        echo "Fix this layer first - higher layers may self-correct.\n";
    }
}

echo "\n";
