<?php
/*
/**
 * Sidebars for ADC Twenty Thirteen
 *
 * @package      adc-twenty-thirteen
 * @since        1.0.0
 * @link         http://www.adclinic.com
 * @author       Cindy Brummer <cindybrummer@standardbeagle.com. cbrummer@adclinic.com>
 * @copyright    Copyright (c) 2013, Cindy Brummer
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

/**
 * Sidebar Registration
 * @since 1.0.0
 *
 * This file contains all of the sidebars needed for ADC Twenty Thirteen
 *
 */
	//Header widget areas


	// Home page sidebars
	genesis_register_sidebar(array(
		'id'=>'adc-home-headline',
		'name'=>('Home Headline'),
		'description' => 'This is the top headline.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div>',
		'before_title'=>'<h2 class="widget-title">','after_title'=>'</h2>'
	));
	genesis_register_sidebar(array(
		'id'=>'adc-home-top-left',
		'name'=>('Home Top Left'),
		'description' => 'This is the top left section of the homepage.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div>',
		'before_title'=>'<h4 class="widget-title">','after_title'=>'</h4>'
	));
	genesis_register_sidebar(array(
		'id'=>'adc-home-top-right',
		'name'=>('Home Top Right'),
		'description' => 'This is the top right section of the homepage.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div>',
		'before_title'=>'<h4 class="widge-ttitle">','after_title'=>'</h4>'
	));
	genesis_register_sidebar(array(
		'id'=>'adc-home-middle-1',
		'name'=>('Home Middle #1'),
		'description' => 'This is the first column of the middle section of the homepage.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div>',
		'before_title'=>'<h4 class="widget-title">','after_title'=>'</h4>'
	));
	genesis_register_sidebar(array(
		'id'=>('adc-home-middle-2'),
		'name'=>'Home Middle #2',
		'description' => 'This is the second column of the middle section of the homepage.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div>',
		'before_title'=>'<h4 class="widget-title">','after_title'=>'</h4>'
	));
	
