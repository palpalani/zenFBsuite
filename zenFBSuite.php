<?php 

/*
This plugin is a combination of many of the Facebook social plugins implemented for easy use
in your Zenphoto gallery. Simply set the options in the admin interface and make the appropriate
template changes to place the Facebook features/integration you'd like.

Code Implementation - Micheal Luttrull (micheall)
*/

$plugin_is_filter = 5|THEME_PLUGIN;
$plugin_description = gettext("zenFBSuite is a plugin to implement the Facebook social plugins into your Zenphoto powered CMS/Gallery.");
$plugin_author      = "Micheal Luttrull (micheall)";
$plugin_version     = "1.4.4.3";
$plugin_URL         = "http://inthemdl.net/pages/zenfb-suite";

//zenFBSuite Option Interface
$option_interface = 'zenFBSuiteOptions';

/*
Register OpenGraph Meta keys into theme header
*/
zp_register_filter('theme_head', 'zenFBOpenGraphTags');
zp_register_filter('theme_body_open', 'zenFBSuiteJS');

/*
zenFBSuite Plugin option handling class
*/
class zenFBSuiteOptions {
				function zenFBSuiteOptions() {
								//zenFBcommon
								setOptionDefault('zenFBcommon_appid', NULL);
								setOptionDefault('zenFBcommon_adminid', NULL);
								setOptionDefault('zenFBcommon_defaultlogo', NULL);
								setOptionDefault('zenFBcommon_siteroot', NULL);
								
								//zenFBActivity
								setOptionDefault('zenFBActivity_showheader', 0);
								setOptionDefault('zenFBActivity_recommends', 0);
								setOptionDefault('zenFBActivity_font', 0);
								setOptionDefault('zenFBActivity_scheme', 0);
								setOptionDefault('zenFBActivity_width', '300');
								setOptionDefault('zenFBActivity_height', '300');
								setOptionDefault('zenFBActivity_linktarget', '_blank');
								setOptionDefault('zenFBActivity_bordercolor', NULL);

								//zenFBComments
								setOptionDefault('zenFBComments_numofposts', '10');
								setOptionDefault('zenFBComments_width', '450');
								setOptionDefault('zenFBComments_albums', 1);
								setOptionDefault('zenFBComments_images', 1);
								setOptionDefault('zenFBComments_articles', 1);
								setOptionDefault('zenFBComments_pages', 1);
								setOptionDefault('zenFBComments_colorscheme', 0);
								setOptionDefault('zenFBComments_migrate', 0);	
								
								//zenFBLike
								setOptionDefault('zenFBLike_layoutstyle', 0);
								setOptionDefault('zenFBLike_showfaces', 0);
								setOptionDefault('zenFBLike_verbage', 0);
								setOptionDefault('zenFBLike_font', 0);
								setOptionDefault('zenFBLike_scheme', 0);
								setOptionDefault('zenFBLike_width', '450');
								setOptionDefault('zenFBLike_sendbutton', 0);
								
								//zenFBRecommend
								setOptionDefault('zenFBRecommend_showheader', 0);
								setOptionDefault('zenFBRecommend_font', 0);
								setOptionDefault('zenFBRecommend_scheme', 0);
								setOptionDefault('zenFBRecommend_width', '300');
								setOptionDefault('zenFBRecommend_height', '300');
								setOptionDefault('zenFBRecommend_linktarget', '_blank');
								setOptionDefault('zenFBRecommend_bordercolor', NULL);
								
								//zenFBSend
								setOptionDefault('zenFBSend_font', 0);
								setOptionDefault('zenFBSend_scheme', 0);
				}
				
