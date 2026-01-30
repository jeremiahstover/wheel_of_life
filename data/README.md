# Wheel of Life Assessment Data

This folder contains the question pool for the Wheel of Life assessment system.

## The Matrix

The assessment covers **8 layers** (foundation → culmination) across **9 dimensions** (tripartite being).

```
     │  1  │  2  │  3  │  4  │  5  │  6  │  7  │  8  │
─────┼─────┼─────┼─────┼─────┼─────┼─────┼─────┼─────┤
  A  │ A1  │ A2  │ A3  │ A4  │ A5  │ A6  │ A7  │ A8  │  Communion
  B  │ B1  │ B2  │ B3  │ B4  │ B5  │ B6  │ B7  │ B8  │  Conscience
  C  │ C1  │ C2  │ C3  │ C4  │ C5  │ C6  │ C7  │ C8  │  Holiness
  D  │ D1  │ D2  │ D3  │ D4  │ D5  │ D6  │ D7  │ D8  │  Mind
  E  │ E1  │ E2  │ E3  │ E4  │ E5  │ E6  │ E7  │ E8  │  Will
  F  │ F1  │ F2  │ F3  │ F4  │ F5  │ F6  │ F7  │ F8  │  Emotions
  G  │ G1  │ G2  │ G3  │ G4  │ G5  │ G6  │ G7  │ G8  │  Sustenance
  H  │ H1  │ H2  │ H3  │ H4  │ H5  │ H6  │ H7  │ H8  │  Capability
  I  │ I1  │ I2  │ I3  │ I4  │ I5  │ I6  │ I7  │ I8  │  Wholeness
```

**72 cells × 5 questions = 360 questions total**

---

## Dimensions (Letters)

| Code | Name | Category | Function | Description |
|------|------|----------|----------|-------------|
| A | Communion | Spirit | Receives | Relationship with God, spiritual intake |
| B | Conscience | Spirit | Executes | Moral action, conviction applied |
| C | Holiness | Spirit | State | Spiritual health, sanctification |
| D | Mind | Soul | Receives | Knowledge, learning, wisdom intake |
| E | Will | Soul | Executes | Choices, follow-through, action |
| F | Emotions | Soul | State | Emotional health, processing feelings |
| G | Sustenance | Body | Receives | Nutrition, rest, environment |
| H | Capability | Body | Executes | Strength, movement, physical action |
| I | Wholeness | Body | State | Integrated health, wellness |

---

## Layers (Numbers)

| Code | Name | Definition | Opposite |
|------|------|------------|----------|
| 1 | Order | Reality has patterns that can be discovered and used. | Nihilism |
| 2 | Causality | Actions have consequences; you reap what you sow. | Fatalism |
| 3 | Responsibility | If it's in your life, it's yours to address. | Entitlement |
| 4 | Discipline | Do what needs doing, especially when you don't feel like it. | Hedonism |
| 5 | Skill | Get measurably better at what matters. | Incompetence |
| 6 | Resources | Margin to steward and invest. | Poverty |
| 7 | Fellowship | Mutual investment, transparency, and sharpening. | Isolation |
| 8 | Sacrifice | Pour out for others with no expectation of return. | Hoarding |

### Layer 3 Note

Responsibility has two aspects:
- **What's mine**: "If it's in your life, it's yours to address."
- **How to hold it**: "Own it — no blame, no excuses."

### Layer 6 Note

Resources span three wealth tiers (from the Ladder of Wealth):
- **Money** — financial margin
- **Time** — capacity margin
- **Relationships** — relational capital

Surplus should flow upward: use money surplus to buy back time; use time surplus to invest in relationships.

---

## Folder Structure

```
data/
├── README.md           # This file
├── questions/          # 72 cell files (A1.json through I8.json)
└── layers/             # Archive - original monolithic layer files
```

### `/questions/` — The Active Data

72 files, one per cell. Each contains 5 questions.

Filename format: `{dimension}{layer}.json` (e.g., `E4.json` = Will at Discipline)

**Use for**: All assessment applications. The drunkard's walk diagnostic navigates by incrementing/decrementing the layer number.

### `/layers/` — Archive

The original 8 monolithic files (45 questions each, all 9 dimensions bundled).

**Use for**: Reference, history. May be removed once migration is complete.

---

## The Remediation Principle

Layers build on each other. When a layer is weak, the cause is usually in the layer below.

```
Layer N:   WEAK   ← Symptom
Layer N-1: STRONG ← Solid ground
           ↑
        FOCUS on Layer N (the break point)
```

Navigate DOWN until you find strength. The first weak layer above solid ground is your focus.

---

## Drunkard's Walk Example

Finding the break point in dimension E (Will):

```
Start: Probe E3 and E6 (Responsibility and Resources)

E6 score: 2 (weak)
E3 score: 4 (strong)

Break is between 3 and 6. Binary search middle:
  Probe E5: 2 (weak) — still looking for floor
  Probe E4: 4 (strong) — found the floor

Floor is E4 (Discipline). Break is E5 (Skill).
Focus: Will at Skill layer.
```

Navigation is just `$layer--` to go down, `$layer++` to go up.

---

## Scoring

- **Questions**: 1-5 scale (Almost Never → Almost Always)
- **Cell Score**: Average of 5 questions (1-5 scale)
- **Threshold**: 3.5 (below = weak, above = strong)

For display, can convert to 1-10: `(average) * 2`
