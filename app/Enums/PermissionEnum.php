<?php

namespace App\Enums;

enum PermissionEnum: string
{
    // Admin Permissions
    case VIEW_DASHBOARD = 'view dashboard';

    case VIEW_USERS = 'view users';
    case CREATE_USERS = 'create users';
    case EDIT_USERS = 'edit users';
    case DELETE_USERS = 'delete users';
    case ASSIGN_ROLES = 'assign roles';
    case ACTIVATE_USERS = 'activate users';
    case DEACTIVATE_USERS = 'deactivate users';

    case VIEW_ROLES = 'view roles';
    case CREATE_ROLES = 'create roles';
    case EDIT_ROLES = 'edit roles';
    case DELETE_ROLES = 'delete roles';

    case VIEW_PRODUCTS = 'view products';
    case CREATE_PRODUCTS = 'create products';
    case EDIT_PRODUCTS = 'edit products';
    case DELETE_PRODUCTS = 'delete products';

    case VIEW_CATEGORIES = 'view categories';
    case CREATE_CATEGORIES = 'create categories';
    case EDIT_CATEGORIES = 'edit categories';
    case DELETE_CATEGORIES = 'delete categories';

    case VIEW_ORDERS = 'view orders';
    case VIEW_ORDER = 'view order';
    case EDIT_ORDERS = 'edit orders';
    case DELETE_ORDERS = 'delete orders';

    case VIEW_MESSAGES = 'view messages';
    case REPLY_MESSAGES = 'reply messages';
    case DELETE_MESSAGES = 'delete messages';

    CASE VIEW_ACTIVITIES = 'view activities';
    CASE SEARCH_ACTIVITIES = 'search activities';
    CASE CLEAR_ACTIVITIES = 'clear activities';

    case VIEW_SETTINGS = 'view settings';
    case EDIT_GENERAL_SETTINGS = 'edit general settings';
    case EDIT_ORDER_SETTINGS = 'edit order settings';
    case EDIT_NOTIFICATION_SETTINGS = 'edit notification settings';
    case EDIT_SOCIAL_SETTINGS = 'edit social settings';

    // User Permissions
    case VIEW_PROFILE = 'view profile';
    case EDIT_PROFILE = 'edit profile';
    case DELETE_ACCOUNT = 'delete account';
    case PLACE_ORDERS = 'place orders';
    case VIEW_MY_ORDERS = 'view my orders';
    case CANCEL_ORDERS = 'cancel orders';
    case SEND_MESSAGES = 'send messages';
    case VIEW_MY_MESSAGES = 'view my messages';

    // Helper method to get all permissions as an array of strings
    public static function getAllPermissions(): array
    {        
        return array_map(fn($permission) => $permission->value, self::cases());
    }
}