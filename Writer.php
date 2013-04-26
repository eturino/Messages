<?php

interface EtuDev_Messages_Writer
{
    public function addMessage($type, $message);

    public function getMessages($destroyAfterRead = true);
}