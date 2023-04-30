<?php

class Calendar 
{
    public $active_year, $active_month, $active_day;
    private $events = [];

    public function __construct($date = null) {
        $this->active_year = $date != null ? date('Y', strtotime($date)) : date('Y');
        $this->active_month = $date != null ? date('m', strtotime($date)) : date('m');
        $this->active_day = $date != null ? date('d', strtotime($date)) : date('d');
    }

    /*
    / Adds event on the calendar.
    / @param: $txt; text that displays in calendar.
    / @param: $date; date of the event, formy [yyyy-mm-dd].
    / @param: $days; num of days the event continues.
    / @param: $color; default value is empty string or takes 'red', 'green', 'blue'.
    */
    public function add_event($txt, $date, $days = 1, $color = '') {
        $color = $color ? ' ' . $color : $color;
        $this->events[] = [$txt, $date, $days, $color];
    }

    /*
    / Constructs the calendar in html formating.
    */
    public function __toString() {
        $num_days = date('t', strtotime($this->active_day . '-' . $this->active_month . '-' . $this->active_year));
        $num_days_last_month = date('j', strtotime('last day of previous month', strtotime($this->active_day . '-' . $this->active_month . '-' . $this->active_year)));
        $days = [0 => 'Mon', 1 => 'Tue', 2 => 'Wed', 3 => 'Thu', 4 => 'Fri', 5 => 'Sat', 6 => 'Sun'];
        $first_day_of_week = array_search(date('D', strtotime($this->active_year . '-' . $this->active_month . '-1')), $days);
        $html = '<div class="calendar">';
        $html .= '<div class="header">';
        $html .= '<div class="month-year">';
        $html .= date('F Y', strtotime($this->active_year . '-' . $this->active_month . '-' . $this->active_day));
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="days">';
        foreach ($days as $day) {
            $html .= '
                <div class="day_name">
                    ' . $day . '
                </div>
            ';
        }
        for ($i = $first_day_of_week; $i > 0; $i--) {
            $html .= '
                <div class="day_num ignore">
                    ' . ($num_days_last_month-$i+1) . '
                </div>
            ';
        }
        for ($i = 1; $i <= $num_days; $i++) {
            $selected = '';
            if ($i == $this->active_day) 
            {
                $selected = ' selected';                
            }
            $html .= '<div class="day_num' . $selected . '">';
            $html .= '<span>' . $i . '</span>';
            foreach ($this->events as $event) {
                for ($d = 0; $d <= ($event[2]-1); $d++) {
                    if (date('y-m-d', strtotime($this->active_year . '-' . $this->active_month . '-' . $i . ' -' . $d . ' day')) == date('y-m-d', strtotime($event[1]))) {
                        $html .= '<div class="event' . $event[3] . '">';
                        $html .= $event[0];
                        $html .= '</div>';
                    }
                }
            }
            $html .= '</div>';
        }
        for ($i = 1; $i <= (42-$num_days-max($first_day_of_week, 0)); $i++) {
            $html .= '
                <div class="day_num ignore">
                    ' . $i . '
                </div>
            ';
        }
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

    /*
    / Gets number of days in a month. 
    / @param: $selecMonth; currently selected month the calendar displays.
    / @return: returns option values for drop down selection window in html formating. 
    */
    public function GetNumOfDays($selecMonth)
    {
        $evenMonths = array(4,6,9,11);
        $oddMonths = array(1,3,5,7,8,10,12);
        $html = "";

        if ($selecMonth == 2)
        {
            for ($x = 1; $x <= 28; $x++)
            {
                $html .= '<option value="' . $x . '">' . $x . '</option>';
            }
        }
        else
        {
            foreach ($oddMonths as $month)
            {
                if ($selecMonth == $month)
                {
                    for ($x = 1; $x <= 31; $x++)
                    {
                        $html .= '<option value="' . $x . '">' . $x . '</option>';
                    }
                }
            }
            foreach ($evenMonths as $month)
            {
                if ($selecMonth == $month)
                {
                    for ($x = 1; $x <= 30; $x++)
                    {
                        $html .= '<option value="' . $x . '">' . $x . '</option>';
                    }
                }
            }
        }
        return $html;
    }
}
?>