<?php

namespace App\Modules\EnumManager;

enum QuestionEnum:int {
    case Short_text = 0;
    case Long_text = 1;
    case Checkbox = 2;
    case Radio_button = 3;
}