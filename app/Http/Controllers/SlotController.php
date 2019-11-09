<?php

    namespace App\Http\Controllers;

class SlotController extends Controller
{

    /**
     * @var array
     */
    private $values = [9, 10, 'J', 'Q', 'K', 'A', 'cat', 'dog', 'monkey', 'bird'];

    /**
     * @var array
     */
    private $slot = [];

    /**
     * @var array
     */
    private $paylines = [
        [0, 3, 6, 9, 12],
        [1, 4, 7, 10, 13],
        [2, 5, 8, 11, 14],
        [0, 4, 8, 10, 12],
        [2, 4, 6, 10, 14]
    ];

    /**
     * @var array
     */
    private $total_win = [];

    /**
     * @var int
     */
    private $bet = 100;

    /**
     *  Run all methods:
     *
     * Create a temporary board with random values from the given slot array
     * Create a display board with all the paylines and create the relation between both arrays
     * @return array
     */
    public function run()
    {
        $this->createBoard();
        $board = $this->createDisplay();
        $paylineArray = $this->getPayline();
        if (!empty($paylineArray)) {
            $this->total_win = $this->creditSlot(array_values($paylineArray));
        }
        return array(
            'board' => implode(",", $board),
            'paylines' => $paylineArray,
            'bet' => $this->bet,
            'total_win' => $this->total_win
        );
    }

    /**
     *   Return the same array but shuffle
     *
     * @return void
     */
    private function createBoard()
    {
        for ($i = 0; $i < 15; $i++) {
            $this->slot[] = $this->values[rand(0, 9)];
        }
    }

    /**
     *   Return the Board to display following the paylines and the order that it is given from the paylines.
     *
     * @return array
     */
    private function createDisplay()
    {
        $display = [];
        for ($i = 0; $i < 3; $i++) {
            foreach ($this->paylines[$i] as $payline) {
                $display[] = $this->slot[$payline];
            }
        }
        return $display;
    }

    /**
     *   Return the payline array
     *
     * @return array
     */

    private function getPayline()
    {
        $payline = [];
        $paylinesToCredit = [];
        for ($i = 0; $i < 5; $i++) {
            foreach ($this->paylines[$i] as $paylineIndex) {
                $payline[] = $this->slot[$paylineIndex];
            }
            $max = 5;
            for ($j = 0; $j < count($payline) - 1; $j++) {
                if ($payline[$j] != $payline[$j + 1]) {
                    $max = $j + 1;
                    break;
                }
            }
            if ($max > 2) {
                $paylineFormatted = implode(",", $this->paylines[$i]);
                $paylinesToCredit["$paylineFormatted"] = $max;
            }
            unset($payline);
        }
        return $paylinesToCredit;
    }

    /**
     *   Function to credit after the bet, following the payline
     *
     * @param $array
     * @return int : total to credit
     */
    private function creditSlot($array)
    {
        $total_win = [];
        foreach ($array as $matchItem) {
            switch ($matchItem) {
                case 3:
                    $total_win[] = $this->bet * 0.2;
                    continue;
                case 4:
                    $total_win[] = $this->bet * 2;
                    continue;
                case 5:
                    $total_win[] = $this->bet * 10;
                    continue;
            }
        }
            return array_sum($total_win);
    }
}
