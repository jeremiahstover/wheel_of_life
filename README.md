# Wheel of Life Assessment Framework

A comprehensive personal development assessment system based on the 8-layer model of growth and the tripartite nature of human beings (Spirit, Soul, Body).

**Live demo**: [tripartite.us](https://tripartite.us)

## The Framework

### 8 Layers (Foundation → Culmination)

| Layer | Name | Core Question | Opposite |
|-------|------|---------------|----------|
| 1 | Order | Do you believe patterns exist? | Nihilism |
| 2 | Causality | Do you see cause → effect? | Fatalism |
| 3 | Responsibility | Do you own it as yours? | Entitlement |
| 4 | Discipline | Are you consistently doing it? | Hedonism |
| 5 | Skill | Are you getting better? | Incompetence |
| 6 | Resources | Is skill producing surplus? | Poverty |
| 7 | Fellowship | Mutual investment, transparency, sharpening? | Isolation |
| 8 | Sacrifice | Pouring out without expectation of return? | Hoarding |

### 9 Dimensions (Tripartite Model)

| Category | Function | Dimension |
|----------|----------|-----------|
| **Spirit** | Receives | Communion |
| | Executes | Conscience |
| | State | Holiness |
| **Soul** | Receives | Mind |
| | Executes | Will |
| | State | Emotions |
| **Body** | Receives | Sustenance |
| | Executes | Capability |
| | State | Wholeness |

### The Remediation Principle

When a layer is weak, fix the layer below. Keep going down until you find solid ground.

```
Layer N:   WEAK   ← This is where the house is wobbling
Layer N-1: STRONG ← This is solid ground
           ↑
        FOCUS HERE
```

## Project Structure

```
wheel_of_life/
├── data/                    # Shared question pool (360 questions)
│   ├── layers/              # Organized by layer (8 files, 45 questions each)
│   └── dimensions/          # Organized by dimension (9 files, 40 questions each)
│
├── apps/
│   ├── cli/                 # Original command-line tool
│   ├── html/                # Static HTML (deployed to tripartite.us)
│   └── diagnostic/          # NEW: Drunkard's walk algorithm
│
└── README.md
```

## Applications

### Static HTML (`/apps/html/`)
Single-page assessment, currently deployed at [tripartite.us](https://tripartite.us). No server required.

### CLI Tool (`/apps/cli/`)
PHP command-line assessment with result persistence.

### Diagnostic Tool (`/apps/diagnostic/`)
Optimized assessment using the "drunkard's walk" algorithm. Finds your break point across all layers and dimensions in ~45 questions instead of 360.

## Data Organization

The same 360 questions are organized two ways:

- **`/data/layers/`** — Horizontal slices. One file per layer, all 9 dimensions. Use for deep-dive on a specific layer.

- **`/data/dimensions/`** — Vertical slices. One file per dimension, all 8 layers. Use for the drunkard's walk diagnostic.

See `/data/README.md` for details on the dual organization.

## Scoring

- **Questions**: 1-5 scale (Almost Never → Almost Always)
- **Dimension Score**: (sum of 5 questions / 5) × 2 = 1-10 scale

| Score | Level | Meaning |
|-------|-------|---------|
| 1-2 | Crisis | Immediate attention required |
| 3-4 | Below Baseline | Foundation cracked |
| 5-6 | Maintaining | Functional but not growing |
| 7-8 | Target Zone | Solid ground |
| 9-10 | Exceptional | Ready to build higher |

## Philosophy

This framework is grounded in the conviction that:

1. **Integration, not separation** — Life, work, and ministry are one
2. **Layers build on layers** — You can't skip foundation work
3. **The goal is sacrifice** — Build resources so you can pour them out for others
4. **"Give your second cloak, not your first"** — Sacrifice from surplus, not self-destruction

See the full philosophy documentation in the source repository.
