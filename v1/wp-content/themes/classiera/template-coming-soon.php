<?php
/**
 * Template name: Coming Soon
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Classiera
 * @since Classiera
 */

?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>

<?php  wp_head(); ?>
	<style type="text/css">
        #bg {
            position: fixed;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
        }
        #bg img {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            min-width: 50%;
            min-height: 50%;
        }
        #comingSoon{
            /*padding: 100px 0 0 0;*/
        }
        .comingSoon__content{
            position: relative;
        }
        .comingSoon__content .comingSoon__logo{
            /*margin-bottom: 80px;*/
            position: absolute;
            top: 100px;
            left: 0;
            right: 0;
            margin: 0 auto;
        }
        .comingSoon__content .comingSoon__logo h3{
            font-weight: 300;
            color: #fff;
            font-family: 'Raleway', sans-serif !important;
        }
        #clock{
            /*margin-bottom: 80px;*/
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            transform: translateY(-50%);
            margin: auto;
        }
        #clock li{
            padding-left: 15px;
            padding-right: 15px;
        }
        #clock li p{
            text-align: center;
            border-bottom: 1px solid #fff;
            font-size: 100px;
            padding-bottom: 20px;
            margin-bottom: 25px;
            color: #ffffff;
            line-height: 100%;
            font-weight: 100;
            padding-left: 30px;
            padding-right: 30px;
        }
        #clock li span{
            font-size: 15px;
            color: #fff;
            text-transform: uppercase;
            font-weight: bold;
            font-family: 'Raleway', sans-serif !important;
        }
        .comingSoon__Social{
            position: absolute;
            bottom: 100px;
            left: 0;
            right: 0;
            margin: 0 auto;
        }
        .comingSoon__Social a{
            display: inline-block;
            width: 50px;
            height: 50px;
            line-height: 50px;
            text-align: center;
            border: 1px solid #ffffff;
            border-radius: 1000px;
            margin-right: 10px;
        }
        .comingSoon__Social a i{
            color: #ffffff;
            font-size: 20px;
        }
        .classiera__copyright{
            color: #ffffff;
            font-size: 16px;
            font-weight: 300;
            position: absolute;
            bottom: 50px;
            left: 0;
            right: 0;
            margin: 0 auto;
        }
        @media only screen and (max-width: 640px) {
            .comingSoon__content .comingSoon__logo{
                top: 30px;
            }
            .comingSoon__content .comingSoon__logo h3{
                font-size: 16px;
            }
            #clock li{
                padding: 0 5px;
            }
            #clock li p{
                font-size: 14px;
                padding-left: 10px;
                padding-right: 10px;
            }
            #clock li span{
                font-size: 11px;
            }
            .comingSoon__Social{
                bottom: 50px;
            }
            .classiera__copyright{
                bottom: 20px;
            }
        }
    </style>
</head>
<body>
<?php 
global $redux_demo; 
$comingBG = $redux_demo['coming-soon-bg']['url'];
$cominglogo = $redux_demo['coming-soon-logo']['url'];
$comingtxt = $redux_demo['coming-soon-txt'];
$facebook_link = $redux_demo['facebook-link'];
$twitter_link = $redux_demo['twitter-link'];
$google_plus_link = $redux_demo['google-plus-link'];
$instagram_link = $redux_demo['instagram-link'];
$trnsDays = $redux_demo['coming-trns-days'];
$trnsHours = $redux_demo['coming-trns-hours'];
$trnsMin = $redux_demo['coming-trns-minutes'];
$trnsSec = $redux_demo['coming-trns-seconds'];

$comingMonth = $redux_demo['coming-month'];
$comingDays = $redux_demo['coming-days'];
$comingYear = $redux_demo['coming-year'];
$copyRight = $redux_demo['coming-copyright'];
?>
    <div id="bg">
        <img src="<?php echo esc_url($comingBG); ?>" alt="comingSoon">
    </div>
	<section id="comingSoon">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="comingSoon__content text-center">
                        <div class="comingSoon__logo">
                            <img class="img-responsive" src="<?php echo esc_url($cominglogo); ?>" alt="logo">
                            <h3><?php echo esc_attr($comingtxt); ?></h3>
                        </div>
                        <ul id="clock" class="list-unstyled list-inline"></ul>
                        <div class="comingSoon__Social">
                            <a href="<?php echo esc_url($facebook_link); ?>"><i class="fab fa-facebook-f"></i></a>
							<a href="<?php echo esc_url($twitter_link); ?>"><i class="fab fa-twitter"></i></a>
							<a href="<?php echo esc_url($google_plus_link); ?>"><i class="fab fa-google-plus-g"></i></a>
							<a href="<?php echo esc_url($instagram_link); ?>"><i class="fab fa-instagram"></i></a> 
                        </div>
                        <p class="classiera__copyright"><?php echo esc_html($copyRight); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/countdown.js"></script>
	<?php wp_footer(); ?>
   <script type="text/javascript">      
	$(document).ready(function(){
        $('#clock').countdown('<?php echo esc_attr($comingYear); ?>/<?php echo esc_attr($comingMonth); ?>/<?php echo esc_attr($comingDays); ?>', function(event) {
            $(this).html(event.strftime(''
                + '<li><p>%D</p><span>days</span></li>'
                + '<li><p>%H</p><span>Hours</span></li>'
                + '<li><p>%M</p><span>Miutes</span></li>'
                + '<li><p>%S</p><span>Seconds</span></li>'));
            });
            var h = $(window).height();
            $('.comingSoon__content').css('height', h);
	});		
    </script>
</body>
</html>