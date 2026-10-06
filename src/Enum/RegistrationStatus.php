<?php

namespace App\Enum;

enum RegistrationStatus: string
{

    case Cancelled ='cancelled';

    case Conformed ='Confirmer';

    case Waitlist='Waitlist';

}
