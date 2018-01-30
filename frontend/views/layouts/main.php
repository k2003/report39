<?php

/**
 * @var string $content
 * @var \yii\web\View $this
 */

use yii\helpers\Html;
use frontend\models\Bemployee;

$bundle = yiister\gentelella\assets\Asset::register($this);

$session = Yii::$app->session;
$checklogin = Bemployee::findOne(['b_employee_id'=>$session['userid'],]);

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="nav-<?= !empty($_COOKIE['menuIsCollapsed']) && $_COOKIE['menuIsCollapsed'] == 'true' ? 'sm' : 'md' ?>" >
<?php $this->beginBody(); ?>
<div class="container body">

    <div class="main_container">

        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">

                <div class="navbar nav_title" style="border: 0;">
                    <a href="#" class="site_title"><i class="glyphicon glyphicon-list-alt"></i> <span>Report39!</span></a>
                </div>
                <div class="clearfix"></div>
                <!-- menu prile quick info -->
                <!--

                <div class="profile">
                    <div class="profile_pic">
                        <img src="http://placehold.it/128x128" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Welcome,</span>
                        <h2>John Doe</h2>
                    </div>
                </div>
                -->
                <!-- /menu prile quick info -->

                <br />

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                    <div class="menu_section">
                        <h3>ระบบรายงาน</h3>
                        <?=
                        \yiister\gentelella\widgets\Menu::widget(
                            [
                                "items" => [
                                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                                    ["label" => "TEST", "url" => ["/test/index"], "icon" => "file-code-o"],
                  									["label" => "หน้าแรก", "url" => ["/site/index"], "icon" => "home"],
                  									["label" => "Dashboard", "url" => ["/dashboard/index"], "icon" => "dashboard"],
	                                    [
                                        "label" => "ตรวจสอบข้อมูล 43 แฟ้ม",
                                        "url" => "#",
                                        "icon" => "th-list",
                                        "items" => [
                                            [
                                                "label" => "1. แฟ้ม PERSON",
                                                "url" => ["/person/index"],
                                            ],
					                                  [
                                                "label" => "2. แฟ้ม ADDRESS",
                                                "url" => ["/address/index"],
                                            ],
			                                      [
                                                "label" => "3. แฟ้ม DEATH",
                                                "url" => ["/death/index"],
                                            ],
                      											[
                      												"label" => "4. แฟ้ม CHRONIC",
                      												"url" => ["/chronic/index"],
                      											],
					                                  [
                                                "label" => "5. แฟ้ม CARD",
                                                "url" => ["#"],
                                            ],
			                                [
                                                "label" => "6. แฟ้ม HOME",
                                                "url" => ["#"],
                                            ],
			                                [
                                                "label" => "7. แฟ้ม VILLAGE",
                                                "url" => ["#"],
                                            ],
											[
												"label" => "8. แฟ้ม PROVIDER",
												"url" => ["#"],
											],
											[
												"label" => "9. แฟ้ม DRUGALLERGY",
												"url" => ["#"],
											],
					                        [
                                                "label" => "10. แฟ้ม WOMEN",
                                                "url" => ["#"],
                                            ],
			                                [
                                                "label" => "11. แฟ้ม DRUGALLERGY",
                                                "url" => ["#"],
                                            ],
											[
												"label" => "12. แฟ้ม FUNCTIONAL",
												"url" => ["#"],
											],
											[
											"label" => "13. แฟ้ม ICF",
											"url" => ["#"],
											],
					                        [
                                                "label" => "14. แฟ้ม SERVICE",
                                                "url" => ["#"],
                                            ],
			                                [
                                                "label" => "15. แฟ้ม DIAGNOSIS_OPD",
                                                "url" => ["#"],
                                            ],
											[
												"label" => "16. แฟ้ม DRUG_OPD",
												"url" => ["#"],
											],
					                        [
                                                "label" => "17. แฟ้ม PROCEDURE_OPD",
                                                "url" => ["#"],
                                            ],
			                                [
                                                "label" => "18. แฟ้ม CHARGE_OPD",
                                                "url" => ["#"],
                                            ],
											[
												"label" => "19. แฟ้ม SURVEILLANCE",
												"url" => ["#"],
											],
											[
												"label" => "20. แฟ้ม ACCIDENT",
												"url" => ["#"],
											],
					                        [
                                                "label" => "21. แฟ้ม LABFU",
                                                "url" => ["#"],
                                            ],
			                                [
                                                "label" => "22. แฟ้ม CHRONICFU",
                                                "url" => ["#"],
                                            ],
			                                [
                                                "label" => "23. แฟ้ม ADMISSION",
                                                "url" => ["#"],
                                            ],
											[
												"label" => "24. แฟ้ม DIAGNOSIS_IPD",
												"url" => ["#"],
											],
											[
												"label" => "25. แฟ้ม DRUG_IPD",
												"url" => ["#"],
											],
											[
												"label" => "26. แฟ้ม PROCEDURE_IPD",
												"url" => ["#"],
											],
					                        [
                                                "label" => "27. แฟ้ม CHARGE_IPD",
                                                "url" => ["#"],
                                            ],
			                                [
                                                "label" => "28. แฟ้ม APPOINTMENT",
                                                "url" => ["#"],
                                            ],
											[
											"label" => "29. แฟ้ม DENTAL",
											"url" => ["/dental/index"],

											],
											[
												"label" => "30. แฟ้ม REHABILITATION",
												"url" => ["#"],
											],
											[
												"label" => "31. แฟ้ม NCDSCREEN",
												"url" => ["#"],
											],
											[
												"label" => "32. แฟ้ม FP",
												"url" => ["#"],
											],
					                        [
                                                "label" => "33. แฟ้ม PRENATAL",
                                                "url" => ["#"],
                                            ],
			                                [
                                                "label" => "34. แฟ้ม ANC",
                                                "url" => ["/anc/index"],
                                            ],
			                                [
                                                "label" => "35. แฟ้ม LABOR",
                                                "url" => ["#"],
                                            ],
											[
											"label" => "36. แฟ้ม POSTNATAL",
											"url" => ["#"],
											],
			                                [
                                                "label" => "37. แฟ้ม NEWBORN",
                                                "url" => ["#"],
                                            ],
			                                [
                                                "label" => "38. แฟ้ม NEWBORNCARE",
                                                "url" => ["#"],
                                            ],
			                                [
                                                "label" => "39. แฟ้ม EPI",
                                                "url" => ["/epi/index"],
                                            ],
			                                [
                                                "label" => "40. แฟ้ม NUTRITION",
                                                "url" => ["#"],
                                            ],
			                                [
                                                "label" => "41. แฟ้ม SPECIALPP",
                                                "url" => ["#"],
                                            ],
			                                [
                                                "label" => "42. แฟ้ม COMMUNITY_ACTIVITY",
                                                "url" => ["#"],
                                            ],
			                                [
                                                "label" => "43. แฟ้ม COMMUNITY_SERVICE",
                                                "url" => ["#"],
                                            ],
			                                [
                                                "label" => "44. แฟ้ม CARE_REFER",
                                                "url" => ["#"],
                                            ],
			                                [
                                                "label" => "45. แฟ้ม CLINICAL_REFER",
                                                "url" => ["#"],
                                            ],
			                                [
                                                "label" => "46. แฟ้ม DRUG_REFER",
                                                "url" => ["#"],
                                            ],
			                                [
                                                "label" => "47. แฟ้ม INVESTIGATION_REFER",
                                                "url" => ["#"],
                                            ],
			                                [
                                                "label" => "48. แฟ้ม PROCEDURE_REFER",
                                                "url" => ["#"],
                                            ],
			                                [
                                                "label" => "49. แฟ้ม REFER_HISTORY",
                                                "url" => ["#"],
                                            ],
			                                [
                                                "label" => "50. แฟ้ม REFER_RESULT",
                                                "url" => ["#"],
                                            ],
			                                [
                                                "label" => "51. แฟ้ม DATA_CORRECT",
                                                "url" => ["#"],
                                            ],
			                                [
                                                "label" => "52. แฟ้ม POLICY",
                                                "url" => ["#"],
                                            ],
                                        ],
                                    ],
                                    ["label" => "NCD", "url" => ["/ncd/index"], "icon" => "th"],
                                    ["label" => "QOF", "url" => ["/qof/index"], "icon" => "th"],
                                    ["label" => "PPA", "url" => ["/ppa/index"], "icon" => "th"],
                                    ["label" => "KPI", "url" => ["/kpi/index"], "icon" => "th"],
                                    /*
                                    ["label" => "Error page", "url" => ["site/error-page"], "icon" => "close"],
                                    [
                                        "label" => "Widgets",
                                        "icon" => "th",
                                        "url" => ["#"],
                                        "items" => [
                                            ["label" => "Menu", "url" => ["site/menu"]],
                                            ["label" => "Panel", "url" => ["site/panel"]],
                                        ],
                                    ],
                                    [
                                        "label" => "Badges",
                                        "url" => ["#"],
                                        "icon" => "table",
                                        "items" => [
                                            [
                                                "label" => "Default",
                                                "url" => ["#"],
                                                "badge" => "123",
                                            ],
                                            [
                                                "label" => "Success",
                                                "url" => ["#"],
                                                "badge" => "new",
                                                "badgeOptions" => ["class" => "label-success"],
                                            ],
                                            [
                                                "label" => "Danger",
                                                "url" => ["#"],
                                                "badge" => "!",
                                                "badgeOptions" => ["class" => "label-danger"],
                                            ],
                                        ],
                                    ],
                                    [
                                        "label" => "Multilevel",
                                        "url" => ["#"],
                                        "icon" => "table",
                                        "items" => [
                                            [
                                                "label" => "Second level 1",
                                                "url" => ["#"],
                                            ],
                                            [
                                                "label" => "Second level 2",
                                                "url" => ["#"],
                                                "items" => [
                                                    [
                                                        "label" => "Third level 1",
                                                        "url" => ["#"],
                                                    ],
                                                    [
                                                        "label" => "Third level 2",
                                                        "url" => ["#"],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                    */
                                ],
                            ]
                        )
                        ?>
                    </div>

                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <!--<div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top" title="Settings">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Lock">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Logout">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                </div>-->
                <!-- /menu footer buttons -->

            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">

            <div class="nav_menu">
                <nav class="" role="navigation">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
						<?php $login = Yii::$app->urlManager->createUrl(['/site/login']);?>
						<?php $logout = Yii::$app->urlManager->createUrl(['/logout/index']);?>

						<?php if(!$checklogin){ ?>
						<li><a href="<?=$login?>"><i class="glyphicon glyphicon-lock"></i> เข้าสู่ระบบ</a></li>
						<?php }else { ?>
						<li><a href="<?=$logout?>"><i class="glyphicon glyphicon-log-out"></i> ออกจากระบบ</a></li>
                        <li><a href="#"><i class="glyphicon glyphicon-user"></i><?=' '.$session['fname'].' '.$session['lname']?></a></li>
						<?php } ?>
                       <!--<li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <img src="http://placehold.it/128x128" alt="">John Doe
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li><a href="javascript:;">  Profile</a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <span class="badge bg-red pull-right">50%</span>
                                        <span>Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;">Help</a>
                                </li>
                                <li><a href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                                </li>
                            </ul>
                        </li>-->

                        <!--<li role="presentation" class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-envelope-o"></i>
                                <span class="badge bg-green">6</span>
                            </a>
                            <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                <li>
                                    <a>
                      <span class="image">
                                        <img src="http://placehold.it/128x128" alt="Profile Image" />
                                    </span>
                      <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                      <span class="image">
                                        <img src="http://placehold.it/128x128" alt="Profile Image" />
                                    </span>
                      <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                      <span class="image">
                                        <img src="http://placehold.it/128x128" alt="Profile Image" />
                                    </span>
                      <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                      <span class="image">
                                        <img src="http://placehold.it/128x128" alt="Profile Image" />
                                    </span>
                      <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                                    </a>
                                </li>
                                <li>
                                    <div class="text-center">
                                        <a href="/">
                                            <strong>See All Alerts</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>-->

                    </ul>
                </nav>
            </div>

        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            <?php if (isset($this->params['h1'])): ?>
                <div class="page-title">
                    <div class="title_left">
                        <h1><?= $this->params['h1'] ?></h1>
                    </div>
                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Go!</button>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="clearfix"></div>

            <?= $content ?>
        </div>
        <!-- /page content -->
        <!-- footer content -->
        <footer>
            <div class="pull-right">
                Report HospitalOS by <a href="" rel="nofollow" target="_blank">Ninja</a><br />
                Extension for Yii framework 2 by <a href="http://yiister.ru" rel="nofollow" target="_blank">Yiister</a>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>

</div>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>
<!-- /footer content -->
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
