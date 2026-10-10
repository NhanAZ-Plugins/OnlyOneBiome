# Changelog

## 0.0.2

- Validate `biomeID` before changing loaded chunks. Invalid values leave world data unchanged and produce a server log error.
- Keep the original block layers and light arrays while replacing biome palettes.
- Add a chunk test against Axolotl-PM source and a pinned DevTools workflow with PHPStan at maximum level.
