<?php

namespace App\Http\Controllers;

use App\Grid;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GridController extends Controller
{
    public $error = '';

    public function resolve(Request $request)
    {
        $gridArray = json_decode($request->get('grid'));

        $grid = new Grid($gridArray);

        if (! $this->validateGrid($grid)) {
            return new JsonResponse(['grid' => [], 'error' => $this->error]);
        }

        $grid->resolve(0);

        return new JsonResponse(['grid' => $grid->grid, 'error' => null]);
    }

    private function validateGrid(Grid $grid)
    {
        $gridValues = $grid->grid;

        $checkEmpty = 0;

        /** @var array $row */
        foreach ($gridValues as $row) {
            $checkEmpty += array_sum($row);
        }

        if ($checkEmpty == 0) {
            $this->error = 'Grid empty';
            return false;
        }

        for ($i = 0; $i < 9; $i++) {
            for ($j = 0; $j < 9; $j++) {

                $value = $gridValues[$i][$j];

                if ($value != 0) {

                    if ($this->errorLine($value, $gridValues[$i])) {
                        $this->error = 'Duplicate ' . $value . ' on line ' . ($i + 1);
                        return false;
                    }

                    if ($this->errorCol($value, $gridValues, $j)) {
                        $this->error = 'Duplicate ' . $value . ' on column ' . ($j + 1);
                        return false;
                    }

//                    if ($this->errorSquare($value, $gridValues, $j, $i)) {
//                        $this->error = 'Duplicate ' . $value . ' on a square';
//                        return false;
//                    }
                }
            }
        }

        return true;
    }

    private function errorLine(int $value, array $row) : bool
    {
        $checkError = 0;

        for ($i = 0; $i < 9 ; $i++) {
            if ($value == $row[$i]) {
                $checkError++;
            }
        }
        return ($checkError > 1) ? true : false;
    }

    private function errorCol(int $value, array $grid, int $j) : bool
    {
        $checkError = 0;

        for ($i = 0; $i < 9 ; $i++) {
            if ($value == $grid[$i][$j]) {
                $checkError++;
            }
        }
        return ($checkError > 1) ? true : false;
    }

//    private function errorSquare($value, $gridValues, $x, $y)
//    {
//        $checkError = 0;
//        $startX = (int) ($x - ($x % 3));
//        $startY = (int) ($y - ($y % 3));
//
//        for ($i = $startX; $i < $startX + 3; $i++) {
//            for ($j = $startY; $j < $startY + 3; $j++) {
//                if ($gridValues[$i][$j] == $value) {
//                    $checkError++;
//                }
//            }
//        }
//        return ($checkError > 1) ? true : false;
//    }
}
