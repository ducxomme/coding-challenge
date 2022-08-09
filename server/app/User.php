<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\User
 *
 * @property int $id ID
 * @property int|null $employee_id 社員ID
 * @property string $username ユーザ名
 * @property string $password パスワード
 * @property string $family_name ユーザ名(性)
 * @property string|null $middle_name ミドルネーム
 * @property string $first_name ユーザ名(名)
 * @property string|null $mail_address E-MAILアドレス
 * @property string|null $language_cdkey 言語
 * @property int $role_type 権限区分
 * @property int $administrator_flag 特権ユーザフラグ
 * @property int $apply_role_job_pos_or_grade_a_flag 役職／等級権限適用フラグ
 * @property int $system_use_flag_1 システム利用権限1
 * @property int $system_use_flag_2 システム利用権限2
 * @property int $system_use_flag_3 システム利用権限3
 * @property int $system_use_flag_4 システム利用権限4
 * @property int $system_use_flag_5 システム利用権限5
 * @property int $system_use_flag_6 システム利用権限6
 * @property int $system_use_flag_7 システム利用権限7
 * @property int $system_use_flag_8 システム利用権限8
 * @property int $system_use_flag_9 システム利用権限9
 * @property int $system_use_flag_10 システム利用権限10
 * @property int $system_use_flag_11 システム利用権限11
 * @property int $system_use_flag_12 システム利用権限12
 * @property int $system_use_flag_13 システム利用権限13
 * @property int $system_use_flag_14 システム利用権限14
 * @property int $system_use_flag_15 システム利用権限15
 * @property int $system_use_flag_16 システム利用権限16
 * @property int $system_use_flag_17 システム利用権限17
 * @property int $system_use_flag_18 システム利用権限18
 * @property int $system_use_flag_19 システム利用権限19
 * @property int $system_use_flag_20 システム利用権限20
 * @property int $system_use_flag_21 システム利用権限21
 * @property int $system_use_flag_22 システム利用権限22
 * @property int $system_use_flag_23 システム利用権限23
 * @property int $system_use_flag_24 システム利用権限24
 * @property int $system_use_flag_25 システム利用権限25
 * @property int $system_use_flag_26 システム利用権限26
 * @property int $system_use_flag_27 システム利用権限27
 * @property int $system_use_flag_28 システム利用権限28
 * @property int $system_use_flag_29 システム利用権限29
 * @property int $system_use_flag_30 システム利用権限30
 * @property string|null $use_start_date 利用開始日
 * @property string|null $use_end_date 利用終了日
 * @property int $password_force_edit パスワード強制変更
 * @property string|null $before_login_timestamp 前回ログイン日時
 * @property string|null $password_change_date パスワード変更日
 * @property int|null $failure_count ログイン失敗回数
 * @property string|null $failure_timestamp ログイン失敗日時
 * @property string|null $agent_allow_time 代理認証リミット時刻
 * @property string|null $agent_password 代理認証パスワード
 * @property string $otp_secret_key ワンタイムパスワード作成用秘密鍵
 * @property string $second_factor_last_login_at 最後に二段階認証をした時刻。
 * @property string $second_factor_last_login_ua 最後に二段階認証をした時のUserAgent。
 * @property string $second_factor_last_login_ip 最後に二段階認証をした時のIPアドレス。
 * @property int $bounce_count バウンスカウント
 * @property int $stop_mail メール配信停止
 * @property int|null $unit_tree_open_level 組織図展開表示階層
 * @property string $modified_by 更新者
 * @property string $created 作成日時
 * @property string $modified 更新日時
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereAdministratorFlag($value)
 * @method static Builder|User whereAgentAllowTime($value)
 * @method static Builder|User whereAgentPassword($value)
 * @method static Builder|User whereApplyRoleJobPosOrGradeAFlag($value)
 * @method static Builder|User whereBeforeLoginTimestamp($value)
 * @method static Builder|User whereBounceCount($value)
 * @method static Builder|User whereCreated($value)
 * @method static Builder|User whereEmployeeId($value)
 * @method static Builder|User whereFailureCount($value)
 * @method static Builder|User whereFailureTimestamp($value)
 * @method static Builder|User whereFamilyName($value)
 * @method static Builder|User whereFirstName($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereLanguageCdkey($value)
 * @method static Builder|User whereMailAddress($value)
 * @method static Builder|User whereMiddleName($value)
 * @method static Builder|User whereModified($value)
 * @method static Builder|User whereModifiedBy($value)
 * @method static Builder|User whereOtpSecretKey($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePasswordChangeDate($value)
 * @method static Builder|User wherePasswordForceEdit($value)
 * @method static Builder|User whereRoleType($value)
 * @method static Builder|User whereSecondFactorLastLoginAt($value)
 * @method static Builder|User whereSecondFactorLastLoginIp($value)
 * @method static Builder|User whereSecondFactorLastLoginUa($value)
 * @method static Builder|User whereStopMail($value)
 * @method static Builder|User whereSystemUseFlag1($value)
 * @method static Builder|User whereSystemUseFlag10($value)
 * @method static Builder|User whereSystemUseFlag11($value)
 * @method static Builder|User whereSystemUseFlag12($value)
 * @method static Builder|User whereSystemUseFlag13($value)
 * @method static Builder|User whereSystemUseFlag14($value)
 * @method static Builder|User whereSystemUseFlag15($value)
 * @method static Builder|User whereSystemUseFlag16($value)
 * @method static Builder|User whereSystemUseFlag17($value)
 * @method static Builder|User whereSystemUseFlag18($value)
 * @method static Builder|User whereSystemUseFlag19($value)
 * @method static Builder|User whereSystemUseFlag2($value)
 * @method static Builder|User whereSystemUseFlag20($value)
 * @method static Builder|User whereSystemUseFlag21($value)
 * @method static Builder|User whereSystemUseFlag22($value)
 * @method static Builder|User whereSystemUseFlag23($value)
 * @method static Builder|User whereSystemUseFlag24($value)
 * @method static Builder|User whereSystemUseFlag25($value)
 * @method static Builder|User whereSystemUseFlag26($value)
 * @method static Builder|User whereSystemUseFlag27($value)
 * @method static Builder|User whereSystemUseFlag28($value)
 * @method static Builder|User whereSystemUseFlag29($value)
 * @method static Builder|User whereSystemUseFlag3($value)
 * @method static Builder|User whereSystemUseFlag30($value)
 * @method static Builder|User whereSystemUseFlag4($value)
 * @method static Builder|User whereSystemUseFlag5($value)
 * @method static Builder|User whereSystemUseFlag6($value)
 * @method static Builder|User whereSystemUseFlag7($value)
 * @method static Builder|User whereSystemUseFlag8($value)
 * @method static Builder|User whereSystemUseFlag9($value)
 * @method static Builder|User whereUnitTreeOpenLevel($value)
 * @method static Builder|User whereUseEndDate($value)
 * @method static Builder|User whereUseStartDate($value)
 * @method static Builder|User whereUsername($value)
 * @mixin Eloquent
 */
class User extends Model
{

}
