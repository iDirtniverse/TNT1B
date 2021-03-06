<?php
namespace Tnt;
use pocketmine\utils\TextFormat;
use pocketmine\level\sound\AnvilUseSound;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\Entity;
use pocketmine\nbt\tag\EnumTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\plugin\PluginBase;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\utils\Random;
use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\protocol\UseItemPacket;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\nbt\tag\ByteTag;
class Tnt extends PluginBase implements Listener {
    public function onEnable() {
        $this->getLogger()->info(TextFormat::BLUE ."===============");
        $this->getLogger()->info(TextFormat::GREEN ."Have FUN Plugin BY Nawaf_Craft1b");
        $this->getLogger()->info(TextFormat::BLUE ."===============");
            $this->getServer ()->getPluginManager ()->registerEvents ( $this, $this );
    }
          
        public function place(BlockPlaceEvent $place){
            $block = $place->getBlock();
            $player = $place->getPlayer();
         
            IF($block->getId()===46){
               
                	$place->setCancelled();
			$mot = (new Random())->nextSignedFloat() * M_PI * 2;
			$tnt = Entity::createEntity("PrimedTNT", $block->getLevel()->getChunk($block->x >> 4, $block->z >> 4), new Compound("", [
				"Pos" => new EnumTag("Pos", [
					new DoubleTag("", $block->x + 0.5),
					new DoubleTag("", $block->y),
					new DoubleTag("", $block->z + 0.5)
				]),
				"Motion" => new EnumTag("Motion", [
					new DoubleTag("", -sin($mot) * 0.02),
					new DoubleTag("", 0.2),
					new DoubleTag("", -cos($mot) * 0.02)
				]),
				"Rotation" => new EnumTag("Rotation", [
					new FloatTag("", 0),
					new FloatTag("", 0)
                                    
				]),
				"Fuse" => new ByteTag("Fuse", 100)
			]));
			$tnt->spawnToAll();
                        $player->getLevel()->addSound(new AnviluseSound($player),array($player));
			return true;
		}
            
        }
        
      public function ExplosionPrimeEvent(ExplosionPrimeEvent $p){
          $p->setBlockBreaking(false);
      }
          public function onDamage(EntityDamageEvent $event){
            $player = $event->getEntity();
            $entity = $event->getEntity();
            
  
         if($player instanceof Player && $event->getCause() === EntityDamageEvent::CAUSE_ENTITY_EXPLOSION){
         	switch(mt_rand(1,5)){
         		case 1:
            $event->setDamage(10);
            break;
            case 2:
             $event->setDamage(9);
		break;
            case 3:
             $event->setDamage(8);	
             	break;
	    case 4:
	     $event->setDamage(7);
		break;
	    case 5:
	     $event->setDamage(5);
		break;
         	}
        }
    }
}
