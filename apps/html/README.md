# Static HTML Assessment

A single-page HTML/JavaScript assessment tool currently deployed at [tripartite.us](https://tripartite.us).

## Overview

This is a self-contained static version of the Wheel of Life assessment. All questions and logic are embedded in a single HTML file — no server required.

## Deployment

Currently live at: **https://tripartite.us**

Can be hosted on any static file server, GitHub Pages, or opened directly in a browser.

## Features

- Full assessment (Layer 4 - Discipline, all 9 dimensions)
- Results visualization
- No dependencies beyond a modern browser

## Limitations

- Single layer only (Discipline)
- No result persistence
- Questions embedded in file (not loaded from shared data)

## Data Source

Questions are currently embedded in the HTML. Future versions should load from `../../data/layers/` for consistency with other apps.

## Notes

This was created as a quick deployment option for sharing the assessment. For the full multi-layer diagnostic approach, see `/apps/diagnostic/`.
