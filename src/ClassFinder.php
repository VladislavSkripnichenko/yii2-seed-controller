<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\seeds;

use DirectoryIterator;
use FilesystemIterator;
use IteratorIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

/**
 * Class ClassFinder
 *
 * @package sonrac\seeds
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class ClassFinder
{
    private static $instance;
    /**
     * @var string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    private $vendorBaseDir;
    /**
     * @var null
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    private $loader = null;
    private $psr4Cache = null;

    private function __construct($appRoot)
    {
        $this->vendorBaseDir = $appRoot;

        $vendor = substr_count($this->vendorBaseDir, '/vendor') > 0 ? '' : '/vendor';
        $loaderPath = $this->vendorBaseDir . $vendor . '/autoload.php';

        if (!file_exists($loaderPath)) {
            throw new \Exception('Composer autoload file was not found' . "\n");
        }

        $this->loader = require $loaderPath;
    }

    /**
     * Path to vendor dir
     *
     * @param null|string $appRoot
     *
     * @return ClassFinder
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public static function getInstance($vendorBaseDir = null)
    {
        return self::$instance && !$vendorBaseDir ? self::$instance : self::$instance = new self($vendorBaseDir);
    }

    public static function recFindByExt($dir, array $extensions, $rec = true)
    {
        $extensionList = is_string($extensions) ? $extensions : implode('|', $extensions);
        $regex = '#^(?:[A-Z]:)?(?:/(?!\.Trash)[^/]+)+/[^/]+\.(?:' . $extensionList . ')$#Di';
        $files = [];
        $flags = FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::SKIP_DOTS | FilesystemIterator::UNIX_PATHS;

        if (!$rec) {
            $Directory = new DirectoryIterator($dir);
            $Iterator = new IteratorIterator($Directory, $flags);

            foreach ($Iterator as $item) {
                /** @var $item \SplFileInfo */

                if (!in_array($item->getExtension(), $extensions) || $item->isDir()) {
                    continue;
                }

                $files[] = $item->getPathname();
            }

            sort($files);
            return $files;
        }

        $Directory = new RecursiveDirectoryIterator($dir);
        $Iterator = new RecursiveIteratorIterator($Directory);
        $Regex = new RegexIterator($Iterator, $regex, RegexIterator::GET_MATCH);

        foreach ($Regex as $regex) {
            if (!count($regex) || (!isset($regex[0])) || (isset($regex[0]) && (!is_file($regex[0]) || is_dir($regex[0])))) {
                continue;
            }
            $files[] = $regex[0];
        }

        return $files;
    }

    /**
     * Get path to namespace
     *
     * @param string      $namespace
     * @param null|string $part
     *
     * @return array|string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function getNameSpacePath($namespace, $part = null)
    {
        $autoloadConfig = $this->getComposerAutoLoadModules();

        $realNamespace = ltrim(str_replace('/', '\\', $namespace . '\\'), '\\');
        if ($realNamespace == '\\\\') {
            return '';
        }
        $isset = isset($autoloadConfig[$realNamespace]);
        if ($isset) {
            $path = $autoloadConfig[$realNamespace][0];
            $ret = [
                'path'          => realpath(str_replace('\\', '/', ($path . ($part ? '/' . $part : '')))),
                'namespaceReal' => $namespace,
            ];

            return $ret;
        }

        $baseName = basename(str_replace('\\', '/', $namespace));

        if ($baseName == $namespace && (empty($part) || ($part && !substr_count($part, $baseName)))) {
            return [
                'path'          => str_replace('\\', '/', $part),
                'namespaceReal' => '',
            ];
        }
        $part = $baseName . "/" . ($part ? '/' . $part : '');

        return $this->getNameSpacePath(dirname(str_replace('\\', '/', $namespace)), $part);
    }

    /**
     * Get psr4 autoload namespaces
     *
     * @return array
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function getComposerAutoLoadModules()
    {
        return $this->psr4Cache ?? $this->psr4Cache = $this->loader->getPrefixesPsr4();
    }
}