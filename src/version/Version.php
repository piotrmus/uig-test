<?php
/**
 * Created by PhpStorm.
 * User: Piotr Musial
 * Date: 2019-02-28
 * Time: 18:53
 */

namespace App\Version;


class Version
{
    private $levels = [];

    private $testLevel = 0;

    CONST TEST_ALPHA = 2;
    CONST TEST_BETA = 1;

    const TEST_ALPHA_SYMBOL = 'a';
    const TEST_BETA_SYMBOL = 'b';

    public function __construct(string $input)
    {
        $sections = explode('.', $input);
        $lastElement = $sections[count($sections) - 1];

        if (strtolower(substr($lastElement, strlen($lastElement) - 1, 1)) == self::TEST_ALPHA_SYMBOL) {
            $this->testLevel = self::TEST_ALPHA;
        }
        if (strtolower(substr($lastElement, strlen($lastElement) - 1, 1)) == self::TEST_BETA_SYMBOL) {
            $this->testLevel = self::TEST_BETA;
        }

        foreach ($sections as $section) {
            $this->levels[] = (int)$section;
        }
    }

    public function getLevel(int $number)
    {
        if (isset($this->levels[$number - 1])) {
            return $this->levels[$number - 1];
        }
        return 0;
    }

    public function getLevelDeep()
    {
        return count($this->levels);
    }

    public function getTestLevel()
    {
        return $this->testLevel;
    }

    public function compare(Version $compareVersion)
    {
        $maxDeep = $this->getLevelDeep() > $compareVersion->getLevelDeep() ? $this->getLevelDeep() : $compareVersion->getLevelDeep();
        for ($i = 1; $i <= $maxDeep; $i++) {
            if ($this->getLevel($i) != $compareVersion->getLevel($i)) {
                return ($this->getLevel($i) < $compareVersion->getLevel($i)) ? 1 : 0;
            }
        }
        if ($this->getTestLevel() != $compareVersion->getTestLevel()) {
            return ($this->getTestLevel() < $compareVersion->getTestLevel()) ? 0 : 1;

        }
        return -1;
    }
}
