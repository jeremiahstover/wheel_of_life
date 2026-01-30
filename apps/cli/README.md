# CLI Assessment Tool

The original command-line assessment tool for the Wheel of Life framework.

## Overview

A PHP-based CLI application that walks through the full assessment question by question, storing results and providing analysis.

## Structure

```
cli/
├── quiz.php          # Entry point
├── logic/            # Business rules and use cases
│   ├── rules/
│   └── usecases/
├── presentation/     # Output formatting
├── storage/          # Result persistence
└── README.md
```

## Usage

```bash
php quiz.php
```

## Data Source

Questions are loaded from `../../data/layers/` — the layer-organized JSON files.

## Notes

This was the first implementation of the assessment system. It uses the full 360-question approach, walking through one layer at a time.

For the optimized diagnostic approach using the drunkard's walk algorithm, see `/apps/diagnostic/`.
