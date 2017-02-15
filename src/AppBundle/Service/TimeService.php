<?php
/**
 * Created by PhpStorm.
 * User: itrascastro
 * Date: 31/1/17
 * Time: 0:01
 */

namespace AppBundle\Service;


class TimeService
{
    /**
     * Returns the difference in minutes between the input date and now
     *
     * @param \DateTime $date
     * @return float|int
     */
    public function timeDiff(\DateTime $date)
    {
        $dateFormated = date_format($date, 'H:i');
        $nowFormated = date_format(new \DateTime(),'H:i');
        $t1 = strtotime($dateFormated);
        $t2 = strtotime($nowFormated);

        return ($t2 - $t1) / 60;
    }

    public function dayOfWeek($dayNumber)
    {
        $dayOfWeek = '';

        switch ($dayNumber) {
            case 1:
                $dayOfWeek = 'Dilluns';
                break;
            case 2:
                $dayOfWeek = 'Dimarts';
                break;
            case 3:
                $dayOfWeek = 'Dimecres';
                break;
            case 4:
                $dayOfWeek = 'Dijous';
                break;
            case 5:
                $dayOfWeek = 'Divendres';
                break;
        }

        return $dayOfWeek;
    }
}