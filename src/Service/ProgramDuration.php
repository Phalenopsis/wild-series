<?php

namespace App\Service;

use App\Entity\Program;
class ProgramDuration
{
    public function calculate(Program $program): string
    {
        $hour = 60;
        $day =  24*60;
        $total = 0;
        foreach ($program->getSeasons() as $season){
            foreach ($season->getEpisodes() as $episode) {
                $total += $episode->getDuration();
            }
        }
        if ($total >= 60) {
            $durationMins = $total % $hour;
            if($total >= $day) {
                $durationHours = floor(($total % $day) / 60);
                $durationDays = floor($total / $day);
            }else{
                $durationHours = floor($total / 24);
                $durationDays = 0;
            }


        }else{
            $durationMins = $total;
            $durationHours = 0;
            $durationDays = 0;
        }
        return $durationDays . ' days, ' . $durationHours . ' hours, ' . $durationMins . ' minutes';
    }
}