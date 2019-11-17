<?php

namespace Substrakt\SEO;

class Archive
{
   /**
    * Sets the global wp_query into $this->wpQuery.
    */
    public function __construct()
    {
        global $wp_query;
        $this->wpQuery = $wp_query;
    }

   /**
    * As archives don't have access yet to the Canonical Tag ACF
    * it is returning an empty string.
    * @return string
    */
    public function canonicalTag(): string
    {
        return '';
    }

   /**
    * Returns the archive pages description as defined on the ACF options page.
    * @return string
    */
    public function description(): string
    {
        // Search.
        if (is_search()) {
            $description = $this->searchDescription();
        }

        // 404.
        elseif (is_404()) {
            $description = $this->errorPageDescription();
        }

        // Taxonomies.
        elseif (is_tax()) {
            $taxonomy = get_query_var('taxonomy');
            $term     = ($this->wpQuery->get_queried_object())->slug ?? $taxonomy;

            ($description = $this->archivesFieldValue('seo_taxonomies_repeater', $term, 'description')) ? $description : '';
        }

        // Post Types.
        elseif (\is_archive() || \is_post_type_archive()) {
            ($postType = get_post_type()) ? $postType : $postType = $this->wpQuery->query['post_type'];
            ($description = $this->archivesFieldValue('seo_post_types_repeater', $postType, 'description')) ? $description : '';
        }

        if (empty($description)) {
            $description = \Substrakt\SEO\defaultDescription();
        }

        $description = \Substrakt\SEO\replaceSiteName($description);

        return sanitise($description);
    }

   /**
    * As archives don't have access yet to the Hide from search engines ACF
    * it is returning false.
    * @return boolean
    */
    public function hideFromSearchEngines(): bool
    {
        return false;
    }

   /**
    * Returns the archive pages image as defined on the ACF options page.
    * @return string
    */
    public function image(): string
    {
        // Search.
        if (is_search()) {
            $image = $this->searchImage();
        }

        // 404.
        elseif (is_404()) {
            $image = $this->errorPageImage();
        }


        // Taxonomies.
        elseif (is_tax()) {
            $taxonomy = get_query_var('taxonomy');
            $term     = ($this->wpQuery->get_queried_object())->slug ?? $taxonomy;

            ($image = $this->archivesFieldValue('seo_taxonomies_repeater', $term, 'image')) ? $image : '';
        }

        // Post Types.
        elseif (\is_archive() || \is_post_type_archive()) {
            ($postType = get_post_type()) ? $postType : $postType = $this->wpQuery->query['post_type'];
            ($image = $this->archivesFieldValue('seo_post_types_repeater', $postType, 'image')) ? $image : '';
        }

        if (empty($image)) {
            $image = \Substrakt\SEO\defaultImage();
        }

        return $image;
    }

   /**
    * Returns the archive pages  title as defined on the ACF options page.
    * @return string
    */
    public function title(): string
    {
        // Search.
        if (is_search()) {
            $title = $this->searchTitle();
        }

        // 404.
        elseif (is_404()) {
            $title = $this->errorPageTitle();
        }

        // Taxonomies.
        elseif (is_tax()) {
            $taxonomy = get_query_var('taxonomy');
            $term     = ($this->wpQuery->get_queried_object())->slug ?? $taxonomy;

            ($title = $this->archivesFieldValue('seo_taxonomies_repeater', $term, 'title')) ? $title : $title = (new \Substrakt\Platypus\Term(get_term_by('slug', $term, $taxonomy)))->name();

            // Add pagination if page is not 1.
            $title = $this->archivesTitlePagination($title);
        }

        // Post Types.
        elseif (\is_archive() || \is_post_type_archive()) {
            ($postType = get_post_type()) ? $postType : $postType = $this->wpQuery->query['post_type'];
            ($title = $this->archivesFieldValue('seo_post_types_repeater', $postType, 'title')) ? $title : $title = \Substrakt\SEO\specialArchiveTitles($postType);

            // Add pagination if page is not 1.
            $title = $this->archivesTitlePagination($title);
        }

        // Incorporates the site title structure to the title.
        $structure = \Substrakt\SEO\titleStructure();
        $title     = str_replace('{post_title}', $title, $structure);
        $title     = \Substrakt\SEO\replaceSiteName($title);

        return $title;
    }

   /**
    * As archives don't have access yet to the Twitter or Facebook ACF
    * it is returning false.
    * @return boolean
    */
    public function twitter(): bool
    {
        return false;
    }

   /**
    * Checks if we the page is on a page that is not the first page
    * and appends the page number to the SEO title.
    * @param string $title
    * @return string
    */
    private function archivesTitlePagination(string $title): string
    {
        $paged = get_query_var('paged');

        if ($paged > 1) {
            $title = "{$title} | Page {$paged}";
        }

        return $title;
    }

   /**
    * Given the repeater name, slug and field kind returns the correspondent
    * field value from the dynamic SEO: Options ACF.
    * @param string $repeaterName
    * @param string $slug post slug | taxonomy slug
    * @param string $field 'title' | 'description' | 'image'
    * @return string
    */
    private function archivesFieldValue(string $repeaterName, string $slug, string $field): string
    {
        $repeater = get_field($repeaterName, 'option');

        if ($repeater) {
            $key = array_search($slug, $repeater);

            if ($fieldValue = $repeater[$key]["seo_{$slug}_archive_{$field}"]) {
                if (is_array($fieldValue)) {
                    $fieldValue = wp_get_attachment_image_src($fieldValue['ID'], 'large');
                    $fieldValue = array_shift($fieldValue);
                }

                return $fieldValue;
            }
        }

        return '';
    }
}
