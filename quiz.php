#!/usr/bin/env php
<?php
declare(strict_types=1);

/**
 * Wheel of Life - Discipline Assessment
 * 
 * A CLI quiz that runs the assessment, generates a summary report,
 * and provides recommendations based on scores.
 * 
 * Usage:
 *   php quiz.php          Run the full quiz
 *   php quiz.php --report Show last result without taking quiz
 *   php quiz.php --help   Show this help
 */

// Autoload all classes
$baseDir = __DIR__;
require_once $baseDir . '/data/entities/Entities.php';
require_once $baseDir . '/data/persistence/Persistence.php';
require_once $baseDir . '/logic/rules/ScoringRules.php';
require_once $baseDir . '/logic/usecases/UseCases.php';
require_once $baseDir . '/presentation/CliPresenter.php';

// Configuration
$config = [
    'data_path' => $baseDir . '/data',
    'storage_path' => $baseDir . '/storage',
    'assessment_file' => 'discipline-assessment.json',
];

/**
 * Main application
 */
function main(array $args, array $config): int {
    $showReportOnly = in_array('--report', $args);
    $showHelp = in_array('--help', $args) || in_array('-h', $args);

    if ($showHelp) {
        showHelp();
        return 0;
    }

    try {
        // Initialize services
        $loader = new AssessmentLoader($config['data_path']);
        $storage = new ResultStorage($config['storage_path']);
        $assessment = $loader->load($config['assessment_file']);

        if ($showReportOnly) {
            return showLastReport($assessment, $storage);
        }

        return runQuiz($assessment, $storage);
        
    } catch (Exception $e) {
        echo "\nError: " . $e->getMessage() . "\n";
        return 1;
    }
}

function showHelp(): void {
    echo <<<HELP

Wheel of Life - Discipline Assessment
=====================================

Usage:
  php quiz.php          Run the full 45-question assessment
  php quiz.php --report Show your most recent results without retaking
  php quiz.php --help   Show this help message

The assessment covers 9 dimensions across Spirit, Soul, and Body:

  Spirit: Connection to God, Conscience, Purpose/Calling
  Soul:   Mind, Will, Emotions
  Body:   Fuel & Recovery, Capacity & Function, Health & Wholeness

After completing the quiz, you'll receive:
  - Scores for each dimension (1-10 scale)
  - Identification of crisis areas and strengths
  - Personalized recommendations with scripture

Results are saved to the /storage folder for tracking progress over time.


HELP;
}

function showLastReport(Assessment $assessment, ResultStorage $storage): int {
    $result = $storage->loadLatest();
    
    if (!$result) {
        echo "\nNo previous results found. Run the quiz first: php quiz.php\n";
        return 1;
    }

    // Get previous result for comparison (if exists)
    $allResults = $storage->loadAll();
    $previousResult = count($allResults) > 1 ? $allResults[1] : null;

    $reporter = new ReportGenerator($assessment, $result, $previousResult);
    
    CliPresenter::clear();
    CliPresenter::showSummary($reporter->generateSummary());
    CliPresenter::showRecommendations($reporter->generateRecommendations());
    CliPresenter::showNextSteps($assessment->nextSteps);
    
    return 0;
}

function runQuiz(Assessment $assessment, ResultStorage $storage): int {
    $quiz = new QuizRunner($assessment);
    $totalQuestions = $quiz->getTotalQuestions();
    $questionNum = 0;

    CliPresenter::clear();
    CliPresenter::header($assessment->title);
    
    echo "  {$assessment->layerFocus}\n\n";
    CliPresenter::wrap("Definition: " . $assessment->definition, 2);
    echo "\n  This assessment has {$totalQuestions} questions across 9 dimensions.\n";
    echo "  Take your time. Answer honestly based on your actual behavior, not aspirations.\n";
    
    CliPresenter::showResponseScale($assessment->responseScale);
    
    $input = CliPresenter::prompt("  Press Enter to begin (or 'q' to quit): ");
    if (strtolower($input) === 'q') {
        echo "\n  Quiz cancelled.\n";
        return 0;
    }

    // Run through each dimension
    foreach ($assessment->dimensions as $dimension) {
        CliPresenter::clear();
        CliPresenter::showDimensionHeader($dimension, $questionNum + 1);
        
        foreach ($dimension->questions as $question) {
            $questionNum++;
            CliPresenter::showQuestion($questionNum, $totalQuestions, $question);
            
            // Show principle as hint
            if (!empty($question->principle)) {
                echo "  (Principle: {$question->principle})\n";
            }
            
            $answer = CliPresenter::promptInt("  Your answer [1-5]: ", 1, 5);
            $quiz->recordAnswer($question->id, $answer);
        }

        // Brief pause between dimensions
        if ($dimension->id < 9) {
            echo "\n  ✓ Dimension complete. ";
            CliPresenter::prompt("Press Enter for next dimension...");
        }
    }

    // Calculate and display results
    $result = $quiz->calculateResults();
    
    // Save result
    $filepath = $storage->save($result);
    
    // Get previous result for comparison
    $allResults = $storage->loadAll();
    $previousResult = count($allResults) > 1 ? $allResults[1] : null;
    
    // Generate report
    $reporter = new ReportGenerator($assessment, $result, $previousResult);
    
    CliPresenter::clear();
    CliPresenter::showSummary($reporter->generateSummary());
    CliPresenter::showRecommendations($reporter->generateRecommendations());
    CliPresenter::showNextSteps($assessment->nextSteps);
    
    echo "\n  Results saved to: {$filepath}\n";
    echo "\n  Run 'php quiz.php --report' anytime to review.\n\n";
    
    return 0;
}

// Run
exit(main($argv, $config));
