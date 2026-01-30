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

| Code | Name |
|------|------|
| 1 | Order |
| 2 | Causality |
| 3 | Responsibility |
| 4 | Discipline |
| 5 | Skill |
| 6 | Resources |
| 7 | Fellowship |
| 8 | Sacrifice |

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
    "definition": "..."
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
