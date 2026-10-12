<?php

namespace App\Enum;

enum RoleUser : string
{
    case Admin='ROLE_ADMIN';
    case Organisateur = 'ROLE_ORGANIZER' ;
    case Utilisateur = 'ROLE_USER';

}