// Area located in the top. Empty by default.
	genesis_register_sidebar( array(
		'name' => __( 'Alert Widget Area'),
		'id' => 'alert-widget-area',
		'description' => __( 'Widget area for displaying special announcements at the top of a page'),
		'before_widget' => '<aside id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );
// Area located above primary sidebar area.
	genesis_register_sidebar( array(
		'name' => __( 'Appointment Widget Area'),
		'id' => 'appointment-widget-area',
		'description' => __( 'Widget area for displaying appointment button above primary sidebar'),
		'before_widget' => '<aside id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</aside>',
	) );
//About section sidebar area that replaces the primary sidebar area left of the content
	genesis_register_sidebar( array(
		'name' => ('About Sidebar'),
		'id' => 'about-sidebar',
		'description' => ('The sidebar that holds right-column widgets for the About section'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>'
		)
	);
//Custom widget area that lives above the secondary sidebar area
	genesis_register_sidebar( array(
		'name' => ('About Nav Extras'),
		'id' => 'about-extras-sidebar',
		'description' => ('The sidebar that holds the submenu extras for the About section'),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>'
		)
	);
//Billing section sidebar area that replaces the primary sidebar area left of the content
	genesis_register_sidebar( array(
		'name' => ('Billing Sidebar'),
		'id' => 'billing-sidebar',
		'description' => ('The sidebar that holds widgets for the Billing section'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>'
		)
	);
//Custom widget area for  Billing pages that lives above the secondary sidebar area
	genesis_register_sidebar( array(
		'name' => ('Billing Nav Extras'),
		'id' => 'billing-extras-sidebar',
		'description' => ('The sidebar that holds the submenu extras for the Billing section'),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>'
		)
	);
//Careers section sidebar area that replaces the primary sidebar area left of the content
	genesis_register_sidebar( array(
		'name' => ('Careers Sidebar'),
		'id' => 'careers-sidebar',
		'description' => ('The sidebar that holds widgets for the Careers section pages'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>'
		)
	);	
//Custom widget areas that lives above the secondary sidebar area
	genesis_register_sidebar( array(
		'name' => ('Careers Nav Extras'),
		'id' => 'careers-extras-sidebar',
		'description' => ('The sidebar that holds the submenu extras for the Careers section'),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>'
		)
	);
//Community section sidebars areas that replaces the primary sidebar area left of the content
	genesis_register_sidebar( array(
		'name' => ('Community Sidebar'),
		'id' => 'community-sidebar',
		'description' => ('The sidebar that holds widgets for the Community/Outreach pages'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>'
		)
	);
//Custom Community section subnav sidebar area that lives above the secondary sidebar area
	genesis_register_sidebar( array(
		'name' => ('Community Nav Extras'),
		'id' => 'community-extras-sidebar',
		'description' => ('The sidebar that holds the submenu extras for the community/outreach section'),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>'
		)
	);
//Custom Contact section sidebar area that replaces the primary sidebar area left of the content
	genesis_register_sidebar( array(
		'name' => ('Contact Sidebar'),
		'id' => 'contact-sidebar',
		'description' => ('The sidebar that holds the submenu extras for the Contact section'),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>'
		)
	);
//Custom Doctors section sidebar area that replaces the primary sidebar area left of the content
	genesis_register_sidebar( array(
		'name' => ('Doctors Sidebar'),
		'id' => 'doctors-sidebar',
		'description' => ('The sidebar that holds widgets for the primary sidebar- Doctors section'),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>'
		)
	);
//Custom Doctors section subnav sidebar areas that lives above the secondary sidebar area
	genesis_register_sidebar( array(
		'name' => ('Doctors Nav Extras'),
		'id' => 'doctors-extras-sidebar',
		'description' => ('The sidebar that holds the submenu extras for the Doctors section'),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>'
		)
	);
//Employees only section sidebar area that replaces the primary sidebar area left of the content
	genesis_register_sidebar( array(
		'name' => ('Employee Sidebar'),
		'id' => 'employee-sidebar',
		'description' => ('The sidebar that holds widgets for the Employee Access page'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>'
		)
	);
//Custom Employees only page subnav sidebar areas that lives above the secondary sidebar area
	genesis_register_sidebar( array(
		'name' => ('Employee Nav Extras'),
		'id' => 'employee-extras-sidebar',
		'description' => ('The sidebar that holds the submenu extras for the Employees Only section'),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>'
		)
	);
//Custom Imaging section sidebar area that replaces the primary sidebar area left of the content
	genesis_register_sidebar( array(
		'name' => ('Imaging Sidebar'),
		'id' => 'imaging-sidebar',
		'description' => ('The sidebar that holds widgets for the Imaging pages'),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>'
		)
	);	
//Custom Locations section sidebar area that replaces the primary sidebar area left of the content
	genesis_register_sidebar( array(
		'name' => ('Locations Sidebar'),
		'id' => 'locations-sidebar',
		'description' => ('The sidebar that holds widgets for the Locations section'),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>'
		)
	);
//Custom Locations page subnav sidebar areas that lives above the secondary sidebar area
	genesis_register_sidebar( array(
		'name' => ('Locations Nav Extras'),
		'id' => 'locations-extras-sidebar',
		'description' => ('The sidebar that holds extra widgets for the Locations section pages'),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>'
		)
	);
//Custom Patient Tools section sidebar area that replaces the primary sidebar area left of the content
	genesis_register_sidebar( array(
		'name' => ('Patient Tools Sidebar'),
		'id' => 'patient-tools-sidebar',
		'description' => ('The sidebar that replaces the primary sidebar with widgets for the Patient Tools section'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>'
		)
	);
	//Custom Quality Assurance section sidebar area that replaces the primary sidebar area left of the content
	genesis_register_sidebar( array(
		'name' => ('QA Sidebar'),
		'id' => 'quality-assurance-sidebar',
		'description' => ('The sidebar that replaces the primary sidebar with widgets for the Quality Assurance section'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>'
		)
	);
//Custom Quality Assurance section subnav sidebar areas that live above the secondary sidebar area
	genesis_register_sidebar( array(
		'name' => ('QA Right Sidebar'),
		'id' => 'quality-assurance-extras-sidebar',
		'description' => ('The right sidebar that holds widgets for the Quality Assurance section'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>'
		)
	);
//Custom Patient Tools subnav sidebar areas that lives above the secondary sidebar area
	genesis_register_sidebar( array(
		'name' => ('Patient Tools Nav Extras'),
		'id' => 'patient-tools-extras-sidebar',
		'description' => ('The sidebar that holds the submenu extras for the Patient Tools section'),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>'
		)
	);
//Custom Services section sidebar area that replaces the primary sidebar area left of the content
	genesis_register_sidebar( array(
		'name' => ('Services Sidebar'),
		'id' => 'services-sidebar',
		'description' => ('The sidebar that holds widgets for the Medical Services section'),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>'
		)
	);
//Custom Services section subnav sidebar areas that lives above the secondary sidebar area
	genesis_register_sidebar( array(
		'name' => ('Services Nav Extras'),
		'id' => 'services-extras-sidebar',
		'description' => ('The sidebar that holds extra widgets for the Medical Services section'),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>'
		)
	);
	
//Flu page sidebar area that replaces the primary sidebar area left of the content
	genesis_register_sidebar( array(
		'name' => ('Flu Sidebar'),
		'id' => 'flu-sidebar',
		'description' => ('The sidebar that holds widgets for the Flu pages)'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>'
		)
	);
//Education page sidebar area that replaces the primary sidebar area left of the content
	genesis_register_sidebar( array(
		'name' => ('Education Sidebar'),
		'id' => 'education-sidebar',
		'description' => ('The sidebar that holds widgets for the Education pages)'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>'
		)
	);