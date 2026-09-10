---
name: Kinetic Infrastructure
colors:
  surface: '#faf8ff'
  surface-dim: '#d2d9f4'
  surface-bright: '#faf8ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f2f3ff'
  surface-container: '#eaedff'
  surface-container-high: '#e2e7ff'
  surface-container-highest: '#dae2fd'
  on-surface: '#131b2e'
  on-surface-variant: '#3f4850'
  inverse-surface: '#283044'
  inverse-on-surface: '#eef0ff'
  outline: '#707881'
  outline-variant: '#bfc7d2'
  surface-tint: '#006398'
  primary: '#006194'
  on-primary: '#ffffff'
  primary-container: '#007bb9'
  on-primary-container: '#fdfcff'
  inverse-primary: '#93ccff'
  secondary: '#0051d5'
  on-secondary: '#ffffff'
  secondary-container: '#316bf3'
  on-secondary-container: '#fefcff'
  tertiary: '#006947'
  on-tertiary: '#ffffff'
  tertiary-container: '#00855b'
  on-tertiary-container: '#f5fff6'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#cce5ff'
  primary-fixed-dim: '#93ccff'
  on-primary-fixed: '#001d31'
  on-primary-fixed-variant: '#004b73'
  secondary-fixed: '#dbe1ff'
  secondary-fixed-dim: '#b4c5ff'
  on-secondary-fixed: '#00174b'
  on-secondary-fixed-variant: '#003ea8'
  tertiary-fixed: '#6ffbbe'
  tertiary-fixed-dim: '#4edea3'
  on-tertiary-fixed: '#002113'
  on-tertiary-fixed-variant: '#005236'
  background: '#faf8ff'
  on-background: '#131b2e'
  surface-variant: '#dae2fd'
typography:
  display-hero:
    fontFamily: Space Grotesk
    fontSize: 56px
    fontWeight: '700'
    lineHeight: 64px
    letterSpacing: -0.03em
  display-hero-mobile:
    fontFamily: Space Grotesk
    fontSize: 36px
    fontWeight: '700'
    lineHeight: 44px
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: Space Grotesk
    fontSize: 36px
    fontWeight: '600'
    lineHeight: 44px
    letterSpacing: -0.02em
  headline-lg-mobile:
    fontFamily: Space Grotesk
    fontSize: 28px
    fontWeight: '600'
    lineHeight: 36px
    letterSpacing: -0.01em
  headline-md:
    fontFamily: Space Grotesk
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
    letterSpacing: -0.01em
  headline-sm:
    fontFamily: Space Grotesk
    fontSize: 18px
    fontWeight: '600'
    lineHeight: 26px
    letterSpacing: '0'
  body-lg:
    fontFamily: Inter
    fontSize: 18px
    fontWeight: '400'
    lineHeight: 28px
  body-md:
    fontFamily: Inter
    fontSize: 15px
    fontWeight: '400'
    lineHeight: 24px
  body-sm:
    fontFamily: Inter
    fontSize: 13px
    fontWeight: '400'
    lineHeight: 20px
  label-md:
    fontFamily: JetBrains Mono
    fontSize: 13px
    fontWeight: '500'
    lineHeight: 18px
    letterSpacing: 0.02em
  label-sm:
    fontFamily: JetBrains Mono
    fontSize: 11px
    fontWeight: '500'
    lineHeight: 16px
    letterSpacing: 0.04em
  code-inline:
    fontFamily: JetBrains Mono
    fontSize: 13px
    fontWeight: '400'
    lineHeight: 20px
rounded:
  sm: 0.125rem
  DEFAULT: 0.25rem
  md: 0.375rem
  lg: 0.5rem
  xl: 0.75rem
  full: 9999px
spacing:
  unit-2xs: 0.25rem
  unit-xs: 0.5rem
  unit-sm: 0.75rem
  unit-md: 1rem
  unit-lg: 1.5rem
  unit-xl: 2rem
  unit-2xl: 3rem
  unit-3xl: 4rem
  unit-4xl: 6rem
  gutter-mobile: 1rem
  gutter-desktop: 2rem
  container-max: 80rem
---

## Brand & Style
The design system positions IT infrastructure and enterprise networking not as invisible utility, but as precision architecture. Engineered for high-stakes technical teams, CTOs, and modern systems architects, the visual language balances surgical precision with dynamic agency energy. It evokes relentless uptime, instantaneous throughput, and absolute operational clarity.

The aesthetic direction combines **Corporate / Modern** engineering rigor with subtle **Glassmorphism** and technical accents. Interfaces prioritize rapid data parsing via ultra-crisp typographic contrast, structural hairline dividers, and calculated electric-blue focal points that lead the eye through technical topologies, service health indicators, and solution matrices.

## Colors
The palette leverages high-luminance slate backgrounds paired with deep navy neutrals and saturated, glowing cybernetic accents.

- **Primary (`#0284c7`) & Cyan Hover (`#0ea5e9`):** Represents routing velocity, fiber-optic data channels, and primary action affordances.
- **Secondary (`#2563eb`):** Provides deep spectrum backing for complex data visualizations, multi-layer networking diagrams, and hero CTAs.
- **Tertiary (`#10b981`):** Applied exclusively for operational stability, 99.999% uptime validation, low-latency telemetry, and positive state metrics.
- **Neutral Core (`#0f172a`, `#1e293b`, `#334155`):** High-density text hierarchy engineered to prevent eyestrain while maximizing contrast against pristine canvas surfaces.
- **Surface Foundations (`#ffffff`, `#f8fafc`, `#f1f5f9`, `#e2e8f0`):** Stratified layers that organize technical density into digestable panels without visual clutter.

