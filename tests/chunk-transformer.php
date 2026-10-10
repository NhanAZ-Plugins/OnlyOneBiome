<?php

declare(strict_types=1);

use NhanAZ\OnlyOneBiome\BiomeTransformer;
use pocketmine\world\format\Chunk;

$serverSource = $argv[1] ?? null;
if ($serverSource === null || !is_file($serverSource . "/vendor/autoload.php")) {
	throw new RuntimeException("Pass an installed Axolotl-PM source directory as the first argument.");
}

require $serverSource . "/vendor/autoload.php";
require dirname(__DIR__) . "/src/BiomeTransformer.php";

$chunk = new Chunk([], true);
$chunk->setBlockStateId(1, 64, 1, 42);
$chunk->setBiomeId(0, 64, 0, 1);
$blockLayer = $chunk->getSubChunk(4)->getBlockLayers()[0];

$changed = BiomeTransformer::apply($chunk, 21);
if ($changed !== $chunk->getHeight()) {
	throw new RuntimeException("Expected all subchunks to receive the target biome.");
}
foreach ($chunk->getSubChunks() as $subChunk) {
	if ($subChunk->getBiomeArray()->getPalette() !== [21]) {
		throw new RuntimeException("A subchunk has an unexpected biome palette.");
	}
}
if ($chunk->getBlockStateId(1, 64, 1) !== 42 || $chunk->getSubChunk(4)->getBlockLayers()[0] !== $blockLayer) {
	throw new RuntimeException("Biome transformation changed a block layer.");
}
if (BiomeTransformer::apply($chunk, 21) !== 0) {
	throw new RuntimeException("Applying the same biome should leave the chunk unchanged.");
}

echo "PASS: chunk biome transformation and block preservation\n";
