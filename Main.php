<?php
require_once('Animal.php');

/**
 * Created by PhpStorm.
 * Author: Amy Luo
 * Date: 2016-06-10
 * Time: 20:58
 */
class Main
{
    const CLASS_NAME_GOAT = 'Goat';
    const CLASS_NAME_SHEEP = 'Sheep';

    protected static $MAXVALUE = 10000;
    protected static $QUANTITY = 100;

    private $primeNumberPool = [];
    private $countPrimePool;

    public function __construct()
    {
        $this->generatePrimeNumberInRange(self::$MAXVALUE);
        $this->countPrimePool = count($this->primeNumberPool);
    }

    /**
     * Get all prime number between 2 and $maxValue
     * @param int $maxValue
     *
     * @return array $primeArray
     */
    private function generatePrimeNumberInRange($maxValue)
    {
        $startValue = 2;
        do {
            $this->primeNumberPool[] = $startValue;
            $startValue = gmp_intval(gmp_nextprime($startValue));
        } while ($startValue <= $maxValue);

    }


    /**
     * Generate random key list
     */
    private function getPrimeKeyList()
    {
        $keyArray = range(0, $this->countPrimePool-1);
        shuffle($keyArray);
        $snArrayKey = array_slice($keyArray, 0, 100);
        sort($snArrayKey);

        return $snArrayKey;
    }

    /**
     * @param string $className
     * @return array $animals
     */
    private function getNewBornAnimals($className = null)
    {
        if (is_null($className)) {
            return false;
        }

        $snArrayKey = $this->getPrimeKeyList();
        $animals = [];
        foreach ($snArrayKey as $key) {
            $prime = $this->primeNumberPool[$key];
            $animals[$prime] = new $className($prime);
        }

        return $animals;
    }

    /**
     * @return array|bool
     */
    public function getNewBornSheep()
    {
        return $this->getNewBornAnimals(self::CLASS_NAME_SHEEP);
    }

    /**
     * @return array|bool
     */
    public function getNewBornGoat()
    {
        return $this->getNewBornAnimals(self::CLASS_NAME_GOAT);
    }

    /**
     * @param array $animals
     * @param string $fileName
     * @return bool
     */
    public function printToFile(array $animals, $fileName = null)
    {
        if (is_null($fileName) || empty($fileName)) {
            return false;
        }

        $file = fopen($fileName, "w") or die("Unable to open file");

        foreach ($animals as $animal) {
            $txt = $animal->getSn() . "\n";
            fwrite($file, $txt);
        }
        fclose($file);
    }

    public function getAnimalsSum(array $array)
    {
        $sum = 0;
        foreach ($array as $key => $item) {
            $sum = $sum + $key;
        }

        return $sum;
    }

    public function getAnimalsMean(array $array)
    {
        $mean = 0;
        if (empty($array)) {
            return $mean;
        }

        $sum = $this->getAnimalsSum($array);
        $mean = floor($sum / count($array));

        return $mean;
    }

    public function getAnimalsMinimum(array $array)
    {
        $min = 0;
        if (empty($array)) {
            return $min;
        }

        return min(array_keys($array));
    }

    public function getAnimalsMaximum(array $array)
    {
        $max = 0;
        if (empty($array)) {
            return max;
        }

        return max(array_keys($array));
    }

    public function getAnimalsMedian(array $array)
    {
        $median = 0;
        if (empty($array)) {
            return $median;
        }

        $count = count($array);
        if ($count % 2 == 0) {
            $id = $count / 2;
        } else {
            $id = ($count + 1) / 2;
        }

        return array_keys($array)[$id - 1];
    }

    public function getAnimalsRange(array $array)
    {
        $range = 0;
        if (empty($array)) {
            return $range;
        }

        return $this->getAnimalsMaximum($array) - $this->getAnimalsMinimum($array);
    }

