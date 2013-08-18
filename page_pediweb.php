<?php
/**
 * Template name: Pediatric Web
 *
 *
 * @package      adc-twenty-thirteen
 * @since        1.0.0
 * @link         http://www.adclinic.com
 * @author       Cindy Brummer <cindybrummer@standardbeagle.com. cbrummer@adclinic.com>
 * @copyright    Copyright (c) 2013, Cindy Brummer
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 *
 */

remove_action ('genesis_loop', 'genesis_do_loop');
add_action( 'genesis_loop', 'custom_do_pediatricweb_loop' );

function custom_do_pediatricweb_loop() {
    	
	// Intro Text (from page content)
	echo '<div class="page hentry entry">';
	echo '<h1 class="entry-title">'. get_the_title() .'</h1>';
	echo '<div class="entry-content">' . get_the_content() ;
	if ( is_page( '4824' ) ) {  
    	echo '<div class="one-half first"><h3>Pediatric Web Topics</h3>';
        echo '<ul>';
        wp_list_pages('child_of=4824&depth=1&title_li=' );
        echo '</ul></div>';
    }
	if (is_page('4738')){ 
		//Illness page content
		$PostPage = "http://www.pediatricweb.com/webpost/Illness.asp?";

		$variables = "pw_groupid=270";
		$variables = $variables . "&pw_accesscode=B14D3C17-704F-4BCD-A8ED-D32985D25041";
		$variables = $variables . "&pw_url=";
		$variables = $variables . "&pw_articlepage=" . "/education/pediatric-patient-education/is-my-child-sick/";
		if ($_GET["tArticleId"] > "")  {
		   $variables = $variables . "&tArticleId=" . $_GET["tArticleId"];
		} else {
		   if ($_POST["tArticleId"] > "")   {
			 $variables = $variables . "&tArticleId=" . $_POST["tArticleId"];
		   }
		}
		if ($_GET["tCategoryId"] > "") {
		   $variables = $variables . "&tCategoryId=" . $_GET["tCategoryId"];
		} else {
		   if ($_POST["tCategoryId"] > "")   {
			  $variables = $variables . "&tCategoryId=" . $_POST["tCategoryId"];
		   }
		}
		
		if ($_GET["tArticleStyle"] > ""){
		   $variables = $variables . "&tArticleStyle=" . $_GET["tArticleStyle"];
		} else {
			if ($_POST["tArticleStyle"] > "")    {
			  $variables = $variables . "&tArticleStyle=" . $_POST["tArticleStyle"];
			}
		}
		
		
		$query = $PostPage . $variables;
		$url = parse_url($query);
		$host = $url["host"];
		$path = $url["path"] . "?" . $url["query"];
		$timeout = 1;
		$fp = fsockopen ($host, 80, $errno, $errstr, $timeout);
		if ($fp) {
		  fputs ($fp, "GET $path HTTP/1.0\nHost: " . $host . "\n\n");
		  while (!feof($fp)) {
			$buf .= fgets($fp, 128);
		  }
		  $lines = split("\n", $buf);
		  $varResult = $lines[count($lines)-1];
		  fclose($fp);
		} else {
		  # enter error handing code here
		}
		echo $varResult;
	}elseif (is_page('4754')){
        //Pediatric Medical Conditions dropdown-->
		$PostPage = "http://www.pediatricweb.com/webpost/MedicalConditionsDropDown.asp?";
		
		$variables = "pw_groupid=270";
		$variables = $variables . "&pw_accesscode=B14D3C17-704F-4BCD-A8ED-D32985D25041";
		$variables = $variables . "&pw_url=";
		$variables = $variables . "&pw_articlepage=" . "/education/pediatric-patient-education/pediatric-medical-conditions/";
		if ($_GET["tArticleId"] > "")  {
		   $variables = $variables . "&tArticleId=" . $_GET["tArticleId"];
		} else {
		   if ($_POST["tArticleId"] > "")   {
			 $variables = $variables . "&tArticleId=" . $_POST["tArticleId"];
		   }
		}
		if ($_GET["tCategoryId"] > "") {
		   $variables = $variables . "&tCategoryId=" . $_GET["tCategoryId"];
		} else {
		   if ($_POST["tCategoryId"] > "")   {
			  $variables = $variables . "&tCategoryId=" . $_POST["tCategoryId"];
		   }
		}
		
		if ($_GET["tArticleStyle"] > ""){
		   $variables = $variables . "&tArticleStyle=" . $_GET["tArticleStyle"];
		} else {
			if ($_POST["tArticleStyle"] > "")    {
			  $variables = $variables . "&tArticleStyle=" . $_POST["tArticleStyle"];
			}
		}
		
		
		$query = $PostPage . $variables;
		$url = parse_url($query);
		$host = $url["host"];
		$path = $url["path"] . "?" . $url["query"];
		$timeout = 1;
		$fp = fsockopen ($host, 80, $errno, $errstr, $timeout);
		if ($fp) {
		  fputs ($fp, "GET $path HTTP/1.0\nHost: " . $host . "\n\n");
		  while (!feof($fp)) {
			$buf .= fgets($fp, 128);
		  }
		  $lines = split("\n", $buf);
		  $varResult = $lines[count($lines)-1];
		  fclose($fp);
		} else {
		  # enter error handing code here
		}
		echo $varResult;

	}elseif (is_page('4807')){ 
		$PostPage = "http://www.pediatricweb.com/webpost/Medicine.asp?";
		
		$variables = "pw_groupid=270";
		$variables = $variables . "&pw_accesscode=B14D3C17-704F-4BCD-A8ED-D32985D25041";
		$variables = $variables . "&pw_url=";
		$variables = $variables . "&pw_articlepage=" . "/education/pediatric-patient-education/pediatric-medicine-and-dosages/";
		if ($_GET["tArticleId"] > "")  {
		   $variables = $variables . "&tArticleId=" . $_GET["tArticleId"];
		} else {
		   if ($_POST["tArticleId"] > "")   {
			 $variables = $variables . "&tArticleId=" . $_POST["tArticleId"];
		   }
		}
		if ($_GET["tCategoryId"] > "") {
		   $variables = $variables . "&tCategoryId=" . $_GET["tCategoryId"];
		} else {
		   if ($_POST["tCategoryId"] > "")   {
			  $variables = $variables . "&tCategoryId=" . $_POST["tCategoryId"];
		   }
		}
		
		if ($_GET["tArticleStyle"] > ""){
		   $variables = $variables . "&tArticleStyle=" . $_GET["tArticleStyle"];
		} else {
			if ($_POST["tArticleStyle"] > "")    {
			  $variables = $variables . "&tArticleStyle=" . $_POST["tArticleStyle"];
			}
		}
		
		
		$query = $PostPage . $variables;
		$url = parse_url($query);
		$host = $url["host"];
		$path = $url["path"] . "?" . $url["query"];
		$timeout = 1;
		$fp = fsockopen ($host, 80, $errno, $errstr, $timeout);
		if ($fp) {
		  fputs ($fp, "GET $path HTTP/1.0\nHost: " . $host . "\n\n");
		  while (!feof($fp)) {
			$buf .= fgets($fp, 128);
		  }
		  $lines = split("\n", $buf);
		  $varResult = $lines[count($lines)-1];
		  fclose($fp);
		} else {
		  # enter error handing code here
		}
		echo $varResult;
	}elseif (is_page('4814')){
		$PostPage = "http://www.pediatricweb.com/webpost/Behavior.asp?";
		
		$variables = "pw_groupid=270";
		$variables = $variables . "&pw_accesscode=B14D3C17-704F-4BCD-A8ED-D32985D25041";
		$variables = $variables . "&pw_url=";
		$variables = $variables . "&pw_articlepage=" . "/education/pediatric-patient-education/behavior/";
		if ($_GET["tArticleId"] > "")  {
		   $variables = $variables . "&tArticleId=" . $_GET["tArticleId"];
		} else {
		   if ($_POST["tArticleId"] > "")   {
			 $variables = $variables . "&tArticleId=" . $_POST["tArticleId"];
		   }
		}
		if ($_GET["tCategoryId"] > "") {
		   $variables = $variables . "&tCategoryId=" . $_GET["tCategoryId"];
		} else {
		   if ($_POST["tCategoryId"] > "")   {
			  $variables = $variables . "&tCategoryId=" . $_POST["tCategoryId"];
		   }
		}
		
		if ($_GET["tArticleStyle"] > ""){
		   $variables = $variables . "&tArticleStyle=" . $_GET["tArticleStyle"];
		} else {
			if ($_POST["tArticleStyle"] > "")    {
			  $variables = $variables . "&tArticleStyle=" . $_POST["tArticleStyle"];
			}
		}
		
		
		$query = $PostPage . $variables;

		$url = parse_url($query);
		$host = $url["host"];
		$path = $url["path"] . "?" . $url["query"];
		$timeout = 1;
		$fp = fsockopen ($host, 80, $errno, $errstr, $timeout);
		if ($fp) {
		  fputs ($fp, "GET $path HTTP/1.0\nHost: " . $host . "\n\n");
		  while (!feof($fp)) {
			$buf .= fgets($fp, 128);
		  }
		  $lines = split("\n", $buf);
		  $varResult = $lines[count($lines)-1];
		  fclose($fp);
		} else {
		  # enter error handing code here
		}
		echo $varResult;
	}elseif (is_page('4816')){
		$PostPage = "http://www.pediatricweb.com/webpost/Breastfeeding.asp?";
		
		$variables = "pw_groupid=270";
		$variables = $variables . "&pw_accesscode=B14D3C17-704F-4BCD-A8ED-D32985D25041";
		$variables = $variables . "&pw_url=";
		$variables = $variables . "&pw_articlepage=" . "/education/pediatric-patient-education/breastfeeding/";
		if ($_GET["tArticleId"] > "")  {
		   $variables = $variables . "&tArticleId=" . $_GET["tArticleId"];
		} else {
		   if ($_POST["tArticleId"] > "")   {
			 $variables = $variables . "&tArticleId=" . $_POST["tArticleId"];
		   }
		}
		if ($_GET["tCategoryId"] > "") {
		   $variables = $variables . "&tCategoryId=" . $_GET["tCategoryId"];
		} else {
		   if ($_POST["tCategoryId"] > "")   {
			  $variables = $variables . "&tCategoryId=" . $_POST["tCategoryId"];
		   }
		}
		
		if ($_GET["tArticleStyle"] > ""){
		   $variables = $variables . "&tArticleStyle=" . $_GET["tArticleStyle"];
		} else {
			if ($_POST["tArticleStyle"] > "")    {
			  $variables = $variables . "&tArticleStyle=" . $_POST["tArticleStyle"];
			}
		}
		
		
		$query = $PostPage . $variables;
		$url = parse_url($query);
		$host = $url["host"];
		$path = $url["path"] . "?" . $url["query"];
		$timeout = 1;
		$fp = fsockopen ($host, 80, $errno, $errstr, $timeout);
		if ($fp) {
		  fputs ($fp, "GET $path HTTP/1.0\nHost: " . $host . "\n\n");
		  while (!feof($fp)) {
			$buf .= fgets($fp, 128);
		  }
		  $lines = split("\n", $buf);
		  $varResult = $lines[count($lines)-1];
		  fclose($fp);
		} else {
		  # enter error handing code here
		}
		echo $varResult;

	}elseif (is_page('4818')){
		$PostPage = "http://www.pediatricweb.com/webpost/WGA.asp?";
		
		$variables = "pw_groupid=270";
		$variables = $variables . "&pw_accesscode=B14D3C17-704F-4BCD-A8ED-D32985D25041";
		$variables = $variables . "&pw_url=";
		$variables = $variables . "&pw_articlepage=" . "/education/pediatric-patient-education/whats-going-around/";
		if ($_GET["tArticleId"] > "")  {
		   $variables = $variables . "&tArticleId=" . $_GET["tArticleId"];
		} else {
		   if ($_POST["tArticleId"] > "")   {
			 $variables = $variables . "&tArticleId=" . $_POST["tArticleId"];
		   }
		}
		if ($_GET["tCategoryId"] > "") {
		   $variables = $variables . "&tCategoryId=" . $_GET["tCategoryId"];
		} else {
		   if ($_POST["tCategoryId"] > "")   {
			  $variables = $variables . "&tCategoryId=" . $_POST["tCategoryId"];
		   }
		}
		
		if ($_GET["tArticleStyle"] > ""){
		   $variables = $variables . "&tArticleStyle=" . $_GET["tArticleStyle"];
		} else {
			if ($_POST["tArticleStyle"] > "")    {
			  $variables = $variables . "&tArticleStyle=" . $_POST["tArticleStyle"];
			}
		}
		
		
		$query = $PostPage . $variables;
		$url = parse_url($query);
		$host = $url["host"];
		$path = $url["path"] . "?" . $url["query"];
		$timeout = 1;
		$fp = fsockopen ($host, 80, $errno, $errstr, $timeout);
		if ($fp) {
		  fputs ($fp, "GET $path HTTP/1.0\nHost: " . $host . "\n\n");
		  while (!feof($fp)) {
			$buf .= fgets($fp, 128);
		  }
		  $lines = split("\n", $buf);
		  $varResult = $lines[count($lines)-1];
		  fclose($fp);
		} else {
		  # enter error handing code here
		}
		echo $varResult;

	}elseif (is_page('4820')){
		$PostPage = "http://www.pediatricweb.com/webpost/Newborns.asp?";
		
		$variables = "pw_groupid=270";
		$variables = $variables . "&pw_accesscode=B14D3C17-704F-4BCD-A8ED-D32985D25041";
		$variables = $variables . "&pw_url=";
		$variables = $variables . "&pw_articlepage=" . "/education/pediatric-patient-education/newborns/";
		if ($_GET["tArticleId"] > "")  {
		   $variables = $variables . "&tArticleId=" . $_GET["tArticleId"];
		} else {
		   if ($_POST["tArticleId"] > "")   {
			 $variables = $variables . "&tArticleId=" . $_POST["tArticleId"];
		   }
		}
		if ($_GET["tCategoryId"] > "") {
		   $variables = $variables . "&tCategoryId=" . $_GET["tCategoryId"];
		} else {
		   if ($_POST["tCategoryId"] > "")   {
			  $variables = $variables . "&tCategoryId=" . $_POST["tCategoryId"];
		   }
		}
		
		if ($_GET["tArticleStyle"] > ""){
		   $variables = $variables . "&tArticleStyle=" . $_GET["tArticleStyle"];
		} else {
			if ($_POST["tArticleStyle"] > "")    {
			  $variables = $variables . "&tArticleStyle=" . $_POST["tArticleStyle"];
			}
		}
		
		
		$query = $PostPage . $variables;
		$url = parse_url($query);
		$host = $url["host"];
		$path = $url["path"] . "?" . $url["query"];
		$timeout = 1;
		$fp = fsockopen ($host, 80, $errno, $errstr, $timeout);
		if ($fp) {
		  fputs ($fp, "GET $path HTTP/1.0\nHost: " . $host . "\n\n");
		  while (!feof($fp)) {
			$buf .= fgets($fp, 128);
		  }
		  $lines = split("\n", $buf);
		  $varResult = $lines[count($lines)-1];
		  fclose($fp);
		} else {
		  # enter error handing code here
		}
		echo $varResult;

	}elseif (is_page('4822')){
		$PostPage = "http://www.pediatricweb.com/webpost/Teens.asp?";
		
		$variables = "pw_groupid=270";
		$variables = $variables . "&pw_accesscode=B14D3C17-704F-4BCD-A8ED-D32985D25041";
		$variables = $variables . "&pw_url=";
		$variables = $variables . "&pw_articlepage=" . "/education/pediatric-patient-education/teens/";
		if ($_GET["tArticleId"] > "")  {
		   $variables = $variables . "&tArticleId=" . $_GET["tArticleId"];
		} else {
		   if ($_POST["tArticleId"] > "")   {
			 $variables = $variables . "&tArticleId=" . $_POST["tArticleId"];
		   }
		}
		if ($_GET["tCategoryId"] > "") {
		   $variables = $variables . "&tCategoryId=" . $_GET["tCategoryId"];
		} else {
		   if ($_POST["tCategoryId"] > "")   {
			  $variables = $variables . "&tCategoryId=" . $_POST["tCategoryId"];
		   }
		}
		
		if ($_GET["tArticleStyle"] > ""){
		   $variables = $variables . "&tArticleStyle=" . $_GET["tArticleStyle"];
		} else {
			if ($_POST["tArticleStyle"] > "")    {
			  $variables = $variables . "&tArticleStyle=" . $_POST["tArticleStyle"];
			}
		}
		
		
		$query = $PostPage . $variables;
		$url = parse_url($query);
		$host = $url["host"];
		$path = $url["path"] . "?" . $url["query"];
		$timeout = 1;
		$fp = fsockopen ($host, 80, $errno, $errstr, $timeout);
		if ($fp) {
		  fputs ($fp, "GET $path HTTP/1.0\nHost: " . $host . "\n\n");
		  while (!feof($fp)) {
			$buf .= fgets($fp, 128);
		  }
		  $lines = split("\n", $buf);
		  $varResult = $lines[count($lines)-1];
		  fclose($fp);
		} else {
		  # enter error handing code here
		}
		echo $varResult;
					
	}
        echo '<div><p class="pediweb-helper"><span class="icon-cr-info"></span> Content provided by PediWeb.<br />Content authors are not and have not ever been associated with The Austin Diagnostic Clinic.</p></div>';

	

	echo '</div><!-- end .entry-content -->';
	echo '</div><!-- end .page .hentry .entry -->';
}
	
/** Remove Post Info */
remove_action('genesis_before_post_content','genesis_post_info');
remove_action('genesis_after_post_content','genesis_post_meta');
 
genesis();
