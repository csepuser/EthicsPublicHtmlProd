<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language->language; ?>" xml:lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>">

<head>
  <title><?php print $head_title ?></title>
  
  <meta http-equiv="Content-Style-Type" content="text/css" />
  <?php /* Setting the default style sheet language for validation */  ?>
  
  <?php print $head ?>
  <?php print $styles ?>
  
  <!--[if IE 6]>
    <link rel="stylesheet" type="text/css" href="<?php print base_path(). path_to_theme(); ?>/iestyles/ie6.css" />
<![endif]-->

  <!--[if IE 7]>
    <link rel="stylesheet" type="text/css" href="<?php print base_path(). path_to_theme(); ?>/iestyles/ie7.css" />
<![endif]-->
  
  
  <?php print $scripts ?>
</head>

<body class="<?php print add_css_classes(); ?>">
  
<div class="main-container">
  <div id="page">

    <div id="header">
      <table width="100%">
	<tr>
	  <td align="left">
	    <a href="<?php print $base_path ?>" title="<?php print t('Home') ?>"><div id="eel-logo"></div></a>
	  </td>
	  <td align="right">
	    <table width ="100%" style="float:left">
	      <tr>
		<td style="padding-right :80px;" width="60%">
		  <?php print str_replace("Search this site:", "", $search_box); ?>
		</td>
		<td width="40%">	    
		  <?php if($user->uid == 0): ?>
		  <div class="user-links">New User? <a href="<?php print url('user/register'); ?>">Register</a> | <a href="<?php print url('user/login'); ?>">Login</a></div>
		  <?php endif; ?>
		</td>
	      </tr>  
	    </table>

	    <div style="clear:both;"></div>
	    <div id="eel-slogan"><?php if($site_slogan):?> <p class="slogan"><?php print $site_slogan ?></p><?php endif; ?></div><br/>
	    
	  </td>
	</tr>
      </table>
    </div> <!-- header -->

    <div id="utilities">     
      <?php if (isset($primary_links)) : ?>
      <div id="plinks">
      <?php
	 if(theme_get_setting('menutype')== '0') { 
	   print theme('links', $primary_links, array('class' => 'links primary-links'));	
         } else {
           print phptemplate_get_primary_links();
         }
      ?>
      </div>
      <?php endif; ?>
    </div> <!-- utilities -->
 
    <?php if (($secondary_links)) : ?>
      <div id="navmenu">
	<?php print theme('links', $secondary_links, array('class' => 'links secondary-links')); ?>
      </div>
      <div class="stopfloat"></div>
    <?php endif; ?>

    <div class="wrapper"> <!--wrapper:defines whole content margins-->
      
      <!-- left -->
      <?php if($left): ?>
      <div class="lsidebar">
        <?php print $left ?>
      </div>
      <?php endif; ?>
      <!-- end left -->

      <div id="primary" class="<?php print marinelli_width( $left, $right); ?>">
           <div class="singlepage">
	     <?php print $breadcrumb; ?> 
	     <?php if ($mission): print '<div id="sitemission"><p>'. $mission .'</p></div>'; endif; ?>
	     <?php if($title): ?>
	       <?php 
		   if ($is_front){ 
		      //if we are on the front page use <h2> for title.
		      print '<h2'. ($tabs ? ' class="with-tabs"' : '') .'>'. $title .'</h2>'; 		 
		   } else {
		      //otherwise use <h1> for node title
		      print '<h1'. ($tabs ? ' class="with-tabs"' : '') .'>'. $title .'</h1>';  
		   }
	       ?>
	     <?php endif; ?> <!-- title -->
		 
             <?php if ($tabs): print '<div class="tabs">'.$tabs.'</div>'; endif; ?>
             <?php if ($help) { ?><div class="help"><?php print $help ?></div><?php } ?>
             <?php if ($messages) { ?><div class="messages"><?php print $messages ?></div><?php } ?>
	     <div class="drdot"> <hr/> </div>
             
	     <?php print $content ?>
	   </div> <!-- singlepage-->
     </div> <!-- primary -->
   
    <!-- right -->
    <?php if ($right): ?>
      <div class="rsidebar"> 
        <?php print $right ?>
      </div>
    <?php endif; ?>
    <!-- end right -->

    <div class="clear" style="clear: both;"></div>
    </div> <!-- wrapper -->
  </div> <!-- page -->

  <div id="footer">
    <?php print $footer ?>
    <?php print $footer_message ?>
  </div>
  
</div> <!-- main container -->

<?php print $closure ?>
</body>
</html>
