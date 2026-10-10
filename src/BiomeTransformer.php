<?php

declare(strict_types=1);

namespace NhanAZ\OnlyOneBiome;

use pocketmine\world\format\Chunk;
use pocketmine\world\format\PalettedBlockArray;
use pocketmine\world\format\SubChunk;

final class BiomeTransformer {
	public static function apply(Chunk $chunk, int $biomeId): int {
		$changed = 0;
		foreach ($chunk->getSubChunks() as $y => $subChunk) {
			if ($subChunk->getBiomeArray()->getPalette() === [$biomeId]) {
				continue;
			}
			$chunk->setSubChunk($y, new SubChunk(
				$subChunk->getEmptyBlockId(),
				$subChunk->getBlockLayers(),
				new PalettedBlockArray($biomeId),
				$subChunk->getBlockSkyLightArray(),
				$subChunk->getBlockLightArray()
			));
			++$changed;
		}
		return $changed;
	}
}
