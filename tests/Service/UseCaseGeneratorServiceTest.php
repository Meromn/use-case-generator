<?php

namespace Meromn\Tests\Service;

use Meromn\UseCaseGenerator\Service\UseCaseGeneratorService;
use PHPUnit\Framework\TestCase;

class UseCaseGeneratorServiceTest extends TestCase
{
    private const BASE_NAME_FOR_TEST = 'PhpUnitTestFolderUseCase';
    private const BASE_PATH = '/var/PhpUnitTestFolder/';
    private const BASE_PATH_TEST = '/var/TestPhpUnitTestFolder/';
    private const PROJECT_DIR = __DIR__ . '/../..';

    /**
     * @var UseCaseGeneratorService $service
     */
    private UseCaseGeneratorService $service;

    public function setUp(): void
    {
        $this->createService();
        parent::setUp();
    }

    public function testGenerateFolderAndFiles(): void
    {
        $r = $this->service->generateFolderAndFiles(self::BASE_NAME_FOR_TEST);
        $projectDirPath = self::PROJECT_DIR;
        $basePath = $projectDirPath . self::BASE_PATH . self::BASE_NAME_FOR_TEST . '/';
        self::assertIsArray($r);
        foreach ($r as $result) {
            self::assertStringContainsString(self::BASE_NAME_FOR_TEST, $result);
        }
        self::assertTrue(file_exists($basePath . 'UseCase.php'));
        self::assertTrue(file_exists($basePath . 'Request.php'));
        self::assertTrue(file_exists($basePath . 'Response.php'));
    }

    public function testGenerateTestsFiles(): void
    {
        $r = $this->service->generateTestsFiles(self::BASE_NAME_FOR_TEST);
        $projectDirPath = self::PROJECT_DIR;
        $basePath = $projectDirPath . self::BASE_PATH_TEST . self::BASE_NAME_FOR_TEST . '/';
        self::assertIsArray($r);
        foreach ($r as $result) {
            self::assertStringContainsString(self::BASE_NAME_FOR_TEST, $result);
        }
        self::assertTrue(file_exists($basePath . 'UseCaseTest.php'));
        self::assertTrue(file_exists($basePath . 'RequestTest.php'));
        self::assertTrue(file_exists($basePath . 'ResponseTest.php'));
    }

    /**
     * @return void
     */
    public static function tearDownAfterClass(): void
    {
        $projectDirPath = self::PROJECT_DIR;
        $basePath = $projectDirPath . self::BASE_PATH;
        $basePathTest = $projectDirPath . self::BASE_PATH_TEST;
        self::delTree($basePath);
        self::delTree($basePathTest);
    }

    /**
     * @param string $dirPath
     * @return void
     */
    private static function delTree(string $dirPath): void
    {
        $files = array_diff(scandir($dirPath), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$dirPath/$file")) ? self::delTree("$dirPath/$file") : unlink("$dirPath/$file");
        }
        rmdir($dirPath);
    }

    private function createService(): void
    {
        $this->service = new UseCaseGeneratorService(
            __DIR__ . '/../../var/PhpUnitTestFolder',
            __DIR__ . '/../../var/TestPhpUnitTestFolder',
            'UseCase',
            'Request',
            'Response',
            'App\UseCase',
            'App\Tests',
            __DIR__ . '/../..'
        );
    }
}