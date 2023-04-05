<?php


return[

    'permissions' => [

        'profile'=> 'profile control',
        'products'=> 'product control',
        'manage'=> 'manage control',
        'users'=> 'user control',
        'roles-permission'=> 'role-permission control',
        'tags'=> 'tag control',
        'attributes'=> 'attribute control',
        'options'=> 'option control',
        'settings' => 'settings control',
        'account' => 'account control',
        'complaints' => 'complaints control',
        'orders' => 'order control',
    ],


    'permissions_admin' => [
        //store
        'store'=> 'store control',
        'store_create' => 'add store',
        'store_edit' => 'edit store',
        'store_delete' => 'delete store',
        //profile
        'profile' => 'profile control',
        'profile_edit' => 'edit profile',
        'profile_security' => 'go to security profile',
        'profile_security' => 'update security profile',
        //role-permissions
        'role-permission' => 'role&permission control',
        'role-permission_create' => 'add role&permission',
        'role-permission_edit' => 'edit role&permission',
        'role-permission_delete' => 'delete role&permission',
        //user
        'user' => 'user control',
        'user_create' => 'add user',
        'user_edit' => 'edit user',
        'user_delete' => 'delete user',
        'user_show' => 'show user',
        //categories
        'category' => 'category control',
        'category_create' => 'add category',
        'category_edit' => 'edit category',
        'category_delete' => 'delete category',
        'category_show' => 'show category',
        'category_trash' => 'trash category',
        'category_force_delete' => 'force delete category',
        'category_restore' => 'restore category',
        //products
        'product' => 'product control',
        'product_create' => 'add product',
        'product_edit' => 'edit product',
        'product_delete' => 'delete product',
        'product_show' => 'show product',
        'product_trash' => 'trash product',
        'product_force_delete' => 'force delete product',
        'product_restore' => 'restore product',
        'product_variant' => 'add variant  product',
        'product_delete_variant' => 'delete variant product',
        //supplier
        'supplier' => 'supplier control',
        'supplier_create' => 'add supplier',
        'supplier_edit' => 'edit supplier',
        'supplier_delete' => 'delete supplier',
        'supplier_show' => 'show supplier',
        'supplier_trash' => 'trash supplier',
        'supplier_force_delete' => 'force delete supplier',
        'supplier_restore' => 'restore supplier',
        //client
        'client' => 'client control',
        'client_create' => 'add client',
        'client_edit' => 'edit client',
        'client_delete' => 'delete client',
        'client_show' => 'show client',
        'client_trash' => 'trash client',
        'client_force_delete' => 'force delete client',
        'client_restore' => 'restore client',
        //company
        'company' => 'company control',
        'company_create' => 'add company',
        'company_edit' => 'edit company',
        'company_delete' => 'delete company',
        'company_show' => 'show company',
        'company_trash' => 'trash company',
        'company_force_delete' => 'force delete company',
        'company_restore' => 'restore company',
        //tag
        'tag' => 'tag control',
        'tag_create' => 'add tag',
        'tag_edit' => 'edit tag',
        'tag_delete' => 'delete tag',
        'tag_show' => 'show tag',
        //attribute
        'attribute' => 'attribute control',
        'attribute_create' => 'add attribute',
        'attribute_edit' => 'edit attribute',
        'attribute_delete' => 'delete attribute',
        //'attribute_show' => 'show attribute',
        //plan
        'plan' => 'plan control',
        'plan_create' => 'add plan',
        'plan_edit' => 'edit plan',
        'plan_delete' => 'delete plan',
        //'plan_show' => 'show plan',
        //subscription
        'subscription' => 'subscription control',
        'subscriptione_create' => 'add subscription',
        'subscription_edit' => 'edit subscription',
        'subscription_delete' => 'delete subscription',
        'subscription_show' => 'show subscription',
    ],


    'permissions_user' => [

        'store'=> 'store control',
        'products'=> 'product control',
        'manage'=> 'manage control',
        'user'=> 'user control',
        'roles-permission'=> 'role-permission control',
        'settings' => 'settings control',
        'account' => 'account control',
        'subscription' => 'subscription control',
        'complaints' => 'complaints control',
        'store-setting' => 'store-setting control',
        'orders' => 'order control'
    ]



];
