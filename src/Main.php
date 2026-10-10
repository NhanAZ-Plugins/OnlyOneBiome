<?php

declare(strict_types=1);

namespace NhanAZ\OnlyOneBiome;

use pocketmine\event\Listener;
use pocketmine\event\world\ChunkLoadEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\world\biome\Biome;

final class Main extends PluginBase implements Listener {
	private ?int $biomeId = null;

	protected function onEnable(): void {
		$this->saveDefaultConfig();
		$value = $this->getConfig()->get("biomeID");
		if (!is_int($value) || $value < 0 || $value >= Biome::MAX_BIOMES) {
			$this->getLogger()->error("Configuration value 'biomeID' must be an integer from 0 through 255. Chunk biomes will not be changed.");
			return;
		}
		$this->biomeId = $value;
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	/** Thanks @Muqsit: https://discord.com/channels/373199722573201408/373214753147060235/1122366583050866738 */
	public function onChunk(ChunkLoadEvent $event): void {
		if ($this->biomeId !== null) {
			BiomeTransformer::apply($event->getChunk(), $this->biomeId);
		}
	}
}
