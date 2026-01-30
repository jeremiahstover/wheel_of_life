# Assessment Questions

72 cell files containing 5 questions each.

## File Naming

`{dimension}{layer}.json`

- **Dimension**: A-I (see mapping below)
- **Layer**: 1-8 (see mapping below)

Example: `E4.json` = Will (E) at Discipline (4)

## Address Scheme

| Level | Format | Example | Meaning |
|-------|--------|---------|---------|
| Dimension | Letter (A-I) | `E` | Will |
| Layer | Number (1-8) | `4` | Discipline |
| Cell | `{dim}{layer}` | `E4` | Will at Discipline |
| Question | `{cell}{a-e}` | `E4c` | Third question in that cell |
| Response | `{question}{1-5}` | `E4c3` | Answered "3" (Sometimes) |

Pattern: **Letter-Number-Letter-Number** — categories alternate with scales.

## Dimensions

| Code | Name | Category | Function |
|------|------|----------|----------|
| A | Communion | Spirit | Receives |
| B | Conscience | Spirit | Executes |
| C | Holiness | Spirit | State |
| D | Mind | Soul | Receives |
| E | Will | Soul | Executes |
| F | Emotions | Soul | State |
| G | Sustenance | Body | Receives |
| H | Capability | Body | Executes |
| I | Wholeness | Body | State |

## Layers

| Code | Name | Definition | Full Answers? |
|------|------|------------|---------------|
| 1 | Order | Reality has patterns that can be discovered and used. | ✗ |
| 2 | Causality | Actions have consequences; you reap what you sow. | ✗ |
| 3 | Responsibility | If it's in your life, it's yours to address. | ✗ |
| 4 | Discipline | Do what needs doing, especially when you don't feel like it. | ✓ |
| 5 | Skill | Get measurably better at what matters. | ✗ |
| 6 | Resources | Margin to steward and invest. | ✗ |
| 7 | Fellowship | Mutual investment, transparency, and sharpening. | ✗ |
| 8 | Sacrifice | Pour out for others with no expectation of return. | ✗ |

## File Format

```json
{
  "cell": "E4",
  "dimension": {
    "code": "E",
    "name": "Will",
    "category": "Soul",
    "function": "Executes"
  },
  "layer": {
    "code": 4,
    "name": "Discipline",
    "definition": "Do what needs doing, especially when you don't feel like it."
  },
  "questions": [
    {
      "id": "E4a",
      "text": "When I commit to doing something...",
      "voice": "Jordan Peterson",
      "principle": "Integrity with yourself is the foundation",
      "answers": {
        "1": "I regularly abandon commitments when they get hard...",
        "2": "I follow through on easy things but back out...",
        "3": "I push through sometimes, but difficulty often wins...",
        "4": "I usually finish what I start...",
        "5": "Once I commit, I execute..."
      }
    },
    ...
  ]
}
```

Note: The `answers` field is only present for Layer 4 (Discipline) currently. Other layers will be updated.

## Navigation

To traverse layers within a dimension:
- Down: decrement layer number (E6 → E5 → E4)
- Up: increment layer number (E4 → E5 → E6)

The drunkard's walk finds the break point by binary searching the layer axis.
