<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 8/27/14
 * Time: 2:15 PM
 */

class PProject {

    private  $label;
    private $start;
    private $end;
    private $priority;
    private $timeStart;
    private $timeEnd;





    /**
     * @param mixed $timeEnd
     */
    public function setTimeEnd($timeEnd)
    {
        $this->timeEnd = $timeEnd;
    }

    /**
     * @return mixed
     */
    public function getTimeEnd()
    {
        return $this->timeEnd;
    }

    /**
     * @param mixed $timeStart
     */
    public function setTimeStart($timeStart)
    {
        $this->timeStart = $timeStart;
    }

    /**
     * @return mixed
     */
    public function getTimeStart()
    {
        return $this->timeStart;
    }





    public function __construct(){


    }

    /**
     * @return mixed
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return mixed
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @return mixed
     */
    public function getStart()
    {
        return $this->start;
    }




    /**
     * @param String $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @param mixed $priority
     * @see important or urgent
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * @param Date  $start
     */
    public function setStart($start)
    {
        $this->start = PMaskFormate::data_br_to_us($start);
    }

    /**
     * @param Date $end
     */
    public function setEnd($end)
    {
        $this->end = PMaskFormate::data_br_to_us($end);
    }







} 