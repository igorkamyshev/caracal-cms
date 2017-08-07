<?php

namespace AppBundle\DBAL;

use AppBundle\Entity\Contact;


class EnumContactType extends EnumType
{
    protected $name = 'enumcontacttype';
    protected $values = [
        Contact::PHONE_TYPE,
        Contact::EMAIL_TYPE,
        Contact::ADDRESS_TYPE,
    ];
}