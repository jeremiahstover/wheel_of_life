# Wheel of Life - Discipline Assessment

A CLI PHP application that runs the Discipline layer assessment from the Wheel of Life framework.

## Requirements

- PHP 8.1+
- No external dependencies (vanilla PHP)

## Usage

```bash
# Run the full 45-question assessment
php quiz.php

# View your most recent results without retaking
php quiz.php --report

# Help
php quiz.php --help
```

## What It Does

1. **Runs the Quiz**: 45 questions across 9 dimensions (Spirit, Soul, Body)
2. **Generates Summary**: Scores per dimension on 1-10 scale with interpretation
3. **Provides Recommendations**: Prioritized next steps with remediation advice and scripture

## Structure (DLPR)

```
wheel_of_life/
├── quiz.php                      # Entry point
├── data/
│   ├── discipline-assessment.json  # Source data
│   ├── entities/
│   │   └── Entities.php          # Anemic structures
│   └── persistence/
│       └── Persistence.php       # JSON loader, result storage
├── logic/
│   ├── rules/
│   │   └── ScoringRules.php      # Scoring calculations
│   └── usecases/
│       └── UseCases.php          # Quiz runner, report generator
├── presentation/
│   └── CliPresenter.php          # CLI output formatting
└── storage/                      # Saved results (auto-created)
```

## Scoring

- Questions: 1-5 scale (Almost Never → Almost Always)
- Dimension Score: (sum / 5) * 2 = 1-10 scale

### Interpretation

| Score | Level           | Meaning                        |
|-------|-----------------|--------------------------------|
| 1-2   | Crisis          | Immediate attention required   |
| 3-4   | Below Baseline  | Needs focused work             |
| 5-6   | Maintaining     | Functional but not growing     |
| 7-8   | Target Zone     | Disciplines established        |
| 9-10  | Exceptional     | Approaching mastery            |

## The 9 Dimensions

| Category | Dimension              | Focus                              |
|----------|------------------------|------------------------------------||
| Spirit   | Connection to God      | Communion through spiritual practices |
| Spirit   | Conscience             | Acting on moral conviction         |
| Spirit   | Purpose/Calling        | Staying aligned, resisting distractions |
| Soul     | Mind                   | Learning, intellectual growth      |
| Soul     | Will                   | Follow-through, integrity with self |
| Soul     | Emotions               | Processing feelings, managing actions |
| Body     | Fuel & Recovery        | Nutrition, sleep, environment      |
| Body     | Capacity & Function    | Exercise, movement, physical ability |
| Body     | Health & Wholeness     | Preventive care, integrated wellness |

## Progress Tracking

Results are automatically saved to `/storage/result_YYYY-MM-DD_HHMMSS.json`. 

When you retake the assessment, the report compares your current scores to your previous attempt.

## The Remediation Principle

If Discipline is weak, shore up Responsibility. Go down the layers until you find solid ground:

```
Discipline ← Responsibility ← Causality ← Order
```
