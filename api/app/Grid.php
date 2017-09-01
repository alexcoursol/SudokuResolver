<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grid extends Model
{
    public $grid;

    public function __construct(array $grid)
    {
        $this->grid = $grid;
    }

    public function resolve(int $pos)
    {
        if ($pos == 9*9) return true;

        $x = (int) $pos / 9;
        $y = (int) $pos % 9;

        if ($this->grid[$x][$y] != 0) {
            return $this->resolve($pos+1);
        }

        for ($nb=1; $nb <= 9; $nb++) {

            if ($this->notInLine($nb, $x) && $this->notInCol($nb, $y) && $this->notInSquare($nb, $x, $y)) {

                $this->grid[$x][$y] = $nb;

                if ($this->resolve($pos + 1)) {
                    return true;
                }
            }
        }
        $this->grid[$x][$y] = 0;
        return false;
    }

    public function notInLine(int $nb, int $x) : bool
    {
        return (in_array($nb, $this->grid[$x])) ? false : true;
    }

    public function notInCol(int $nb, int $y) : bool
    {
        foreach($this->grid as $line){
            if ($line[$y] == $nb) return false;
        }
        return true;
    }

    public function notInSquare(int $nb, int $x, int $y) : bool
    {
        $startX = (int) ($x - ($x % 3));
        $startY = (int) ($y - ($y % 3));

        for ($i = $startX; $i < $startX + 3; $i++) {
            for ($j = $startY; $j < $startY + 3; $j++) {
                if ($this->grid[$i][$j] == $nb) return false;
            }
        }
        return true;
    }
}
