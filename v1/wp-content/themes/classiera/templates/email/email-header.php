<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:400,400i,500,500i,700,700i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,400i,700,700i,900,900i" rel="stylesheet">
    <style>
        body{
            margin: 0;
            padding: 0;
        }
        .primary-color{
            color: #b6d91a !important;
        }
        .classiera-email-social-icon:hover{
            background: #b6d91a !important;
            color: #ffffff;
        }
        @media only screen and (min-width: 640px) {
            .classiera-email-content{
                width: 600px !important;
                margin: 0 auto !important;
            }
        }
        @media only screen and (max-width: 630px) {
            .classiera-email-content{
                width: 100% !important;
                text-align: center !important;
            }
            .classiera-column-3{
                width: 100% !important;
                margin-bottom: 10px !important;
                text-align: center !important;
            }
            .classiera-column-6{
                width: 100% !important;
                text-align: center !important;
            }
        }
        @media only screen and (min-width: 640px) and (max-width: 768px) {
            .classiera-column-3{
                width: 33% !important;
            }
            .classiera-column-6{
                width: 32% !important;
            }
        }
    </style>
</head>	
<body>
	<?php 
		global $redux_demo;
		$classieraEmail = $redux_demo['contact-email'];
		$classieraPhone = $redux_demo['contact-phone'];
		$classieraFacebook = $redux_demo['facebook-link'];
		$classieraTwitter = $redux_demo['twitter-link'];
		$classieraGoogle = $redux_demo['google-plus-link'];
		$classieralogo = $redux_demo['classiera_email_logo']['url'];
		$blog_title = get_bloginfo('name');
	?>
	<div style="width: 100%;">
		<div class="classiera-email-topbar" style="background:#232323; padding: 5px 30px;">
            <div class="classiera-column-3" style="width: 25%; display: inline-block;">
				<?php $emailIMG = get_template_directory_uri() . '/images/social/email.png'; ?>
				<img src="<?php echo esc_url($emailIMG); ?>" style="width:11px; padding-right: 15px;" alt="email">
                <span style="color: #aaaaaa; font-size:12px; font-family: 'Lato', sans-serif;">
					<?php echo sanitize_email($classieraEmail); ?>
				</span>
            </div>
            <div class="classiera-column-3" style="width: 25%; display: inline-block;">
				<?php $phoneIMG = get_template_directory_uri() . '/images/social/phone.png'; ?>
                <img src="<?php echo esc_url($phoneIMG); ?>" style="width:11px; padding-right: 15px;" alt="phone">
                <a href="tel:+496170961709" style="text-decoration: none; color: #aaaaaa; font-size:12px; font-family: 'Lato', sans-serif;"><?php echo esc_html($classieraPhone); ?></a>
            </div>
            <div class="classiera-column-6" style="width: 48%; display: inline-block; text-align: right;">
				<?php if(!empty($classieraFacebook)){?>
				<?php $facebookIMG = get_template_directory_uri() . '/images/social/facebook.png'; ?>
                <a class="classiera-email-social-icon" href="<?php echo esc_url($classieraFacebook); ?>" style="background: #444444; height: 30px; width: 30px; text-align: center; display: inline-block; line-height:30px;">
                    <img src="<?php echo esc_url($facebookIMG); ?>" style="width:11px;" alt="facebook">
                </a>
				<?php } ?>
				<?php if(!empty($classieraTwitter)){?>
				<?php $twiiterIMG = get_template_directory_uri() . '/images/social/twiiter.png'; ?>
                <a class="classiera-email-social-icon" href="<?php echo esc_url($classieraTwitter); ?>" style="background: #444444; height: 30px; width: 30px; text-align: center; display: inline-block; line-height:30px;">
                    <img src="<?php echo esc_url($twiiterIMG); ?>" style="width:11px;" alt="twitter">
                </a>
				<?php } ?>
				<?php if(!empty($classieraGoogle)){?>
				<?php $googleIMG = get_template_directory_uri() . '/images/social/google-plus.png'; ?>
                <a class="classiera-email-social-icon" href="<?php echo esc_url($classieraGoogle); ?>" style="background: #444444; height: 30px; width: 30px; text-align: center; display: inline-block; line-height:30px;">
                    <img src="<?php echo esc_url($googleIMG); ?>" style="width:11px;" alt="google">
                </a>
				<?php } ?>
            </div>
        </div>
		<div class="classiera-email-logo" style="width: 100%; background: #fff; text-align: center; padding: 25px 0; box-shadow: 0 4px 2px -2px rgba(0, 0, 0, 0.15);">
            <img src="<?php echo esc_url($classieralogo); ?>" alt="<?php echo esc_html($blog_title); ?>">
        </div>