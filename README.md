
<div style="text-align:center;">

# UseCase Generator

---

UseCase Generator is a **smart command** that creates use case files in a matter of seconds, inspired by [symfony/maker-bundle](https://github.com/symfony/maker-bundle).

[Description](#description) •
[Usage](#usage) •
[Installation](#installation) •
[Configuration](#configuration)

</div>

---
## Description
Create your UseCase files within a second. Similar to the maker bundle that creates entity and repository files, this bundle generates files for your use case. To perform this magic, simply run: `php bin/console meromn:maker:use-case`

By default, it creates three UseCase files in a folder named by the user. The command will prompt you to create test files as well.

---
## Usage
There is only one command to rule them all.

```shell
php bin/console meromn:maker:use-case
```
#### Options and Arguments
**<u>Options</u>**

- `--test` or `-t` to create tests file by default.
    ```shell 
    php bin/console meromn:maker:use-case --test # or -t
    ```
  This command prompts the user to provide a use case name and creates the corresponding use case folder and files, along with the associated test files.

**<u>Arguments</u>**

- You can directly add the UseCase folder name in your command.
    ```shell 
    php bin/console meromn:maker:use-case CreateUseCase
    ```
  This command prompts the user to determine if test files are needed. It creates a folder named CreateUseCase and the associated files.

Of course, you can mix all the options and arguments together:
```shell
php bin/console meromn:maker:use-case CreateUseCase -t
```

This command creates a folder named CreateUseCase with the associated files, as well as the test files.

---
## Installation
To install the UseCase Generator bundle, you can use composer:

```shell
composer require meromn/use-case-generator --dev
```
And that's it! Check [Configuration](#configuration) section to modify the default values.

---
## Configuration
You can adjust some configuration options depending on your project. Update the following YAML file:
```yaml
# config/use_case_maker.yaml

# All the data provided here are the default value
  use_case_maker:
    folder_location: '%kernel.project_dir%/src/UseCase' # The path where the folder and files will be created
    folder_test_location: '%kernel.project_dir%/tests' # The path where the folder and tests files will be created 
    namespace_for_use_case: 'App\UseCase' # The namespace for the class 
    namespace_for_tests_use_case: 'App\Tests' # The namespace for the tests class
    naming:
      use_case: 'UseCase' # The class name for use case
      request: 'Request' # The class name for the request
      response: 'Response' # The class name for the response
```