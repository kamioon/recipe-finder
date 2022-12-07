# Hello!

This is a Cookie recipe finder by point of its ingredients.

## use docker

First build the image:

```bash
docker build . -t cookie
```

Then run the finder command:

```bash
 docker run --rm -i -t cookie php /var/www/html/bin/run.php finder  
```

## use without docker

First create/copy ```.env``` file.

```bash
cp .env_example .env
```

Then install libraries with composer:

```bash
composer install
```

Note 1: make sure the ``logs`` directory is writeable.
or disable logging by setting ``IS_DEBUG`` to ``0`` .

```bash
php bin/run.php finder
```

## Tests

you can find some unit tests in the `/tests` directory. to run them

```bash
./vendor/bin/phpunit tests
```

## Structure

a simple symfony console app create in ``bin/run.php`` file. it uses a command in
``src/Console/FindRecipeCommand.php``. the initialization of data placed there. so if we want a new ingredient we can
add there.

### Ingredient

to create an ingredient you can use

```php
 $ingredient = new Ingredient(
                    new Name("Cinnamon"),
                    new Capacity(2),
                    new Durability(3),
                    new Flavor(-2),
                    new Texture(-1),
                    new Calories(3),
                    );
```

to add Quantity to the ingredient, first need a Measurement:

```php
$measurement = new Measurement(44, UnitVolume::teaspoons())
```

```php
    $ingredientQuantity = new IngredientQuantity(
                $ingredient,
                $measurement
            );
```

then we can put some amount of ingredients into a container (here a bowl). a bowl should have a capacity. in this test
we set it 100 tea-spoon.

```php
 $bowl = new Bowl(
            new Measurement(100, UnitVolume::teaspoons()
            $ingredientQuantity
            );
```

to find out the score of the bowl. Just put the bowl in to calculator:

```php
        $calculator = new TasteCalculator(
            $bowl,
        );
        
        $score = $calculator->getScore();

```
