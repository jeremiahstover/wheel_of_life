# Wishlist: Future Development

Ideas for evolving this assessment into something more powerful.

---

## 1. Computer Adaptive Testing (CAT) Across All Layers

The current assessment only covers Layer 4 (Discipline). The full Wheel of Life has 8 layers:

```
Layer 8: Transcendence
Layer 7: Generativity  
Layer 6: Competence
Layer 5: Diligence
Layer 4: Discipline      ← current
Layer 3: Responsibility
Layer 2: Causality
Layer 1: Order
```

### The Vision

Build out question sets for all 8 layers, then implement adaptive navigation:

**If scoring well (7+) on current layer → probe upward**
- "You have discipline. But are you *diligent*? Let's check Layer 5."
- Confirms the foundation is solid before moving up

**If scoring poorly (≤4) on current layer → probe downward**  
- "Discipline is struggling. Let's check if Responsibility (Layer 3) is solid."
- Follows the remediation principle: go down until you find solid ground

### Adaptive Flow Example

```
Start at Layer 4 (Discipline)
    ↓
Score: 4.2 (Below Baseline)
    ↓
"Let's check Layer 3 (Responsibility)"
    ↓
Score: 6.1 (Maintaining)
    ↓
"Foundation is here. Focus remediation on building 
 Discipline on top of your Responsibility base."
```

### Technical Approach

- Each layer gets its own question bank (45 questions, same 9-dimension structure)
- Assessment starts at Layer 4 (middle of stack)
- After scoring, algorithm decides: up, down, or stop
- Final report shows the "stack trace" — which layers are solid, which need work
- URL encoding expands: `#r=SEED.L4answers.L3answers...`

### Why This Matters

Most people know *what* they should do (Discipline) but struggle because something underneath is broken. CAT finds the actual break point rather than just measuring symptoms.

---

## 2. Multi-Angle Question Redundancy (Anti-Gaming)

### The Problem

Self-assessment is easy to game, consciously or unconsciously:
- Social desirability bias ("I should say I pray daily")
- Self-deception ("I'm pretty good at this, actually")
- Pattern recognition ("Oh, this is asking about X again")

### The Solution

Ask the same thing from multiple angles:

**Direct:**
> "I maintain a consistent prayer practice."

**Behavioral:**
> "In the past week, how many days did I spend time in prayer?"

**Situational:**
> "When I'm stressed, my first instinct is to pray."

**Inverted:**
> "I often realize I haven't prayed in days."

**Concrete:**
> "I could describe what I prayed about yesterday."

### Consistency Scoring

If someone answers:
- Direct: 5 (Almost Always)
- Behavioral: 2 (1-2 days)
- Inverted: 4 (Usually haven't prayed)

The inconsistency itself is data. Either:
- They're not being honest with themselves
- They have aspirational self-image disconnected from behavior
- The dimension needs deeper examination

### Implementation Ideas

- 3-5 angles per dimension (15-25 questions per dimension instead of 5)
- Randomize heavily so patterns aren't obvious
- Calculate "consistency score" alongside raw score
- Flag dimensions with high inconsistency for reflection
- Weight behavioral/concrete questions higher than aspirational ones

### Report Addition

> **Consistency Alert:** Your responses about *Connection to God* showed significant variation. Your stated commitment (4.8) differs from reported behaviors (2.4). This gap often indicates an area worth honest reflection.

---

## 3. Conscience-Prodding Deep Questions

### The Problem

Current questions are relatively safe. They measure frequency of behavior but don't probe the heart. Someone can score well while their conscience remains unexamined.

### The Vision

A separate "deep dive" mode with questions designed to surface what's actually going on underneath. These aren't about frequency — they're about honesty.

### Example Questions by Dimension

**Connection to God:**
- "Is my prayer life about genuine relationship, or checking a box?"
- "When did I last hear from God in a way that surprised or challenged me?"
- "Am I hiding anything from God that I haven't been willing to bring into the light?"

**Conscience:**
- "What am I currently doing that I know I shouldn't be?"
- "What am I not doing that I know I should be?"
- "Is there anyone I'm avoiding because I know they'd call out something in my life?"

**Will:**
- "What promise to myself have I broken most recently?"
- "Where am I currently lying to myself about my intentions?"
- "What would I do differently if I knew everyone could see my choices?"

**Emotions:**
- "What feeling am I most actively suppressing right now?"
- "Who am I angry at that I haven't dealt with?"
- "What am I afraid to feel?"

**Health &amp; Wholeness:**
- "What am I doing to my body that I'd be embarrassed to admit?"
- "What warning signs am I ignoring?"
- "If my body could talk, what would it be begging me to stop doing?"

### Implementation Approach

**Not scored numerically.** These questions don't map to a 1-5 scale. Instead:

1. **Reflection prompts** — user writes free-form response (stored locally only, never transmitted)
2. **Binary acknowledgment** — "This question surfaced something I need to address" (yes/no)
3. **Commitment capture** — "Based on this reflection, I will: ___________"

### When to Use

- Optional "deep dive" after completing standard assessment
- Recommended when:
  - Consistency scores are low (self-deception likely)
  - User has taken assessment multiple times with no improvement
  - User explicitly requests deeper examination
- Warning: "These questions are designed to be uncomfortable. They work best when answered with radical honesty."

### Privacy-First Design

- Responses stored in browser localStorage only
- Never included in shareable URL
- Option to export encrypted backup
- Clear "delete all reflections" button

---

## Implementation Priority

| Feature | Complexity | Impact | Priority |
|---------|------------|--------|----------|
| Multi-angle questions | Medium | High | 1 |
| Conscience-prodding mode | Low | High | 2 |
| Full 8-layer CAT | High | Very High | 3 |

Start with #2 (low effort, high impact), then #1 (improves validity), then #3 (requires significant content development for 7 more layers).

---

## Content Development Needed

### For Multi-Angle Questions
- 4 additional question variants per existing question = 180 new questions
- Behavioral anchoring for each (what does this look like concretely?)
- Inverted phrasing that doesn't feel obvious

### For Conscience-Prodding
- 3-5 deep questions per dimension = 27-45 questions
- Reflection prompt format (not multiple choice)
- Commitment template structure

### For Full CAT
- 7 more complete layer assessments = 315 questions per layer × 7 = 2,205 questions
- Layer-specific interpretations and remediation advice
- Cross-layer analysis logic

---

## Open Questions

1. **Scoring multi-angle:** Weight all equally? Favor behavioral over aspirational? Use ML to find predictive weights?

2. **CAT stopping rules:** How many layers up/down before stopping? What if someone scores poorly all the way down to Order?

3. **Conscience mode opt-in:** Should it be hidden until unlocked? Require completing standard assessment first? Always available?

4. **Data persistence:** LocalStorage vs. URL encoding vs. optional account creation? Privacy vs. longitudinal tracking tradeoffs.

5. **Accountability integration:** Option to share conscience reflections with a trusted person? Export for spiritual director/counselor?
