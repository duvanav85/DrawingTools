<?php

    class Draw {
        private $canvas = array();  
        private $command = "";      
        private $pixels = array();  
        private $supported_commands =  array("C", "L", "R", "B", "Q"); 

        private function drawLine($args, $char = "x") {
            $args = array_map("intval", $args); // make sure args are integers
            if($args[1] == $args[3]) { // horizontal line
                $line = range($args[0], $args[2]);
                foreach($line as $x)
                    $this->pixels[$x][$args[1]] = $char;
            } elseif($args[0] == $args[2]) { // vertical line
                $line = range($args[1], $args[3]);
                foreach($line as $y)
                    $this->pixels[$args[0]][$y] = $char;
            } else {
                return false;
            }
            return true;
        }

        private function floodFill($x, $y, $color) {
            if($x < 1 || $y < 1 || $x > $this->canvas[0] || $y > $this->canvas[1])
                return;

            if(isset($this->pixels[$x][$y]))
                return;

            $this->pixels[$x][$y] = $color;

            // call this method again to check more pixels in all 4 directions, this may use too much memory in which case there are other ways to do it: http://en.wikipedia.org/wiki/Flood_fill
            $this->floodFill($x-1, $y, $color);
            $this->floodFill($x+1, $y, $color);
            $this->floodFill($x, $y-1, $color);
            $this->floodFill($x, $y+1, $color);

        }

        public function controller($input) {
            $this->command = substr($input, 0, 1);

            $output = "";

            if(in_array($this->command, $this->supported_commands)) {

                if($this->command != "Q") {
                    $args = explode(" ", substr($input, 2));
                    // at this point we could do some validation on the args but maybe it's not required just for the coding challenge?
                    if($this->command == "C") {
                        $this->pixels = array();  // clear existing lines if canvas is resized
                        $this->canvas = array_slice($args, 0, 2);
                    } elseif(empty($this->canvas)) {
                        $output = "Please use C first to set the canvas." . "\n";
                    } elseif($this->command == "L") {
                        if(!$this->drawLine($args))
                            $output = "Sorry only horizontal and vertical lines are supported at this time." . "\n";
                    } elseif($this->command == "R") {
                        $this->drawLine(array($args[0], $args[1], $args[2], $args[1]));
                        $this->drawLine(array($args[0], $args[3], $args[2], $args[3]));
                        $this->drawLine(array($args[0], $args[1], $args[0], $args[3]));
                        $this->drawLine(array($args[2], $args[1], $args[2], $args[3]));
                    } elseif($this->command == "B") {
                        $color = substr($args[2], 0, 1);
                        $this->floodFill($args[0], $args[1], $color);
                    }


                    if($output == "") { // draw the canvas if no errors
                        for($r = 0; $r <= $this->canvas[1] + 1; $r++ ) {
                            for($c = 0; $c <= $this->canvas[0] + 1; $c++ ) {
                                if($r == 0 || $r == $this->canvas[1] + 1)
                                    $output .= "-";
                                elseif($c == 0 || $c == $this->canvas[0] + 1)
                                    $output .= "|";
                                elseif(isset($this->pixels[$c][$r]))
                                    $output .= $this->pixels[$c][$r];
                                else
                                    $output .= " ";
                            }
                            $output .= "\n";
                        }
                    }
                }

            } else {
                $output = "Command $this->command not recognized." . "\n";
            }

            return $output;
        }

        
        public function consoleListener() {
            while($this->command != "Q") {
                echo "enter command: ";
                $input = stream_get_line(STDIN, 1024, PHP_EOL);
                echo $this->controller($input);
            }
        }

    }
?>