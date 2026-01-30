# Question Revision Workflow

## Overview

This document captures the process for revising assessment questions from "correct answer" framing to sentence stem format with conversational answers.

## Before Starting a Layer

1. **Load the pattern guide**: `view data/questions/GUIDE.md`
2. **Check progress files**: See what's done, what's pending, any notes for this layer
3. **Understand the layer's spectrum**: Each layer has its own 1→5 progression (see GUIDE.md)

## Per-Cell Workflow

For each cell (e.g., A4, B4, C4...):

### 1. Pattern Refresh
At the start of each cell, reload the condensed pattern:
- Layer definition
- Answer progression (1→5) for this layer
- Key checks

### 2. Load Current Questions
Show all 5 questions with their current text and answers.

### 3. Review Each Question (One at a Time)

For each question:

**a) Propose stem conversion**
- Convert "correct answer" framing to open sentence stem
- Check: Does stem telegraph the right answer? If so, flip it.

**b) Propose answer adjustments**
- Ensure stem + answer forms readable sentence
- Check against pattern:
  - 1: Passive/external (or dismissive)
  - 2: Trying but failing / mostly external
  - 3: Split / honest middle (both/and)
  - 4: Mostly owned + internal hedge
  - 5: Clean, stark, no hedging
- Check for anti-patterns:
  - Self-referencing ("I know I should...")
  - Labels instead of behavior ("make excuses" → "find the reasons")
  - Your diagnosis instead of their narrative
  - Parenthetical editorializing ("(I don't)")
  - Loaded/preachy language

**c) Present to user for review**
- Show proposed stem
- Show proposed answers in table format
- Wait for feedback

**d) Iterate until approved**
- User may catch issues (tone, embedded implications, layer mismatch)
- Refine based on feedback
- Don't batch approve — each question matters

### 4. Commit the Cell
After all 5 questions in a cell are approved:
- Update the JSON file
- Commit with descriptive message
- Push to remote

### 5. Move to Next Cell
Repeat pattern refresh at start of each new cell.

## Quality Standards

### "Good Enough" vs "Needs Work"

**Good enough**:
- Stem doesn't telegraph answer
- Answers are behavior, not labels
- Clear distinction between adjacent answers
- Readable concatenation
- Fits layer spectrum

**Needs work**:
- Self-referencing language
- Your diagnosis instead of their narrative
- Tone feels judgmental or preachy
- Embedded implications in stem
- Skill question at Discipline layer (or vice versa)

### Key Principles

1. **Every question is load-bearing** — 45 questions instead of 360 means each carries 8x weight
2. **Make honest self-assessment easy** — People avoid answers that make them feel judged
3. **Use their internal narrative** — What they tell themselves, not your analysis
4. **Layer fit matters** — Discipline = whether you do it; Skill = how well you do it

## Collaboration Dynamic

- AI proposes, human refines
- Human catches things AI misses (tone, cultural connotations, embedded assumptions)
- Iteration is expected and valuable
- "Good enough" is acceptable — perfect is the enemy of done

## After Completing a Layer

1. Update progress file for that layer
2. Note any discoveries or patterns for future layers
3. Update GUIDE.md if new patterns emerged

## Notes for Specific Layers

### Layer 5 (Skill) — Mind dimension
Pre-discovered models to use:
- **Thinking progression**: external → internal → critical → original
- **Engagement posture**: pre-judged → negative filter → positive filter → active pursuit

(Add more notes here as layers are completed)

---

*Last updated: 2026-01-30*
