<?php

namespace RMiller\ErrorExtension\Observer;

interface ErrorObserver
{
    public function notify(array $error);
}
