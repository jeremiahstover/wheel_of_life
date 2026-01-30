# Wheel of Life Assessment Data

This folder contains the question pool for the Wheel of Life assessment system.

## Dual Organization

The same 360 questions are organized two ways for different access patterns:

### `/layers/` — Horizontal Slices

8 files, 45 questions each. One file per layer of the personal development model.

**Use for**: Deep-dive assessment on a single layer. When you've identified a weak layer and want to explore all 9 dimensions at that level.

```
Layer 1: Order         → Do you believe patterns exist?
Layer 2: Causality     → Do you see cause → effect?
Layer 3: Responsibility → Do you own it?
Layer 4: Discipline    → Are you consistently doing it?
Layer 5: Skill         → Are you getting better?
Layer 6: Resources     → Is skill producing surplus?
Layer 7: Fellowship    → Mutual investment, transparency, sharpening?
Layer 8: Sacrifice     → Pouring out without expectation of return?
```

### `/dimensions/` — Vertical Slices

9 files, 40 questions each. One file per dimension of the tripartite being.

**Use for**: Diagnostic assessment using the drunkard's walk algorithm. Navigate across layers within one dimension to find the break point.

```
SPIRIT
  Communion   → Receives (relationship with God)
  Conscience  → Executes (moral action)
  Holiness    → State (spiritual health)

SOUL
  Mind        → Receives (knowledge, wisdom)
  Will        → Executes (choices, action)
  Emotions    → State (emotional health)

BODY
  Sustenance  → Receives (fuel, recovery)
  Capability  → Executes (strength, function)
  Wholeness   → State (integrated health)
```

## The Overlap

These are the **same questions** organized differently:

- `layers/discipline.json` dimension 5 (Will) questions
- `dimensions/will.json` layer 4 (Discipline) questions

**Same content. Different index.**

Think of a spreadsheet:
- Layers = rows
- Dimensions = columns
- Questions = cells

You can read by row or by column. Same data, different traversal.

## Question ID Format

Questions use a compound ID: `{layer}.{dimension}.{letter}`

Example: `4.5.C` = Layer 4 (Discipline), Dimension 5 (Will), Question C

This allows cross-referencing between the two organizations.

## Remediation Principle

When a layer is weak, the fix is usually in the layer below. The drunkard's walk algorithm exploits this by navigating DOWN from weakness until it finds solid ground.

```
Weakness at Layer N + Strength at Layer N-1 = Focus on Layer N
```

The diagnostic app uses `/dimensions/` to efficiently find this break point across all 9 dimensions simultaneously.
