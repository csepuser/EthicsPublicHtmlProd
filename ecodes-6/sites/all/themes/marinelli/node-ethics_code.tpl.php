<div class="node<?php if ($sticky) { print " sticky"; } ?><?php if (!$status) { print " node-unpublished"; } ?>">
  <?php if ($picture) {
      print $picture;
  }?>
    
  <?php if ($page == 0) { ?>
    <h2 class="nodeTitle">
      <a href="<?php print $node_url?>"><?php print $title; ?></a>
	<?php global $base_url;
	if ($sticky) { print '<img src="'.base_path(). drupal_get_path('theme','marinelli').'/img/sticky.gif" alt="'.t('sticky icon').'" class="sticky" />'; } ?>
    </h2>
  <?php } ?>
    
  <?php if (!$teaser): ?>
    <?php if ($submitted): ?>
      <div class="metanode"><p><?php print t('By ') .'<span class="author">'. theme('username', $node).'</span>' . t(' - Posted on ') . '<span class="date">'.format_date($node->created, 'custom', "d F Y").'</span>'; ?></p>
      </div> 
    <?php endif; ?>
  <?php endif; ?>
    
  <div class="content">
    <?php 
      //print "<pre>";print_r($node->field_source);print "</pre>";
    ?>

    <div class="field-organization field">
      <strong>Organization: </strong> 
      <?php if(trim($node->field_organization[0]["safe"]["title"])): ?>
        <?php print $node->field_organization[0]["safe"]["title"]; ?>
      <?php endif; ?>
      <?php if(trim($node->field_org_url[0]["value"])): ?>
      	    <?php print "<a href='".$node->field_org_url[0]["value"]."' target='_blank'>Visit Organization Page</a>"; ?>
      <?php endif; ?>
    </div>

    <div class="field-source field">
      <strong>Source: </strong> 
      <?php if(trim($node->field_source[0]["view"])): ?>
        <?php print $node->field_source[0]["view"]; ?>
      <?php endif; ?>
      <?php if(trim($node->field_source_url[0]["value"])): ?>
      	    <?php print "<a href='".$node->field_source_url[0]["value"]."' target='_blank'>Visit Source Page</a>"; ?>
      <?php endif; ?>
    </div>

    <?php print $content ?>
  </div>
    
  <?php if (!$teaser): ?>
    <?php if ($links) { ?><div class="links"><?php print $links?></div><?php }; ?>
  <?php endif; ?>
    
  <?php if ($teaser): ?>
     <?php if ($links) { ?><div class="linksteaser"><div class="links"><?php print $links?></div></div><?php }; ?>
  <?php endif; ?>
    
  <?php if (!$teaser): ?>
     <?php if ($terms) { ?><div class="taxonomy"><span><?php print t('Tags') ?></span> <?php print $terms?></div><?php } ?>
  <?php endif; ?>

</div>
