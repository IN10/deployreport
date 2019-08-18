<?php

namespace App;

class Stage
{
    const TEST = 'test';
    const ACCEPTANCE = 'acceptance';
    const PRODUCTION = 'production';

    const ALL = [self::TEST, self::ACCEPTANCE, self::PRODUCTION];
}