				function getOptionsSupported() {
								//zenFBCommonets Checkboxes
								$checkboxes = array(
												gettext('Albums') => 'zenFBComments_albums',
												gettext('Images') => 'zenFBComments_images'
								);
								if (getOption('zp_plugin_zenpage')) {
												$checkboxes = array_merge($checkboxes, array(
																gettext('Pages') => 'zenFBComments_pages',
																gettext('News') => 'zenFBComments_articles'
												));
								}
								return array(
												//zenFBcommon Options
												gettext('Common: Application ID') => array(
																'key' => 'zenFBcommon_appid',
																'type' => 0,
																'order' => 0,
																'desc' => gettext('Enter <em>YOUR</em> Application ID from facebook here. For more information please visit <a href="http://inthemdl.net/news/creating-your-facebook-app_id" target="_blank">this page</a>.<br /><em><b>Please note:  YOU MUST ENTER AN APPLICATION ID FOR THESE PLUGINS TO FUNCTION!</b></em><br />
								  You should be entering numbers only in this field.')
												),
												gettext('Common: Admin ID/User ID') => array(
																'key' => 'zenFBcommon_adminid',
																'type' => 0,
																'order' => 1,
																'desc' => gettext('Enter <em>YOUR</em> User ID from facebook here. For more information please visit <a href="http://inthemdl.net/news/finding-your-facebook-userid" target="_blank">this page</a>.<br />
								  Enter your Facebook User ID # or vanity name here.<br />
								  <em><b>Please note:  YOU MUST ENTER AN ADMIN ID FOR THESE PLUGINS TO FUNCTION!</b></em><br />
								  For multiple admins, enter a comma separated list (can be #s or name); i.e.  \'1273267113, micheall, myfacebooknamerocks\'')
												),
												gettext('Common: Default Logo URL') => array(
																'key' => 'zenFBcommon_defaultlogo',
																'type' => 0,
																'order' => 2,
																'desc' => gettext('If zenphoto does not have a current image/object thumbnail do you want to display a default logo? Enter a valid URL link to the image you would like to use.  If nothing entered, and no current object/image thumbnail available, Facebook wall posts will not display an image. If an invalid URL is used it will display a broken link to an image.')
												),
												gettext('Common: Site Root Install Location') => array(
																'key' => 'zenFBcommon_siteroot',
																'type' => 0,
																'order' => 3,
																'desc' => gettext('Enter the url (including http://) to the root fo your Zenphoto installation. i.e. http://inthemdl.net/ or http://myzenphoto.com/gallery/')
												),
												//zenFBActivity Options
												gettext('Activity: Hide Header?') => array(
																'key' => 'zenFBActivity_showheader',
																'type' => 5,
																'order' => 4,
																'selections' => array(
																				gettext('No') => 0,
																				gettext('Yes') => 1
																),
																'desc' => gettext('Do you want to hide the "Recent Activity" header in your box?')
												),
												gettext('Activity: Show Recommendations?') => array(
																'key' => 'zenFBActivity_recommends',
																'type' => 5,
																'order' => 5,
																'selections' => array(
																				gettext('No') => 0,
																				gettext('Yes') => 1
																),
																'desc' => gettext('Enabling this will split your activity box in half with recent activity and recommendations by default. Leaving this set to no will still populate empty space in the box with recommendations.')
												),
												gettext('Activity: Font') => array(
																'key' => 'zenFBActivity_font',
																'type' => 5,
																'order' => 6,
																'selections' => array(
																				gettext('Default') => 0,
																				gettext('Arial') => 1,
																				gettext('Lucida Grande') => 2,
																				gettext('Segoe UI') => 3,
																				gettext('Tahoma') => 4,
																				gettext('Trebuche MS') => 5,
																				gettext('Verdana') => 6
																),
																'desc' => gettext('Which font do you want to use?')
												),
												gettext('Activity: Color Scheme') => array(
																'key' => 'zenFBActivity_scheme',
																'type' => 5,
																'order' => 7,
																'selections' => array(
																				gettext('Light') => 0,
																				gettext('Dark') => 1
																),
																'desc' => gettext('Simple Light or Dark color scheme selection.')
												),
												gettext('Activity: Width') => array(
																'key' => 'zenFBActivity_width',
																'type' => 0,
																'order' => 8,
																'desc' => gettext('Width to display recommend box. Defaults to 300 pixels. (numbers only)')
												),
												gettext('Activity: Height') => array(
																'key' => 'zenFBActivity_height',
																'type' => 0,
																'order' => 9,
																'desc' => gettext('Height to display recommend box. Defaults to 300 pixels. (numbers only)')
												),
												gettext('Activity: Border Color') => array(
																'key' => 'zenFBActivity_bordercolor',
																'type' => 0,
																'order' => 10,
																'desc' => gettext('What color do you want the border to be? Can be RGB hastags (#FF33FF) or Color Words (white, pink, black, gray, etc).')
												),												
												gettext('Activity: Link Target') => array(
																'key' => 'zenFBActivity_linktarget',
																'type' => 5,
																'order' => 11,
																'selections' => array(
																				gettext('_blank') => 0,
																				gettext('_top') => 1,
																				gettext('_parent') => 2,
																),
																'desc' => gettext('Where do you want links to target?')
												),
												//zenFBComments Options
												gettext('Comments: Allow comments on') => array(
																'key' => 'zenFBComments_allowed',
																'type' => OPTION_TYPE_CHECKBOX_ARRAY,
																'checkboxes' => $checkboxes,
																'order' => 12,
																'desc' => gettext('Comment forms will be presented on the checked pages.')
												),
												gettext('Comments: Number Of Posts') => array(
																'key' => 'zenFBComments_numofposts',
																'type' => 0,
																'order' => 13,
																'desc' => gettext('Number of posts to display. Defaults to 10. (numbers only)')
												),
												gettext('Comments: Width') => array(
																'key' => 'zenFBComments_width',
																'type' => 0,
																'order' => 14,
																'desc' => gettext('Width to display like button & options. Defaults to 450 pixels. (numbers only)')
												),
												gettext('Comments: Color Scheme') => array(
																'key' => 'zenFBComments_colorscheme',
																'type' => 5,
																'order' => 15,
																'selections' => array(
																				gettext('Light') => 0,
																				gettext('Dark') => 1
																),
																'desc' => gettext('Choose which style to use.')
												),
												//zenFBLike Options
												gettext('Like: Layout Style') => array(
																'key' => 'zenFBLike_layoutstyle',
																'type' => 5,
																'order' => 16,
																'selections' => array(
																				gettext('Standard') => 0,
																				gettext('Simple Button Count') => 1,
																				gettext('Box Count') => 2
																),
																'desc' => gettext('Determine the layout of social context next to the button.')
												),
												gettext('Like: Show Faces?') => array(
																'key' => 'zenFBLike_showfaces',
																'type' => 5,
																'order' => 17,
																'selections' => array(
																				gettext('Yes') => 0,
																				gettext('No') => 1
																				
																),
																'desc' => gettext('Do you want to show profile pictures below the button of people who have clicked like?')
												),
												gettext('Like: Verbage') => array(
																'key' => 'zenFBLike_verbage',
																'type' => 5,
																'order' => 18,
																'selections' => array(
																				gettext('Like') => 0,
																				gettext('Recommend') => 1
																),
																'desc' => gettext('Do you want to use "Like" or "Recommend"?')
												),
												gettext('Like: Font') => array(
																'key' => 'zenFBLike_font',
																'type' => 5,
																'order' => 19,
																'selections' => array(
																				gettext('Default') => 0,
																				gettext('Arial') => 1,
																				gettext('Lucida Grande') => 2,
																				gettext('Segoe UI') => 3,
																				gettext('Tahoma') => 4,
																				gettext('Trebuche MS') => 5,
																				gettext('Verdana') => 6
																),
																'desc' => gettext('Which font do you want to use?')
												),
												gettext('Like: Color Scheme') => array(
																'key' => 'zenFBLike_scheme',
																'type' => 5,
																'order' => 20,
																'selections' => array(
																				gettext('Light') => 0,
																				gettext('Dark') => 1
																),
																'desc' => gettext('Simple Light or Dark color scheme selection.')
												),
												gettext('Like: Width') => array(
																'key' => 'zenFBLike_width',
																'type' => 0,
																'order' => 21,
																'desc' => gettext('Width to display like button & options. Defaults to 450 pixels. (numbers only)')
												),
												gettext('Like: Include Send Button') => array(
																'key' => 'zenFBLike_sendbutton',
																'type' => 5,
																'order' => 22,
																'selections' => array(
																				gettext('Yes') => 0,
																				gettext('No') => 1	
																),
																'desc' => gettext('Do you want to include a send button next to the like button?')
												),
												//zenFBRecommend Options
												gettext('Recommendations: Hide Header?') => array(
																'key' => 'zenFBRecommend_showheader',
																'type' => 5,
																'order' => 23,
																'selections' => array(
																				gettext('No') => 0,
																				gettext('Yes') => 1
																),
																'desc' => gettext('Do you want to hide the "Recommendations" header in your box?')
												),
												gettext('Recommendations: Font') => array(
																'key' => 'zenFBRecommend_font',
																'type' => 5,
																'order' => 24,
																'selections' => array(
																				gettext('Default') => 0,
																				gettext('Arial') => 1,
																				gettext('Lucida Grande') => 2,
																				gettext('Segoe UI') => 3,
																				gettext('Tahoma') => 4,
																				gettext('Trebuche MS') => 5,
																				gettext('Verdana') => 6
																),
																'desc' => gettext('Which font do you want to use?')
												),
												gettext('Recommendations: Color Scheme') => array(
																'key' => 'zenFBRecommend_scheme',
																'type' => 5,
																'order' => 25,
																'selections' => array(
																				gettext('Light') => 0,
																				gettext('Dark') => 1
																),
																'desc' => gettext('Simple Light or Dark color scheme selection.')
												),
												gettext('Recommendations: Width') => array(
																'key' => 'zenFBRecommend_width',
																'type' => 0,
																'order' => 26,
																'desc' => gettext('Width to display recommend box. Defaults to 300 pixels. (numbers only)')
												),
												gettext('Recommendations: Height') => array(
																'key' => 'zenFBRecommend_height',
																'type' => 0,
																'order' => 27,
																'desc' => gettext('Height to display recommend box. Defaults to 300 pixels. (numbers only)')
												),
												gettext('Recommendations: Border Color') => array(
																'key' => 'zenFBRecommend_bordercolor',
																'type' => 0,
																'order' => 28,
																'desc' => gettext('What color do you want the border to be? Can be RGB hastags (#FF33FF) or Color Words (white, pink, black, gray, etc).')
												),												
												gettext('Recommendations: Link Target') => array(
																'key' => 'zenFBRecommend_linktarget',
																'type' => 5,
																'order' => 29,
																'selections' => array(
																				gettext('_blank') => 0,
																				gettext('_top') => 1,
																				gettext('_parent') => 2,
																),
																'desc' => gettext('Where do you want links to target?')
												),
												//zenFBSend Options
												gettext('Send: Font') => array(
																'key' => 'zenFBSend_font',
																'type' => 5,
																'order' => 30,
																'selections' => array(
																				gettext('Default') => 0,
																				gettext('Arial') => 1,
																				gettext('Lucida Grande') => 2,
																				gettext('Segoe UI') => 3,
																				gettext('Tahoma') => 4,
																				gettext('Trebuche MS') => 5,
																				gettext('Verdana') => 6
																),
																'desc' => gettext('Which font do you want to use?')
												),
												gettext('Send: Color Scheme') => array(
																'key' => 'zenFBSend_scheme',
																'type' => 5,
																'order' => 31,
																'selections' => array(
																				gettext('Light') => 0,
																				gettext('Dark') => 1
																),
																'desc' => gettext('Simple Light or Dark color scheme selection.')
												)
								);
								
				}
				
				function handleOption($option, $currentValue) {
				}
}


/* 
OpenGraph Keys to be added to the header via a filter call to theme_head.
These keys, while not essential for integration, are now essential for the plugins
as I feel it helps provide a deeper link between your gallery and Facebook.
*/
function zenFBOpenGraphTags() {
				global $_zp_gallery, $_zp_current_album, $_zp_current_image, $_zp_current_zenpage_news, $_zp_current_zenpage_page, $_zp_gallery_page, $_zp_current_category, $_zp_authority;
				//Populate OpenGraph Site Name with Gallery title
				echo '<meta property="og:site_name" content="' . getBareGalleryTitle() . '" />';
				//Populate OpenGraph Title with Gallery title
				echo '<meta property="og:title" content="' . getBareGalleryTitle() . '" />';				
				// Populate OpenGraph URL metakey with the URL to current page
				echo '<meta property="og:url" content="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '"/>';
				// Populate OG:Type as website or article based on if at root page or not.
				$currenturl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '';
				$siteroot   = getOption('zenFBSuite_siteroot');
				if ($siteroot == $currenturl) {
								echo '<meta property="og:type" content="website" />';
				}
				else {
								echo '<meta property="og:type" content="article" />';
				}
				
				// Use the object thumbnail if viewing an item in gallery, else it will randomly choose an image
				// from your webpage.
				if (getImageThumb()) {
								echo '<meta property="og:image" content="http://' . $_SERVER['HTTP_HOST'] . getUnprotectedImageURL() . '" />';
				} else {
								$logo = getOption('zenFBSuite_defaultlogo');
								if ($logo != NULL) {
												echo '<meta property="og:image" content="' . $logo . '" />';
								}
				}
				/*
				You need to set up your own app_id for these plugins, for multiple reasons.
				1)  Some of the advanced features are tied to both your URL and the app_id that is registered.
				If they don't match, they will not work.
				
				2)  You want to drive people to YOUR site, not to the zenFBSuite site.  Set up your own application
				by following the information in the post listed below.
				Please visit "http://inthemdl.net/news/creating-your-facebook-app_id" for more information.
				*/
				$appid = getOption('zenFBSuite_appid');
				if ($appid != NULL) {
								echo '<meta property="fb:app_id" content="' . $appid . '"/>';
				} else {
								echo '<meta property="fb:app_id" content="126578374030382"/>';
				}
				/*
				Change the your facebook ID in the admin options.
				Please visit: "http://inthemdl.net/news/finding-your-facebook-userid" for more information.
				*/
				$adminid = getOption('zenFBSuite_adminid');
				if ($adminid != NULL) {
								echo '<meta property="fb:admins" content="' . $adminid . '"/>';
				} else {
								echo '<meta property="fb:admins" content="micheall"/>';
				}
				// Add meta tag for og:description
				// Set og:description to match the gallery description.
				$desc = getBareGalleryDesc();
				// Set desc to image description if viewing an image.
				if (is_object($_zp_current_image) AND is_object($_zp_current_album)) {
								$desc = getBareImageDesc();
				}
				// Set desc to album description if viewing page with album thumbs.
				if (is_object($_zp_current_album) AND !is_object($_zp_current_image)) {
								$desc = getBareAlbumDesc();
				}
				// Set desc to contents of article or page if viewing.
				if (function_exists("is_NewsArticle")) {
								if (is_NewsArticle()) {
												$desc = strip_tags(getNewsContent());
								} else if (is_NewsCategory()) {
												$desc = "";
								} else if (is_Pages()) {
												$desc = strip_tags(getPageContent());
								}
				}
				echo '<meta property="og:description" content="' . $desc . '"/>';
				echo '<meta property="og:locale" content="en_US"/>';
}

//zenFBcommon
/*
zenFBSuite - Places code Facebook div with proper javascript into pages.
*/
function zenFBSuiteJS() {
				$appid   = getOption('zenFBSuite_appid');
				$adminid = getOption('zenFBSuite_adminid');
				echo "
		<div id='fb-root'></div>
		<script>
		  window.fbAsyncInit = function() {
		    FB.init({
		      appId  : '" . $appid . "',
		      status : true, // check login status
		      cookie : true, // enable cookies to allow the server to access the session
		      xfbml  : true  // parse XFBML
		    });
		  };

		  (function() {
		    var e = document.createElement('script');
		    e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
		    e.async = true;
		    document.getElementById('fb-root').appendChild(e);
		  }());
	</script>";
}

//zenFBActivity
/*
Places the Facebook "Recommendations" box wherever you want: (e.g. album page, image page)
<?php if (function_exists('zenFBActivity')) { zenFBActivity(); } ?>
*/
function zenFBActivity() {
				// Set variables
				$showheader = getOption('zenFBActivity_showheader');
				$recommends = getOption('zenFBActivity_recommends');
				$font       = getOption('zenFBActivity_font');
				$scheme     = getOption('zenFBActivity_scheme');
				$target		= getOption('zenFBActivity_linktarget');
				$bordercolr	= getOption('zenFBActivity_bordercolor');				
				$width      = gettext(getOption('zenFBActivity_width'));
				$height     = gettext(getOption('zenFBActivity_height'));
				$domain     = $_SERVER['HTTP_HOST'];
				
				
				// Output XFBML
				$zenFBActivity_html = '<div class="fb-activity" data-site="' . $site . '" ';
				$zenFBActivity_html .= 'data-width="' . $width . '" ';
				$zenFBActivity_html .= 'data-height="' . $height . '" ';
				if ($showheader == 1) {
								$zenFBActivity_html .= 'data-header="false" ';
				} else {
								$zenFBActivity_html .= 'data-header="true" ';
				}
				if ($scheme == 1) {
								$zenFBActivity_html .= 'data-colorscheme="dark" ';
				}
				if ($target == 0) {
								$zenFBActivity_html .= 'data-linktarget="_blank" ';
				}
				if ($target == 1) {
								$zenFBActivity_html .= 'data-linktarget="_top" ';
				}
				if ($target == 2) {
								$zenFBActivity_html .= 'data-linktarget="_parent" ';
				}
				if ($bordercolr != NULL) {
								$zenFBActivity_html .= 'data-border-color="' . $bordercolr . '" ';
				}
				if ($font == 1) {
								$zenFBActivity_html .= 'data-font="arial" ';
				}
				if ($font == 2) {
								$zenFBActivity_html .= 'data-font="lucida grande" ';
				}
				if ($font == 3) {
								$zenFBActivity_html .= 'data-font="segoe ui" ';
				}
				if ($font == 4) {
								$zenFBActivity_html .= 'data-font="tahoma" ';
				}
				if ($font == 5) {
								$zenFBActivity_html .= 'data-font="trebuche ms" ';
				}
				if ($font == 6) {
								$zenFBActivity_html .= 'data-font="verdana" ';
				}
				if ($recommends == 1) {
								$zenFBActivity_html .= 'data-recommendations="true" ';
				}
				$zenFBActivity_html .= '></div>';
				
				echo $zenFBActivity_html;
				
				unset($zenFBActivity_html);
}

//zenFBComments
/*
Places the Comment box into your theme wherever you want a box to show: (e.g. album page, image page)
<?php if (function_exists('zenFBComments')) { zenFBComments(); } ?>
*/
function zenFBComments() {
				//Initiate Global Variables
				global $_zp_gallery_page;
				//Check Whether comments are allowed on certain pages, if disabled return.
				switch ($_zp_gallery_page) {
								case 'album.php':
												if (!getOption('zenFBComments_albums'))
																break;
												$comments_open = OpenedForComments(ALBUM);
												break;
								case 'image.php':
												if (!getOption('zenFBComments_images'))
																break;
												$comments_open = OpenedForComments(IMAGE);
												break;
								case 'pages.php':
												if (!getOption('zenFBComments_pages'))
																break;
												$comments_open = zenpageOpenedForComments();
												break;
								case 'news.php':
												if (!getOption('zenFBComments_articles'))
																break;
												$comments_open = zenpageOpenedForComments();
												break;
								default:
												return;
												break;
				}
				// Set variables
				$numofposts = gettext(getOption('zenFBComments_numofposts'));
				$width      = gettext(getOption('zenFBComments_width'));
				$scheme     = getOption('zenFBComments_colorscheme');
				$migrate    = getOption('zenFBComments_migrate');
				if (!isset($_SERVER['HTTPS'])) {
				$url    = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
				} else { 
				$url    = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
				}
				
				// Output Button XFBML
				if ($comments_open) {
								$zenFBComments_html = '<div class="fb-comments" ';
								$zenFBComments_html .= 'data-href="' . $url . '" ';
								$zenFBComments_html .= 'data-num-posts="' . $numofposts . '" ';
								$zenFBComments_html .= 'data-width="' . $width . '" ';
								if ($scheme == 1) {
												$zenFBComments_html .= 'data-colorscheme="dark" ';
								}
								$zenFBComments_html .= '></div>';
								echo $zenFBComments_html;
								
								unset($zenFBComments_html);
				}
}

//zenFBLike
/*
Places the Facebook Like html into your theme wherever you want a button to show: (e.g. album page, image page)
<?php if (function_exists('zenFBLike')) { zenFBLike(); } ?>
*/
function zenFBLike() {
				// Set variables
				$layout = getOption('zenFBLike_layoutstyle');
				$faces  = getOption('zenFBLike_showfaces');
				$send	= getOption('zenFBLike_sendbutton');
				$verb   = getOption('zenFBLike_verbage');
				$font   = getOption('zenFBLike_font');
				$scheme = getOption('zenFBLike_scheme');
				$width  = gettext(getOption('zenFBLike_width'));
				if (!isset($_SERVER['HTTPS'])) {
				$url    = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
				} else { 
				$url    = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
				}
				
				
				// Output Button XFBML
				$zenFBLike_html = '<div class="fb-like" data-href="' . $url . '"';
				if ($send == 1) {
								$zenFBLike_html .= 'data-send="false" ';
				} else {
								$zenFBLike_html .= 'data-send="true" ';
				}
				if ($layout == 1) {
								$zenFBLike_html .= 'data-layout="button_count"';
				}
				if ($layout == 2) {
								$zenFBLike_html .= 'data-layout="box_count"';
				}				
				$zenFBLike_html .= 'data-width="' . $width . '" ';							
				if ($faces == 1) {
								$zenFBLike_html .= 'data-show-faces="false" ';
				} else {
								$zenFBLike_html .= 'data-show-faces="true" ';
				}
				if ($verb == 1) {
								$zenFBLike_html .= 'data-action="recommend"';
				}
				if ($scheme == 1) {
								$zenFBLike_html .= 'data-colorscheme="dark"';
				}						
				if ($font == 1) {
								$zenFBLike_html .= 'data-font="arial"';
				}
				if ($font == 2) {
								$zenFBLike_html .= 'data-font="lucida grande"';
				}
				if ($font == 3) {
								$zenFBLike_html .= 'data-font="segoe ui"';
				}
				if ($font == 4) {
								$zenFBLike_html .= 'data-font="tahoma"';
				}
				if ($font == 5) {
								$zenFBLike_html .= 'data-font="trebuche ms"';
				}
				if ($font == 6) {
								$zenFBLike_html .= 'data-font="verdana"';
				}
				$zenFBLike_html .= '></div>';
				
				echo $zenFBLike_html;
				
				unset($zenFBLike_html);
}

//zenFBRecommend
/*
Places the Facebook "Recommendations" box wherever you want: (e.g. album page, image page)
<?php if (function_exists('zenFBRecommend')) { zenFBRecommend(); } ?>
*/
function zenFBRecommend() {
				// Set variables
				$showheader = getOption('zenFBRecommend_showheader');
				$font       = getOption('zenFBRecommend_font');
				$scheme     = getOption('zenFBRecommend_scheme');
				$target		= getOption('zenFBRecommend_linktarget');
				$bordercolr	= getOption('zenFBRecommend_bordercolor');				
				$width      = gettext(getOption('zenFBRecommend_width'));
				$height     = gettext(getOption('zenFBRecommend_height'));
				$domain    = $_SERVER['HTTP_HOST'];
				
				// Output XFBML
				$zenFBRecommend_html = '<div class="fb-recommendations" data-site="' . $site . '" ';
				$zenFBRecommend_html .= 'data-width="' . $width . '" ';
				$zenFBRecommend_html .= 'data-height="' . $height . '" ';
				if ($showheader == 1) {
								$zenFBRecommend_html .= 'data-header="false" ';
				} else {
								$zenFBRecommend_html .= 'data-header="true" ';
				}
				if ($scheme == 1) {
								$zenFBRecommend_html .= 'data-colorscheme="dark" ';
				}
				if ($target == 0) {
								$zenFBRecommend_html .= 'data-linktarget="_blank" ';
				}
				if ($target == 1) {
								$zenFBRecommend_html .= 'data-linktarget="_top" ';
				}
				if ($target == 2) {
								$zenFBRecommend_html .= 'data-linktarget="_parent" ';
				}
				if ($bordercolr != NULL) {
								$zenFBRecommend_html .= 'data-border-color="' . $bordercolr . '" ';
				}
				if ($font == 1) {
								$zenFBRecommend_html .= 'data-font="arial" ';
				}
				if ($font == 2) {
								$zenFBRecommend_html .= 'data-font="lucida grande" ';
				}
				if ($font == 3) {
								$zenFBRecommend_html .= 'data-font="segoe ui" ';
				}
				if ($font == 4) {
								$zenFBRecommend_html .= 'data-font="tahoma" ';
				}
				if ($font == 5) {
								$zenFBRecommend_html .= 'data-font="trebuche ms" ';
				}
				if ($font == 6) {
								$zenFBRecommend_html .= 'data-font="verdana" ';
				}
				$zenFBRecommend_html .= '></div>';
				
				echo $zenFBRecommend_html;
				
				unset($zenFBRecommend_html);
}

//zenFBSend
/*
Places the Facebook Send html into your theme wherever you want a button to show: (e.g. album page, image page)
<?php if (function_exists('zenFBSend')) { zenFBSend(); } ?>
*/
function zenFBSend() {
				// Set variables
				$font   = getOption('zenFBSend_font');
				$scheme = getOption('zenFBSend_scheme');
				if (!isset($_SERVER['HTTPS'])) {
				$url    = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
				} else { 
				$url    = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
				}				
				
				// Output Button XFBML
				$zenFBSend_html = '<div class="fb-send" data-href="' . $url . '"';
				if ($font == 1) {
								$zenFBSend_html .= 'data-font="arial"';
				}
				if ($font == 2) {
								$zenFBSend_html .= 'data-font="lucida grande"';
				}
				if ($font == 3) {
								$zenFBSend_html .= 'data-font="segoe ui"';
				}
				if ($font == 4) {
								$zenFBSend_html .= 'data-font="tahoma"';
				}
				if ($font == 5) {
								$zenFBSend_html .= 'data-font="trebuche ms"';
				}
				if ($font == 6) {
								$zenFBSend_html .= 'data-font="verdana"';
				}
				if ($scheme == 1) {
								$zenFBSend_html .= 'data-colorscheme="dark"';
				}
				$zenFBSend_html .= '></div>';
				
				echo $zenFBSend_html;
				
				unset($zenFBSend_html);
}

?>