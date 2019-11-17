<?php $seo = \Substrakt\SEO\seo(); ?>

<!-- Title -->
<?php if ($title = apply_filters('/Substrakt/SEO/Title', $seo->title(), $seo)): ?>
    <title><?php echo $title; ?></title>
<?php endif; ?>

<!-- Description -->
<?php if ($description = apply_filters('/Substrakt/SEO/Description', $seo->description(), $seo)): ?>
    <meta name="description" content="<?php echo $description ?>">
<?php endif; ?>

<!-- Twitter -->
<!-- Twitter: Card Size -->
<?php if ($cardSize = apply_filters('/Substrakt/SEO/Twitter/CardSize', 'summary', $seo)): ?>
    <meta name="twitter:card" content="<?php echo $cardSize; ?>"/>
<?php endif; ?>

<!-- Twitter: Site -->
<?php if ($site = apply_filters('/Substrakt/SEO/Twitter/Site', '', $seo)): ?>
    <meta name="twitter:site" content="<?php echo $site; ?>"/>
<?php endif; ?>

<!-- Twitter: Title -->
<?php if ($title = apply_filters('/Substrakt/SEO/Twitter/Title', $seo->title(), $seo)): ?>
    <meta name="twitter:title" content="<?php echo $title; ?>"/>
<?php endif; ?>

<!-- Twitter: Description -->
<?php if ($description = apply_filters('/Substrakt/SEO/Twitter/Description', $seo->description(), $seo)): ?>
    <meta name="twitter:description" content="<?php echo $description; ?>"/>
<?php endif; ?>

<!-- Twitter: Image -->
<?php if ($image = apply_filters('/Substrakt/SEO/Twitter/Image', $seo->image(), $seo)): ?>
    <meta name="twitter:image" content="<?php echo $image; ?>"/>
<?php endif; ?>

<!-- Facebook-->
<!-- Facebook: URL -->
<?php if ($url = apply_filters('/Substrakt/SEO/Facebook/URL', '', $seo)): ?>
    <meta property="og:url" content="<?php echo $url; ?>">
<?php endif; ?>

<!-- Facebook: Site Name -->
<?php if ($siteName = apply_filters('/Substrakt/SEO/Facebook/SiteName', \Substrakt\SEO\siteName(), $seo)): ?>
    <meta property="og:site_name" content="<?php echo $siteName; ?>"/>
<?php endif; ?>

<!-- Facebook: Title -->
<?php if ($title = apply_filters('/Substrakt/SEO/Facebook/Title', $seo->title(), $seo)): ?>
    <meta property="og:title" content="<?php echo $title; ?>"/>
<?php endif; ?>

<!-- Facebook: Description -->
<?php if ($description = apply_filters('/Substrakt/SEO/Facebook/Description', $seo->description(), $seo)): ?>
    <meta property="og:description" content="<?php echo $description; ?>"/>
<?php endif; ?>

<!-- Facebook: Image -->
<?php if ($image = apply_filters('/Substrakt/SEO/Facebook/Image', $seo->image(), $seo)): ?>
    <meta property="og:image" content="<?php echo $image; ?>"/>
<?php endif; ?>

<!-- Hide From Search Engines -->
<?php if ($seo->hideFromSearchEngines()): ?>
    <meta name="robots" content="noindex,follow">
<?php endif; ?>

<!-- Canonical Tag -->
<?php if ($tag = $seo->canonicalTag()): ?>
    <link rel="canonical" href="<?php echo $tag; ?>">
<?php endif; ?>
