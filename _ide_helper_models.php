<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement query()
 */
	class Agreement extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DepartmentPermission> $permissions
 * @property-read int|null $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereUpdatedAt($value)
 */
	class Department extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $department_id
 * @property string $resource
 * @property bool $can_view
 * @property bool $can_create
 * @property bool $can_update
 * @property bool $can_delete
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Department $department
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepartmentPermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepartmentPermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepartmentPermission query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepartmentPermission whereCanCreate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepartmentPermission whereCanDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepartmentPermission whereCanUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepartmentPermission whereCanView($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepartmentPermission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepartmentPermission whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepartmentPermission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepartmentPermission whereResource($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepartmentPermission whereUpdatedAt($value)
 */
	class DepartmentPermission extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $title
 * @property string $classification
 * @property string|null $team_members
 * @property string|null $target_agenda
 * @property string|null $location
 * @property string|null $time_frame
 * @property string|null $beneficiaries_who
 * @property int|null $beneficiaries_how_many
 * @property numeric|null $budget_ps
 * @property numeric|null $budget_mooe
 * @property numeric|null $budget_co
 * @property string|null $partner
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereBeneficiariesHowMany($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereBeneficiariesWho($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereBudgetCo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereBudgetMooe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereBudgetPs($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal wherePartner($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereTargetAgenda($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereTeamMembers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereTimeFrame($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereUpdatedAt($value)
 */
	class Proposal extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $record_code
 * @property string $title
 * @property string $link_url
 * @property int $maintenance_years
 * @property int $preservation_years
 * @property string|null $remarks
 * @property int $display_order
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordForm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordForm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordForm onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordForm query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordForm whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordForm whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordForm whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordForm whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordForm whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordForm whereLinkUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordForm whereMaintenanceYears($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordForm wherePreservationYears($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordForm whereRecordCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordForm whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordForm whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordForm whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordForm withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordForm withoutTrashed()
 */
	class RecordForm extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $department_id
 * @property string $user_type
 * @property string $username
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $college
 * @property string|null $phone
 * @property string|null $about
 * @property string|null $avatar_path
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Department|null $department
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAbout($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAvatarPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCollege($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUserType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
 */
	class User extends \Eloquent {}
}

