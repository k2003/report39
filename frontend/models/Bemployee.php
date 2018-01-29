<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "b_employee".
 *
 * @property string $b_employee_id
 * @property string $employee_login
 * @property string $employee_password
 * @property string $employee_firstname
 * @property string $employee_lastname
 * @property string $employee_number
 * @property string $employee_last_login
 * @property string $employee_last_logout
 * @property string $employee_active
 * @property string $b_service_point_id
 * @property string $f_employee_level_id
 * @property string $f_employee_rule_id
 * @property string $f_employee_authentication_id
 * @property string $b_employee_default_tab
 * @property string $employee_warning_dx
 * @property string $record_date_time
 * @property string $update_date_time
 * @property string $employee_warning_icd10
 * @property string $t_person_id
 * @property string $provider
 * @property string $f_provider_council_code_id
 * @property string $f_provider_type_id
 * @property string $start_date
 * @property string $out_date
 * @property string $move_from
 * @property string $move_to
 * @property string $employee_number_issue_date
 * @property string $is_main_doctor
 * @property string $b_visit_clinic_id
 */
class Bemployee extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_employee';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['b_employee_id'], 'required'],
            [['employee_number_issue_date'], 'safe'],
            [['b_employee_id', 'employee_login', 'employee_password', 'employee_firstname', 'employee_lastname', 'employee_number', 'employee_last_login', 'employee_last_logout', 'employee_active', 'b_service_point_id', 'f_employee_level_id', 'f_employee_rule_id', 'f_employee_authentication_id', 'b_employee_default_tab', 'employee_warning_dx', 'record_date_time', 'update_date_time', 't_person_id', 'provider', 'f_provider_type_id', 'start_date', 'out_date', 'move_from', 'move_to', 'b_visit_clinic_id'], 'string', 'max' => 255],
            [['employee_warning_icd10', 'is_main_doctor'], 'string', 'max' => 1],
            [['f_provider_council_code_id'], 'string', 'max' => 2],
            [['b_employee_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'b_employee_id' => 'B Employee ID',
            'employee_login' => 'Employee Login',
            'employee_password' => 'Employee Password',
            'employee_firstname' => 'Employee Firstname',
            'employee_lastname' => 'Employee Lastname',
            'employee_number' => 'Employee Number',
            'employee_last_login' => 'Employee Last Login',
            'employee_last_logout' => 'Employee Last Logout',
            'employee_active' => 'Employee Active',
            'b_service_point_id' => 'B Service Point ID',
            'f_employee_level_id' => 'F Employee Level ID',
            'f_employee_rule_id' => 'F Employee Rule ID',
            'f_employee_authentication_id' => 'F Employee Authentication ID',
            'b_employee_default_tab' => 'B Employee Default Tab',
            'employee_warning_dx' => 'Employee Warning Dx',
            'record_date_time' => 'Record Date Time',
            'update_date_time' => 'Update Date Time',
            'employee_warning_icd10' => 'Employee Warning Icd10',
            't_person_id' => 'T Person ID',
            'provider' => 'Provider',
            'f_provider_council_code_id' => 'F Provider Council Code ID',
            'f_provider_type_id' => 'F Provider Type ID',
            'start_date' => 'Start Date',
            'out_date' => 'Out Date',
            'move_from' => 'Move From',
            'move_to' => 'Move To',
            'employee_number_issue_date' => 'Employee Number Issue Date',
            'is_main_doctor' => 'Is Main Doctor',
            'b_visit_clinic_id' => 'B Visit Clinic ID',
        ];
    }

    /**
     * @inheritdoc
     * @return BemployeeQuery the active query used by this AR class.
     */

}
