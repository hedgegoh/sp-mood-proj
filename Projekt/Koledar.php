<?php
    class CustvenKoledar
    {
        public string $dan;
        public string $mesec;
        public string $leto;

        private $custva = [];

        private $teden = [0 => 'Ponedeljek', 1 => 'Torek', 2 => 'Sreda', 3 => 'Četrtek', 4 => 'Petek', 5 => 'Sobota', 6 => 'Nedelja'];
        private $tedenAng = [0 => 'Mon', 1 => 'Tue', 2 => 'Wed', 3 => 'Thu', 4 => 'Fri', 5 => "Sat", 6 => 'Sun'];
        private $imeMeseci = [0 => 'Januar', 1 => 'Februar', 2 => 'Marec', 3 => 'April', 4 => 'Maj', 5 => 'Junij', 
                                6 => 'Julij', 7 => 'Avgust', 8 => 'September', 9 => 'Oktober', 10 => 'November', 11 => 'December'];

        // nastavi trenuten datum, ki ga bo prikazal koledar
        public function NastaviDatum(string $datum = null)
        {
            if ($datum != null)
            {
                $this->dan = date('d', strtotime($datum));
                $this->mesec = date('m', strtotime($datum));
                $this->leto = date('Y', strtotime($datum));
            }
            else
            {
                $this->mesec = date("m");
                $this->leto = date("Y");
            }
        }

        // izrise koledar v html formatu
        public function __toString()
        {
            $dneviMesec = date('t', strtotime($this->dan . '-' . $this->mesec . '-' . $this->leto));
            $zacetniDanMesec = array_search(date('D', strtotime($this->dan . '-' . $this->mesec . '-' . $this->leto)), $this->tedenAng);

            $imeMesec = $this->imeMeseci[intval($this->mesec) - 1];

            $html = "<div class = 'custvenKoledar'>";
            $html .= "<h3>" . $imeMesec . " " . $this->leto . "</h3>";
            $html .= "<table class = 'dneviTeden'><tr>";
            foreach ($this->teden as $dan)
            {
                $html .= "<th class = 'imeDneva'>" . $dan . "</th>";
            }
            $html .= "</tr><tr>";
            for ($i = 1; $i <= $dneviMesec + $zacetniDanMesec; $i++)
            { 
                if ($i < $zacetniDanMesec + 1)
                {
                    $html .= "<td></td>";
                }
                else
                {
                    $html .= "<td>" . $i - $zacetniDanMesec;

                    foreach ($this->custva as $custvo) 
                    {
                        for ($d = 0; $d <= ($custvo[2]-1); $d++) 
                        {
                            if (date('y-m-d', strtotime($this->leto . '-' . $this->mesec . '-' . $i - $zacetniDanMesec . ' -' . $d . ' day')) == date('y-m-d', strtotime($custvo[1]))) 
                            {
                                $html .= '<div class="' . $custvo[3] . '">';
                                $html .= $custvo[0];
                                $html .= '</div>';
                            }
                        }
                    }
                    $html .="</td>";
                    
                    if ($i % 7 == 0)
                    {
                        $html .= "</tr><tr>";
                    }
                    else if ($i == $dneviMesec + $zacetniDanMesec)
                    {
                        $html .= "</tr>";
                    }                
                }
                
            }
            
            $html .= "</table>";
            $html .= "</div>";

            return $html;
        }

        // Glede kateri mesec je vrne nazaj možnosti zbiranja dnevov
        public function dnevi_mesec($selecMonth)
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

        // doda custvo noter v izris koledarja
        public function dodaj_custvo(string $custvo, string $datum, int $zaporedniDni, string $barva)
        {
            $this->custva[] = [$custvo, $datum, $zaporedniDni, $barva];
        }
    }
?>

