<?php
return [
    'access' => [
        'list-supplier' => 'list_supplier',
        'add-supplier' => 'add_supplier',
        'edit-supplier' => 'edit_supplier',
        'update-supplier' => 'update_supplier',
        'delete-supplier' => 'delete_supplier',
        'restore-supplier' => 'restore_supplier',
        'action-supplier' => 'restore_supplier',

        'list-category' => 'list_cat',
        'edit-category' => 'edit_cat',
        'delete-category' => 'delete_cat',

        'list-product' => 'list_product',
        'add-product' => 'add_product',
        'edit-product' => 'edit_product',
        'delete-product' => 'delete_product',
        'restore-product' => 'restore_product',
        'detail-product' => 'detail_product',

        'list-orderform' => 'list_input',
        'add-orderform' => 'add_input',
        'edit-orderform' => 'edit_input',
        'delete-orderform' => 'delete_input',
        'detail-orderform' => 'detail_input',

        'list-output' => 'list_output',
        'add-output' => 'add_output',
        'edit-output' => 'edit_output',
        'delete-output' => 'delete_output',

        'list-input' => 'list_ip',
        'add-input' => 'add_ip',
        'edit-input' => 'edit_ip',
        'delete-input' => 'delete_ip',

        'list-staff' => 'list_staff',
        'add-staff' => 'add_staff',
        'edit-staff' => 'edit_staff',
        'delete-staff' => 'delete_staff',
        'restore-staff' => 'restore_staff',

        'list-role' => 'list_role',
        'add-role' => 'add_role',
        'edit-role' => 'edit_role',
        'delete-role' => 'delete_role',

        'add-permission' => 'add_permission',

    ],

    'table_module' => [
        'supplier',
        'product',
        'orderform',
        'input',
        'output',
        'user',
        'role',
        'test',
    ],

    'module_children' => [
        'list',
        'add',
        'edit',
        'delete',
        'restore'
    ]
];
