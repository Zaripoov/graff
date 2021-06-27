<?php


namespace frontend\modules\v1\models;


use function Symfony\Component\String\s;

class Dijkstra
{

    public $startIndex = null;
    public $finishIndex = null;

    public $way = [];
    public $wayIndex = -1;

    public $nodes = [];
    public $links = [];

    public $sum = 0;
    public $listPaths = [];

    public $w = [];



    public function __construct($start, $end, $nodes, $links)
    {
        $this->startIndex = $start;
        $this->finishIndex = $end;
        $this->nodes = $nodes;
        //$this->links = sort($links['start_point'], SORT_NUMERIC);
        $this->links = $links;

        $this->combingOutThePaths($start);
    }

    public function combingOutThePaths($nodeIndex){

        $this->wayIndex++;

        $this->way[$this->wayIndex] = $nodeIndex;



        if($nodeIndex == $this->finishIndex){



            foreach ($this->way as $key => $item){
                if($key == 0){
                    $wayPrevious = $item;
                }elseif($key > 0){
                    foreach ($this->links as $link){
                        if(($link['start_point'] == $wayPrevious) AND ($link['end_point'] == $item)){
                            $this->sum = $this->sum + $link['libra'];
                        }
                    }
                }

                $wayPrevious = $item;
            }

            $this->listPaths[] = ['path' => $this->way, 'sum' => $this->sum];

            //$this->pathSequence();
            $this->sum = 0;
        }elseif(($nodeIndex != $this->startIndex) OR ($this->wayIndex == 0)){
            foreach ($this->links as $i => $link){
                if ($link['start_point'] == $nodeIndex) {
                    $this->combingOutThePaths($link['end_point'], $this->finishIndex);
                }
            }
        }else{
            $this->sum = 0;

        }

        $this->wayIndex--;

    }


    public function shortStroke(){

        $minSum = 0;
        $sumPath =  [];

        foreach ($this->listPaths as $key => $path){
            $sumPath[] = $path['sum'];
            if($key == 0){
                $minSum = $path['sum'];
                $newKey = $key;
            }else{
                if($minSum > $path['sum']){
                    $minSum = $path['sum'];
                    $newKey = $key;
                }
            }
        }


        return $this->listPaths[$newKey] ;


    }

    public function pathSequence(){
        //return $this->listPaths[] = ['path' => $this->way, 'sum' => $this->sum];



        return $this->listPaths;
        //return $this->way;
    }







}