<?php

return [
    'credential' => [
        'Grant-Type' => 'authentication_from_opp', // ERP team user
        'Client-Id' => 'erp',
        'Client-Secret' => '8WmFQNsHTCDLKbcYE7Ra5wqEqLZdBHqzzhzzZ5fTqeQH4C9Q6TKYVMWWsNtgJEcT',
        'token_type' => 'Bearer',
        'cipher' => [
            'password' => 'Ue9u925pg2HHbEzddjT8X2EezzVc6rJB', // Must be 32 digits
            'iv' => 'M4d4rv9RSfjeHA53', // Must be 16 digits
            'variance' => 5, // The variance of second that allow to access
        ],
    ],
];