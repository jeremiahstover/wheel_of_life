<?php
declare(strict_types=1);

/**
 * Data Persistence - Load assessment data and manage result storage
 */

class AssessmentLoader {
    private string $dataPath;

    public function __construct(string $dataPath) {
        $this->dataPath = $dataPath;
    }

    public function load(string $filename): Assessment {
        $filepath = $this->dataPath . '/' . $filename;
        
        if (!file_exists($filepath)) {
            throw new RuntimeException("Assessment file not found: {$filepath}");
        }

        $json = file_get_contents($filepath);
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException("Invalid JSON: " . json_last_error_msg());
        }

        return new Assessment($data);
    }
}

class ResultStorage {
    private string $storagePath;

    public function __construct(string $storagePath) {
        $this->storagePath = $storagePath;
        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0755, true);
        }
    }

    public function save(QuizResult $result): string {
        $filename = 'result_' . date('Y-m-d_His') . '.json';
        $filepath = $this->storagePath . '/' . $filename;

        $data = [
            'timestamp' => $result->timestamp,
            'dimension_scores' => $result->dimensionScores,
            'answers' => $result->answers,
            'overall_average' => $result->overallAverage,
        ];

        file_put_contents($filepath, json_encode($data, JSON_PRETTY_PRINT));
        return $filepath;
    }

    public function loadLatest(): ?QuizResult {
        $files = glob($this->storagePath . '/result_*.json');
        if (empty($files)) {
            return null;
        }

        // Sort by filename (contains timestamp)
        rsort($files);
        return $this->loadFromFile($files[0]);
    }

    public function loadAll(): array {
        $files = glob($this->storagePath . '/result_*.json');
        rsort($files);
        
        $results = [];
        foreach ($files as $file) {
            $results[] = $this->loadFromFile($file);
        }
        return $results;
    }

    private function loadFromFile(string $filepath): QuizResult {
        $data = json_decode(file_get_contents($filepath), true);
        
        $result = new QuizResult();
        $result->timestamp = $data['timestamp'];
        $result->dimensionScores = $data['dimension_scores'];
        $result->answers = $data['answers'];
        $result->overallAverage = $data['overall_average'];
        
        return $result;
    }
}
