<?php

return [
    'linkable_to_page' => true,
    'per_page' => 50,
    'order' => [
        'position' => 'asc',
    ],
    'sidebar' => [
        'icon' => '<i class="bi bi-person"></i>',
        'weight' => 70,
    ],
    'permissions' => [
        'read partners' => 'Read',
        'create partners' => 'Create',
        'update partners' => 'Update',
        'delete partners' => 'Delete',
    ],
];
