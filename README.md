# Wheel of Life - Discipline Assessment

Assessment tool for the Discipline layer (Layer 4 of 8) from the Wheel of Life framework.

## Two Interfaces

### Web Interface (Recommended)

Single HTML file, no server required. Results stored in URL for easy bookmarking and sharing.

**To use:**
1. Enable GitHub Pages on this repo (Settings → Pages → Deploy from main branch)
2. Visit: `https://jeremiahstover.github.io/wheel_of_life/`

Or open `index.html` locally with a web server:
```bash
# Python
python -m http.server 8000

# PHP
php -S localhost:8000

# Node
npx serve
```

**Features:**
- One question per page with progress indicator
- Keyboard shortcuts (1-5 to answer, Backspace to go back)
- Results stored in URL hash - bookmark or share the link
- Three-tab results view:
  - **Graph**: Radar chart visualization of all 9 dimensions
  - **Conclusion**: Score bars, crisis areas, strength areas
  - **Suggestions**: Top 3 priorities with remediation advice and scripture

### CLI Interface

Vanilla PHP, no dependencies.

```bash
php quiz.php           # Take the assessment
php quiz.php --report  # View last saved results
php quiz.php --help    # Help
```

Results saved to `/storage/result_*.json` for tracking progress over time.

## The Assessment

**Definition of Discipline:** Consistently making yourself do what needs to be done, especially when you don't feel like doing it.

### Tripartite Model v2 (Receives/Executes/State)

| Category | Function | Dimension | Focus |
|----------|----------|-----------|-------|
| Spirit | Receives | Communion | Receiving from God through spiritual practices |
| Spirit | Executes | Conscience | Acting on moral conviction |
| Spirit | State | Holiness | Maintaining spiritual purity, sanctification |
| Soul | Receives | Mind | Learning, intellectual growth |
| Soul | Executes | Will | Follow-through, integrity with self |
| Soul | State | Emotions | Processing feelings, managing actions |
| Body | Receives | Sustenance | Nutrition, sleep, environment |
| Body | Executes | Capability | Exercise, movement, physical ability |
| Body | State | Wholeness | Preventive care, integrated wellness |

### Scoring

- **Questions**: 1-5 scale (Almost Never → Almost Always)
- **Dimension Score**: (sum / 5) × 2 = 1-10 scale

| Score | Level | Meaning |
|-------|-------|---------|
| 1-2 | Crisis | Immediate attention required |
| 3-4 | Below Baseline | Needs focused work |
| 5-6 | Maintaining | Functional but not growing |
| 7-8 | Target Zone | Disciplines established |
| 9-10 | Exceptional | Approaching mastery |

## Project Structure (DLPR)

```
wheel_of_life/
├── index.html                    # Web interface (single file)
├── quiz.php                      # CLI entry point
├── data/
│   ├── discipline-assessment.json  # Source data
│   ├── discipline-assessment.md    # Human-readable reference
│   ├── entities/Entities.php
│   └── persistence/Persistence.php
├── logic/
│   ├── rules/ScoringRules.php
│   └── usecases/UseCases.php
├── presentation/CliPresenter.php
└── storage/                      # CLI results (gitignored)
```

## The Remediation Principle

If Discipline is weak, shore up Responsibility. Go down the layers until you find solid ground:

```
Discipline ← Responsibility ← Causality ← Order
```

## URL Format

Web results are encoded in the URL hash:
```
https://example.com/index.html#r=MzQ1MzQ1MzQ1MzQ1MzQ1MzQ1MzQ1MzQ1MzQ1MzQ1MzQ1
```

The `r=` parameter contains base64-encoded answers (45 digits, each 1-5). This allows:
- Bookmarking results
- Sharing via link
- No server-side storage needed
- Privacy (results never leave the browser)
