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
        var_dump($dateFormated);
        $nowFormated = date_format(new \DateTime(),'H:i');
        var_dump($nowFormated);
        $t1 = strtotime($dateFormated);
        $t2 = strtotime($nowFormated);

        return ($t2 - $t1) / 60;
    }
}