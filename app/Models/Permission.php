<?php

namespace App\Models;

use App\Traits\HasTimestampSerializable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    public const CAN_CREATE_CLIENT = 'create_client';
    public const CAN_UPDATE_CLIENT = 'update_client';
    public const CAN_DELETE_CLIENT = 'delete_client';
    public const CAN_VIEW_CLIENT = 'view_client';

    public const CAN_CREATE_COLLECTION = 'create_collection';
    public const CAN_UPDATE_COLLECTION = 'update_collection';
    public const CAN_DELETE_COLLECTION = 'delete_collection';
    public const CAN_VIEW_COLLECTION = 'view_collection';

    public const CAN_CREATE_PRODUCT = 'create_product';
    public const CAN_UPDATE_PRODUCT = 'update_product';
    public const CAN_DELETE_PRODUCT = 'delete_product';
    public const CAN_VIEW_PRODUCT = 'view_product';

    public const CAN_CREATE_PROJECT = 'create_project';
    public const CAN_UPDATE_PROJECT = 'update_project';
    public const CAN_DELETE_PROJECT = 'delete_project';
    public const CAN_VIEW_PROJECT = 'view_project';

    public const CAN_CREATE_PROPOSAL = 'create_proposal';
    public const CAN_UPDATE_PROPOSAL = 'update_proposal';
    public const CAN_DELETE_PROPOSAL = 'delete_proposal';
    public const CAN_VIEW_PROPOSAL = 'view_proposal';

    public const CAN_CREATE_ROLE = 'create_role';
    public const CAN_UPDATE_ROLE = 'update_role';
    public const CAN_DELETE_ROLE = 'delete_role';
    public const CAN_VIEW_ROLE = 'view_role';

    public const CAN_CREATE_PERMISSION = 'create_permission';
    public const CAN_UPDATE_PERMISSION = 'update_permission';
    public const CAN_DELETE_PERMISSION = 'delete_permission';
    public const CAN_VIEW_PERMISSION = 'view_permission';

    public const CAN_CREATE_SERVICE_TEMPLATE = 'create_service_template';
    public const CAN_UPDATE_SERVICE_TEMPLATE = 'update_service_template';
    public const CAN_DELETE_SERVICE_TEMPLATE = 'delete_service_template';
    public const CAN_VIEW_SERVICE_TEMPLATE = 'view_service_template';

    public const CAN_CREATE_USER = 'create_user';
    public const CAN_UPDATE_USER = 'update_user';
    public const CAN_DELETE_USER = 'delete_user';
    public const CAN_VIEW_USER = 'view_user';

    public const CAN_CREATE_TEAM = 'create_team';
    public const CAN_UPDATE_TEAM = 'update_team';
    public const CAN_DELETE_TEAM = 'delete_team';
    public const CAN_VIEW_TEAM = 'view_team';

    public $timestamps = false;

    /**
     * The roles that belong to the permission.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
