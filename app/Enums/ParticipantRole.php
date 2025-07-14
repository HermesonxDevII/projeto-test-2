<?php

namespace App\Enums;

enum ParticipantRole: string
{
    case OWNER = 'owner';
    case ADMIN = 'admin';
    case PARTICIPANT = 'participant';

}
