<?php
declare(strict_types=1);

/**
 * Data Entities - Anemic structures for the quiz system
 */

class Question {
    public string $id;
    public string $text;
    public string $voice;
    public string $principle;
    public ?int $answer = null;

    public function __construct(array $data) {
        $this->id = $data['id'];
        $this->text = $data['text'];
        $this->voice = $data['voice'] ?? '';
        $this->principle = $data['principle'] ?? '';
    }
}

class Remediation {
    public string $advice;
    public string $scriptureText;
    public string $scriptureRef;

    public function __construct(array $data) {
        $this->advice = $data['advice'];
        $this->scriptureText = $data['scripture']['text'] ?? '';
        $this->scriptureRef = $data['scripture']['reference'] ?? '';
    }
}

class Dimension {
    public int $id;
    public string $name;
    public string $category;
    public string $description;
    public string $scriptureText;
    public string $scriptureRef;
    /** @var Question[] */
    public array $questions = [];
    public Remediation $remediation;
    public ?float $score = null;

    public function __construct(array $data) {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->category = $data['category'];
        $this->description = $data['description'];
        $this->scriptureText = $data['scripture_anchor']['text'] ?? '';
        $this->scriptureRef = $data['scripture_anchor']['reference'] ?? '';
        
        foreach ($data['questions'] as $q) {
            $this->questions[] = new Question($q);
        }
        
        $this->remediation = new Remediation($data['remediation']);
    }
}

class Assessment {
    public string $title;
    public string $version;
    public string $layerFocus;
    public string $definition;
    /** @var Dimension[] */
    public array $dimensions = [];
    public array $responseScale = [];
    public array $interpretation = [];
    public array $nextSteps = [];

    public function __construct(array $data) {
        $this->title = $data['meta']['title'];
        $this->version = $data['meta']['version'];
        $this->layerFocus = $data['meta']['layer_focus'];
        $this->definition = $data['meta']['definition'];
        $this->responseScale = $data['scoring']['response_scale'];
        $this->interpretation = $data['scoring']['interpretation'];
        $this->nextSteps = $data['results_guidance']['next_steps'];

        foreach ($data['dimensions'] as $dim) {
            $this->dimensions[] = new Dimension($dim);
        }
    }
}

class QuizResult {
    public string $timestamp;
    /** @var array<int, float> dimension_id => score */
    public array $dimensionScores = [];
    /** @var array<string, int> question_id => answer */
    public array $answers = [];
    public float $overallAverage = 0.0;

    public function __construct() {
        $this->timestamp = date('Y-m-d H:i:s');
    }
}
