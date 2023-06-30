<?php

namespace Meromn\UseCaseGenerator\Service;

use Meromn\UseCaseGenerator\Contracts\Service\UseCaseGeneratorServiceInterface;
use Meromn\UseCaseGenerator\Helper\FileHelper;

readonly final class UseCaseGeneratorService implements UseCaseGeneratorServiceInterface
{
    /**
     * @param string $folderLocation
     * @param string $folderTestLocation
     * @param string $useCaseClassBaseName
     * @param string $requestClassBaseName
     * @param string $responseClassBaseName
     * @param string $baseNamespaceForUseCase
     * @param string $baseTestsNamespaceForUseCase
     * @param string $projectDir
     */
    public function __construct(
        private string $folderLocation,
        private string $folderTestLocation,
        private string $useCaseClassBaseName,
        private string $requestClassBaseName,
        private string $responseClassBaseName,
        private string $baseNamespaceForUseCase,
        private string $baseTestsNamespaceForUseCase,
        private string $projectDir
    ) {
    }

    /**
     * @param string $useCaseName
     * @return array<string>
     * @throws \Exception
     */
    public function generateFolderAndFiles(string $useCaseName): array
    {
        $useCaseName = ucfirst($useCaseName);
        $path = $this->folderLocation;
        FileHelper::createFolderIfNotExist($path);
        $path .= '/' . $useCaseName . '/';
        $namespace = $this->baseNamespaceForUseCase . '\\' . $useCaseName;
        FileHelper::createFolderIfNotExist($path);
        FileHelper::createFileIfNotExist($path . $this->useCaseClassBaseName . '.php', $namespace);
        FileHelper::createFileIfNotExist($path . $this->requestClassBaseName . '.php', $namespace);
        FileHelper::createFileIfNotExist($path . $this->responseClassBaseName . '.php', $namespace);
        $basePathFolderLocation = str_replace($this->projectDir . '/', '', $this->folderLocation);
        $baseSuccessString = $basePathFolderLocation . '/' . $useCaseName . '/';
        return [
            $baseSuccessString . $this->useCaseClassBaseName . '.php',
            $baseSuccessString . $this->requestClassBaseName . '.php',
            $baseSuccessString . $this->responseClassBaseName . '.php'
        ];
    }

    /**
     * @param string $useCaseName
     * @return array<string>
     * @throws \Exception
     */
    public function generateTestsFiles(string $useCaseName): array
    {
        $useCaseName = ucfirst($useCaseName);
        $path = $this->folderTestLocation;
        FileHelper::createFolderIfNotExist($path);
        $path .= '/' . $useCaseName . '/';
        $namespace = $this->baseTestsNamespaceForUseCase . '\\' . $useCaseName;
        FileHelper::createFolderIfNotExist($path);
        FileHelper::createFileIfNotExist($path . $this->useCaseClassBaseName . 'Test.php', $namespace);
        FileHelper::createFileIfNotExist($path . $this->requestClassBaseName . 'Test.php', $namespace);
        FileHelper::createFileIfNotExist($path . $this->responseClassBaseName . 'Test.php', $namespace);
        $basePathFolderLocation = str_replace($this->projectDir . '/', '', $this->folderTestLocation);
        $baseSuccessString = $basePathFolderLocation . '/' . $useCaseName . '/';
        return [
            $baseSuccessString . $this->useCaseClassBaseName . '.php',
            $baseSuccessString . $this->requestClassBaseName . '.php',
            $baseSuccessString . $this->responseClassBaseName . '.php'
        ];
    }

    /**
     * @param string|null $useCaseName
     * @return string
     */
    public static function checkUseCaseNameIntegrity(?string $useCaseName): string
    {
        if (!self::checkUseCaseNameIsNotNull($useCaseName)) {
            throw new \RuntimeException(
                'The name of the use case cannot be null'
            );
        }
        if (!self::checkValidUserProvideName($useCaseName)) {
            throw new \RuntimeException(
                'The name of the use case must have \'UseCase\' suffix'
            );
        }
        return $useCaseName;
    }

    /**
     * @param string|null $useCaseName
     * @return bool
     */
    public static function checkUseCaseNameIsNotNull(?string $useCaseName): bool
    {
        if ($useCaseName === null || trim($useCaseName) === '') {
            return false;
        }
        return true;
    }

    public static function checkValidUserProvideName(string $useCaseName): bool
    {
        if (!is_string($useCaseName) || 'UseCase' !== substr($useCaseName, -7)) {
            return false;
        }
        return true;
    }
}