## Coding challenge.

### Main requirements
1. use Symfony Console component
2. Make command that takes local/remote XML file as source and exports to Google Sheets
3. Docker setup
4. Configurable Google Spreadsheet connection
5. Errors into log file

### Additional requirements
 
1. Show/describe patterns
2. Clean code
3. Tests
4. Easy-to-start/adapt

### Solution description:

#### Folders and files
   1 `config` - external API configs (Google SpreadS)     
   2 `src` - main functionality       
   3 `tests` - obvious        
   4 `var/input`, `var/output` - folders for import/export (local) files (if needed)  
   5 `var/logs` - obvious   
   6 `./app.php` - entrypoint
   
#### Env used:        
   1 `ENV` - if set to `dev` Logger output = stdout/stderr        
   2 `LOG_DIR` - folder for logging into file for `env != dev`. Default = `./var/logs`
   
#### How to run:      
   1 Pull the code on local machine   
   2 Build Docker image   
   3 Start interactively Docker container or run the needed commands (below)          
        3.1 Execute tests `docker run -it -v $PWD:/var/www YOUR_IMAGE ./vendor/phpunit/phpunit/phpunit`   
        3.2 Command itself:  `docker run -it -v $PWD:/var/www YOUR_IMAGE php app.php app:migrate IMPORT_FILE_SOURCE` (local source or remote)
        as an example, run `docker run -it -v $PWD:/var/www YOUR_IMAGE php app.php app:migrate:local ./var/input/sample.xml`
        and check `./var/output` folder for json export result

#### Code description:

Command is the main logical unit which has several dependencies and operates with
imports and exports only based on Contract.
Dependencies for simplicity are initialized in Entrypoint (./app.php) and injected without using any Service Locator or smth.
This was done on purpose - main thing is the Contract for command and 
not how the concrete implementation classes are being created.

The main "src" folder is structured in the following way:

- `Command` - Command itself as a Logical starting point or operator
- `Transport` - layer of data import/export handling
  Each (import, export) folder has an interface which Command relies upon.
  To show the example of usage of such approach, several Export implementations had been created.
  Also you can easily change the Export instance in `app.php` on local one to see the resulf of command
  in case if connection to Google Spreadsheet fails for some reason
  
- `Transport/Exception` - custom exceptions folder
- `Transport/Validator` - validation layer. Created 2 import source validators: that file exists and reachable
- `Domain` (decided not to include to avoid toooo many abstractions that are not covered in requirements)
Main Object that we import and then export -> catalog of coffee items with prices, names, etc.
So, in case of more complicated operations (not just transmit from one source into another), makes sense to
  extend `Domain` with `CoffeeItem`, `CoffeeItemCollection` objects, etc
  
#### Things to consider/mention

1. XMLReader has efficient memory usage and not reading whole XML into memory
2. Google SpreadSheet API has limitations (100 req/s)
2. XML element key sanitizer. (see `./var/input/sample.xml`) 
    At the moment it's `camelCase + snake_case + PascalCase`
    Probably making it single formatted would be more consistent