## Typography
Typographic pairings embody technical precision:
- **Headlines (Space Grotesk):** Delivers a technical, geometric edge suited for infrastructure architecture and enterprise networking services. Tight kerning provides an authoritative, industrial posture.
- **Body Text (Inter):** Guarantees frictionless readability across high-density documentation, case studies, service agreements, and system breakdowns.
- **Labels, Telemetry & Code (JetBrains Mono):** Grounded in developer and sysadmin workflows. Used across metric visualizations, IP readouts, protocol tags, and SLA badges to convey computational accuracy.

## Layout & Spacing
The layout architecture is structured around a baseline 8pt grid mapped to a 12-column fluid grid system bounded by a max-width container of `1280px` (`80rem`).

- **Desktop (1024px+):** 12 columns with `32px` (`2rem`) gutters and horizontal margins adapting smoothly to center-contain content.
- **Tablet (768px - 1023px):** 8 columns with `24px` (`1.5rem`) gutters, reflowing complex multi-column infrastructure diagrams into dual-column cards.
- **Mobile (<768px):** 4 columns with `16px` (`1rem`) margins and gutters. Multi-tier pricing tables and node monitoring modules collapse into swipeable inline sequences or single-column stacked modules.

Internal card components maintain an internal rhythmic padding of `unit-lg` (`1.5rem`), scaling down to `unit-md` (`1rem`) on handheld displays to maintain payload density.

## Elevation & Depth
Depth in this system avoids heavy drop shadows, instead relying on **tonal containment, micro-borders, and diffused cyber-glows**:

- **Level 0 (Canvas):** Pure `#f8fafc` or `#ffffff` baseline plane.
- **Level 1 (Structural Cards & Panels):** Surface `#ffffff` elevated through a 1px border of `#e2e8f0` coupled with a precision ambient shadow: `0 1px 3px 0 rgba(15, 23, 42, 0.04), 0 1px 2px -1px rgba(15, 23, 42, 0.04)`.
- **Level 2 (Hover States & Active Cards):** Surface elevated to `box-shadow: 0 10px 25px -5px rgba(2, 132, 199, 0.08), 0 8px 10px -6px rgba(15, 23, 42, 0.04)` combined with an accent border transition to `#0284c7` (30% opacity).
- **Level 3 (Modals, Overlays, Floating Diagnostics):** Surface `#ffffff` backed by `box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.08), 0 10px 10px -5px rgba(15, 23, 42, 0.03)` with a subtle frosted backdrop blur (`backdrop-filter: blur(8px)` with `rgba(248, 250, 252, 0.8)`).

## Shapes
A restrained **Soft (`1`)** shape language dominates the design system, reflecting enterprise discipline and architectural stability rather than casual consumer softness.

- Standard buttons, input fields, badges, and card panels implement a consistent `4px` (`0.25rem`) to `8px` (`0.5rem`) radius.
- Data tags, chip toggles, and status pills retain crisp geometries with maximum corner limits of `6px`.
- High-level modal windows and hero spotlight containers cap their corner radius at `12px` (`0.75rem`), ensuring sharp, architectural profiles across all viewports.

## Components

### Buttons
- **Primary:** Solid gradient fill from `#0284c7` to `#2563eb` with crisp white `Inter` semi-bold text, `8px` border radius, and an ambient cyan hover glow.
- **Secondary / Outline:** Background `#ffffff`, 1px border of `#e2e8f0`, text `#0f172a`. On hover: border transitions to `#0284c7` with light slate tint `#f0f9ff`.
- **Ghost / Technical:** Text `#334155`, no border. Includes right-pointing mono arrow (`→`) using `JetBrains Mono` for navigation links.

### Chips & Status Badges
- **Status Indicator:** Inline-flex pill featuring a live pulsing dot (e.g., emerald `#10b981` dot with an animated radial ping for 99.9% uptime). Background `#ecfdf5`, text `#065f46`, font `JetBrains Mono` at `11px`.
- **Protocol Chip:** Subdued `#f1f5f9` surface with `#475569` text and `#cbd5e1` 1px border for networking specs (`BGP`, `VLAN`, `Zero-Trust`, `SD-WAN`).

### Lists
- Architectural key-value pair lists for technical specifications. Left-hand label in `#64748b` (`Inter`), right-hand value in `#0f172a` (`JetBrains Mono`). Separated by a 1px dashed divider `#e2e8f0`.

### Checkboxes & Radio Buttons
- Precision square boxes with `3px` corner radius. Checked states fill with `#0284c7` displaying a crisp geometric tick mark. Radio controls use a high-contrast concentric ring layout.

### Input Fields
- Background `#ffffff`, 1px border `#cbd5e1`, text `#0f172a`. Focused state activates a dual-ring: 1px border `#0284c7` backed by an ambient outer glow ring `0 0 0 3px rgba(2, 132, 199, 0.15)`.

### Cards & Service Nodes
- **Service Node Card:** White backdrop, 1px border `#e2e8f0`. Header contains technical monospaced ID tag (e.g., `// NET-SEC-01`) alongside a dynamic SVG network icon tinted in electric cyan.
- **Metric Highlight Card:** Highlights client throughput, latency metrics, and architecture scores with an oversized `Space Grotesk` numeral over a faint blue-tinted linear gradient background.