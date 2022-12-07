<?php

declare(strict_types=1);

namespace App\Console;

use App\Kitchen\Cabinet\Bowl;
use App\Kitchen\Cabinet\ContainerInterface;
use App\Kitchen\Cabinet\Ingredient;
use App\Kitchen\Cabinet\IngredientProperties\Calories;
use App\Kitchen\Cabinet\IngredientProperties\Capacity;
use App\Kitchen\Cabinet\IngredientProperties\Durability;
use App\Kitchen\Cabinet\IngredientProperties\Flavor;
use App\Kitchen\Cabinet\IngredientProperties\Name;
use App\Kitchen\Cabinet\IngredientProperties\Texture;
use App\Kitchen\Cabinet\IngredientQuantity;
use App\Kitchen\Cabinet\Rules\QuantityException;
use App\Kitchen\Calculator\TasteCalculator;
use App\Kitchen\Finder\RecipeFinder;
use App\Kitchen\Recipe\RecipeInterface;
use Measurements\Dimension;
use Measurements\Exceptions\MeasurementValueException;
use Measurements\Measurement;
use Measurements\Units\UnitVolume;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FindRecipeCommand extends Command
{
    private Dimension $unitVolume;
    private LoggerInterface $logger;

    public function configure(): void
    {
        $this->setName('finder')
            ->setDescription('This will be find best recipe for milk-dunking cookie recipe.')
            ->addArgument(
                'capacity',
                InputArgument::OPTIONAL,
                'The Capacity of your Bowl',
                100
            );
        $this->bootstrap();
    }

    private function bootstrap()
    {
        $this->unitVolume = UnitVolume::teaspoons();
        $this->logger = new Logger('debug');
        $this->logger->pushHandler(new StreamHandler(ROOT_DIR . "/" . $_ENV["LOG_FILE"]));
    }

    /**
     * @throws QuantityException
     * @throws MeasurementValueException
     */
    private function generateIngredients($capacity): RecipeInterface
    {

        // first we make ready a container for our ingredient
        $bowl = new Bowl(
            new Measurement($capacity, $this->unitVolume),
            new IngredientQuantity(
                new Ingredient(
                    new Name("Butterscotch"),
                    new Capacity(-1),
                    new Durability(-2),
                    new Flavor(6),
                    new Texture(3),
                    new Calories(8)
                ),
                new Measurement(0, $this->unitVolume)
            ),
            new IngredientQuantity(
                new Ingredient(
                    new Name("Cinnamon"),
                    new Capacity(2),
                    new Durability(3),
                    new Flavor(-2),
                    new Texture(-1),
                    new Calories(3),
                ),
                new Measurement(0, $this->unitVolume)
            )
        );

        $calculator = new TasteCalculator($bowl);
        $finder = new RecipeFinder(
            $bowl,
            $calculator,
            $_ENV["IS_DEBUG"] ? $this->logger : null
        );

        return $finder->find();

    }

    /**
     * @throws MeasurementValueException
     * @throws QuantityException
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $capacity = $input->getArgument("capacity");

        $result = $this->generateIngredients($capacity);

        $output->writeln("Best Score: <info>" . $result->getScore() . "</info>");
        $this->print_pretty($result->getContainer(), $output);
//        print_r($result);
        return Command::SUCCESS;
    }

    private function print_pretty(ContainerInterface $container, OutputInterface $output)
    {
        foreach ($container->getIngredientQuantities() as $ingredientQuantity) {
            $output->writeln([
                "",
                "Ingredient: " . json_encode($ingredientQuantity->getIngredient()),
                "Quantity: " . $ingredientQuantity->getQuantity()->toString(),
                ""
            ]);
        }
    }
}