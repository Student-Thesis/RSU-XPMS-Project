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
 * @property string $id
 * @property string|null $user_id
 * @property string|null $notifiable_user_id
 * @property string $action
 * @property string|null $model_type
 * @property string|null $model_id
 * @property array<array-key, mixed>|null $changes
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property string|null $read_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $notifiableUser
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereChanges($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereNotifiableUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereUserId($value)
 */
	class ActivityLog extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $organization_name
 * @property \Illuminate\Support\Carbon $date_signed
 * @property string|null $mou_path
 * @property string|null $mou_link
 * @property string|null $moa_path
 * @property string|null $moa_link
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement whereDateSigned($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement whereMoaLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement whereMoaPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement whereMouLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement whereMouPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement whereOrganizationName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement whereUserId($value)
 */
	class Agreement extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property string|null $type
 * @property string $priority
 * @property string $visibility
 * @property string|null $color
 * @property string|null $location
 * @property int $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarEvent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarEvent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarEvent query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarEvent whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarEvent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarEvent whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarEvent whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarEvent whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarEvent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarEvent whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarEvent wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarEvent whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarEvent whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarEvent whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarEvent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarEvent whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CalendarEvent whereVisibility($value)
 */
	class CalendarEvent extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DepartmentPermission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
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
 * @property string $name
 * @property string|null $address
 * @property string|null $room
 * @property string|null $notes
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventLocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventLocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventLocation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventLocation whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventLocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventLocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventLocation whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventLocation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventLocation whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventLocation whereRoom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventLocation whereUpdatedAt($value)
 */
	class EventLocation extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $campus_college
 * @property int $num_faculties
 * @property int $involved_extension_total
 * @property int $involved_extension_q1
 * @property int $involved_extension_q2
 * @property int $involved_extension_q3
 * @property int $involved_extension_q4
 * @property int $iec_developed_total
 * @property int $iec_developed_q1
 * @property int $iec_developed_q2
 * @property int $iec_developed_q3
 * @property int $iec_developed_q4
 * @property int $iec_reproduced_total
 * @property int $iec_reproduced_q1
 * @property int $iec_reproduced_q2
 * @property int $iec_reproduced_q3
 * @property int $iec_reproduced_q4
 * @property int $iec_distributed_total
 * @property int $iec_distributed_q1
 * @property int $iec_distributed_q2
 * @property int $iec_distributed_q3
 * @property int $iec_distributed_q4
 * @property int $proposals_approved_total
 * @property int $proposals_approved_q1
 * @property int $proposals_approved_q2
 * @property int $proposals_approved_q3
 * @property int $proposals_approved_q4
 * @property int $proposals_implemented_total
 * @property int $proposals_implemented_q1
 * @property int $proposals_implemented_q2
 * @property int $proposals_implemented_q3
 * @property int $proposals_implemented_q4
 * @property int $proposals_documented_total
 * @property int $proposals_documented_q1
 * @property int $proposals_documented_q2
 * @property int $proposals_documented_q3
 * @property int $proposals_documented_q4
 * @property int $community_served_total
 * @property int $community_served_q1
 * @property int $community_served_q2
 * @property int $community_served_q3
 * @property int $community_served_q4
 * @property int $beneficiaries_assistance_total
 * @property int $beneficiaries_assistance_q1
 * @property int $beneficiaries_assistance_q2
 * @property int $beneficiaries_assistance_q3
 * @property int $beneficiaries_assistance_q4
 * @property int $moa_mou_total
 * @property int $moa_mou_q1
 * @property int $moa_mou_q2
 * @property int $moa_mou_q3
 * @property int $moa_mou_q4
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereBeneficiariesAssistanceQ1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereBeneficiariesAssistanceQ2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereBeneficiariesAssistanceQ3($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereBeneficiariesAssistanceQ4($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereBeneficiariesAssistanceTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereCampusCollege($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereCommunityServedQ1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereCommunityServedQ2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereCommunityServedQ3($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereCommunityServedQ4($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereCommunityServedTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereIecDevelopedQ1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereIecDevelopedQ2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereIecDevelopedQ3($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereIecDevelopedQ4($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereIecDevelopedTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereIecDistributedQ1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereIecDistributedQ2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereIecDistributedQ3($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereIecDistributedQ4($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereIecDistributedTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereIecReproducedQ1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereIecReproducedQ2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereIecReproducedQ3($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereIecReproducedQ4($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereIecReproducedTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereInvolvedExtensionQ1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereInvolvedExtensionQ2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereInvolvedExtensionQ3($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereInvolvedExtensionQ4($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereInvolvedExtensionTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereMoaMouQ1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereMoaMouQ2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereMoaMouQ3($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereMoaMouQ4($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereMoaMouTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereNumFaculties($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereProposalsApprovedQ1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereProposalsApprovedQ2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereProposalsApprovedQ3($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereProposalsApprovedQ4($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereProposalsApprovedTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereProposalsDocumentedQ1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereProposalsDocumentedQ2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereProposalsDocumentedQ3($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereProposalsDocumentedQ4($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereProposalsDocumentedTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereProposalsImplementedQ1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereProposalsImplementedQ2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereProposalsImplementedQ3($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereProposalsImplementedQ4($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereProposalsImplementedTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereUpdatedAt($value)
 */
	class Faculty extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $sender_id
 * @property int $recipient_id
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $recipient
 * @property-read \App\Models\User $sender
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PrivateMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PrivateMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PrivateMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PrivateMessage whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PrivateMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PrivateMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PrivateMessage whereRecipientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PrivateMessage whereSenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PrivateMessage whereUpdatedAt($value)
 */
	class PrivateMessage extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
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
 * @property string|null $leader
 * @property string|null $college_campus
 * @property bool $in_house
 * @property bool $revised_proposal
 * @property bool $ntp
 * @property bool $endorsement
 * @property bool $proposal_presentation
 * @property bool $proposal_documents
 * @property bool $program_proposal
 * @property bool $project_proposal
 * @property bool $moa_mou
 * @property bool $activity_design
 * @property bool $certificate_of_appearance
 * @property bool $attendance_sheet
 * @property bool $photos
 * @property bool $terminal_report
 * @property string|null $source_of_funds
 * @property numeric|null $expenditure
 * @property string|null $fund_utilization_rate
 * @property string $status
 * @property string|null $approved_by
 * @property string|null $approved_at
 * @property string|null $documentation_report
 * @property string|null $code
 * @property string|null $remarks
 * @property string|null $drive_link
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read float $approved_budget
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereActivityDesign($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereAttendanceSheet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereBeneficiariesHowMany($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereBeneficiariesWho($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereBudgetCo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereBudgetMooe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereBudgetPs($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereCertificateOfAppearance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereCollegeCampus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereDocumentationReport($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereDriveLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereEndorsement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereExpenditure($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereFundUtilizationRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereInHouse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereLeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereMoaMou($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereNtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal wherePartner($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal wherePhotos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereProgramProposal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereProjectProposal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereProposalDocuments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereProposalPresentation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereRevisedProposal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereSourceOfFunds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereTargetAgenda($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereTeamMembers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereTerminalReport($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereTimeFrame($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proposal whereUserId($value)
 */
	class Proposal extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PublicMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PublicMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PublicMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PublicMessage whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PublicMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PublicMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PublicMessage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PublicMessage whereUserId($value)
 */
	class PublicMessage extends \Eloquent {}
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
 * @property string $name
 * @property string $slug
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingsClassification active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingsClassification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingsClassification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingsClassification onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingsClassification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingsClassification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingsClassification whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingsClassification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingsClassification whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingsClassification whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingsClassification whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingsClassification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingsClassification withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingsClassification withoutTrashed()
 */
	class SettingsClassification extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingsTargetAgenda active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingsTargetAgenda newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingsTargetAgenda newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingsTargetAgenda onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingsTargetAgenda query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingsTargetAgenda whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingsTargetAgenda whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingsTargetAgenda whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingsTargetAgenda whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingsTargetAgenda whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingsTargetAgenda whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingsTargetAgenda whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingsTargetAgenda withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettingsTargetAgenda withoutTrashed()
 */
	class SettingsTargetAgenda extends \Eloquent {}
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
 * @property string $status
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Department|null $department
 * @property-read string $full_name
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUserType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
 */
	class User extends \Eloquent {}
}