    public function gerAnimalsGroup(array $array)
    {
        if (empty($array)) {
            return false;
        }

        $groups = [
            'One_Digit' => 0,
            'Two_Digits' => 0,
            'Three_Digits' => 0,
            'Four_Digits' => 0,
        ];
        foreach ($array as $key => $animal) {
            if ($key <= 9) {
                $groups['One_Digit']++;
            } elseif ($key <= 99) {
                $groups['Two_Digits']++;
            } elseif ($key <= 999) {
                $groups['Three_Digits']++;
            } else {
                $groups['Four_Digits']++;
            }
        }
        return $groups;
    }
}


$main = new Main();

// Get 100 Goat
$goats = $main->getNewBornGoat();

// Get 100 Sheep
$sheep = $main->getNewBornSheep();

// Print Goat sn to goat.txt
$main->printToFile($goats, 'goat.txt');
echo ("goat.txt created.\n\n");

// Print Sheep sn to sheep.txt
$main->printToFile($sheep, 'sheep.txt');
echo ("sheep.txt created.\n\n");

// Find paired goat & sheep by sn and print to soulmates.txt
$sharedKeys = array_intersect_key($goats, $sheep);
$main->printToFile($sharedKeys, 'soulmates.txt');
echo ("soulmates.txt created.\n\n");

// Output to screen with some interesting facts for goat or sheep
$resultMatrix = [];

$resultMatrix['Sum'] = [
    Main::CLASS_NAME_GOAT => $main->getAnimalsSum($goats),
    Main::CLASS_NAME_SHEEP => $main->getAnimalsSum($sheep),
];

$resultMatrix['Mean'] = [
    Main::CLASS_NAME_GOAT => $main->getAnimalsMean($goats),
    Main::CLASS_NAME_SHEEP => $main->getAnimalsMean($sheep),
];

$resultMatrix['Minimum'] = [
    Main::CLASS_NAME_GOAT => $main->getAnimalsMinimum($goats),
    Main::CLASS_NAME_SHEEP => $main->getAnimalsMinimum($sheep),
];

$resultMatrix['Maximum'] = [
    Main::CLASS_NAME_GOAT => $main->getAnimalsMaximum($goats),
    Main::CLASS_NAME_SHEEP => $main->getAnimalsMaximum($sheep),
];

$resultMatrix['Median'] = [
    Main::CLASS_NAME_GOAT => $main->getAnimalsMedian($goats),
    Main::CLASS_NAME_SHEEP => $main->getAnimalsMedian($sheep),
];

$resultMatrix['Range'] = [
    Main::CLASS_NAME_GOAT => $main->getAnimalsRange($goats),
    Main::CLASS_NAME_SHEEP => $main->getAnimalsRange($sheep),
];

$resultMatrix['Groups'] = [
    Main::CLASS_NAME_GOAT => $main->gerAnimalsGroup($goats),
    Main::CLASS_NAME_SHEEP => $main->gerAnimalsGroup($sheep),
];

$format = "|%15.15s |%10.10s |%10.10s |\n";
$tblRow = "|----------------|-----------|-----------|\n";
print($tblRow);
printf($format, 'Statistics', 'Goat', 'Sheep');
print($tblRow);

foreach ($resultMatrix as $typeName => $value) {
    if ($typeName == 'Groups') {
        printf($format, 'One Digits', $value[Main::CLASS_NAME_GOAT]['One_Digit'], $value[Main::CLASS_NAME_SHEEP]['One_Digit']);
        print($tblRow);
        printf($format, 'Two Digits', $value[Main::CLASS_NAME_GOAT]['Two_Digits'], $value[Main::CLASS_NAME_SHEEP]['Two_Digits']);
        print($tblRow);
        printf($format, 'Three Digits', $value[Main::CLASS_NAME_GOAT]['Three_Digits'], $value[Main::CLASS_NAME_SHEEP]['Three_Digits']);
        print($tblRow);
        printf($format, 'Four Digits', $value[Main::CLASS_NAME_GOAT]['Four_Digits'], $value[Main::CLASS_NAME_SHEEP]['Four_Digits']);
        print($tblRow);
    } else {
        printf($format, $typeName, $value[Main::CLASS_NAME_GOAT], $value[Main::CLASS_NAME_SHEEP]);
        print($tblRow);
    }
}

