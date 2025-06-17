<?php

namespace customiesdevs\customies\craft;

use Erodia\Engine;
use Erodia\Util\Reflect;
use Exception;
use InvalidArgumentException;
use pocketmine\crafting\ExactRecipeIngredient;
use pocketmine\crafting\ShapedRecipe;
use pocketmine\crafting\ShapelessRecipe;
use pocketmine\item\Item;
use pocketmine\item\LegacyStringToItemParser;
use pocketmine\item\StringToItemParser;
use pocketmine\Server;
use pocketmine\utils\Filesystem;
use pocketmine\utils\SingletonTrait;

class CraftFactory
{
    use SingletonTrait;

    /**
     * @param string $path
     * @return void
     */
    public function registerFromPath(string $path): void
    {
        $this->processFile($path, 'register');
    }

    /**
     * @param string $path
     * @return void
     */
    public function unregistersFromPath(string $path): void
    {
        $this->processFile($path, 'unregister');
    }

    /**
     * @param string $path
     * @param string $action
     * @return void
     */
    private function processFile(string $path, string $action): void
    {
        try {
            $content = Filesystem::fileGetContents($path);
            $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

            if (!is_array($data)) {
                throw new Exception("Invalid object format in path: {$path}");
            }

            foreach ($data as $index => $value) {
                if ($action === 'register') {
                    $this->validateAndRegister($value, $path, $index);
                } else {
                    $this->{$action}($value);
                }
            }
        } catch (Exception $exception) {
            Engine::getInstance()->getLogger()->error("Error processing file {$path}: " . $exception->getMessage());
        }
    }

    /**
     * @param array $value
     * @param string $path
     * @param int $index
     * @return void
     * @throws Exception
     */
    private function validateAndRegister(array $value, string $path, int $index): void
    {
        if (!isset($value['input'], $value['output'], $value['shape'])) {
            throw new Exception("Missing required keys in entry #{$index} in file {$path}.");
        }

        $this->register($value['input'], $value['output'], $value['shape']);
    }

    /**
     * @param array $input
     * @param array $output
     * @param array $shape
     * @return void
     */
    public function register(array $input, array $output, array $shape): void
    {
        if (!isset($output['id'])) {
            throw new InvalidArgumentException('The output item ID is required.');
        }

        $parsedOutput = $this->parseItem($output['id'], $output['count'] ?? 1);
        $parsedInput = array_map(fn($item) => new ExactRecipeIngredient($this->parseItem($item)), $input);

        try {
            $recipe = new ShapedRecipe($shape, $parsedInput, [$parsedOutput]);
            Server::getInstance()->getCraftingManager()->registerShapedRecipe($recipe);
        } catch (Exception $e) {
            Server::getInstance()->getLogger()->error("Error registering the recipe: " . $e->getMessage());
        }
    }

    /**
     * @param string $item
     * @return void
     */
    public function unregister(string $item): void
    {
        $craftMgr = Server::getInstance()->getCraftingManager();
        $recipes = $craftMgr->getCraftingRecipeIndex();

        $newRecipes = array_filter($recipes, fn($recipe) =>
            !($recipe instanceof ShapedRecipe || $recipe instanceof ShapelessRecipe) ||
            !$this->containsItem($recipe, $item)
        );

        Reflect::put($craftMgr, "craftingRecipeIndex", array_values($newRecipes));
    }

    /**
     * @param string $item
     * @param int $count
     * @return Item
     */
    private function parseItem(string $item, int $count = 1): Item
    {
        return StringToItemParser::getInstance()->parse($item)->setCount($count) ??
            LegacyStringToItemParser::getInstance()->parse($item)->setCount($count);
    }

    /**
     * @param $recipe
     * @param string $item
     * @return bool
     */
    private function containsItem($recipe, string $item): bool
    {
        $parsedItem = $this->parseItem($item);
        return array_reduce($recipe->getResults(), fn($carry, $result) =>
            $carry || $result->equals($parsedItem, false, false), false);
    }
}
