# OnlyOneBiome

OnlyOneBiome replaces the biome palette of each chunk when Axolotl-PM loads that chunk. The chosen biome ID comes from the plugin configuration. This changes biome data in loaded world chunks; it does not change the blocks themselves.

## Requirements and compatibility

- Axolotl-PM API 5.0.0, as declared in [`plugin.yml`](plugin.yml). PHPStan at maximum level and a chunk transformation test pass against the 5.0.0 and 5.49.1 source revisions. Intermediate releases have not been tested.
- PHP 8.1 or newer, as required by those Axolotl-PM source revisions.
- No external plugin or runtime library dependency.

## Installation

Download the PHAR from [GitHub Releases](https://github.com/NhanAZ-Plugins/OnlyOneBiome/releases), place it in the server's `plugins` directory, and restart Axolotl-PM.

## Configuration and world behavior

Set `biomeID` in [`resources/config.yml`](resources/config.yml). The default is `21` for jungle. The value must be an integer from `0` through `255`; use an ID recognized by your Axolotl-PM version. A list of common IDs is included in the configuration file. An invalid value is logged at startup and leaves chunk biomes unchanged until the setting is corrected and the server restarts.

The plugin changes chunks as they load after it is enabled, including existing chunks loaded from storage and newly generated chunks. Chunks already loaded before the plugin starts are not processed until they load again. Modified chunks may be saved to the world, so keep a world backup if you need to restore the previous biome data. The plugin does not add a command or permission.

## Build and verification

The [build workflow](.github/workflows/build.yml) tests biome transformation with Axolotl-PM source and runs PHPStan at maximum level. It then uses [DevTools](https://github.com/NhanAZ/DevTools) to build and inspect a downloadable PHAR. The workflow pins DevTools and Axolotl-PM source to reviewed commits.

To run the chunk test locally, provide an installed Axolotl-PM source directory: `php tests/chunk-transformer.php /path/to/Axolotl-PM`. For a local PHAR build, follow the [DevTools CLI guide](https://github.com/NhanAZ/DevTools/blob/main/docs/cli.md) with this repository as the project directory. The chunk test checks biome values and block preservation; it does not prove how a connected Bedrock client renders the result.

## Support, authors and license

Report bugs in [GitHub Issues](https://github.com/NhanAZ-Plugins/OnlyOneBiome/issues) or contact [NhanAZ Discord](https://discord.gg/j2X83ujT6c). The manifest retains Muqsit and NhanAZ as authors. OnlyOneBiome retains its existing [MIT license](LICENSE).
