<?php

namespace Libraries;

class Messenger
{
    const INFO = 1;
    const WARNING = 2;
    const ERROR = 3;
    
    public function info($message)
    {
        return $this->message(self::INFO, $message);
    }
    
    public function warning($message)
    {
        return $this->message(self::WARNING, $message);
    }
    
    protected function message($level, $message)
    {
        $this->messages[] = ['level' => $level, 'message' => $message];
    }
}