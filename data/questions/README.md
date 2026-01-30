# Assessment Questions

72 cell files containing 5 questions each.

## File Naming

`{dimension}{layer}.json`

- **Dimension**: A-I (see mapping below)
- **Layer**: 1-8 (see mapping below)

Example: `E4.json` = Will (E) at Discipline (4)

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

| Code | Name | Definition |
|------|------|------------|
| 1 | Order | Reality has patterns that can be discovered and used. |
| 2 | Causality | Actions have consequences; you reap what you sow. |
| 3 | Responsibility | If it's in your life, it's yours to address. |
| 4 | Discipline | Do what needs doing, especially when you don't feel like it. |
| 5 | Skill | Get measurably better at what matters. |
| 6 | Resources | Margin to steward and invest. |
| 7 | Fellowship | Mutual investment, transparency, and sharpening. |
| 8 | Sacrifice | Pour out for others with no expectation of return. |

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
      "id": "E4.A",
      "text": "...",
      "voice": "...",
      "principle": "..."
    },
    ...
  ]
}
```

## Navigation

To traverse layers within a dimension:
- Down: decrement layer number (E6 → E5 → E4)
- Up: increment layer number (E4 → E5 → E6)

The drunkard's walk finds the break point by binary searching the layer axis.
