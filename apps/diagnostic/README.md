# Diagnostic Assessment Tool

A PHP application that uses the "drunkard's walk" algorithm to efficiently find your break point across all 8 layers and 9 dimensions.

## The Problem

Full assessment = 360 questions = 90+ minutes.

Most people don't need to deeply assess every layer. They need to find **where the foundation cracked**.

## The Solution: Drunkard's Walk

Binary search adapted for hierarchical constraints.

### The Remediation Principle

Layers build on each other. If Layer 6 is weak, the cause is usually in Layer 5 (or below). The goal isn't to deeply understand the weak layer — it's to find the **break point**:

```
Layer N:   WEAK   ← This is where the house is wobbling
Layer N-1: STRONG ← This is solid ground
           ↑
        FOCUS HERE (Layer N is your break point)
```

### The Algorithm

1. **Probe Layer 3 and Layer 6** (all 9 dimensions)
   - This splits the 8-layer stack roughly in half

2. **Navigate based on results:**
   - Both HIGH → go up (probe 7, 8)
   - Both LOW → go down (probe 1, 2)
   - 3 HIGH, 6 LOW → break is in middle (probe 4, 5)
   - 3 LOW, 6 HIGH → anomaly, investigate

3. **Find the floor:**
   - Keep going down until you hit a STRONG layer
   - The layer immediately ABOVE that is your focus

4. **Confirm:**
   - Quick check that the floor is actually solid
   - Then you know where to work

### Question Count

| Approach | Questions | Time |
|----------|-----------|------|
| Full assessment | 360 | 90+ min |
| Drunkard's walk | ~45 | 10-15 min |

**8x reduction** while still covering all 9 dimensions.

## Data Source

Questions loaded from `../../data/dimensions/` — the dimension-organized JSON files.

Each file contains one dimension across all 8 layers, enabling the vertical traversal the algorithm requires.

## Structure

```
diagnostic/
├── index.php         # Entry point
├── engine.php        # Walk algorithm
├── results.php       # Result display and analysis
├── templates/        # UI templates
│   ├── question.php
│   └── results.php
└── README.md
```

## Usage

```bash
# Serve with PHP built-in server
php -S localhost:8080

# Open browser to localhost:8080/apps/diagnostic/
```

## Output

The diagnostic produces:
1. **Break point** for each dimension (which layer to focus on)
2. **Overall pattern** (are breaks clustered at one layer across dimensions?)
3. **Remediation guidance** (what to do about it)

## Philosophy

Don't waste questions deeply probing Layer 6 if the real problem is Layer 3. Fix Layer 3, and 4, 5, 6, 7, 8 often resolve themselves.

Find the break. Fix the foundation. Build from there.
