# Version history

(since v1.4)

### 1.4.2

- include textpacks within plugin; remove remote install facility
- remove unneeded options panel
- TXP 4.6+ only

### 1.4.1

- new: `relative_urls` attribute: link URLs without domain name and http(s) prefix (for demoncleaner)
- fix: uncaught type error in PHP 8.2

### 1.4

- new feature: virtual sections
- new categories features:
  - redirect to Article category option
  - categoried articles in menu
  - new attributes `cat_article_include`, `cat_article_exclude`, `cat_article_sort`, `cat_article_attr`
- new admin feature: drag & drop section ordering
- new classes 'menu_virtual', 'menu_category', 'menu_clone'
- new attribute 'ignore_alt_title' for adi_menu & adi_breadcrumb tags
- new attributes `exclude_clone`, `role` **, `override_exclude` & `suppress_url_sections` for adi_menu tag
- new attribute `labeltag` for adi_breadcrumb
- new attributes `force_current` & `current_descendants_only` (for detail)
- new tags: `adi_menu_info` & `adi_menu_if_info`
- fix: stop clone inheriting an alternative title
- fix: adi_breadcrumb now uses alternative title
- fix: article list defaults to live only (use status="" for both live & sticky) **
- fix: active class applied to menu items that are redirected to active section **
- fix: disallow sections to be selected as parents of, or redirect to, themselves
- fix: disabled submenus on error pages
- fix: breadcrumb less crummy on error pages
- fix: prevent empty HTML class attribute when adi_breadcrumb 'linkclass' is empty (thanks CeBe)
- fix: table prefix issue (thanks sochicomputerRU)
- deprecated attributes: 'clone_title', 'test', 'new_article_mode' **
- deprecated "old article mode" **
- now updates lastmod
- TXP 4.5+ only
- updated for TXP 4.6