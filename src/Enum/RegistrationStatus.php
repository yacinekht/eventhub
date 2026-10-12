<?php

namespace App\Enum;

enum RegistrationStatus: string
{

    case Cancelled ='cancelled';

    case Confirmed ='Confirmer';

    case Waitlist='Waitlist';

}
