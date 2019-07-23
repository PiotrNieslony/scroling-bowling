<?php


namespace App;


class Game
{
    private $knockedDownPins = array();
    private $sumInFrames = array();
    private $bonusInFrames = array();
    private $actualFrame = 0;
    private $actualRoll = 1;

    public function runGame(): void
    {
        while($this->actualFrame <= 10){
            echo "Enter frame: " . ($this->actualFrame +1)
                . ", roll ". $this->actualRoll . ": ";
            $this->roll($this->enterRoll());
            $this->printTableOfScors();
            echo "Sum of points: ". $this->sumOfPoints().PHP_EOL;
        }
        echo "You scored " . $this->sumOfPoints() . "points.";
    }

    public function roll($knockedDownPins): void
    {
        $this->knockedDownPins[$this->actualFrame][$this->actualRoll] = $knockedDownPins;

        if(isset($this->sumInFrames[$this->actualFrame]))
            $this->sumInFrames[$this->actualFrame] += $knockedDownPins;
        else
            $this->sumInFrames[$this->actualFrame] = $knockedDownPins;

        if ($this->actualFrame == 10 ){
            if ($knockedDownPins == 10 && $this->actualRoll == 1){
                $this->bonusInFrames[$this->actualFrame] = "strike";
                $this->addingBonus();
                $this->actualRoll = 3;
            } elseif ($sumInFrames[$this->actualFrame] == 10 && $this->actualRoll == 2){
                $this->addingBonus();
                $this->actualRoll = 3;
            } elseif ($this->actualRoll == 3){
                $this->addingBonus();
                $this->actualRoll = 3;
            }
        }
        elseif ($knockedDownPins == 10 && $this->actualRoll == 1) {
            $this->bonusInFrames[$this->actualFrame] = "strike";
            $this->addingBonus();
            $this->actualRoll = 1;
            $this->actualFrame++;
        } elseif ($sumInFrames[$this->actualFrame] == 10 && $this->actualRoll == 2) {
            $this->bonusInFrames[$this->actualFrame] = "spares";
            $this->addingBonus();
            $this->actualRoll = 1;
            $this->actualFrame++;
        } elseif ($this->actualRoll == 1) {
            $this->addingBonus();
            $this->actualRoll = 2;
        } elseif ($this->actualRoll == 2) {
            $this->addingBonus();
            $this->actualRoll = 1;
            $this->actualFrame++;
        }
    }

    private function addingBonus(): void
    {
        if(isset($this->bonusInFrames[($this->actualFrame) - 2])){
            if($this->bonusInFrames[($this->actualFrame) - 2] == 'strike'){
                $this->sumInFrames[($this->actualFrame) - 2] +=
                    $this->knockedDownPins[$this->actualFrame][$this->actualRoll];
            }
        }
        if (isset($this->bonusInFrames[($this->actualFrame) - 1])){
            $this->sumInFrames[($this->actualFrame) - 1] +=
                $this->knockedDownPins[$this->actualFrame][$this->actualRoll];
        }
    }

//    private function printTableOfScors()
//    {
//        const TOP_LINE = "╔══╤══╦══╤══╦══╤══╦══╤══╦══╤══╦══╤══╦══╤══╦══╤══╦══╤══╦══╤══╤══╗";
//        $secondLine    = "║";
//        for($i = 0; i >=21; i++){
//            $secondLine .=  (isset($knockedDownPins[$i][$j])) ? $knockedDownPins[$i][$j] : "  ";
//        }
//    }

    private function printTableOfScors()
    {
        foreach ($this->sumInFrames as $sumInFrame){
            echo " | ".$sumInFrame;
        }
        echo PHP_EOL;
    }

    private function sumOfPoints(): int
    {
        return array_sum ($this->sumInFrames);
    }

    private function enterRoll(): int
    {
        return intval(fgets(STDIN));
    }

}