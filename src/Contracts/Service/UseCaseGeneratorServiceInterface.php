<?php

namespace Meromn\UseCaseGenerator\Contracts\Service;

interface UseCaseGeneratorServiceInterface
{
    /**
     * @param string $useCaseName
     * @return array<string>
     */
    public function generateFolderAndFiles(string $useCaseName): array;

    /**
     * @param string $useCaseName
     * @return array<string>
     */
    public function generateTestsFiles(string $useCaseName): array;
}