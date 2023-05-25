# cmostores.com Trial Task

## Added files

- `src/Entity/Calculation.php` - this is the database model used to store previous calculations
- `src/Form/CalculationType.php` - the form type I used to generate a symfony form to collect data from the user
- `src/Repository/CalculationRepository.php` - repository class for `Calculation` model
- `src/Controller/CalculationController.php` - controller class
- `src/Entity/DTO/CalculationDto.php` - data transfer object to store data entered in the form
- `src/Calculator/PricingCalculator.php` - class used to calculate gross and net values from the given user value and VAT rate
- `migrations/Version20230525095836.php` - doctrine generated migration class
- `templates/index.html.twig` - main template for displaying content to the user

## Modified files

- `config/packages/doctrine.yml` - added `attribute` metadata mapping type
- `config/packages/twig.yml` - added bootstrap form theme
- `composer.json` - added packages to help formatting text and implement CSRF protection in forms